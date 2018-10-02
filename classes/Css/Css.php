<?php

namespace Wiredot\Copernicus\Css;

class Css {

	private $name;
	private $files;
	private $mode;
	private $dependencies;
	private $version;
	private $media;

	public function __construct( $name, $files, $mode = 'front', $dependencies = array(), $version = null, $media = 'all' ) {
		$this->name = $name;
		$this->files = $files;
		$this->mode = $mode;
		$this->dependencies = $dependencies;
		$this->version = $version;
		$this->media = $media;
	}

	public function register_css_files() {
		if ( 'front' == $this->mode ) {
			add_filter( 'wp_enqueue_scripts', array( $this, 'register_css_file' ) );
		} else {
			add_filter( 'admin_enqueue_scripts', array( $this, 'register_css_file' ) );
		}
	}

	public function register_css_file() {
		if ( is_array( $this->files ) ) {
			foreach ( $this->files as $css_name => $css_link ) {
				$this->display_css_file( $css_name, $css_link, $this->dependencies, $this->version, $this->media );
			}
		} else {
			$this->display_css_file( $this->name, $this->files, $this->dependencies, $this->version, $this->media );
		}
	}

	private function display_css_file( $name, $file, $dependencies, $version, $media ) {
		wp_register_style( $name, $file, $dependencies, $version, $media );
		wp_enqueue_style( $name );
	}
}
