<?php

namespace Wiredot\Copernicus;

use Wiredot\Preamp\Core as Preamp;

class Setup {

	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_setup' ) );
	}

	public function theme_setup() {
		$config = Preamp::get_config( 'theme' );

		if ( isset( $config['textdomain'] ) ) {
			load_theme_textdomain( $config['textdomain'] );
		}

		if ( isset( $config['support'] ) && is_array( $config['support'] ) ) {
			foreach ( $config['support'] as $feature => $args ) {
				if ( true === $args ) {
					add_theme_support( $feature );
				} else if ( is_array( $args ) ) {
					add_theme_support( $feature, $args );
				}
			}
		}
	}
}
