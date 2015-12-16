<?php

namespace Copernicus;

use Ospinto\dBug;

class CP_Meta_Box {

	private $meta_boxes;

	public function __construct($meta_boxes) {
		$this->meta_boxes = $meta_boxes;

		new dBug($this->meta_boxes);
	}
}