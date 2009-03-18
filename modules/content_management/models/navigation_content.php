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
			->add_rules('name', 'required', 'length[4,52]', 'chars[a-z A-Z0-9_.]')
			->add_rules('tag', 'required', 'length[4,52]', array($this, 'unique_tag'))
			->add_rules('parent_id', 'required', 'digit', array($this, 'valid_node'));

		return parent::validate($array, $save);
	}
	public function update(array & $array)
	{
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('name', 'required', 'length[4,52]', 'chars[a-z A-Z0-9_.]')
			->add_rules('tag', 'required', 'length[4,52]')
			->add_rules('page_id', 'digit')
			->add_rules('anchor', 'chars[a-zA-Z0-9_./]');

		return parent::validate($array, TRUE);
	}

	public function unique_tag($id)
	{
		return !(bool) $this->db
			->where($this->unique_key($id), $id)
			->count_records($this->table_name);
	}
	public function valid_node($id)
	{
		return (bool) $this->db
			->where($this->unique_key($id), $id)
			->count_records($this->table_name);
	}

	public function unique_key($id)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id))
		{
			return 'tag';
		}
		return parent::unique_key($id);
	}
	
	
	public function delete($descendants = TRUE)
	{
		$type = Auto_Modeler::factory('content_type', 'navigation');
		//delete all the nodes that this and its descendants are in
		if($descendants)
		{
			$items = $this->subtree(TRUE)->find_all();
			foreach($items as $item)
			{
				$node = Auto_Modeler::factory('content_node')
					->fetch_where(array
						(
							'content_type_id' => $type->id,
							'content_id' => $item->id,
						));
				if((bool)count($node))
				{
					$node->current()->delete();
				}
			}
		}
		else
		{

		}
		parent::delete($descendants);
	}

	public function render()
	{
		echo View::factory($this->view)
			->set('node', $this);
	}

}