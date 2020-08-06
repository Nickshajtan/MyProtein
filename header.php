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
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
/*
 * Check ZLIB & set ZLIB
 *
 */
$zlib = ini_get('zlib.output_compression');
if( isset( $zlib ) && $zlib !== 'On' && ini_get('zlib.output_compression_level') !== '1' ) :
    ini_set('zlib.output_compression', 'On');
    ini_set('zlib.output_compression_level', '1');
endif; 
/*
 * Check ZLIB and set GZIP
 *
 */
if( isset( $zlib ) && $zlib !== 'On' && ini_get('zlib.output_compression_level') !== '1' ) :
	if ( substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') ) :
		ob_start('ob_gzhandler'); 
	endif;
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
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="language" content="<?php echo get_locale(); ?>">
	<meta name="theme-color" content="black">
    <?php if( !empty( SITE_INFO ) ) : ?>
        <meta name="copyright" content="<?php echo SITE_INFO; ?>">
    <?php endif; ?>
    <!--	Apple     -->
    <?php if( !empty( SITE_INFO ) ) : ?>
        <meta name="apple-mobile-web-app-title" content="<?php echo SITE_INFO; ?>">
    <?php endif; ?>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <!--	End Apple     -->
    <!--    Android   -->
    <?php if( !empty( SITE_INFO ) ) : ?>
        <meta name="application-name" content="<?php echo SITE_INFO; ?>">
    <?php endif; ?>
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#000000">
    <!--    End Android   -->
    <!--    Windows   -->
    <?php if( !empty( SITE_INFO ) ) : ?>
        <meta name="application-name" content="<?php echo SITE_INFO; ?>">
    <?php endif; ?>
    <meta name="msapplication-TileColor" content="#dddddd">
    <meta name="msapplication-window" content="width=1024;height=768">
    <?php if( !empty( SITE_NAME ) ) : ?>
        <meta name="msapplication-tooltip" content="<?php echo SITE_NAME; ?>">
    <?php endif; ?>
    <!--    End Windows   -->
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
	<div id="page" class="site remodal-bg">
		
		<header id="masthead" class="site-header closed">
			<div class="wrapper container">
               <div class="burger">
                   <span></span>
                   <span></span>
                   <span></span>
               </div>
                <div class="header-top col-12">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <?php if( function_exists( 'hcc_the_custom_logo' ) ) : 
                                hcc_the_custom_logo(); 
                            endif; ?>
                        </div>
                        <?php if( function_exists( 'get_field' ) ) :
                        $phones = get_field('phone_nums', 'options'); 
                        if( $phones ) : ?>
                        <div class="col-12 col-lg-6 phones d-flex align-items-start justify-content-xl-end">
                            
                            <?php $counter = 1; foreach( $phones as $phone ) : ?>
                                <?php $tel = sanitize_text_field( trim( $phone['phone_num'] ) );
                                $href = preg_replace( '~[^0-9]+~', '', $tel ); 
                                if( !empty( $tel ) ) : ?>
                                    <?php if( wp_is_mobile() && $counter === 2 ) : break; endif; ?>
                                    <a href="tel:+38<?php echo $href; ?>" class="d-flex align-items-center justify-content-start phone">
                                        <span class="icon"></span><span class="body">+38 <?php echo $tel; ?></span>
                                    </a>
                                <?php endif; 
                                if( $counter == 2 ) :
                                    break;
                                endif; ?>
                            <?php $counter++; endforeach; ?>
                
                        </div>
                        <?php endif;
                        endif; ?>
                    </div>
                </div>
				<div class="header-bottom col-12">
				    <div class="row">
				        <nav id="site-navigation" class="main-navigation col-12 col-lg-10">
                            <?php wp_nav_menu( array(
                                'theme_location'	=> 'main_menu',
                                'menu_id'			=> 'primary-menu',
                                'container'		    => '',
                                'walker'            => new HCC_Nav_Walker(),
                            ) ); ?>
                        </nav>
                        <?php if( function_exists( 'get_field' ) ) :
                        $socials = get_field('socials', 'options'); 
                        if( $socials ) : ?>
                        <div class="d-none d-xl-flex col-12 col-lg-2 socials align-items-start justify-content-end">
                            <?php foreach( $socials as $social ) : 
                                        $image = $social['icon'];
                                        $href  = esc_url( wp_kses_post( trim( $social['link'] ) ) );
                                        if( !empty( $image ) ) : ?>
                                            <a href="<?php echo ( !empty( $href )  ) ? $href : '#'; ?>" target="_blank">
                                                <img src="<?php echo esc_url( aq_resize( $image['url'], 30, 30, true, true, true) ); ?>" title="<?php echo esc_attr( $image['title'] ) ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" >
                                            </a>
                                        <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <?php endif;
                        endif; ?>
				    </div>
				</div>
		    </div>
	    </header>

	<div id="content" class="site-content">
	    <main>
            <?php if ( function_exists( 'yoast_breadcrumb' ) ) : ?>
            <div class="breadcrumbs">
                <?php yoast_breadcrumb( '<div id="breadcrumbs">', '</div>' ); ?>
            </div>
            <?php endif; ?>