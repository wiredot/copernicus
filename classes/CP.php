<?php

namespace Wiredot\Copernicus;

use Wiredot\Copernicus\Templates\Template_Hierarchy;
use Wiredot\Copernicus\Custom_Post_Types\Custom_Post_Type_Factory;
use Wiredot\Copernicus\Meta_Boxes\Meta_Box_Factory;
use Wiredot\Copernicus\Taxonomies\Taxonomy_Factory;
use Wiredot\Copernicus\Sidebars\Sidebar_Factory;
use Wiredot\Copernicus\Nav_Menus\Nav_Menu_Factory;
use Wiredot\Copernicus\Image_Sizes\Image_Size_Factory;
use Wiredot\Copernicus\Css\Css_Factory;
use Wiredot\Copernicus\Js\Js_Factory;
use Wiredot\Copernicus\Settings\Settings_Factory;

class CP {

	private static $instance = null;

	private function __construct( $directory, $url ) {
		define( 'CP_DIR', $directory );
		define( 'CP_URL', $url );

		new Template_Hierarchy;

		$cpt = new Custom_Post_Type_Factory( Config::get_config( 'custom_post_type' ) );
		$cpt->register_custom_post_types();

		$mb = new Meta_Box_Factory( Config::get_config( 'meta_box' ) );
		$mb->register_meta_boxes();

		$taxonomy = new Taxonomy_Factory( Config::get_config( 'taxonomy' ) );
		$taxonomy->register_taxonomies();

		$sidebars = new Sidebar_Factory( Config::get_config( 'sidebar' ) );
		$sidebars->register_sidebars();

		$nav_menus = new Nav_Menu_Factory( Config::get_config( 'nav_menu' ) );
		$nav_menus->register_nav_menus();

		$image_size = new Image_Size_Factory( Config::get_config( 'image_size' ) );
		$image_size->add_image_sizes();

		$css = new Css_Factory( Config::get_config( 'css' ) );
		$css->register_css_files();

		$js = new Js_Factory( Config::get_config( 'js' ) );
		$js->register_js_files();

		$settings = new Settings_Factory( Config::get_config( 'settings' ) );
		$settings->add_settings();
	}

	public static function run( $directory, $url ) {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof CP ) ) {
			self::$instance = new CP( $directory, $url );
		}
		return self::$instance;
	}
}
