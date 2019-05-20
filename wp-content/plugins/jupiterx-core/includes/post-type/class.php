<?php
/**
 * Class to register Jupiter post types and custom taxonomies.
 *
 * @package JupiterX_Core\Post_Type
 *
 * @since 1.0.0
 */

/**
 * Handle the Jupiter Portfolio post type.
 *
 * @since 1.0.0
 *
 * @package JupiterX_Core\Post_Type
 */
final class JupiterX_Portfolio {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_post_type' ] );
		add_action( 'init', [ $this, 'register_taxonomies' ] );
	}

	/**
	 * Register post type.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_post_type() {
		$labels = [
			'name'           => _x( 'Portfolios', 'Portfolio General Name', 'jupiterx-core' ),
			'singular_name'  => _x( 'Portfolio', 'Portfolio Singular Name', 'jupiterx-core' ),
			'menu_name'      => __( 'Portfolios', 'jupiterx-core' ),
			'name_admin_bar' => __( 'Portfolio', 'jupiterx-core' ),
			'all_items'      => __( 'All Portfolios', 'jupiterx-core' ),
		];

		/**
		 * Filter portfolio post type arguments.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args The post type arguments.
		 */
		$args = apply_filters( 'jupiterx_portfolio_args', [
			'label'         => __( 'Portfolio', 'jupiterx-core' ),
			'description'   => __( 'Portfolio Description', 'jupiterx-core' ),
			'labels'        => $labels,
			'supports'      => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'trackbacks', 'revisions', 'custom_fields', 'page-attributes' ],
			'public'        => true,
			'menu_position' => 5,
			'can_export'    => true,
			'has_archive'   => true,
			'show_in_rest'  => true,
		] );

		register_post_type( 'portfolio', $args );
	}

	/**
	 * Call taxonomies registration.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_taxonomies() {
		$this->register_category_taxonomy();
		$this->register_tag_taxonomy();
	}

	/**
	 * Register category taxonomy.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function register_category_taxonomy() {
		$labels = array(
			'name'                       => _x( 'Categories', 'Category General Name', 'jupiterx-core' ),
			'singular_name'              => _x( 'Category', 'Category Singular Name', 'jupiterx-core' ),
			'menu_name'                  => __( 'Categories', 'jupiterx-core' ),
			'all_items'                  => __( 'All Categories', 'jupiterx-core' ),
			'parent_item'                => __( 'Parent Category', 'jupiterx-core' ),
			'parent_item_colon'          => __( 'Parent Category:', 'jupiterx-core' ),
			'new_item_name'              => __( 'New Category Name', 'jupiterx-core' ),
			'add_new_item'               => __( 'Add New Category', 'jupiterx-core' ),
			'edit_item'                  => __( 'Edit Category', 'jupiterx-core' ),
			'update_item'                => __( 'Update Category', 'jupiterx-core' ),
			'view_item'                  => __( 'View Category', 'jupiterx-core' ),
			'separate_items_with_commas' => __( 'Separate categories  with commas', 'jupiterx-core' ),
			'add_or_remove_items'        => __( 'Add or remove categories ', 'jupiterx-core' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'jupiterx-core' ),
			'popular_items'              => __( 'Popular Categories', 'jupiterx-core' ),
			'search_items'               => __( 'Search Categories', 'jupiterx-core' ),
			'not_found'                  => __( 'Not Found', 'jupiterx-core' ),
			'no_terms'                   => __( 'No categories ', 'jupiterx-core' ),
			'items_list'                 => __( 'Categories list', 'jupiterx-core' ),
			'items_list_navigation'      => __( 'Categories list navigation', 'jupiterx-core' ),
		);

		/**
		 * Filter portfolio category taxonomy arguments.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args The taxonomy arguments.
		 */
		$args = apply_filters( 'jupiterx_portfolio_category_args', [
			'labels'       => $labels,
			'rewrite'      => [ 'slug' => 'portfolio-category' ],
			'hierarchical' => true,
			'show_in_rest' => true,
		] );

		register_taxonomy( 'portfolio_category', 'portfolio', $args );
	}

	/**
	 * Register tag taxonomy.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function register_tag_taxonomy() {
		$labels = array(
			'name'                       => _x( 'Tags', 'Tag General Name', 'jupiterx-core' ),
			'singular_name'              => _x( 'Tag', 'Tag Singular Name', 'jupiterx-core' ),
			'menu_name'                  => __( 'Tags', 'jupiterx-core' ),
			'all_items'                  => __( 'All Tags', 'jupiterx-core' ),
			'parent_item'                => __( 'Parent Tag', 'jupiterx-core' ),
			'parent_item_colon'          => __( 'Parent Tag:', 'jupiterx-core' ),
			'new_item_name'              => __( 'New Tag Name', 'jupiterx-core' ),
			'add_new_item'               => __( 'Add New Tag', 'jupiterx-core' ),
			'edit_item'                  => __( 'Edit Tag', 'jupiterx-core' ),
			'update_item'                => __( 'Update Tag', 'jupiterx-core' ),
			'view_item'                  => __( 'View Tag', 'jupiterx-core' ),
			'separate_items_with_commas' => __( 'Separate tags with commas', 'jupiterx-core' ),
			'add_or_remove_items'        => __( 'Add or remove tags', 'jupiterx-core' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'jupiterx-core' ),
			'popular_items'              => __( 'Popular Tags', 'jupiterx-core' ),
			'search_items'               => __( 'Search Tags', 'jupiterx-core' ),
			'not_found'                  => __( 'Not Found', 'jupiterx-core' ),
			'no_terms'                   => __( 'No tags', 'jupiterx-core' ),
			'items_list'                 => __( 'Tags list', 'jupiterx-core' ),
			'items_list_navigation'      => __( 'Tags list navigation', 'jupiterx-core' ),
		);

		/**
		 * Filter portfolio tag taxonomy arguments.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args The taxonomy arguments.
		 */
		$args = apply_filters( 'jupiterx_portfolio_tag_args', [
			'labels'       => $labels,
			'rewrite'      => [ 'slug' => 'portfolio-tag' ],
			'show_in_rest' => true,
		] );

		register_taxonomy( 'portfolio_tag', 'portfolio', $args );
	}
}

new JupiterX_Portfolio();
