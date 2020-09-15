<?php
/*
 * Including Footer Logo, Socials & Footer Nav
 *
 */

$has_nav       = ( has_nav_menu('footer') ) ? true : false;
$has_logo      = ( function_exists( 'hcc_the_custom_logo' ) ) ? true : false;
$footer_logo   = ( !empty( get_option('options_footer_logo') ) )  ? get_option('options_footer_logo') : false;
$nav_class     = '';
$social_class  = '';
$logo_class    = '';

$subfields = array(
  'icon' => 'image-type',
  'link' => 'text-type',
);

$socials = hcc_get_option_field( 'options_socials', 
    array(
      'icon' => 'image-type',
      'link' => 'text-type',
    ), 
false );

$has_socials  = ( $socials && in_array('footer', get_option('options_socials_display') ) ) ? $socials : false;

if( !$has_logo && $has_nav || !$has_socials && $has_nav ) {
    $nav_class = 'col-xl-10';
}
else {
    $nav_class = 'col-xl-8';
}

if( !$has_nav && $has_logo && $has_socials) {
  $social_class = 'col-xl-6 ';
  $logo_class   = 'col-xl-6 ';
}
else{
  $social_class = 'col-xl-2 ';
  $logo_class   = 'col-xl-2 ';
}

if( $has_logo || $has_nav ) : ?>
                  <div class="site-footer__top">
                    <div class="container-fluid site-container">
                      <div class="row d-flex align-items-center">
                          <?php if( $has_logo ) : ?>
                          <div class="col-12 col-md-6 col-lg-3 <?php echo $logo_class; ?> order-lg-1 order-1 order-md-1 order-lg-1 site-footer__footer-block">
                              <?php hcc_the_custom_logo($footer_logo); ?>
                          </div>
                          <?php endif;
                          if( $has_nav ) : ?>
                          <nav id="footer-navigation" class="footer-navigation col-12 col-md-12 col-lg-9 <?php echo $nav_class; ?> order-2 order-md-3 order-lg-2 site-footer__footer-block">
                              <?php 
                              $nav_args = array(
                                  'theme_location'	=> 'footer',
                                  'menu_id'			=> 'footer-menu',
                                  'container'		=> '',
                                  'depth'           => 1,
                              );

                              if( class_exists('\Core\HCC_Nav_Walker') && isset( $nav_args ) ) :
                                $nav_args['walker'] = new \Core\HCC_Nav_Walker();
                              endif; 

                              wp_nav_menu( $nav_args ); ?>
                          </nav>
                          <?php endif;
                          if( $has_socials && is_array( $socials ) ) : ?>
                                  <div class="col-12 col-md-6 col-lg-12 <?php echo $social_class; ?> order-3 order-md-2 order-lg-3 site-footer__footer-block">
                                             <div class="socials w-100">
                                             
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
                                  </div>
                          <?php endif; ?>
                      </div>
                    </div>
                  </div>
<?php endif; ?>