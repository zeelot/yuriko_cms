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
			->add_rules('title', 'required', 'length[4,52]', 'chars[a-z A-Z0-9_.]')
			->add_rules('alias', 'required', 'length[4,52]', array($this, 'unique_tag'));
	}
	public function unique_key($id)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id))
		{
			return 'alias';
		}
		return parent::unique_key($id);
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