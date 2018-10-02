<?php

namespace Wiredot\Copernicus\Settings;

use Wiredot\Copernicus\Config;

class Tab {

	private $id;
	private $name;
	private $options_prefix;

	public function __construct( $id, $name, $options_prefix ) {
		$this->id = $id;
		$this->name = $name;
		$this->options_prefix = $options_prefix;
	}

	public function get_tab() {
		return array(
			'id' => $this->id,
			'name' => $this->name,
			'sections' => $this->get_sections(),
		);
	}

	public function get_sections() {
		$sections = '';

		$config = Config::get_config( 'settings' );
		$Section_Factory = new Section_Factory( $config['section'], $this->options_prefix );
		$sections .= $Section_Factory->get_section( $this->id );

		return $sections;
	}

	public function save_tab() {
		$config = Config::get_config( 'settings' );
		$Section_Factory = new Section_Factory( $config['section'], $this->options_prefix );
		$Section_Factory->save_section( $this->id );
	}
}
