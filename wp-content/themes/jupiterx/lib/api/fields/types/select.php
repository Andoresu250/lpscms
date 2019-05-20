<?php
// @codingStandardsIgnoreFile
/**
 * Handler for rendering the select field.
 *
 * @package JupiterX\Framework\API\Fields\Types
 */

jupiterx_add_smart_action( 'jupiterx_field_select', 'jupiterx_field_select' );
/**
 * Echo select field type.
 *
 * @since 1.0.0
 *
 * @param array $field      {
 *      For best practices, pass the array of data obtained using {@see jupiterx_get_fields()}.
 *
 * @type mixed  $value      The field's current value.
 * @type string $name       The field's "name" value.
 * @type array  $attributes An array of attributes to add to the field. The array's key defines the attribute name
 *                          and the array's value defines the attribute value. Default is an empty array.
 * @type mixed  $default    The default value. Default false.
 * @type array  $options    An array used to populate the select options. The array key defines option value and the
 *                          array value defines the option label.
 * }
 */
function jupiterx_field_select( array $field ) {

	if ( empty( $field['options'] ) ) {
		return;
	}

	include dirname( __FILE__ ) . '/views/select.php';
}
