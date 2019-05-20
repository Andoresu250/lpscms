<?php
// @codingStandardsIgnoreFile
/**
 * Handler for rendering the text field.
 *
 * @package JupiterX\Framework\API\Fields\Types
 */

jupiterx_add_smart_action( 'jupiterx_field_text', 'jupiterx_field_text' );
/**
 * Render the text field.
 *
 * @since 1.0.0
 *
 * @param array $field      {
 *                          For best practices, pass the array of data obtained using {@see jupiterx_get_fields()}.
 *
 * @type mixed  $value      The field's current value.
 * @type string $name       The field's "name" value.
 * @type array  $attributes An array of attributes to add to the field. The array's key defines the attribute name
 *                          and the array's value defines the attribute value. Default is an empty array.
 * @type mixed  $default    The default value. Default false.
 * }
 */
function jupiterx_field_text( array $field ) {
	printf( '<input id="%s" type="text" name="%s" value="%s" %s>',
		esc_attr( $field['id'] ),
		esc_attr( $field['name'] ),
		esc_attr( $field['value'] ),
		jupiterx_esc_attributes( $field['attributes'] ) // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped -- Escaping is handled in the function.
	);
}
