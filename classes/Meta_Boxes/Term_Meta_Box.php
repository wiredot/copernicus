<?php

namespace Wiredot\Copernicus\Meta_Boxes;

use Wiredot\Copernicus\Twig\Twig;
use Wiredot\Copernicus\Form\Row;

class Term_Meta_Box extends Meta_Box {

	public function __construct( $meta_box_id, $meta_box ) {
		$this->meta_box_id = $meta_box_id;
		$this->meta_box = $meta_box;

		// save meta boxes
		if ( is_array( $meta_box['taxonomy'] ) ) {
			foreach ( $meta_box['taxonomy'] as $taxonomy ) {
				add_action( $taxonomy . '_add_form_fields', array( $this, 'add_form_fields' ), 10, 3 );
				add_action( $taxonomy . '_edit_form_fields', array( $this, 'edit_form_fields' ), 10, 2 );

				add_action( 'edited_' . $taxonomy, array( $this, 'update_term_meta' ), 10, 2 );
				add_action( 'created_' . $taxonomy, array( $this, 'save_term_meta' ), 10, 2 );
			}
		} else {
			add_action( $meta_box['taxonomy'] . '_add_form_fields', array( $this, 'add_form_fields' ), 10, 3 );
			add_action( $meta_box['taxonomy'] . '_edit_form_fields', array( $this, 'edit_form_fields' ), 10, 2 );

			add_action( 'edited_' . $meta_box['taxonomy'], array( $this, 'update_term_meta' ), 10, 2 );
			add_action( 'created_' . $meta_box['taxonomy'], array( $this, 'save_term_meta' ), 10, 2 );
		}
	}

	public function add_form_fields( $taxonomy ) {
		if ( is_array( $this->meta_box['fields'] ) ) {
			$rows = wp_nonce_field( 'Copernicus-tmb_' . $this->meta_box_id . '_nonce', 'Copernicus-tmb_' . $this->meta_box_id . '_nonce', false, false );

			foreach ( $this->meta_box['fields'] as $key => $meta_box_field ) {
				$row = new Row( $key, $key, $meta_box_field );
				$rows .= $row->get_row();
			}

			$Twig = new Twig;
			echo $Twig->twig->render(
				'forms/meta_box.twig',
				array(
					'rows' => $rows,
				)
			);
		}
	}

	public function edit_form_fields( $term, $taxonomy ) {
		if ( is_array( $this->meta_box['fields'] ) ) {
			$rows = wp_nonce_field( 'Copernicus-tmb_' . $this->meta_box_id . '_nonce', 'Copernicus-tmb_' . $this->meta_box_id . '_nonce', false, false );

			foreach ( $this->meta_box['fields'] as $key => $meta_box_field ) {
				$value = get_term_meta( $term->term_id, $key, true );
				$row = new Row( $key, $key, $meta_box_field, $value );
				$rows .= $row->get_row();
			}

			$Twig = new Twig;
			echo $Twig->twig->render(
				'forms/meta_box.twig',
				array(
					'rows' => $rows,
				)
			);
		}
	}

	public function save_term_meta( $term_id, $tt_id ) {
		if ( is_array( $this->meta_box['fields'] ) ) {

			foreach ( $this->meta_box['fields'] as $key => $meta_box_field ) {
				if ( isset( $_POST[ $key ] ) ) {
					add_term_meta( $term_id, $key, $_POST[ $key ] );
				}
			}
		}
	}

	public function update_term_meta( $term_id, $tt_id ) {
		if ( is_array( $this->meta_box['fields'] ) ) {

			foreach ( $this->meta_box['fields'] as $key => $meta_box_field ) {
				if ( isset( $_POST[ $key ] ) ) {
					update_term_meta( $term_id, $key, $_POST[ $key ] );
				} else {
					delete_term_meta( $term_id, $key );
				}
			}
		}
	}
}
