<?php

namespace Wiredot\Copernicus\Taxonomies;

class Taxonomy_Factory {

	private $taxonomies;

	function __construct( $taxonomies ) {
		$this->taxonomies = $taxonomies;
	}

	public function register_taxonomies() {
		if ( ! is_array( $this->taxonomies ) ) {
			return;
		}

		foreach ( $this->taxonomies as $taxonomy_id => $taxonomy ) {
			new Taxonomy( $taxonomy_id, $taxonomy['post_type'], $taxonomy['args'] );
		}
	}
}
