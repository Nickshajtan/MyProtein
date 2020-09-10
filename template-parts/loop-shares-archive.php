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

$param = array(
  'numberposts'      => 0,
  'posts_per_page'   => $per_option,
  'paged'            => $paged,
  'post_type'        => array( get_post_type(), 'product' ),
  'orderby'          => 'rand',
  'order'            => 'ASC',
  'suppress_filters' => true,
  'tax_query' => array(
		array(
			'taxonomy'         => 'product_tag',
			'field'            => 'slug',
			'terms'            => array( 'shares', 'present', ),
            'operator'         => 'IN',
            'include_children' => false,
		)
	)
);

//var_dump( get_posts( $param ) );
//wp_die();

global $wp_query;
global $post;
$param             = array_merge( $wp_query->query, $param );
$tmp_post          = $post;
$query = query_posts( $param ); ?>

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
                if( get_template_part( 'template-parts/content/content-archive', $post_type ) === false ) {
                        get_template_part( 'template-parts/content/content-archive', 'post' );
                }

              endwhile;
              //Pagination
              get_template_part('template-parts/pagination'); ?>
          </div>
        </div>    
      <?php else :
            get_template_part( 'template-parts/content/content', 'none' );
      endif; ?>
    </div>
  </div>
</section>
<?php $post = $tmp_post; 
wp_reset_postdata(); 
wp_reset_query();
unset( $query ); ?>