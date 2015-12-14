<?php

namespace Copernicus;

use Ospinto\dBug;

class CP_CPT {

	private $cpts;

	public function __construct($cpts) {
		$this->cpts = $cpts;

		add_action('init', array($this, 'init'));
	}

	public function init() {
		if ( is_array($this->cpts) ) {
			$this->register_post_types($this->cpts);
		}

		$CP_Smarty = new CP_Smarty();
		new dBug($CP_Smarty);

		(new CP_Image('asdasd'))->get_image_link();
	}

	public function aa() {
		
	}

	private function register_post_types($cpts) {
		
	}

	private function register_post_type($cpt) {

	}
}