<?php
/**
 * Jupiter Social networks Widget.
 *
 * Widget defined here and the options are loading using custom fields.
 *
 * @package JupiterX\Framework\API\Widgets
 *
 * @since 1.0.0
 */

/**
 * Defines new widget as Social Widget.
 *
 * @since   1.0.0
 * @ignore
 * @access  private
 *
 * @package JupiterX\Framework\API\Widgets
 */
class JupiterX_Widget_Social extends JupiterX_Widget {

	/**
	 * Setup new widget.
	 */
	public function __construct() {
		$props = [
			'name'        => __( 'Jupiter X - Social Networks', 'jupiterx' ),
			'description' => __( 'Social network icons.', 'jupiterx' ),
			'settings'    => [
				[
					'name' => 'title',
					'label' => __( 'Title', 'jupiterx' ),
					'type' => 'text',
				],
				[
					'label'   => __( 'Choose social networks', 'jupiterx' ),
					'name'    => 'networks',
					'type'    => 'flexible',
					'options' => [
						'android'        => __( 'Android', 'jupiterx' ),
						'apple'          => __( 'Apple', 'jupiterx' ),
						'behance'        => __( 'Behance', 'jupiterx' ),
						'bitbucket'      => __( 'Bitbucket', 'jupiterx' ),
						'delicious'      => __( 'Delicious', 'jupiterx' ),
						'digg'           => __( 'Digg', 'jupiterx' ),
						'dribbble'       => __( 'Dribbble', 'jupiterx' ),
						'facebook'       => __( 'Facebook', 'jupiterx' ),
						'flickr'         => __( 'Flickr', 'jupiterx' ),
						'foursquare'     => __( 'Foursquare', 'jupiterx' ),
						'github'         => __( 'Github', 'jupiterx' ),
						'google-plus'    => __( 'Google Plus', 'jupiterx' ),
						'instagram'      => __( 'Instagram', 'jupiterx' ),
						'jsfiddle'       => __( 'JSFiddle', 'jupiterx' ),
						'linkedin'       => __( 'Linkedin', 'jupiterx' ),
						'medium'         => __( 'Medium', 'jupiterx' ),
						'pinterest'      => __( 'Pinterest', 'jupiterx' ),
						'product-hunt'   => __( 'Product Hunt', 'jupiterx' ),
						'reddit'         => __( 'Reddit', 'jupiterx' ),
						'rss'            => __( 'RSS', 'jupiterx' ),
						'skype'          => __( 'Skype', 'jupiterx' ),
						'snapchat'       => __( 'Snapchat', 'jupiterx' ),
						'soundcloud'     => __( 'Soundcloud', 'jupiterx' ),
						'spotify'        => __( 'Spotify', 'jupiterx' ),
						'stack-overflow' => __( 'Stack Overflow', 'jupiterx' ),
						'steam'          => __( 'Steam', 'jupiterx' ),
						'stumbleupon'    => __( 'Stumbleupon', 'jupiterx' ),
						'telegram'       => __( 'Telegram', 'jupiterx' ),
						'tripadvisor'    => __( 'TripAdvisor', 'jupiterx' ),
						'tumblr'         => __( 'Tumblr', 'jupiterx' ),
						'twitch'         => __( 'Twitch', 'jupiterx' ),
						'twitter'        => __( 'Twitter', 'jupiterx' ),
						'vimeo'          => __( 'Vimeo', 'jupiterx' ),
						'vk'             => __( 'VK', 'jupiterx' ),
						'weibo'          => __( 'Weibo', 'jupiterx' ),
						'weixin'         => __( 'Weixin', 'jupiterx' ),
						'whatsapp'       => __( 'Whatsapp', 'jupiterx' ),
						'wordpress'      => __( 'WordPress', 'jupiterx' ),
						'xing'           => __( 'Xing', 'jupiterx' ),
						'yelp'           => __( 'Yelp', 'jupiterx' ),
						'youtube'        => __( 'Youtube', 'jupiterx' ),
						'500px'          => __( '500px', 'jupiterx' ),
					],
				],
				[
					'name'  => 'new_tab',
					'type'  => 'checkbox',
					'label' => __( 'Open links in new tab', 'jupiterx' ),
				],
				[
					'name' => 'divider_1',
					'type' => 'divider',
				],
				[
					'name'    => 'icon_size',
					'type'    => 'number',
					'label'   => __( 'Icon size', 'jupiterx' ),
					'atts'    => [ 'min' => '8' ],
					'default' => '24',
				],
				[
					'name'  => 'border_radius',
					'type'  => 'number',
					'label' => __( 'Border radius', 'jupiterx' ),
					'atts'  => [ 'min' => '0' ],
				],
				[
					'name'  => 'icons_space',
					'type'  => 'number',
					'label' => __( 'Space between icons', 'jupiterx' ),
				],
				[
					'name'  => 'custom_colors',
					'type'  => 'checkbox',
					'label' => __( 'Use custom colors', 'jupiterx' ),
				],
				[
					'name'      => 'icon_color',
					'type'      => 'color',
					'label'     => __( 'Icon color', 'jupiterx' ),
					'default'   => '#FFFFFF',
					'condition' => [
						'setting' => 'custom_colors',
					],
				],
				[
					'name'      => 'background_color',
					'type'      => 'color',
					'label'     => __( 'Background color', 'jupiterx' ),
					'default'   => '#000000',
					'condition' => [
						'setting' => 'custom_colors',
					],
				],
				[
					'name'      => 'icon_color_hover',
					'type'      => 'color',
					'label'     => __( 'Icon hover color', 'jupiterx' ),
					'default'   => '#FFFFFF',
					'condition' => [
						'setting' => 'custom_colors',
					],
				],
				[
					'name'      => 'background_color_hover',
					'type'      => 'color',
					'label'     => __( 'Background hover color', 'jupiterx' ),
					'default'   => '#000000',
					'condition' => [
						'setting' => 'custom_colors',
					],
				],
			],
		];

		parent::__construct(
			'jupiterx_social',
			esc_html__( 'Jupiter X - Social Networks', 'jupiterx' ),
			$props
		);
	}

	/**
	 * Outputs the content of the widget.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Widget instance.
	 *
	 * @return void
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 */
	public function widget( $args, $instance ) {
		$defaults = [
			'title'                  => '',
			'networks'               => [],
			'new_tab'                => '',
			'icon_size'              => '',
			'border_radius'          => '',
			'icons_space'            => '',
			'custom_colors'          => '',
			'icon_color'             => '',
			'background_color'       => '',
			'icon_color_hover'       => '',
			'background_color_hover' => '',
		];

		$instance  = wp_parse_args( $instance, $defaults );
		$id        = 'widget_' . $args['widget_id'];
		$unique_id = uniqid( 'jupiterx-social-widget-wrapper-' );
		$title     = $instance['title'];
		$networks  = (array) $instance['networks'];
		$target    = $instance['new_tab'] ? '_blank' : '_self';

		echo $args['before_widget']; // @phpcs:ignore

		$this->render_custom_css( $instance, $unique_id );

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // @phpcs:ignore
		}

		if ( ! empty( $networks ) ) {

			jupiterx_open_markup_e( 'jupiterx_widget_social_wrapper', 'div', 'class=jupiterx-social-widget-wrapper ' . $unique_id );

			foreach ( $networks as $name => $network ) {
				// Data converts to object while importing template.
				$network = (array) $network;

				if ( empty( $network['value'] ) ) {
					continue;
				}

				$label = $network['label'];
				$url   = $network['value'];

				jupiterx_open_markup_e( 'jupiterx_widget_social_link', 'a', [
					'href'   => esc_url( $url ),
					'class'  => 'jupiterx-widget-social-share-link btn jupiterx-widget-social-icon-' . esc_attr( $name ),
					'target' => $target,
				] );

					jupiterx_open_markup_e( 'jupiterx_widget_social_icon_screen_reader', 'span', 'class=screen-reader-text' );

						echo esc_html( $label );

					jupiterx_close_markup_e( 'jupiterx_widget_social_icon_screen_reader', 'span' );

					jupiterx_open_markup_e( 'jupiterx_widget_social_icon', 'span', 'class=jupiterx-social-icon jupiterx-icon-' . esc_attr( $name ) );

					jupiterx_close_markup_e( 'jupiterx_widget_social_icon', 'span' );

				jupiterx_close_markup_e( 'jupiterx_widget_social_link', 'a' );

			}

			jupiterx_close_markup_e( 'jupiterx_widget_social_wrapper', 'div' );

		}

		echo $args['after_widget']; // @phpcs:ignore
	}

	/**
	 * Render the current widget instance custom css.
	 *
	 * @param string $instance         Widget instance.
	 * @param string $unique_id Widget instance unique ID.
	 *
	 * @return void
	 */
	public function render_custom_css( $instance, $unique_id ) {
		$icon_size     = $instance['icon_size'];
		$border_radius = $instance['border_radius'];
		$icons_space   = $instance['icons_space'];
		$custom_color  = $instance['custom_colors'];

		$unique_selector  = ".{$unique_id}";
		$wrapper_style    = '';
		$link_style       = '';
		$icon_style       = '';
		$link_hover_style = '';
		$icon_hover_style = '';

		if ( ! empty( $icon_size ) ) {
			$icon_style .= 'font-size:' . $icon_size . 'px;';
			$link_style .= 'padding:' . $icon_size * 0.5 . 'px;';
		}

		if ( is_numeric( $border_radius ) ) {
			$link_style .= 'border-radius:' . $border_radius . 'px;';
		}

		if ( ! empty( $icons_space ) ) {
			$wrapper_style .= 'margin-right:calc(-' . $icons_space . 'px/2);';
			$wrapper_style .= 'margin-left:calc(-' . $icons_space . 'px/2);';
			$link_style    .= 'margin-right:calc(' . $icons_space . 'px/2);';
			$link_style    .= 'margin-left:calc(' . $icons_space . 'px/2);';
			$link_style    .= 'margin-bottom:' . $icons_space . 'px;';
		}

		if ( $custom_color ) {
			$color          = $instance['icon_color'];
			$bg_color       = $instance['background_color'];
			$hover_color    = $instance['icon_color_hover'];
			$bg_hover_color = $instance['background_color_hover'];

			$icon_style .= 'color:' . $color . ';';
			$link_style .= 'background-color:' . $bg_color . ';';

			$icon_hover_style = 'color:' . $hover_color . ';';
			$link_hover_style = 'background-color:' . $bg_hover_color . ';';
		}

		// phpcs:disable
		jupiterx_open_markup_e( 'jupiterx_social_widget_styles', 'style' );

			$widget_styles = [
				"$unique_selector"                                                              => $wrapper_style,
				"$unique_selector .jupiterx-widget-social-share-link"                            => $link_style,
				"$unique_selector .jupiterx-widget-social-share-link:hover"                      => $link_hover_style,
				"$unique_selector .jupiterx-widget-social-share-link .jupiterx-social-icon"       => $icon_style,
				"$unique_selector .jupiterx-widget-social-share-link:hover .jupiterx-social-icon" => $icon_hover_style,
			];

			foreach ( $widget_styles as $selector => $styles ) {
				if ( ! empty( $styles ) ) {
					echo "$selector { $styles }";
				}
			}

		jupiterx_close_markup_e( 'jupiterx_social_widget_styles', 'style' );
		// phpcs:enable
	}
}
