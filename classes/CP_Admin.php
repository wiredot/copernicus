<?php

namespace Copernicus;

use Ospinto\dBug;

class CP_Admin {

	private $meta_boxes = [];

	public function __construct($meta_boxes) {
		$this->meta_boxes = $meta_boxes;
	}

	public function init() {

		// create meta boxes
		new CP_Meta_Box_Factory($this->meta_boxes);
	}
}