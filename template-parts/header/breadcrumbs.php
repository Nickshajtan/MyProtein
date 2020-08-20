<?php 
/*
 * Site breadcrumbs
 *
 */
if ( function_exists( 'yoast_breadcrumb' ) ) :
                  $breadcrumbs = yoast_breadcrumb( '<div id="breadcrumbs">', '</div>', false ); 
            
                  if( !empty( $breadcrumbs ) ) : ?>
                  <div class="breadcrumbs">
                      <?php echo $breadcrumbs; ?>
                  </div>
                  <?php endif;
endif; ?>
