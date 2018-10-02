<?php

namespace Wiredot\Copernicus\Fields;

use Wiredot\Copernicus\Twig\Twig;
use Wiredot\Copernicus\Form\Row;
use Wiredot\Copernicus\Form\Row_Multilingual;
use Wiredot\Copernicus\Languages;

class Group {

	protected $label;
	protected $name;
	protected $id;
	protected $value;
	protected $fields;
	protected $size;

	public function __construct( $label, $name, $id, $value, $fields ) {
		$this->label = $label;
		$this->name = $name;
		$this->id = $id;
		$this->value = $value;
		$this->fields = $fields;
	}

	public function get_field() {
		$Twig = new Twig;

		$rows = '';

		$next_key = 1;

		if ( is_array( $this->value ) ) {
			$max_key = max( array_keys( $this->value ) );
			$next_key = $max_key + 1;
		}

		$group_items = $this->get_group_items( $this->name, $this->fields, $this->value );

		$new_group_item = '';

		foreach ( $this->fields as $name => $field ) {
			if ( Languages::has_languages() && isset( $field['translate'] ) && $field['translate'] ) {
				$row = new Row_Multilingual( $this->name . '_#_#_' . $name, 'Copernicus_new_' . $this->name . '[#_#][' . $name . ']', $field, array(), 1 );
			} else {
				$row = new Row( $this->name . '_#_#_' . $name, 'Copernicus_new_' . $this->name . '[#_#][' . $name . ']', $field, '' );
			}
			$new_group_item .= $row->get_row();
		}

		return $Twig->twig->render(
			'forms/group.twig',
			array(
				'label' => $this->label,
				'name' => $this->name,
				'id' => $this->id,
				'value' => $this->value,
				'group_items' => $group_items,
				'new_group_item' => $new_group_item,
				'next_key' => $next_key,
			)
		);
	}

	public function get_group_items( $group_name, $fields, $values ) {
		$Twig = new Twig;

		if ( ! is_array( $values ) ) {
			return;
		}

		$group_items = '';

		foreach ( $values as $key => $value ) {

			$rows = '';

			foreach ( $fields as $name => $field ) {
				if ( Languages::has_languages() && isset( $field['translate'] ) && $field['translate'] ) {
					$mvalues = array();
					$languages = Languages::get_languages();
					foreach ( $languages as $language_id => $language ) {
						$mvalues[ $language_id ] = $value[ $name . $language['postmeta_suffix'] ];
					}
					$row = new Row_Multilingual( $group_name . '_' . $key . '_' . $name, $group_name . '[' . $key . '][' . $name . ']', $field, $mvalues, 1 );
				} else {
					if ( isset( $value[ $name ] ) ) {
						$item_value = $value[ $name ];
					} else {
						$item_value = '';
					}
					$row = new Row( $group_name . '_' . $key . '_' . $name, $group_name . '[' . $key . '][' . $name . ']', $field, $item_value );
				}
				$rows .= $row->get_row();
			}

			$group_items .= $Twig->twig->render(
				'forms/group_item.twig',
				array(
					'rows' => $rows,
					'group_name' => $group_name,
					'key' => $key,
				)
			);
		}

		return $group_items;
	}
}
