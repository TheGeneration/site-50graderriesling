<?php

namespace GTheme_Child\Modules\Review;

use GTheme\Page_Builder\Components\Module\Module_Controller;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Module class for a dummy module, copy this to create your own
 */
class Review_Controller extends Module_Controller {

	/**
	 * @inheritDoc
	 */
	protected $icon = 'star-half-stroke';

	/**
	 * @inheritDoc
	 */
	public function get_title() {
		return esc_html__( 'Reviews', 'g-theme-child' );
	}

	/**
	 * @inheritDoc
	 */
	public function get_description() {
		return esc_html__( 'Reviews description', 'g-theme-child' );
	}
}
