<?php

namespace Wiredot\Copernicus\Fields;

use Wiredot\Copernicus\Twig\Twig;

class Input {

	protected $type;
	protected $name;
	protected $id;
	protected $value;
	protected $attributes;
	protected $size;
	protected $prefix;
	protected $suffix;
	protected $default;

	public function __construct( $type, $name, $id, $value, $attributes, $size = '', $prefix = '', $suffix = '', $default = '' ) {
		$this->type = $type;
		$this->name = $name;
		$this->id = $id;
		$this->value = $value;
		$this->attributes = $attributes;
		$this->size = $size;
		$this->prefix = $prefix;
		$this->suffix = $suffix;
		$this->default = $default;

		if ( $size ) {
			if ( isset( $this->attributes['class'] ) ) {
				$this->attributes['class'] .= ' ' . $size . '-text';
			} else {
				$this->attributes['class'] = $size . '-text';
			}
		}

		if ( isset( $attributes['class'] ) ) {
			$this->attributes['class'] .= ' Copernicus-' . $this->type;
		} else {
			$this->attributes['class'] = 'Copernicus-' . $this->type;
		}
	}

	public function get_field() {
		$Twig = new Twig;

		return $Twig->twig->render(
			'fields/input.twig',
			array(
				'type' => $this->type,
				'name' => $this->name,
				'id' => $this->id,
				'value' => $this->value,
				'attributes' => $this->attributes,
				'prefix' => $this->prefix,
				'suffix' => $this->suffix,
				'default' => $this->default,
			)
		);
	}
}
