<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Modified Pre Order Tree Traversal Class.
 *
 * @package libraries
 * @author Mathew Davies, Kiall Mac Innes
 **/
class ORM_MPTT extends ORM
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
     * Parent Column
     *
     * @var string
     **/
    protected $parent_column = 'parent';
    
    /**
     * Level Column
     *
     * TODO : Remove this table column and do this via SQL
     *
     * @var string
     **/
    protected $level_column = 'level';

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
     * $node = ORM::factory('table', 12)->has_child();
     *
     * if ($node)
     * {
     *     print 'This node has a child.';      
     * }
     *
     * @access public
     * @return boolean
     * @author Mathew Davies
     **/
    public function has_child()
    {
        // If the gap between the left and right values is more than 1
        // then we know the node has children.
        return (($this->{$this->right_column} - $this->{$this->left_column}) > 1) ? TRUE : FALSE;
    }
    
    /**
     * Is the current node a leaf node
     * (Has no children)
     *
     * $node = ORM::factory('table', 12)->is_leaf();
     *
     * if ($node)
     * {
     *     print 'This node is a leaf node.';      
     * }
     *
     * @access public
     * @return boolean
     * @author Kiall Mac Innes
     **/
    public function is_leaf()
    {
        return !$this->has_child();
    }
    
    /**
     * Is the current node a root node?
     *
     *
     * $node = ORM::factory('table', 12)->is_root();
     *
     * if ($node)
     * {
     *     print 'This node is a root node.';      
     * }
     *
     * @access public
     * @return boolean
     * @author Kiall Mac Innes
     **/
    public function is_root()
    {
        return ($this->{$this->left_column} === 1) ? TRUE : FALSE;
    }
    
    /**
     * Returns the root node
     *
     * $root = ORM::factory('table')->root()->find();
     *
     * @access public
     * @return object
     * @author Mathew Davies
     **/
    public function root()
    {
        return $this->where($this->left_column, 1);
    }
    
    /**
     * Leaf nodes are ones that have no
     * children.
     *
     * $leaf_nodes = ORM::factory('table')->leaf_nodes()->find_all();
     *
     * @access public
     * @return object
     * @author Mathew Davies
     **/
    public function leaf_nodes()
    {
        return $this->where('`'.$this->left_column.'` = (`'.$this->right_column.'` - 1)')->orderby($this->left_column, 'ASC');
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
        $left = $this->db->query('UPDATE '.$this->table_name.' SET `'.$this->left_column.'` = `'.$this->left_column.'` + '.$size.' WHERE `'.$this->left_column.'` >= '.$start);
        
        // Now the right.
        $right = $this->db->query('UPDATE '.$this->table_name.' SET `'.$this->right_column.'` = `'.$this->right_column.'` + '.$size.' WHERE `'.$this->right_column.'` >= '.$start);
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
        $left = $this->db->query('UPDATE '.$this->table_name.' SET `'.$this->left_column.'` = `'.$this->left_column.'` - '.$size.' WHERE `'.$this->left_column.'` >= '.$start);
        
        // Now the right.
        $right = $this->db->query('UPDATE '.$this->table_name.' SET `'.$this->right_column.'` = `'.$this->right_column.'` - '.$size.' WHERE `'.$this->right_column.'` >= '.$start);
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
     * @param $node object | integer Node object or ID.
     * @return void
     * @author Mathew Davies
     **/
    public function insert_as_last_child($node)
    {
        // Lock the table.
        $this->lock();
        
        // If $node isn't an object we find the node with the ID
        if (!is_a($node, get_class($this)))
        {
            $node = ORM::factory($this->table_name, $node);
        }
        
        // Example : left = 1, right = 32

        // Values for the new node
        // Example : left = 32, right = 33
        $this->{$this->left_column}  = $node->{$this->right_column};
        $this->{$this->right_column} = $node->{$this->right_column} + 1;
        $this->{$this->level_column} = $node->{$this->level_column} + 1;
        $this->{$this->parent_column} = $node->{$this->primary_key};
        
        // Create some space for the new node.
        $this->create_space($this->{$this->left_column});
        
        // Save the new node.
        parent::save();
        
        // Unlock the table.
        $this->unlock();
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
        // The node has no descendants, easy to remove.
        if ($this->is_leaf())
        {
            // Lock the table
            $this->lock();
            
            // Left value.
            $left = $this->{$this->left_column};
            
            // Delete the current object.
            parent::delete();
            
            // Close the gap.
            $this->delete_space($left);
                
            // Unlock the table.
            $this->unlock();
        }
        
        // The node has descendants that need to be removed.
        if ($this->has_child() AND $descendants === TRUE)
        {
            // Lock the table.
            $this->lock();
            
            // Left and right values.
            $left  = $this->{$this->left_column};
            $right = $this->{$this->right_column};
            
            // Delete the node and it's descendants.
            $this->db->delete($this->table_name, '`'.$this->left_column.'` BETWEEN '.$this->{$this->left_column}.' AND '.$this->{$this->right_column});
            
            // Close the gap
            $this->delete_space($left, ($right - $left) + 1);
            
            // Unlock the table.
            $this->unlock();
        }
        
        // Delete the node and move the descendants up a level.
        if ($this->has_child() AND $descendants === FALSE)
        {
            // TODO : Finish this method.
        }
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
            return $this->where('`'.$this->left_column.'` >= '.$this->{$this->left_column}.' AND `'.$this->right_column.'` <= '.$this->{$this->right_column})->orderby($this->left_column, 'ASC');
            
        return $this->where('`'.$this->left_column.'` > '.$this->{$this->left_column}.' AND `'.$this->right_column.'` < '.$this->{$this->right_column})->orderby($this->left_column, 'ASC');
    }
    
    /**
     * Move a subtree to a specified target.
     *
     * @return void
     * @author Mathew Davies
     **/
    public function move_to()
    {
        // Lock the table.
        $this->lock();
        
        // TODO : Finish this bloody method.
        
        // Unlock the table.
        $this->unlock();
    }
    
    /**
     * Returns the path to the current node.
     *
     * $node = ORM::factory('table')->where('name', 'Some Node')->find();
     *
     * $path = ORM::factory('table', $node->id)->path()->find_all();
     *
     * @access public
     * @param $root boolean Should it include the root node?
     * @return object
     * @author Mathew Davies
     **/
    public function path($root = FALSE)
    {
        if ($root === TRUE)
            return $this->where('`'.$this->left_column.'` <= '.$this->{$this->left_column}.' AND `'.$this->right_column.'` >= '.$this->{$this->right_column});
            
        return $this->where('`'.$this->left_column.'` < '.$this->{$this->left_column}.' AND `'.$this->right_column.'` > '.$this->{$this->right_column});
    }
    
} // END class ORM_MPTT_Core extends ORM