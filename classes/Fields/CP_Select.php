<?php

namespace Copernicus\Fields;

use Copernicus\CP_Field;

class CP_Select extends CP_Field {

	public function get_field() {
		return $this->smarty->fetch( 'fields/select.twig' );
	}

}
