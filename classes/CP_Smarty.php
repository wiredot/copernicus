<?php

namespace Copernicus;

use Smarty;

class CP_Smarty {

	private $template_dirs = array();
	private $plugins_dirs = array();
	private $compile_dirs = array();
	private $cache_dirs = array();

	private $Smarty;

	public function __construct() {
		$this->smarty = new Smarty();
	}
}