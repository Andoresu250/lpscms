<?php
/**
 * Settings API: JupiterX_Control_Panel_Settings base class
 *
 * @package JupiterX\Framework\Control_Panel\Settings
 *
 * @since 1.0
 */

/**
 * Settings.
 *
 * @package JupiterX\Framework\Control_Panel\Settings
 *
 * @since 1.0
 */
class JupiterX_Control_Panel_Settings {

	/**
	 * Constructor.
	 *
	 * @since 1.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_jupiterx_cp_settings', array( $this, 'ajax_handler' ) );
	}

	/**
	 * Map the requests to proper methods.
	 *
	 * @since 1.0
	 */
	public function ajax_handler() {
		check_ajax_referer( 'jupiterx_control_panel', 'nonce' );

		$type = jupiterx_post( 'type' );

		if ( ! $type ) {
			wp_send_json_error(
				__( 'Type param is missing.', 'jupiterx' )
			);
		}

		if ( 'flush' === $type ) {
			$this->flush();
		}

		if ( 'save' === $type ) {
			$this->save();
		}

		wp_send_json_error(
			sprintf( __( 'Type param (%s) is not valid.', 'jupiterx' ), $type )
		);
	}

	/**
	 * Flush assets cache.
	 *
	 * @since 1.0.0
	 */
	public function flush() {

		if ( function_exists( 'jupiterx_flush_compiler' ) ) {
			jupiterx_flush_compiler( 'jupiterx' );
		}

		jupiterx_elementor_flush_cache();

		wp_send_json_success( __( 'Assets flushed successfully.', 'jupiterx' ) );
	}

	/**
	 * Save settings.
	 *
	 * @since 1.0.0
	 */
	public function save() {
		$fields = jupiterx_post( 'fields' );
		$type   = jupiterx_post( 'type' );

		if ( ! $fields ) {
			wp_send_json_error( __( 'Fields param is missing.', 'jupiterx' ) );
		}

		if ( ! jupiterx_is_pro() ) {
			$pro_fields = [
				'jupiterx_adobe_fonts_project_id',
				'jupiterx_tracking_codes_after_head',
				'jupiterx_tracking_codes_before_head',
				'jupiterx_tracking_codes_after_body',
				'jupiterx_tracking_codes_before_body',
			];

			foreach ( $pro_fields as $name ) {
				unset( $fields[ $name ] );
			}
		}

		foreach ( $fields as $key => $value ) {
			update_option( $key, $value );
		}

		wp_send_json_success( __( 'Settings saved successfully.', 'jupiterx' ) );
	}

}

new JupiterX_Control_Panel_Settings();
