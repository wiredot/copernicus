<?php

namespace Copernicus;

use Ospinto\dBug;

abstract class CP_Meta_Box {

	private $id;
	private $active;
	private $meta_box;

	public function __construct( $id, $active, $meta_box ) {
		$this->id = $id;
		$this->active = $active;
		$this->meta_box = $meta_box;
	}

	public function create_meta_box_if_active() {
		if ( $this->active ) {
			$this->create_meta_box();
		}
	}

	private function create_meta_box() {
		//new dBug($this->meta_box);
	}
}
