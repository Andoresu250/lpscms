<?php
// @codingStandardsIgnoreFile
/**
 * Handler for rendering the checkbox field.
 *
 * @package JupiterX\Framework\API\Fields\Types
 */

jupiterx_add_smart_action( 'jupiterx_field_checkbox', 'jupiterx_field_checkbox' );
/**
 * Echo checkbox field.
 *
 * @since 1.0.0
 *
 * @param array $field          {
 *      For best practices, pass the array of data obtained using {@see jupiterx_get_fields()}.
 *
 * @type mixed  $value          The field's current value.
 * @type string $name           The field's "name" value.
 * @type array  $attributes     An array of attributes to add to the field. The array's key defines the attribute name
 *                              and the array's value defines the attribute value. Default is an empty array.
 * @type mixed  $default        The default value. Default false.
 * @type string $checkbox_label The field checkbox label. Default is 'Enable'.
 * }
 */
function jupiterx_field_checkbox( array $field ) {
	$checkbox_label = jupiterx_get( 'checkbox_label', $field, __( 'Enable', 'jupiterx' ) );

	include dirname( __FILE__ ) . '/views/checkbox.php';
}
