<?php
// @codingStandardsIgnoreFile
/**
 * View file for the field's description.
 *
 * @package JupiterX\Framework\API\Fields\Types
 *
 * @since   1.0.0
 */

?>

<br /><a class="bs-read-more" href="#"><?php esc_html_e( 'More...', 'jupiterx' ); ?></a>
<div class="bs-extended-content" style="display: none;"><?php echo $extended; ?></div><?php // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped -- To optimize, escaping is handled in the calling function. ?>
