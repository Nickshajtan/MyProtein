<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package hcc
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

get_header();
if ( have_posts() ) :

	if( get_template_part( 'template-parts/loop-'. get_post_type(), 'archive' ) === false ) :
       get_template_part( 'template-parts/loop', 'archive' );
    endif;
      
else :

	get_template_part( 'template-parts/content/content', 'none' );

endif;
get_sidebar();
get_footer();
