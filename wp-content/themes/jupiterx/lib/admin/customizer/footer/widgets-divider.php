<?php
/**
 * Add Jupiter settings for Footer > Styles > Divider popup to the WordPress Customizer.
 *
 * @package JupiterX\Framework\Admin\Customizer
 *
 * @since   1.0.0
 */

$section = 'jupiterx_footer_widgets_divider';

// Widget divider.
JupiterX_Customizer::add_field( [
	'type'      => 'jupiterx-border',
	'settings'  => 'jupiterx_footer_widgets_divider',
	'section'   => $section,
	'css_var'   => 'footer-widgets-divider',
	'exclude'   => [ 'radius' ],
	'transport' => 'postMessage',
	'output'    => [
		[
			'element'  => '.jupiterx-footer-widgets .jupiterx-widget-divider',
			'property' => 'border-top',
		],
	],
] );
