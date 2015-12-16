<?php

namespace Copernicus;

class CP {

	public function __construct($plugin_file = '') {
		$Config = new CP_Config(get_stylesheet_directory() . '/config/');

		// register custom post types
		$CPT = new CP_Custom_Post_Type($Config->get_config('cpt'));

		// create meta boxes
		$MB = new CP_Meta_Box($Config->get_config('mb'));
	}
}