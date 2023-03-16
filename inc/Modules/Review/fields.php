<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

return [
	'general' => [
		'fields' => [
			'total_rating'      => [
				'title'       => esc_html__( 'Rating', 'g-theme-child' ),
				'type'        => 'number',
				'min'         => 1,
				'max'         => 5,
				'step'        => 0.1,
				'placeholder' => esc_html__( 'Enter a number between 1 - 5', 'g-theme-child' ),
			],
			'total_rating_desc' => [
				'title' => esc_html__( 'Description', 'g-theme-child' ),
				'type'  => 'text',
			],
			'review_btn_text'   => [
				'title' => esc_html__( 'Button text', 'g-theme-child' ),
				'type'  => 'text',
			],
			'review_form_id'    => [
				'title' => esc_html__( 'Form ID', 'g-theme-child' ),
				'type'  => 'number',
			],
			'person_reviews'    => [
				'title'  => esc_html__( 'Reviews from people', 'g-theme-child' ),
				'type'   => 'section',
				'fields' => [
					'person_review' => [
						'title'  => esc_html__( 'Review field', 'g-theme-child' ),
						'type'   => 'repeatable',
						'fields' => [
							'name'    => [
								'title'       => esc_html__( 'Name', 'g-theme-child' ),
								'type'        => 'text',
								'admin_label' => true,
							],
							'content' => [
								'title'      => esc_html__( 'Review', 'g-theme-child' ),
								'type'       => 'editor',
								'code_style' => 'html',
							],
							'rating'  => [
								'title'       => esc_html__( 'Rating', 'g-theme-child' ),
								'type'        => 'number',
								'min'         => 1,
								'max'         => 5,
								'step'        => 0.1,
								'placeholder' => esc_html__( 'Enter a number between 1 - 5', 'g-theme-child' ),
							],
							'date'    => [
								'title'       => esc_html__( 'Date', 'g-theme-child' ),
								'type'        => 'text',
								'placeholder' => esc_html__( 'yyyy-mm-dd', 'g-theme-child' ),
							],
						],
					],
				],
			],
		],
	],
];