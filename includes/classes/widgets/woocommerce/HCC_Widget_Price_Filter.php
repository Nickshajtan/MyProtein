<?php
/*
 * Override WOO widget
 *
 */

namespace WOO_Widgets;

if ( !class_exists( 'WooCommerce' ) ) {
  return false;
}

class HCC_Widget_Price_Filter extends \WC_Widget_Price_Filter {
  
}
