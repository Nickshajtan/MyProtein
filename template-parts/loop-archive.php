<?php
/*
 * Loop for archives
 *
 */

$title      = ( is_archive() )    ? single_cat_title('', false) : single_post_title('', false);
$title      = ( empty( $title ) ) ? __('Category page', 'hcc')  : wp_kses_post( $title );  ?>

<section class="cat-page">
  <div class="container">
    <div class="row">
      <?php if ( false && !empty( $title ) ) : ?>
          <div class="col-12 cat-page__title">
            <?php echo '<h1 class="title text-left">' . $title . '</h1>'; ?>
          </div>
      <?php endif;
      
      if( have_posts() ) : ?>
        <div class="col-12 cat-page__list">
         <div class="row">
            <?php while ( have_posts() ) :
              the_post();

              if( get_template_part( 'template-parts/content/content-archive', get_post_type() ) === false ) {
                      get_template_part( 'template-parts/content/content-archive', 'post' );
              }


            endwhile;
            //Pagination
            get_template_part('template-parts/pagination');?>
         </div>
        </div>     
      <?php endif; ?>
    </div>
  </div>
</section>
