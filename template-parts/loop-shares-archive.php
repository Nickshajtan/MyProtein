<?php
/*
 * Loop for archives
 *
 */

$title      = ( is_archive() )    ? single_cat_title('', false) : single_post_title('', false);
$title      = ( empty( $title ) ) ? __('Category page', 'hcc')  : wp_kses_post( $title ); 
$per_option = ( get_option('post_per_page') >= 3 ) ? (int) ceil( get_option('post_per_page')/ 2 ) : 3; 

if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
} 
elseif ( get_query_var('page') ) {  
    $paged = get_query_var('page');
} 
else {
    $paged = 1;
}

$args = array(
                'numberposts'      => 0,
                'posts_per_page'   => $per_option,
                'paged'            => $paged,
                'post_type'        => get_post_type(),
                'orderby'          => 'status',
                'order'            => 'ASC',
                'suppress_filters' => true,
);
global $post;
$tmp_post = $post;
query_posts( $args ); ?>

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
                global $post;

                if( get_template_part( 'template-parts/content/content-archive', get_post_type() ) === false ) {
                        get_template_part( 'template-parts/content/content-archive', 'post' );
                }


              endwhile; ?>
          </div>
        </div>

        <div class="pagination cat-page__pagination col-12">
             <div class="row">
               <?php if( function_exists('hcc_pagination_bar') ) :
                  echo hcc_pagination_bar($wp_query);
               elseif( function_exists('the_posts_pagination') ) :
                  get_template_part('template-parts/pagination');
               endif; ?>
             </div>
        </div>      
      <?php endif; ?>
    </div>
  </div>
</section>
<?php $post = $tmp_post; ?>