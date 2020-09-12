<?php
/*
 * Override WOO widget
 *
 */

namespace WOO_Widgets;

if ( !class_exists( 'WooCommerce' ) ) {
  return false;
}

class HCC_Widget_Layered_Nav extends \WC_Widget_Layered_Nav {
  
    private static $_exclude_variable_products = false;
  
    /**
	 * Constructor.
	 */
	public function __construct() {
        $this->_exclude_variable_products = $_exclude_variable_products;
		$this->widget_cssclass    = 'woocommerce widget_layered_nav woocommerce-widget-layered-nav hcc-override';
		$this->widget_description = __( 'Display a list of attributes to filter products in your store.', 'woocommerce' );
		$this->widget_id          = 'hcc_woocommerce_layered_nav';
		$this->widget_name        = 'HCC ' . __( 'Filter Products by Attribute', 'woocommerce' );
		\WC_Widget::__construct();
	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args Arguments.
	 * @param array $instance Instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! is_shop() && ! is_product_taxonomy() ) {
			return;
		}

		$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
		$taxonomy           = $this->get_instance_taxonomy( $instance );
		$query_type         = $this->get_instance_query_type( $instance );
		$display_type       = $this->get_instance_display_type( $instance );

		if ( ! taxonomy_exists( $taxonomy ) ) {
			return;
		}

		$terms = get_terms( $taxonomy, array( 'hide_empty' => '1' ) );

		if ( 0 === count( $terms ) ) {
			return;
		}

		ob_start();

		$this->widget_start( $args, $instance );

		if ( 'dropdown' === $display_type ) {
			wp_enqueue_script( 'selectWoo' );
			wp_enqueue_style( 'select2' );
			$found = $this->layered_nav_dropdown( $terms, $taxonomy, $query_type );
		} else {
			$found = $this->layered_nav_list( $terms, $taxonomy, $query_type );
		}

		$this->widget_end( $args );

		// Force found when option is selected - do not force found on taxonomy attributes.
		if ( ! is_tax() && is_array( $_chosen_attributes ) && array_key_exists( $taxonomy, $_chosen_attributes ) ) {
			$found = true;
		}

		if ( ! $found ) {
			ob_end_clean();
		} else {
			echo ob_get_clean(); // @codingStandardsIgnoreLine
		}
	}
  
    /**
	 * Count products within certain terms, taking the main WP query into consideration.
	 *
	 * This query allows counts to be generated based on the viewed products, not all products.
	 *
	 * @param  array  $term_ids Term IDs.
	 * @param  string $taxonomy Taxonomy.
	 * @param  string $query_type Query Type.
	 * @return array
	 */
	protected function get_filtered_term_product_counts( $term_ids, $taxonomy, $query_type ) {
		global $wpdb;
        $this->_exclude_variable_products = $exclude_variable_products;

		$main_tax_query = $this->get_main_tax_query();
		$meta_query     = $this->get_main_meta_query();

		$non_variable_tax_query_sql = array( 'where' => '' );
		$is_and_query               = 'and' === $query_type;

		foreach ( $main_tax_query as $key => $query ) {
			if ( is_array( $query ) && $taxonomy === $query['taxonomy'] ) {
				if ( $is_and_query ) {
					$non_variable_tax_query_sql = $this->convert_tax_query_to_sql( array( $query ) );
				}
				unset( $main_tax_query[ $key ] );
			}
		}

        if( $this->_exclude_variable_products === true ) {
          $exclude_variable_products_tax_query_sql = $this->get_extra_tax_query_sql( 'product_type', array( 'variable' ), 'NOT IN' );
        }

		$meta_query_sql     = ( new WP_Meta_Query( $meta_query ) )->get_sql( 'post', $wpdb->posts, 'ID' );
		$main_tax_query_sql = $this->convert_tax_query_to_sql( $main_tax_query );
		$term_ids_sql       = '(' . implode( ',', array_map( 'absint', $term_ids ) ) . ')';

		// Generate the first part of the query.
		// This one will return non-variable products and variable products with concrete values for the attributes.
		$query           = array();
		$query['select'] = "SELECT IF({$wpdb->posts}.post_type='product_variation', {$wpdb->posts}.post_parent, {$wpdb->posts}.ID) AS product_id, terms.term_id AS term_count_id";
		$query['from']   = "FROM {$wpdb->posts}";
		$query['join']   = "
			INNER JOIN {$wpdb->term_relationships} AS tr ON {$wpdb->posts}.ID = tr.object_id
			INNER JOIN {$wpdb->term_taxonomy} AS term_taxonomy USING( term_taxonomy_id )
			INNER JOIN {$wpdb->terms} AS terms USING( term_id )
			{$main_tax_query_sql['join']} {$meta_query_sql['join']}"; // Not an omission, really no more JOINs required.

		$variable_where_part = "
			OR ({$wpdb->posts}.post_type = 'product_variation'
		    AND NOT EXISTS (
		        SELECT ID FROM {$wpdb->posts} AS parent
		        WHERE parent.ID = {$wpdb->posts}.post_parent AND parent.post_status NOT IN ('publish')
		    ))
		";

		$search_sql = '';
		$search     = $this->get_main_search_query_sql();
		if ( $search ) {
			$search_sql = ' AND ' . $search;
		}

		$query['where'] = "
			WHERE
			{$wpdb->posts}.post_status = 'publish'
			{$main_tax_query_sql['where']} {$meta_query_sql['where']}
			AND (
				(
					{$wpdb->posts}.post_type = 'product'
					{$exclude_variable_products_tax_query_sql['where']}
					{$non_variable_tax_query_sql['where']}
				)
				{$variable_where_part}
			)
			AND terms.term_id IN {$term_ids_sql}
			{$search_sql}";

		$search = $this->get_main_search_query_sql();
		if ( $search ) {
			$query['where'] .= ' AND ' . $search;
		}

		$query          = apply_filters( 'woocommerce_get_filtered_term_product_counts_query', $query );
		$main_query_sql = implode( ' ', $query );

		// Generate the second part of the query.
		// This one will return products having "Any..." as the value of the attribute.

		$query_sql_for_attributes_with_any_value = "
			SELECT {$wpdb->posts}.ID AS product_id, {$wpdb->term_relationships}.term_taxonomy_id as term_count_id FROM {$wpdb->posts}
		 	JOIN {$wpdb->posts} variations ON variations.post_parent = {$wpdb->posts}.ID
			LEFT JOIN {$wpdb->postmeta} ON variations.ID = {$wpdb->postmeta}.post_id AND {$wpdb->postmeta}.meta_key = 'attribute_$taxonomy'
			JOIN {$wpdb->term_relationships} ON {$wpdb->term_relationships}.object_id = {$wpdb->posts}.ID
			WHERE ( {$wpdb->postmeta}.meta_key IS NULL OR {$wpdb->postmeta}.meta_value = '')
			AND {$wpdb->posts}.post_type = 'product'
			AND {$wpdb->posts}.post_status = 'publish'
			AND variations.post_status = 'publish'
			AND variations.post_type = 'product_variation'
			AND {$wpdb->term_relationships}.term_taxonomy_id in $term_ids_sql
			{$main_tax_query_sql['where']}";

		// We have two queries - let's see if cached results of this query already exist.
		$query_hash = md5( $main_query_sql . $query_sql_for_attributes_with_any_value );

		// Maybe store a transient of the count values.
		$cache = apply_filters( 'woocommerce_layered_nav_count_maybe_cache', true );
		if ( true === $cache ) {
			$cached_counts = (array) get_transient( 'wc_layered_nav_counts_' . sanitize_title( $taxonomy ) );
		} else {
			$cached_counts = array();
		}

		if ( ! isset( $cached_counts[ $query_hash ] ) ) {
			$counts                       = $this->get_term_product_counts_from_queries( $main_query_sql, $query_sql_for_attributes_with_any_value );
			$cached_counts[ $query_hash ] = $counts;
			if ( true === $cache ) {
				set_transient( 'wc_layered_nav_counts_' . sanitize_title( $taxonomy ), $cached_counts, DAY_IN_SECONDS );
			}
		}

		return array_map( 'absint', (array) $cached_counts[ $query_hash ] );
	}
}
