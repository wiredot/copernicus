<?php

namespace Copernicus;

use Ospinto\dBug;

class MB {

	private $mb;

	public function __construct($mb) {
		$this->mb = $mb;

		new dBug($this->mb);
	}
}