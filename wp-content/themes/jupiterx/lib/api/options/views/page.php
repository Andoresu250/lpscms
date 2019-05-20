<?php
/**
 * View file for the page's HTML.
 *
 * @package JupiterX\Framework\API\Options
 *
 * @since   1.0.0
 */

?>

<form action="" method="post" class="bs-options" data-page="<?php echo esc_attr( jupiterx_get( 'page' ) ); ?>">
	<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
	<?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>
	<input type="hidden" name="jupiterx_options_nonce" value="<?php echo esc_attr( wp_create_nonce( 'jupiterx_options_nonce' ) ); ?>" />
	<div class="metabox-holder<?php echo $column_class ? esc_attr( $column_class ) : ''; ?>">
		<?php
		do_meta_boxes( $page, 'normal', null );

		if ( $column_class ) {
			do_meta_boxes( $page, 'column', null );
		}
		?>
	</div>
	<p class="bs-options-form-actions">
		<input type="submit" name="jupiterx_save_options" value="<?php esc_attr_e( 'Save', 'jupiterx' ); ?>" class="button-primary">
		<input type="submit" name="jupiterx_reset_options" value="<?php esc_attr_e( 'Reset', 'jupiterx' ); ?>" class="button-secondary">
	</p>
</form>
