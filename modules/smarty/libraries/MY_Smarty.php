<?php defined('SYSPATH') OR die('No direct access allowed.');

include Kohana::find_file('vendor', 'smarty/Smarty.class');

class MY_Smarty_Core extends Smarty {

	function __construct()
	{
		// Check if we should use smarty or not
		if (Kohana::config('smarty.integration') == FALSE)
			return;

		// Okay, integration is enabled, so call the parent constructor
		parent::Smarty();

		$this->cache_dir      = Kohana::config('smarty.cache_path');
		$this->compile_dir    = Kohana::config('smarty.compile_path');
		$this->config_dir     = Kohana::config('smarty.configs_path');
		$this->plugins_dir[]  = Kohana::config('smarty.plugins_path');
		$this->debug_tpl      = Kohana::config('smarty.debug_tpl');
		$this->debugging_ctrl = Kohana::config('smarty.debugging_ctrl');
		$this->debugging      = Kohana::config('smarty.debugging');
		$this->caching        = Kohana::config('smarty.caching');
		$this->force_compile  = Kohana::config('smarty.force_compile');
		$this->security       = Kohana::config('smarty.security');

		// check if cache directory is exists
		$this->checkDirectory($this->cache_dir);

		// check if smarty_compile directory is exists
		$this->checkDirectory($this->compile_dir);

		// check if smarty_cache directory is exists
		$this->checkDirectory($this->cache_dir);

		if ($this->security)
		{
			$configSecureDirectories = Kohana::config('smarty.secure_dirs');
			$safeTemplates           = array(Kohana::config('smarty.global_templates_path'));

			$this->secure_dir                          = array_merge($configSecureDirectories, $safeTemplates);
			$this->security_settings['IF_FUNCS']       = Kohana::config('smarty.if_funcs');
			$this->security_settings['MODIFIER_FUNCS'] = Kohana::config('smarty.modifier_funcs');
		}

		// Autoload filters
		$this->autoload_filters = array('pre'    => Kohana::config('smarty.pre_filters'),
										'post'   => Kohana::config('smarty.post_filters'),
										'output' => Kohana::config('smarty.output_filters'));

		// Add all helpers to plugins_dir
		$helpers = glob(APPPATH . 'helpers/*', GLOB_ONLYDIR | GLOB_MARK);

		foreach ($helpers as $helper)
		{
			$this->plugins_dir[] = $helper;
		}
	}

	public function checkDirectory($directory)
	{
		if ((! file_exists($directory) AND ! @mkdir($directory, 0755)) OR ! is_writable($directory) OR !is_executable($directory))
		{
			$error = 'Compile/Cache directory "%s" is not writeable/executable';
			$error = sprintf($error, $directory);

			throw new Kohana_User_Exception('Compile/Cache directory is not writeable/executable', $error);
		}

		return TRUE;
	}
}
