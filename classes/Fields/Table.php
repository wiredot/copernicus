<?php

namespace Wiredot\Copernicus\Fields;

use Wiredot\Copernicus\Twig\Twig;

class Table {

	protected $type;
	protected $name;
	protected $id;
	protected $value;
	protected $table_type;
	protected $cols;
	protected $rows;
	protected $disabled;

	public function __construct( $type, $name, $id, $value, $table_type, $cols, $rows, $disabled, $options ) {
		$this->type = $type;
		$this->name = $name;
		$this->id = $id;
		$this->value = $value;
		$this->table_type = $table_type;
		$this->cols = $cols;
		$this->rows = $rows;
		$this->disabled = $disabled;
		$this->options = $options;
	}

	public function get_field() {
		$Twig = new Twig;

		return $Twig->twig->render(
			'fields/table.twig',
			array(
				'name' => $this->name,
				'id' => $this->id,
				'value' => $this->value,
				'table_type' => $this->table_type,
				'cols' => $this->cols,
				'rows' => $this->rows,
				'disabled' => $this->disabled,
				'options' => $this->options,
			)
		);
	}
}
