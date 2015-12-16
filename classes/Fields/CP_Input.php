<?php

namespace Copernicus\Fields;

use Copernicus\CP_Field;
use Copernicus\CP_Smarty;

class CP_Input extends CP_Field {

	protected $input_type = 'text';

	public function get_field() {
		$smarty = (new CP_Smarty())->get_smarty();
		$smarty->assign('value', $this->value);
		$smarty->assign('input_type', $this->input_type);
		$smarty->assign('attributes', $this->attributes);

		return $smarty->fetch('fields/input.html');
	}

}