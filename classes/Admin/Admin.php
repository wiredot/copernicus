<?php

namespace Wiredot\Copernicus\Admin;

use Wiredot\Copernicus\Config;
use Wiredot\Copernicus\Css\Css;
use Wiredot\Copernicus\Js\Js;

/**
 * Meadow extension for Twig with WordPress specific functionality.
 */
class Admin {

	public function __construct() {
		$this->init_admin_css();
		$this->init_admin_js();

		$admin_custom_columns = Config::get_config( 'admin_custom_columns' );
		if ( isset( $admin_custom_columns ) ) {
			$custom_columns = new Custom_Columns_Factory( $admin_custom_columns );
			$custom_columns->set_custom_columns();
		}
	}

	public function init_admin_css() {
		$preamp_css = new Css( 'preamp', CP_URL . 'vendor/wiredot/preamp/assets/css/preamp.css', 'admin' );
		$preamp_css->register_css_files();

		$trumbowyg_css = new Css( 'trumbowyg', CP_URL . 'vendor/wiredot/preamp/assets/lib/trumbowyg/dist/ui/trumbowyg.css', 'admin' );
		$trumbowyg_css->register_css_files();
	}

	public function init_admin_js() {
		$preamp_js = new Js( 'admin', 'preamp', CP_URL . 'vendor/wiredot/preamp/assets/js/preamp.js', 'admin' );
		$preamp_js->register_js_files();

		$trumbowyg_js = new Js( 'admin', 'trumbowyg', CP_URL . 'vendor/wiredot/preamp/assets/lib/trumbowyg/dist/trumbowyg.js', 'admin' );
		$trumbowyg_js->register_js_files();
	}

}
