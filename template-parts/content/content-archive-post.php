<?php
/*
 * Content single render for archive
 * 
 *
 */ 

$post_id = 'post' . get_the_ID();
$date    = get_the_date();
$autor   = get_the_author_meta('display_name');
$cats    = get_the_category(',');
$title   = wp_kses_post( get_the_title() );
$content = wp_kses_post( get_the_content() );
$content = apply_filters( 'the_content', wp_trim_words( $content, 50, '...') ); 

if( function_exists('hcc_getPostViews') ) {
  $views = hcc_getPostViews( get_the_ID() ); 
} 
?>

<article id="<?php echo $post_id; ?>" <?php post_class( array('post', $post_id, 'col-12' ) ); ?>>
    <div class="row">
      <div class="col-12 post__data">
        <?php if( has_post_thumbnail() && strpos( get_the_post_thumbnail_url(), 'wp-header-logo' ) === false ) : ?>
            <div class="w-100 post__data__img"><?php the_post_thumbnail(); ?></div>
        <?php endif;
        if( !empty( $date ) ) : ?>
          <div class="w-100 post__data__date">
            <p class="text-white">Published: <date><em><?php echo $date; ?></em></date></p>
          </div>
        <?php endif;
        if( $autor ) : ?>
          <div class="w-100 post__data__autor">
            <p class="text-white">Author: <em><?php echo $autor; ?></em></p>
          </div>
        <?php endif;
        if( !empty( $views ) ) : ?>
          <div class="w-100 post__data__views">
            <p class="text-white">Views: <em><?php echo $views; ?></em></p>
          </div>
        <?php endif; 
        if( !is_null( $cats ) && is_array( $cats ) ) : ?>
          <div class="w-100 post__data__categories-list">
            <div class="d-inline">
              <p class="text-white">Category:</p> 
              <ul>
                <?php foreach( $cats as $cat ) : 
                  echo '<li class="text-white">' . $cat . '</li>'; 
                endforeach; ?>
              </ul>
            </div>
          </div>
        <?php endif; 
        if( !empty( $title ) ) : ?>
          <div class="w-100 post__data__title">
            <h3 class="text-white"><?php echo $title; ?></h3>
          </div>
        <?php endif;
        if( !empty( $content ) ) : ?>
          <div class="w-100 post__data__content text-white">
            <?php echo $content; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
</article>
  