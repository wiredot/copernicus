<?php

namespace Copernicus;

use Copernicus\Meta_Boxes\CP_Post_Meta_Box;
use Copernicus\Meta_Boxes\CP_User_Meta_Box;
use Copernicus\Meta_Boxes\CP_Term_Meta_Box;
use Ospinto\dBug;

class CP_Meta_Box_Factory {

	private $meta_boxes;

	public function __construct($meta_boxes) {
		$this->meta_boxes = $meta_boxes;

		add_action('admin_init', array($this, 'create_meta_boxes'));
	}

	public function create_meta_boxes() {
		foreach ($this->meta_boxes as $key => $meta_box) {

			switch ($meta_box['type']) {
				case 'post':
					$meta = new CP_Post_Meta_Box($key, $meta_box['active'], $meta_box);
					break;
				case 'user':
					$meta = new CP_User_Meta_Box($key, $meta_box['active'], $meta_box);
					break;
				case 'term':
					$meta = new CP_Term_Meta_Box($key, $meta_box['active'], $meta_box);
					break;
			}

			if (is_object($meta)) {
				$meta->create_meta_box_if_active();
			}
		}
	}
}