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

$per_page   = get_option('posts_per_page');
$per_option = ( $per_page > 4 && $per_page % 2 === 0 ) ? absint( $per_page/ 2 ) : 3;

if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
} 
elseif ( get_query_var('page') ) {  
    $paged = get_query_var('page');
} 
else {
    $paged = 1;
}

$param      = array(
  'numberposts'      => 0,
  'posts_per_page'   => $per_option,
  'paged'            => $paged,
  'post_type'        => array( get_post_type() ),
  'orderby'          => 'date',
  'order'            => 'DESC',
);

$tmp_post   = $post;
$param      = array_merge( $wp_query->query, $param );
$wp_query   = new WP_Query( $param );

get_header();

if ( have_posts() ) :

	if( get_template_part( 'template-parts/loop-'. get_post_type() . '-archive' ) === false ) {
       get_template_part( 'template-parts/loop', 'archive' );
    }

    $title = '<b class="title text-white">' . '<span>' . __('Нужна помощь?', 'hcc') . '</span><br />' . __('Заполните форму и мы свяжемся с вами', 'hcc') . '</b>';

	@include( 'template-parts/form-custom-section.php' );


else :

	get_template_part( 'template-parts/content/content', 'none' );

endif; 
wp_reset_query();
$post = $tmp_post;
get_sidebar();
get_footer();
