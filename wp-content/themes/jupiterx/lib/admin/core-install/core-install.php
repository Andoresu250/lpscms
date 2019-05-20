<?php
/**
 * This class handles init of core plugin installer.
 *
 * @since 1.0.0
 *
 * @package Jupiter\Framework\Admin\Core_Install
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Init theme core installer.
 *
 * @since 1.0.0
 *
 * @package Jupiter\Framework\Admin\Core_Install
 */
class JupiterX_Theme_Core_Install {

	/**
	 * Class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'admin_print_scripts', 'wp_print_admin_notice_templates' );
		add_action( 'wp_ajax_jupiterx_core_install_plugin', [ $this, 'install_plugin' ] );
		add_action( 'wp_ajax_jupiterx_core_install_plugin_notice', [ $this, 'dismiss_notice' ] );
		add_action( 'admin_notices', [ $this, 'install_notice' ] );
	}

	/**
	 * Load scripts.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'jupiterx-core-install', JUPITERX_ADMIN_URL . 'core-install/assets/css/core-install' . JUPITERX_MIN_CSS . '.css', [], JUPITERX_VERSION );
		wp_enqueue_script( 'jupiterx-core-install', JUPITERX_ADMIN_URL . 'core-install/assets/js/core-install' . JUPITERX_MIN_JS . '.js', [ 'jquery', 'wp-util', 'updates' ], JUPITERX_VERSION, true );
		wp_localize_script( 'jupiterx-core-install', 'jupiterxCoreInstall', [
			'controlPanelUrl' => admin_url( 'admin.php?page=' . JUPITERX_SLUG ),
			'i18n'            => [
				'idle'            => __( 'Activate Jupiter X Core Plugin', 'jupiterx' ),
				'installing'      => __( 'Installing plugin...', 'jupiterx' ),
				'activating'      => __( 'Activating plugin...', 'jupiterx' ),
				'completed'       => __( 'Plugin activation completed.', 'jupiterx' ),
				'errorActivating' => __( 'There was an issue during the activation process.', 'jupiterx' ),
			],
		] );
	}

	/**
	 * Print admin notice.
	 *
	 * @since 1.0.0
	 */
	public function install_notice() {
		$notice_state_meta = 'jupiterx_core_install_plugin_notice';

		if ( get_user_meta( get_current_user_id(), $notice_state_meta, true ) === 'disabled' ) {
			return;
		}
		?>

		<div id="jupiterx-core-install-notice" class="updated jupiterx-core-install-notice notice is-dismissible">
			<?php wp_nonce_field( 'jupiterx-core-installer-nonce', 'jupiterx-core-installer-notice-nonce' ); ?>
			<div class="jupiterx-core-install-notice-logo">
				<img src="<?php echo esc_url( JUPITERX_ADMIN_ASSETS_URL . 'images/jupiterx-notice-logo.png' ); ?>" alt="<?php esc_html_e( 'Jupiter X', 'jupiterx' ); ?>" />
			</div>
			<div class="jupiterx-core-install-notice-content">
				<h2><?php esc_html_e( 'Almost done! 👋', 'jupiterx' ); ?></h2>
				<p><?php esc_html_e( 'To complete the installation and unlock more features, we highly recommend to activate Jupiter X Core plugin.', 'jupiterx' ); ?></p>
				<button class="button button-primary button-hero jupiterx-core-install-plugin">
					<span class="dashicons dashicons-download"></span>
					<span class="button-text"><?php esc_html_e( 'Activate Jupiter X Core Plugin', 'jupiterx' ); ?></span>
				</button>
			</div>
		</div>
		<?php
	}

	/**
	 * Install plugin via ajax.
	 *
	 * @since 1.0.0
	 *
	 * @SuppressWarnings(PHPMD.NPathComplexity)
	 */
	public function install_plugin() {
		check_ajax_referer( 'jupiterx-core-installer-nonce', '_wpnonce' );

		// Include.
		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

		// Prepare installer.
		$status   = [];
		$skin     = new WP_Ajax_Upgrader_Skin();
		$upgrader = new Plugin_Upgrader( $skin );
		$core_url = 'https://static-cdn.artbees.net/jupiterx/plugins/jupiterx-core.zip';
		$result   = $upgrader->install( $core_url );

		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			$status['debug'] = $skin->get_upgrade_messages();
		}

		if ( is_wp_error( $result ) ) {
			$status['errorCode']    = $result->get_error_code();
			$status['errorMessage'] = $result->get_error_message();
			wp_send_json_error( $status );
		} elseif ( is_wp_error( $skin->result ) ) {
			// If folder exists it means we just have to activate the plugin.
			if ( 'folder_exists' !== $skin->result->get_error_code() ) {
				$status['errorCode']    = $skin->result->get_error_code();
				$status['errorMessage'] = $skin->result->get_error_message();
				wp_send_json_error( $status );
			}
		} elseif ( $skin->get_error_messages() ) {
			$status['errorMessage'] = $skin->get_error_messages();
			wp_send_json_error( $status );
		} elseif ( is_null( $result ) ) {
			global $wp_filesystem;
			$status['errorCode']    = 'unable_to_connect_to_filesystem';
			$status['errorMessage'] = __( 'Unable to connect to the filesystem. Please confirm your credentials.', 'jupiterx' );

			// Pass through the error from WP_Filesystem if one was raised.
			if ( $wp_filesystem instanceof WP_Filesystem_Base && is_wp_error( $wp_filesystem->errors ) && $wp_filesystem->errors->has_errors() ) {
				$status['errorMessage'] = esc_html( $wp_filesystem->errors->get_error_message() );
			}

			wp_send_json_error( $status );
		}

		$install_status = install_plugin_install_status( [
			'slug'    => 'jupiterx-core',
			'version' => null,
		], true );

		$pagenow = isset( $_POST['pagenow'] ) ? sanitize_key( $_POST['pagenow'] ) : '';

		// If installation request is coming from import page, do not return network activation link.
		$plugins_url = ( 'import' === $pagenow ) ? admin_url( 'plugins.php' ) : network_admin_url( 'plugins.php' );

		if ( current_user_can( 'activate_plugin', $install_status['file'] ) && is_plugin_inactive( $install_status['file'] ) ) {
			$status['activateUrl'] = add_query_arg(
				array(
					'_wpnonce' => wp_create_nonce( 'activate-plugin_' . $install_status['file'] ),
					'action'   => 'activate',
					'plugin'   => $install_status['file'],
				), $plugins_url
			);
		}

		wp_send_json_success( $status );
	}

	/**
	 * Update notice visibility.
	 *
	 * @since 1.2.0
	 */
	public function dismiss_notice() {
		check_ajax_referer( 'jupiterx-core-installer-nonce', '_wpnonce' );

		if ( empty( $_POST['state'] ) ) {
			wp_send_json_error();
		}

		update_user_meta(
			get_current_user_id(),
			'jupiterx_core_install_plugin_notice',
			sanitize_text_field( wp_unslash( $_POST['state'] ) )
		);

		wp_send_json_success();
	}

}

/**
 * Run the core installer.
 *
 * Show installer notice only when logged in user can manage install plugins and core plugin is not installed or activated.
 *
 * @since 1.0.0
 */
if ( current_user_can( 'install_plugins' ) ) {
	if ( ! function_exists( 'jupiterx_core' ) ) {
		new JupiterX_Theme_Core_Install( 'install' );
	}
}

