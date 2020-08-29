<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package hcc
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
// set post views
if( function_exists('hcc_setPostViews') ){
    hcc_setPostViews($post->ID);   
}
get_header();
?>
<section class="single-page">
      <?php
      while ( have_posts() ) :
          the_post();
          get_template_part('template-parts/content/content', 'single');
      endwhile; 
      ?>
</section>
<?php
get_sidebar();
get_footer();
