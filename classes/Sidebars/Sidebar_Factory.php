<?php

namespace Wiredot\Copernicus\Sidebars;

class Sidebar_Factory {

	private $sidebars;

	function __construct( $sidebars ) {
		$this->sidebars = $sidebars;
	}

	public function register_sidebars() {
		if ( ! is_array( $this->sidebars ) ) {
			return;
		}

		foreach ( $this->sidebars as $id => $args ) {
			$args['id'] = $id;
			$sidebar = new Sidebar( $args );
		}
	}
}
