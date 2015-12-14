<?php

namespace Copernicus;

class CP {

	public function __construct($plugin_file = '') {
		$CP_Config = new CP_Config(get_stylesheet_directory() . '/config/');

		// register custom post types
		$CP_CPT = new CP_CPT($CP_Config->get_config('cpt'));

		// create meta boxes
		$CP_MB = new CP_MB($CP_Config->get_config('mb'));
	}
}