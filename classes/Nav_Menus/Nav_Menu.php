<?php

namespace Wiredot\Copernicus\Nav_Menus;

class Nav_Menu {

	private $location;
	private $description;

	function __construct( $location, $description ) {
		$this->location = $location;
		$this->description = $description;

		add_action( 'after_setup_theme', array( $this, 'register_nav_menu' ) );
	}

	public function register_nav_menu() {
		register_nav_menu( $this->location, $this->description );
	}
}
