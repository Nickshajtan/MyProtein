<?php
/**
 * The template for displaying 403 pages
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hcc
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

get_header();
$your_query = new WP_Query( 'pagename=error-403' );
if( $your_query->have_posts() ) : 
    while ( $your_query->have_posts() ) : $your_query->the_post(); 
        $title = get_the_title();
        $content = get_the_content();
    ?>    
    <div <?php body_class("error-page error_403 d-flex align-items-center justify-content-center"); ?> >
        <section <?php body_class("error-page__section"); ?>>
            <div class="container">
                <div class="row d-flex align-items-center justify-content-center">
                   <?php if( $title && $title_visibility === 'show' ) : ?>
                    <div class="col-12 justify-content-start align-items-center d-flex">
                        <div class="error-page__section__title-wrapper">
                           <h1 class="error-page__section__title text-left"><?php echo $title; ?></h1>  
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if( has_post_thumbnail() && strpos( get_the_post_thumbnail_url(), 'wp-header-logo' ) === false ) : ?>
                        <div class="col-12 error-page__section__thumbnail-wrapper">
                            <?php the_post_thumbnail('full', array( "class" => "img-inner img-responsive " . get_post_type() . "-image") ); ?>
                        </div>
                    <?php endif; ?>
                    <div class="col-12 error-page__section__content-wrapper">
                        <div class="error-page__section__content text-white text-center">
                          <?php echo ( $content ) ? $content : __('Упс, такой страницы не существует!', 'hcc'); ?>
                        </div>
                        <?php if( $home_btn_visibility === 'show' || $back_btn_visibility === 'show' ) : ?>
                        <div class="w-100 link-wrapper justify-content-between align-items-center d-flex">
                            <?php if( $home_btn_visibility === 'show' ) : ?>
                              <a href="<?php echo ( THEME_HOME_URL ) ? THEME_HOME_URL : get_home_url('/'); ?>" class="button">
                                <?php echo __('На главную','hcc'); ?>
                              </a>
                            <?php endif;
                            if( $back_btn_visibility === 'show' ) : ?>
                              <a href="#" class="button" onclick="history.back();return false;">
                                <?php echo __('Назад','hcc'); ?>
                              </a>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>  
    </div>  
    <?php endwhile; 
wp_reset_postdata();
endif;    
get_footer(); ?>
