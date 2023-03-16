<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

return [
	'general' => [
		'fields' => [
			'price'       => [
				'title'       => esc_html__( 'Price', 'g-theme-child' ),
				'type'        => 'text',
				'placeholder' => '89 sek',
			],
			'country'     => [
				'title' => esc_html__( 'Country', 'g-theme-child' ),
				'type'  => 'text',
			],
			'flag'        => [
				'title'       => esc_html__( 'Flag', 'g-theme-child' ),
				'type'        => 'media',
				'storage'     => 'id',
				'media_types' => [ 'image' ],
			],
			'description' => [
				'title'      => esc_html__( 'Description', 'g-theme-child' ),
				'type'       => 'editor',
				'code_style' => 'html',
			],
		],
	],
];