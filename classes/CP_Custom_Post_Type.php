<?php

namespace Copernicus;

use Ospinto\dBug;

class CP_Custom_Post_Type {

	private $custom_post_types;

	public function __construct($custom_post_types) {
		$this->custom_post_types = $custom_post_types;

		add_action('init', array($this, 'init'));
	}

	public function init() {
		if ( is_array($this->custom_post_types) ) {
			$this->register_post_types($this->custom_post_types);
		}

		$Smarty = new CP_Smarty();
		//new dBug($Smarty);

		(new CP_Image('asdasd'))->get_image_link();
	}

	public function aa() {
		
	}

	private function register_post_types($custom_post_types) {
		
	}

	private function register_post_type($cpt) {

	}
}