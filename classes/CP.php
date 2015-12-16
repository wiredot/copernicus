<?php

namespace Copernicus;

use Copernicus\CP_Admin;
use Copernicus\CP_Field;
use Copernicus\CP_Fieldset;
use Copernicus\Fields\CP_Select;
use Copernicus\Fields\CP_Input;
use Copernicus\Fields\Input\CP_Email;
use Ospinto\dBug;

class CP {

	public function __construct($plugin_file = '') {
		$CP_Config = new CP_Config(get_stylesheet_directory() . '/config/');

		// register custom post types
		$CP_Custom_Post_Type_Factory = new CP_Custom_Post_Type_Factory($CP_Config->get_config('cpt'));

		if (is_admin()) {
			$CP_Admin = new CP_Admin($CP_Config->get_config('mb'));
			$CP_Admin->init();
		}

		$CP_Email = new CP_Email('Name', 'text', 'name1', '', ['placeholder' => 'input asdas']);
		//$CP_Email->show_field();

		$CP_Input = new CP_Input('Input', 'text', 'name1', '', ['placeholder' => 'input asdas']);
		//$CP_Input->show_field();

		$CP_Select = new CP_Select('Select', 'text', 'name1', '');
		//$CP_Select->show_field();

		$CP_Fieldset = new CP_Fieldset([ ['label' => 'ddlabel', 'name' => 'name', 'id' => 'name', 'type' => 'email'] ]);
		new dBug($CP_Fieldset->get_fieldset());

	}
}