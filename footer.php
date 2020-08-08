<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hcc
 */

$has_nav       = ( has_nav_menu('footer') ) ? true : false;
$has_logo      = ( function_exists( 'hcc_the_custom_logo' ) ) ? true : false;

if( function_exists( 'get_field' ) ) : 
  $socials     = get_field('socials', 'options'); 
  $has_socials = $socials;
  $phones      = get_field('phone_nums', 'options');
  $emails      = get_field('emails', 'options'); 
  $addresses   = get_field('addresses', 'options'); 
else :
  $has_socials = false;
endif;

$nav_class    = '';
$social_class = '';
$logo_class   = '';
  
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

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly  ?>
                </main>
            </div><!-- #content -->
            
            <footer id="colophon" class="site-footer">
              
                <div class="site-footer__top">
                  <div class="container-fluid site-container">
                    <div class="row d-flex align-items-center">
                        <?php if( $has_logo ) : ?>
                        <div class="col-12 col-md-6 col-lg-3 <?php echo $logo_class; ?> order-lg-1 order-1 order-md-1 order-lg-1 site-footer__footer-block">
                            <?php hcc_the_custom_logo(); ?>
                        </div>
                        <?php endif;
                        if( $has_nav ) : ?>
                        <nav id="footer-navigation" class="footer-navigation col-12 col-md-12 col-lg-9 <?php echo $nav_class; ?> order-2 order-md-3 order-lg-2 site-footer__footer-block">
                            <?php wp_nav_menu( array(
                                'theme_location'	=> 'footer',
                                'menu_id'			=> 'primary-menu',
                                'container'		    => '',
                                'walker'            => new HCC_Nav_Walker(),
                            ) ); ?>
                        </nav>
                        <?php endif;
                        if( $has_socials && is_array( $socials ) ) : ?>
                                <div class="col-12 col-md-6 col-lg-12 <?php echo $social_class; ?> order-3 order-md-2 order-lg-3 site-footer__footer-block">
                                           <div class="socials w-100">
                                            <?php foreach( $socials as $social ) : 
                                                $image = $social['icon'];
                                                $href  = esc_url( wp_kses_post( trim( $social['link'] ) ) );
                                                if( !empty( $image ) ) : ?>
                                                    <a href="<?php echo ( !empty( $href )  ) ? $href : '#'; ?>" target="_blank">
                                                        <img src="<?php echo esc_url( $image['url'] ); ?>" title="<?php echo esc_attr( $image['title'] ) ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" class="svg-icon" >
                                                    </a>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            </div>
                                </div>
                        <?php endif; ?>
                    </div>
                  </div>
                </div>
                
                <?php if( $phones && !empty( $phones ) || $emails && !empty( $phones ) || $addresses && !empty( $addresses ) ) : ?>
                      <div class="site-footer__middle">
                        <div class="container-fluid site-container">
                          <div class="row d-flex align-items-center">
                           <?php if( $phones && is_array( $phones ) ) : ?>
                              <div class="col-12 col-md-6  col-lg-4 order-1 site-footer__footer-block">
                                  <div class="w-100 phones">
                                          <?php foreach( $phones as $phone ) : ?>
                                              <?php $tel = sanitize_text_field( trim( $phone['phone_num'] ) );
                                              $href = preg_replace( '~[^0-9]+~', '', $tel ); 
                                              if( !empty( $tel ) ) : ?>
                                                  <a href="tel:<?php echo $href; ?>" class="d-flex align-items-end justify-content-end ml-auto link_el">
                                                      <span class="icon"></span><span class="body"><?php echo $tel; ?></span>
                                                  </a>
                                              <?php endif; ?>
                                          <?php endforeach; ?>
                                  </div>
                              </div>
                            <?php endif;
                            if( $emails && is_array( $emails ) ) : ?>
                            <div class="col-12 col-md-6  col-lg-4 order-2 site-footer__footer-block">
                                <div class="w-100 emails">
                                          <?php foreach( $emails as $email ) : ?>
                                              <?php $email = wp_kses_post( trim( $email['email'] ) ); 
                                              if( !empty( $email ) ) : ?>
                                                  <a href="mailto:<?php echo $email; ?>" class="d-flex align-items-end justify-content-end ml-auto link_el">
                                                      <span class="icon"></span><span class="body"><?php echo $email; ?></span>
                                                  </a>
                                              <?php endif; ?>
                                          <?php endforeach; ?>
                                </div> 
                            </div>
                            <?php endif;
                            if( $addresses && is_array( $addresses ) ) : ?>
                              <div class="col-12 col-md-12 col-lg-4 order-3 site-footer__footer-block">
                                        <div class="w-100 addresses d-block d-md-flex flex-md-column d-lg-block">
                                            <?php foreach( $addresses as $adres ) : ?>
                                                <?php $adress = wp_kses_post( trim( $adres['adress'] ) );
                                                $href = esc_url( wp_kses_post( trim( $adres['g_href'] ) ) ); 
                                                if( !empty( $adress ) ) : ?>
                                                    <a href="<?php echo ( !empty( $href )  ) ? $href : '#'; ?>" target="_blank" rel="nofollow" class="d-flex align-items-end justify-content-end ml-auto link_el">
                                                        <span class="icon"></span><span class="body"><?php echo $adress; ?></span>
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
                
                <div class="site-footer__bottom">
                  <div class="container-fluid site-container">
                    <div class="row d-flex justify-content-center">
                        <a href="<?php echo get_privacy_policy_url(); ?>" class="link_el" rel="nofollow">
                                <?php if( !empty( COPYRIGHT ) ) : echo COPYRIGHT; endif; ?>
                        </a>
                        <?php if( !empty( SITE_FOR_CLIENT ) ) : ?>
                            <div class="col-12 col-md-6 d-flex justify-content-end align-items-center text-white">Created by HCC</div>
                        <?php endif; ?>
                    </div>
                  </div>  
                </div>
                
            </footer><!-- #colophon -->
        </div><!-- #page -->

        <!-- include modal form -->
        <?php //get_template_part('template-parts/modal', 'custom'); ?>
        <!-- include custom widgets -->
        <?php //get_template_part('template-parts/widgets', 'fixed'); ?>
        <!-- include site loader -->
        <?php //get_template_part('template-parts/site', 'loader'); ?>
        
        <div class="overlay"></div>
        <?php wp_footer(); ?>
        
        <?php $browsersync = get_option('hcc-theme-tl-reload'); 
        if( $browsersync === true ) : ?>
            <script id="__bs_script__">//<![CDATA[
                document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.js?v=2.23.6'><\/script>".replace("HOST", location.hostname));
            //]]></script>
        <?php endif; ?>
    </body>
</html>
