<?php

namespace GTheme_Child\Modules\Review;

use GTheme\Page_Builder\Components\Module\Module;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Model for the Review module
 */
class Review extends Module {
	protected $casts = [
		'person_review' => 'array',
	];

	/**
	 * Module field
	 *
	 * @var \GTheme\Page_Builder\Components\Module\Module;
	 */
	public $person_review = null;
}
