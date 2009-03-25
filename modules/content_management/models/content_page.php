<?php defined('SYSPATH') OR die('No direct access allowed.');

class Content_Page_Model extends ORM {

	protected $has_many = array
	(
		'content_pages_sections_nodes',
		'content_nodes' => 'content_pages_sections_nodes',
		'content_sections' => 'content_pages_sections_nodes',
	);

	public function validate(array & $array, $save = FALSE)
	{
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('name', 'required', 'length[1,127]', 'chars[a-zA-Z0-9_./]')
			->add_rules('alias', 'required', 'length[1,127]', 'chars[a-zA-Z0-9_./]');
		//if this is a new page the name and alias should be unique
		if(!$this->loaded)
		{
			$array->add_rules('name', array($this, 'unique_name'))
			->add_rules('alias', array($this, 'unique_alias'));
		}
		return parent::validate($array, $save);
	}
	public function unique_key($id)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id))
		{
			return 'alias';
		}
		return parent::unique_key($id);
	}
	public function unique_alias($id)
	{
		return !(bool) $this->db
			->where('alias', $id)
			->count_records($this->table_name);
	}
	public function unique_name($id)
	{
		return !(bool) $this->db
			->where('name', $id)
			->count_records($this->table_name);
	}

	public function render_children()
	{
		$objects = $this->content_pages_sections_nodes;
		if(count($objects) == 0) return FALSE; //page has no content yet
		$sections = array();
		$current_section = NULL;
		$section = NULL;
		
		foreach($objects as $obj)
		{
			if ($current_section != $obj->content_section_id)
			{
				$section = $obj->content_section;
				$current_section = $section->id;
			}
			
			$sections[$section->name]['object'] = $section;
			$sections[$section->name]['nodes'][] = $obj->content_node;
		}
		$output = NULL;
		foreach($sections as $name => $section)
		{
			$output .= View::factory($section['object']->template)
							->set('nodes', $section['nodes'])
							->set('section', $section['object'])->render();
		}
		return $output;
	}

} // End Content Page Model