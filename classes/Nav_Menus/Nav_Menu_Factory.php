<?php

namespace Wiredot\Copernicus\Nav_Menus;

class Nav_Menu_Factory {

	private $nav_menus;

	function __construct( $nav_menus ) {
		$this->nav_menus = $nav_menus;
	}

	public function register_nav_menus() {
		if ( ! is_array( $this->nav_menus ) ) {
			return;
		}

		foreach ( $this->nav_menus as $location => $menu ) {
			$nav_menu = new Nav_Menu( $location, $menu['description'] );
		}
	}
}
