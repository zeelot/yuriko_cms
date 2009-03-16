<?php


class Content_Type_Model extends Auto_Modeler{

	protected $table_name = 'content_types';

	protected $data = array
	(
		'id'   => '',
		'name' => ''
	);

	public function __construct($id = NULL)
	{
		parent::__construct();
		if ($id != NULL AND is_string($id))
		{
			// try and get a row with this name
			$data = $this->db->orwhere(array('name' => $id))->get($this->table_name)->result(FALSE);
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

}