<?php

namespace Wiredot\Copernicus;

use Wiredot\Preamp\Core as Preamp;

class Core {

	private static $instance = null;

	private function __construct() {
		Preamp::run( CP_URL );
		new Setup;
		new Autoload;
		new Template;
	}

	public static function run() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof CP ) ) {
			self::$instance = new Core;
		}
		return self::$instance;
	}

	public static function header() {
		Header::show_header();
	}

	public static function footer() {
		Footer::show_footer();
	}

	public static function template() {
		// new Template::template_dispatch();
	}
}
