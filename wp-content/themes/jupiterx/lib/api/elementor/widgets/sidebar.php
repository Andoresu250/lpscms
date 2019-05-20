<?php
/**
 * Handles overriding Elementor Sidebar widget.
 *
 * @package JupiterX\Framework\API\Elementor
 *
 * @since   1.0.0
 */

/**
 * The Jupiter Elementor's Custom Sidebar
 *
 * @since   1.0.0
 * @ignore
 *
 * @package JupiterX\Framework\API\Elementor
 */
class JupiterX_Elementor_Widget_Sidebar extends \Elementor\Widget_Sidebar {

	/**
	 * Render sidebar widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$sidebar = $this->get_settings_for_display( 'sidebar' );

		if ( empty( $sidebar ) ) {
			return;
		}

		echo jupiterx_widget_area( $sidebar ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
