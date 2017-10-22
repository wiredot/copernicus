<?php

namespace Wiredot\Copernicus;

use Wiredot\Preamp\Twig;

class Footer {

	private function __construct() {
	}

	public static function show_footer() {
		$Twig = new Twig;
		echo $Twig->twig->render( 'footer.twig' );
	}
}
