<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package hcc
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
get_header();
if( have_posts() ) : 
    while ( have_posts() ) :
        the_post(); ?>
        <section class="container-fluid site-container page-wrap">
              <div class="row-fluid">
                <div class="col-12 page-wrap__content">
                  <?php the_content(); ?>
                </div>
              </div>
        </section>
    <?php endwhile;
else :
    get_template_part( 'template-parts/content/content', 'none' );
endif; 
get_footer();
