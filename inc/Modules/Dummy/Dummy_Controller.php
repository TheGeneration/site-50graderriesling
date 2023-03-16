<?php

namespace GTheme_Child\Modules\Dummy;

use GTheme\Page_Builder\Components\Module\Module_Controller;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Module class for a dummy module, copy this to create your own
 */
class Dummy_Controller extends Module_Controller {

	/**
	 * @inheritDoc
	 */
	protected $icon = 'umbrella';

	/**
	 * @inheritDoc
	 */
	public function get_title() {
		return esc_html__( 'Dummy module', 'g-theme-child' );
	}

	/**
	 * @inheritDoc
	 */
	public function get_description() {
		return esc_html__( 'Dummy module description', 'g-theme-child' );
	}
}
