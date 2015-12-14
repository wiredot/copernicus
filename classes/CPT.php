<?php

namespace Copernicus;

class CPT {

	private $cpts;

	public function __construct($cpts) {
		$this->cpts = $cpts;

		add_action('init', array($this, 'init'));
	}

	public function init() {
		if ( is_array($this->cpts) ) {
			$this->register_post_types($this->cpts);
		}
	}

	private function register_post_types($cpts) {
		
	}

	private function register_post_type($cpt) {

	}
}