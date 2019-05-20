<?php
/**
 * Update plugins functionality.
 *
 * @package JupiterX_Core\Updater
 *
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'pre_set_site_transient_update_plugins', 'jupiterx_plugins_update' );
/**
 * Check if any update is available for Jupiter X plugins.
 * We are adding available updates to WordPress
 *
 * @param object $data Plugins update data.
 *
 * @since 1.0.0
 */
function jupiterx_plugins_update( $data ) {

	$plugin_manager = new JupiterX_Plugin_Updater();

	$list_of_plugins = $plugin_manager->plugins_custom_api( 0, 30, [ 'slug', 'basename', 'version', 'img_url', 'source' ] );

	if ( ! is_array( $list_of_plugins ) || count( $list_of_plugins ) < 1 ) {
		return $data;
	}

	foreach ( $list_of_plugins as $key => $plugin_info ) {

		$plugins = [
			'jupiterx-core',
			'raven',
			'revslider',
			'masterslider',
			'layerslider',
			'advanced-custom-fields-pro',
			'jet-elements',
			'jet-menu',
			'jet-popup',
			'jet-tabs',
			'jet-woo-builder',
			'jet-tricks',
			'jet-engine',
			'jet-smart-filters',
		];

		if ( ! in_array( $plugin_info['slug'], $plugins, true ) ) {
			continue;
		}

		$current_plugin_version = $plugin_manager->get_plugin_version( $plugin_info['slug'] );

		if ( ! $current_plugin_version ) {
			continue;
		}

		if ( version_compare( $current_plugin_version, $plugin_info['version'] ) === -1 ) {
			$file_path = $plugin_info['basename'];
			$update    = new stdClass();

			$update->slug        = $plugin_info['slug'];
			$update->plugin      = $file_path;
			$update->new_version = $plugin_info['version'];
			$update->package     = $plugin_info['source'];
			$update->icons['1x'] = $plugin_info['img_url'];
			$update->icons['2x'] = $plugin_info['img_url'];

			$data->response[ $file_path ] = $update;
		}
	}

	return $data;
}
