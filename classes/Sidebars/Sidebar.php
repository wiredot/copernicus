<?php

namespace Wiredot\Copernicus\Sidebars;

class Sidebar {

	private $args;

	function __construct( $args ) {
		$this->args = $args;

		add_action( 'widgets_init', array( $this, 'register_sidebar' ) );
	}

	public function register_sidebar() {
		register_sidebar( $this->args );
	}
}
