<?php
/**
 * Prepare and initialize the Jupiter framework.
 *
 * @package JupiterX\Framework
 *
 * @since   1.0.0
 */

add_action( 'jupiterx_before_init', 'jupiterx_check_requirements', -1 );
/**
 * Check JupiterX theme requirements.
 *
 * @since 1.2.0
 *
 * @return void
 */
function jupiterx_check_requirements() {

	if ( ! version_compare( phpversion(), '5.6', '<' ) ) {
		return;
	}

	$output = '<h2>' . __( 'Maintenance Mode', 'jupiterx' ) . '</h2><hr />';

	$output .= '<p>' . __( 'We\'re updating our website. Please check back soon.', 'jupiterx' ) . '</p>';

	if ( current_user_can( 'manage_options' ) || current_user_can( 'manage_network' ) ) {
		$output .= '<p>' . __( 'Resolve following issues to disable Maintenance Mode. (This part of message is visible to admin users.)', 'jupiterx' ) . '</p>';

		$issues = array(
			sprintf(// translators: 1: PHP version, 2: URL to JupiterX requirements page.
				__( 'Your server\'s PHP version (%1$s) is not supported. This version is old, insecure and slow. Please read <a href="%2$s" target="_blank">Checking Server Requirements</a> article to learn about WordPress, Jupiter X and other plugins\' server requirements. You may contact your host provider/server administrator to increase the PHP version', 'jupiterx' ),
				esc_attr( phpversion() ),
				'https://help.artbees.net/getting-started/installing-the-theme/jupiter-x-server-requirements'
			),
		);

		$output .= '<ul>';

		foreach ( $issues as $issue ) {
			$output .= '<li>' . $issue . '</li>';
		}

		$output .= '</ul>';
	}

	echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	wp_die();
}

add_action( 'jupiterx_init', 'jupiterx_update_plugins_requirements', 0 );
/**
 * Check update plugins requirements.
 *
 * @since 1.3.0
 *
 * @return void
 *
 * @SuppressWarnings(PHPMD.ElseExpression)
 */
function jupiterx_update_plugins_requirements() {
	if ( is_admin() || in_array( $GLOBALS['pagenow'], [ 'wp-login.php' ], true ) || ! get_site_transient( 'jupiterx_update_plugins_notice' ) ) {
		return;
	}

	$plugins = jupiterx_get_update_plugins();

	if ( empty( $plugins ) ) {
		return;
	}

	if ( current_user_can( 'update_plugins' ) ) {
		$output = '<h2>' . __( 'Important plugins waiting to be updated!', 'jupiterx' ) . '</h2><hr />';

		$output .= '<p>' . __( 'Resolve following issues to disable Maintenance Mode. (This part of message is visible to admin users.)', 'jupiterx' ) . '</p>';

		$output .= '<p>';

		$output .= sprintf(
			// translators: 1: Control panel link.
			esc_html__( 'Go to %s page. Install and activate the following plugins:', 'jupiterx' ),
			'<a href="' . admin_url( '?page=jupiterx&force_check=1#install-plugins' ) . '">' . esc_html__( 'Control Panel > Plugins', 'jupiterx' ) . '</a>'
		);

		$output .= '</p>';

		$output .= '<ul>';

		foreach ( $plugins as $plugin ) {
			$output .= '<li>' . $plugin['name'] . '</li>';
		}

		$output .= '</ul>';
	} else {
		$output = '<h1>' . __( 'Maintenance Mode', 'jupiterx' ) . '</h1>';

		$output .= '<p>' . __( 'We\'re updating our website. Please check back soon.', 'jupiterx' ) . '</p>';
	}

	echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	wp_die();
}

add_action( 'jupiterx_init', 'jupiterx_premium_requirements', 0 );
/**
 * Check JupiterX initial premium requirements.
 *
 * @since 1.3.0
 */
function jupiterx_premium_requirements() {
	if (
		is_admin() ||
		in_array( $GLOBALS['pagenow'], [ 'wp-login.php' ], true ) ||
		! jupiterx_is_registered() ||
		jupiterx_is_plugin_active( 'pro' )
	) {
		return;
	}

	$output = '<h2>' . __( 'Maintenance Mode', 'jupiterx' ) . '</h2><hr />';

	$output .= '<p>' . __( 'We\'re updating our website. Please check back soon.', 'jupiterx' ) . '</p>';

	if ( current_user_can( 'manage_options' ) || current_user_can( 'manage_network' ) ) {
		$output .= '<p>' . __( 'Resolve following issues to disable Maintenance Mode. (This part of message is visible to admin users.)', 'jupiterx' ) . '</p>';

		$issues = array(
			sprintf(
				// translators: 1: Control panel link.
				esc_html__( 'Go to %s and activate Jupiter X Pro plugin.', 'jupiterx' ),
				'<a href="' . admin_url( '?page=jupiterx&force_check=1#install-plugins' ) . '">' . esc_html__( 'Control Panel > Plugins', 'jupiterx' ) . '</a>'
			),
		);

		$output .= '<ul>';

		foreach ( $issues as $issue ) {
			$output .= '<li>' . $issue . '</li>';
		}

		$output .= '</ul>';
	}

	echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	wp_die();
}

add_action( 'jupiterx_init', 'jupiterx_define_constants', -1 );
/**
 * Define constants.
 *
 * @since 1.0.0
 * @ignore
 *
 * @return void
 */
function jupiterx_define_constants() {
	$theme_data = get_file_data( get_template_directory() . '/style.css', [ 'Version' ], 'jupiterx' );

	// Define premium.
	if ( ! defined( 'JUPITERX_PREMIUM' ) ) {
		define( 'JUPITERX_PREMIUM', false );
	}

	// Define version.
	define( 'JUPITERX_VERSION', array_shift( $theme_data ) );
	define( 'JUPITERX_INITIAL_FREE_VERSION', '1.3.0' );
	define( 'JUPITERX_NAME', 'Jupiter X' );
	define( 'JUPITERX_SLUG', 'jupiterx' );

	// Define paths.
	if ( ! defined( 'JUPITERX_THEME_PATH' ) ) {
		define( 'JUPITERX_THEME_PATH', wp_normalize_path( trailingslashit( get_template_directory() ) ) );
	}

	define( 'JUPITERX_PATH', JUPITERX_THEME_PATH . 'lib/' );
	define( 'JUPITERX_API_PATH', JUPITERX_PATH . 'api/' );
	define( 'JUPITERX_ASSETS_PATH', JUPITERX_PATH . 'assets/' );
	define( 'JUPITERX_LANGUAGES_PATH', JUPITERX_PATH . 'languages/' );
	define( 'JUPITERX_RENDER_PATH', JUPITERX_PATH . 'render/' );
	define( 'JUPITERX_TEMPLATES_PATH', JUPITERX_PATH . 'templates/' );
	define( 'JUPITERX_STRUCTURE_PATH', JUPITERX_TEMPLATES_PATH . 'structure/' );
	define( 'JUPITERX_FRAGMENTS_PATH', JUPITERX_TEMPLATES_PATH . 'fragments/' );

	// Define urls.
	if ( ! defined( 'JUPITERX_THEME_URL' ) ) {
		define( 'JUPITERX_THEME_URL', trailingslashit( get_template_directory_uri() ) );
	}

	define( 'JUPITERX_URL', JUPITERX_THEME_URL . 'lib/' );
	define( 'JUPITERX_API_URL', JUPITERX_URL . 'api/' );
	define( 'JUPITERX_ASSETS_URL', JUPITERX_URL . 'assets/' );
	define( 'JUPITERX_LESS_URL', JUPITERX_ASSETS_URL . 'less/' );
	define( 'JUPITERX_JS_URL', JUPITERX_ASSETS_URL . 'js/' );
	define( 'JUPITERX_IMAGE_URL', JUPITERX_ASSETS_URL . 'images/' );

	// Define admin paths.
	define( 'JUPITERX_ADMIN_PATH', JUPITERX_PATH . 'admin/' );

	// Define admin url.
	define( 'JUPITERX_ADMIN_URL', JUPITERX_URL . 'admin/' );
	define( 'JUPITERX_ADMIN_ASSETS_URL', JUPITERX_ADMIN_URL . 'assets/' );
	define( 'JUPITERX_ADMIN_JS_URL', JUPITERX_ADMIN_ASSETS_URL . 'js/' );

	// Define helpers.
	define( 'JUPITERX_IMAGE_SIZE_OPTION', JUPITERX_SLUG . '_image_sizes' );
}

add_action( 'jupiterx_init', 'jupiterx_load_dependencies', -1 );
/**
 * Load dependencies.
 *
 * @since 1.0.0
 * @ignore
 *
 * @return void
 */
function jupiterx_load_dependencies() {
	require_once JUPITERX_API_PATH . 'init.php';

	$components = [
		'api',
		'compatibility',
		'actions',
		'html',
		'term-meta',
		'post-meta',
		'image',
		'fonts',
		'customizer',
		'custom-fields',
		'template',
		'layout',
		'header',
		'menu',
		'widget',
		'footer',
		'elementor',
		'woocommerce',
		'lazy-load',
		'unboarding',
	];

	// Load the necessary Jupiter components.
	jupiterx_load_api_components( $components );

	// Add third party styles and scripts compiler support.
	jupiterx_add_api_component_support( 'wp_styles_compiler' );
	jupiterx_add_api_component_support( 'wp_scripts_compiler' );

	/**
	 * Fires after Jupiter API loads.
	 *
	 * @since 1.0.0
	 */
	do_action( 'jupiterx_after_load_api' );
}

add_action( 'jupiterx_init', 'jupiterx_add_theme_support' );
/**
 * Add theme support.
 *
 * @since 1.0.0
 * @ignore
 *
 * @return void
 */
function jupiterx_add_theme_support() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

	// Jupiter specific.
	add_theme_support( 'jupiterx-default-styling' );

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'woocommerce' );

	/**
	 * Image sizes.
	 *
	 * @todo Find a possible better place to add the functions.
	 */
	$image_sizes = get_option( JUPITERX_IMAGE_SIZE_OPTION );

	if ( ! empty( $image_sizes ) ) {
		foreach ( $image_sizes as $size ) {

			$width  = absint( $size['size_w'] );
			$height = absint( $size['size_h'] );

			$is_valid_width  = ( ! empty( $width ) && $width > 0 ) ? true : false;
			$is_valid_height = ( ! empty( $height ) && $height > 0 ) ? true : false;

			if ( ! $is_valid_width || ! $is_valid_height ) {
				continue;
			}

			$crop = ( isset( $size['size_c'] ) && 'on' === $size['size_c'] ) ? true : false;

			add_image_size( $size['size_n'], $width, $height, $crop );
		}
	}
}

add_action( 'jupiterx_init', 'jupiterx_includes' );
/**
 * Include framework files.
 *
 * @since 1.0.0
 * @ignore
 *
 * @return void
 */
function jupiterx_includes() {
	// Include admin.
	if ( is_admin() ) {
		require_once JUPITERX_ADMIN_PATH . 'assets.php';
		require_once JUPITERX_ADMIN_PATH . 'core-install/core-install.php';
		require_once JUPITERX_ADMIN_PATH . 'options.php';
		require_once JUPITERX_ADMIN_PATH . 'control-panel/control-panel.php';
		require_once JUPITERX_ADMIN_PATH . 'setup-wizard/setup-wizard.php';
		require_once JUPITERX_ADMIN_PATH . 'update-plugins/update-plugins.php';
		require_once JUPITERX_ADMIN_PATH . 'update-plugins/class-plugin-updater.php';
		require_once JUPITERX_ADMIN_PATH . 'update-plugins/functions.php';
	}

	// Include assets.
	require_once JUPITERX_ASSETS_PATH . 'assets.php';

	// Include renderers.
	require_once JUPITERX_RENDER_PATH . 'template-parts.php';
	require_once JUPITERX_RENDER_PATH . 'fragments.php';
	require_once JUPITERX_RENDER_PATH . 'widget-area.php';
	require_once JUPITERX_RENDER_PATH . 'walker.php';
	require_once JUPITERX_RENDER_PATH . 'menu.php';
}

add_action( 'init', 'jupiterx_customizer_include' );
/**
 * Include customizer setting file.
 *
 * With loading customizer on init, we have access to custom post types and custom taxonomies.
 *
 * @since 1.0.0
 * @ignore
 *
 * @return void
 */
function jupiterx_customizer_include() {
	/**
	 * Hook after registering theme customizer settings.
	 *
	 * @since 1.3.0
	 */
	do_action( 'jupiterx_before_customizer_register' );

	/**
	 * Load customizer settings.
	 */
	require_once JUPITERX_ADMIN_PATH . 'customizer/settings.php';

	/**
	 * Hook after registering theme customizer settings.
	 *
	 * @since 1.3.0
	 */
	do_action( 'jupiterx_after_customizer_register' );
}

add_action( 'admin_menu', 'jupiterx_register_theme_page' );
/**
 * Register theme page.
 *
 * @since 1.0.0
 *
 * @return void
 */
function jupiterx_register_theme_page() {
	add_theme_page( JUPITERX_NAME, JUPITERX_NAME, 'edit_theme_options', JUPITERX_SLUG, function() {
		include_once JUPITERX_ADMIN_PATH . '/control-panel/views/layout/master.php';
	} );
}

add_action( 'admin_head', 'jupiterx_backend_custom_css_output' );
/**
 * Print styles globally for theme admin menu icon.
 *
 * @since 1.0.0
 * @ignore
 *
 * @return void
 */
function jupiterx_backend_custom_css_output() {
	echo '<style type="text/css">
		#toplevel_page_jupiterx .menu-icon-generic div.wp-menu-image {
		background: url(' . esc_url( JUPITERX_ADMIN_ASSETS_URL ) . 'images/jupiterx-admin-menu-icon.svg) no-repeat 7px 6px !important;
		background-size: 22px auto !important;
		opacity: 0.6;
	}
	#toplevel_page_jupiterx .menu-icon-generic div.wp-menu-image:before {
		content: " ";
	}
	</style>';
}

/**
 * Handles url redirects
 *
 * @since 1.0.0
 * @ignore
 *
 * @return void
 */
function jupiterx_handle_url_redirects() {
	// @codingStandardsIgnoreStart
	if ( empty( $_GET['page'] ) ) {
		return;
	}

	if ( 'customize_theme' === $_GET['page'] ) {
		wp_redirect( admin_url( '/customize.php' ) );
		wp_die();
	}
	// @codingStandardsIgnoreEnd
}

add_action( 'jupiterx_init', 'jupiterx_load_textdomain' );
/**
 * Load text domain.
 *
 * @since 1.0.0
 * @ignore
 *
 * @return void
 */
function jupiterx_load_textdomain() {
	load_theme_textdomain( 'jupiterx', JUPITERX_LANGUAGES_PATH );
}

/**
 * Fires before Jupiter loads.
 *
 * @since 1.0.0
 */
do_action( 'jupiterx_before_init' );

	/**
	 * Load Jupiter framework.
	 *
	 * @since 1.0.0
	 */
	do_action( 'jupiterx_init' );

/**
 * Fires after Jupiter loads.
 *
 * @since 1.0.0
 */
do_action( 'jupiterx_after_init' );
