<?php
/**
 * Handler for rendering the image field.
 *
 * @package JupiterX\Framework\API\Fields\Types
 */

jupiterx_add_smart_action( 'jupiterx_field_enqueue_scripts_image', 'jupiterx_field_image_assets' );
/**
 * Enqueued the assets for the image field.
 *
 * @since 1.0.0
 *
 * @return void
 */
function jupiterx_field_image_assets() {
	wp_enqueue_media();
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script( 'jupiterx-field-media', JUPITERX_API_URL . 'fields/assets/js/media' . JUPITERX_MIN_CSS . '.js', array( 'jquery' ), JUPITERX_VERSION ); // @codingStandardsIgnoreLine
}

jupiterx_add_smart_action( 'jupiterx_field_image', 'jupiterx_field_image' );
/**
 * Render the image field, which handles a single image or a gallery of images.
 *
 * @since 1.0.0
 *
 * @param array $field       {
 *                           For best practices, pass the array of data obtained using {@see jupiterx_get_fields()}.
 *
 * @type mixed  $value       The image's or images' ID.
 * @type string $name        The field's "name" value.
 * @type array  $attributes  An array of attributes to add to the field. The array's key defines the attribute name
 *                           and the array's value defines the attribute value. Default is an empty array.
 * @type mixed  $default     The default value. Default is false.
 * @type string $is_multiple Set to true to enable multiple images (gallery). Default is false.
 * }
 */
function jupiterx_field_image( array $field ) {
	$images      = array_merge( (array) $field['value'], array( 'placeholder' ) );
	$is_multiple = jupiterx_get( 'multiple', $field );
	$link_text   = _n( 'Add Image', 'Add Images', ( $is_multiple ? 2 : 1 ), 'jupiterx' );

	// If this is a single image and it already exists, then hide the "add image" hyperlink.
	$hide_add_link = ! $is_multiple && is_numeric( $field['value'] );

	// Render the view file.
	include dirname( __FILE__ ) . '/views/image.php';
}

/**
 * Get the Image ID's attributes.
 *
 * @since  1.0.0
 * @ignore
 * @access private
 *
 * @param string $id          The given image's ID.
 * @param array  $field       The field's configuration parameters.
 * @param bool   $is_multiple Multiple flag.
 *
 * @return array
 */
function _jupiterx_get_image_id_attributes( $id, array $field, $is_multiple ) {
	$attributes = array_merge( array(
		'class' => 'image-id',
		'type'  => 'hidden',
		'name'  => $is_multiple ? $field['name'] . '[]' : $field['name'], // Return single value if not multiple.
		'value' => $id,
	), $field['attributes'] );

	if ( 'placeholder' === $id ) {
		$attributes = array_merge(
			$attributes,
			array(
				'disabled' => 'disabled',
				'value'    => false,
			)
		);
	}

	return $attributes;
}

/**
 * Get the image's URL.
 *
 * @since 1.0.0
 *
 * @param mixed $image_id The image's attachment ID.
 *
 * @return string|void
 */
function _jupiterx_get_image_url( $image_id ) {
	$image_id = (int) $image_id;

	// If this is not a valid image ID, bail out.
	if ( $image_id < 1 ) {
		return;
	}

	return jupiterx_get( 0, wp_get_attachment_image_src( $image_id, 'thumbnail' ) );
}

/**
 * Get the image's alt description.
 *
 * @since 1.0.0
 *
 * @param mixed $image_id The image's attachment ID.
 *
 * @return string|void
 */
function _jupiterx_get_image_alt( $image_id ) {
	$image_id = (int) $image_id;

	// If this is not a valid image ID, bail out.
	if ( $image_id < 1 ) {
		return;
	}

	$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

	// If this image does not an "alt" defined, return the default.
	if ( ! $image_alt ) {
		return __( 'Sorry, no description was given for this image.', 'jupiterx' );
	}

	return $image_alt;
}
