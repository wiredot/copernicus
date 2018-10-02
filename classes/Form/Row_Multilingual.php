<?php

namespace Wiredot\Copernicus\Form;

use Wiredot\Copernicus\Twig\Twig;
use Wiredot\Copernicus\Fields\Field_Factory;
use Wiredot\Copernicus\Languages;

class Row_Multilingual {

	protected $field;
	protected $id;
	protected $name;
	protected $values;
	protected $template;
	protected $condition;
	protected $in_group;

	public function __construct( $id, $name, $field, $values = array(), $in_group = false ) {
		$this->id = $id;
		$this->name = $name;
		$this->field = $field;
		$this->values = $values;
		$this->in_group = $in_group;

		if ( isset( $field['condition'] ) ) {
			$this->condition = $field['condition'];
		}

		if ( isset( $field['template'] ) ) {
			$this->template = $field['template'];
		}
	}

	public function get_row() {
		$field = $this->get_fields();

		if ( 'checkbox' == $this->field['type'] && ! count( $this->field['options'] ) ) {
			$this->field['type'] = 'checkboxes';
		}

		$class = '';

		if ( $this->template ) {
			$class .= 'Copernicus-template ';

			if ( is_array( $this->template ) ) {
				foreach ( $this->template as $template ) {
					$class .= 'Copernicus-template-' . $template . ' ';
				}
			} else {
				$class .= 'Copernicus-template-' . $this->template . ' ';
			}
		}

		$data = array();

		if ( $this->condition ) {
			$class .= 'Copernicus-condition ';

			foreach ( $this->condition as $field_condition => $value ) {
				$data[] = $field_condition;
				$class .= 'Copernicus-condition-' . $field_condition . ' ';

				if ( is_array( $value ) ) {
					foreach ( $value as $val ) {
						$class .= 'Copernicus-condition-' . $field_condition . '-' . $val . ' ';
					}
				} else {
					$class .= 'Copernicus-condition-' . $field_condition . '-' . $value . ' ';
				}
			}
		}

		$Twig = new Twig;
		return $Twig->twig->render(
			'forms/row.twig',
			array(
				'field' => $field,
				'type' => $this->field['type'],
				'label' => $this->field['label'],
				'description' => $this->field['description'],
				'class' => $class,
				'id' => $this->id,
				'data' => $data,
			)
		);
	}

	public function get_fields() {
		$languages = Languages::get_languages();
		foreach ( $languages as $language_id => $language ) {
			if ( $this->in_group ) {
				$name = substr_replace( $this->name, $language['postmeta_suffix'] . ']', -1 );
			} else {
				$name = $this->name . $language['postmeta_suffix'];
			}
			$field = new Field_Factory( $this->id . $language['postmeta_suffix'], $name, $this->field, $this->values[ $language_id ] );
			$languages[ $language_id ]['field'] = $field->get_field();
		}

		$Twig = new Twig;
		return $Twig->twig->render(
			'forms/multilingual.twig',
			array(
				'id' => $this->id,
				'languages' => $languages,
			)
		);
	}

	public function show_row() {
		echo $this->get_row();
	}
}
