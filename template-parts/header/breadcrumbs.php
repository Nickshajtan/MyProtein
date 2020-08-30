<?php 
/*
 * Site breadcrumbs
 *
 */

if ( function_exists( 'yoast_breadcrumb' ) ) :
                  $breadcrumbs = yoast_breadcrumb( '<div id="breadcrumbs">', '</div>', false ); 
            
                  if( !empty( $breadcrumbs ) ) :
                  
                    if( function_exists('is_woocommerce') && is_woocommerce() && function_exists('woocommerce_breadcrumb') ) :

                      $sep   = get_option('wpseo_titles')['separator'];
                      $title = wp_kses_post( get_the_title( get_option('page_on_front') ) );
                      $args  = array(
                        'delimiter'   => ( !empty( $sep ) )   ? $sep   : '&nbsp;&rarr;&nbsp;',
                        'wrap_before' => '<div id="breadcrumbs">',
                        'wrap_after'  => '</div>',
                        'home'        => ( !empty( $title ) ) ? $title : __('Главная', 'hcc'),
                      );
                      woocommerce_breadcrumb( $args );  
                      
                    else : ?>
                      <div class="breadcrumbs">
                            <?php echo $breadcrumbs; ?>
                      </div>
                    <?php endif; 

                  endif;

endif; ?>
