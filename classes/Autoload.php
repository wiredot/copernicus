<?php

namespace Wiredot\Copernicus;

class Autoload {

	public function __construct() {
		$this->autoload_classes( get_template_directory() . '/classes' );
	}

	private function autoload_classes( $folder_name ) {
		if ( file_exists( $folder_name ) ) {
			$handle = opendir( $folder_name );

			while ( false !== ($entry = readdir( $handle )) ) {
				if ( preg_match( '/^class-(.*).php/', $entry, $matches ) ) {
					$file = $folder_name . '/' . $matches[0];
					$class_name = 'CP_' . ucfirst( $matches[1] );

					$class_name = $this->format_class_name( $matches[1] );

					if ( ! class_exists( $class_name ) ) {
						$this->load_class( $file, $class_name );
					}
				}
			}
		}
	}

	private static function load_class( $file, $class_name ) {
		if ( file_exists( $file ) ) {
			include_once $file;

			global $$class_name;
			$$class_name = new $class_name;
		}
	}

	function format_class_name( $str ) {
		$class_name = preg_replace_callback(
			'/-(\w)/', function ( $matches ) {
					return strtoupper( $matches[0] );
			}, $str
		);

		$class_name = ucfirst( $class_name );
		$class_name = preg_replace( '/-/', '_', $class_name );

		return $class_name;
	}
}
