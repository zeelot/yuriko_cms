<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 *
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @license    http://yurikocms.com/license
 */

class Content_Argument_Model extends ORM {

	protected $belongs_to = array
	(
		'content_pivot',
		'content_node',
	);

	public function unique_key($id)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id))
		{
			return 'key';
		}

		return parent::unique_key($id);
	}
	public function validate(array & $array, $save = FALSE)
	{
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('key', 'required', 'length[1,50]', 'chars[a-zA-Z 0-9_./]')
			->add_rules('value', 'required', 'length[1,255]', 'chars[a-zA-Z 0-9_./]')
			->add_rules('content_node_id', 'digit', array($this, 'node_exists'))
			->add_rules('content_pivot_id', 'digit', array($this, 'pivot_exists'));
		//run an event so that this plugin can add it's own validation
		Event::run('yuriko.'.$array['type'].'_argument_validation', $array);
		return parent::validate($array, $save);
	}

	public function node_exists($id)
	{
		return (bool) $this->db
			->where($this->unique_key($id), $id)
			->count_records('content_nodes');
	}
	public function pivot_exists($id)
	{
		return (bool) $this->db
			->where($this->unique_key($id), $id)
			->count_records('content_pivots');
	}
}
