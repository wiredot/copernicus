<?php

namespace Wiredot\Copernicus;

class Config {

	private static $initialized = false;

	private static $directories = array();

	private static $config = array();

	private static function initialize() {
		if ( self::$initialized ) {
			return;
		}

		self::$directories = self::get_directories();
		self::$config = self::load_directories();

		self::$initialized = true;
	}

	private static function get_directories() {
		$directories['theme'] = array(
			'directory' => get_template_directory() . '/config/',
			'url' => get_template_directory_uri(),
		);

		$active_plugins = apply_filters( 'cp_active_plugins', get_option( 'active_plugins' ) );

		if ( $active_plugins ) {
			foreach ( $active_plugins as $plugin ) {
				$directories[] = array(
					'directory' => WP_PLUGIN_DIR . '/' . plugin_dir_path( $plugin ) . 'config/',
					'url' => plugin_dir_url( $plugin ),
				);
			}
		}

		return apply_filters( 'cp_config_directories', $directories );
	}

	private static function load_directories() {
		$config = array();

		foreach ( self::$directories as $config_directory ) {
			$config_part = self::load_directory( $config_directory['directory'], $config_directory['url'] );

			if ( is_array( $config_part ) ) {
				$config = array_replace_recursive( $config, $config_part );
			}
		}

		return apply_filters( 'cp_config', $config );
	}

	private static function load_directory( $directory, $url ) {
		$config = array();

		// get all files from config folder
		if ( file_exists( $directory ) && $handle = opendir( $directory ) ) {

			// for each file with .config.php extension
			while ( false !== ( $filename = readdir( $handle ) ) ) {
				if ( '.' == $filename || '..' == $filename ) {
					continue;
				}

				$config_part = array();
				if ( is_dir( $directory . $filename ) ) {
					$config_part = self::load_directory( $directory . $filename . '/', $url );
				} else if ( preg_match( '/.config.php$/', $filename ) ) {
					$config_part = self::load_config_file( $directory . $filename );
				}

				if ( isset( $config_part['css'] ) ) {
					foreach ( $config_part['css'] as $key => $config_css ) {
						$config_part['css'][ $key ]['url'] = $url;
					}
				}

				if ( isset( $config_part['js'] ) ) {
					foreach ( $config_part['js'] as $key => $config_js ) {
						$config_part['js'][ $key ]['url'] = $url;
					}
				}

				if ( count( $config_part ) ) {
					$config = array_replace_recursive( $config, $config_part );
				}
			}
			closedir( $handle );
		}

		return $config;
	}

	private static function load_config_file( $filename ) {
		if ( file_exists( $filename ) ) {

			// get config array from file
			require_once $filename;
			if ( isset( $config ) ) {
				return $config;
			}
		}

		return null;
	}

	public static function get_config( $key = null ) {
		self::initialize();

		if ( ! $key ) {
			return self::$config;
		}

		if ( isset( self::$config[ $key ] ) ) {
			return self::$config[ $key ];
		}

		return null;
	}
}
