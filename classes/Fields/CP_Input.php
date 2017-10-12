<?php

namespace Copernicus\Fields;

use Copernicus\CP_Field;

class CP_Input extends CP_Field {

	protected $input_type = 'text';

	public function get_field() {
		$this->smarty->assign('input_type', $this->input_type);
		return $this->smarty->fetch('fields/input.twig');
	}

}