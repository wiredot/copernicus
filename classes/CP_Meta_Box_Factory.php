<?php

namespace Copernicus;

use Ospinto\dBug;

class CP_Meta_Box_Factory {

	private $meta_boxes;

	public function __construct($meta_boxes) {
		$this->meta_boxes = $meta_boxes;
	}

	public function create_meta_boxes() {
		foreach ($this->meta_boxes as $key => $meta_box) {
			$meta = new CP_Meta_Box($key, $meta_box['active'], $meta_box);
			$meta->create_meta_box_if_active();
		}
	}
}