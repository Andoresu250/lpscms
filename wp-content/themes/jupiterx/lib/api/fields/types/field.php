<?php
// @codingStandardsIgnoreFile
/**
 * Handler for rendering the field's label and description.
 *
 * @package JupiterX\Framework\API\Fields\Types
 */

jupiterx_add_smart_action( 'jupiterx_field_group_label', 'jupiterx_field_label' );
jupiterx_add_smart_action( 'jupiterx_field_wrap_prepend_markup', 'jupiterx_field_label' );
/**
 * Render the field's label.
 *
 * @since 1.0.0
 *
 * @param array $field {
 *                     Array of data.
 *
 * @type string $label The field label. Default false.
 * }
 */
function jupiterx_field_label( array $field ) {

	// These field types do not use a label, as they are using fieldsets with legends.
	if ( in_array( $field['type'], array( 'radio', 'group', 'activation' ), true ) ) {
		return;
	}

	$label = jupiterx_get( 'label', $field );

	if ( ! $label ) {
		return;
	}

	$id   = 'jupiterx_field_label[_' . $field['id'] . ']';
	$tag  = 'label';
	$args = array( 'for' => $field['id'] );

	jupiterx_open_markup_e( $id, $tag, $args );
		echo esc_html( $field['label'] );
	jupiterx_close_markup_e( $id, $tag );
}

jupiterx_add_smart_action( 'jupiterx_field_wrap_append_markup', 'jupiterx_field_description' );
/**
 * Render the field's description.
 *
 * @since 1.0.0
 *
 * @param array $field       {
 *                           Array of data.
 *
 * @type string $description The field description. The description can be truncated using <!--more--> as a delimiter.
 *                           Default false.
 * }
 */
function jupiterx_field_description( array $field ) {
	$description = jupiterx_get( 'description', $field );

	if ( ! $description ) {
		return;
	}
	// Escape the description here.
	$description = wp_kses_post( $description );

	// If the description has <!--more-->, split it.
	if ( preg_match( '#<!--more-->#', $description, $matches ) ) {
		list( $description, $extended ) = explode( $matches[0], $description, 2 );
	}

	jupiterx_open_markup_e( 'jupiterx_field_description[_' . $field['id'] . ']', 'div', array( 'class' => 'bs-field-description' ) );

		echo $description;  // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped -- To optimize, escaping is handled above.

	if ( isset( $extended ) ) {
		include dirname( __FILE__ ) . '/views/field-description.php';
	}

	jupiterx_close_markup_e( 'jupiterx_field_description[_' . $field['id'] . ']', 'div' );
}
