<?php
/**
 * Add Jupiter X section to the WordPress Customizer.
 *
 * @package JupiterX\Framework\Admin\Customizer
 *
 * @since 1.3.0
 */

$section = 'jupiterx_pro';

// Unlock to Jupiter X Pro section.
JupiterX_Customizer::add_section( $section, array(
	'title'         => __( 'Unlock to Jupiter X Pro', 'jupiterx' ),
	'priority'      => 0,
	'type'          => 'jupiterx-link',
	'jupiterx_url'  => 'https://themes.artbees.net/jupiterx-pro',
	'jupiterx_icon' => 'jupiterx-icon-pro',
	'upgrade_link'  => jupiterx_upgrade_link( 'customizer' ),
) );

// A Dummy setting.
JupiterX_Customizer::add_field( [
	'type'            => 'hidden',
	'settings'        => 'jupiterx_pro_setting',
	'section'         => $section,
	'active_callback' => function () {
		return ! jupiterx_is_pro();
	},
] );
