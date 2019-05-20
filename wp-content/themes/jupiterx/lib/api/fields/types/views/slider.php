<?php
// @codingStandardsIgnoreFile
/**
 * View file for the slider field type.
 *
 * @package JupiterX\Framework\API\Fields\Types
 *
 * @since   1.0.0
 */

?>

<div class="bs-slider-wrap" slider_min="<?php echo (int) $field['min']; ?>" slider_max="<?php echo (int) $field['max']; ?>" slider_interval="<?php echo (int) $field['interval']; ?>">
	<input id="<?php echo esc_html( $field['id'] ); ?>" type="text" value="<?php echo esc_attr( $field['value'] ); ?>" name="<?php echo esc_attr( $field['name'] ); ?>" style="display: none;" <?php echo jupiterx_esc_attributes( $field['attributes'] ); ?>/><?php // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped -- Escaping is handled in the function. ?>
</div>
<span class="bs-slider-value"><?php echo esc_html( $field['value'] ); ?></span>

<?php if ( $field['unit'] ) : ?>
<span class="bs-slider-unit"><?php echo esc_html( $field['unit'] ); ?></span>
	<?php
endif;
