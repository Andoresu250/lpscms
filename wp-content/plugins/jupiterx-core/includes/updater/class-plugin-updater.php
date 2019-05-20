<?php
/**
 * Class to check updates for plugins.
 *
 * @package JupiterX_Core\Updater
 *
 * @since 1.0.0
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
class JupiterX_Plugin_Updater {
	/**
	 * API URL.
	 *
	 * @var string $api_url http://artbees.net/api/v2/.
	 */
	private $api_url;

	/**
	 * Theme Name
	 *
	 * @var string $theme_name JupiterX.
	 */
	private $theme_name;

	/**
	 * Class constructor.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Functions that we need run at first.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init() {
		$this->set_api_url( 'http://artbees.net/api/v2/' );
		$this->set_theme_name( 'JupiterX' );
	}

	/**
	 * Set API URL.
	 *
	 * @param string $api_url API URL.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function set_api_url( $api_url ) {
		$this->api_url = $api_url;
	}

	/**
	 * Get API URL.
	 *
	 * @since 1.0.0
	 *
	 * @return string API URL.
	 */
	public function get_api_url() {
		return $this->api_url;
	}

	/**
	 * Set theme name.
	 *
	 * @param string $theme_name Theme name.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function set_theme_name( $theme_name ) {
		$this->theme_name = $theme_name;
	}

	/**
	 * Get theme name.
	 *
	 * @since 1.0.0
	 *
	 * @return string Theme name
	 */
	public function get_theme_name() {
		return $this->theme_name;
	}

	/**
	 * Set theme name.
	 *
	 * @param int   $from Start offset.
	 * @param int   $count How many.
	 * @param array $list_of_attr List of attributes to fetch.
	 *
	 * @since 1.0.0
	 */
	public function plugins_custom_api( $from = 0, $count = 1, $list_of_attr = [] ) {
		$url = $this->get_api_url() . 'tools/plugin-custom-list';

		$response = $this->wp_remote_get( $url, [
			'theme-name'   => $this->get_theme_name(),
			'from'         => $from,
			'count'        => $count,
			'list-of-attr' => wp_json_encode( $list_of_attr ),
		]);

		if ( ! isset( $response->bool ) || ! $response->bool ) {
			return false;
		}

		$result = json_decode( wp_json_encode( $response->data ), true );

		return $result;
	}

	/**
	 * Reusable wrapper method for WP remote getter.
	 *
	 * Method only returns response body.
	 *
	 * @param string $url URL to send request to it.
	 * @param array  $headers Headers to send with request.
	 *
	 * @since 1.0.0
	 *
	 * @return array $response Response body.
	 */
	public static function wp_remote_get( $url = '', $headers = [] ) {
		$required_headers = [
			'api-key' => get_option( 'artbees_api_key' ),
			'domain'  => $_SERVER['SERVER_NAME'], // phpcs:ignore
		];

		// Combined headers.
		$headers = array_merge( $headers, $required_headers );

		$response = json_decode( wp_remote_retrieve_body( wp_remote_get( $url, [
			'sslverify' => false,
			'headers'   => $headers,
		] ) ) );

		return $response;
	}

	/**
	 * This method is responsible to get plugin version.
	 * It used native WordPress functions.
	 *
	 * @param string $plugin_slug for example : (js_composer_theme).
	 *
	 * @since 1.0.0
	 *
	 * @return bool|int will return version of plugin or false.
	 */
	public function get_plugin_version( $plugin_slug ) {
		$plugin_path = $this->find_plugin_path( $plugin_slug );

		if ( ! $plugin_path ) {
			return false;
		}

		$plugin_full_path = trailingslashit( WP_PLUGIN_DIR ) . $plugin_path;

		if ( ! file_exists( $plugin_full_path ) ) {
			return false;
		}

		$get_plugin_data  = get_plugin_data( $plugin_full_path );
		$version_response = $get_plugin_data['Version'];

		if ( ! empty( $version_response ) ) {
			return $version_response;
		}

		return false;
	}

	/**
	 * This method is responsible to find plugin head file and return full path of it.
	 *
	 * @param string $plugin_slug Plugins slug for example (js_composer_theme).
	 *
	 * @since 1.0.0
	 *
	 * @return string|bool Will return plugin path : (js_composer_theme/js_composer.php) or false if plugin slug not exist.
	 * @SuppressWarnings(PHPMD.ElseExpression)
	 */
	public function find_plugin_path( $plugin_slug ) {
		wp_clean_plugins_cache();
		$plugins = get_plugins();
		foreach ( $plugins as $plugin_address => $plugin_data ) {

			// Extract slug from address.
			if ( strlen( $plugin_address ) === basename( $plugin_address ) ) {
				$slug = strtolower( str_replace( '.php', '', $plugin_address ) );
			} else {
				$slug = strtolower( str_replace( '/' . basename( $plugin_address ), '', $plugin_address ) );
			}
			// Check if slug exists.
			if ( strtolower( $plugin_slug ) === $slug ) {
				return $plugin_address;
			}
		}
		return false;
	}
}
