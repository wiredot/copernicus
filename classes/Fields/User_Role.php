<?php

namespace Wiredot\Copernicus\Fields;

use \WP_Roles;

class User_Role extends Field {

	protected $type = 'select';

	public function __construct( $label, $name, $id, $value, $attributes, $options = array(), $labels = array(), $arguments = array() ) {
		$this->label = $label;
		$this->name = $name;
		$this->id = $id;
		$this->value = $value;
		$this->attributes = $attributes;
		$this->labels = $labels;
		$this->arguments = $arguments;
		$this->options = $this->get_options();
	}

	public function get_options() {
		$roles = new WP_Roles();

		$role_names = $roles->role_names;

		if ( ! is_array( $role_names ) ) {
			return null;
		}

		$options = array( 0 => '-- select --' );

		foreach ( $role_names as $field_key => $field_value ) {
			$options[ $field_key ] = $field_value;
		}

		return $options;
	}
}
