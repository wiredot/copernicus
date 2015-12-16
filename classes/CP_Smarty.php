<?php

namespace Copernicus;

use Smarty;

class CP_Smarty {

	private $template_dirs = [];
	private $plugins_dirs = [];
	private $compile_dirs = [];
	private $cache_dirs = [];

	private $Smarty;

	public function __construct() {

		$this->template_dirs[] = get_stylesheet_directory() . '/templates/';
		$this->plugins_dirs[] = get_stylesheet_directory() . '/lib/smarty-plugins/';
		
		$this->template_dirs[] = CP_PATH . '/templates/';
		$this->plugins_dirs[] = CP_PATH.'/lib/smarty-plugins/';


		$this->smarty = new Smarty();
		$this->smarty->addPluginsDir($this->plugins_dirs);
		$this->smarty->setTemplateDir($this->template_dirs);
		$this->smarty->setCompileDir(WP_CONTENT_DIR . '/smarty/templates_c/');
		$this->smarty->setCacheDir(WP_CONTENT_DIR . '/smarty/cache/');
		// $this->smarty->registerFilter('pre', array($this, 'block_loop_literal'));
		// $this->smarty->registerDefaultPluginHandler(array($this, 'default_plugin_handler'));
		$this->smarty->force_compile = true;
	}

	public function get_smarty() {
		return $this->smarty;
	}
}