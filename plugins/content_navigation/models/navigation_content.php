<?php


class Navigation_Content_Model extends ORM_MPTT implements Content_Model{

	protected $left_column = 'lft';
    protected $right_column = 'rgt';
    protected $parent_column = 'parent_id';
	protected $level_column = 'level';


	protected $belongs_to = array('node' => 'content_node');

	protected $ignored_columns = array('parent_id');

	public function validate(array & $array, $save = FALSE)
	{
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('name', 'required', 'length[1,52]', 'chars[a-z A-Z0-9_.]')
			->add_rules('tag', 'required', 'length[1,52]')
			->add_rules('page_id', 'digit')
			->add_rules('anchor', 'chars[a-zA-Z0-9_./:]')
			->add_rules('view', 'required');
		if(!$this->loaded)
		{
			$array
			//the parent needs to exist and the current item does NOT
				->add_rules('parent_id', 'required', 'digit', array($this, 'item_exists'))
				->add_rules('tag', array($this, 'item_available'));
		}

		return parent::validate($array, $save);
	}
	public function save()
	{
		$type = ORM::factory('content_type', 'navigation');

		$node = new Content_Node_Model($this->node_id);
		$node->content_type_id = $type->id;
		$node->content_id = $this->id;
		$node->name = $this->name;
		$node->alias = 'navigation/'.$this->tag;
		$node->save();
		$this->node_id = $node->id;
		return parent::save();
	}
	public function delete()
	{
		$type = ORM::factory('content_type', 'navigation');
		//delete all the nodes that this and its descendants created
		$items = $this->subtree(TRUE)->find_all();
		foreach($items as $item)
		{
			$node = ORM::factory('content_node')
				->where(array
					(
						'content_type_id' => $type->id,
						'content_id' => $item->id,
					))->find();
			if($node->loaded)
			{
				$node->delete();
			}
		}
		parent::delete();
	}

	public function move_up()
	{
		$above = ORM::factory('navigation_content')
			->where(array('level' => $this->level, 'rgt' => $this->lft-1))
			->find();
		if(!$above->loaded) Event::run('mptt.already_top');

		$this->move_to_prev_sibling($above);
	}
	public function move_down()
	{
		$below = ORM::factory('navigation_content')
			->where(array('level' => $this->level, 'lft' => $this->rgt+1))
			->find();
		if(!$below->loaded) Event::run('mptt.already_bottom');

		$this->move_to_next_sibling($below);
	}

	//checks if a content_node is attached to this item
	public function has_node()
	{
		if(!$this->loaded) return FALSE;
		return (bool) $this->db
			->where(array
				(
					'content_id' => $this->id,
					'content_type_id' => ORM::factory('content_type', 'navigation')->id,
				))->count_records('content_nodes');
	}
	public function item_exists($id)
	{
		return (bool) $this->db
			->where($this->unique_key($id), $id)
			->count_records($this->table_name);
	}
	public function item_available($id)
	{
		return !$this->item_exists($id);
	}

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
		echo View::factory('content/navigation/'.$this->view)
			->set('node', $this);
	}

}