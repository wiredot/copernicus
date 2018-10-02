<?php

namespace Wiredot\Copernicus\Admin;

use Wiredot\Copernicus\Twig\Twig;
use Wiredot\Copernicus\Config;
use Wiredot\Copernicus\Settings\Tab_Factory;

class Menu {

	private $page_title;
	private $menu_title;
	private $capability;
	private $menu_slug;
	private $icon_url;
	private $position;
	private $options_prefix;

	function __construct( $page_title, $menu_title, $capability, $menu_slug, $icon_url, $position, $options_prefix ) {
		$this->page_title = $page_title;
		$this->menu_title = $menu_title;
		$this->capability = $capability;
		$this->menu_slug = $menu_slug;
		$this->icon_url = $icon_url;
		$this->position = $position;
		$this->options_prefix = $options_prefix;

		add_action( 'wp_ajax_Copernicus_settings_save_' . $this->menu_slug, array( $this, 'save_settings' ) );
	}

	public function add_settings_page() {
		add_action( 'admin_menu', array( $this, 'add_submenu_page' ) );
	}

	public function add_submenu_page() {
		add_menu_page(
			$this->page_title,
			$this->menu_title,
			$this->capability,
			$this->menu_slug,
			array( $this, 'settings_page' ),
			$this->icon_url,
			$this->position
		);
	}

	public function settings_page() {
		$Twig = new Twig;
		echo $Twig->twig->render(
			'settings/settings.twig',
			array(
				'page_title' => $this->page_title,
				'tabs' => $this->get_tabs(),
				'menu_slug' => $this->menu_slug,
			)
		);
	}

	public function get_tabs() {
		$tabs = array();

		$config = Config::get_config( 'settings' );
		$Tab_Factory = new Tab_Factory( $config['tab'], $this->options_prefix );
		return $Tab_Factory->get_tab( $this->menu_slug );
	}

	public function save_settings() {
		header( 'content-type:application/json' );

		$tab = $_POST['Copernicus-settings-tab'];

		$config = Config::get_config( 'settings' );
		$Tab_Factory = new Tab_Factory( $config['tab'], $this->options_prefix );
		$Tab_Factory->save_tab( $tab );

		$response = array(
			'success' => 1,
			'message' => __( 'Settings Saved!', 'Copernicus' ),
		);
		echo json_encode( $response );
		exit;
	}
}
