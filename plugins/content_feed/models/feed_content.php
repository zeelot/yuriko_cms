<?php


class Feed_Content_Model extends ORM{

	public $items = array();
	
	protected $belongs_to = array('node' => 'content_node');

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
			->add_rules('name', 'required', 'length[1,125]', 'chars[a-zA-Z0-9_.]')
			->add_rules('title', 'required', 'length[1,125]', 'chars[a-zA-Z 0-9_.]')
			->add_rules('url', 'required', 'length[1,255]', 'url');
		if(!$this->loaded)
		{
			$array
				->add_rules('name', array($this, 'name_available'));
		}

		return parent::validate($array, $save);
	}
	public function name_available($id)
	{
		return !(bool) $this->db
			->where($this->unique_key($id), $id)
			->count_records($this->table_name);
	}
	public function save()
	{

		$type = ORM::factory('content_type', 'feed');

		$node = new Content_Node_Model($this->node_id);
		$node->content_type_id = $type->id;
		$node->content_id = $this->id;
		$node->name = $this->name;
		$node->alias = 'feed/'.$this->name;
		$node->save();
		$this->node_id = $node->id;
		parent::save();
		$node->content_id = $this->id;
		return $node->save();
	}
	public function delete()
	{
		$node = ORM::factory('content_node', $this->node_id);
		$node->delete();
		parent::delete();
	}
	//checks if a content_node is attached to this item
	public function has_node()
	{
		if(!$this->loaded) return FALSE;
		return (bool) $this->db
			->where(array
				(
					'content_id' => $this->id,
					'content_type_id' => Auto_Modeler::factory('content_type', 'feed')->id,
				))->count_records('content_nodes');
	}

}