<?php
 /*
  * Template name: Home page
  * 
  */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
get_header();
global $post;

if(have_posts()) : while(have_posts()) : the_post();
         
          $content = get_the_content();
          $content = apply_filters( 'the_content', $content );
          $post_id = get_the_ID();

          $flex = get_field('flexible_content', $post_id);

          if ( !empty( $content ) || ( $flex && is_array( $flex ) ) ) : ?>
          <div <?php body_class("d-flex align-items-center justify-content-center flex-column"); ?>>

                  <?php echo $content;
            
            if( $flex && !is_null( $flex ) && is_array( $flex ) || have_rows( 'flexible_content', $post_id ) ) :
                 while (has_sub_field('flexible_content', $post_id)) :
                                   $row_layout_slug = get_row_layout();
                                   get_template_part('template-parts/flexible/block', $row_layout_slug);
                 endwhile;
            endif; ?>
          </div>
          <?php else : 
                get_template_part('template-parts/content/content', 'none');
          endif;

endwhile; endif; 
get_footer(); ?>