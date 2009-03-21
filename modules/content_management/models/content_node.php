<?php defined('SYSPATH') OR die('No direct access allowed.');

class Content_Node_Model extends Auto_Modeler_ORM {

	protected $table_name = 'content_nodes';

	protected $data = array
	(
		'id'   => '',
		'name' => '',
		'content_type_id' => '',
		'content_id' => '',
		'alias' => '',
		'template' => '',
	);

	protected $rules = array
	(
		'alias' => array('required'),
		'name' => array('required'),
		'content_id' => array('required', 'digit'),
		'content_type_id' => array('required', 'digit'),
	);

	protected $aliases = array
	(
		'page'    => 'content_pages_sections_nodes',
		'section' => 'content_pages_sections_nodes',
		'nodes'   => 'content_pages_sections_nodes',
		'objects' => 'content_pages_sections_nodes',
	);

	protected $has_many = array
	(
		'content_pages_sections_nodes',
	);

	public function __construct($id = NULL)
	{
		parent::__construct();
		if ($id != NULL AND is_string($id))
		{
			// try and get a row with this name
			$data = $this->db->orwhere(array('alias' => $id))->get($this->table_name)->result(FALSE);
			// try and assign the data
			if (count($data) == 1 AND $data = $data->current())
			{
				foreach ($data as $key => $value)
				$this->data[$key] = $value;
			}
		}
		elseif ($id != NULL AND (ctype_digit($id) OR is_int($id)))
		{
			// try and get a row with this id
			$data = $this->db->getwhere($this->table_name, array('id' => $id))->result(FALSE);
			// try and assign the data
			if (count($data) == 1 AND $data = $data->current())
			{
				foreach ($data as $key => $value)
				$this->data[$key] = $value;
			}
		}
	}

	public function find_content()
	{
		//return the model of the content related to this node
		return Auto_Modeler::factory($this->content_type->name.'_content', $this->content_id);
	}


} // End Content Node Model