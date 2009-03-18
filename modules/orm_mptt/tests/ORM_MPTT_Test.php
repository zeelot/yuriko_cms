<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * ORM_MPTT Unit Tests.
 *
 * @todo Comment this class right ;)
 * @package	ORM_MPTT
 */
class ORM_MPTT_Test extends Unit_Test_Case {

	/**
	 * Is this unit test disabled
	 *
	 * @var boolean
	 **/
	const DISABLED = FALSE;

	/**
	 * Has the setup process been run
	 *
	 * @var boolean
	 **/
	public $setup_has_run = FALSE;
	
	/**
	 * Database instance
	 *
	 * @var Kohana database instance
	 **/
	protected $db;
	
	/**
	 * Setup
	 *
	 * This creates the database and inserts
	 * sample data to perform tests on.
	 *
	 * @return void
	 * @author Kiall Mac Innes
	 **/
	public function setup()
	{
		$this->db = Database::instance();
		
		try
		{
			$this->db->query('DROP TABLE `orm_mptt_unit_tests`');
		}
		catch (Exception $e) {}
		
		// Create table.
		$this->db->query('CREATE TABLE `orm_mptt_unit_tests` (`id` INT( 255 ) UNSIGNED NOT NULL AUTO_INCREMENT ,`lft` INT( 255 ) NOT NULL ,`rgt` INT( 255 ) NOT NULL ,`lvl` INT( 255 ) NOT NULL ,`name` VARCHAR( 255 ) NOT NULL ,PRIMARY KEY ( `id` )) ENGINE = MYISAM ');
		
		// Sample data.
		// 1 - 22
		// 		2 - 3
		// 		4 - 7
		// 			5 - 6
		// 		8 - 9
		// 		10 - 21
		// 			11 - 12
		// 			13 - 18
		// 				14 - 15
		// 				16 - 17
		// 			19 - 20
		$this->db->insert('orm_mptt_unit_tests', array('id' => 1,'lvl' => 0,'lft' => 1,'rgt' => 22, 'name' => 'Root Node'));
		$this->db->insert('orm_mptt_unit_tests', array('id' => 2,'lvl' => 1,'lft' => 2,'rgt' => 3, 'name' => 'Leaf Node'));
		$this->db->insert('orm_mptt_unit_tests', array('id' => 3,'lvl' => 1,'lft' => 4,'rgt' => 7, 'name' => 'Normal Node'));
		$this->db->insert('orm_mptt_unit_tests', array('id' => 4,'lvl' => 2,'lft' => 5,'rgt' => 6, 'name' => 'Leaf Node'));
		$this->db->insert('orm_mptt_unit_tests', array('id' => 5,'lvl' => 1,'lft' => 8,'rgt' => 9, 'name' => 'Leaf Node'));
		$this->db->insert('orm_mptt_unit_tests', array('id' => 6,'lvl' => 1,'lft' => 10,'rgt' => 21, 'name' => 'Normal Node'));
		$this->db->insert('orm_mptt_unit_tests', array('id' => 7,'lvl' => 2,'lft' => 11,'rgt' => 12, 'name' => 'Leaf Node'));
		$this->db->insert('orm_mptt_unit_tests', array('id' => 8,'lvl' => 2,'lft' => 13,'rgt' => 18, 'name' => 'Normal Node'));
		$this->db->insert('orm_mptt_unit_tests', array('id' => 9,'lvl' => 3,'lft' => 14,'rgt' => 15, 'name' => 'Leaf Node'));
		$this->db->insert('orm_mptt_unit_tests', array('id' => 10,'lvl' => 3,'lft' => 16,'rgt' => 17, 'name' => 'Leaf Node'));
		$this->db->insert('orm_mptt_unit_tests', array('id' => 11,'lvl' => 2,'lft' => 19,'rgt' => 20, 'name' => 'Leaf Node'));
		
		$this->setup_has_run = TRUE;
	}
	
	/**
	 * Teardown
	 *
	 * After each test has finished we remove the test table.
	 *
	 * @return void
	 * @author Kiall Mac Innes
	 **/
	public function teardown()
	{
		if ($this->setup_has_run)
		{
			$this->db->query('DROP TABLE `orm_mptt_unit_tests`');
		}
	}
	
	/**
	 * Setup Test
	 *
	 * Make sure our table and sample data exist.
	 *
	 * @return void
	 * @author Kiall Mac Innes
	 **/
	public function setup_test()
	{
		$this->assert_true_strict($this->setup_has_run);
		
		// Verify the tree.
		$this->assert_true_strict(ORM_MPTT::factory('orm_mptt_unit_test')->root->verify_tree());
	}
	
	/**
	 * Has children
	 *
	 * @return void
	 * @author Kiall Mac Innes
	 **/
	public function has_children_test()
	{
		$node = ORM_MPTT::factory('orm_mptt_unit_test', 3);
		$this->assert_true_strict($node->has_children());
		
		$node = ORM_MPTT::factory('orm_mptt_unit_test', 4);		
		$this->assert_false_strict($node->has_children());
		
		// Verify the tree.
		$this->assert_true_strict(ORM_MPTT::factory('orm_mptt_unit_test')->root->verify_tree());
	}
	
	/**
	 * Is Leaf test
	 *
	 * @return void
	 * @author Kiall Mac Innes
	 **/
	public function is_leaf_test()
	{
		$node = ORM_MPTT::factory('orm_mptt_unit_test', 4);
		$this->assert_true_strict($node->is_leaf());
		
		$node = ORM_MPTT::factory('orm_mptt_unit_test', 3);
		$this->assert_false_strict($node->is_leaf());
		
		// Verify the tree.
		$this->assert_true_strict(ORM_MPTT::factory('orm_mptt_unit_test')->root->verify_tree());
	}
	
	/**
	 * Is the current node a descendant of the target node?
	 *
	 * @return void
	 * @author Mathew Davies
	 **/
	public function is_descendant_test()
	{
		// Parent
		$parent = ORM_MPTT::factory('orm_mptt_unit_test',1);
		
		$node = ORM_MPTT::factory('orm_mptt_unit_test', 2);
		
		$this->assert_true_strict($node->is_descendant($parent));
			
		// Parent
		$parent = ORM_MPTT::factory('orm_mptt_unit_test',3);
		
		$node = ORM_MPTT::factory('orm_mptt_unit_test', 2);
		
		$this->assert_false_strict($node->is_descendant($parent));
			
		// Parent
		$parent = ORM_MPTT::factory('orm_mptt_unit_test',2);
		
		$node = ORM_MPTT::factory('orm_mptt_unit_test', 2);
		
		$this->assert_false_strict($node->is_descendant($parent));
		
		// Verify the tree.
		$this->assert_true_strict(ORM_MPTT::factory('orm_mptt_unit_test')->root->verify_tree());
	}
	
	/**
	 * Root Test
	 *
	 * @return void
	 * @author Kiall Mac Innes
	 **/
	public function is_root_test()
	{
		$node = ORM_MPTT::factory('orm_mptt_unit_test', 1);
		$this->assert_true_strict($node->is_root());
		
		$node = ORM_MPTT::factory('orm_mptt_unit_test', 2);
		$this->assert_false_strict($node->is_root());
		
		$node = ORM_MPTT::factory('orm_mptt_unit_test')->root;
		$this->assert_true_strict($node->is_root());
		
		// Verify the tree.
		$this->assert_true_strict(ORM_MPTT::factory('orm_mptt_unit_test')->root->verify_tree());
	}
	
	/**
	 * Level
	 *
	 * @return void
	 * @author Kiall Mac Innes
	 **/
	public function level_test()
	{
		$node = ORM_MPTT::factory('orm_mptt_unit_test', 1);
		
		$this->assert_integer($node->lvl)
			 ->assert_same(0, $node->lvl);
		
		$node = ORM_MPTT::factory('orm_mptt_unit_test', 4);
		
		$this->assert_integer($node->lvl)
			 ->assert_same(2, $node->lvl);
		
		// Verify the tree.
		$this->assert_true_strict(ORM_MPTT::factory('orm_mptt_unit_test')->root->verify_tree());
	}
	
	/**
	 * Parent test
	 *
	 * @return void
	 * @author Mathew Davies
	 **/
	public function parent_test()
	{
		$node = ORM_MPTT::factory('orm_mptt_unit_test', 2);
		
		$this->assert_integer($node->parent->id)
			 ->assert_same(1, $node->parent->id);
		
		// Root node, can't have a parent.
		$node = ORM_MPTT::factory('orm_mptt_unit_test', 1);
		
		$this->assert_false_strict($node->parent);
		
		// Verify the tree.
		$this->assert_true_strict(ORM_MPTT::factory('orm_mptt_unit_test')->root->verify_tree());
	}
	
	/**
	 * Find the parents of the the current node
	 *
	 * @return void
	 * @author Mathew Davies
	 **/
	public function parents_test()
	{
		$node = ORM_MPTT::factory('orm_mptt_unit_test', 9);
		
		$this->assert_integer($node->parents->count())
			 ->assert_same(3, $node->parents->count());
			
		$node = ORM_MPTT::factory('orm_mptt_unit_test', 2);
		
		$this->assert_integer($node->parents->count())
			 ->assert_same(1, $node->parents->count());
		
		// Verify the tree.
		$this->assert_true_strict(ORM_MPTT::factory('orm_mptt_unit_test')->root->verify_tree());
	}
	
	/**
	 * Find all leaf nodes
	 *
	 * @return void
	 * @author Mathew Davies
	 **/
	public function leaves_test()
	{
		$root = ORM_MPTT::factory('orm_mptt_unit_test', 1);
		
		foreach ($root->leaves as $row)
		{
			$size = (int) ($row->rgt - $row->lft);
			
			$this->assert_integer($size)
				 ->assert_same(1, $size);
		}
		
		// Verify the tree.
		$this->assert_true_strict(ORM_MPTT::factory('orm_mptt_unit_test')->root->verify_tree());
	}
	
	/**
	 * Insert as first child.
	 *
	 * @return void
	 * @author Mathew Davies
	 **/
	public function insert_as_first_child_test()
	{
		// This will be our parent.
		$root = ORM_MPTT::factory('orm_mptt_unit_test')->root;

		// Prepare New Node for insertation
		$node = ORM_MPTT::factory('orm_mptt_unit_test');
		$node->name = 'First Child';
		
		// Save and insert the new node in the desired position
		$node->insert_as_first_child($root); 
		
		$this->assert_true_strict($node->saved)
			 ->assert_integer($node->lft)	
			 ->assert_integer($node->rgt)
			 ->assert_same(2, $node->lft)
			 ->assert_same(3, $node->rgt);
		
		// Verify the tree.
		$this->assert_true_strict(ORM_MPTT::factory('orm_mptt_unit_test')->root->verify_tree());
	}
	
	/**
	 * Insert as last child
	 *
	 * @return void
	 * @author Mathew Davies
	 **/
	public function insert_as_last_child_test()
	{
		// This will be our parent.
		$root = ORM_MPTT::factory('orm_mptt_unit_test')->root;

		// Prepare New Node for insertation
		$node = ORM_MPTT::factory('orm_mptt_unit_test');
		$node->name = 'Last Child';
		
		// Save and insert the new node in the desired position
		$node->insert_as_last_child($root);
		
		$this->assert_true_strict($node->saved)
			 ->assert_integer($node->lft)	
			 ->assert_integer($node->rgt)
			 ->assert_same(22, $node->lft)
			 ->assert_same(23, $node->rgt);
		
		// Verify the tree.
		$this->assert_true_strict(ORM_MPTT::factory('orm_mptt_unit_test')->root->verify_tree());
	}
	
	/**
	 * Insert as previous sibling
	 *
	 * @return void
	 * @author Mathew Davies
	 **/
	public function insert_as_prev_sibling_test()
	{
		// This will be our parent.
		$root = ORM_MPTT::factory('orm_mptt_unit_test', 5);
		
		// Prepare New Node for insertation
		$node = ORM_MPTT::factory('orm_mptt_unit_test');
		$node->name = 'Previous Sibling';
		
		// Save and insert the new node in the desired position
		$node->insert_as_prev_sibling($root); 
				
		$this->assert_true_strict($node->saved)
			 ->assert_integer($node->lft)	
			 ->assert_integer($node->rgt)
			 ->assert_same(8, $node->lft)
			 ->assert_same(9, $node->rgt);
			 
		// Verify the tree.
		$this->assert_true_strict(ORM_MPTT::factory('orm_mptt_unit_test')->root->verify_tree());
	}
	
	/**
	 * Insert as next sibling
	 *
	 * @return void
	 * @author Mathew Davies
	 **/
	public function insert_as_next_sibling_test()
	{
		// This will be our parent.
		$root = ORM_MPTT::factory('orm_mptt_unit_test', 5);

		// Prepare New Node for insertation 
		$node = ORM_MPTT::factory('orm_mptt_unit_test');
		$node->name = 'Next Sibling';
		
		// Save and insert the new node in the desired position
		$node->insert_as_next_sibling($root); 
		
		$this->assert_true_strict($node->saved)
			 ->assert_integer($node->lft)	
			 ->assert_integer($node->rgt)
			 ->assert_same(10, $node->lft)
			 ->assert_same(11, $node->rgt);
		
		// Verify the tree.
		$this->assert_true_strict(ORM_MPTT::factory('orm_mptt_unit_test')->root->verify_tree());
	}
	
	/**
	 * Save test
	 *
	 * @return void
	 * @author Mathew Davies
	 **/
	public function save_test()
	{
		$node = ORM_MPTT::factory('orm_mptt_unit_test');
		$node->name = 'Save Test';
		$this->assert_false_strict($node->save())
			 ->assert_false_strict($node->saved);
		
		// Verify the tree.
		$this->assert_true_strict(ORM_MPTT::factory('orm_mptt_unit_test')->root->verify_tree());
	}
	
	/**
	 * Delete test
	 *
	 * @return void
	 * @author Mathew Davies
	 **/
	public function delete_test()
	{
		$node = ORM_MPTT::factory('orm_mptt_unit_test', 3);
		$node->delete();
		
		// Verify the tree.
		$this->assert_true_strict(ORM_MPTT::factory('orm_mptt_unit_test')->root->verify_tree());
	}
	
	// public function select_list_test()
	// {
	// 	
	// }
	
	// public function subtree_test()
	// {
	// 	
	// }
	
	/**
	 * Move the node to the first child of the target node.
	 *
	 * @return void
	 * @author Mathew Davies
	 **/
	public function move_to_first_child_test()
	{
		// print 'BEFORE<br><br>';
		
		// $test = ORM_MPTT::factory('orm_mptt_unit_test')->orderby('lft', 'ASC')->find_all();
		
		// foreach ($test as $row)
		// {
		// 	print $row->id.' '.str_repeat(' - ', $row->level). $row->name.' ('.$row->lft.' - '.$row->rgt.')<br />';
		// }
		
		// Target root node.
		$root = ORM_MPTT::factory('orm_mptt_unit_test', 1);
		
		// Node we're moving.
		$node = ORM_MPTT::factory('orm_mptt_unit_test', 6);
		$node->move_to_first_child($root);

		// print '<br><br><br>AFTER<br><br>';
		
		// $test = ORM_MPTT::factory('orm_mptt_unit_test')->orderby('lft', 'ASC')->find_all();
		
		// foreach ($test as $row)
		// {
		// 	print $row->id.' '.str_repeat(' - ', $row->level). $row->name.' ('.$row->lft.' - '.$row->rgt.')<br />';
		// }
		
		// Verify the tree.
		$this->assert_true_strict(ORM_MPTT::factory('orm_mptt_unit_test')->root->verify_tree());
	}
	
	/**
	 * Move the node to the last child of the target node.
	 *
	 * @return void
	 * @author Mathew Davies
	 **/
	public function move_to_last_child_test()
	{
		// print 'BEFORE<br><br>';
		
		// $test = ORM_MPTT::factory('orm_mptt_unit_test')->orderby('lft', 'ASC')->find_all();
		
		// foreach ($test as $row)
		// {
		// 	print $row->id.' '.str_repeat(' - ', $row->level). $row->name.' ('.$row->lft.' - '.$row->rgt.')<br />';
		// }
		
		// Target root node.
		$root = ORM_MPTT::factory('orm_mptt_unit_test', 1);
		
		// Node we're moving.
		$node = ORM_MPTT::factory('orm_mptt_unit_test', 3);
		$node->move_to_last_child($root);
		
		// print '<br><br><br>AFTER<br><br>';
		
		// $test = ORM_MPTT::factory('orm_mptt_unit_test')->orderby('lft', 'ASC')->find_all();
		
		// foreach ($test as $row)
		// {
		// 	print $row->id.' '.str_repeat(' - ', $row->level). $row->name.' ('.$row->lft.' - '.$row->rgt.')<br />';
		// }
		
		// Verify the tree.
		$this->assert_true_strict(ORM_MPTT::factory('orm_mptt_unit_test')->root->verify_tree());
	}
	
	/**
	 * Move the node to the previous sibling of the target node.
	 *
	 * @return void
	 * @author Mathew Davies
	 **/
	public function move_to_prev_sibling_test()
	{
		// print 'BEFORE<br><br>';
		
		// $test = ORM_MPTT::factory('orm_mptt_unit_test')->orderby('lft', 'ASC')->find_all();
		
		// foreach ($test as $row)
		// {
		// 	print $row->id.' '.str_repeat(' - ', $row->level). $row->name.' ('.$row->lft.' - '.$row->rgt.')<br />';
		// }
		
		// Target node
		$target = ORM_MPTT::factory('orm_mptt_unit_test', 5);
		
		// Node we're moving.
		$node = ORM_MPTT::factory('orm_mptt_unit_test', 6);
		$node->move_to_prev_sibling($target);
		
		// print 'BEFORE<br><br>';
		
		// $test = ORM_MPTT::factory('orm_mptt_unit_test')->orderby('lft', 'ASC')->find_all();
		
		// foreach ($test as $row)
		// {
		// 	print $row->id.' '.str_repeat(' - ', $row->level). $row->name.' ('.$row->lft.' - '.$row->rgt.')<br />';
		// }
		
		// Verify the tree.
		$this->assert_true_strict(ORM_MPTT::factory('orm_mptt_unit_test')->root->verify_tree());
	}
	
	/**
	 * Move the node to the next sibling of the target node.
	 *
	 * @return void
	 * @author Mathew Davies
	 **/
	public function move_to_next_sibling_test() 
	{
		// print 'BEFORE<br><br>';
		
		// $test = ORM_MPTT::factory('orm_mptt_unit_test')->orderby('lft', 'ASC')->find_all();
		
		// foreach ($test as $row)
		// {
		// 	print $row->id.' '.str_repeat(' - ', $row->level). $row->name.' ('.$row->lft.' - '.$row->rgt.')<br />';
		// }
		
		// Target node
		$target = ORM_MPTT::factory('orm_mptt_unit_test', 2);
		
		// Node we're moving.
		$node = ORM_MPTT::factory('orm_mptt_unit_test', 6);
		$node->move_to_next_sibling($target);
		
		// print 'BEFORE<br><br>';
		
		// $test = ORM_MPTT::factory('orm_mptt_unit_test')->orderby('lft', 'ASC')->find_all();
		
		// foreach ($test as $row)
		// {
		// 	print $row->id.' '.str_repeat(' - ', $row->level). $row->name.' ('.$row->lft.' - '.$row->rgt.')<br />';
		// }
		
		// Verify the tree.
		$this->assert_true_strict(ORM_MPTT::factory('orm_mptt_unit_test')->root->verify_tree());
	}
	
	/**
	 * Verify Tree
	 *
	 * @return void
	 * @author Kiall Mac Innes
	 **/
	public function verify_tree_test()
	{
		$root = ORM_MPTT::factory('orm_mptt_unit_test')->root;
		$this->assert_true_strict($root->verify_tree());
		
		$this->db->query('UPDATE `orm_mptt_unit_tests` set lft = 5 WHERE id = 2');
		
		$this->assert_false_strict($root->verify_tree());
	}
}