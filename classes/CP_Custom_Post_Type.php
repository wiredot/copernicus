<?php

namespace Copernicus;

use Ospinto\dBug;

class CP_Custom_Post_Type {

	private $name;
	private $labels = [];

	public function __construct( $name, $active, $labels ) {
		$this->name = $name;
		$this->active = $active;
		$this->labels = $labels;
	}

	public function register_post_type_if_active() {
		if ( $this->active ) {
			$this->register_post_type();
		}
	}

	private function register_post_type() {
		new dBug( $this->name );
	}
}
