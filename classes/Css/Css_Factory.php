<?php

namespace Wiredot\Copernicus\Css;

class Css_Factory {

	private $css_files;

	public function __construct( $css_files ) {
		$this->css_files = $css_files;
	}

	public function register_css_files() {
		if ( ! is_array( $this->css_files ) ) {
			return;
		}

		foreach ( $this->css_files as $name => $css_file ) {
			if ( ! isset( $css_file['files'] ) || ! isset( $css_file['url'] ) ) {
				continue;
			}

			foreach ( $css_file['files'] as $key => $file ) {
				$css_file['files'][ $key ] = $css_file['url'] . $file;
			}

			if ( isset( $css_file['front'] ) && $css_file['front'] ) {
				$mode = 'front';
			} else if ( isset( $css_file['admin'] ) && $css_file['admin'] ) {
				$mode = 'admin';
			} else {
				continue;
			}

			if ( isset( $css_file['media'] ) ) {
				$css_file['media'] = false;
			}

			if ( isset( $css_file['dependencies'] ) ) {
				$css_file['dependencies'] = false;
			}

			if ( isset( $css_file['version'] ) ) {
				$css_file['version'] = null;
			}

			$css = new Css( $name, $css_file['files'], $mode, $css_file['dependencies'], $css_file['version'], $css_file['media'] );
			$css->register_css_files();
		}
	}
}
