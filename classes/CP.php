<?php

namespace Copernicus;

use Copernicus\CP_Field;
use Copernicus\Fields\CP_Select;
use Copernicus\Fields\CP_Input;
use Copernicus\Fields\Input\CP_Email;

class CP {

	public function __construct($plugin_file = '') {
		$Config = new CP_Config(get_stylesheet_directory() . '/config/');

		// register custom post types
		$CPT = new CP_Custom_Post_Type($Config->get_config('cpt'));

		// create meta boxes
		$MB = new CP_Meta_Box($Config->get_config('mb'));

		$input = new CP_Email('Name', 'text', 'name1', '', ['placeholder' => 'input asdas']);
		$input->show_label();
		$input->show_field();

		$input = new CP_Input('Input', 'text', 'name1', '', ['placeholder' => 'input asdas']);
		$input->show_label();
		$input->show_field();

		$select = new CP_Select('Select', 'text', 'name1', '');
		$select->show_label();
		$select->show_field();
	}
}