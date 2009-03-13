<?php defined('SYSPATH') OR die('No direct access allowed.');

class Content_Page_Model extends Auto_Modeler_ORM {

	protected $table_name = 'content_pages';

	protected $data = array
	(
		'id'   => '',
		'alias' => '',
		'name' => '',
	);

	protected $aliases = array
	(
		'sections'	=> 'content_pages_sections_nodes',
		'nodes'		=> 'content_pages_sections_nodes',
		'objects'	=> 'content_pages_sections_nodes',
		'content_pages' => 'pages',
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

	public function render_children()
	{
		$objects = $this->find_related('objects');
		$sections = array();
		$current_section = NULL;
		$section = NULL;
		
		foreach($objects as $obj)
		{
			if ($current_section != $obj->section_id)
			{
				$section = $obj->section;
				$current_section = $section->id;
			}
			$sections[$section->name]['object'] = $section;
			$sections[$section->name]['nodes'][] = $obj->node;
		}
		foreach($sections as $name => $section)
		{
			echo View::factory($section['object']->template)->set('nodes', $section['nodes'])->set('section', $section['object']);
		}
	}

} // End Content Page Model