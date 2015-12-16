<?php

namespace Copernicus;

abstract class CP_Field {

	protected $label;
	protected $name;
	protected $id;
	protected $attributes = ['required' => 0];
	
	protected $value;

	public function __construct($label, $name, $id, $value = '', $attributes = []) {
		$this->label = $label;
		$this->name = $name;
		$this->id = $id;
		$this->value = $value;
		$this->attributes = $attributes;
	}

	public function get_label() {
		return $this->label;
	}

	public function show_label() {
		$smarty = (new CP_Smarty())->get_smarty();
		$smarty->assign('asd', 'asdas');
		echo $this->label;
	}

	public function show_field() {
		echo $this->get_field();
	}

	abstract protected function get_field();

}