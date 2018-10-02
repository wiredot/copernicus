<?php

namespace Wiredot\Copernicus\Settings;

class Tab_Factory {

	private $tabs;
	private $options_prefix;

	function __construct( $tabs, $options_prefix ) {
		$this->tabs = $tabs;
		$this->options_prefix = $options_prefix;
	}

	public function get_tab( $page ) {
		if ( ! is_array( $this->tabs ) ) {
			return array();
		}

		$tabs = array();

		foreach ( $this->tabs as $id => $tab ) {
			if ( $tab['page'] == $page ) {
				$Tab = $this->init_tab( $id );
				$tabs[ $id ] = $Tab->get_tab();
			}
		}
		return $tabs;
	}

	public function save_tab( $id ) {
		if ( isset( $this->tabs[ $id ] ) ) {
			$Tab = $this->init_tab( $id );
			return $Tab->save_tab();
		}
		return null;
	}

	public function init_tab( $id ) {
		return new Tab( $id, $this->tabs[ $id ]['name'], $this->options_prefix );
	}
}
