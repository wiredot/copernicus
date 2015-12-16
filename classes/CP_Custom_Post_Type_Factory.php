<?php

namespace Copernicus;

use Ospinto\dBug;

class CP_Custom_Post_Type_Factory {

	private $custom_post_types = [];

	public function __construct($custom_post_types) {
		$this->custom_post_types = $custom_post_types;

		add_action('init', array($this, 'register_post_types'));
	}

	public function register_post_types() {
		foreach ($this->custom_post_types as $key => $custom_post_type) {
			$post_type = new CP_Custom_Post_Type($key, $custom_post_type['active'], $custom_post_type);
			$post_type->register_post_type_if_active();
		}
	}
}