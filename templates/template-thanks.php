<?php
/**
 * Template name: Thank you
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
get_header();
if( have_posts() ) : 
    while ( have_posts() ) :
        the_post();
        $content = get_the_content();
        $title   = wp_kses_post( get_the_title() );
        $content = wp_kses_post( apply_filters( 'the_content', $content ) );
        $link    = get_field('link', get_the_ID() );

        if( $link && is_array( $link ) ) : 
          $link_target = $link['target'] ? esc_attr( $link['target'] ) : '_self';
          $link_url    = esc_url( $link['url'] );
          $link_text   = wp_kses_post( $link['title'] );
        endif; ?>
          
          <div class="thanks-page d-flex align-items-center justify-content-center">
            <section class=" thanks-page__section">
              <?php if ( $content ) : ?>
                <div class="container">
                  <div class="row">
                    <div class="col-12 d-flex align-items-center justify-content-center flex-column thanks-page__content-wrapper">
                      <h1 class="text-white page-title thanks-page__title"><?php echo $title; ?></h1>
                      <div class="thanks-page__content"><?php echo $content; ?></div>
                      <?php if( $link && is_array( $link ) ) : ?>
                        <a class="button thanks-page__button" href="<?php echo $link_url; ?>" target="<?php echo $link_target; ?>"><?php echo $link_text; ?></a>
                      <?php endif; ?>
                    </div>
                    <?php if( has_post_thumbnail() && strpos( get_the_post_thumbnail_url(), 'wp-header-logo' ) === false ) : ?>
                          <div class="col-12 thanks-page__thumbnail-wrapper">
                              <?php the_post_thumbnail('full', array( "class" => "img-inner img-responsive thanks-page-image " . get_post_type() . "-image") ); ?>
                          </div>
                    <?php endif; ?>
                  </div>
                </div>
              <?php else : 
                    get_template_part('template-parts/content', 'none');
              endif; ?>
            </section>    
          </div>
        
    <?php endwhile; 
endif; 
get_footer();
