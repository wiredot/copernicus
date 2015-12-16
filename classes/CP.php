<?php

namespace Copernicus;

use Copernicus\CP_Field;
use Copernicus\CP_Fieldset;
use Copernicus\Fields\CP_Select;
use Copernicus\Fields\CP_Input;
use Copernicus\Fields\Input\CP_Email;
use Ospinto\dBug;

class CP {

	public function __construct($plugin_file = '') {
		$Config = new CP_Config(get_stylesheet_directory() . '/config/');

		// register custom post types
		$custom_post_type_factory = new CP_Custom_Post_Type_Factory($Config->get_config('cpt'));
		add_action('init', array($custom_post_type_factory, 'register_post_types'));

		// create meta boxes
		$meta_box_factory = new CP_Meta_Box_Factory($Config->get_config('mb'));
		add_action('init', array($meta_box_factory, 'create_meta_boxes'));

		$input = new CP_Email('Name', 'text', 'name1', '', ['placeholder' => 'input asdas']);
		//$input->show_field();

		$input = new CP_Input('Input', 'text', 'name1', '', ['placeholder' => 'input asdas']);
		//$input->show_field();

		$select = new CP_Select('Select', 'text', 'name1', '');
		//$select->show_field();

		$fieldset = new CP_Fieldset([ ['label' => 'ddlabel', 'name' => 'name', 'id' => 'name', 'type' => 'email'] ]);
		new dBug($fieldset->get_fieldset());
	}
}