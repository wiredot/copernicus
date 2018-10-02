<?php

namespace Wiredot\Copernicus\Custom_Post_Types;

class Custom_Post_Type {

	private $post_type;
	private $args;

	function __construct( $post_type = '', $args = array() ) {
		$this->post_type = $post_type;
		$this->args = $args;

		if ( isset( $args['messages'] ) ) {
			add_filter( 'post_updated_messages', array( $this, 'updated_messages' ) );
		}
		add_action( 'init', array( $this, 'register_post_type' ) );
	}

	public function register_post_type() {
		register_post_type( $this->post_type, $this->args );
	}

	public function updated_messages( $messages ) {
		$post = get_post();

		$new_messages = $this->args['messages'];
		$date = date_i18n( __( 'M j, Y @ G:i', 'wp-photo-gallery' ), strtotime( $post->post_date ) );
		$new_messages[9] = str_replace( '%date%', $date, $new_messages[9] );
		if ( isset( $_GET['revision'] ) ) {
			$new_messages[5] = str_replace( '%revision%', $_GET['revision'], $new_messages[5] );
		}

		$messages['wp-photo-gallery'] = $new_messages;

		return $messages;
	}
}
