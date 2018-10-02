<?php

namespace Wiredot\Copernicus\Admin;

class Menu_Factory {

	private $menus;

	function __construct( $menus ) {
		$this->menus = $menus;
	}

	public function add_menus() {
		foreach ( $this->menus as $menu_slug => $settings ) {
			$Menu = new Menu( $settings['page_title'], $settings['menu_title'], $settings['capability'], $menu_slug, $settings['icon_url'], $settings['position'], $settings['options_prefix'] );

			$Menu->add_settings_page();

		}
	}
}
