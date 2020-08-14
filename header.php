<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hcc
 */

/*
 * PHP compression
 *
 */
if( get_option('hcc-theme-tl-gzip') || get_option('hcc-theme-tl-zlib') ) :
  get_template_part('compression');
endif;

/*
 * Check ACF including 
 *
 */
if( !class_exists('ACF') ) : 
        if( is_user_logged_in() && current_user_can('update_plugins') && current_user_can('install_plugins') ) :
          if( isset( $theme_error) ) :
            $theme_error(__('ACF plugin is not included. Enable it now, please, this plugin is required for website correct work.', 'hcc'), __('Must use component not found.', 'hcc'));
          else:
            echo __('ACF is not included. Enable it now, please, or contact withsite admin, becouse this plugin is required', 'hcc');
          endif;
        elseif( is_user_logged_in() ) :
            echo __('ACF is not included. Enable it now, please, or contact withsite admin, becouse this plugin is required', 'hcc');
            exit();
        else :
          header( 'Status: 403 Forbidden' );
	      header( 'HTTP/1.1 403 Forbidden' );
	      exit();
        endif;
endif; ?>
<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('template-parts/header/head'); ?>

  <body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
	<div id="page" class="site remodal-bg">
	
		<?php /** Header settings **/
              
              $show_first_row  = true;
              $show_second_row = false;
              
              $has_nav    = ( has_nav_menu('header') ) ? true : false;
              $has_woo    = ( class_exists('WooCommerce') ) ? true : false;
              $isset_logo = ( function_exists( 'hcc_the_custom_logo' ) ) ? true : false;
      
              if( function_exists( 'get_field' ) ) : 
                $socials     = get_field('socials', 'options');
                $phones      = get_field('phone_nums', 'options');
                $emails      = get_field('emails', 'options'); 
                $addresses   = get_field('addresses', 'options');
              endif;
        ?>
		<header id="masthead" class="site-header closed <?php if( is_front_page() ) : ?>absolute<?php endif; ?>">
		
			<div class="wrapper container-fluid pl-0 pr-0 site-header__container">
               <div class="burger">
                   <span></span>
                   <span></span>
                   <span></span>
               </div>
               
               
               <div class="row-fluid d-flex flex-column">
                 
                 <?php if( $socials && $show_first_row || $has_woo && $show_first_row ) : ?>
                 <div class="site-header__top col-12 order-3 order-xl-1 pl-0 pr-0">
                   <div class="container">
                     <div class="row -flex align-items-center">
                       <?php if( is_array( $socials ) && !is_null( $socials ) ) : ?>
                         <div class="col-12 col-xl-3 socials d-flex order-3 order-xl-1">
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
                       <?php endif;
                       if( true || $has_woo ) : ?>
                         <div class="col-12 col-xl-5 d-flex order-2 order-xl-2 offset-xl-1 justify-content-end search-block">
                            <a href="#" onclick="alert('Тут будет поиск')">Поиск по товарам</a>
                         </div>
                         <div class="col-12 col-xl-3 d-flex order-1 order-xl-3 justify-content-end cart-block">
                            <a href="#" onclick="alert('Тут будет корзина')">Корзина (0)</a>
                         </div>
                       <?php endif; ?>
                     </div>
                   </div>
                 </div>
                 <?php endif; ?>
                 
                 <?php if( $show_second_row && ( $phones || $emails || $addresses ) ) :
                    get_template_part('template-parts/header/header', 'middle');
                 endif; ?>
                 
                 <?php if( $isset_logo || $has_nav ) : ?>
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
                                    );
                                    if( class_exists('HCC_Nav_Walker') && isset( $nav_args ) ) :
                                      $nav_args['walker'] = new HCC_Nav_Walker();
                                    endif; 
                                    wp_nav_menu( $nav_args ); ?>
                        </nav>
                     </div>

                   </div>
                 </div>
                 <?php endif; ?>
                 
               </div>
                
		    
		    
		    <?php if( current_theme_supports('custom-header') && get_option('hcc-theme-wp-customizing') && has_custom_header() ) :
              the_custom_header_markup();
            endif; ?>
          </div>
	    </header>

	<div id="content" class="site-content">
	    <main>
            <?php if ( function_exists( 'yoast_breadcrumb' ) ) : ?>
            <div class="breadcrumbs">
                <?php yoast_breadcrumb( '<div id="breadcrumbs">', '</div>' ); ?>
            </div>
            <?php endif; ?>