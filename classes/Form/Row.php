<?php

namespace Wiredot\Copernicus\Form;

use Wiredot\Copernicus\Twig\Twig;
use Wiredot\Copernicus\Fields\Field_Factory;

class Row {

	protected $field;
	protected $id;
	protected $name;
	protected $value;
	protected $template;
	protected $condition;

	public function __construct( $id, $name, $field, $value = '' ) {
		$this->id = $id;
		$this->name = $name;
		$this->field = $field;
		$this->value = $value;

		if ( isset( $field['condition'] ) ) {
			$this->condition = $field['condition'];
		}

		if ( isset( $field['template'] ) ) {
			$this->template = $field['template'];
		}
	}

	public function get_row() {
		if ( ! isset( $this->field['type'] ) ) {
			return;
		}
		$field = new Field_Factory( $this->id, $this->name, $this->field, $this->value );

		if ( ! isset( $this->field['options'] ) ) {
			$this->field['options'] = array();
		}

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

		if ( $this->condition ) {
			$class .= 'Copernicus-condition Copernicus-condition-active ';

			foreach ( $this->condition as $field_condition => $value ) {
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

		if ( ! isset( $this->field['description'] ) ) {
			$this->field['description'] = '';
		}

		$Twig = new Twig;
		return $Twig->twig->render(
			'forms/row.twig',
			array(
				'field' => $field->get_field(),
				'type' => $this->field['type'],
				'label' => $this->field['label'],
				'description' => $this->field['description'],
				'class' => $class,
				'id' => $this->id,
			)
		);
	}

	public function show_row() {
		echo $this->get_row();
	}
}
