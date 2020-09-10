<?php
/*
 * WOO categories item template hooks
 *
 */

/**
 * Remove defaults
 */
add_action( 'woocommerce_init', function() {
  remove_action('woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10);
  remove_action('woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10);
  remove_action('woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10);
  
  add_action('woocommerce_before_subcategory', function( $category ) {
    echo '<a href="' . esc_url( get_term_link( $category, 'product_cat' ) ) . '"><figure>';
  }, 10);
  
  add_action('woocommerce_after_subcategory', function( $category ) {
    echo '</a></figure>';
  }, 10);
  
  add_action('woocommerce_before_subcategory_title', function( $category ) {
    $thumbnail_id         = get_term_meta( $category->term_id, 'thumbnail_id', true );
    if ( $thumbnail_id ) {
      $thumbnail_url        = wp_get_attachment_image_url( $thumbnail_id, 'full' );

      if( is_page( get_option('woocommerce_shop_page_id') ) ) {
        $image       = ( !empty( $thumbnail_url ) && strpos( $thumbnail_url, 'wp-header-logo' ) === false ) ? aq_resize( $thumbnail_url, 270, 270, true, true, true) : false;
        $dimensions  = wc_get_image_size( array(270, 270) );
        $image        = ( is_array( $image ) ) ? $image[0] : $image;
        $image_srcset = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $thumbnail_id, array(270, 270) ) : false;
        $image_sizes  = function_exists( 'wp_get_attachment_image_sizes' ) ? wp_get_attachment_image_sizes( $thumbnail_id, array(270, 270) ) : false;
      }
      else {
        $image = ( !empty( $thumbnail_url ) && strpos( $thumbnail_url, 'wp-header-logo' ) === false ) ? aq_resize( $thumbnail_url, 364, 411, true, true, true) : false;
        $dimensions  = wc_get_image_size( array(364, 411) );
        $image        = ( is_array( $image ) ) ? $image[0] : $image;
        $image_srcset = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $thumbnail_id, array(364, 411) ) : false;
        $image_sizes  = function_exists( 'wp_get_attachment_image_sizes' ) ? wp_get_attachment_image_sizes( $thumbnail_id, array(364, 411) ) : false;
      }
    }
    else {
        $image        = wc_placeholder_img_src();
        $image_srcset = false;
        $image_sizes  = false;
    }

    if ( $image ) {
        // Prevent esc_url from breaking spaces in urls for image embeds.
        // Ref: https://core.trac.wordpress.org/ticket/23605.
        $image = str_replace( ' ', '%20', $image );

        // Add responsive image markup if available.
        if ( $image_srcset && $image_sizes ) {
            echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" srcset="' . esc_attr( $image_srcset ) . '" sizes="' . esc_attr( $image_sizes ) . '" /><figcaption class="sr-only">' . wp_kses_post( $cat->description ) . '</figcaption>';
        } else {
            echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" /><figcaption class="sr-only">' . wp_kses_post( $cat->description ) . '</figcaption>';
        }
    }
  }, 10);
  
  // count inner cats 
  add_filter('woocommerce_subcategory_count_html', function() {
    return '';
  });
});
