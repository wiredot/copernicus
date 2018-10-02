<?php

namespace Wiredot\Copernicus\Settings;

use Wiredot\Copernicus\Core;
use Wiredot\Copernicus\Languages;
use Wiredot\Copernicus\Twig\Twig;
use Wiredot\Copernicus\Utilities;
use Wiredot\Copernicus\Form\Row;
use Wiredot\Copernicus\Form\Row_Multilingual;

class Section {

	private $id;
	private $name;
	private $description;
	private $fields;
	private $options_prefix;

	public function __construct( $id, $name, $description, $fields, $options_prefix ) {
		$this->id = $id;
		$this->name = $name;
		$this->description = $description;
		$this->fields = $fields;
		$this->options_prefix = $options_prefix;
	}

	public function get_section() {
		$rows = $this->get_rows();
		$Twig = new Twig;
		return $Twig->twig->render(
			'settings/section.twig',
			array(
				'id' => $this->id,
				'name' => $this->name,
				'description' => $this->description,
				'rows' => $rows,
			)
		);
	}

	public function get_rows() {
		$rows = '';
		foreach ( $this->fields as $key => $field ) {
			if ( Languages::has_languages() && isset( $field['translate'] ) && $field['translate'] ) {
				$values = array();
				$Row = new Row_Multilingual( $key, $key, $field, $values );
			} else {
				$value = get_option( $this->options_prefix . $key );
				$Row = new Row( $key, $key, $field, $value );
			}
			$rows .= $Row->get_row();
		}

		return $rows;
	}

	public function save_section() {
		foreach ( $this->fields as $key => $field ) {
			if ( ! isset( $_POST[ $key ] ) ) {
				delete_option( $key );
			} else {
				$value = $_POST[ $key ];
				switch ( $field['type'] ) {
					default:
						if ( is_array( $value ) ) {
							$sanitized_value = Utilities::array_map_r( 'sanitize_text_field', $value );
						} else {
							$sanitized_value = sanitize_text_field( $value );
						}
						break;
				}

				$autoload = false;
				if ( isset( $field['autoload'] ) && $field['autoload'] ) {
					$autoload = true;
				}
				update_option( $this->options_prefix . $key, $sanitized_value, $autoload );
			}
		}
	}
}
