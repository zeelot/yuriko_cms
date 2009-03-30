<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Just a little modification of where the View object is created.
 * This allows the assets module to detect when the profiler
 * will be displayed.
 */
class Profiler extends Profiler_Core {

	protected $profiles = array();
	protected $show;
	protected $view;

	public function __construct()
	{
		$this->view = new View('kohana_profiler');
		parent::__construct();
	}
	public function render($return = FALSE)
	{
		$start = microtime(TRUE);

		$get = isset($_GET['profiler']) ? explode(',', $_GET['profiler']) : array();
		$this->show = empty($get) ? Kohana::config('profiler.show') : $get;

		Event::run('profiler.run', $this);

		$styles = '';
		foreach ($this->profiles as $profile)
		{
			$styles .= $profile->styles();
		}

		// Don't display if there's no profiles
		if (empty($this->profiles))
			return;

		// Load the profiler view
		$data = array
		(
			'profiles' => $this->profiles,
			'styles'   => $styles,
			'execution_time' => microtime(TRUE) - $start
		);
		//changed this to use the view already created in constructor
		$view = $this->view;
		$view->set($data);
		// Return rendered view if $return is TRUE
		if ($return == TRUE)
			return $view->render();

		// Add profiler data to the output
		if (stripos(Kohana::$output, '</body>') !== FALSE)
		{
			// Closing body tag was found, insert the profiler data before it
			Kohana::$output = str_ireplace('</body>', $view->render().'</body>', Kohana::$output);
		}
		else
		{
			// Append the profiler data to the output
			Kohana::$output .= $view->render();
		}
	}


}