<?php
/**
 * Add Jupiter settings for Footer > Styles > Widgets Title popup to the WordPress Customizer.
 *
 * @package JupiterX\Framework\Admin\Customizer
 *
 * @since   1.0.0
 */

$section = 'jupiterx_footer_widgets_title';

// Typography.
JupiterX_Customizer::add_field( [
	'type'       => 'jupiterx-typography',
	'settings'   => 'jupiterx_footer_widgets_title_typography',
	'section'    => $section,
	'responsive' => true,
	'css_var'    => 'footer-widgets-title',
	'transport'  => 'postMessage',
	'exclude'    => [ 'line_height', 'text_transform' ],
	'output'     => [
		[
			'element' => '.jupiterx-footer-widgets .card-title',
		],
	],
] );

// Divider.
JupiterX_Customizer::add_field( [
	'type'     => 'jupiterx-divider',
	'settings' => 'jupiterx_footer_widgets_title_divider',
	'section'  => $section,
] );

// Spacing.
JupiterX_Customizer::add_responsive_field( [
	'type'      => 'jupiterx-box-model',
	'settings'  => 'jupiterx_footer_widgets_title_spacing',
	'section'   => $section,
	'css_var'   => 'footer-widgets-title',
	'transport' => 'postMessage',
	'exclude'   => [ 'padding' ],
	'output'    => [
		[
			'element' => '.jupiterx-footer-widgets .card-title',
		],
	],
] );
