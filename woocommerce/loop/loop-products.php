<?php
/*
 * Woo template foe products list
 *
 *
 */
wc_get_template_part('loop/loop', 'start'); ?>
  <div class="col-12 woo-shop__products">
    <ul class="row d-grid grid-column-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?> woo-shop__products__grid">
        <?php if ( wc_get_loop_prop( 'total' ) ) :
                      while ( have_posts() ) :
                          the_post();

                          /**
                           * Hook: woocommerce_shop_loop.
                           */
                          do_action( 'woocommerce_shop_loop' );

                          wc_get_template_part( 'content', 'product' );
                       endwhile;
        endif; ?>
      </ul>
    </div>
<?php wc_get_template_part('loop/loop', 'end');