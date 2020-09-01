<?php
/*
 * Loop for archives
 *
 */

$title      = ( is_archive() )    ? single_cat_title('', false) : single_post_title('', false);
$title      = ( empty( $title ) ) ? __('Category page', 'hcc')  : wp_kses_post( $title );

$args = array(
  'number'       => '',
  'orderby'      => 'comment_date',
  'order'        => 'DESC',
  'status'       => 'approve',
  'type'         => 'comment',
  'post_type'    => 'product',
  'count'        => false,
  'fields'       => '',
  'hierarchical' => false, 
);
$comments = get_comments( $args );

if( !is_null( $comments ) && ( is_array( $comments ) || is_object( $comments ) ) ) {
  $args    = array();
  $counter = 0;
  foreach( $comments as $comment ){
    $args[$counter]['ID']           = $comment->comment_ID;
    $args[$counter]['post_author']  = $comment->comment_author;
    $args[$counter]['post_date']    = $comment->comment_date;
    $args[$counter]['post_content'] = wp_kses_post( strip_tags( $comment->comment_content ) );
    $args[$counter]['post_title']   = wp_kses_post( strip_tags( $comment->comment_title ) );
    $counter++;
  }

  if( !is_null( $args ) && ( is_array( $args ) || is_object( $args ) ) ) {
    global $wp_query; 
    $wp_query->query = shuffle( array_merge( $wp_query->query, $args ) ); 
  }
} ?>

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
