<?php

namespace Copernicus;

use Ospinto\dBug;

class CP_Config {

	private $config = array();
	private $config_directory = array();

	public function __construct( $config_directory ) {
		$this->set_config_directory($config_directory);
		$config = $this->load_config();
		$this->set_config($config);

		new dBug($this->get_config());
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

	private function set_config($config) {
		$this->config = $config;
	}

	public function get_config_directory() {
		return $this->config_directory;
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