<?php

namespace Wiredot\Copernicus\Fields;

use Wiredot\Copernicus\Twig\Twig;

class Upload extends Field {

	public function __construct( $label, $name, $id, $value, $attributes, $options, $labels ) {
		$this->label = $label;
		$this->name = $name;
		$this->id = $id;
		$this->value = $value;
		$this->attributes = $attributes;
		$this->labels = $labels;
	}

	public function get_field() {
		$Twig = new Twig;

		return $Twig->twig->render(
			'fields/upload.twig',
			array(
				'label' => $this->label,
				'labels' => $this->labels,
				'name' => $this->name,
				'id' => $this->id,
				'value' => $this->value,
				'attributes' => $this->attributes,
			)
		);
	}
}
