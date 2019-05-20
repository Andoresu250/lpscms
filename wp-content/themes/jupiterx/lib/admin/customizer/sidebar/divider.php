<?php
/**
 * Add Jupiter settings for Sidebar > Styles > Widgets Container tab to the WordPress Customizer.
 *
 * @package JupiterX\Framework\Admin\Customizer
 *
 * @since   1.0.0
 */

$section = 'jupiterx_sidebar_divider';

// Sidebar.
JupiterX_Customizer::add_field( [
	'type'      => 'jupiterx-border',
	'settings'  => 'jupiterx_sidebar_divider_sidebar',
	'section'   => $section,
	'css_var'   => 'sidebar-divider-sidebar',
	'label'     => __( 'Sidebar', 'jupiterx' ),
	'transport' => 'postMessage',
	'exclude'   => [ 'size', 'radius' ],
	'default'   => [
		'width' => [
			'size' => '0',
			'unit' => 'px',
		],
	],
	'output'    => [
		[
			'element'     => '.jupiterx-sidebar:not(.order-lg-first), .jupiterx-sidebar.order-lg-last',
			'property'    => 'border-left',
			'media_query' => '@media (min-width: 992px)',
		],
		[
			'element'     => '.jupiterx-sidebar.order-lg-first, .jupiterx-primary.order-lg-last ~ .jupiterx-sidebar',
			'property'    => 'border-right',
			'media_query' => '@media (min-width: 992px)',
		],
	],
] );

// Divider.
JupiterX_Customizer::add_field( [
	'type'     => 'jupiterx-divider',
	'settings' => 'jupiterx_sidebar_divider_line',
	'section'  => $section,
] );

// Widgets.
JupiterX_Customizer::add_field( [
	'type'      => 'jupiterx-border',
	'settings'  => 'jupiterx_sidebar_divider_widgets',
	'section'   => $section,
	'css_var'   => 'sidebar-divider-widgets',
	'label'     => __( 'Widgets', 'jupiterx' ),
	'transport' => 'postMessage',
	'default'   => [
		'width' => [
			'size' => '0',
			'unit' => 'px',
		],
		'color' => '#6c757d',
	],
	'output'    => [
		[
			'element'  => '.jupiterx-sidebar .jupiterx-widget-divider',
			'property' => 'border-bottom',
		],
	],
] );
