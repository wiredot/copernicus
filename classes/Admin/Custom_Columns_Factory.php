<?php

namespace Wiredot\Copernicus\Admin;

class Custom_Columns_Factory {

	private $custom_columns;

	public function __construct( $custom_columns = array() ) {
		$this->custom_columns = $custom_columns;
	}

	public function set_custom_columns() {
		foreach ( $this->custom_columns as $custom_columns ) {
			$columns = new Custom_Columns( $custom_columns['post_type'], $custom_columns['columns'] );
		}
	}
}
