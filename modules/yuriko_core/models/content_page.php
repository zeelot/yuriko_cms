<?php defined('SYSPATH') OR die('No direct access allowed.');

class Content_Page_Model extends ORM {

	protected $has_many = array
	(
		'content_pivots',
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

	public function get_sections()
	{
		$sections = Kohana::config('theme.sections');
		$data = array();
		foreach ($sections as $key => $name)
		{
			$pivots = ORM::factory('content_pivot')
				->where(array('content_page_id' => $this->id, 'section' => $key))
				->find_all();
			foreach($pivots as $pivot)
			{
				$data[$key][] = $pivot->content_node;
			}
			if (!isset($data[$key])) $data[$key] = array();
		}
		return $data;
	}

} // End Content Page Model