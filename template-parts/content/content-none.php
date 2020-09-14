<?php
/**
* Template part for displaying a message that posts cannot be found
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package hcc
*/

if ( is_search() ) :
	?>
    <div class="container">
        <div class="row">
          <div class="col-12 d-flex align-items-center content-none">
	        <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'hcc' ); ?></p>
          </div>
        </div>
    </div>
	<?php 
else : 
	if( function_exists('is_woocommerce') && is_woocommerce() ) : 
      $left_sidebar    = ( is_active_sidebar( 'WOO-Left' ) )  ? true : false;
      $right_sidebar   = ( is_active_sidebar( 'WOO-Right' ) ) ? true : false;
      $class           = 'col-12';

      if( !is_product() && $left_sidebar && $right_sidebar ) {
        $class = 'col-12 col-lg-6';
      }

      if( !is_product() && $left_sidebar || $right_sidebar ) {
        $class = 'col-12 col-lg-9';
      }
    ?>
      <div class="container">
        <div class="row">
          <div class="col-12 d-flex align-items-center content-none">
             <div class="row d-flex w-100">
               <?php if( !is_product() && $left_sidebar ) : ?>
                 <aside class="col-12 col-lg-3"><ul><?php dynamic_sidebar('WOO-Left'); ?></ul></aside>
               <?php endif; ?>
               <div class="<?php echo $class; ?> mr-auto ml-auto">
                 <p class="text-center w-100"><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'hcc' ); ?></p>  
               </div>
             </div>
             <?php if( !is_product() && $right_sidebar ) : ?>
                 <aside class="col-12 col-lg-3"><ul><?php dynamic_sidebar('WOO-Right'); ?></ul></aside>
             <?php endif; ?>
          </div>
        </div>
      </div>
    <?php else : ?>
      <div class="container">
        <div class="row">
          <div class="col-12 d-flex align-items-center content-none">
              <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'hcc' ); ?></p>  
          </div>
        </div>
    </div>
	<?php endif;
endif;
