<?php
/**
 * This class handles AJAX.
 *
 * @since 1.0.0
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
 * @since 1.0.0
 *
 * @package JupiterX\Framework\Admin\Setup_Wizard
 */
final class JupiterX_Setup_Wizard_Ajax {

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
	 * @since 1.0.0
	 */
	public function __construct() {
		$functions = [
			'next_page',
			'activate_api',
			'install_plugins',
			'get_templates',
			'import_template',
			'get_template_psd',
			'hide_notice',
		];

		foreach ( $functions as $function ) {
			add_action( 'wp_ajax_jupiterx_setup_wizard_' . $function, [ $this, $function ] );
		}
	}

	/**
	 * Get the next page.
	 *
	 * @since 1.0.0
	 */
	public function next_page() {
		$page_id = jupiterx_setup_wizard()->get_next_page();

		update_option( 'jupiterx_setup_wizard_current_page', $page_id );

		// Remove notice when user reached final page.
		if ( 'completed' === $page_id ) {
			update_option( 'jupiterx_setup_wizard_hide_notice', true );
		}

		ob_start();

		jupiterx_setup_wizard()->render_content( $page_id );

		$html = ob_get_clean();

		wp_send_json_success( [
			'html' => $html,
			'page' => $page_id,
		] );
	}

	/**
	 * Activate the API key.
	 *
	 * @since 1.0.0
	 */
	public function activate_api() {
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

	/**
	 * Get templates list.
	 *
	 * @since 1.0.0
	 */
	public function get_templates() {
		$template = [
			'id'       => filter_input( INPUT_POST, 'template_id' ),
			'name'     => filter_input( INPUT_POST, 'template_name' ),
			'category' => filter_input( INPUT_POST, 'template_category' ),
		];

		$headers = [
			'pagination-start'  => intval( filter_input( INPUT_POST, 'pagination_start' ) ),
			'pagination-count'  => intval( filter_input( INPUT_POST, 'pagination_count' ) ),
			'template-id'       => $template['id'],
			'template-name'     => empty( $template['name'] ) ? null : $template['name'],
			'template-category' => empty( $template['category'] ) ? null : $template['category'],
		];

		$data = [
			'timeout'     => 10,
			'httpversion' => '1.1',
			'headers'     => array_merge( [
				'theme-name' => JUPITERX_SLUG,
				'domain'     => wp_unslash( $_SERVER['SERVER_NAME'] ), // phpcs:ignore
			], $headers ),
		];

		$post = wp_remote_get( 'https://artbees.net/api/v2/theme/templates', $data );

		$response = json_decode( wp_remote_retrieve_body( $post ) );

		wp_send_json_success( [
			'templates' => $response->data,
			'status'    => self::OK,
		] );
	}

	/**
	 * Process import template.
	 *
	 * @since 1.0.0
	 */
	public function import_template() {
		$template_id = get_option( 'jupiterx_template_installed_id' );

		if ( ! empty( $template_id ) ) {
			wp_send_json_success( [
				'message' => __( 'Cannot process your request because you have already installed a template.', 'jupiterx' ),
				'status'  => self::ERROR,
			] );
		}

		$templates_manager = new JupiterX_Control_Panel_Install_Template();

		// Install template function.
		$templates_manager->install_template_procedure();
	}

	/**
	 * Get template psd link.
	 *
	 * @since 1.0.0
	 */
	public function get_template_psd() {
		$api_key = get_option( 'artbees_api_key' );

		if ( empty( $api_key ) ) {
			wp_send_json_success( [
				'message' => __( 'Your API key could not be verified.', 'jupiterx' ),
				'status'  => self::ERROR,
			] );
		}

		$templates_manager = new JupiterX_Control_Panel_Install_Template();

		// Template download function.
		$templates_manager->get_template_psd_link();
	}

	/**
	 * Hide message notice.
	 *
	 * @since 1.0.0
	 */
	public function hide_notice() {
		update_option( 'jupiterx_setup_wizard_hide_notice', true );

		wp_send_json_success( [
			'status' => self::OK,
		] );
	}
}

new JupiterX_Setup_Wizard_Ajax();
