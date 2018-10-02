<?php

namespace Wiredot\Copernicus\Taxonomies;

class Taxonomy {

	private $taxonomy;
	private $post_type;
	private $args;

	function __construct( $taxonomy, $post_type, $args ) {
		$this->taxonomy = $taxonomy;
		$this->post_type = $post_type;
		$this->args = $args;

		add_action( 'after_setup_theme', array( $this, 'register_taxonomy' ) );
	}

	public function register_taxonomy() {
		register_taxonomy(
			$this->taxonomy,
			$this->post_type,
			$this->args
		);
	}
}
