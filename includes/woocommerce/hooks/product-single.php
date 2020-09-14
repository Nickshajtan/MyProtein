<?php
/*
 * WOO products single template hooks
 * 
 */
add_action('woocommerce_init', function(){
  
  // Unset hooks
  remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices', 10);
  remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
  remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
  
  // Remove tabs
  add_filter( 'woocommerce_product_tabs', function( $tabs ) {
    unset( $tabs['reviews'] );                // Remove reviews
    unset( $tabs['additional_information'] ); // Remove additional
    return $tabs;
  }, 98 );
  
  // Related Products
  remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
  remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
  
  add_action('woocommerce_after_single_product', function() {
    echo do_shortcode('[hcc_woo_related_products limit="3" per_page="3" columns="3" order="ASC" orderby="rand"]');
  });
  

  /*
   * Override WOO gallery function
   *
   */
  if( !function_exists('hcc_wc_get_gallery_image_html') ) :
    function hcc_wc_get_gallery_image_html( $attachment_id, $main_image = false ) {
        $flexslider        = (bool) apply_filters( 'woocommerce_single_product_flexslider_enabled', get_theme_support( 'wc-product-gallery-slider' ) );
        $gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
        $thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
        $image_size        = apply_filters( 'woocommerce_gallery_image_size', $flexslider || $main_image ? 'woocommerce_single' : $thumbnail_size );
        $full_size         = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
        $thumbnail_src     = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
        $full_src          = wp_get_attachment_image_src( $attachment_id, $full_size );
        $resize_src        = aq_resize( $attachment_id, 527, 623, true, true, true );
        $alt_text          = trim( wp_strip_all_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );
        $src               = ( !empty( $resize_src ) ) ? esc_url( $resize_src ) : $image_size;
        $image             = wp_get_attachment_image(
            $attachment_id,
            $src,
            false,
            apply_filters(
                'woocommerce_gallery_image_html_attachment_image_params',
                array(
                    'title'                   => _wp_specialchars( get_post_field( 'post_title', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
                    'data-caption'            => _wp_specialchars( get_post_field( 'post_excerpt', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
                    'data-src'                => esc_url( $src ),
                    'data-large_image'        => esc_url( $full_src[0] ),
                    'data-large_image_width'  => esc_attr( $full_src[1] ),
                    'data-large_image_height' => esc_attr( $full_src[2] ),
                    'class'                   => esc_attr( $main_image ? 'wp-post-image img-responsive img-inner' : 'img-responsive img-inner' ),
                ),
                $attachment_id,
                $src,
                $main_image
            )
        );
        
        
        return '<div data-thumb="' . esc_url( $thumbnail_src[0] ) . '" data-thumb-alt="' . esc_attr( $alt_text ) . '" class="woocommerce-product-gallery__image"><a href="' . $full_src[0] . '">' . $image . '</a></div>';
    }
  endif;
});
