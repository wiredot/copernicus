<?php

namespace Copernicus;

use Ospinto\dBug;

class Config {

	private $config = array();

	public function __construct() {
		$config = $this->load_config_directory(get_stylesheet_directory() . '/config/');
		$this->set_config($config);

		new dBug($this->get_config());
	}

	private function load_config_directory($directory) {
		$config = array();

		// get all files from config folder
		if (file_exists($directory) && $handle = opendir($directory)) {

			// for each file with .config.php extension
			while (false !== ($filename = readdir($handle))) {
				
				if (preg_match('/.config.php$/', $filename)) {
					$config_part = $this->get_config_file($directory.$filename);
					if ( is_array($config_part) ) {
						$config = array_replace_recursive( $config, $config_part );
					}
				}
			}
			closedir($handle);
		}

		return $config;
	}

	private function get_config_file($filename) {
		if (file_exists($filename)) {
			// get config array from file
			require_once $filename;
			if (isset($config)) {
				return $config;
			}
		}

		return null;
	}

	private function set_config($config) {
		$this->config = $config;
	}
	
	public function get_config($key = null) {
		if ( $key ) {

			if ( isset($this->config[$key])) {
				return $this->config[$key];
			}
			return null;
		}
		return $this->config;
	}
}