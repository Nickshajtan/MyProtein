<?php
/*
 * Loop for archives
 *
 */
global $wp_query;
global $post;

$title      = ( is_archive() )    ? single_cat_title('', false) : single_post_title('', false);
$title      = ( empty( $title ) ) ? __('Category page', 'hcc')  : wp_kses_post( $title );
$post_type  = $wp_query->query['post_type'];
$per_option = ( get_option('post_per_page') > 1 ) ? trim( get_option('post_per_page') ) : 4;

$args = array(
  'numberposts'      => 0,
  'posts_per_page'   => $per_option,
  'paged'            => $paged,
  'post_type'        => get_post_type(),
  'orderby'          => 'date',
  'order'            => 'ASC',
  'suppress_filters' => true,
);
$posts = get_posts( $args );

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
$comments   = get_comments( $args );
unset( $args );

if( !empty( $comments ) && ( is_array( $comments ) || is_object( $comments ) ) ) {
  $args    = array();
  $counter = 0;
  foreach( $comments as $comment ){
    $args[$counter]['ID']           = $comment->comment_ID;
    $args[$counter]['post_ID']      = $comment->comment_post_ID;
    $args[$counter]['post_author']  = $comment->comment_author;
    $args[$counter]['post_date']    = $comment->comment_date;
    $args[$counter]['post_content'] = wp_kses_post( strip_tags( $comment->comment_content ) );
    $args[$counter]['post_title']   = wp_kses_post( strip_tags( $comment->comment_title ) );
    $args[$counter]['type']         = 'comment';
    $counter++;
  }
} 

if( !empty($args) && ( is_array($args) || is_object($args) ) ) {
  $posts = array_merge( $posts, $args );
  asort($posts);
}

?>

<section class="cat-page">
  <div class="container">
    <div class="row">
      <?php if ( false && !empty( $title ) ) : ?>
          <div class="col-12 cat-page__title">
            <?php echo '<h1 class="title text-left">' . $title . '</h1>'; ?>
          </div>
      <?php endif;
      if( !empty( $posts ) && ( is_array( $posts ) || is_object( $posts ) ) ) : ?>
        <div class="col-12 cat-page__list">
         <div class="row">
            <?php foreach( $posts as $post ) :
	              setup_postdata($post);
                  $post = (object) $post;
  
                  if( get_template_part( 'template-parts/content/content-archive', $post_type ) === false ) {
                          get_template_part( 'template-parts/content/content-archive', 'post' );
                  }
           
            endforeach;
            //Pagination
            get_template_part('template-parts/pagination');?>
         </div>
        </div>   
      <?php else :
            get_template_part( 'template-parts/content/content', 'none' );  
      endif; ?>
    </div>
  </div>
</section>
<?php wp_reset_postdata(); ?>
