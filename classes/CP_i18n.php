<?php

namespace Copernicus;

class CP_i18n{

	public function __construct() {
		
		add_action('plugins_loaded', array($this, 'load_textdomain'));
	}

	public function load_textdomain() {
		
		$lang_file = CP_PATH.'/languages/copernicus-pl_PL.mo';

		if ( file_exists( $lang_file ) ) {
			load_plugin_textdomain( 'copernicus', false, CP_BASENAME . '/languages' );

			echo get_locale();

			echo __('Customers', 'copernicus');
			exit;
		}
	}
}