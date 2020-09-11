<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package hcc
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

global $wp_query;
global $post;

$param      = array(
  'numberposts'      => 0,
  'orderby'          => 'date',
  'order'            => 'DESC',
);

$param             = array_merge( $wp_query->query, $param );
$tmp_post          = $post;
$query = query_posts($param);

get_header();
if ( have_posts() ) :
  
	if( get_template_part( 'template-parts/loop-'. get_post_type(), 'archive' ) === false ) {
       get_template_part( 'template-parts/loop', 'archive' );
    }

    $title = '<b class="title text-white">' . '<span>' .  __('Хотите оставить свой отзыв?', 'hcc') . '</span><br />' . '</b>';

	@include( 'template-parts/form-custom-reviews_section.php' );

else :

	get_template_part( 'template-parts/content/content', 'none' );

endif;
wp_reset_postdata(); 
wp_reset_query();
$post = $tmp_post;
get_sidebar();
get_footer();
