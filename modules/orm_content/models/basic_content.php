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

}