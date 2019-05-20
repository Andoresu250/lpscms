<?php
/**
 * Echo header fragments.
 *
 * @package JupiterX\Framework\Templates\Fragments
 *
 * @since   1.0.0
 */

jupiterx_add_smart_action( 'jupiterx_head', 'jupiterx_head_meta', 0 );
/**
 * Echo head meta.
 *
 * @since 1.0.0
 *
 * @return void
 */
function jupiterx_head_meta() {
	?>
	<meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php
}

jupiterx_add_smart_action( 'wp_head', 'jupiterx_head_pingback' );
/**
 * Echo head pingback.
 *
 * @since 1.0.0
 *
 * @return void
 */
function jupiterx_head_pingback() {
	?>
	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
	<?php
}

jupiterx_add_smart_action( 'wp_head', 'jupiterx_favicon' );
/**
 * Echo head favicon if no icon was added via the customizer.
 *
 * @since 1.0.0
 *
 * @return void
 */
function jupiterx_favicon() {

	// Stop here if and icon was added via the customizer.
	if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
		return;
	}

	$url = file_exists( get_stylesheet_directory() . '/favicon.ico' ) ? get_stylesheet_directory_uri() . '/favicon.ico' : JUPITERX_URL . 'favicon.ico';

	jupiterx_selfclose_markup_e(
		'jupiterx_favicon',
		'link',
		array(
			'rel'  => 'Shortcut Icon',
			'href' => $url, // Automatically escaped.
			'type' => 'image/x-icon',
		)
	);
}

jupiterx_add_filter( 'jupiterx_register_fonts', 'jupiterx_add_typography_fonts' );
/**
 * Add typography fonts to enqueue list.
 *
 * @since 1.0.0
 *
 * @param array $registered_fonts Registered fonts.
 *
 * @return array
 */
function jupiterx_add_typography_fonts( $registered_fonts ) {
	$fonts = get_theme_mod( 'jupiterx_typography_fonts', [] );

	if ( empty( $fonts ) ) {
		return $registered_fonts;
	}

	foreach ( $fonts as $font ) {
		$registered_fonts[ $font['name'] ] = $font['type'];
	}

	return $registered_fonts;
}

jupiterx_add_smart_action( 'wp_enqueue_scripts', 'jupiterx_google_analytics' );
/**
 * Echo Google Analytics script in header.
 *
 * @since 1.0.0
 *
 * @return void
 */
function jupiterx_google_analytics() {
	$ga_id        = get_option( 'jupiterx_google_analytics_id' );
	$anonymize_ip = get_option( 'jupiterx_google_analytics_anonymization', true );

	if ( empty( $ga_id ) ) {
		return;
	}

	$ga_url = 'https://www.googletagmanager.com/gtag/js?id=' . esc_attr( $ga_id );
	// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
	wp_enqueue_script( 'jupiterx-gtag-script', $ga_url, array(), null, false );
	wp_add_inline_script(
		'jupiterx-gtag-script',
		jupiterx_google_analytics_inline_script( $ga_id, $anonymize_ip )
	);

	add_filter( 'script_loader_tag', 'jupiterx_make_script_async', 10, 2 );
}

/**
 * Get inline script part of Google Analytics script.
 *
 * @since 1.2.0
 *
 * @param string $ga_id Google Analytics Tracking Id.
 * @param string $anonymize_ip IP Anonymization.
 *
 * @return string
 * @SuppressWarnings(PHPMD.ElseExpression)
 */
function jupiterx_google_analytics_inline_script( $ga_id, $anonymize_ip ) {
	ob_start();

	// phpcs:disable
	?>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		<?php if ( $anonymize_ip ) : ?>
			gtag('config', '<?php echo esc_attr( $ga_id ); ?>', { 'anonymize_ip': true });
		<?php else : ?>
			gtag('config', '<?php echo esc_attr( $ga_id ); ?>');
		<?php endif; ?>
	</script>
	<?php
	// phpcs:enable

	return str_replace( array( '<script>', '</script>' ), '', ob_get_clean() );
}

/**
 * Add async attribute to script.
 *
 * @since 1.2.0
 *
 * @param string $tag Script tag.
 * @param string $handle Enqueued script handle.
 *
 * @return string
 */
function jupiterx_make_script_async( $tag, $handle ) {
	$async_scripts_handle = array( 'jupiterx-gtag-script' );

	if ( ! in_array( $handle, $async_scripts_handle, true ) ) {
		return $tag;
	}

	return preg_replace( '/<script/', '<script async', $tag, 1 );
}

jupiterx_add_smart_action( 'jupiterx_header', 'jupiterx_site_navbar' );
/**
 * Echo header site navbar.
 *
 * @since 1.0.0
 *
 * @return void
 * @SuppressWarnings(PHPMD.ElseExpression)
 */
function jupiterx_site_navbar() {
	$class           = [ 'jupiterx-site-navbar', 'navbar', 'navbar-expand-md', 'navbar-light' ];
	$container_class = 'container';
	$align           = jupiterx_get_option( 'jupiterx_header_align', '', [
		'desktop' => 'row',
		'tablet'  => 'row',
		'mobile'  => 'row',
	] );

	// Align.
	foreach ( $align as $device => $align ) {
		if ( 'row' === $align ) {
			$class[] = 'jupiterx-navbar-' . $device . '-left';
			continue;
		}

		$class[] = 'jupiterx-navbar-' . $device . '-right';
	}

	// Full width.
	if ( true === get_theme_mod( 'jupiterx_header_full_width', false ) ) {
		$container_class = 'container-fluid';
	}

	jupiterx_open_markup_e(
		'jupiterx_site_navbar',
		'nav',
		[
			'class'     => implode( ' ', $class ),
			'role'      => 'navigation',
			'itemscope' => 'itemscope',
			'itemtype'  => 'http://schema.org/SiteNavigationElement',
		]
	);

		jupiterx_open_markup_e( 'jupiterx_navbar_container', 'div', 'class=' . $container_class );

			jupiterx_open_markup_e(
				'jupiterx_navbar_collapse',
				'div',
				[
					'class' => 'collapse navbar-collapse',
					'id'    => 'jupiterxSiteNavbar',
				]
			);

			jupiterx_close_markup_e( 'jupiterx_navbar_collapse', 'div' );

			jupiterx_open_markup_e( 'jupiterx_navbar_content', 'div', 'class=jupiterx-navbar-content' );

			jupiterx_close_markup_e( 'jupiterx_navbar_content', 'div' );

		jupiterx_close_markup_e( 'jupiterx_navbar_container', 'div' );

	jupiterx_close_markup_e( 'jupiterx_site_navbar', 'nav' );
}

jupiterx_add_smart_action( 'jupiterx_navbar_container_prepend_markup', 'jupiterx_navbar_brand' );
/**
 * Echo header navbar brand.
 *
 * @since 1.0.0
 *
 * @return void
 * @SuppressWarnings(PHPMD.ElseExpression)
 */
function jupiterx_navbar_brand() {
	jupiterx_open_markup_e( 'jupiterx_navbar_brand', 'div', 'class=jupiterx-navbar-brand' );

		$link_class = [
			'jupiterx-navbar-brand-link',
			'navbar-brand',
		];

		$logo        = get_theme_mod( 'jupiterx_header_logo', 'jupiterx_logo' );
		$logo_image  = get_theme_mod( $logo );
		$logo_sticky = get_theme_mod( 'jupiterx_logo_sticky' );
		$logo_mobile = get_theme_mod( 'jupiterx_logo_mobile' );

		if ( $logo_sticky ) {
			$link_class[] = 'navbar-brand-sticky';
		}

		if ( $logo_mobile ) {
			$link_class[] = 'navbar-brand-mobile';
		}

		jupiterx_open_markup_e(
			'jupiterx_navbar_brand_link',
			'a',
			[
				'href'     => home_url(), // Automatically escaped.
				'class'    => implode( ' ', $link_class ),
				'rel'      => 'home',
				'itemprop' => 'headline',
			]
		);

			if ( $logo_image ) {

				$logo_retina = get_theme_mod( $logo . '_retina' );
				$image_attrs = $logo_retina ? [ 'srcset' => "{$logo_image} 1x, {$logo_retina} 2x" ] : [];

				jupiterx_open_markup_e(
					'jupiterx_navbar_brand_logo',
					'img',
					array_merge( [
						'src'   => esc_url( $logo_image ),
						'class' => 'jupiterx-navbar-brand-img',
					], $image_attrs )
				);

				if ( $logo_sticky ) {

					$logo_retina = get_theme_mod( 'jupiterx_logo_sticky_retina' );
					$image_attrs = $logo_retina ? [ 'srcset' => "{$logo_sticky} 1x, {$logo_retina} 2x" ] : [];

					jupiterx_open_markup_e(
						'jupiterx_navbar_brand_logo_sticky',
						'img',
						array_merge( [
							'src'   => esc_url( $logo_sticky ),
							'class' => 'jupiterx-navbar-brand-img jupiterx-navbar-brand-img-sticky',
						], $image_attrs )
					);

				}

				if ( $logo_mobile ) {

					$logo_retina = get_theme_mod( 'jupiterx_logo_mobile_retina' );
					$image_attrs = $logo_retina ? [ 'srcset' => "{$logo_mobile} 1x, {$logo_retina} 2x" ] : [];

					jupiterx_open_markup_e(
						'jupiterx_navbar_brand_logo_mobile',
						'img',
						array_merge( [
							'src'   => esc_url( $logo_mobile ),
							'class' => 'jupiterx-navbar-brand-img jupiterx-navbar-brand-img-mobile',
						], $image_attrs )
					);
				}
			} else {

				jupiterx_output_e( 'jupiterx_navbar_brand_text', get_bloginfo( 'name' ) );

			}

		jupiterx_close_markup_e( 'jupiterx_navbar_brand_link', 'a' );

	jupiterx_close_markup_e( 'jupiterx_navbar_brand', 'div' );
}

jupiterx_add_smart_action( 'jupiterx_navbar_brand_link_after_markup', 'jupiterx_navbar_description' );
/**
 * Echo header navbar description.
 *
 * @since 1.0.0
 *
 * @return void
 */
function jupiterx_navbar_description() {
	// Stop here if there isn't a description.
	$description = get_bloginfo( 'description' );

	if ( ! $description || get_theme_mod( 'jupiterx_logo' ) ) {
		return;
	}

	jupiterx_open_markup_e(
		'jupiterx_navbar_description',
		'span',
		[
			'class'    => 'jupiterx-navbar-description navbar-text',
			'itemprop' => 'description',
		]
	);

		jupiterx_output_e( 'jupiterx_navbar_description_text', $description );

	jupiterx_close_markup_e( 'jupiterx_navbar_description', 'span' );
}

jupiterx_add_smart_action( 'jupiterx_navbar_content_append_markup', 'jupiterx_navbar_toggler', 20 );
/**
 * Echo header navbar toggler.
 *
 * @since 1.0.0
 *
 * @return void|bool False if Ubermenu is active.
 */
function jupiterx_navbar_toggler() {
	// Check for ubermenu to prevent duplicate toggles.
	if ( function_exists( 'ubermenu' ) ) {
		return false;
	}

	$classes  = 'jupiterx-navbar-toggler navbar-toggler';
	$defaults = [ 'logo', 'menu', 'search', 'cart' ];
	$devices  = [ 'tablet', 'mobile' ];
	$elements = get_theme_mod( 'jupiterx_header_elements' );

	foreach ( $devices as $device ) {
		if ( ! isset( $elements[ $device ] ) ) {
			$elements[ $device ] = $defaults;
		}

		if ( ! in_array( 'menu', $elements[ $device ], true ) && ! in_array( 'search', $elements[ $device ], true ) ) {
			$classes .= " jupiterx-{$device}-hidden";
		}
	}

	jupiterx_open_markup_e(
		'jupiterx_navbar_toggler',
		'button',
		[
			'class'         => $classes,
			'type'          => 'button',
			'data-toggle'   => 'collapse',
			'data-target'   => '#jupiterxSiteNavbar',
			'aria-controls' => 'jupiterxSiteNavbar',
			'aria-expanded' => 'false',
			'aria-label'    => __( 'Toggle navigation', 'jupiterx' ),
		]
	);

		jupiterx_open_markup_e( 'navbar_toggler_icon', 'span', 'class=navbar-toggler-icon' );

		jupiterx_close_markup_e( 'navbar_toggler_icon', 'span' );

	jupiterx_close_markup_e( 'jupiterx_navbar_toggler', 'button' );
}

jupiterx_add_smart_action( 'jupiterx_site_before_markup', 'jupiterx_modify_site_markup' );

/**
 * Modify site markup.
 *
 * @since 1.0.0
 */
function jupiterx_modify_site_markup() {

	if ( 'boxed' === get_theme_mod( 'jupiterx_site_width', 'full_width' ) ) {
		jupiterx_wrap_inner_markup( 'jupiterx_site', 'jupiterx_site_container', 'div', 'class=jupiterx-site-container' );
	}

	if ( get_theme_mod( 'jupiterx_site_body_border_enabled', false ) && 'full_width' === get_theme_mod( 'jupiterx_site_width', 'full_width' ) ) {
		$position = get_theme_mod( 'jupiterx_site_main_border_enabled', false ) ? 'main' : 'body';

		jupiterx_add_attribute( 'jupiterx_site', 'class', 'jupiterx-site-' . $position . '-border' );
	}

}
