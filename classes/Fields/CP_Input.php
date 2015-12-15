<?php

namespace Copernicus\Fields;

use Copernicus\CP_Field;

class CP_Input extends CP_Field {
	
	protected $options;

	public function __construct($label, $options) {
		$this->label = $label;
		$this->options = $options;
	}

	public function get_field() {
		return 'Field';
	}

	public function get_options() {
		print_r($this->options);
	}

}