<?php
/*
 * Display Header socials, widgets
 * If Woocommerce is enable display Woo cart & Woo search and not display widgets
 *
 */
$woo        = ( defined('WOO_SUPPORT') ) ? WOO_SUPPORT : is_plugin_active( 'woocommerce/woocommerce.php' );
$has_woo    = ( class_exists('WooCommerce') && $woo ) ? true : false;

$sidebars   = ( is_active_sidebar( 'Header-1' ) || is_active_sidebar( 'Header-2' ) ) ? true : false;
$sidebars   = ( $has_woo === true ) ? false : $sidebars;

$socials = hcc_get_option_field( 'options_socials', 
                array(
                  'icon' => 'image-type',
                  'link' => 'text-type',
                ), 
false );

$has_socials  = ( (boolean) $socials && in_array('header', get_option('options_socials_display') ) ) ? (boolean) $socials : false;
$horisontal   = ( isset( $has_socials ) && $has_socials === true ) ? 'start' : 'end';

if( $has_socials || $has_woo || $sidebars ) : ?>
                 <div class="site-header__top col-12 order-3 order-xl-1 pl-0 pr-0">
                   <div class="container">
                     <div class="row d-flex align-items-center justify-content-<?php echo $horisontal; ?>">
                       <?php if( is_array( $socials ) && !is_null( $socials ) ) : ?>
                         <div class="col-12 col-xl-3 socials d-flex order-3 order-xl-1">
                            <?php foreach( $socials as $social ) : 
                                $image = wp_get_attachment_image( $social['icon'], 'full', false, array('class' => 'svg-icon'));
                                $href  = ( !empty( $social['link'] ) ) ? esc_url( wp_kses_post( trim( $social['link'] ) ) ) : '#';
                           
                                if( !empty( $image ) && !is_null( $image ) ) : ?>
                                    <a href="<?php echo $href; ?>" target="_blank">
                                        <?php echo $image; ?>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                         </div>
                       <?php endif;
                       if( $has_woo && !$sidebars ) : ?>
                         <div class="col-12 col-xl-5 d-flex order-2 order-xl-2 offset-xl-1 justify-content-end search-block">
                            <a href="#" onclick="alert('Тут будет поиск')">Поиск по товарам</a>
                         </div>
                         <div class="col-12 col-xl-3 d-flex order-1 order-xl-3 justify-content-end cart-block">
                            <a href="#" onclick="alert('Тут будет корзина')">Корзина (0)</a>
                         </div>
                       <?php endif;
                       if( !$has_woo && $sidebars ) : 
                          if( is_active_sidebar( 'Header-1' ) ) : ?>
                         <div class="col-12 col-xl-5 d-flex order-2 order-xl-2 offset-xl-1 justify-content-end sidebar-block">
                            <?php dynamic_sidebar( 'Header-1' ); ?>
                         </div>
                         <?php endif;
                         if( is_active_sidebar( 'Header-2' ) ) : ?>
                         <div class="col-12 col-xl-3 d-flex order-1 order-xl-3 justify-content-end sidebar-block">
                            <?php dynamic_sidebar( 'Header-2' ); ?>
                         </div>
                         <?php endif;
                       endif; ?>
                     </div>
                   </div>
                 </div>
<?php endif; ?>
