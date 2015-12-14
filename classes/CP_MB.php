<?php

namespace Copernicus;

use Ospinto\dBug;

class CP_MB {

	private $mb;

	public function __construct($mb) {
		$this->mb = $mb;

		new dBug($this->mb);
	}
}