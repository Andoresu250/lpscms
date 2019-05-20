<?php
/**
 * This class handles AJAX.
 *
 * @since 1.3.0
 *
 * @package JupiterX\Framework\Admin\Setup_Wizard
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AJAX class.
 *
 * @since 1.3.0
 *
 * @package JupiterX\Framework\Admin\Setup_Wizard
 */
final class JupiterX_API_Ajax {

	/**
	 * Successful return status.
	 */
	const OK = true;

	/**
	 * Error return status.
	 */
	const ERROR = false;

	/**
	 * Class constructor.
	 *
	 * @since 1.3.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_jupiterx_api', [ $this, 'ajax' ] );
	}

	/**
	 * Main AJAX function.
	 *
	 * @since 1.3.0
	 */
	public function ajax() {
		$type = filter_input( INPUT_POST, 'type' );

		if ( ! isset( $type ) || ! method_exists( $this, $type ) ) {
			wp_send_json_success( [
				'status' => self::ERROR,
			] );
		}

		// Run AJAX type.
		call_user_func( [ $this, $type ] );
	}

	/**
	 * Activate the API key.
	 *
	 * @since 1.3.0
	 */
	public function activate() {
		$api_key = filter_input( INPUT_POST, 'api_key' );

		if ( empty( $api_key ) ) {
			wp_send_json_success( [
				'message' => __( 'API key is empty.', 'jupiterx' ),
				'status'  => self::ERROR,
			] );
		}

		$data = array(
			'timeout'     => 10,
			'httpversion' => '1.1',
			'body'        => array(
				'apikey' => $api_key,
				'domain' => wp_unslash( $_SERVER['SERVER_NAME'] ), // phpcs:ignore
			),
		);

		$post = wp_remote_post( 'https://artbees.net/api/v1/verify', $data );

		$response = json_decode( wp_remote_retrieve_body( $post ) );

		if ( ! $response->is_verified ) {
			wp_send_json_success( [
				'message' => __( 'Your API key could not be verified.', 'jupiterx' ),
				'status'  => self::ERROR,
			] );
		}

		update_option( 'artbees_api_key', $api_key, 'yes' );

		wp_send_json_success( [
			'message' => __( 'Your product registration was successful.', 'jupiterx' ),
			'status'  => self::OK,
		] );
	}

	/**
	 * Install a
	 *
	 * @since 1.3.0
	 */
	public function install_plugin() {
		$api_key = filter_input( INPUT_POST, 'api_key' );

		if ( empty( $api_key ) ) {
			wp_send_json_success( [
				'message' => __( 'API key is empty.', 'jupiterx' ),
				'status'  => self::ERROR,
			] );
		}

		$data = array(
			'timeout'     => 10,
			'httpversion' => '1.1',
			'body'        => array(
				'apikey' => $api_key,
				'domain' => wp_unslash( $_SERVER['SERVER_NAME'] ), // phpcs:ignore
			),
		);

		$post = wp_remote_post( 'https://artbees.net/api/v1/verify', $data );

		$response = json_decode( wp_remote_retrieve_body( $post ) );

		if ( ! $response->is_verified ) {
			wp_send_json_success( [
				'message' => __( 'Your API key could not be verified.', 'jupiterx' ),
				'status'  => self::ERROR,
			] );
		}

		update_option( 'artbees_api_key', $api_key, 'yes' );

		wp_send_json_success( [
			'message' => __( 'Your product registration was successful.', 'jupiterx' ),
			'status'  => self::OK,
		] );
	}

	/**
	 * Batch install selected plugins.
	 *
	 * @since 1.0.0
	 */
	public function install_plugins() {
		$plugins_list = filter_input( INPUT_POST, 'plugins', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY );

		if ( empty( $plugins_list ) ) {
			wp_send_json_success( [
				'message' => __( 'Plugins list is empty.', 'jupiterx' ),
				'status'  => self::ERROR,
			] );
		}

		$plugins_manager = new JupiterX_Control_Panel_Plugin_Manager();

		$plugins_manager->set_lock( 'install_batch', true );

		foreach ( $plugins_list as $plugin_slug ) {
			$plugins_manager->set_plugin_slug( $plugin_slug );

			$plugin_basename = $plugins_manager->get_plugin_basename_by_slug( $plugin_slug );

			if ( ! file_exists( trailingslashit( WP_PLUGIN_DIR ) . $plugin_basename ) ) {
				if ( ! $plugins_manager->install( $plugin_slug ) ) {
					wp_send_json_success( [
						'message' => sprintf( '%1$s %2$s.', __( 'There was an error occur installing the plugin', 'jupiterx' ), $plugin_slug ),
						'status'  => self::ERROR,
					] );
				}
			}

			if ( ! is_plugin_active( $plugin_basename ) ) {
				if ( ! $plugins_manager->activate( $plugin_basename ) ) {
					wp_send_json_success( [
						'message' => sprintf( '%1$s %2$s.', __( 'There was an error occur installing the plugin', 'jupiterx' ), $plugin_slug ),
						'status'  => self::ERROR,
					] );
				}
			}
		}

		wp_send_json_success( [
			'message' => __( 'Plugins installed successfully.', 'jupiterx' ),
			'status'  => self::OK,
		] );
	}
}

new JupiterX_API_Ajax();
