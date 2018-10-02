<?php

namespace Wiredot\Copernicus\Fields;

class User extends Field {

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
		$users = get_users( $this->arguments );

		if ( ! $users ) {
			return null;
		}

		$options = array( 0 => '-- select --' );

		foreach ( $users as $user ) {
			$options[ $user->ID ] = get_user_meta( $user->ID, 'first_name', true ) . ' ' . get_user_meta( $user->ID, 'last_name', true ) . ' (' . $user->data->user_login . ')';
		}

		return $options;
	}
}
