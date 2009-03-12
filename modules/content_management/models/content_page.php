<?php defined('SYSPATH') OR die('No direct access allowed.');

class Content_Page_Model extends Auto_Modeler_ORM {

	protected $table_name = 'content_pages';

	protected $data = array
	(
		'id'   => '',
		'name' => ''
	);

	protected $aliases = array
	(
		'sections'	=> 'content_pages_sections_nodes',
		'nodes'		=> 'content_pages_sections_nodes',
		'objects'	=> 'content_pages_sections_nodes',
		
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

} // End Content Page Model