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

$products = get_posts( array(
  'numberposts' => 0,
  'post_type'   => 'products',
  'orderby'     => 'date',
  'order'       => 'ASC',
  'tag'         => 'shares', 'present',
) );

if( !is_null( $products ) && ( is_array( $products ) || is_object( $products ) ) ) {
  $args    = array();
  $counter = 0;
  foreach( $products as $product ){
    $args[$counter]['ID']           = $product->ID;
    $args[$counter]['post_author']  = $product->post_author;
    $args[$counter]['post_date']    = $product->post_date;
    $args[$counter]['type']         = 'share';
    $counter++;
  }
}

global $wp_query;
global $post;
$args            = array_merge( $wp_query->query, $args );
$wp_query->query = ( !is_null( $products ) && ( is_array( $products ) ) || is_object( $products ) ) 
                   ? shuffle( array_merge( $args, $products ) ) : $wp_query->query;

$tmp_post        = $post;
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

                if( get_template_part( 'template-parts/content/content-archive', get_post_type() ) === false ) {
                        get_template_part( 'template-parts/content/content-archive', 'post' );
                }

              endwhile;
              //Pagination
              get_template_part('template-parts/pagination'); ?>
          </div>
        </div>    
      <?php endif; ?>
    </div>
  </div>
</section>
<?php $post = $tmp_post; 
wp_reset_postdata(); 
wp_reset_query(); ?>