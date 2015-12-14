<?php

namespace Copernicus;

use Copernicus\Config;

class CP {

	public function __construct($plugin_file = '') {
		$cp_config = new Config;
		// autoload copernicus classes
		//$this->autoload_classes(plugin_dir_path($this->plugin_file).'library/copernicus');

		// autoload child theme classes
		//$this->autoload_classes(get_template_directory().'/library');
	}

	private function autoload_classes($folder_name) {
		//echo $folder_name.'<br>';
		if (file_exists($folder_name)) {
			$handle = opendir($folder_name);
			
			while (false !== ($entry = readdir($handle))) {
				if (preg_match('/^class-((?!copernicus).*).php/', $entry, $matches)) {
					$file = $folder_name.'/'.$matches[0];
					$class_name = 'CP_'.ucfirst($matches[1]);

					if (!class_exists($class_name)) {
						$this->load_class($file, $class_name);
					}
				}
			}
		}
	}

	private function load_class($file, $class_name) {
		if (file_exists($file)) {
			include_once $file;
			
			global $$class_name;
			$$class_name = new $class_name;
		}
	}
}