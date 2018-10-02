<?php

namespace Wiredot\Copernicus\Twig;

use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_SimpleFunction;

class Twig {

	public $twig;

	private $directories = array();

	public function __construct() {
		$this->directories = $this->get_directories();

		$loader = new Twig_Loader_Filesystem( $this->directories );
		$environment = new Twig_Environment( $loader );

		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			$debug_extension = new Twig_Extension_Debug();
			$environment->addExtension( $debug_extension );
			$environment->enableDebug();
		}

		$environment->registerUndefinedFunctionCallback( array( $this, 'undefined_function' ) );

		$environment->addTokenParser( new Loop_Token_Parser() );

		$this->twig = $environment;
	}

	public function undefined_function( $function_name ) {
		if ( function_exists( $function_name ) ) {
			return new Twig_SimpleFunction(
				$function_name,
				function () use ( $function_name ) {
					ob_start();
					$return = call_user_func_array( $function_name, func_get_args() );
					$echo   = ob_get_clean();
					return empty( $echo ) ? $return : $echo;
				},
				array( 'is_safe' => array( 'all' ) )
			);
		}
		return false;
	}

	private function get_directories() {
		$directories = array();

		if ( is_dir( get_template_directory() . '/templates/' ) ) {
			$directories[] = get_template_directory() . '/templates/';
		}

		$active_plugins = apply_filters( 'cp_active_plugins', get_option( 'active_plugins' ) );

		if ( $active_plugins ) {
			foreach ( $active_plugins as $plugin ) {
				if ( is_dir( WP_PLUGIN_DIR . '/' . plugin_dir_path( $plugin ) . 'templates/' ) ) {
					$directories[] = WP_PLUGIN_DIR . '/' . plugin_dir_path( $plugin ) . 'templates/';
				}
			}
		}

		if ( is_dir( CP_DIR . 'templates/' ) ) {
			$directories[] = CP_DIR . 'templates/';
		}

		return apply_filters( 'cp_twig_directories', $directories );
	}
}
