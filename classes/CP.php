<?php

namespace Copernicus;

use Copernicus\Config;

class CP {

	public function __construct($plugin_file = '') {
		$Config = new Config(get_stylesheet_directory() . '/config/');

		$MB = new MB($Config->get_config('mb'));
		$CPT = new CPT($Config->get_config('cpt'));
	}
}