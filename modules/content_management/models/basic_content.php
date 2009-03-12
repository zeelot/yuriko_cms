<?php


class Basic_Content_Model extends ORM{

	protected $belongs_to = array('format' => 'content_format');

	public function unique_key($id)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id))
		{
			return 'name';
		}
		return parent::unique_key($id);
	}

	public function validate(array & $array, $save = FALSE)
	{
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('name', 'required', 'length[4,32]', 'chars[a-zA-Z0-9_.]')
			->add_rules('format_id', 'required', 'valid::digit')
			->add_rules('content', 'required');

		return parent::validate($array, $save);
	}
	public function save()
	{
		if($this->format->name == 'markdown')
		{
			require Kohana::find_file('vendor', 'Markdown');
			$this->html = Markdown($this->content);
		}else if($this->format->name == 'html')
		{
			$this->html = $this->content;
		}
		return parent::save();
	}

}