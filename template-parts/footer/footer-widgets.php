<?php
/*
 * Including Footer sidebars
 *
 *
 */

if ( is_active_sidebar( 'Footer-1' ) ) {
  $footer_first_sidebar  = true;
}
if ( is_active_sidebar( 'Footer-2' ) ) {
  $footer_second_sidebar = true;
}
if ( is_active_sidebar( 'Footer-3' ) ) {
  $footer_third_sidebar  = true;
}

if( $footer_first_sidebar === true && $footer_second_sidebar === true && $footer_third_sidebar === true ) {
  $class = 'col-12 col-md-6 col-lg-4';
}
if( ( $footer_first_sidebar === true && $footer_second_sidebar === true ) || 
    ( $footer_first_sidebar === true && $footer_third_sidebar === true)   || 
    ( $footer_third_sidebar === true && $footer_second_sidebar === true) ) {
  $class = 'col-12 col-md-6 col-lg-6';
}
else {
  $class = 'col-12';
}

if( $footer_first_sidebar || $footer_second_sidebar || $footer_third_sidebar ) : ?>
                      <aside class="site-footer__sidebars">
                        <div class="container-fluid site-container">
                          <div class="row d-flex align-items-center">
                            <?php if( $footer_first_sidebar ) : ?>
                            <div class="<?php echo $class; ?> order-1 site-footer__footer-block">
                                <?php dynamic_sidebar('Footer-1'); ?>
                            </div>
                            <?php endif;
                            if( $footer_second_sidebar ) : ?>
                            <div class="<?php echo $class; ?> order-2 site-footer__footer-block">
                                <?php dynamic_sidebar('Footer-2'); ?>
                            </div>
                            <?php endif;
                            if( $footer_third_sidebar ) : ?>
                              <div class="<?php echo $class; ?> order-3 site-footer__footer-block">
                                <?php dynamic_sidebar('Footer-3'); ?>
                              </div>
                            <?php endif; ?>
                          </div>
                        </div>
                      </aside>
<?php endif; 
