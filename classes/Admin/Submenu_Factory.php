<?php

namespace Wiredot\Copernicus\Admin;

class Submenu_Factory {

	private $submenus;

	function __construct( $submenus ) {
		$this->submenus = $submenus;
	}

	public function add_submenus() {
		foreach ( $this->submenus as $menu_slug => $settings ) {
			$Submenu = new Submenu( $settings['parent_slug'], $settings['page_title'], $settings['menu_title'], $settings['capability'], $menu_slug, $settings['options_prefix'] );

			$Submenu->add_settings_page();
		}
	}
}
