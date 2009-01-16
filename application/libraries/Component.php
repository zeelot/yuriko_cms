<?php
/**
 * \brief Wraps a Controller object and allows to grab the output of its methods.
 *
 * This class is tipically used to compose a view with the result of the execution of multiple controllers.
 * One controller, the "composite" controller, uses the "factory" method to instantiate components and
 * the "method" method to generate the subviews, assigning them to the variables of a template view.
 *
 * \note This class is based on dlib's Dispatch library, extended and adapted to KohanaPHP v2.3 routing/filesystem.
 */
class Component {

	/// When a component is instantiated, the original Router static properties are backed up here.
	protected $router_state_backup;

	/// The component controller instance
	protected $controller;
	/// The component controller name as it appears in Router::$controller
	protected $router_controller;

	/**
	 * Instantiates the specified controller, optionally replacing $_GET and $_POST contents before calling the component constructor.
	 * \note The original $_GET and $_POST array are restored as soon as the component is instantiated.
	 * @param $controller The name of the controller class to be instantiated, lowercase, without the "Controller_" prefix.
	 * @param $get The array that should replace $_GET.
	 * @param $post The array that should replace $_POST.
	 * @return A new Component object.
	 */
	public static function factory($controller, $get = null, $post = null) {

		// Backup router state
		$old_router = array();
		$old_router['current_route'] = Router::$current_route;
		$old_router['current_uri'] = Router::$current_uri;
		$old_router['query_string'] = Router::$query_string;
		$old_router['complete_uri'] = Router::$complete_uri;
		$old_router['controller'] = Router::$controller;
		$old_router['method'] = Router::$method;
		$old_router['arguments'] = Router::$arguments;

		// The following three variables could be determined by running Router code and passing an url, but:
		// 1) The performance penalty would be high
		// 1) It's not a good idea for a controller to alter its behaviour depending on them, anyway
		//Router::$current_route = '';
		//Router::$current_uri = '';
		//Router::$complete_uri = '';

		Router::$controller = $controller;

		// We don't know these yet
		Router::$method = '';
		Router::$arguments = array();

		// If get or post parameters are passed, alter $_GET, $_POST and Router::$query_string accordingly
		// NOTE: Should we alter $_SERVER['QUERY_STRING'] too?
		if ($get !== null) {
			$old_get = $_GET;
			$_GET = $get;
			Router::$query_string = '?'.http_build_query($get);
		}
		if ($post !== null) {
			$old_post = $_POST;
			$_POST = $post;
		}

		// If class is not defined already, load controller file
		$controller_class = ucfirst($controller).'_Controller';
		if (!class_exists($controller_class, false)) {
			$controller_file = $controller;

			// If the component file doesn't exist, fire exception
			$filepath = Kohana::find_file('controllers', $controller_file, true);

			// Include the Controller file
			require_once $filepath;
		}

		// Run system.pre_controller
		Event::run('dispatch.pre_controller');

		// Initialize the controller
		$controller_instance = new $controller_class;

		// Run system.post_controller_constructor
		Event::run('dispatch.post_controller_constructor');

		// Revert $_GET and $_POST changes
		if ($get !== null) $_GET = $old_get;
		if ($post !== null) $_POST = $old_post;

		// Revert Router state
		Router::$current_route = $old_router['current_route'];
		Router::$current_uri = $old_router['current_uri'];
		Router::$query_string = $old_router['query_string'];
		Router::$complete_uri = $old_router['complete_uri'];
		Router::$controller = $old_router['controller'];
		Router::$method = $old_router['method'];
		Router::$arguments = $old_router['arguments'];

		return new Component($controller_instance, $controller, $old_router);
	}

	private function __construct(Controller $controller_instance, $router_controller, $router_state_backup) {
		$this->controller = $controller_instance;
		$this->router_controller = $router_controller;
		$this->router_state_backup = $router_state_backup;
	}


	/// Magic method: returns the $key property of the wrapped Controller
	public function __get($key) {
		return $this->controller->$key;
	}

	/// Magic method: sets the $key property of the wrapped Controller
	public function __set($key,$value) {
		$this->controller->$key = $value;
	}

	/// Magic method: checks if the $key property of the wrapped Controller is set.
	public function __isset($key) {
		return isset($this->controller->$key);
	}

	/// Calls __toString() on the wrapped Controller
	public function __toString() {
		return $this->render();
	}

	/// Calls __toString() on the wrapped Controller
	public function render() {
		return (string) $this->controller;
	}

	/// Magic method: invoke method $name (with arguments $arguments) of the wrapped Controller.
	/// \note This method is slow. Use the "method" method directly if you can.
	public function __call($name, $arguments = null) {
		return $this->method($name, $arguments);
	}

	/**
	* Invokes method $method (with arguments $arguments) of the wrapped Controller, optionally replacing
	* $_GET and $_POST contents before making the call.
	* @param $method The name of the method to invoke.
	* @param $arguments The arguments to pass.
	* @param $get The array that should replace $_GET.
	* @param $post The array that should replace $_POST.
	* @param $capture If true (default) any output generated by the method is captured and returned,
	*        otherwise the method's return value itself is returned.
	* @return The called method's output or its return value, depending on $capture.
	*/
	public function method($method, $arguments = null, $get = null, $post = null, $capture = true) {

		// If method does not exist, call the "__call" magic method
		// This can be made faster by catching an exception in the switch statement below
		if (!method_exists($this->controller, $method)) {
			$arguments = array($method, $arguments);
			$method = '__call';
		}

		// Change Router state to reflect call
		//Router::$current_route = '';
		//Router::$current_uri = '';
		//Router::$complete_uri = '';
		Router::$controller = $this->router_controller;
		Router::$method = $method;
		if ($arguments === null) Router::$arguments = array();
		else Router::$arguments = $arguments;

		// If get or post parameters are passed, alter $_GET, $_POST and Router::$query_string accordingly
		// NOTE: Should we alter $_SERVER['QUERY_STRING'] too?
		if ($get !== null) {
			$old_get = $_GET;
			$_GET = $get;
			Router::$query_string = '?'.http_build_query($get);
		}
		if ($post !== null) {
			$old_post = $_POST;
			$_POST = $post;
		}

		// Start output capture
		if ($capture) {
			ob_implicit_flush(0);
			ob_start();
		}

		if (is_string($arguments)) $arguments = array($arguments);

		// Invoke method
		switch (count($arguments)) {
			case 1:
				$result=$this->controller->$method($arguments[0]);
				break;
			case 2:
				$result=$this->controller->$method($arguments[0], $arguments[1]);
				break;
			case 3:
				$result=$this->controller->$method($arguments[0], $arguments[1], $arguments[2]);
				break;
			case 4:
				$result=$this->controller->$method($arguments[0], $arguments[1], $arguments[2], $arguments[3]);
				break;
			default:
				// Resort to using call_user_func_array for many arguments (slower)
				$result=call_user_func_array(array($this->controller, $method), $arguments);
				break;
		}

		// Run system.post_controller
		Event::run('dispatch.post_controller');

		// Stop output capture
		if ($capture) {
			$result = ob_get_contents();
			ob_end_clean();
		}

		// Revert $_GET and $_POST changes
		if ($get !== null) $_GET = $old_get;
		if ($post !== null) $_POST = $old_post;

		// Revert Router state
		//Router::$current_route = $this->router_state_backup['current_route'];
		//Router::$current_uri = $this->router_state_backup['current_uri'];
		//Router::$complete_uri = $this->router_state_backup['complete_uri'];
		Router::$query_string = $this->router_state_backup['query_string'];
		Router::$controller = $this->router_state_backup['controller'];
		Router::$method = $this->router_state_backup['method'];
		Router::$arguments = $this->router_state_backup['arguments'];

		return $result;
	}
}