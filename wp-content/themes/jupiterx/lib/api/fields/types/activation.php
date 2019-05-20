<?php
// @codingStandardsIgnoreFile
/**
 * Handler for rendering the activation field.
 *
 * @package JupiterX\Framework\API\Fields\Types
 */

jupiterx_add_smart_action( 'jupiterx_field_activation', 'jupiterx_field_activation' );
/**
 * Render the activation field.
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
 * @type int    $default    The default value.
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
function jupiterx_field_activation( array $field ) {
	include dirname( __FILE__ ) . '/views/activation.php';
}
