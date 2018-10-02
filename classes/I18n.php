<?php

namespace Wiredot\Copernicus;

class I18n {

	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
	}

	public function load_textdomain() {
		load_plugin_textdomain( 'copernicus', false, CP_BASENAME . '/languages' );
	}
}
