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
  <?php get_template_part('template-parts/header/head');
  /** Default site preloader **/
  $loader = get_option('hcc-theme-tl-preloader');
  if( $loader ) :
    get_template_part('template-parts/header/loader', 'default');
  endif;
  ?>

  <body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
	<div id="page" class="site remodal-bg">
		<header id="masthead" class="site-header closed <?php if( is_front_page() || is_404() ) : ?>absolute<?php endif; ?>">
		
			<div class="wrapper container-fluid pl-0 pr-0 site-header__container">
               <div class="burger">
                   <span></span>
                   <span></span>
                   <span></span>
               </div>
               
               <div class="row-fluid d-flex flex-column">
                 <?php 
                 /*** Widgets, Woo cart & Woo search, Socials ***/
                 get_template_part('template-parts/header/header', 'row_top');
                 /*** Contact info ***/
                 get_template_part('template-parts/header/header', 'row_middle');
                 /*** Logo & Nav ***/
                 get_template_part('template-parts/header/header', 'row_bottom'); 
                 ?>
               </div>
		    
		    <?php if( current_theme_supports('custom-header') && get_option('hcc-theme-wp-customizing') && has_custom_header() ) :
              the_custom_header_markup();
            endif; ?>
          </div>
	    </header>
	    <?php  
        /*** Search widgets area ***/
        get_template_part('template-parts/header/header', 'full_width_search');
        /*** Breadcrumbs ***/
        get_template_part('template-parts/header/breadcrumbs');
        ?>
	    
	<div id="content" class="site-content">
	    <main>
	    