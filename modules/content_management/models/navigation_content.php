<?php


class Navigation_Content_Model extends ORM_MPTT implements Content_Model{

	protected $left_column = 'lft';
    protected $right_column = 'rgt';
    protected $parent_column = 'parent_id';
    protected $level_column = 'level';

	public function unique_key($id)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id))
		{
			return 'tag';
		}
		return parent::unique_key($id);
	}

	public function render()
	{
		echo View::factory($this->view)
			->set('node', $this);
	}

}