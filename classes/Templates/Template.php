<?php

namespace Wiredot\Copernicus\Templates;

use Wiredot\Preamp\Twig;
use Wiredot\Copernicus\Templates\Extension;
use Wiredot\Preamp\Core as Preamp;

class Template {

	public $template_types = array(
		'embed',
		'404',
		'search',
		'taxonomy',
		'frontpage',
		'home',
		'attachment',
		'single',
		'page',
		'singular',
		'category',
		'tag',
		'author',
		'date',
		'archive',
		'commentspopup',
		'paged',
		'index',
	);

	protected $type = '';

	public function __construct() {
		foreach ( $this->template_types as $type ) {
			add_filter( "{$type}_template_hierarchy", array( $this, 'template_hierarchy' ) );
		}

		add_filter( 'template_include', array( $this, 'template_include_twig' ) );
		$this->add_templates();

		$twig_extension = new Extension();
		$Twig = new Twig;
		$Twig->twig->addExtension( $twig_extension );
	}

	public function template_hierarchy( $templates ) {
		$this->type = substr( current_filter(), 0, - 19 ); // Trim '_template_hierarchy' from end.
		$twig_templates = [];

		foreach ( $templates as $php_template ) {
			if ( '.php' === substr( $php_template, strlen( $php_template ) - 4 ) ) {
				$twig_templates[] = substr( $php_template, 0, - 4 ) . '.twig';
				$twig_templates[] = 'templates/' . substr( $php_template, 0, - 4 ) . '.twig';
			} else if ( '.twig' === substr( $php_template, strlen( $php_template ) - 5 ) ) {
				$twig_templates[] = 'templates/' . $php_template;
				$twig_templates[] = substr( $php_template, 0, - 5 ) . '.php';
			}
		}

		return array_merge( $twig_templates, $templates );
	}

	public function template_include( $template ) {
		return apply_filters( 'meadow_query_template', $template, $this->type );
	}

	public function template_include_twig( $template ) {
		if ( '.twig' === substr( $template, - 5 ) ) {
			/** @var \Twig_Environment $twig */

			$twig_extension = new Extension();
			$Twig = new Twig;
			$Twig->twig->addExtension( $twig_extension );
			echo $Twig->twig->render( basename( $template ) );

			// $twig = $this['twig.environment'];
			// echo $twig->render( basename( $template ), apply_filters( 'meadow_context', array() ) );
			return false;
		}

		return $template;
	}

	public function add_templates() {
		$templates = Preamp::get_config( 'template' );

		if ( ! is_array( $templates ) ) {
			return;
		}

		$template_post_type = array();

		foreach ( $templates as $id => $template ) {

			if ( is_array( $template['post_type'] ) ) {
				foreach ( $template['post_type'] as $post_type ) {
					new Template_File( $id, $template['name'], $post_type );
				}
			} else {
				new Template_File( $id, $template['name'], $template['post_type'] );
			}
		}
	}
}