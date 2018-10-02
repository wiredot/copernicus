<?php

namespace Wiredot\Copernicus;

class Languages {

	private static $languages = array();
	private static $instance = null;

	private function __construct( $languages ) {
		self::$languages = $languages;
	}

	public static function set_languages( $languages ) {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Languages ) ) {
			self::$instance = new Languages( $languages );
		}

		return self::$instance;
	}

	public static function get_languages() {
		return self::$languages;
	}

	public static function has_languages() {
		if ( is_array( self::$languages ) && count( self::$languages ) > 1 ) {
			return true;
		}
		return false;
	}
}
