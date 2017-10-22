<?php

namespace Wiredot\Copernicus;

use Wiredot\Preamp\Twig;

class Header {

	private function __construct() {
	}

	public static function show_header() {
		$Twig = new Twig;
		echo $Twig->twig->render( 'header.twig' );
	}
}
