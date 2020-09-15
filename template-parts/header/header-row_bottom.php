<?php
/*
 * Header Logo & Header Nav
 *
 */
$isset_logo = ( function_exists( 'hcc_the_custom_logo' ) ) ? true : false;
$has_nav    = ( has_nav_menu('header') ) ? true : false;

if( $isset_logo || $has_nav ) : ?>
                 <div class="site-header__bottom col-12 d-flex order-1 order-xl-3 pl-0 pr-0">
                   <div class="container">
                     <div class="row d-flex justify-content-between align-items-center">
                         <div class="col-12 col-xl-3">
                           <?php hcc_the_custom_logo(); ?>
                         </div>
                       <nav id="site-navigation" class="main-navigation site-header__nav col-12 col-xl-9 d-flex justify-content-end">
                              <?php $nav_args = array(
                                        'theme_location'	=> 'header',
                                        'menu_id'			=> 'header-menu',
                                        'container'		    => '',
                                        'depth'             => 3,
                                    );
                                    if( class_exists('\Core\HCC_Nav_Walker') && isset( $nav_args ) ) :
                                      $nav_args['walker'] = new \Core\HCC_Nav_Walker();
                                    endif; 
                                    wp_nav_menu( $nav_args ); ?>
                        </nav>
                     </div>

                   </div>
                 </div>
<?php endif; ?>