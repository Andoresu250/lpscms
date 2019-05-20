<?php
/**
 * Add Jupiter settings for Footer > Styles > Widgets Thumbnail popup to the WordPress Customizer.
 *
 * @package JupiterX\Framework\Admin\Customizer
 *
 * @since   1.0.0
 */

$section = 'jupiterx_footer_widgets_thumbnail';

// Border.
JupiterX_Customizer::add_field( [
	'type'      => 'jupiterx-border',
	'settings'  => 'jupiterx_footer_widgets_thumbnail_border',
	'section'   => $section,
	'label'     => __( 'Border', 'jupiterx' ),
	'css_var'   => 'footer-widgets-thumbnail-border',
	'transport' => 'postMessage',
	'exclude'   => [ 'style', 'size' ],
	'default'   => [
		'width' => [
			'size' => '0',
			'unit' => 'px',
		],
	],
	'output'   => [
		[
			'element' => '.jupiterx-footer-widgets .jupiterx-widget img, .jupiterx-thumbnail-over',
		],
	],
] );
