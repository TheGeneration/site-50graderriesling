<?php

namespace GTheme_Child;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class Scripts
 */
class Scripts {

	/**
	 * Init function for adding hooks and filters
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_frontend_scripts' ], 100 );

		add_filter( 'gt_editor_styles_filter', [ $this, 'append_editor_styles' ] );
	}

	/**
	 * Add editor styles to WYSIWYG
	 *
	 * @param array $stylesheets
	 *
	 * @return array
	 */
	public function append_editor_styles( $stylesheets ) {
		$stylesheets[] = get_stylesheet_directory_uri() . '/assets/css/editor.min.css';

		return $stylesheets;
	}

	/**
	 * Enqueue scripts and styles in frontend
	 *
	 * @return void
	 */
	public function enqueue_frontend_scripts() {
		// This file is empty by default
		wp_enqueue_style( Theme::THEME_NAME, get_stylesheet_directory_uri() . '/assets/css/app.min.css', [], Theme::VERSION );
		wp_enqueue_style( 'figtree-css', get_stylesheet_directory_uri() . '/assets/fonts/dm-sans/font.css', [], Theme::VERSION );

		// This file is empty by default
		wp_enqueue_script( Theme::THEME_NAME, get_stylesheet_directory_uri() . '/assets/js/app.min.js', [], Theme::VERSION, true );
	}
}
