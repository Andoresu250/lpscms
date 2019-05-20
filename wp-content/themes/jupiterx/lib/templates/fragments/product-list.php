<?php
/**
 * The Jupiter WooCommerce product list integration.
 *
 * @package JupiterX\Framework\API\WooCommerce
 *
 * @since 1.0.0
 */

add_filter( 'loop_shop_columns', 'jupiterx_wc_loop_shop_columns' );
/**
 * Filter loop columns size.
 *
 * @since 1.0.0
 *
 * @param int $columns Number of columns.
 *
 * @return int
 */
function jupiterx_wc_loop_shop_columns( $columns ) {
	$grid_columns = intval( get_theme_mod( 'jupiterx_product_list_grid_columns', 3 ) );

	if ( ! empty( $grid_columns ) ) {
		return $grid_columns;
	}

	return $columns;
}

add_filter( 'woocommerce_before_shop_loop_item', 'jupiterx_wc_loop_item_before', 0 );
/**
 * Prepend a markup in product item.
 *
 * @since 1.0.0
 */
function jupiterx_wc_loop_item_before() {
	echo '<div class="jupiterx-product-container">';
}

add_filter( 'woocommerce_after_shop_loop_item', 'jupiterx_wc_loop_item_after', 999 );
/**
 * Append a closing markup in product item.
 *
 * @since 1.0.0
 */
function jupiterx_wc_loop_item_after() {
	echo '</div>';
}


add_action( 'woocommerce_shop_loop_item_title', 'jupiterx_wc_template_loop_product_title' );
/**
 * Add product title with custom functionality.
 *
 * @since 1.0.0
 */
function jupiterx_wc_template_loop_product_title() {
	$title_tag = get_theme_mod( 'jupiterx_product_list_title_tag', 'h2' );

	echo sprintf(
		'<%1$s class="woocommerce-loop-product__title">%2$s</%1$s>',
		esc_attr( $title_tag ),
		get_the_title() // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);
}

add_action( 'woocommerce_shop_loop_item_title', 'jupiterx_wc_template_loop_out_of_stock', 10 );
/**
 * Add out of stack badge to shop loop item.
 *
 * @since 1.0.0
 */
function jupiterx_wc_template_loop_out_of_stock() {
	global $product;

	if ( ! $product->is_in_stock() ) {
		echo '<span class="jupiterx-out-of-stock">' . esc_html__( 'Out of Stock', 'jupiterx' ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

add_filter( 'woocommerce_loop_add_to_cart_args', 'jupiterx_wc_loop_add_to_cart_args', 10 );
/**
 * Add arguments to add to cart button.
 *
 * @since 1.0.0
 *
 * @param array $args Button arguments.
 *
 * @return array
 */
function jupiterx_wc_loop_add_to_cart_args( $args ) {
	$args['class'] .= ' jupiterx-icon-shopping-cart-6';

	return $args;
}

jupiterx_wc_loop_pagination_enabled();
/**
 * Enable or disable loop elements.
 *
 * Immediately call this function without any hooks.
 *
 * @since 1.0.0
 */
function jupiterx_wc_loop_pagination_enabled() {
	if ( ! get_theme_mod( 'jupiterx_product_list_pagination', true ) ) {
		remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
	}
}

/**
 * Enable or disable loop elements.
 *
 * @since 1.0.0
 */
jupiterx_wc_loop_elements_enabled();

/**
 * Remove default shop loop title template.
 *
 * @since 1.0.0
 */
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title' );

/**
 * Remove default WooCommerce product image from loop.
 *
 * @since 1.3.0
 */
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

add_action( 'woocommerce_before_shop_loop_item_title', 'jupiterx_wc_loop_product_thumbnail', 10 );
/**
 * Replace default WooCommerce product image in shop loop.
 *
 * It adds extra markup to let object fit polyfill work on IE.
 *
 * @since 1.3.0
 */
function jupiterx_wc_loop_product_thumbnail() {
	global $product;

	$image_size = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );

	jupiterx_open_markup_e( 'jupiterx_wc_loop_product_image', 'div', 'class=jupiterx-wc-loop-product-image' );

		echo $product ? $product->get_image( $image_size ) : ''; // phpcs:ignore

	jupiterx_close_markup_e( 'jupiterx_wc_loop_product_image', 'div' );
}
