<?php

namespace Wiredot\Copernicus;

use Wiredot\Preamp\Core as Preamp;
use Wiredot\Copernicus\Templates\Template;

class Core {

	private static $instance = null;

	private function __construct() {
		Preamp::run( CP_URL, CP_DIR );

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
}
