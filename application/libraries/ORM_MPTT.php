<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Modified Preorder Tree Traversal Class.
 *
 * @package libraries
 * @author Mathew Davies, Kiall Mac Innes
 **/
class ORM_MPTT_Core extends ORM
{
	/**
	 * Left Column
	 *
	 * @var string
	 **/
	protected $left_column = 'lft';
	
	/**
	 * Right Column
	 *
	 * @var string
	 **/
	protected $right_column = 'rgt';
	
	/**
	 * Level Field Value
	 * 
	 * @var int
	 **/
	protected $_level = FALSE;
	
	/**
	 * Constructor
	 *
	 * @access public
	 * @return void
	 * @author Mathew Davies
	 **/
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}

	/**
	 * Locks the MPTT table.
	 *
	 * @access private
	 * @return void
	 * @author Kiall Mac Innes
	 **/
	private function lock()
	{
		$this->db->query('LOCK TABLE '.$this->table_name.' WRITE');
	}
	
	/**
	 * Unlocks the MPTT table.
	 *
	 * @access private
	 * @return void
	 * @author Kiall Mac Innes
	 **/
	private function unlock()
	{
		$this->db->query('UNLOCK TABLES');
	}

	/**
	 * Does the node have a child?
	 *
	 * $node = ORM::factory('table', 12)->has_children();
	 *
	 * if ($node)
	 * {
	 *	 print 'This node has a child.';	  
	 * }
	 *
	 * @access public
	 * @return boolean
	 * @author Mathew Davies
	 **/
	public function has_children()
	{
		// If the gap between the left and right values is more than 1
		// then we know the node has children.
		return (($this->{$this->right_column} - $this->{$this->left_column}) > 1);
	}
	
	/**
	 * Is the current node a leaf node
	 * (Has no children)
	 *
	 * $node = ORM::factory('table', 12)->is_leaf();
	 *
	 * if ($node)
	 * {
	 *	 print 'This node is a leaf node.';	  
	 * }
	 *
	 * @access public
	 * @return boolean
	 * @author Kiall Mac Innes
	 **/
	public function is_leaf()
	{
		return !$this->has_children();
	}
	
	/**
	 * Is the current node a descendant of the supplied node
	 *
	 * @access public
	 * @param $target node Target Node
	 * @return boolean
	 * @author Gallery3
	 **/
	public function is_descendant($target)
	{
		return ($this->{$this->left_column} > $target->{$this->left_column} AND $this->{$this->right_column} < $target->{$this->right_column});
	}
	
	/**
	 * Is the current node a root node?
	 *
	 * $is_root = ORM::factory('table', 12)->is_root();
	 *
	 * if ($node)
	 * {
	 *	 print 'This node is a root node.';	  
	 * }
	 *
	 * @access public
	 * @return boolean
	 * @author Kiall Mac Innes
	 **/
	public function is_root()
	{
		return ($this->{$this->left_column} === 1);
	}
	
	/**
	 * Returns the level for the current node.
	 * 
	 * $level = $this->level();
	 * 
	 * @access protected
	 * @return int
	 **/
	protected function level()
	{
		// SELECT COUNT(*) as level FROM `admin_menus` WHERE `left` < 2 AND `right` > 5
		if (!$this->_level) 
		{
			$this->_level = (int) $this->db->query('SELECT COUNT(*) AS level FROM `'.$this->table_name.'` WHERE `'.$this->left_column.'` < '.$this->{$this->left_column}.' AND `'.$this->right_column.'` > '.$this->{$this->right_column})->current()->level;
		}
		
		return $this->_level;
	}
	
	/**
	 * Returns the root node
	 *
	 * $root = $this->root();
	 *
	 * @access protected
	 * @return object
	 * @author Mathew Davies
	 **/
	protected function root()
	{
		return self::factory($this->object_name)->where($this->left_column, 1)->find();
	}
	
	/**
	 * Returns the parent node
	 *
	 * $node = $this->parent();
	 *
	 * @access protected
	 * @return object
	 * @author Mathew Davies
	 **/
	protected function parent()
	{
		// Root node, can't possibly have a parent
		if ($this->{$this->left_column} === 1)
			return FALSE;
		
		// SELECT * FROM `table` WHERE `left` < 9 AND `right` > 10 ORDER BY `right` ASC LIMIT 1
		return self::factory($this->object_name)->where('`'.$this->left_column.'` < '.$this->{$this->left_column}.' AND `'.$this->right_column.'` > '.$this->{$this->right_column})->orderby($this->right_column, 'ASC')->find();
	}
	
	/**
	 * Returns the parents of this node
	 *
	 * $parents = $this->parents();
	 *
	 * @access protected
	 * @param $root Include the root node or not
	 * @return ORM_Iterator
	 **/
	protected function parents($root = TRUE)
	{
		// Root node, can't possibly have a parent
		if ($this->{$this->left_column} === 1)
			return FALSE;
		
		// SELECT * FROM `table` WHERE `lft` <= 9 AND `rgt` >= 10 AND id <> 6 ORDER BY `lft` ASC
		$result = self::factory($this->object_name)->where('`'.$this->left_column.'` <= '.$this->{$this->left_column}.' AND `'.$this->right_column.'` >= '.$this->{$this->right_column})->orderby($this->left_column, 'ASC');
		
		if ( ! $root)
			$result->where('`'.$this->left_column.'` != 1');
			
		return $result->find_all();
	}
	
	/**
	 * Returns a list of leaf nodes.
	 *
	 * $leaf_nodes = ORM::factory('table', 1)->leaves;
	 *
	 * @access public
	 * @return object
	 * @author Mathew Davies
	 **/
	protected function leaves()
	{
		$result = self::factory($this->object_name)->where('`'.$this->left_column.'` = (`'.$this->right_column.'` - 1)	AND `'.$this->left_column.'` >= '.$this->{$this->left_column}.' AND `'.$this->right_column.'` <= '.$this->{$this->right_column})->orderby($this->left_column, 'ASC');
		
		return $result->find_all();
	}
	
	/**
	 * Get Size
	 *
	 * Returns the current size of the node.
	 *
	 * @return void
	 * @author Mathew Davies, Kiall Mac Innes
	 **/
	protected function get_size()
	{
		return ($this->{$this->right_column} - $this->{$this->left_column}) + 1;
	}

	/**
	 * Create a gap in the tree to make room for a new node
	 *
	 * @access private
	 * @param $start integer Start position.
	 * @param $size integer The size of the gap (default is 2)
	 * @return void
	 * @author Kiall Mac Innes
	 **/
	private function create_space($start, $size = 2)
	{
		// Update the left values.
		$this->db->query('UPDATE '.$this->table_name.' SET `'.$this->left_column.'` = `'.$this->left_column.'` + '.$size.' WHERE `'.$this->left_column.'` >= '.$start);

		// Now the right.
		$this->db->query('UPDATE '.$this->table_name.' SET `'.$this->right_column.'` = `'.$this->right_column.'` + '.$size.' WHERE `'.$this->right_column.'` >= '.$start);
	}
	
	/**
	 * Closes a gap in a tree. Mainly used after a node has
	 * been removed.
	 *
	 * @access private
	 * @param $start integer Start position.
	 * @param $size integer The size of the gap (default is 2)
	 * @return void
	 * @author Kiall Mac Innes
	 **/
	private function delete_space($start, $size = 2)
	{
		// Update the left values.
		$this->db->query('UPDATE '.$this->table_name.' SET `'.$this->left_column.'` = `'.$this->left_column.'` - '.$size.' WHERE `'.$this->left_column.'` >= '.$start);
		
		// Now the right.
		$this->db->query('UPDATE '.$this->table_name.' SET `'.$this->right_column.'` = `'.$this->right_column.'` - '.$size.' WHERE `'.$this->right_column.'` >= '.$start);
	}
	
	/**
	 * Inserts a new node to the left of the first node.
	 *
	 * $parent = 12;
	 *
	 * $new = ORM::factory('table');
	 * $new->name = 'New Node';
	 * $new->insert_as_first_child($parent);
	 *
	 * @access public
	 * @param $target object | integer Node object or ID.
	 * @return void
	 * @author Mathew
	 **/
	public function insert_as_first_child($target)
	{
		// Insert should only work on new nodes.. if its already it the tree it needs to be moved!
		if ($this->loaded)
			return FALSE;
		
		// Lock the table.
		$this->lock();
		
		// If $target isn't an object we find the node with the ID
		if (!is_a($target, get_class($this)))
		{
			$target = self::factory($this->object_name, $target);
		}
		else
		{
			// Ensure we're using the latest version of $target
			$target->reload();
		}
		
		// Example : left = 1, right = 32

		// Values for the new node
		// Example : left = 2, right = 3
		$this->{$this->left_column}  = $target->{$this->left_column} + 1;
		$this->{$this->right_column} = $this->{$this->left_column} + 1;
		
		// Create some space for the new node.
		$this->create_space($this->{$this->left_column});
		
		// Save the new node.
		parent::save();
		
		// Unlock the table.
		$this->unlock();
		
		return $this;
	}
	
	/**
	 * Inserts a new node to the right of the last node.
	 *
	 * $parent = 12;
	 *
	 * $new = ORM::factory('table');
	 * $new->name = 'New Node';
	 * $new->insert_as_last_child($parent);
	 *
	 * @access public
	 * @param $target object | integer Node object or ID.
	 * @return void
	 * @author Mathew Davies
	 **/
	public function insert_as_last_child($target)
	{
		// Insert should only work on new nodes.. if its already it the tree it needs to be moved!
		if ($this->loaded)
			return FALSE;
			
		// Lock the table.
		$this->lock();
		
		// If $target isn't an object we find the node with the ID
		if (!is_a($target, get_class($this)))
		{
			$target = self::factory($this->object_name, $target);
		}
		else
		{
			// Ensure we're using the latest version of $target
			$target->reload();
		}
		
		// Example : left = 1, right = 32

		// Values for the new node
		// Example : left = 32, right = 33
		$this->{$this->left_column}  = $target->{$this->right_column};
		$this->{$this->right_column} = $this->{$this->left_column} + 1;
		
		// Create some space for the new node.
		$this->create_space($this->{$this->left_column});
		
		// Save the new node.
		parent::save();
		
		// Unlock the table.
		$this->unlock();
		
		return $this;
	}

	/**
	 * Inserts a new node as a previous sibling
	 *
	 * $target = 12;
	 *
	 * $new = ORM::factory('table');
	 * $new->name = 'New Node';
	 * $new->insert_as_prev_sibling($target);
	 *
	 * @access public
	 * @param $target object | integer Node object or ID.
	 * @return void
	 **/
	public function insert_as_prev_sibling($target)
	{
		// Insert should only work on new nodes.. if its already it the tree it needs to be moved!
		if ($this->loaded)
			return FALSE;
		
		// Lock the table.
		$this->lock();
		
		// If $target isn't an object we find the node with the ID
		if (!is_a($target, get_class($this)))
		{
			$target = self::factory($this->object_name, $target);
		}
		else
		{
			// Ensure we're using the latest version of $target
			$target->reload();
		}

		$this->{$this->left_column}  = $target->{$this->left_column};
		$this->{$this->right_column} = $this->{$this->left_column} + 1;
		
		// Create some space for the new node.
		$this->create_space($this->{$this->left_column});
		
		// Save the new node.
		parent::save();
		
		// Unlock the table.
		$this->unlock();
		
		return $this;
	}

	/**
	 * Inserts a new node as a next sibling
	 *
	 * $target = 12;
	 *
	 * $new = ORM::factory('table');
	 * $new->name = 'New Node';
	 * $new->insert_as_next_sibling($target);
	 *
	 * @access public
	 * @param $target object | integer Node object or ID.
	 * @return void
	 **/
	public function insert_as_next_sibling($target)
	{
		// Insert should only work on new nodes.. if its already it the tree it needs to be moved!
		if ($this->loaded)
			return FALSE;
		
		// Lock the table.
		$this->lock();
		
		// If $target isn't an object we find the node with the ID
		if (!is_a($target, get_class($this)))
		{
			$target = self::factory($this->object_name, $target);
		}
		else
		{
			// Ensure we're using the latest version of $target
			$target->reload();
		}

		$this->{$this->left_column}  = $target->{$this->right_column} + 1;
		$this->{$this->right_column} = $this->{$this->left_column} + 1;
		
		// Create some space for the new node.
		$this->create_space($this->{$this->left_column});
		
		// Save the new node.
		parent::save();
		
		// Unlock the table.
		$this->unlock();
		
		return $this;
	}
	
	/**
	 * Overloaded save method
	 *
	 * @return void
	 * @author Mathew Davies
	 **/
	public function save()
	{
		if ($this->loaded === TRUE)
		{
			return parent::save();
		}
		
		return FALSE;
	}
	
	/**
	 * Removes a node and descendants if specified.
	 *
	 * $
	 *
	 * @access public
	 * @param $descendants boolean Remove the descendants?
	 * @return void
	 * @author Mathew Davies, Kiall Mac Innes
	 **/
	public function delete($descendants = TRUE)
	{
		// Lock the table
		$this->lock();
		
		// The descendants need to be removed.
		if ($descendants)
		{
			// Delete the node and it's descendants.
			$this->db->delete($this->table_name, '`'.$this->left_column.'` BETWEEN '.$this->{$this->left_column}.' AND '.$this->{$this->right_column});

			// Close the gap
			$this->delete_space($this->{$this->left_column}, $this->get_size());
		}
		// The descendants need to be moved up a level.
		else
		{
			throw new Exception('Not Implemented');
		}

		// Unlock the table.
		$this->unlock();
	}

	/**
	 * Overloads the select_list method to
	 * support indenting.
	 *
	 * @param $key string First table column
	 * @param $val string Second table column
	 * @param $indent string Use this character for indenting
	 * @return void
	 * @author Mathew
	 **/
	public function select_list($key = NULL, $val = NULL, $indent = FALSE)
	{
		if (is_string($indent))
		{
			$result = $this->load_result(TRUE);
			
			$array = array();
			
			foreach ($result as $row)
			{
				$array[$row->$key] = str_repeat($indent, $row->level).$row->$val;
			}
			
			return $array;
		}

		return parent::select_list($key, $val);
	}
	
	/**
	 * Returns the subtree of the currently loaded
	 * node
	 *
	 * $root = ORM::factory('table')->root()->find();
	 *
	 * $descendants = ORM::factory('table', $root->id)->subtree()->find_all();
	 *
	 * @access public
	 * @param $root boolean Should it include the root node?
	 * @return object
	 * @author Mathew Davies
	 **/
	public function subtree($root = FALSE)
	{		
		if ($root === TRUE)
			return self::factory($this->object_name)->where('`'.$this->left_column.'` >= '.$this->{$this->left_column}.' AND `'.$this->right_column.'` <= '.$this->{$this->right_column})->orderby($this->left_column, 'ASC');
			
		return self::factory($this->object_name)->where('`'.$this->left_column.'` > '.$this->{$this->left_column}.' AND `'.$this->right_column.'` < '.$this->{$this->right_column})->orderby($this->left_column, 'ASC');
	}
	
	/**
	 * Move to First Child
	 *
	 * This moves the current node to the first child of the target node.
	 *
	 * @param $target object | integer Target Node
	 * @return void
	 * @author Mathew Davies, Kiall Mac Innes
	 **/
	public function move_to_first_child($target)
	{
		// Lock the table
		$this->lock();	
		
		// Move should only work on nodes that are already in the tree.. if its not already it the tree it needs to be inserted!
		if (!$this->loaded)
			return FALSE;

		// Make sure we have the most uptodate version of this AFTER we lock
		$this->reload(); // This should *probably* go into $this->lock();
		
		// Find the target node properties.
		if (!is_a($target, get_class($this)))
		{
			$target = self::factory($this->table_name, $target);
		}
		
		// New Left Value.
		$new_left = $target->{$this->left_column} + 1;
		
		// Move
		$this->move($new_left);
		
		// Unlock the table.
		$this->unlock();

		return $this;
	}
	
	/**
	 * Move to Last Child
	 *
	 * This moves the current node to the last child of the target node.
	 *
	 * @param $target object | integer Target Node
	 * @return void
	 * @author Mathew Davies, Kiall Mac Innes
	 **/
	public function move_to_last_child($target)
	{
		// Lock the table
		$this->lock();
		
		// Move should only work on nodes that are already in the tree.. if its not already it the tree it needs to be inserted!
		if (!$this->loaded)
			return FALSE;
			
		// Make sure we have the most uptodate version of this AFTER we lock
		$this->reload(); // This should *probably* go into $this->lock();
		
		// Find the target node properties.
		if (!is_a($target, get_class($this)))
		{
			$target = self::factory($this->table_name, $target);
		}
		
		// New Left Value.
		$new_left = $target->{$this->right_column};
		
		// Move
		$this->move($new_left);
		
		// Unlock the table.
		$this->unlock();
		
		return $this;
	}
	
	/**
	 * Move to Previous Sibling.
	 *
	 * This moves the current node to the previous sibling of the target node.
	 *
	 * @param $target object | integer Target Node
	 * @return void
	 * @author Mathew Davies, Kiall Mac Innes
	 **/
	public function move_to_prev_sibling($target)
	{
		// Move should only work on nodes that are already in the tree.. if its not already it the tree it needs to be inserted!
		if (!$this->loaded)
			return FALSE;
		
		// Lock the table
		$this->lock();
		
		// Make sure we have the most upto date version of this AFTER we lock
		$this->reload(); // This should *probably* go into $this->lock();
		
		// Find the target node properties.
		if (!is_a($target, get_class($this)))
		{
			$target = self::factory($this->table_name, $target);
		}
		
		// New Left Value.
		$new_left = $target->{$this->left_column};
		
		// Move
		$this->move($new_left);
		
		// Unlock the table.
		$this->unlock();
		
		return $this;
	}
	
	/**
	 * Move to Next Sibling.
	 *
	 * This moves the current node to the next sibling of the target node.
	 *
	 * @param $target object | integer Target Node
	 * @return void
	 * @author Mathew Davies, Kiall Mac Innes
	 **/
	public function move_to_next_sibling($target)
	{
		// Move should only work on nodes that are already in the tree.. if its not already it the tree it needs to be inserted!
		if (!$this->loaded)
			return FALSE;
		
		// Lock the table
		$this->lock();
		
		// Make sure we have the most upto date version of this AFTER we lock
		$this->reload(); // This should *probably* go into $this->lock();
		
		// Find the target node properties.
		if (!is_a($target, get_class($this)))
		{
			$target = self::factory($this->table_name, $target);
		}
		
		// New Left Value.
		$new_left = $target->{$this->right_column} + 1;
		
		// Move
		$this->move($new_left);
		
		// Unlock the table.
		$this->unlock();
		
		return $this;
	}
	
	/**
	 * Move
	 *
	 * @param $new_left integer The value for the new left.
	 * @return void
	 * @author Mathew Davies, Kiall Mac Innes
	 **/
	protected function move($new_left)
	{
		// Lock the table
		$this->lock();		
		
		// Size of current node.
		// For example left = 5, right = 6
		// (right - left) + 1
		// Result = 2
		$size = $this->get_size();
		
		// New right value
		$new_right = ($new_left + $size) - 1;

		// Now we create the new gap
		$this->create_space($new_left, $size);

		$this->reload();
		
		// This is how much we move our current node by.
		// This needs checking.
		$offset = ($new_left - $this->{$this->left_column});
		
		// Update the values.
		// UPDATE `$this->table_name` SET `left` = `left` + $offset, `right` = `right` + $offset WHERE `left` >= $this->{$this->left_column} AND `right` <= $this->{$this->right_column}
		$this->db->query('UPDATE '.$this->table_name.' SET `'.$this->left_column.'` = `'.$this->left_column.'` + '.$offset.', `'.$this->right_column.'` = `'.$this->right_column.'` + '.$offset.' WHERE  `'.$this->left_column.'` >= '.$this->{$this->left_column}.' AND `'.$this->right_column.'` <= '.$this->{$this->right_column});
		
		// Now we close the old gap
		$this->delete_space($this->{$this->left_column}, $size);
		
		// Unlock the table.
		$this->unlock();
	}
	
	/**
	 *
	 * @access public
	 * @param $column - Which field to get.
	 * @return mixed
	 **/
	public function __get($column)
	{
		switch ($column)
		{
			case 'level':
				return $this->level();
			case 'parent':
				return $this->parent();
			case 'parents':
				return $this->parents();
			case 'root':
				return $this->root();
			case 'leaves':
				return $this->leaves();
			default:
				return parent::__get($column);
		}
	}
	
	/**
	 * Clear out our data during a reload.
	 * 
	 * @access public
	 * @return mixed
	 **/
	public function reload()
	{
		$this->_level = FALSE;
		return parent::reload();
	}
	
	/**
	 * Verify the tree is in good order 
	 * 
	 * @access public
	 * @return boolean
	 **/
	public function verify_tree()
	{
		if (!$this->is_root())
			throw new Exception('verify_tree() can only be used on root nodes');
		
		$end = $this->{$this->right_column};

		$i = 0;
		
		while ($i < $end)
		{
			$i++;
			$nodes = self::factory($this->object_name)->where('lft', $i)->orwhere('rgt', $i)->find_all();
			if (count($nodes) != 1)
				return FALSE;
		}
		
		return TRUE;
	}
	
} // END class ORM_MPTT_Core