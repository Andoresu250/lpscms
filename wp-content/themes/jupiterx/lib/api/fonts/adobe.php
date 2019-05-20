<?php
/**
 * Main class that handles Adobe fonts.
 *
 * @package JupiterX\Framework\API\Fonts
 *
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adobe fonts loader class.
 *
 * @since 1.0.0
 * @ignore
 * @access private
 *
 * @package JupiterX\Framework\API\Fonts
 */
final class _JupiterX_Load_Adobe_Fonts {

	/**
	 * Construct the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_filter( 'jupiterx_custom_fonts', [ $this, 'add_custom_fonts' ] );
		add_filter( 'jupiterx_font_types', [ $this, 'add_font_type' ] );
	}

	/**
	 * Enqueue scripts.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {
		$adobe_fonts = JupiterX_Fonts::get_registered_fonts( 'adobe' );

		// Don't enqueue if there's no Adobe font registered from the Customizer.
		if ( empty( $adobe_fonts ) ) {
			return;
		}

		$project_id = get_option( 'jupiterx_adobe_fonts_project_id' );

		if ( empty( $project_id ) ) {
			return;
		}

		$script = "WebFont.load({
			typekit: {
				id:'{$project_id}'
			}
		});";

		wp_enqueue_script( 'jupiterx-webfont' );

		// Print script.
		wp_add_inline_script( 'jupiterx-webfont', $script );
	}

	/**
	 * Add Adobe fonts from the custom fonts list of the theme.
	 *
	 * @param array $custom_fonts Current custom fonts.
	 *
	 * @return array Compiled custom fonts.
	 */
	public function add_custom_fonts( $custom_fonts ) {
		$project_id = get_option( 'jupiterx_adobe_fonts_project_id' );

		if ( empty( $project_id ) ) {
			return $custom_fonts;
		}

		// Get data from API.
		$response = wp_remote_get( "https://typekit.com/api/v1/json/kits/{$project_id}/published" );

		// Parse json.
		$adobe = json_decode( wp_remote_retrieve_body( $response ) );

		if ( ! isset( $adobe->kit->families ) || empty( $adobe->kit->families ) ) {
			return $custom_fonts;
		}

		$kit_fonts = $adobe->kit->families;

		$fonts = [];

		foreach ( $kit_fonts as $font ) {
			$fonts[ $font->name ] = [
				'type'  => 'adobe',
				'value' => $font->slug,
			];
		}

		return array_merge( $custom_fonts, $fonts );
	}

	/**
	 * Add new font type.
	 *
	 * @param array $types Current font types.
	 *
	 * @return array Combined types.
	 */
	public function add_font_type( $types ) {
		$types['adobe'] = 'Adobe Fonts' . jupiterx_get_pro_badge();

		return $types;
	}
}

new _JupiterX_Load_Adobe_Fonts();
