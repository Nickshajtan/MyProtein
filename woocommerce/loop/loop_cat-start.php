<?php
/**
 * Product Loop Start
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$columns = esc_attr( wc_get_loop_prop( 'columns' ) );
$columns = ( !empty( $columns ) ) ? $columns : hcc_woocommerce_loop_columns();
$columns = absint( $columns );

if( !is_woocommerce() || is_shop() ) : 
  $class = $columns;
else: 
  $class = $columns - 1;
  $class = absint( $class );
endif;
?>

<ul class="woo-wrap__list woo-wrap__list_cats col-12 d-grid grid-column-<?php echo $class; ?>">
