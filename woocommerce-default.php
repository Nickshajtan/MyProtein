<?php
/**
 * Template for woocommerce page
 * @package hcc
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

$left_sidebar    = ( is_active_sidebar( 'WOO-Left' ) )  ? true : false;
$second_sidebar  = ( is_active_sidebar( 'WOO-Right' ) ) ? true : false;

$class = ( $left_sidebar && $second_sidebar ) ? 'col-lg-4' : 'col-lg-12';
$class = ( $left_sidebar || $second_sidebar ) ? 'col-lg-8' : 'col-lg-12';

get_header();
if( have_posts() ) : ?>
      <section class="container-fluid site-container woo-wrap">
                <div class="row-fluid">
                  <?php if( $left_sidebar ) : ?>
                  <div class="woo-sidebar-left woo-sidebar col-12 col-lg-4 p-0">
                     <?php 
                      /**
                       * Hook: woocommerce_sidebar.
                       *
                       * @hooked woocommerce_get_sidebar - 10
                       */
                      do_action( 'woocommerce_sidebar' );
                      ?>
                    <ul><?php dynamic_sidebar('WOO-Left'); ?></ul>
                  </div>
                  <?php endif; ?>
                  <div class="<?php echo $class; ?> woo-wrap__content">
                    <?php woocommerce_content(); ?>
                  </div>
                  <?php if( $second_sidebar ) : ?>
                  <div class="woo-sidebar-right woo-sidebar col-12 col-lg-4 p-0">
                    <?php 
                    /**
                     * Hook: woocommerce_sidebar.
                     *
                     * @hooked woocommerce_get_sidebar - 10
                     */
                    do_action( 'woocommerce_sidebar' );
                    ?>
                    <ul><?php dynamic_sidebar('WOO-Right'); ?></ul>
                  </div>
                  <?php endif; ?>
                </div>
      </section>
<?php else :
    get_template_part( 'template-parts/content/content', 'none' );
endif; 
get_footer();

unset($left_sidebar);
unset($second_sidebar);
?>
