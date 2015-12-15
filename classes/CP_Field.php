<?php

namespace Copernicus;

abstract class CP_Field {

	protected $label;
	protected $attributes;

	public function __construct($label) {
		$this->label = $label;
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