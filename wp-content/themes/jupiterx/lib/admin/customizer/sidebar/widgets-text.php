<?php
/**
 * Add Jupiter settings for Sidebar > Styles > Widgets Text tab to the WordPress Customizer.
 *
 * @package JupiterX\Framework\Admin\Customizer
 *
 * @since   1.0.0
 */

$section = 'jupiterx_sidebar_widgets_text';

// Typography.
JupiterX_Customizer::add_field( [
	'type'       => 'jupiterx-typography',
	'settings'   => 'jupiterx_sidebar_widgets_text_typography',
	'section'    => $section,
	'responsive' => true,
	'css_var'    => 'sidebar-widgets-text',
	'transport'  => 'postMessage',
	'exclude'    => [ 'line_height', 'letter_spacing', 'text_transform' ],
	'output'     => [
		[
			'element' => '.jupiterx-sidebar .jupiterx-widget .jupiterx-widget-content, .jupiterx-sidebar .jupiterx-widget .jupiterx-widget-content p',
		],
	],
] );

// Divider.
JupiterX_Customizer::add_field( [
	'type'     => 'jupiterx-divider',
	'settings' => 'jupiterx_sidebar_widgets_text_divider',
	'section'  => $section,
] );

// Spacing.
JupiterX_Customizer::add_responsive_field( [
	'type'      => 'jupiterx-box-model',
	'settings'  => 'jupiterx_sidebar_widgets_text_spacing',
	'section'   => $section,
	'css_var'   => 'sidebar-widgets-text',
	'transport' => 'postMessage',
	'exclude'   => [ 'padding' ],
	'output'    => [
		[
			'element' => '.jupiterx-sidebar .jupiterx-widget .jupiterx-widget-content',
		],
	],
] );
