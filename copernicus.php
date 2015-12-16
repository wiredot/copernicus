<?php
/*
  Plugin Name: Copernicus
  Plugin URI:  http://copernicus.wiredot.com/
  Description: WordPress Framework Plugin
  Author: wiredot
  Version: 2.0.0
  Author URI: http://wiredot.com/
  License: GPLv2 or later
 */

// load composer libraries
require __DIR__ . '/vendor/autoload.php';

define( 'CP_PATH', dirname( __FILE__ ) );
define( 'CP_URL', plugin_dir_url( __FILE__ ) );

use Copernicus\CP;
use Copernicus\CP_Field;
use Copernicus\Fields\Input\CP_Email;
use Copernicus\Fields\CP_Select;
use Copernicus\Fields\Factory;
use Ospinto\dBug;

$CP = new CP();

$input = new CP_Email('Name', 'text', 'name1', '', ['placeholder' => 'input asdas']);
$input->show_label();
$input->show_field();

$select = new CP_Select('Select', 'text', 'name1', '');
$select->show_label();
$select->show_field();