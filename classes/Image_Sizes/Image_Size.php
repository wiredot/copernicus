<?php

namespace Wiredot\Copernicus\Image_Sizes;

class Image_Size {

	private $name;
	private $width;
	private $height;
	private $crop;

	public function __construct( $name, $width, $height, $crop ) {
		$this->name = $name;
		$this->width = $width;
		$this->height = $height;
		$this->crop = $crop;
	}

	public function add_image_size() {
		add_image_size( $this->name, $this->width, $this->height, $this->crop );
	}
}
