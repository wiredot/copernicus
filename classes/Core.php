<?php

namespace Wiredot\Copernicus;

use Wiredot\Preamp\Core as Preamp;

class Core {

	private static $instance = null;

	public static $plugin_name = 'Copernicus';
	public static $plugin_version = '2.0.0';

	public function __construct() {
		$Preamp = Preamp::run( CP_PATH, CP_URL );
		new Autoload;
	}

	public static function run() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof CP ) ) {
			self::$instance = new Core;
		}
		return self::$instance;
	}
}
