<?php

namespace Copernicus;


class CP {

	public function __construct($plugin_file = '') {
		$Config = new Config(get_stylesheet_directory() . '/config/');

		// register custom post types
		$CPT = new CPT($Config->get_config('cpt'));

		// create meta boxes
		$MB = new MB($Config->get_config('mb'));
	}
}