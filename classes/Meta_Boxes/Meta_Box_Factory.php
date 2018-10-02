<?php

namespace Wiredot\Copernicus\Meta_Boxes;

class Meta_Box_Factory {

	private $meta_boxes;

	public function __construct( $meta_boxes ) {
		$this->meta_boxes = $meta_boxes;
	}

	public function register_meta_boxes() {
		foreach ( $this->meta_boxes as $type => $type_meta_boxes ) {
			$this->init_meta_boxes( $type, $type_meta_boxes );
		}
	}

	public function init_meta_boxes( $type, $meta_boxes ) {
		foreach ( $meta_boxes as $meta_box_id => $meta_box ) {
			$this->init_meta_box( $type, $meta_box_id, $meta_box );
		}
	}

	public function init_meta_box( $type, $meta_box_id, $meta_box ) {
		if ( ! isset( $meta_box['active'] ) || ! $meta_box['active'] ) {
			return;
		}

		switch ( $type ) {
			case 'post':
				new Post_Meta_Box( $meta_box_id, $meta_box );
				break;

			case 'term':
				new Term_Meta_Box( $meta_box_id, $meta_box );
				break;

			case 'user':
				new User_Meta_Box( $meta_box_id, $meta_box );
				break;
		}
	}
}
