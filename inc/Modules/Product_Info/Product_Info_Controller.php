<?php

namespace GTheme_Child\Modules\Product_Info;

use GTheme\Page_Builder\Components\Module\Module_Controller;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Module class for a dummy module, copy this to create your own
 */
class Product_Info_Controller extends Module_Controller {

	/**
	 * @inheritDoc
	 */
	protected $icon = 'wine-bottle';

	/**
	 * @inheritDoc
	 */
	public function get_title() {
		return esc_html__( 'Product info', 'g-theme-child' );
	}

	/**
	 * @inheritDoc
	 */
	public function get_description() {
		return esc_html__( 'Product info description', 'g-theme-child' );
	}
}
