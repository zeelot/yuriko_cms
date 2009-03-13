<?php


class Navigation_Content_Model extends ORM_Tree implements Content_Model{

	protected $children = "navigation_contents";

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
		echo View::factory($this->view)->set('node', $this);
	}

}