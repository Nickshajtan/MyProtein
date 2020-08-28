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
  
	get_template_part( 'template-parts/loop', 'archive' );

    $title = '<b class="title text-white">' . '<span>' . __('Нужна помощь?', 'hcc') . '</span><br />' . __('Заполните форму и мы свяжемся с вами', 'hcc') . '</b>';

	@include( 'template-parts/form-custom-section.php' );


else :

	get_template_part( 'template-parts/content/content', 'none' );

endif;
get_sidebar();
get_footer();