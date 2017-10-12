<?php

namespace Copernicus;

abstract class CP_Field {

	protected $label;
	protected $name;
	protected $id;
	protected $attributes = [
		'required' => 0,
		'placeholder' => '',
	];

	protected $value;

	protected $smarty;

	public function __construct( $label, $name, $id, $value = '', $attributes = [] ) {
		$this->label = $label;
		$this->name = $name;
		$this->id = $id;
		$this->value = $value;
		$this->attributes = array_merge( $attributes, $this->attributes );

		$this->init_smarty();
	}

	/**
	 * asd asd asd
	 * @return type
	 */
	public function init_smarty() {
		$this->smarty = (new CP_Smarty())->get_smarty();
		$this->smarty->assign( 'label', $this->label );
		$this->smarty->assign( 'name', $this->name );
		$this->smarty->assign( 'id', $this->id );
		$this->smarty->assign( 'value', $this->value );
		$this->smarty->assign( 'attributes', $this->attributes );
	}

	public function show_field() {
		echo $this->get_field();
	}

	abstract protected function get_field();

}
