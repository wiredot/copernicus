<?php

namespace Wiredot\Copernicus\Settings;

class Section_Factory {

	private $sections;
	private $options_prefix;

	function __construct( $sections, $options_prefix ) {
		$this->sections = $sections;
		$this->options_prefix = $options_prefix;
	}

	public function get_section( $tab ) {
		if ( ! is_array( $this->sections ) ) {
			return array();
		}

		foreach ( $this->sections as $id => $s ) {
			if ( $s['tab'] == $tab ) {
				$Section = $this->init_section( $id );
				return $Section->get_section();
			}
		}

		return null;
	}

	public function save_section( $tab ) {
		if ( ! is_array( $this->sections ) ) {
			return;
		}

		foreach ( $this->sections as $id => $s ) {
			if ( $s['tab'] == $tab ) {
				$Section = $this->init_section( $id );
				$Section->save_section();
				return $Section->get_section();
			}
		}
	}

	public function init_section( $id ) {
		return new Section( $id, $this->sections[ $id ]['name'], $this->sections[ $id ]['description'], $this->sections[ $id ]['fields'], $this->options_prefix );
	}
}
