<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
* @package    YurikoCMS
* @author     Lorenzo Pisani - Zeelot
* @license    http://yurikocms.com/license
*/

class Content_Pivot_Model extends ORM {

	/**
	 * This is my pivot table that contains pages, nodes, and sections
	 *
	 */
	protected $belongs_to = array
	(
		'content_page',
		'content_node',
	);
	protected $has_many = array
	(
		'content_arguments',
	);

	public function validate(array & $array, $save = FALSE)
	{
		$array = Validation::factory($array)
			->add_rules('content_page_id', 'required', 'digit', array($this, 'page_exists'))
			->add_rules('content_node_id', 'required', 'digit', array($this, 'node_exists'))
			->add_rules('section', 'required', 'digit')
			->add_rules('view', array($this, 'view_exists'))
			->add_callbacks('content_page_id', array($this, 'unique_pivot'));

		return parent::validate($array, $save);
	}
	public function page_exists($id)
	{
		return (bool) $this->db
			->where($this->unique_key($id), $id)
			->count_records('content_pages');
	}
	public function node_exists($id)
	{
		return (bool) $this->db
			->where($this->unique_key($id), $id)
			->count_records('content_nodes');
	}
	/**
	 * Finds what type of node this is then returns TRUE if $view exists in
	 * views/content/{type}/
	 *
	 * @param <string> $view - the view file to check against
	 * @return <bool>
	 */
	public function view_exists($view)
	{
		/**
		 * @TODO: implement this
		 */
		return TRUE;
	}
	public function unique_pivot(Validation $array, $field)
	{
		$exists = (bool) $this->db
			->where(array
				(
					'content_page_id' => $array->content_page_id,
					'content_node_id' => $array->content_node_id,
					'section'         => $array->section,
				))
			->count_records('content_pivots');
		if ($exists)
		{
			$array->add_error($field, 'pivot_unique');
		}
	}

}