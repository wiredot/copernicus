<?php

namespace Wiredot\Copernicus\Meta_Boxes;

use Wiredot\Copernicus\Form\Row;
use Wiredot\Copernicus\Twig\Twig;


class User_Meta_Box extends Meta_Box {

	public function __construct( $meta_box_id, $meta_box ) {
		$this->meta_box_id = $meta_box_id;
		$this->meta_box = $meta_box;

		add_action( 'edit_user_profile', array( $this, 'add_user_meta_boxes' ) );
		add_action( 'show_user_profile', array( $this, 'add_user_meta_boxes' ) );

		add_action( 'profile_update', array( $this, 'update_user_meta' ) );
	}

	public function add_user_meta_boxes( $user ) {
		if ( is_array( $this->meta_box['fields'] ) ) {
			$rows = wp_nonce_field( 'Copernicus-tmb_' . $this->meta_box_id . '_nonce', 'Copernicus-tmb_' . $this->meta_box_id . '_nonce', false, false );

			foreach ( $this->meta_box['fields'] as $key => $meta_box_field ) {
				$value = get_user_meta( $user->ID, $key, true );
				$row = new Row( $key, $key, $meta_box_field, $value );
				$rows .= $row->get_row();
			}

			$Twig = new Twig;
			echo $Twig->twig->render(
				'forms/meta_box.twig',
				array(
					'rows' => $rows,
					'header' => $this->meta_box['name'],
				)
			);
		}
	}

	public function update_user_meta( $user_id ) {
		if ( is_array( $this->meta_box['fields'] ) ) {

			foreach ( $this->meta_box['fields'] as $key => $meta_box_field ) {
				if ( isset( $_POST[ $key ] ) ) {
						update_user_meta( $user_id, $key, $_POST[ $key ] );
				} else {
					delete_user_meta( $user_id, $key );
				}
			}
		}
	}
}
