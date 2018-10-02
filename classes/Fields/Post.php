<?php

namespace Wiredot\Copernicus\Fields;

use \WP_Query;

class Post extends Field {

	protected $type = 'select';

	public function __construct( $label, $name, $id, $value, $attributes, $options = array(), $labels = array(), $arguments = array() ) {
		$this->label = $label;
		$this->name = $name;
		$this->id = $id;
		$this->value = $value;
		$this->attributes = $attributes;
		$this->labels = $labels;
		$this->arguments = $arguments;
		$this->options = $this->get_options();
	}

	public function get_options() {
		$default_arguments = array(
			'posts_per_page' => -1,
			'post_type' => 'page',
		);

		$arguments = array_merge( $default_arguments, $this->arguments );

		$loop_links = new WP_Query( $arguments );
		$posts = $loop_links->posts;
		if ( ! $posts ) {
			return null;
		}

		foreach ( $posts as $key => $p ) {
			if ( 'attachment' != $p->post_type ) {
				$ancestors = get_ancestors( $p->ID, $p->post_type );
				$title = str_repeat( '- ', count( $ancestors ) ) . $p->post_title;
				$posts[ $key ]->post_title = $title;
			}
		}

		$options = array();

		$options[0] = '-- select --';
		foreach ( $posts as $post ) {
			if ( 'any' == $arguments['post_type'] || ( is_array( $arguments['post_type'] ) && count( $arguments['post_type'] ) ) ) {
				$post_type_object = get_post_type_object( $post->post_type );
				$post_type_name = $post_type_object->labels->name;
				$options[ $post_type_name ][ $post->ID ] = $post->post_title;
			} else {
				$options[ $post->ID ] = $post->post_title;
			}
		}

		if ( 'any' == $arguments['post_type'] || ( is_array( $arguments['post_type'] ) && count( $arguments['post_type'] ) ) ) {
			ksort( $options );
		}

		return $options;
	}
}
