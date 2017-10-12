<?php

namespace Copernicus;

use Copernicus\CP_Admin;
use Copernicus\CP_Field;
use Copernicus\CP_Fieldset;
use Copernicus\Fields\CP_Select;
use Copernicus\Fields\CP_Input;
use Copernicus\Fields\Input\CP_Email;
use Copernicus\CP_i18n;
use Ospinto\dBug;

use \Preamp\Preamp;

class CP {

	private static $instance = null;

	public static $plugin_name = 'Copernicus';
	public static $plugin_version = '2.0.0';

	public function __construct() {
		//$Preamp = Preamp::run(get_template_directory().'/config/');
		// new CP_i18n();
		
		// // register custom post types
		//$CP_Custom_Post_Type_Factory = new CP_Custom_Post_Type_Factory(CP_Config::get_config('cpt'));

		if (is_admin()) {
			// $CP_Admin = new CP_Admin(CP_Config::get_config('mb'));
			//$CP_Admin->init();
		}

		// $CP_Email = new CP_Email('Name', 'text', 'name1', '', ['placeholder' => 'input asdas']);
		// //$CP_Email->show_field();

		// $CP_Input = new CP_Input('Input', 'text', 'name1', '', ['placeholder' => 'input asdas']);
		// //$CP_Input->show_field();

		// $CP_Select = new CP_Select('Select', 'text', 'name1', '');
		// //$CP_Select->show_field();

		// $CP_Fieldset = new CP_Fieldset([ ['label' => 'ddlabel', 'name' => 'name', 'id' => 'name', 'type' => 'email'] ]);
		// //new dBug($CP_Fieldset->get_fieldset());
	}

	public static function run() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof CP ) ) {
			self::$instance = new CP;
		}
		return self::$instance;
	}
}
