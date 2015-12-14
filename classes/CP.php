<?php

namespace Copernicus;

class CP {

	public function __construct($plugin_file = '') {
		$Config = new CP_Config(get_stylesheet_directory() . '/config/');

		// register custom post types
		$CPT = new CP_CPT($Config->get_config('cpt'));

		// create meta boxes
		$MB = new CP_MB($Config->get_config('mb'));
	}
}