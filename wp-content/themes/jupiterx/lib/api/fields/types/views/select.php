<?php
// @codingStandardsIgnoreFile
/**
 * View file for the select field type.
 *
 * @package JupiterX\Framework\API\Fields\Types
 *
 * @since   1.0.0
 */

?>

<select id="<?php echo esc_html( $field['id'] ); ?>" name="<?php echo esc_attr( $field['name'] ); ?>" <?php echo jupiterx_esc_attributes( $field['attributes'] ); ?>><?php // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped -- Escaping is handled in the function. ?>
<?php foreach ( $field['options'] as $value => $label ) : // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- Called from within a function and not within global scope. ?>
	<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $value, $field['value'] ); ?>><?php echo esc_html( $label ); ?></option>
<?php endforeach; ?>
</select>
