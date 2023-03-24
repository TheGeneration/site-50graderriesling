<?php

namespace GTheme_Child;

use GTheme_Child\Modules\Dummy\Dummy_Controller;
use GTheme_Child\Modules\Product_Info\Product_Info_Controller;
use GTheme_Child\Modules\Review\Review_Controller;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! defined( 'GTHEME_CHILD_DIR' ) ) {
	define( 'GTHEME_CHILD_DIR', __DIR__ );
}

if ( ! defined( 'GTHEME_CHILD_FILE' ) ) {
	define( 'GTHEME_CHILD_FILE', __DIR__ );
}

if ( ! class_exists( 'GTheme_Child\\Theme' ) ) :

	/**
	 * Class to capsulate functions
	 */
	class Theme {

		/**
		 * @var string
		 */
		const THEME_NAME = 'g-theme-child';

		/**
		 * @var string
		 *
		 */
		const VERSION = '1.0.1';

		/**
		 * The single instance of the class.
		 *
		 * @var object
		 */
		protected static $instance = null;

		/**
		 * Get class instance.
		 *
		 * @return static Instance.
		 */
		public final static function get_instance() {
			if ( static::$instance === null ) {
				static::$instance = new static();
			}

			return static::$instance;
		}

		/**
		 * Generation_Theme_Child constructor
		 *
		 * @return void
		 */
		public function __construct() {
			$this->load_dependencies();
		}

		/**
		 * Load dependencies and init all modules
		 *
		 * @return void
		 */
		public function run() {
			$this->init_modules();
			$this->add_hooks();
		}

		/**
		 * Load dependencies
		 *
		 * @return void
		 */
		public function load_dependencies() {
			require_once __DIR__ . '/vendor/autoload.php';
		}

		/**
		 * Initialize modules containing child-theme functionality
		 *
		 * @return void
		 */
		public function init_modules() {
			// Language functionality
			$i18n = new I18n();
			$i18n->init();

			// Scripts
			$scripts = new Scripts();
			$scripts->init();

			// Shortcodes
			$shortcodes = new Shortcodes();
			$shortcodes->init();
		}

		/**
		 * Add hooks
		 *
		 * @return void
		 */
		public function add_hooks() {
			// Custom modules filter
			add_filter( 'gt_modules', [ $this, 'theme_modules' ], 20, 1 );

			// Custom style formats filter
			add_filter( 'style_formats_filter', [ $this, 'append_style_formats' ] );

			// Blurb module item elements filter:
			add_filter( 'gt_module_blurb_elements', [ $this, 'blurb_elements' ], 10, 1 );

			// If using a blurb item template, use this filter:
			// add_filter( 'gt_module_blurb_{custom-blurb}_elements', [ $this, '{custom_blurb}_elements' ], 10, 2 );

			// Listing module item elements filter:
			add_filter( 'gt_module_listing_item_elements', [ $this, 'listing_item_elements' ], 10, 1 );

			// If using a listing item template, use this filter:
			// add_filter( 'gt_module_listing_item_{listing-item-template}_elements', [ $this, 'listing_item{listing-item-template}_elements' ], 10, 2 );

			// Additional date formats
			// add_filter( 'gt_date_format_options', [ $this, 'add_date_formats' ], 10, 1 );

			// Use WYSIWYG for posts
			add_filter( 'gt_post_page_builder_mode', '__return_false' );

			// Remove Gravity form submit anchor link
			add_filter( 'gform_confirmation_anchor', '__return_false' );

			add_filter( 'gt_filter_user_roles', [ $this, 'client_feedback_role' ] );

			add_filter( 'gt_color_picker_options', [ $this, 'color_picker_options' ] );

			// Add menu arrow to menu items with child-elements
			add_filter( 'walker_nav_menu_start_el', [ $this, 'parent_menu_dropdown' ], 10, 4 );

			// Add mobile menu overlay to mobile menu section
			add_action( 'gt_section_mobile_menu_before_content', [ $this, 'mobile_menu_overlay' ], 10, 1 );

			// Replace "input" with "button" for submits in Gravity Forms
			add_filter( 'gform_submit_button', [ $this, 'gravity_forms_input_to_button_submit' ], 10, 2 );

		}

		/**
		 * Add color picker options
		 *
		 * @param string[] $options
		 * @return string[]
		 */
		public function color_picker_options( array $options ) {
			// TODO Replace this with the client colors
			$options = array_merge(
				$options,
				[
					// 'color-variable' => [ 'Color hex example in admin: #fff', esc_html__( 'Color name in admin for client: Light Green', 'g-theme-child' ) ],
					'my-variable'   => [ '#fff', esc_html__( 'White', 'g-theme-child' ) ],
					// 'color-variable' => 'Color hex example in admin: #000',
					'my-variable-2' => '#fff',
				]
			);

			return $options;
		}

		/**
		 * Add a client feedback role
		 *
		 * @param array $roles
		 * @return array
		 */
		public function client_feedback_role( array $roles ) {
			$roles[] = [
				'role'               => 'client_feedback',
				'display_name'       => esc_html__( 'Client Feedback', 'g-theme-child' ),
				'hide_admin_notices' => true,
				'level'              => 1, // Used to prevent self-promotion
				'upload_limit'       => [
					'image'           => 1,
					'application/pdf' => 5,
					'video'           => 10,
				],
				'capabilities'       => [
					'level_1' => true,
					'read'    => true,
				],
			];

			return $roles;
		}

		/**
		 * Registering of modules in child-theme
		 *
		 * @param array $modules
		 *
		 * @return array
		 */
		public function theme_modules( array $modules ) {
			return array_merge(
				$modules,
				[
					Dummy_Controller::class,
					Product_Info_Controller::class,
					Review_Controller::class,
				]
			);
		}

		/**
		 * Add style formats to the WYSIWYG
		 *
		 * @param array $style_formats
		 *
		 * @return array
		 */
		public function append_style_formats( array $style_formats ) {
			if ( isset( $style_formats['buttons']['items'] ) ) {
				$style_formats['buttons']['items'] = array_merge(
					$style_formats['buttons']['items'],
					[
						[
							'title'    => esc_html__( 'Tertiary', 'g-theme-child' ),
							'selector' => 'a',
							'classes'  => 'btn btn-tertiary',
						],
					]
				);
			}

			if ( isset( $style_formats['headings']['items'] ) ) {
				$style_formats['headings']['items'] = array_merge(
					$style_formats['headings']['items'],
					[
						[
							'title'    => esc_html__( 'Accent heading', 'g-theme-child' ),
							'selector' => 'h6,h5,h4,h3,h2,h1',
							'classes'  => 'heading-accent',
						],
					]
				);
			}

			return array_merge(
				$style_formats,
				[
					// [
					//  'title'    => esc_html__( 'Text', 'g-theme-child' ),
					//  'selector' => 'p, ul, ol',
					//  'classes'  => 'class-name-text',
					// ],
					// [
					//  'title'   => esc_html__( 'CTA Inline Link', 'g-theme-child' ),
					//  'inline'  => 'span',
					//  'classes' => 'class-name-on-element',
					// ],
					// [
					//  'title'   => esc_html__( 'CTA Inline Link', 'g-theme-child' ),
					//  'block'   => 'div',
					//  'classes' => 'class-name-on-element',
					// ],
				]
			);
		}

		/**
		 * Restructuring of the listing item elements
		 *
		 * @param array $listing_item_elements
		 *
		 * @return array
		 */
		public function listing_item_elements( array $listing_item_elements ) {
			$image_wrapper_elements = [ 'image' ];
			$text_wrapper_elements = [
				'date',
				'terms',
				'title',
				'excerpt',
				'read_more',
			];

			$image_wrapper = array_intersect( $image_wrapper_elements, $listing_item_elements );
			$text_wrapper = array_intersect( $text_wrapper_elements, $listing_item_elements );

			$elements = [];

			if ( ! empty( $image_wrapper ) ) {
				$elements = $image_wrapper;
			}

			if ( ! empty( $text_wrapper ) ) {
				$elements['gt-listing-item-text-wrapper'] = $text_wrapper;
			}

			return $elements;
		}

		/**
		 * Modify elements of the blurb module
		 *
		 * @param array $blurb_elements
		 *
		 * @return array
		 */
		public function blurb_elements( array $blurb_elements ) {
			$image_wrapper_elements = [
				'icon',
				'image',
			];
			$text_wrapper_elements = [
				'heading',
				'subheading',
				'text',
			];

			$image_wrapper = array_intersect( $image_wrapper_elements, $blurb_elements );
			$text_wrapper = array_intersect( $text_wrapper_elements, $blurb_elements );

			$elements = [];

			if ( ! empty( $image_wrapper ) ) {
				$elements = array_merge( $elements, $image_wrapper );
			}

			if ( ! empty( $text_wrapper ) ) {
				$elements['gt-blurb-content-wrapper'] = $text_wrapper;
			}

			return $elements;
		}

		/**
		 * Add date formats
		 *
		 * @param array $date_formats
		 *
		 * @return array
		 */
		public function add_date_formats( array $date_formats ) {
			$date_formats['j F, Y'] = esc_html__( 'j F, Y', 'g-theme-child' );

			return $date_formats;
		}

		/**
		 * Replace "input" with "button" for submits
		 *
		 * @param string $button
		 * @param array $form
		 *
		 * @return string
		 */
		public function gravity_forms_input_to_button_submit( string $button, array $form ) {
			$button = str_replace( 'input', 'button', $button );
			$button = str_replace( '/', '', $button );
			$button .= "{$form['button']['text']}</button>";

			return $button;
		}

		/**
		 * Add menu arrow to menu items with child-elements
		 *
		 * @return string
		 */
		public function mobile_menu_overlay() {
			echo '<div class="mobile-overlay"></div>';
		}

		/**
		 * Add menu arrow to menu items with child-elements
		 *
		 * @param string $item_output
		 * @param WP_Post $item // Menu item data object.
		 * @param int $depth
		 * @param stdClass $args
		 * @return string[]
		 */
		public function parent_menu_dropdown( string $item_output, \WP_Post $item, int $depth, \stdClass $args ) {
			if ( is_array( $item->classes ) && in_array( 'menu-item-has-children', $item->classes, true ) ) {
				return $item_output . '<span class="menu-arrow" role="img" aria-hidden="true"><i class="fa fa-angle-down"></i></span>';
			}

			return $item_output;
		}
	}

	/**
	 * Wrapper for getting the theme instance
	 *
	 * @return Theme
	 */
	function gtheme_child() {
		return Theme::get_instance();
	}

	gtheme_child()->run();

endif;
