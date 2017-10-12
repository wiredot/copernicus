<?php

namespace Copernicus;

use Copernicus\Fields\Input\CP_Email;

class CP_Fieldset {

	private $fields = [];

	public function __construct( $fields ) {
		$this->fields = $fields;
	}

	public function get_fieldset() {
		foreach ( $this->fields as $key => $field ) {
			return $this->get_field( $field );
		}
	}

	public function get_field( $field ) {
		switch ( $field['type'] ) {
			case 'email':
				$field = new CP_Email( $field['label'], $field['name'], $field['id'] );
				break;
		}

		return $field->get_field();
	}
}
