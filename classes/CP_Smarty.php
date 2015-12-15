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
		$this->smarty = new Smarty();
	}

	public function get_smarty() {
		return $this->smarty;
	}
}