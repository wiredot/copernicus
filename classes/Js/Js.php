<?php

namespace Wiredot\Copernicus\Js;

class Js {

	private $mode;
	private $name;
	private $files;
	private $dependencies;
	private $footer;
	private $localize;

	public function __construct( $mode, $name, $files, $dependencies = array(), $footer = false, $localize = null ) {
		$this->mode = $mode;
		$this->name = $name;
		$this->files = $files;
		$this->dependencies = $dependencies;
		$this->footer = $footer;
		$this->localize = $localize;
	}

	public function register_js_files() {
		if ( 'front' == $this->mode ) {
			add_filter( 'wp_enqueue_scripts', array( $this, 'register_js_file' ) );
		} else {
			add_filter( 'admin_enqueue_scripts', array( $this, 'register_js_file' ) );
		}
	}

	public function register_js_file() {
		if ( is_array( $this->files ) ) {
			foreach ( $this->files as $js_name => $js_link ) {
				$this->display_js_file( $js_name, $js_link, $this->dependencies, $this->footer );
			}
		} else {
			$this->display_js_file( $this->name, $this->files, $this->dependencies, $this->footer );
		}
	}

	private function display_js_file( $handle, $src, $dependencies, $footer ) {
		wp_deregister_script( $handle );
		wp_register_script( $handle, $src, $dependencies, false, $footer );
		wp_enqueue_script( $handle );

		if ( is_array( $this->localize ) ) {
			wp_localize_script( $handle, 'Copernicus_js', $this->localize );
		}
	}
}
