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

use Copernicus\CP;
use Copernicus\CP_Field;
use Copernicus\Fields\CP_Input;
use Copernicus\Fields\Factory;
use Ospinto\dBug;

$CP = new CP();

$input = new CP_Input('Name', ['asda', 'asddda']);
echo $input->show_label();
echo $input->get_options();
echo $input->show_field();