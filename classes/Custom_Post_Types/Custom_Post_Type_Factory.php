<?php

namespace Wiredot\Copernicus\Custom_Post_Types;

class Custom_Post_Type_Factory {

	private $custom_post_types = array();

	public function __construct( $custom_post_types ) {
		$this->custom_post_types = $custom_post_types;
	}

	public function register_custom_post_types() {
		if ( ! is_array( $this->custom_post_types ) ) {
			return;
		}

		foreach ( $this->custom_post_types as $post_type => $custom_post_type ) {
			new Custom_Post_Type( $post_type, $custom_post_type );
		}
	}
}
