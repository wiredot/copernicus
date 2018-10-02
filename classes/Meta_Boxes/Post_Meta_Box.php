<?php

namespace Wiredot\Copernicus\Meta_Boxes;

use Wiredot\Copernicus\Twig\Twig;
use Wiredot\Copernicus\Form\Row;
use Wiredot\Copernicus\Utilities;
use Wiredot\Copernicus\Form\Row_Multilingual;
use Wiredot\Copernicus\Languages;

class Post_Meta_Box extends Meta_Box {

	public function __construct( $meta_box_id, $meta_box ) {
		$this->meta_box_id = $meta_box_id;
		$this->meta_box = $meta_box;

		// add meta boxes
		add_action( 'admin_init', array( $this, 'add_meta_box' ) );

		// save meta boxes
		if ( is_array( $meta_box['post_type'] ) ) {
			foreach ( $meta_box['post_type'] as $post_type ) {
				add_action( 'save_post_' . $post_type, array( $this, 'save_meta_box' ), 10, 3 );
			}
		} else {
			add_action( 'save_post_' . $meta_box['post_type'], array( $this, 'save_meta_box' ), 10, 3 );
		}
	}

	public function add_meta_box() {
		add_meta_box(
			$this->meta_box_id,
			$this->meta_box['name'],
			array( $this, 'add_meta_box_content' ),
			$this->meta_box['post_type'],
			$this->meta_box['context'],
			$this->meta_box['priority'],
			$this->meta_box
		);

		if ( is_array( $this->meta_box['post_type'] ) ) {
			foreach ( $this->meta_box['post_type'] as $post_type ) {
				add_filter( 'postbox_classes_' . $post_type . '_' . $this->meta_box_id, array( $this, 'add_my_meta_box_classes' ) );
			}
		} else {
			add_filter( 'postbox_classes_' . $this->meta_box['post_type'] . '_' . $this->meta_box_id, array( $this, 'add_my_meta_box_classes' ) );
		}
	}

	public function add_my_meta_box_classes( $classes = array() ) {
		if ( isset( $this->meta_box['template'] ) && $this->meta_box['template'] ) {
			$classes[] = 'Copernicus-template';

			if ( is_array( $this->meta_box['template'] ) ) {
				foreach ( $this->meta_box['template'] as $template ) {
					$classes[] = 'Copernicus-template-' . $template;
				}
			} else {
				$classes[] = 'Copernicus-template-' . $this->meta_box['template'];
			}
		}

		if ( isset( $this->meta_box['condition'] ) && $this->meta_box['condition'] ) {
			$classes[] = 'Copernicus-condition Copernicus-condition-active';

			if ( is_array( $this->meta_box['condition'] ) ) {
				foreach ( $this->meta_box['condition'] as $key => $values ) {
					$classes[] = 'Copernicus-condition-' . $key;

					if ( is_array( $values ) ) {
						foreach ( $values as $value ) {
							$classes[] = 'Copernicus-condition-' . $key . '-' . $value;
						}
					} else {
						$classes[] = 'Copernicus-condition-' . $key . '-' . $values;
					}
				}
			}
		}

		return $classes;
	}

	public function add_meta_box_content( $post, $meta_box ) {
		$this->meta_box = apply_filters( 'copernicus_meta_box_post-' . $this->meta_box_id, $this->meta_box );
		if ( is_array( $this->meta_box['fields'] ) ) {

			$rows = wp_nonce_field( 'Copernicus-mb_' . $this->meta_box_id . '_nonce', 'Copernicus-mb_' . $this->meta_box_id . '_nonce', false, false );

			foreach ( $this->meta_box['fields'] as $key => $meta_box_field ) {
				if ( Languages::has_languages() && isset( $meta_box_field['translate'] ) && $meta_box_field['translate'] ) {
					$values = $this->get_multilingual_values( $post->ID, $key );
					$row = new Row_Multilingual( $key, $key, $meta_box_field, $values );
				} else {
					$value = get_post_meta( $post->ID, $key, true );
					$row = new Row( $key, $key, $meta_box_field, $value );
				}
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

	public function get_multilingual_values( $post_id, $key ) {
		$languages = Languages::get_languages();
		$values = array();
		foreach ( $languages as $language_id => $language ) {
			$values[ $language_id ] = get_post_meta( $post_id, $key . $language['postmeta_suffix'], true );
		}

		return $values;
	}

	public function save_meta_box( $post_id, $post, $update ) {
		// return if autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! isset( $_POST[ 'Copernicus-mb_' . $this->meta_box_id . '_nonce' ] ) || ! wp_verify_nonce( $_POST[ 'Copernicus-mb_' . $this->meta_box_id . '_nonce' ], 'Copernicus-mb_' . $this->meta_box_id . '_nonce' ) ) {
			return;
		}

		// print_r($this->meta_box['fields']);

		foreach ( $this->meta_box['fields'] as $meta_key => $field ) {
			if ( isset( $field['translate'] ) && $field['translate'] ) {
				$languages = Languages::get_languages();
				foreach ( $languages as $language_id => $language ) {
					$this->save_meta_box_field_by_type( $field['type'], $post_id, $meta_key . $language['postmeta_suffix'] );
				}
			} else {
				$this->save_meta_box_field_by_type( $field['type'], $post_id, $meta_key );
			}
		}
	}

	public function save_meta_box_field_by_type( $type, $post_id, $meta_key ) {
		switch ( $type ) {
			case 'upload':
				$this->save_upload_field( $post_id, $meta_key );
				break;
			default:
				$this->save_meta_box_field( $post_id, $meta_key, $type );
				break;
		}
	}

	public function save_meta_box_field( $post_id, $meta_key, $field_type ) {
		if ( isset( $_POST[ $meta_key ] ) ) {
			$value = $_POST[ $meta_key ];

			// echo $field_type;

			if ( 'group' == $field_type ) {
				$sanitized_value = $this->sanitize_group( $this->meta_box['fields'][ $meta_key ]['fields'], $meta_key, $value );
			} else {
				$sanitized_value = $this->sanitize_field( $field_type, $value );
			}

			// save data
			update_post_meta( $post_id, $meta_key, $sanitized_value );
		} else {
			// delete data
			delete_post_meta( $post_id, $meta_key );
		}
	}

	public function save_upload_field( $post_id, $meta_key ) {
		if ( isset( $_POST[ $meta_key ] ) && is_array( $_POST[ $meta_key ] ) ) {
			// validate file ids
			$files = array_map( 'intval', $_POST[ $meta_key ] );
		} else {
			return;
		}

		if ( isset( $_POST[ $meta_key . '_title' ] ) && is_array( $_POST[ $meta_key . '_title' ] ) ) {
			$file_title = array_map( 'sanitize_text_field', $_POST[ $meta_key . '_title' ] );
		}

		if ( isset( $_POST[ $meta_key . '_caption' ] ) && is_array( $_POST[ $meta_key . '_caption' ] ) ) {
			$file_caption = array_map( 'sanitize_text_field', $_POST[ $meta_key . '_caption' ] );
		}

		if ( isset( $_POST[ $meta_key . '_alt' ] ) && is_array( $_POST[ $meta_key . '_alt' ] ) ) {
			$file_alt = array_map( 'sanitize_text_field', $_POST[ $meta_key . '_alt' ] );
		}

		foreach ( $files as $key => $file_id ) {
			$title = '';
			$caption = '';
			$alt = '';

			if ( isset( $file_title[ $key ] ) ) {
				$title = $file_title[ $key ];
			}

			if ( isset( $file_caption[ $key ] ) ) {
				$caption = $file_caption[ $key ];
			}

			if ( isset( $file_alt[ $key ] ) ) {
				$alt = $file_alt[ $key ];
			}

			$this->update_image_data( $file_id, $title, $caption, $alt );
		}

		update_post_meta( $post_id, $meta_key, $files );
	}

	public function update_image_data( $post_id, $title, $caption, $alt = '' ) {
		global $wpdb;

		$wpdb->update(
			$wpdb->posts,
			array(
				'post_title' => $title,
				'post_excerpt' => $caption,
			),
			array(
				'ID' => $post_id,
			)
		);

		if ( $alt ) {
			update_post_meta( $post_id, '_wp_attachment_image_alt', $alt );
		} else {
			delete_post_meta( $post_id, '_wp_attachment_image_alt' );
		}
	}

	public function sanitize_field( $field_type, $value ) {
		// print_r($field_type);
		switch ( $field_type ) {
			case 'textarea':
				$sanitized_value = sanitize_textarea_field( $value );
				break;
			case 'textarea':
				$sanitized_value = sanitize_textarea_field( $value );
				break;
			case 'editor':
				$sanitized_value = wp_kses_post( $value );
				break;
			default:
				if ( is_array( $value ) ) {
					$sanitized_value = Utilities::array_map_r( 'sanitize_text_field', $value );
				} else {
					$sanitized_value = sanitize_text_field( $value );
				}
				break;
		}

		return $sanitized_value;
	}

	public function sanitize_group( $fields, $meta_key, $values ) {
		$sanitized_value = array();

		if ( ! is_array( $values ) ) {
			return '';
		}

		foreach ( $values as $vkey => $value ) {
			foreach ( $fields as $key => $field ) {
				if ( 'group' == $field['type'] ) {
					if ( isset( $value[ $key ] ) ) {
						$this_value = $value[ $key ];
					} else {
						$this_value = '';
					}
					// print_r($this_value);
					$sanitized_value[ $vkey ][ $key ] = $this->sanitize_group( $field['fields'], $key, $this_value );
					// print_r($sanitized_value);
				} else {
					if ( isset( $value[ $key ] ) ) {
						$sanitized_value[ $vkey ][ $key ] = $this->sanitize_field( $field['type'], $value[ $key ] );
					}
				}
			}
		}

		return $sanitized_value;
	}
}
