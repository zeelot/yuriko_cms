<?php
/**
* Auto_Modeler
*
* @package        Auto_Modeler
* @author         Jeremy Bush
* @copyright      (c) 2008 Jeremy Bush
* @license        http://www.opensource.org/licenses/isc-license.txt
*/
class Auto_Modeler extends Model implements ArrayAccess
{
	// The database table name
	protected $table_name = '';

	// The database fields
	protected $data = array();

	// Validation rules in a 'field' => 'rules' array
	protected $rules = array();
	protected $callbacks = array();

	protected $aliases = array();

	protected $validated = FALSE;

	public function __construct($id = NULL)
	{
		parent::__construct();

		if ($id != NULL)
		{
			// try and get a row with this ID
			$data = $this->db->getwhere($this->table_name, array('id' => $id))->result(FALSE);

			// try and assign the data
			if (count($data) == 1 AND $data = $data->current())
			{
				foreach ($data as $key => $value)
					$this->data[$key] = $value;
			}
		}
	}

	// Magic __get() method
	public function __get($key)
	{
		if (isset($this->aliases[$key]))
			$key = $this->aliases[$key];

		return isset($this->data[$key]) ? $this->data[$key] : NULL;
	}

	// Magic __set() method
	public function __set($key, $value)
	{
		if (isset($this->aliases[$key]))
			$key = $this->aliases[$key];

		if (array_key_exists($key, $this->data))
			$this->data[$key] = $value;
	}

	public function as_array()
	{
		return $this->data;
	}

	// Useful for one line method chaining
	// $model - The model name to make
	// $id - an id to create the model with
	public static function factory($model = FALSE, $id = FALSE)
	{
		$model = empty($model) ? __CLASS__ : ucfirst($model).'_Model';
		return new $model($id);
	}

	// Allows for setting data fields in bulk
	// $data - associative array to set $this->data to
	public function set_fields($data)
	{
		foreach ($data as $key => $value)
		{
			if (isset($this->aliases[$key]))
				$key = $this->aliases[$key];

			if (array_key_exists($this->data[$key]))
				$this->data[$key] = $value;
		}
	}

	public function valid($extra_data = array(), $extra_methods = array())
	{
		$data = Validation::factory(array_merge($extra_data, $this->data))->pre_filter('trim');

		foreach ($this->rules as $field => $rule)
		{
			foreach ($rule as $sub_rule)
				$data->add_rules($field, $sub_rule);
		}

		foreach ($this->callbacks as $field => $callback)
			$data->add_callbacks($field, array($this, $callback));

		// Process any custom user defined rules. Non-model field validation would go here.
		foreach ($extra_methods as $validation_function)
			$this->$validation_function($data);

		if ($data->validate())
			return $this->validated = TRUE;
		else
		{
			$errors = View::factory('form_errors')->set(array('errors' => $data->errors('form_errors')));
			return $errors->render();
		}
	}

	// Saves the current object
	public function save()
	{
		$status = $this->validated ? TRUE : $this->valid();

		if ($status === TRUE)
		{
			if ($this->data['id']) // Do an update
				return count($this->db->update($this->table_name, $this->data, array('id' => $this->data['id'])));
			else // Do an insert
			{
				$id = $this->db->insert($this->table_name, $this->data)->insert_id();
				return ($this->data['id'] = $id);
			}
		}

		throw new Kohana_User_Exception('auto_modeler.validation_error', $status);
	}

	// Deletes the current record and destroys the object
	public function delete()
	{
		if ($this->data['id'])
		{
			return $this->db->delete($this->table_name, array('id' => $this->data['id']));
		}
	}

	// Fetches all rows in the table
	// $order_by - the ORDER BY value to sort by
	// $direction - the direction to sort
	public function fetch_all($order_by = 'id', $direction = 'ASC')
	{
		return $this->db->orderby($order_by, $direction)->get($this->table_name)->result(TRUE, inflector::singular(ucwords($this->table_name)).'_Model');
	}

	// Does a basic search on the table.
	// $where - the where clause to search on
	// $order_by - the ORDER BY value to sort by
	// $direction - the direction to sort
	// $type - pass 'or' here to do a orwhere
	public function fetch_where($where = array(), $order_by = 'id', $direction = 'ASC', $type = '')
	{
		$function = $type.'where';
		return $this->db->$function($where)->orderby($order_by, $direction)->get($this->table_name)->result(TRUE, inflector::singular(ucwords($this->table_name)).'_Model');
	}

	// Returns an associative array to use in dropdowns and other widgets
	// $key - the key column of the array
	// $display - the value column of the array
	// $order_by - the direction to sort
	// $where - an optional where array to be passed if you don't want every record
	public function select_list($key, $display, $order_by = 'id', $where = array())
	{
		$rows = array();

		$query = empty($where) ? $this->fetch_all($order_by) : $this->db->where($where)->orderby($order_by)->get($this->table_name)->result(TRUE, inflector::singular(ucwords($this->table_name)).'_Model');

		$array_display = is_array($display);

		foreach ($query as $row)
		{
			if ($array_display)
			{
				$display_str = array();
				foreach ($display as $text)
					$display_str[] = $row->$text;
				$rows[$row->$key] = implode(' - ', $display_str);
			}
			else
				$rows[$row->$key] = $row->$display;
		}

		return $rows;
	}

	public function has_attribute($key)
	{
		if (isset($this->aliases[$key]))
			$key = $this->aliases[$key];
			//die(kohana::debug($key));
		return array_key_exists($key, $this->data);
	}

	// Array Access Interface
	public function offsetExists($key)
	{
		if (isset($this->aliases[$key]))
			$key = $this->aliases[$key];

		return array_key_exists($key, $this->data);
	}

	public function offsetSet($key, $value)
	{
		$this->__set($key, $value);
	}

	public function offsetGet($key)
	{
		return $this->__get($key);
	}

	public function offsetUnset($key)
	{
		if (isset($this->aliases[$key]))
			$key = $this->aliases[$key];

		$this->data[$key] = NULL;
	}
}