<?php
// @codingStandardsIgnoreFile
/**
 * Handler for rendering the slider field.
 *
 * @package JupiterX\Framework\API\Fields\Types
 */

jupiterx_add_smart_action( 'jupiterx_field_enqueue_scripts_slider', 'jupiterx_field_slider_assets' );
/**
 * Enqueued assets required by the jupiter slider field.
 *
 * @since 1.0.0
 */
function jupiterx_field_slider_assets() {
	wp_enqueue_script( 'jquery-ui-slider' );
}

jupiterx_add_smart_action( 'jupiterx_field_slider', 'jupiterx_field_slider' );
/**
 * Render the slider field.
 *
 * @since 1.0.0
 *
 * @param array $field       {
 *      For best practices, pass the array of data obtained using {@see jupiterx_get_fields()}.
 *
 * @type mixed     $value      The field's current value.
 * @type string    $name       The field's "name" value.
 * @type array     $attributes An array of attributes to add to the field. The array's key defines the attribute name
 *                             and the array's value defines the attribute value. Default is an empty array.
 * @type int|float $default    The default value.
 * @type string    $min        The slider's minimum value. Default 0.
 * @type string    $max        The slider's maximum value. Default 100.
 * @type string    $interval   The slider's interval. Default 1.
 * @type string    $unit       The slider's units, which is displayed after the current value. Default null.
 * }
 */
function jupiterx_field_slider( array $field ) {
	$defaults = array(
		'min'      => 0,
		'max'      => 100,
		'interval' => 1,
		'unit'     => null,
	);

	$field = array_merge( $defaults, $field );

	include dirname( __FILE__ ) . '/views/slider.php';
}
