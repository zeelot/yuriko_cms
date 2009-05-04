<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
* @package    YurikoCMS
* @author     Lorenzo Pisani - Zeelot
* @license    http://yurikocms.com/license
*/

class Content_Page_Model extends ORM {

	protected $has_many = array
	(
		'content_pivots',
		'content_page_inheritances',
	);

	public function validate(array & $array, $save = FALSE)
	{
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('name', 'required', 'length[1,127]', 'chars[a-zA-Z0-9_./]')
			->add_rules('alias', 'required', 'length[1,127]', 'chars[a-zA-Z0-9_./]')
			->add_rules('template', array($this, 'template_exists'));
		//if this is a new page the name and alias should be unique
		if(!$this->loaded)
		{
			$array->add_rules('name', array($this, 'unique_name'))
			->add_rules('alias', array($this, 'unique_alias'));
		}
		return parent::validate($array, $save);
	}
	/**
	 * Checks if the template exists to render this page
	 * 
	 * @param <string> $view - the view file in templates/pages/ 
	 */
	public function template_exists($view)
	{
		return (bool) Kohana::find_file('views', 'templates/page/'.$view);
	}
	public function add_inheritance(array & $array)
	{
		//@TODO: find a better way to do this.
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('page_id', 'required', 'digit', array($this, 'page_exists'), array($this, 'unique_inheritance'));
		if ($array->validate())
		{
			$inheritance = ORM::factory('content_page_inheritance');
			$inheritance->content_page_id = $this->id;
			$inheritance->inherited_page_id = $array->page_id;
			$inheritance->save();
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	public function unique_key($id)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id))
		{
			return 'alias';
		}
		return parent::unique_key($id);
	}
	public function unique_alias($id)
	{
		return !(bool) $this->db
			->where('alias', $id)
			->count_records($this->table_name);
	}
	public function unique_name($id)
	{
		return !(bool) $this->db
			->where('name', $id)
			->count_records($this->table_name);
	}
	public function page_exists($id)
	{
		return (bool) $this->db
			->where($this->unique_key($id), $id)
			->count_records($this->table_name);
	}
	public function unique_inheritance($id)
	{
		return !(bool) $this->db
			->where(array('content_page_id' => $this->id, 'inherited_page_id' => $id))
			->count_records('content_page_inheritances');
	}
	public function has_content()
	{
		return (bool) $this->db
			->where(array('content_page_id' => $this->id))
			->count_records('content_pivots');
	}
	/**
	 * Returns the page sections along with any inherited nodes.
	 * @return <array> The sections of the theme filles with the content nodes
	 */
	public function get_sections()
	{
		$data = array();
		$pages = array();
		$pages[] = $this->id;
		foreach ($this->content_page_inheritances as $inh)
		{
			$pages[] = $inh->inherited_page_id;
		}
		$pivots = ORM::factory('content_pivot')
			->in('content_page_id', $pages)
			->find_all();
		foreach($pivots as $pivot)
		{
			$data[$pivot->section][] = $pivot->content_node;
		}
		foreach (Kohana::config('theme.sections') as $key => $section)
		{
			if(!isset($data[$key]))
			{
				$data[$key] = array();
			}
		}
		return $data;
	}

} // End Content Page Model