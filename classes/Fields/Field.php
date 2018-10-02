<?php

namespace Wiredot\Copernicus\Fields;

use Wiredot\Copernicus\Twig\Twig;

class Field {

	protected $type;
	protected $label;
	protected $name;
	protected $id;
	protected $value;
	protected $attributes;
	protected $options;

	public function __construct( $label, $name, $id, $value, $attributes, $options = array() ) {
		$this->label = $label;
		$this->name = $name;
		$this->id = $id;
		$this->value = $value;
		$this->attributes = $attributes;
		$this->options = $options;

		if ( isset( $attributes['class'] ) ) {
			$this->attributes['class'] .= ' Copernicus-' . $this->type;
		} else {
			$this->attributes['class'] = 'Copernicus-' . $this->type;
		}
	}

	public function get_field() {
		$Twig = new Twig;

		return $Twig->twig->render(
			'fields/' . $this->type . '.twig',
			array(
				'label' => $this->label,
				'name' => $this->name,
				'id' => $this->id,
				'value' => $this->value,
				'attributes' => $this->attributes,
				'options' => $this->options,
			)
		);
	}
}
