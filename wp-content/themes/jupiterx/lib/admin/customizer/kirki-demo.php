<?php
/**
 * phpcs:ignoreFile
 *
 * An example file demonstrating how to add all controls.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.12
 */

return; // Enable if you need.

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Do not proceed if Kirki does not exist.
if ( ! class_exists( 'Kirki' ) ) {
	return;
}

/**
 * Add a panel.
 *
 * @link https://aristath.github.io/kirki/docs/getting-started/panels.html
 */
Kirki::add_panel(
	'kirki_demo_panel', array(
		'priority'    => 10,
		'title'       => esc_attr__( 'Jupiter X - Kirki Controls', 'jupiterx' ),
		'description' => esc_attr__( 'Contains sections for all kirki controls.', 'jupiterx' ),
	)
);

Kirki::add_panel(
	'jupiterx_demo_panel', array(
		'priority'    => 10,
		'title'       => esc_attr__( 'Jupiter X - Customizer Controls', 'jupiterx' ),
		'description' => esc_attr__( 'Contains sections for all kirki controls.', 'jupiterx' ),
	)
);

/**
 * Custom additional demo.
 */
Kirki::add_section( 'nested_section', [
	'title' => esc_attr__( 'Section Nested', 'jupiterx' ),
	'panel' => 'kirki_demo_panel',
] );

Kirki::add_section( 'outer_section', [
	'title' => esc_attr__( 'Section Outer', 'jupiterx' ),
	'panel' => 'kirki_demo_panel',
	'type'  => 'outer'
] );

/**
 * Create section popup demo.
 */
Kirki::add_section( 'popup_input_control', [
	'title' => esc_attr__( 'Input Control', 'jupiterx' ),
	'panel' => 'jupiterx_demo_panel',
	'type'  => 'popup',
] );

Kirki::add_section( 'popup_textarea_control', [
	'title' => esc_attr__( 'Textarea Control', 'jupiterx' ),
	'panel' => 'jupiterx_demo_panel',
	'type'  => 'popup',
] );

Kirki::add_section( 'popup_select_control', [
	'title' => esc_attr__( 'Select Control', 'jupiterx' ),
	'panel' => 'jupiterx_demo_panel',
	'type'  => 'popup',
] );

Kirki::add_section( 'popup_toggle_control', [
	'title' => esc_attr__( 'Toggle Control', 'jupiterx' ),
	'panel' => 'jupiterx_demo_panel',
	'type'  => 'popup',
] );

Kirki::add_section( 'popup_choose_control', [
	'title' => esc_attr__( 'Choose Control', 'jupiterx' ),
	'panel' => 'jupiterx_demo_panel',
	'type'  => 'popup',
] );

Kirki::add_section( 'popup_multicheck_control', [
	'title' => esc_attr__( 'Multicheck Control', 'jupiterx' ),
	'panel' => 'jupiterx_demo_panel',
	'type'  => 'popup',
] );

Kirki::add_section( 'popup_box_model_control', [
	'title' => esc_attr__( 'Box Model Control', 'jupiterx' ),
	'panel' => 'jupiterx_demo_panel',
	'type'  => 'popup',
] );

Kirki::add_section( 'popup_color_control', [
	'title' => esc_attr__( 'Color Control', 'jupiterx' ),
	'panel' => 'jupiterx_demo_panel',
	'type'  => 'popup',
] );

Kirki::add_section( 'popup_background_control', [
	'title' => esc_attr__( 'Background Control', 'jupiterx' ),
	'panel' => 'jupiterx_demo_panel',
	'type'  => 'popup',
] );

Kirki::add_section( 'popup_child_popup_control', [
	'title'  => esc_attr__( 'Child Popup Control', 'jupiterx' ),
	'panel'  => 'jupiterx_demo_panel',
	'type'   => 'popup',
	'tabs'   => [
		'styles' => esc_attr__( 'Styles', 'jupiterx' ),
		'elements' => esc_attr__( 'Elements', 'jupiterx' ),
	],
	'popups' => [
		'blog'      => esc_attr__( 'Blog', 'jupiterx' ),
		'post'      => esc_attr__( 'Post', 'jupiterx' ),
		'product'   => esc_attr__( 'Product', 'jupiterx' ),
		'portfolio' => esc_attr__( 'Portfolio', 'jupiterx' ),
		'archive'   => esc_attr__( 'Archive', 'jupiterx' ),
		'title'     => esc_attr__( 'Title', 'jupiterx' ),
	],
] );

Kirki::add_section( 'popup_child_popup_control_styles', [
	'popup' => 'popup_child_popup_control',
	'type'  => 'pane',
	'pane'  => [
		'type' => 'tab',
		'id'   => 'styles',
	],
] );

Kirki::add_section( 'popup_child_popup_control_elements', [
	'popup' => 'popup_child_popup_control',
	'type'  => 'pane',
	'pane'  => [
		'type' => 'tab',
		'id'   => 'elements',
	],
] );

Kirki::add_section( 'popup_child_popup_control_blog', [
	'popup' => 'popup_child_popup_control',
	'type'  => 'pane',
	'pane'  => [
		'type' => 'popup',
		'id'   => 'blog',
	],
] );

Kirki::add_section( 'popup_child_popup_control_post', [
	'popup' => 'popup_child_popup_control',
	'type'  => 'pane',
	'pane'  => [
		'type' => 'popup',
		'id'   => 'post',
	],
] );

Kirki::add_section( 'popup_child_popup_control_product', [
	'popup' => 'popup_child_popup_control',
	'type'  => 'pane',
	'pane'  => [
		'type' => 'popup',
		'id'   => 'product',
	],
] );

Kirki::add_section( 'popup_child_popup_control_portfolio', [
	'popup' => 'popup_child_popup_control',
	'type'  => 'pane',
	'pane'  => [
		'type' => 'popup',
		'id'   => 'portfolio',
	],
] );

Kirki::add_section( 'popup_child_popup_control_archive', [
	'popup' => 'popup_child_popup_control',
	'type'  => 'pane',
	'pane'  => [
		'type' => 'popup',
		'id'   => 'archive',
	],
] );

Kirki::add_section( 'popup_child_popup_control_title', [
	'popup' => 'popup_child_popup_control',
	'type'  => 'pane',
	'pane'  => [
		'type' => 'popup',
		'id'   => 'title',
	],
] );

Kirki::add_section( 'popup_typography', [
	'title'  => esc_attr__( 'Typography', 'jupiterx' ),
	'panel'  => 'jupiterx_demo_panel',
	'type'   => 'popup',
] );

Kirki::add_section( 'popup_radio_image', [
	'title'  => esc_attr__( 'Radio Image', 'jupiterx' ),
	'panel'  => 'jupiterx_demo_panel',
	'type'   => 'popup',
] );

Kirki::add_section( 'popup_responsive_controls', [
	'title'  => esc_attr__( 'No Refresh Controls', 'jupiterx' ),
	'panel'  => 'jupiterx_demo_panel',
	'type'   => 'popup',
] );

my_config_kirki_add_field(
	array(
		'type'       => 'jupiterx-text',
		'settings'   => 'jupiterx_text_1_setting',
		'section'    => 'popup_input_control',
		'default'    => '',
		'input_type' => 'text',
		'text'       => esc_attr__( 'API Code', 'jupiterx' ),
		'responsive' => true,
		'column'     => 6,
	)
);

my_config_kirki_add_field(
	array(
		'type'       => 'jupiterx-text',
		'settings'   => 'jupiterx_text_2_setting',
		'section'    => 'popup_input_control',
		'default'    => '',
		'input_type' => 'text',
		'text'       => esc_attr__( 'Hash Code', 'jupiterx' ),
		'unit'       => 'xx',
		'column'     => 6,
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'jupiterx-input',
		'settings'    => 'jupiterx_number_1_setting',
		'section'     => 'popup_input_control',
		'default'     => '',
		'input_type'  => 'number',
		'input_attrs' => [
			'min'  => '0',
			'max'  => '100',
		],
		'icon'        => 'font-family',
		'unit'        => 'px',
		'responsive'  => true,
		'column'      => 6,
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'jupiterx-input',
		'settings'    => 'jupiterx_number_2_setting',
		'section'     => 'popup_input_control',
		'default'     => '',
		'input_type'  => 'number',
		'input_attrs' => [
			'min'  => '0',
			'max'  => '100',
		],
		'icon'        => 'font-family',
		'unit'        => 'px',
		'column'      => 6,
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'jupiterx-input',
		'settings'    => 'jupiterx_number_3_setting',
		'section'     => 'popup_input_control',
		'default'     => '',
		'input_type'  => 'number',
		'input_attrs' => [
			'min'  => '0',
			'max'  => '100',
			'placeholder' => esc_attr__( 'Enter font size.', 'jupiterx' ),
		],
		'text'        => esc_attr__( 'Font Size', 'jupiterx' ),
		'unit'        => 'px',
		'responsive'  => true,
		'column'      => 6,
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'jupiterx-input',
		'settings'    => 'jupiterx_number_4_setting',
		'section'     => 'popup_input_control',
		'default'     => '',
		'text'        => esc_attr__( 'Font Size', 'jupiterx' ),
		'units'       => ['px', 'em'],
		'column'      => 6,
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'jupiterx-input',
		'settings'    => 'jupiterx_number_5_setting',
		'section'     => 'popup_input_control',
		'default'     => '',
		'text'        => esc_attr__( 'All units', 'jupiterx' ),
		'responsive'  => true,
		'column'      => 6,
	)
);


my_config_kirki_add_field(
	array(
		'type'        => 'jupiterx-input',
		'settings'    => 'jupiterx_number_6_setting',
		'section'     => 'popup_input_control',
		'default'     => '',
		'text'        => esc_attr__( '1 unit', 'jupiterx' ),
		'units'       => ['px'],
		'responsive'  => true,
		'column'      => 6,
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'jupiterx-textarea',
		'settings'    => 'jupiterx_textarea_1_setting',
		'section'     => 'popup_textarea_control',
		'default'     => '',
		'label'       => esc_attr__( 'Google Script', 'jupiterx' ),
		'input_attrs' => [
			'row' => '7'
		],
		'responsive'  => true,
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'jupiterx-textarea',
		'settings'    => 'jupiterx_textarea_2_setting',
		'section'     => 'popup_textarea_control',
		'default'     => '',
		'label'       => esc_attr__( 'Header Script', 'jupiterx' ),
		'input_attrs' => [
			'row' => '7'
		],
		'responsive'  => true,
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'jupiterx-textarea',
		'settings'    => 'jupiterx_textarea_3_setting',
		'section'     => 'popup_textarea_control',
		'default'     => '',
		'label'       => esc_attr__( 'Footer Script', 'jupiterx' ),
		'input_attrs' => [
			'row' => '7'
		],
		'responsive'  => true,
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-textarea',
		'settings' => 'jupiterx_textarea_4_setting',
		'section'  => 'popup_textarea_control',
		'default'  => '',
		'icon'     => 'font-size',
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-textarea',
		'settings' => 'jupiterx_textarea_5_setting',
		'section'  => 'popup_textarea_control',
		'default'  => '',
		'icon'     => 'font-size',
		'text'    => esc_attr__( 'Inline Label', 'jupiterx' ),
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'jupiterx-select',
		'settings'    => 'jupiterx_select_1_setting',
		'section'     => 'popup_select_control',
		'default'     => '',
		'column'      => '6',
		'label'       => esc_attr__( 'Sidebar', 'jupiterx' ),
		'placeholder' => esc_attr( 'Select Sidebar Position', 'jupiterx' ),
		'default'     => 'full',
		'choices'     => array(
			'full'  => __( 'No Sidebar', 'jupiterx' ),
			'left'  => __( 'Left Sidebar', 'jupiterx' ),
			'right' => __( 'Right Sidebar', 'jupiterx' ),
		),
		'responsive'  => true,
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-select',
		'settings' => 'jupiterx_select_2_setting',
		'section'  => 'popup_select_control',
		'default'  => '',
		'column'   => '6',
		'label'    => esc_attr__( 'Content Position', 'jupiterx' ),
		'default'  => 'top',
		'choices'  => array(
			'top'    => __( 'Top', 'jupiterx' ),
			'right'  => __( 'Right', 'jupiterx' ),
			'bottom' => __( 'Bottom', 'jupiterx' ),
			'left'   => __( 'Left', 'jupiterx' ),
		),
		'responsive' => true,
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-select',
		'settings' => 'jupiterx_select_4_setting',
		'section'  => 'popup_select_control',
		'default'  => '',
		'column'   => '6',
		'label'    => esc_attr__( 'Columns', 'jupiterx' ),
		'default'  => '1',
		'icon'    => 'grid-columns',
		'choices' => array(
			'1' => __( '1 Column', 'jupiterx' ),
			'2' => __( '2 Columns', 'jupiterx' ),
			'3' => __( '3 Columns', 'jupiterx' ),
			'4' => __( '4 Columns', 'jupiterx' ),
		),
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-select',
		'settings' => 'jupiterx_select_5_setting',
		'section'  => 'popup_select_control',
		'default'  => '',
		'column'   => '6',
		'label'    => esc_attr__( 'Rows', 'jupiterx' ),
		'default'  => '1',
		'icon'     => 'grid-rows',
		'choices'  => array(
			'1' => __( '1 Row', 'jupiterx' ),
			'2' => __( '2 Rows', 'jupiterx' ),
			'3' => __( '3 Rows', 'jupiterx' ),
			'4' => __( '4 Rows', 'jupiterx' ),
		),
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-toggle',
		'settings' => 'jupiterx_toggle_setting_1',
		'section'  => 'popup_toggle_control',
		'default'  => false,
		'column'   => '6',
		'label'    => esc_attr__( 'Scroll Top Button', 'jupiterx' ),
		'responsive' => true,
	)
);

my_config_kirki_add_field(
	array(
		'type'       => 'jupiterx-toggle',
		'settings'   => 'jupiterx_toggle_setting_2',
		'section'    => 'popup_toggle_control',
		'default'    => false,
		'column'     => '6',
		'label'      => esc_attr__( 'Boxed Container', 'jupiterx' ),
		'responsive' => true,
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-toggle',
		'settings' => 'jupiterx_toggle_setting_3',
		'section'  => 'popup_toggle_control',
		'default'  => false,
		'column'   => '6',
		'label'    => esc_attr__( 'Smooth Scroll', 'jupiterx' ),
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-toggle',
		'settings' => 'jupiterx_toggle_setting_4',
		'section'  => 'popup_toggle_control',
		'default'  => false,
		'column'   => '6',
		'label'    => esc_attr__( 'Lazy Loading Images', 'jupiterx' ),
	)
);



my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-toggle',
		'settings' => 'jupiterx_toggle_setting_5',
		'section'  => 'popup_toggle_control',
		'default'  => false,
		'column'   => '6',
		'text'    => esc_attr__( 'Scroll Top Button', 'jupiterx' ),
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-toggle',
		'settings' => 'jupiterx_toggle_setting_6',
		'section'  => 'popup_toggle_control',
		'default'  => false,
		'column'   => '6',
		'text'    => esc_attr__( 'Boxed Container', 'jupiterx' ),
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-toggle',
		'settings' => 'jupiterx_toggle_setting_7',
		'section'  => 'popup_toggle_control',
		'default'  => false,
		'column'   => '6',
		'text'    => esc_attr__( 'Smooth Scroll', 'jupiterx' ),
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-toggle',
		'settings' => 'jupiterx_toggle_setting_8',
		'section'  => 'popup_toggle_control',
		'default'  => false,
		'column'   => '6',
		'text'    => esc_attr__( 'Lazy Loading Images', 'jupiterx' ),
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-choose',
		'settings' => 'jupiterx_choose_1_setting',
		'section'  => 'popup_choose_control',
		'column'   => '6',
		'label'    => esc_attr__( 'Position', 'jupiterx' ),
		'default'  => 'top',
		'choices'  => array(
			'top'    => [
				'label' => __( 'Top', 'jupiterx' ),
			],
			'right'  => [
				'label' => __( 'Right', 'jupiterx' ),
			],
			'bottom' => [
				'label' => __( 'Bottom', 'jupiterx' ),
			],
			'left'   => [
				'label' => __( 'Left', 'jupiterx' ),
			],
		),
		'responsive' => true,
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-choose',
		'settings' => 'jupiterx_choose_2_setting',
		'section'  => 'popup_choose_control',
		'column'   => '6',
		'label'    => esc_attr__( 'Position', 'jupiterx' ),
		'default'  => 'top',
		'choices'  => array(
			'top'    => [
				'label' => __( 'Top', 'jupiterx' ),
				'icon'  => 'arrow-top',
			],
			'right'  => [
				'label' => __( 'Right', 'jupiterx' ),
				'icon'  => 'arrow-right',
			],
			'bottom' => [
				'label' => __( 'Bottom', 'jupiterx' ),
				'icon'  => 'arrow-bottom',
			],
			'left'   => [
				'label' => __( 'Left', 'jupiterx' ),
				'icon'  => 'arrow-left',
			],
		),
		'responsive' => true,
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-choose',
		'settings' => 'jupiterx_choose_3_setting',
		'section'  => 'popup_choose_control',
		'label'    => esc_attr__( 'Text Alignment', 'jupiterx' ),
		'default'  => 'left',
		'choices'  => array(
			'left'    => [
				'label' => __( 'Left', 'jupiterx' ),
				'icon'  => 'alignment-left',
			],
			'center'  => [
				'label' => __( 'Center', 'jupiterx' ),
				'icon'  => 'alignment-center',
			],
			'right' => [
				'label' => __( 'Right', 'jupiterx' ),
				'icon'  => 'alignment-right',
			],
		),
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-choose',
		'settings' => 'jupiterx_choose_4_setting',
		'section'  => 'popup_choose_control',
		'label'    => esc_attr__( 'Image Ratio', 'jupiterx' ),
		'default'  => 'default',
		'choices'  => array(
			'default'   => __( 'Default', 'jupiterx' ),
			'ratio-169' => __( '16:9', 'jupiterx' ),
			'ratio-32'  => __( '3:2', 'jupiterx' ),
			'ratio-43'  => __( '4:3', 'jupiterx' ),
			'ratio-11'  => __( '1:1', 'jupiterx' ),
			'ratio-34'  => __( '3:4', 'jupiterx' ),
			'ratio-23'  => __( '2:3', 'jupiterx' ),
			'ratio-916' => __( '9:16', 'jupiterx' ),
		),
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-multicheck',
		'settings' => 'jupiterx_multicheck_1_setting',
		'section'  => 'popup_multicheck_control',
		'label'    => esc_attr__( 'Position', 'jupiterx' ),
		'default'  => [
			'desktop' => [ 'top', 'right' ],
			'tablet'  => [ 'left', 'bottom' ],
			'mobile'  => [ 'right', 'left' ],
		],
		'choices'  => array(
			'top'    => __( 'Top', 'jupiterx' ),
			'right'  => __( 'Right', 'jupiterx' ),
			'bottom' => __( 'Bottom', 'jupiterx' ),
			'left'   => __( 'Left', 'jupiterx' ),
		),
		'responsive' => true,
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-divider',
		'section'  => 'popup_multicheck_control',
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-multicheck',
		'settings' => 'jupiterx_multicheck_2_setting',
		'section'  => 'popup_multicheck_control',
		'label'    => esc_attr__( 'Display Product Info', 'jupiterx' ),
		'default'  => [],
		'choices'  => array(
			'product-name'  => __( 'Product Name', 'jupiterx' ),
			'regular-price' => __( 'Regular Price', 'jupiterx' ),
			'sale-price'    => __( 'Sale Price', 'jupiterx' ),
			'add-to-cart'   => __( 'Add to Cart Button', 'jupiterx' ),
			'rating'        => __( 'Rating', 'jupiterx' ),
		),
	)
);

my_config_kirki_add_field(
	array(
		'type'       => 'jupiterx-label',
		'settings'   => 'label_hover',
		'section'    => 'popup_multicheck_control',
		'label'      => __( 'Hover', 'jupiterx' ),
		'label_type' => 'fancy',
		'color'      => 'orange',
	)
);

my_config_kirki_add_field(
	array(
		'type'       => 'jupiterx-label',
		'settings'   => 'label_active',
		'section'    => 'popup_multicheck_control',
		'label'      => __( 'Active', 'jupiterx' ),
		'label_type' => 'fancy',
		'color'      => 'green',
	)
);

my_config_kirki_add_field(
	array(
		'type'       => 'jupiterx-label',
		'settings'   => 'label_passive',
		'section'    => 'popup_multicheck_control',
		'label'      => __( 'Passive', 'jupiterx' ),
		'label_type' => 'fancy',
		'color'      => 'yellow',
	)
);

my_config_kirki_add_field(
	array(
		'type'       => 'jupiterx-box-model',
		'settings'   => 'jupiterx_box_model_1_setting',
		'section'    => 'popup_box_model_control',
		'transport'  => 'postMessage',
		'responsive' => true,
	)
);

my_config_kirki_add_field(
	array(
		'type'       => 'jupiterx-box-model',
		'settings'   => 'jupiterx_box_model_2_setting',
		'section'    => 'popup_box_model_control',
		'exclude'    => [ 'margin' ],
		'responsive' => true,
	)
);

my_config_kirki_add_field(
	array(
		'type'       => 'jupiterx-box-model',
		'settings'   => 'jupiterx_box_model_3_setting',
		'section'    => 'popup_box_model_control',
		'exclude'    => [ 'margin' ],
		'responsive' => true,
		'units'      => ['px', 'em'],
	)
);

my_config_kirki_add_field(
	array(
		'type'       => 'jupiterx-color',
		'settings'   => 'jupiterx_color_1_setting',
		'label'      => __( 'Text Color', 'jupiterx' ),
		'section'    => 'popup_color_control',
		'transport'  => 'postMessage',
		'responsive' => true,
	)
);

my_config_kirki_add_field(
	array(
		'type'       => 'jupiterx-color',
		'settings'   => 'jupiterx_color_2_setting',
		'text'       => __( 'Border Color', 'jupiterx' ),
		'column'     => '6',
		'section'    => 'popup_color_control',
		'responsive' => true,
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-color',
		'settings' => 'jupiterx_color_3_setting',
		'icon'     => 'font-color',
		'column'   => '2',
		'section'  => 'popup_color_control',
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-color',
		'settings' => 'jupiterx_color_4_setting',
		'icon'     => 'background-color',
		'column'   => '4',
		'section'  => 'popup_color_control',
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-background',
		'settings' => 'jupiterx_background_setting',
		'icon'     => 'background-color',
		'section'  => 'popup_background_control',
		'include'  => [ 'video' ],
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-child-popup',
		'settings' => 'jupiterx_child_popup_setting_1',
		'section'  => 'popup_child_popup_control_styles',
		'target'   => 'popup_child_popup_control',
		'sortable' => 'true',
		'choices'  => [
			'blog'      => esc_attr__( 'Blog', 'jupiterx' ),
			'post'      => esc_attr__( 'Post', 'jupiterx' ),
			'product'   => esc_attr__( 'Product', 'jupiterx' ),
			'portfolio' => esc_attr__( 'Portfolio', 'jupiterx' ),
			'archive'   => esc_attr__( 'Archive', 'jupiterx' ),
		]
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-child-popup',
		'settings' => 'jupiterx_open_pane_setting_2',
		'section'  => 'popup_child_popup_control_elements',
		'target'   => 'popup_child_popup_control',
		'sortable' => 'true',
		'choices'  => [
			'title' => esc_attr__( 'Title', 'jupiterx' ),
		]
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-typography',
		'settings' => 'jupiterx_typography_0',
		'section'  => 'popup_child_popup_control_blog',
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-typography',
		'settings' => 'jupiterx_typography_1',
		'section'  => 'popup_typography',
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'jupiterx-radio-image',
		'settings' => 'jupiterx_radio_image_0',
		'section'  => 'popup_radio_image',
		'choices'  => [
			'footer_layout_01' => 'footer-layout-01',
			'footer_layout_02' => 'footer-layout-02',
			'footer_layout_03' => 'footer-layout-03',
			'footer_layout_04' => 'footer-layout-04',
			'footer_layout_05' => 'footer-layout-05',
			'footer_layout_06' => 'footer-layout-06',
			'footer_layout_07' => 'footer-layout-07',
			'footer_layout_08' => 'footer-layout-08',
			'footer_layout_09' => 'footer-layout-09',
			'footer_layout_10' => 'footer-layout-10',
			'footer_layout_11' => 'footer-layout-11',
			'footer_layout_12' => 'footer-layout-12',
			'footer_layout_13' => 'footer-layout-13',
			'footer_layout_14' => 'footer-layout-14',
			'footer_layout_15' => 'footer-layout-15',
			'footer_layout_16' => 'footer-layout-16',
			'footer_layout_17' => 'footer-layout-17',
		],
	)
);

JupiterX_Customizer::add_field(
	array(
		'type'       => 'jupiterx-color',
		'settings'   => 'jupiterx_test_responsive_control_color_1',
		'label'      => __( 'Title Color', 'jupiterx' ),
		'section'    => 'popup_responsive_controls',
		'column'     => 6,
		'responsive' => true,
		'transport'  => 'postMessage',
		'output'     => [
			[
				'element'  => '.navbar-light .jupiterx-navbar-brand-link',
				'property' => 'color',
			],
		],
	)
);

JupiterX_Customizer::add_field(
	array(
		'type'       => 'jupiterx-typography',
		'settings'   => 'jupiterx_test_responsive_control_typography_1',
		'label'      => __( 'Title Typography', 'jupiterx' ),
		'section'    => 'popup_responsive_controls',
		'responsive' => true,
		'transport'  => 'postMessage',
		'output'     => [
			[
				'element'  => '.navbar-light .jupiterx-navbar-brand-link',
			],
		],
	)
);

JupiterX_Customizer::add_field(
	array(
		'type'       => 'jupiterx-background',
		'settings'   => 'jupiterx_test_responsive_control_background_1',
		'section'    => 'popup_responsive_controls',
		'transport'  => 'postMessage',
		'output'     => [
			[
				'element'  => '.navbar-light .jupiterx-navbar-brand-link',
			],
		],
	)
);

JupiterX_Customizer::add_field(
	array(
		'type'       => 'jupiterx-border',
		'settings'   => 'jupiterx_test_responsive_control_border_1',
		'section'    => 'popup_responsive_controls',
		'transport'  => 'postMessage',
		'exclude'    => [ 'size' ],
		'output'     => [
			[
				'element'  => '.navbar-light .jupiterx-navbar-brand-link',
			],
		],
	)
);

JupiterX_Customizer::add_field(
	array(
		'type'       => 'jupiterx-box-shadow',
		'settings'   => 'jupiterx_test_responsive_control_box_shadow_1',
		'section'    => 'popup_responsive_controls',
		'transport'  => 'postMessage',
		'output'     => [
			[
				'element'  => '.navbar-light .jupiterx-navbar-brand-link',
			],
		],
	)
);

JupiterX_Customizer::add_field(
	array(
		'type'       => 'jupiterx-box-model',
		'settings'   => 'jupiterx_test_responsive_control_spacing_1',
		'label'      => __( 'Title Spacing', 'jupiterx' ),
		'section'    => 'popup_responsive_controls',
		'responsive' => true,
		'transport'  => 'postMessage',
		'output'     => [
			[
				'element'  => '.navbar-light .jupiterx-navbar-brand-link',
			],
		],
	)
);

JupiterX_Customizer::add_field(
	array(
		'type'     => 'jupiterx-divider',
		'settings' => 'jupiterx_test_divider',
		'section'  => 'popup_responsive_controls',
	)
);

JupiterX_Customizer::add_field(
	array(
		'type'       => 'jupiterx-color',
		'settings'   => 'jupiterx_test_responsive_control_color_2',
		'label'      => __( 'Description Color', 'jupiterx' ),
		'section'    => 'popup_responsive_controls',
		'column'     => 6,
		'responsive' => true,
		'transport'  => 'postMessage',
		'output'     => [
			[
				'element'  => '.navbar-light .jupiterx-navbar-description',
				'property' => 'color',
			],
		],
	)
);

JupiterX_Customizer::add_field(
	array(
		'type'       => 'jupiterx-typography',
		'settings'   => 'jupiterx_test_responsive_control_typography_2',
		'label'      => __( 'Description Typography', 'jupiterx' ),
		'section'    => 'popup_responsive_controls',
		'responsive' => true,
		'transport'  => 'postMessage',
		'output'     => [
			[
				'element'  => '.navbar-light .jupiterx-navbar-description',
			],
		],
	)
);

JupiterX_Customizer::add_field(
	array(
		'type'       => 'jupiterx-background',
		'settings'   => 'jupiterx_test_responsive_control_background_2',
		'section'    => 'popup_responsive_controls',
		'transport'  => 'postMessage',
		'output'     => [
			[
				'element'  => '.navbar-light .jupiterx-navbar-description',
			],
		],
	)
);

JupiterX_Customizer::add_field(
	array(
		'type'       => 'jupiterx-border',
		'settings'   => 'jupiterx_test_responsive_control_border_2',
		'section'    => 'popup_responsive_controls',
		'transport'  => 'postMessage',
		'exclude'    => [ 'size' ],
		'output'     => [
			[
				'element'  => '.navbar-light .jupiterx-navbar-description',
			],
		],
	)
);

JupiterX_Customizer::add_field(
	array(
		'type'       => 'jupiterx-box-shadow',
		'settings'   => 'jupiterx_test_responsive_control_box_shadow_2',
		'section'    => 'popup_responsive_controls',
		'transport'  => 'postMessage',
		'output'     => [
			[
				'element'  => '.navbar-light .jupiterx-navbar-description',
			],
		],
	)
);

JupiterX_Customizer::add_field(
	array(
		'type'       => 'jupiterx-box-model',
		'settings'   => 'jupiterx_test_responsive_control_spacing_2',
		'label'      => __( 'Description Spacing', 'jupiterx' ),
		'section'    => 'popup_responsive_controls',
		'responsive' => true,
		'transport'  => 'postMessage',
		'output'     => [
			[
				'element'  => '.navbar-light .jupiterx-navbar-description',
			],
		],
	)
);

/**
 * Add Sections.
 *
 * We'll be doing things a bit differently here, just to demonstrate an example.
 * We're going to define 1 section per control-type just to keep things clean and separate.
 *
 * @link https://aristath.github.io/kirki/docs/getting-started/sections.html
 */
$sections = array(
	'background'      => array( esc_attr__( 'Background', 'jupiterx' ), '' ),
	'code'            => array( esc_attr__( 'Code', 'jupiterx' ), '' ),
	'checkbox'        => array( esc_attr__( 'Checkbox', 'jupiterx' ), '' ),
	'color'           => array( esc_attr__( 'Color', 'jupiterx' ), '' ),
	'color-palette'   => array( esc_attr__( 'Color Palette', 'jupiterx' ), '' ),
	'custom'          => array( esc_attr__( 'Custom', 'jupiterx' ), '' ),
	'dashicons'       => array( esc_attr__( 'Dashicons', 'jupiterx' ), '' ),
	'date'            => array( esc_attr__( 'Date', 'jupiterx' ), '' ),
	'dimension'       => array( esc_attr__( 'Dimension', 'jupiterx' ), '' ),
	'dimensions'      => array( esc_attr__( 'Dimensions', 'jupiterx' ), '' ),
	'editor'          => array( esc_attr__( 'Editor', 'jupiterx' ), '' ),
	'fontawesome'     => array( esc_attr__( 'Font-Awesome', 'jupiterx' ), '' ),
	'generic'         => array( esc_attr__( 'Generic', 'jupiterx' ), '' ),
	'image'           => array( esc_attr__( 'Image', 'jupiterx' ), '' ),
	'multicheck'      => array( esc_attr__( 'Multicheck', 'jupiterx' ), '' ),
	'multicolor'      => array( esc_attr__( 'Multicolor', 'jupiterx' ), '' ),
	'number'          => array( esc_attr__( 'Number', 'jupiterx' ), '' ),
	'palette'         => array( esc_attr__( 'Palette', 'jupiterx' ), '' ),
	'preset'          => array( esc_attr__( 'Preset', 'jupiterx' ), '' ),
	'radio'           => array( esc_attr__( 'Radio', 'jupiterx' ), esc_attr__( 'A plain Radio control.', 'jupiterx' ) ),
	'radio-buttonset' => array( esc_attr__( 'Radio Buttonset', 'jupiterx' ), esc_attr__( 'Radio-Buttonset controls are essentially radio controls with some fancy styling to make them look cooler.', 'jupiterx' ) ),
	'radio-image'     => array( esc_attr__( 'Radio Image', 'jupiterx' ), esc_attr__( 'Radio-Image controls are essentially radio controls with some fancy styles to use images', 'jupiterx' ) ),
	'repeater'        => array( esc_attr__( 'Repeater', 'jupiterx' ), '' ),
	'select'          => array( esc_attr__( 'Select', 'jupiterx' ), '' ),
	'slider'          => array( esc_attr__( 'Slider', 'jupiterx' ), '' ),
	'sortable'        => array( esc_attr__( 'Sortable', 'jupiterx' ), '' ),
	'switch'          => array( esc_attr__( 'Switch', 'jupiterx' ), '' ),
	'toggle'          => array( esc_attr__( 'Toggle', 'jupiterx' ), '' ),
	'typography'      => array( esc_attr__( 'Typography', 'jupiterx' ), '', 'outer' ),
);
foreach ( $sections as $section_id => $section ) {
	$section_args = array(
		'title'       => $section[0],
		'description' => $section[1],
		'panel'       => 'kirki_demo_panel',
	);
	if ( isset( $section[2] ) ) {
		$section_args['type'] = $section[2];
	}
	Kirki::add_section( str_replace( '-', '_', $section_id ) . '_section', $section_args );
}

/**
 * A proxy function. Automatically passes-on the config-id.
 *
 * @param array $args The field arguments.
 */
function my_config_kirki_add_field( $args ) {
	Kirki::add_field( 'jupiter', $args );
}

/**
 * Background Control.
 *
 * @todo Triggers change on load.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'background',
		'settings'    => 'background_setting',
		'label'       => esc_attr__( 'Background Control', 'jupiterx' ),
		'description' => esc_attr__( 'Background conrols are pretty complex! (but useful if properly used)', 'jupiterx' ),
		'section'     => 'background_section',
		'default'     => array(
			'background-color'      => 'rgba(20,20,20,.8)',
			'background-image'      => '',
			'background-repeat'     => 'repeat',
			'background-position'   => 'center center',
			'background-size'       => 'cover',
			'background-attachment' => 'scroll',
		),
	)
);

/**
 * Code control.
 *
 * @link https://aristath.github.io/kirki/docs/controls/code.html
 */
my_config_kirki_add_field(
	array(
		'type'        => 'code',
		'settings'    => 'code_setting',
		'label'       => esc_attr__( 'Code Control', 'jupiterx' ),
		'description' => esc_attr__( 'Description', 'jupiterx' ),
		'section'     => 'code_section',
		'default'     => '',
		'choices'     => array(
			'language' => 'css',
		),
	)
);

/**
 * Checkbox control.
 *
 * @link https://aristath.github.io/kirki/docs/controls/checkbox.html
 */
my_config_kirki_add_field(
	array(
		'type'        => 'checkbox',
		'settings'    => 'checkbox_setting',
		'label'       => esc_attr__( 'Checkbox Control', 'jupiterx' ),
		'description' => esc_attr__( 'Description', 'jupiterx' ),
		'section'     => 'checkbox_section',
		'default'     => true,
	)
);

/**
 * Color Controls.
 *
 * @link https://aristath.github.io/kirki/docs/controls/color.html
 */
my_config_kirki_add_field(
	array(
		'type'        => 'color',
		'settings'    => 'color_setting_hex',
		'label'       => __( 'Color Control (hex-only)', 'jupiterx' ),
		'description' => esc_attr__( 'This is a color control - without alpha channel.', 'jupiterx' ),
		'section'     => 'color_section',
		'default'     => '#0008DC',
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'color',
		'settings'    => 'color_setting_rgba',
		'label'       => __( 'Color Control (with alpha channel)', 'jupiterx' ),
		'description' => esc_attr__( 'This is a color control - with alpha channel.', 'jupiterx' ),
		'section'     => 'color_section',
		'default'     => '#0088CC',
		'choices'     => array(
			'alpha' => true,
		),
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'color',
		'settings'    => 'color_setting_hue',
		'label'       => __( 'Color Control - hue only.', 'jupiterx' ),
		'description' => esc_attr__( 'This is a color control - hue only.', 'jupiterx' ),
		'section'     => 'color_section',
		'default'     => 160,
		'mode'        => 'hue',
	)
);

/**
 * DateTime Control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'date',
		'settings'    => 'date_setting',
		'label'       => esc_attr__( 'Date Control', 'jupiterx' ),
		'description' => esc_attr__( 'This is a date control.', 'jupiterx' ),
		'section'     => 'date_section',
		'default'     => '',
	)
);

/**
 * Editor Controls
 */
my_config_kirki_add_field(
	array(
		'type'        => 'editor',
		'settings'    => 'editor_1',
		'label'       => esc_attr__( 'First Editor Control', 'jupiterx' ),
		'description' => esc_attr__( 'This is an editor control.', 'jupiterx' ),
		'section'     => 'editor_section',
		'default'     => '',
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'editor',
		'settings'    => 'editor_2',
		'label'       => esc_attr__( 'Second Editor Control', 'jupiterx' ),
		'description' => esc_attr__( 'This is a 2nd editor control just to check that we do not have issues with multiple instances.', 'jupiterx' ),
		'section'     => 'editor_section',
		'default'     => esc_attr__( 'Default Text', 'jupiterx' ),
	)
);

/**
 * Color-Palette Controls.
 *
 * @link https://aristath.github.io/kirki/docs/controls/color-palette.html
 */
my_config_kirki_add_field(
	array(
		'type'        => 'color-palette',
		'settings'    => 'color_palette_setting_0',
		'label'       => esc_attr__( 'Color-Palette', 'jupiterx' ),
		'description' => esc_attr__( 'This is a color-palette control', 'jupiterx' ),
		'section'     => 'color_palette_section',
		'default'     => '#888888',
		'choices'     => array(
			'colors' => array( '#000000', '#222222', '#444444', '#666666', '#888888', '#aaaaaa', '#cccccc', '#eeeeee', '#ffffff' ),
			'style'  => 'round',
		),
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'color-palette',
		'settings'    => 'color_palette_setting_4',
		'label'       => esc_attr__( 'Color-Palette', 'jupiterx' ),
		'description' => esc_attr__( 'Material Design Colors - all', 'jupiterx' ),
		'section'     => 'color_palette_section',
		'default'     => '#F44336',
		'choices'     => array(
			'colors' => Kirki_Helper::get_material_design_colors( 'all' ),
			'size'   => 17,
		),
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'color-palette',
		'settings'    => 'color_palette_setting_1',
		'label'       => esc_attr__( 'Color-Palette', 'jupiterx' ),
		'description' => esc_attr__( 'Material Design Colors - primary', 'jupiterx' ),
		'section'     => 'color_palette_section',
		'default'     => '#000000',
		'choices'     => array(
			'colors' => Kirki_Helper::get_material_design_colors( 'primary' ),
			'size'   => 25,
		),
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'color-palette',
		'settings'    => 'color_palette_setting_2',
		'label'       => esc_attr__( 'Color-Palette', 'jupiterx' ),
		'description' => esc_attr__( 'Material Design Colors - red', 'jupiterx' ),
		'section'     => 'color_palette_section',
		'default'     => '#FF1744',
		'choices'     => array(
			'colors' => Kirki_Helper::get_material_design_colors( 'red' ),
			'size'   => 16,
		),
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'color-palette',
		'settings'    => 'color_palette_setting_3',
		'label'       => esc_attr__( 'Color-Palette', 'jupiterx' ),
		'description' => esc_attr__( 'Material Design Colors - A100', 'jupiterx' ),
		'section'     => 'color_palette_section',
		'default'     => '#FF80AB',
		'choices'     => array(
			'colors' => Kirki_Helper::get_material_design_colors( 'A100' ),
			'size'   => 60,
			'style'  => 'round',
		),
	)
);

/**
 * Dashicons control.
 *
 * @link https://aristath.github.io/kirki/docs/controls/dashicons.html
 */
my_config_kirki_add_field(
	array(
		'type'        => 'dashicons',
		'settings'    => 'dashicons_setting_0',
		'label'       => esc_attr__( 'Dashicons Control', 'jupiterx' ),
		'description' => esc_attr__( 'Using a custom array of dashicons', 'jupiterx' ),
		'section'     => 'dashicons_section',
		'default'     => 'menu',
		'choices'     => array(
			'menu',
			'admin-site',
			'dashboard',
			'admin-post',
			'admin-media',
			'admin-links',
			'admin-page',
		),
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'dashicons',
		'settings'    => 'dashicons_setting_1',
		'label'       => esc_attr__( 'All Dashicons', 'jupiterx' ),
		'description' => esc_attr__( 'Showing all dashicons', 'jupiterx' ),
		'section'     => 'dashicons_section',
		'default'     => 'menu',
	)
);

/**
 * Dimension Control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'dimension',
		'settings'    => 'dimension_0',
		'label'       => esc_attr__( 'Dimension Control', 'jupiterx' ),
		'description' => esc_attr__( 'Description Here.', 'jupiterx' ),
		'section'     => 'dimension_section',
		'default'     => '10px',
	)
);

/**
 * Dimensions Control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'dimensions',
		'settings'    => 'dimensions_0',
		'label'       => esc_attr__( 'Dimension Control', 'jupiterx' ),
		'description' => esc_attr__( 'Description Here.', 'jupiterx' ),
		'section'     => 'dimensions_section',
		'default'     => array(
			'width'  => '100px',
			'height' => '100px',
		),
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'dimensions',
		'settings'    => 'dimensions_1',
		'label'       => esc_attr__( 'Dimension Control', 'jupiterx' ),
		'description' => esc_attr__( 'Description Here.', 'jupiterx' ),
		'section'     => 'dimensions_section',
		'default'     => array(
			'padding-top'    => '1em',
			'padding-bottom' => '10rem',
			'padding-left'   => '1vh',
			'padding-right'  => '10px',
		),
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'spacing',
		'settings'    => 'spacing_0',
		'label'       => esc_attr__( 'Spacing Control', 'jupiterx' ),
		'description' => esc_attr__( 'Description Here.', 'jupiterx' ),
		'section'     => 'dimensions_section',
		'default'     => array(
			'top'    => '1em',
			'bottom' => '10rem',
			'left'   => '1vh',
			'right'  => '10px',
		),
	)
);

/**
 * Font-Awesome Control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'fontawesome',
		'settings'    => 'fontawesome_setting',
		'label'       => esc_attr__( 'Font Awesome Control', 'jupiterx' ),
		'description' => esc_attr__( 'Description Here.', 'jupiterx' ),
		'section'     => 'fontawesome_section',
		'default'     => 'bath',
	)
);

/**
 * Generic Controls.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'text',
		'settings'    => 'generic_text_setting',
		'label'       => esc_attr__( 'Text Control', 'jupiterx' ),
		'description' => esc_attr__( 'Description', 'jupiterx' ),
		'section'     => 'generic_section',
		'default'     => '',
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'textarea',
		'settings'    => 'generic_textarea_setting',
		'label'       => esc_attr__( 'Textarea Control', 'jupiterx' ),
		'description' => esc_attr__( 'Description', 'jupiterx' ),
		'section'     => 'generic_section',
		'default'     => '',
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'generic',
		'settings'    => 'generic_custom_setting',
		'label'       => esc_attr__( 'Custom input Control.', 'jupiterx' ),
		'description' => esc_attr__( 'The "generic" control allows you to add any input type you want. In this case we use type="password" and define custom styles.', 'jupiterx' ),
		'section'     => 'generic_section',
		'default'     => '',
		'choices'     => array(
			'element'  => 'input',
			'type'     => 'password',
			'style'    => 'background-color:black;color:red;',
			'data-foo' => 'bar',
		),
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'text',
		'settings'    => 'generic_text_setting_nested',
		'label'       => esc_attr__( 'Text Control', 'jupiterx' ),
		'description' => esc_attr__( 'Description', 'jupiterx' ),
		'section'     => 'nested_section',
		'default'     => '',
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'textarea',
		'settings'    => 'generic_textarea_setting_nested',
		'label'       => esc_attr__( 'Textarea Control', 'jupiterx' ),
		'description' => esc_attr__( 'Description', 'jupiterx' ),
		'section'     => 'nested_section',
		'default'     => '',
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'generic',
		'settings'    => 'generic_custom_setting_nested',
		'label'       => esc_attr__( 'Custom input Control.', 'jupiterx' ),
		'description' => esc_attr__( 'The "generic" control allows you to add any input type you want. In this case we use type="password" and define custom styles.', 'jupiterx' ),
		'section'     => 'nested_section',
		'default'     => '',
		'choices'     => array(
			'element'  => 'input',
			'type'     => 'password',
			'style'    => 'background-color:black;color:red;',
			'data-foo' => 'bar',
		),
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'text',
		'settings'    => 'generic_text_setting_outer',
		'label'       => esc_attr__( 'Text Control', 'jupiterx' ),
		'description' => esc_attr__( 'Description', 'jupiterx' ),
		'section'     => 'outer_section',
		'default'     => '',
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'textarea',
		'settings'    => 'generic_textarea_setting_outer',
		'label'       => esc_attr__( 'Textarea Control', 'jupiterx' ),
		'description' => esc_attr__( 'Description', 'jupiterx' ),
		'section'     => 'outer_section',
		'default'     => '',
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'generic',
		'settings'    => 'generic_custom_setting_outer',
		'label'       => esc_attr__( 'Custom input Control.', 'jupiterx' ),
		'description' => esc_attr__( 'The "generic" control allows you to add any input type you want. In this case we use type="password" and define custom styles.', 'jupiterx' ),
		'section'     => 'outer_section',
		'default'     => '',
		'choices'     => array(
			'element'  => 'input',
			'type'     => 'password',
			'style'    => 'background-color:black;color:red;',
			'data-foo' => 'bar',
		),
	)
);

/**
 * Image Control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'image',
		'settings'    => 'image_setting_url',
		'label'       => esc_attr__( 'Image Control (URL)', 'jupiterx' ),
		'description' => esc_attr__( 'Description Here.', 'jupiterx' ),
		'section'     => 'image_section',
		'default'     => '',
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'image',
		'settings'    => 'image_setting_id',
		'label'       => esc_attr__( 'Image Control (ID)', 'jupiterx' ),
		'description' => esc_attr__( 'Description Here.', 'jupiterx' ),
		'section'     => 'image_section',
		'default'     => '',
		'choices'     => array(
			'save_as' => 'id',
		),
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'image',
		'settings'    => 'image_setting_array',
		'label'       => esc_attr__( 'Image Control (array)', 'jupiterx' ),
		'description' => esc_attr__( 'Description Here.', 'jupiterx' ),
		'section'     => 'image_section',
		'default'     => '',
		'choices'     => array(
			'save_as' => 'array',
		),
	)
);

/**
 * Multicheck Control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'multicheck',
		'settings'    => 'multicheck_setting',
		'label'       => esc_attr__( 'Multickeck Control', 'jupiterx' ),
		'section'     => 'multicheck_section',
		'default'     => array( 'option-1', 'option-3', 'option-4' ),
		'priority'    => 10,
		'choices'     => array(
			'option-1' => esc_attr__( 'Option 1', 'jupiterx' ),
			'option-2' => esc_attr__( 'Option 2', 'jupiterx' ),
			'option-3' => esc_attr__( 'Option 3', 'jupiterx' ),
			'option-4' => esc_attr__( 'Option 4', 'jupiterx' ),
			'option-5' => esc_attr__( 'Option 5', 'jupiterx' ),
		),
	)
);

/**
 * Multicolor Control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'multicolor',
		'settings'    => 'multicolor_setting',
		'label'       => esc_attr__( 'Label', 'jupiterx' ),
		'section'     => 'multicolor_section',
		'priority'    => 10,
		'choices'     => array(
			'link'    => esc_attr__( 'Color', 'jupiterx' ),
			'hover'   => esc_attr__( 'Hover', 'jupiterx' ),
			'active'  => esc_attr__( 'Active', 'jupiterx' ),
		),
		'alpha'       => true,
		'default'     => array(
			'link'    => '#0088cc',
			'hover'   => '#00aaff',
			'active'  => '#00ffff',
		),
	)
);

/**
 * Number Control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'number',
		'settings'    => 'number_setting',
		'label'       => esc_attr__( 'Label', 'jupiterx' ),
		'section'     => 'number_section',
		'priority'    => 10,
		'choices'     => array(
			'min'  => -5,
			'max'  => 5,
			'step' => 1,
		),
	)
);

/**
 * Palette Control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'palette',
		'settings'    => 'palette_setting',
		'label'       => esc_attr__( 'Label', 'jupiterx' ),
		'section'     => 'palette_section',
		'default'     => 'blue',
		'choices'     => array(
			'a200'  => Kirki_Helper::get_material_design_colors( 'A200' ),
			'blue'  => Kirki_Helper::get_material_design_colors( 'blue' ),
			'green' => array( '#E8F5E9', '#C8E6C9', '#A5D6A7', '#81C784', '#66BB6A', '#4CAF50', '#43A047', '#388E3C', '#2E7D32', '#1B5E20', '#B9F6CA', '#69F0AE', '#00E676', '#00C853' ),
			'bnw'   => array( '#000000', '#ffffff' ),
		),
	)
);

/**
 * Radio Control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'radio',
		'settings'    => 'radio_setting',
		'label'       => esc_attr__( 'Radio Control', 'jupiterx' ),
		'description' => esc_attr__( 'The description here.', 'jupiterx' ),
		'section'     => 'radio_section',
		'default'     => 'option-3',
		'choices'     => array(
			'option-1' => esc_attr__( 'Option 1', 'jupiterx' ),
			'option-2' => esc_attr__( 'Option 2', 'jupiterx' ),
			'option-3' => esc_attr__( 'Option 3', 'jupiterx' ),
			'option-4' => esc_attr__( 'Option 4', 'jupiterx' ),
			'option-5' => esc_attr__( 'Option 5', 'jupiterx' ),
		),
	)
);

/**
 * Radio-Buttonset Control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'radio-buttonset',
		'settings'    => 'radio_buttonset_setting',
		'label'       => esc_attr__( 'Radio-Buttonset Control', 'jupiterx' ),
		'description' => esc_attr__( 'The description here.', 'jupiterx' ),
		'section'     => 'radio_buttonset_section',
		'default'     => 'option-2',
		'choices'     => array(
			'option-1' => esc_attr__( 'Option 1', 'jupiterx' ),
			'option-2' => esc_attr__( 'Option 2', 'jupiterx' ),
			'option-3' => esc_attr__( 'Option 3', 'jupiterx' ),
		),
	)
);

/**
 * Radio-Image Control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'radio-image',
		'settings'    => 'radio_image_setting',
		'label'       => esc_attr__( 'Radio-Image Control', 'jupiterx' ),
		'description' => esc_attr__( 'The description here.', 'jupiterx' ),
		'section'     => 'radio_image_section',
		'default'     => 'travel',
		'choices'     => array(
			'moto'    => 'https://jawordpressorg.github.io/wapuu/wapuu-archive/wapuu-moto.png',
			'cossack' => 'https://raw.githubusercontent.com/templatemonster/cossack-wapuula/master/cossack-wapuula.png',
			'travel'  => 'https://jawordpressorg.github.io/wapuu/wapuu-archive/wapuu-travel.png',
		),
	)
);

/**
 * Repeater Control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'repeater',
		'settings'    => 'repeater_setting',
		'label'       => esc_attr__( 'Repeater Control', 'jupiterx' ),
		'description' => esc_attr__( 'The description here.', 'jupiterx' ),
		'section'     => 'repeater_section',
		'default'     => array(
			array(
				'link_text'   => esc_attr__( 'Kirki Site', 'jupiterx' ),
				'link_url'    => 'https://aristath.github.io/kirki/',
				'link_target' => '_self',
				'checkbox'    => false,
			),
			array(
				'link_text'   => esc_attr__( 'Kirki Repository', 'jupiterx' ),
				'link_url'    => 'https://github.com/aristath/kirki',
				'link_target' => '_self',
				'checkbox'    => false,
			),
		),
		'fields' => array(
			'link_text' => array(
				'type'        => 'text',
				'label'       => esc_attr__( 'Link Text', 'jupiterx' ),
				'description' => esc_attr__( 'This will be the label for your link', 'jupiterx' ),
				'default'     => '',
			),
			'link_url' => array(
				'type'        => 'text',
				'label'       => esc_attr__( 'Link URL', 'jupiterx' ),
				'description' => esc_attr__( 'This will be the link URL', 'jupiterx' ),
				'default'     => '',
			),
			'link_target' => array(
				'type'        => 'select',
				'label'       => esc_attr__( 'Link Target', 'jupiterx' ),
				'description' => esc_attr__( 'This will be the link target', 'jupiterx' ),
				'default'     => '_self',
				'choices'     => array(
					'_blank'  => esc_attr__( 'New Window', 'jupiterx' ),
					'_self'   => esc_attr__( 'Same Frame', 'jupiterx' ),
				),
			),
			'checkbox' => array(
				'type'			=> 'checkbox',
				'label'			=> esc_attr__( 'Checkbox', 'jupiterx' ),
				'default'		=> false,
			),
		),
	)
);

/**
 * Select Control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'select',
		'settings'    => 'select_setting',
		'label'       => esc_attr__( 'Select Control', 'jupiterx' ),
		'description' => esc_attr__( 'The description here.', 'jupiterx' ),
		'section'     => 'select_section',
		'default'     => 'option-3',
		'placeholder' => esc_attr__( 'Select an option', 'jupiterx' ),
		'choices'     => array(
			'option-1' => esc_attr__( 'Option 1', 'jupiterx' ),
			'option-2' => esc_attr__( 'Option 2', 'jupiterx' ),
			'option-3' => esc_attr__( 'Option 3', 'jupiterx' ),
			'option-4' => esc_attr__( 'Option 4', 'jupiterx' ),
			'option-5' => esc_attr__( 'Option 5', 'jupiterx' ),
		),
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'select',
		'settings'    => 'select_setting_multiple',
		'label'       => esc_attr__( 'Select Control', 'jupiterx' ),
		'description' => esc_attr__( 'The description here.', 'jupiterx' ),
		'section'     => 'select_section',
		'default'     => 'option-3',
		'multiple'    => 3,
		'choices'     => array(
			'option-1' => esc_attr__( 'Option 1', 'jupiterx' ),
			'option-2' => esc_attr__( 'Option 2', 'jupiterx' ),
			'option-3' => esc_attr__( 'Option 3', 'jupiterx' ),
			'option-4' => esc_attr__( 'Option 4', 'jupiterx' ),
			'option-5' => esc_attr__( 'Option 5', 'jupiterx' ),
		),
	)
);

/**
 * Slider Control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'slider',
		'settings'    => 'slider_setting',
		'label'       => esc_attr__( 'Slider Control', 'jupiterx' ),
		'description' => esc_attr__( 'The description here.', 'jupiterx' ),
		'section'     => 'slider_section',
		'default'     => '10',
		'choices'     => array(
			'min'  => 0,
			'max'  => 20,
			'step' => 1,
			'suffix' => 'px',
		),
	)
);

/**
 * Sortable control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'sortable',
		'settings'    => 'sortable_setting',
		'label'       => __( 'This is a sortable control.', 'jupiterx' ),
		'section'     => 'sortable_section',
		'default'     => array( 'option3', 'option1', 'option4' ),
		'choices'     => array(
			'option1' => esc_attr__( 'Option 1', 'jupiterx' ),
			'option2' => esc_attr__( 'Option 2', 'jupiterx' ),
			'option3' => esc_attr__( 'Option 3', 'jupiterx' ),
			'option4' => esc_attr__( 'Option 4', 'jupiterx' ),
			'option5' => esc_attr__( 'Option 5', 'jupiterx' ),
			'option6' => esc_attr__( 'Option 6', 'jupiterx' ),
		),
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'sortable',
		'settings'    => 'sortable_setting_2',
		'label'       => __( 'This is a sortable control.', 'jupiterx' ),
		'section'     => 'sortable_section',
		'choices'     => array(
			'option1' => esc_attr__( 'Option 1', 'jupiterx' ),
			'option2' => esc_attr__( 'Option 2', 'jupiterx' ),
			'option3' => esc_attr__( 'Option 3', 'jupiterx' ),
			'option4' => esc_attr__( 'Option 4', 'jupiterx' ),
			'option5' => esc_attr__( 'Option 5', 'jupiterx' ),
			'option6' => esc_attr__( 'Option 6', 'jupiterx' ),
		),
	)
);

/**
 * Switch control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'switch',
		'settings'    => 'switch_setting',
		'label'       => esc_attr__( 'Switch Control', 'jupiterx' ),
		'description' => esc_attr__( 'Description', 'jupiterx' ),
		'section'     => 'switch_section',
		'default'     => true,
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'switch',
		'settings'    => 'switch_setting_custom_label',
		'label'       => esc_attr__( 'Switch Control with custom labels', 'jupiterx' ),
		'description' => esc_attr__( 'Description', 'jupiterx' ),
		'section'     => 'switch_section',
		'default'     => true,
		'choices'     => array(
			'on'  => esc_attr__( 'Enabled', 'jupiterx' ),
			'off' => esc_attr__( 'Disabled', 'jupiterx' ),
		),
		'active_callback'    => array(
			array(
				'setting'  => 'switch_setting',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

/**
 * Toggle control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'toggle',
		'settings'    => 'toggle_setting',
		'label'       => esc_attr__( 'Toggle Control', 'jupiterx' ),
		'description' => esc_attr__( 'Description', 'jupiterx' ),
		'section'     => 'toggle_section',
		'default'     => true,
	)
);

/**
 * Typography Control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'typography',
		'settings'    => 'typography_setting_0',
		'label'       => esc_attr__( 'Typography Control Label', 'jupiterx' ),
		'description' => esc_attr__( 'The full set of options.', 'jupiterx' ),
		'section'     => 'typography_section',
		'priority'    => 10,
		'transport'   => 'postMessage',
		'default'     => array(
			'font-family'     => 'Roboto',
			'variant'         => 'regular',
			'font-size'       => '14px',
			'line-height'     => '1.5',
			'letter-spacing'  => '0',
			'color'           => '#333333',
			'text-transform'  => 'none',
			'text-decoration' => 'none',
			'text-align'      => 'left',
			'margin-top'      => '0',
			'margin-bottom'   => '0',
		),
		'choices' => array(
			'fonts' => array(
				'google'   => array( 'popularity', 60 ),
				'families' => array(
					'custom' => array(
						'text'     => 'My Custom Fonts (demo only)',
						'children' => array(
							array( 'id' => 'helvetica-neue', 'text' => 'Helvetica Neue' ),
							array( 'id' => 'linotype-authentic', 'text' => 'Linotype Authentic' ),
						),
					),
				),
				'variants' => array(
					'helvetica-neue'     => array( 'regular', '900' ),
					'linotype-authentic' => array( 'regular', '100', '300' ),
				)
			),
		),
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'typography',
		'settings'    => 'typography_setting_1',
		'label'       => esc_attr__( 'Typography Control Label', 'jupiterx' ),
		'description' => esc_attr__( 'The full set of options.', 'jupiterx' ),
		'section'     => 'typography_section',
		'priority'    => 10,
		'transport'   => 'postMessage',
		'default'     => array(
			'font-family'     => 'Roboto',
		),
	)
);

function kirki_sidebars_select_example() {
	$sidebars = array();
	if ( isset( $GLOBALS['wp_registered_sidebars'] ) ) {
		$sidebars = $GLOBALS['wp_registered_sidebars'];
	}
	$sidebars_choices = array();
	foreach ( $sidebars as $sidebar ) {
		$sidebars_choices[ $sidebar['id'] ] = $sidebar['name'];
	}
	if ( ! class_exists( 'Kirki' ) ) {
		return;
	}
	Kirki::add_field( 'jupiter', array(
		'type'        => 'select',
		'settings'    => 'sidebars_select',
		'label'       => esc_attr__( 'Sidebars Select', 'jupiterx' ),
		'description' => esc_attr__( 'An example of how to implement sidebars selection.', 'jupiterx' ),
		'section'     => 'select_section',
		'default'     => 'primary',
		'choices'     => $sidebars_choices,
		'priority'    => 30,
	) );
}
add_action( 'init', 'kirki_sidebars_select_example', 999 );
