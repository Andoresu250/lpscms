<?php
/**
 * API utility functions.
 *
 * @package JupiterX\Framework\API\API
 *
 * @since 1.3.0
 */

/**
 * Get API key.
 *
 * @since 1.3.0
 *
 * @return string API key.
 */
function jupiterx_get_api_key() {
	$api_key = get_option( 'artbees_api_key' );

	if ( empty( $api_key ) ) {
		return null;
	}

	return $api_key;
}

/**
 * Check theme PRO version.
 *
 * @since 1.3.0
 *
 * @return boolean PRO status.
 */
function jupiterx_is_pro() {
	if ( ! jupiterx_is_plugin_active( 'pro' ) ) {
		return false;
	}

	if ( ! jupiterx_pro()->is_active() ) {
		return false;
	}

	return ! empty( jupiterx_get_api_key() );
}

/**
 * Print PRO badge.
 *
 * @since 1.3.0
 */
function jupiterx_pro_badge() {
	echo jupiterx_get_pro_badge(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Get PRO badge.
 *
 * @since 1.3.0
 *
 * @return string The pro badge.
 */
function jupiterx_get_pro_badge() {
	if ( jupiterx_is_pro() ) {
		return '';
	}

	return sprintf(
		'<img class="jupiterx-pro-badge" src="%1$s" alt="%2$s" />',
		jupiterx_get_pro_badge_url(),
		esc_html__( 'Jupiter X Pro', 'jupiterx' )
	);
}

/**
 * Get PRO badge URL.
 *
 * @since 1.3.0
 *
 * @return string The pro badge URL.
 */
function jupiterx_get_pro_badge_url() {
	$icon = 'pro-badge.svg';

	if ( jupiterx_is_premium() ) {
		$icon = 'lock-badge.svg';
	}

	return JUPITERX_ADMIN_ASSETS_URL . '/images/' . $icon;
}

/**
 * Check theme is premium.
 *
 * @since 1.3.0
 * @return boolean Is Premium.
 */
function jupiterx_is_premium() {
	return JUPITERX_PREMIUM;
}

/**
 * Check theme is registered.
 *
 * @since 1.3.0
 * @return boolean Is Registered.
 */
function jupiterx_is_registered() {
	return ! empty( jupiterx_get_api_key() );
}

/**
 * Get important plugins to update.
 *
 * @since 1.3.0
 *
 * @return array List of plugins.
 */
function jupiterx_get_update_plugins() {
	$update_plugins = [];

	$headers = [
		'api-key'      => get_option( 'artbees_api_key' ),
		'domain'       => $_SERVER['SERVER_NAME'], // phpcs:ignore
		'theme-name'   => 'JupiterX',
		'from'         => 0,
		'count'        => 0,
		'list-of-attr' => wp_json_encode( [
			'slug',
			'version',
			'name',
			'basename',
		] ),
	];

	$response = json_decode( wp_remote_retrieve_body( wp_remote_get( 'http://artbees.net/api/v2/tools/plugin-custom-list', [
		'sslverify' => false,
		'headers'   => $headers,
	] ) ) );

	// Filter to get pro and core plugins only.
	$data = array_filter( $response->data, function( $plugin ) {
		return in_array( $plugin->slug, [ 'jupiterx-pro', 'jupiterx-core', 'raven' ], true );
	} );

	foreach ( $data as $plugin ) {
		$file = trailingslashit( WP_PLUGIN_DIR ) . $plugin->basename;

		if ( ! is_readable( $file ) ) {
			continue;
		}

		$cur_plugin = get_file_data( $file, [
			'Version' => 'Version',
		] );

		if ( version_compare( $plugin->version, $cur_plugin['Version'], '>' ) ) {
			$update_plugins[] = [
				'basename' => $plugin->basename,
				'name'     => $plugin->name,
				'slug'     => $plugin->slug,
				'action'   => 'update',
			];
		}
	}

	$slugs = array_column( $update_plugins, 'slug' );

	if ( ! in_array( 'jupiterx-pro', $slugs, true ) && ! function_exists( 'jupiterx_pro' ) ) {
		$update_plugins[] = [
			'basename' => 'jupiterx-pro/jupiterx-pro.php',
			'name'     => 'Jupiter X Pro',
			'slug'     => 'jupiterx-pro',
			'action'   => 'install',
		];
	}

	foreach ( $update_plugins as $index => $plugin ) {
		if ( ! jupiterx_is_registered() && in_array( $plugin['slug'], [ 'jupiterx-pro', 'raven' ], true ) ) {
			unset( $update_plugins[ $index ] );
		}
	}

	return $update_plugins;
}
