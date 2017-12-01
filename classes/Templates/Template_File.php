<?php

namespace Wiredot\Copernicus\Templates;


class Template_File {

	private $id;
	private $name;
	private $post_type;

	public function __construct( $id, $name, $post_type ) {
		$this->id = $id;
		$this->name = $name;
		$this->post_type = $post_type;

		add_filter( 'theme_' . $post_type . '_templates', array( $this, 'add_page_templates' ) );
	}

	public function add_page_templates( $post_templates ) {
		$post_templates[ $this->id ] = $this->name;
		return $post_templates;
	}
}
