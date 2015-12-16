<?php

namespace Copernicus;

use Ospinto\dBug;

class CP_Config {

	private static $instance;
	private static $config = [];
	private $config_directory = array();

	private function __construct() {
		$config_directory = get_stylesheet_directory() . '/config/';
		$this->set_config_directory($config_directory);
		self::$config = $this->load_config();
	}

	private function load_config() {
		$config = array();

		foreach ($this->get_config_directory() as $config_directory) {
			$config_part = $this->load_config_directory($config_directory);
			if ( is_array($config_part) ) {
				$config = array_replace_recursive( $config, $config_part );
			}
		}

		return $config;
	}

	private function load_config_directory($directory) {
		$config = array();

		// get all files from config folder
		if (file_exists($directory) && $handle = opendir($directory)) {

			// for each file with .config.php extension
			while (false !== ($filename = readdir($handle))) {
				
				if (preg_match('/.config.php$/', $filename)) {
					$config_part = $this->load_config_file($directory.$filename);
					if ( is_array($config_part) ) {
						$config = array_replace_recursive( $config, $config_part );
					}
				}
			}
			closedir($handle);
		}

		return $config;
	}

	private function load_config_file($filename) {
		if (file_exists($filename)) {
			// get config array from file
			require_once $filename;
			if (isset($config)) {
				return $config;
			}
		}

		return null;
	}

	private function set_config_directory($config_directory) {
		$this->config_directory[] = $config_directory;
	}

	public function get_config_directory() {
		return $this->config_directory;
	}
	
	public static function get_config($key = null) {
		if (null === self::$instance) {
            self::$instance = new CP_Config();
        }
        
		if ( $key ) {

			if ( isset(self::$config[$key])) {
				return self::$config[$key];
			}
			return null;
		}
		return self::$config;
	}
}