<?php
/**
 * This class is responsible to manage all jupiters plugin.
 * it will communicate with artbees API and get list of plugins , install them or remove them
 *
 * @author       Reza Marandi <ross@artbees.net>
 * @copyright    Artbees LTD (c)
 * @link         http://artbees.net
 * @version      1.0
 * @package      jupiter
 */
class JupiterX_Control_Panel_Plugin_Manager {

	private $validator;
	private $theme_name;
	private $plugin_slug;
	private $plugin_name;
	private $plugins_dir;
	private $plugin_path;
	private $plugin_remote_file_name;
	private $plugin_remote_url;
	private $response;
	private $api_url;
	private $lock = false;
	private $lock_id = '';

	public function set_theme_name( $theme_name ) {
		$this->theme_name = $theme_name;
	}

	public function set_plugin_slug( $plugin_slug ) {
		$this->plugin_slug = $plugin_slug;
		return $this;
	}

	public function set_plugin_name( $plugin_name ) {
		$this->plugin_name = $plugin_name;
		return $this;
	}

	public function set_plugins_dir( $plugins_dir ) {
		$this->plugins_dir = $plugins_dir;
		return $this;
	}

	public function set_plugin_path( $plugin_path ) {
		$this->plugin_path = $plugin_path;
		return $this;
	}

	public function set_plugin_remote_file_name( $plugin_remote_file_name ) {
		$this->plugin_remote_file_name = $plugin_remote_file_name;
		return $this;
	}

	public function set_plugin_remote_url( $plugin_remote_url ) {
		$this->plugin_remote_url = $plugin_remote_url;
		return $this;
	}

	public function set_response( $response ) {
		$this->response = $response;
		return $this;
	}

	public function set_api_url( $api_url ) {
		$this->api_url = $api_url;
		return $this;
	}

	public function set_lock( $lock_id, $lock ) {
		if ( $lock === true && $this->lock === false ) {
			// Lock is free ...
			$this->lock = $lock;
			$this->lock_id = $lock_id;
		} elseif ( $lock === false && $this->lock === true && $lock_id == $this->lock_id ) {
			// Lock will be free by owner
			$this->lock = $lock;
			$this->lock_id = '';
		}

		return $this;
	}

	public function getThemeName() {
		return $this->theme_name;
	}

	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_plugins_dir() {
		return $this->plugins_dir;
	}

	public function get_plugin_path() {
		return $this->plugin_path;
	}

	public function get_plugin_remote_file_name() {
		return $this->plugin_remote_file_name;
	}

	public function get_plugin_remote_url() {
		return $this->plugin_remote_url;
	}

	public function get_response() {
		return $this->response;
	}

	public function get_response_message() {
		$system_response = $this->get_response();
		if ( isset( $system_response['message'] ) ) {
			return $system_response['message'];
		}
		return null;
	}

	public function get_response_status() {
		$system_response = $this->get_response();
		if ( isset( $system_response['status'] ) ) {
			return $system_response['status'];
		}
		return null;
	}

	public function get_response_data() {
		$system_response = $this->get_response();
		if ( isset( $system_response['data'] ) ) {
			return $system_response['data'];
		}
		return null;
	}

	public function get_api_url() {
		return $this->api_url;
	}

	public function get_lock() {
		return $this->lock;
	}

	public function __construct() {
		$menu_items_access = get_site_option( 'menu_items' );

		if ( is_multisite() && ! isset( $menu_items_access['plugins'] ) && ! current_user_can( 'manage_network_plugins' ) ) {
			return;
		}

		$this->set_theme_name( 'JupiterX' );
		$this->set_api_url( 'http://artbees.net/api/v2/' );
		$this->validator = new JupiterX_Control_Panel_Validator();
		$this->set_plugins_dir( trailingslashit( WP_PLUGIN_DIR ) );

		add_action( 'wp_ajax_abb_get_plugins', [ $this, 'get_plugins_list' ] );
		add_action( 'wp_ajax_abb_install_plugin', [ $this, 'install' ] );
		add_action( 'wp_ajax_abb_activate_plugin', [ $this, 'activate' ] );
		add_action( 'wp_ajax_abb_deactivate_plugin', [ $this, 'deactivate' ] );
		add_action( 'init', [ $this, 'cache' ] );
	}

	public function cache() {
		if ( jupiterx_get( 'force_check', false ) ) {
			delete_transient( 'jupiterx_list_of_plugins' );
		}
	}

	public function get_plugin_basename_by_slug( $slug ) {
		$plugins = get_transient( 'jupiterx_list_of_plugins' );

		if ( empty( $plugins ) ) {
			$plugins = $this->plugins_custom_api( 0, 0, array( 'slug', 'basename' ) );
		}

		$key = array_search( $slug, array_column( $plugins, 'slug') );

		return $plugins[ $key ]['basename'];
	}

	public function install( $slug = '' ) {
		if ( ! current_user_can( 'install_plugins' ) ) {
			$this->message( __( 'Sorry, you are not allowed to install plugins on this site.', 'jupiterx' ), false );
			return false;
		}

		$plugin = isset( $_POST['slug'] ) ? sanitize_key( wp_unslash( $_POST['slug'] ) ) : $slug;

		include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
		include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' ); //for plugins_api..

		$this->set_lock( 'install' ,  true );

		$api = plugins_api(
			'plugin_information',
			[
				'slug'   => $plugin,
				'fields' => [
					'sections' => false,
				],
			]
		);

		$api = ( false !== $api && ! is_wp_error( $api ) ) ? $api : null;

		if ( $api ) {
			$source = $api->download_link;
		} else {
			$this->set_plugin_slug( $plugin );
			$this->plugins_list_from_api();
			$api_response = $this->get_response_data();
			$source = $api_response[0]['source'];
		}

		$skin     = new WP_Ajax_Upgrader_Skin();
		$upgrader = new Plugin_Upgrader( $skin );

		$result = $upgrader->install( $source );

		$this->set_lock( 'install' , false );

		// Error handling. Based on WordPress approach.
		if ( is_wp_error( $result ) ) {
			$this->message( $result->get_error_message(), false );
			return false;
		}

		if ( is_wp_error( $skin->result ) ) {
			$this->message( $skin->result->get_error_message(), false );
			return false;
		}

		if ( $skin->get_errors()->get_error_code() ) {
			$this->message( $skin->get_error_messages(), false );
			return false;
		}

		if ( is_null( $result ) ) {
			global $wp_filesystem;

			$error_message = __( 'Unable to connect to the filesystem. Please confirm your credentials.', 'jupiterx' );

			// Pass through the error from WP_Filesystem if one was raised.
			if ( $wp_filesystem instanceof WP_Filesystem_Base && is_wp_error( $wp_filesystem->errors ) && $wp_filesystem->errors->get_error_code() ) {
				$error_message = esc_html( $wp_filesystem->errors->get_error_message() );
			}

			$this->message( $error_message, false );
			return false;
		}

		$this->message( __( 'Plugin successfully installed.', 'jupiterx' ), true );
		return true;
	}

	public function activate( $basename = '' ) {

		if ( ! isset( $_POST['basename'] ) ) {
			$plugin = $basename;
		} else {
			$plugin =  sanitize_text_field( $_POST['basename'] );
		}

		if ( ! current_user_can( 'activate_plugin', $plugin ) ) {
			$this->message( __( 'Sorry, you are not allowed to activate this plugin.', 'jupiterx' ), false );
			return false;
		}

		$result = activate_plugin( $plugin );

		if ( is_wp_error( $result ) ) {
			$this->message( $result->get_error_message(), false );
			return false;
		}

		$this->message( __( 'Activated Successfully.', 'jupiterx' ), true );
		return true;
	}

	public function deactivate( $basename ) {
				if ( ! isset( $_POST['basename'] ) ) {
			$plugin = $basename;
		} else {
			$plugin =  sanitize_text_field( $_POST['basename'] );
		}

		if ( ! current_user_can( 'activate_plugin', $plugin ) ) {
			$this->message( __( 'Sorry, you are not allowed to deactivate this plugin.', 'jupiterx' ), false );
			return false;
		}

		deactivate_plugins( $plugin );

		$this->message( __( 'Dectivated Successfully.', 'jupiterx' ), true );
		return true;
	}

	/**
	 * Check number of activated plugins in two different groups.
	 *
	 * @since 1.3.0
	 *
	 * @return bool $threshold Wether we are meeting threshold or not.
	 */
	public function plugins_threshold() {

		$plugins   = get_option('active_plugins');
		$threshold = [];

		if ( count( $plugins ) >= 20 ) {
			$threshold[] = 'num';
		}

		$sliders = [
			'LayerSlider/layerslider.php',
			'masterslider/masterslider.php',
			'revslider/revslider.php',
		];

		if ( count( array_intersect( $plugins, $sliders ) ) >= 1 ) {
			$threshold[] = 'sliders';
		}

		$jet_plugins = [
			'jet-blog/jet-blog.php',
			'jet-elements/jet-elements.php',
			'jet-engine/jet-engine.php',
			'jet-menu/jet-menu.php',
			'jet-popup/jet-popup.php',
			'jet-smart-filters/jet-smart-filters.php',
			'jet-tabs/jet-tabs.php',
			'jet-tricks/jet-tricks.php',
			'jet-woo-builder/jet-woo-builder.php',
		];

		if ( count( array_intersect( $plugins, $jet_plugins ) ) >= 4 ) {
			$threshold[] = 'jet-plugins';
		}

		return implode( $threshold, ',' );
	}

	public function array_column( array $input, $columnKey, $indexKey = null ) {
		$array = array();
		foreach ( $input as $value ) {
			if ( ! array_key_exists( $columnKey, $value ) ) {
				trigger_error( "Key \"$columnKey\" does not exist in array" );
				return false;
			}
			if ( is_null( $indexKey ) ) {
				$array[] = $value[ $columnKey ];
			} else {
				if ( ! array_key_exists( $indexKey, $value ) ) {
					trigger_error( "Key \"$indexKey\" does not exist in array" );
					return false;
				}
				if ( ! is_scalar( $value[ $indexKey ] ) ) {
					trigger_error( "Key \"$indexKey\" does not contain scalar value" );
					return false;
				}
				$array[ $value[ $indexKey ] ] = $value[ $columnKey ];
			}
		}
		return $array;
	}

	public function plugins_list_from_api( $exclude_plugins = [] ) {
		$exclude_plugins = json_encode( $exclude_plugins );
		$exclude_plugins = (empty( $exclude_plugins ) == true ? array() : $exclude_plugins);
		$url             = $this->get_api_url() . 'tools/plugin';
		$response        = $this->wp_remote_get( $url, array(
			'from'       => 0,
			'count'      => 20,
			'theme-name' => $this->getThemeName(),
			'exclude-plugins-slug' => $exclude_plugins,
			'plugin-name' => $this->get_plugin_name(),
			'plugin-slug' => $this->get_plugin_slug(),
		) );

		if ( ! isset( $response->bool ) || ! $response->bool ) {
			$this->message( $response->message, false );
			return false;
		}

		if ( empty( $response->data ) ) {
			$this->message( 'Successfull', true, array() );
			return true;
		}

		$result = json_decode( json_encode( $response->data ), true );

		foreach ( $result as $key => $value ) {
				$fetch_data = [];
			if ( 'wp-repo' === $value['source'] ) {
				$fetch_data['download_link'] = 'source';
			}
			if ( 'wp-repo' === $value['version'] ) {
				$fetch_data['version'] = 'version';
			}
			if ( 'wp-repo' === $value['desc'] ) {
				$fetch_data['short_description'] = 'desc';
			}
			if ( is_array( $fetch_data ) && count( $fetch_data ) > 0 ) {
				$response = $this->get_plugin_info_from_wp_repo( $value['slug'], $fetch_data );
				if ( false !== $response ) {
					$result[ $key ] = array_replace( $result[ $key ], $response );
				}
				if ( $this->find_plugin_path( $value['slug'] ) ) {
					$result[ $key ]['version'] = $this->get_plugin_data( $value['slug'], 'Version' );
					$result[ $key ]['desc'] = $this->get_plugin_data( $value['slug'], 'Description' );
				}
			}
		}

		$this->message( 'Successfull', true, $result );

		return true;
	}

	public function plugin_version_from_api( $plugins = [] ) {
		$response = $this->validator
			->setValue( $plugins )
			->setFieldName( 'Plugins' )
			->run( 'array:true' );

		if ( $response === false ) {
			throw new Exception( $this->validator->getMessage() );
		}

		$url      = $this->get_api_url() . 'tools/plugin-version';
		$response = $this->wp_remote_get( $url, array(
			'theme-name' => $this->getThemeName(),
			'plugins-slug' => json_encode( $plugins ),
		) );

		if ( isset( $response->bool ) == false || $response->bool == false ) {
			throw new Exception( $response->message );
		}

		return json_decode( json_encode( $response->data ), true );
	}

	public function get_plugins_list() {
		try {
			$plugins = get_transient( 'jupiterx_list_of_plugins' );
			if ( ! is_array( $plugins ) || empty( $plugins ) ) {
				$plugins = $this->plugins_custom_api( 0 , 0 , array( 'slug', 'basename', 'version', 'name', 'desc', 'more_link', 'img_url', 'required', 'pro' ) );
				set_transient( 'jupiterx_list_of_plugins', $plugins, 12 * HOUR_IN_SECONDS );
			}

			if ( ! is_array( $plugins ) || count( $plugins ) < 1 ) {
				$this->message( __( 'Plugin list is empty', 'jupiterx' ), false );
				return false;
			}

			foreach ( $plugins as $key => $plugin ) {

				$plugins[ $key ]['update_needed']    = false;
				$plugins[ $key ]['installed']        = false;
				$plugins[ $key ]['active']           = false;
				$plugins[ $key ]['network_active']   = false;
				$plugins[ $key ]['install_disabled'] = false;

				if ( is_plugin_active_for_network( $plugin['basename'] )  ) {
					if ( ! current_user_can( 'manage_network_plugins' ) ) {
						unset( $plugins[ $key ] );
						continue;
					}

					$plugins[ $key ]['network_active'] = true;
				}

				if ( $current_version = $this->get_plugin_version( $plugin['slug'] ) ) {
					$plugins[ $key ]['version'] = $current_version;
				}

				if ( version_compare( $current_version, $plugin['version'], '<' ) ) {
					$plugins[ $key ]['update_needed'] = true;
				}

				if ( is_plugin_active( $plugin['basename'] ) ) {
					$plugins[ $key ]['active']    = true;
					$plugins[ $key ]['installed'] = true;
				} elseif ( file_exists( trailingslashit( WP_PLUGIN_DIR ) . $plugin['basename'] ) ) {
					$plugins[ $key ]['installed'] = true;
				}

				if ( ! jupiterx_is_pro() && 'true' === $plugins[ $key ]['pro'] && ! $plugins[ $key ]['installed'] ) {
					$plugins[ $key ]['pro'] = true;
				} else {
					unset( $plugins[ $key ]['pro'] );
				}

				if ( ! empty( jupiterx_get_api_key() ) && 'jupiterx-pro' === $plugins[ $key ]['slug'] && isset( $plugins[ $key ]['pro'] ) ) {
					unset( $plugins[ $key ]['pro'] );
				}

				if ( ! $plugins[ $key ]['installed'] && ( is_multisite() && ! current_user_can( 'manage_network_plugins' ) ) ) {
					$plugins[ $key ]['install_disabled'] = true;
				}
			}

			$limit = $this->plugins_threshold();

			$this->message( 'Successful', true, [ 'plugins' => $plugins, 'limit' => $limit ] );
			return true;

		} catch ( Exception $e ) {
			$this->message( $e->getMessage(), false );
			return false;
		}
	}

	public function plugins_custom_api( $from = 0, $count = 1, $list_of_attr = [] ) {
		$url = $this->get_api_url() . 'tools/plugin-custom-list';

		$response = $this->wp_remote_get( $url, array(
			'theme-name' => $this->getThemeName(),
			'from'       => $from,
			'count'      => $count,
			'list-of-attr' => json_encode( $list_of_attr ),
		) );

		if ( isset( $response->bool ) == false || $response->bool == false ) {
			throw new Exception( $response->message );
			return false;
		}

		$result = json_decode( json_encode( $response->data ), true );

		if ( is_array( $result ) && count( $result ) > 0 ) {
			foreach ( $result as $key => $value ) {
				$fetch_data = [];
				if ( isset( $value['source'] ) && $value['source'] == 'wp-repo' ) {
					$fetch_data['download_link'] = 'source';
				}
				if ( isset( $value['version'] ) && $value['version'] == 'wp-repo' ) {
					$fetch_data['version'] = 'version';
				}
				if ( isset( $value['desc'] ) && $value['desc'] == 'wp-repo' ) {
					$fetch_data['short_description'] = 'desc';
				}
				if ( is_array( $fetch_data ) && count( $fetch_data ) > 0 ) {
					$response = $this->get_plugin_info_from_wp_repo( $value['slug'], $fetch_data );
					if ( $response != false ) {
						$result[ $key ] = array_replace( $result[ $key ], $response );
					}
				}
			}
		}

		return $result;
	}

	/**
	 * method that is resposible to download plugin from api and install it on WordPress then activate it on last step.
	 * it will get an array of plugins name.
	 *
	 * @author Reza Marandi <ross@artbees.net>
	 *
	 * @param str $this->getPluginName plugin name
	 *
	 * @return bool will return boolean status of action , all message is setted to $this->message()
	 */
	public function install_batch( $plugins_slug_list ) {
		try {
			if ( empty( $plugins_slug_list ) || is_array( $plugins_slug_list ) == false || count( $plugins_slug_list ) == 0 ) {
				throw new Exception( 'Plugin list is not an array , use install method instead.' );
			}

			$response        = true; // Plugin is active.
			$this->set_lock( 'install_batch' , true );

			foreach ( $plugins_slug_list as $key => $plugin_slug ) {
				$this->set_plugin_slug( $plugin_slug );

				$plugin_basename = $this->get_plugin_basename_by_slug( $plugin_slug );

				if ( ! file_exists( trailingslashit( WP_PLUGIN_DIR ) . $plugin_basename ) ) {
					$response = $this->install( $plugin_slug );
				}

				if ( ! is_plugin_active( $plugin_basename ) ) {
					$response = $this->activate( $plugin_basename );
				}

				if ( $response == false ) {
					throw new Exception( $this->get_response_message() );
				}
			}

			$this->set_lock( 'install_batch' , false );
			return true;

		} catch ( Exception $e ) {
			$this->message( $e->getMessage(), false );
			return false;
		}
	}

	/**
	 * this method is resposible to get plugin version .
	 * it used native WordPress functions.
	 *
	 * @author Reza Marandi <ross@artbees.net>
	 *
	 * @param str $plugin_slug for example : (js_composer_theme)
	 *
	 * @return bool|int will return version of plugin or false
	 */
	public function get_plugin_version( $plugin_slug ) {
		$plugin_path = $this->find_plugin_path( $plugin_slug );
		if ( $plugin_path === false ) {
			return false;
		}
		$plugin_full_path = $this->get_plugins_dir() . $plugin_path;
		if ( file_exists( $plugin_full_path ) == false ) {
			return false;
		}
		$get_plugin_data = get_plugin_data( $plugin_full_path );
		$version_response = $get_plugin_data['Version'] ;
		if ( empty( $version_response ) == false ) {
			return $version_response;
		} else {
			return false;
		}
	}

	/**
	 * this method is resposible to get plugin version .
	 * it used native WordPress functions.
	 *
	 * @author Reza Marandi <ross@artbees.net>
	 *
	 * @param str $plugin_slug for example : (js_composer_theme)
	 * @param str $which_field which field do you need from plugins data ? (Name | PluginURI | Version | Description | Author | AuthorURI | TextDomain | DomainPath | Network | Title | AuthorName)
	 *
	 * @return bool|int will return version of plugin or false
	 */
	public function get_plugin_data( $plugin_slug, $which_field ) {
		$plugins = get_plugins();
		foreach ( $plugins as $plugin_address => $plugin_data ) {
			// Extract slug from address
			if ( strlen( $plugin_address ) == basename( $plugin_address ) ) {
				$slug = strtolower( str_replace( '.php', '', $plugin_address ) );
			} else {
				$slug = strtolower( str_replace( '/' . basename( $plugin_address ), '', $plugin_address ) );
			}
			// Check if slug exists
			if ( strtolower( $plugin_slug ) == $slug ) {
				return (isset( $plugin_data[ $which_field ] ) ? $plugin_data[ $which_field ] : false);
			}
		}
		return false;
	}

	/**
	 * this method is resposible to get plugin data name field
	 * it used native WordPress functions.
	 *
	 * @author Sofyan Sitorus <sofyan@artbees.net>
	 *
	 * @param str $plugin_slug plugin slug or plugin path (js_composer_theme | js_composer_theme/js_composer.php)
	 *
	 * @return string Will return plugin name or slug if it was not found
	 */
	public function get_plugin_data_name( $plugin_slug ) {

		$plugin_data_name = $this->get_plugin_data( $plugin_slug, 'Name' );

		if ( ! $plugin_data_name ) {
			$url = $this->get_api_url() . 'tools/plugin';
			$response       = \Httpful\Request::get( $url )
				->addHeaders(
					array(
						'theme-name' => $this->getThemeName(),
						'plugin-slug' => $plugin_slug,
					)
				)
				->send();
			if ( isset( $response->data[0]->name ) ) {
				$plugin_data_name = $response->data[0]->name;
			}
		}

		return empty( $plugin_data_name ) ? $plugin_slug : $plugin_data_name;
	}

	/**
	 * this method is resposible to check if input plugin name is active or not.
	 * it used native WordPress functions.
	 *
	 * @author Reza Marandi <ross@artbees.net>
	 *
	 * @param str $plugin_slug plugin slug or plugin path (js_composer_theme | js_composer_theme/js_composer.php)
	 *
	 * @return bool will return boolean status of action , all message is setted to $this->message()
	 */
	public function check_active_plugin( $plugin_slug ) {
		$active_plugins = get_option( 'active_plugins' );
		if ( is_array( $active_plugins ) == false || count( $active_plugins ) < 1 ) {
			return false;
		}
		foreach ( $active_plugins as $index => $string ) {
			if ( strpos( $string, $plugin_slug ) !== false ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * this method is resposible to find plugin head file and return full path of it.
	 *
	 * @author Reza Marandi <ross@artbees.net>
	 *
	 * @param str $plugin_slug plugins slug for example (js_composer_theme).
	 *
	 * @return string|bool will return plugin path : (js_composer_theme/js_composer.php) or false if plugin slug not exist.
	 */
	public function find_plugin_path( $plugin_slug ) {
		$plugins = get_plugins();
		foreach ( $plugins as $plugin_address => $plugin_data ) {

			// Extract slug from address
			if ( strlen( $plugin_address ) == basename( $plugin_address ) ) {
				$slug = strtolower( str_replace( '.php', '', $plugin_address ) );
			} else {
				$slug = strtolower( str_replace( '/' . basename( $plugin_address ), '', $plugin_address ) );
			}
			// Check if slug exists
			if ( strtolower( $plugin_slug ) == $slug ) {
				return $plugin_address;
			}
		}
		return false;
	}

	/**
	 * Try to grab information from WordPress API.
	 *
	 * @param string $plugin_slug Plugin slug.
	 * @param array  $info_array it should be valued if you want to extract specific data from WordPress info
	 *                           for example : array('download_link' => 'source' , 'version' => 'version')
	 *                           array key : the info name from WordPress repo
	 *                           array value : the name of info that you need to return
	 *
	 * @return object Plugins_api response object on success, WP_Error on failure.
	 */
	public function get_plugin_info_from_wp_repo( $plugin_slug, $info_array = [] ) {
		static $api = array();
		if ( ! isset( $api[ $plugin_slug ] ) ) {
			if ( ! function_exists( 'plugins_api' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
			}

			$response   = plugins_api(
				'plugin_information', array(
					'slug' => $plugin_slug,
					'fields' => array(
						'sections' => false,
						'short_description' => true,
					),
				)
			);
			$api[ $plugin_slug ] = false;

			if ( is_wp_error( $response ) ) {
				throw new Exception( $response->get_error_message() );
				return false;
			} else {
				$api[ $plugin_slug ] = $response;
			}
		}
		if ( is_array( $info_array ) && count( $info_array ) > 0 ) {
			$final_response = [];
			foreach ( $info_array as $key => $value ) {
				if ( empty( $api[ $plugin_slug ]->$key ) == false ) {
					$final_response[ $value ] = $api[ $plugin_slug ]->$key;
				}
			}
			return $final_response;
		} else {
			return $api[ $plugin_slug ];
		}
	}

	/**
	 * Reusable wrapper method for WP remote getter.
	 *
	 * Method only returns response body.
	 */
	public function wp_remote_get( $url = '', $headers = [] ) {
		$required_headers = [
			'api-key' => get_option( 'artbees_api_key' ),
			'domain'  => $_SERVER['SERVER_NAME'],
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
	 * this method is resposible to manage all the classes messages and act different on ajax mode or test mode
	 *
	 * @author Reza Marandi <ross@artbees.net>
	 *
	 * @param str   $message for example ("Successfull")
	 * @param bool  $status true or false
	 * @param mixed $data its for when ever you want to result back an array of data or anything else
	 */
	public function message( $message, $status = true, $data = null ) {
		$response = array(
			'message' => jupiterx_logic_message_helper( 'plugin-management' , $message ),
			'status'  => $status,
			'data'    => $data,
		);

		if ( $this->get_lock() == true ) {
			$this->set_response( $response );
			return true;
		} else {
			// Ajax response to UI
			header( 'Content-Type: application/json' );
			wp_die( json_encode( $response ) );
			return true;
		}
	}
}

new JupiterX_Control_Panel_Plugin_Manager();
