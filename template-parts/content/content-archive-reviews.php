<?php
/*
 * Content single render for archive
 * 
 *
 */ 
$type = $post->type;
$type = ( empty( $type ) ) ? 'shares' : $type;

$post_id = 'post-' . $type . '-' . $post->ID;
$date    = ( $type === 'shares' ) ? get_the_date() : get_comment_date();
$cats    = ( $type === 'shares' ) ? get_the_category(',') : false;
$title   = ( $type === 'shares' ) ? wp_kses_post( get_the_title() ) : wp_kses_post( get_the_title( $post->post_ID ) );
$content = ( $type === 'shares' ) ? wp_kses_post( get_the_content() ) : wp_kses_post( get_comment_text() );
$content = apply_filters( 'the_content', wp_trim_words( $content, 200, '...') ); 

if( function_exists('hcc_getPostViews') ) {
  $views = hcc_getPostViews( get_the_ID() ); 
} 

if( $type !== 'comment' ) {
  $settings = get_field('cpt_settings', get_the_ID());
  $link     = esc_url( $settings['cpt_btn'] );
  $link     = (!empty( $link )) ? $link : '#';
  $client   = ( !empty( $settings['client_name'] ) ) ? wp_kses_post( $settings['client_name'] ) : get_the_author_meta('display_name');
  $photo    = rawurlencode( esc_url( wp_get_attachment_url( $settings['client_photo'] ) ) );
  $photo    = ( empty( $photo ) ) ? '' : $photo;
}
else {
  if( is_object( $post ) ) {
    $link     = esc_url( get_permalink( $post->post_ID ) );
    $link     = (!empty( $link )) ? $link : '#';
    $client   = apply_filters( 'comment_author', $post->post_author );
    $photo    = get_avatar( $client, 50, 'wavatar', '', array('class' => 'img-inner img-responsive') );
    $photo    = ( empty( $photo ) ) ? '' : $photo;
  }
}

?>

<article id="<?php echo $post_id; ?>" <?php post_class( array('post', $post_id, 'col-12', 'col-lg-6') ); ?>>
    <div class="row">
      <a href="<?php echo $link; ?>" class="col-12 post__data d-block">
        <?php if( !empty( $title ) ) : ?>
          <div class="w-100 post__data__title">
            <h3><?php echo $title; ?></h3>
          </div>
        <?php endif;
        if( !empty( $content ) ) : ?>
          <div class="w-100 post__data__content text-white">
            <?php echo $content; ?>
          </div>
        <?php endif;
        if( !empty( $photo ) || !empty( $client ) ) : ?>
        <div class="w-100 post__data__addons d-flex justify-content-start">
           <?php if( !empty( $photo ) ) : ?>
             <div class="post__data__addons__img">
               <?php echo $photo; ?>
             </div>
           <?php endif;
           if( !empty( $client ) ) : ?>
            <div class="post__data__addons__name text-white">
              <?php echo $client; ?>
            </div>
           <?php endif; ?>
        </div>
        <?php endif; ?>
      </a>
    </div>
</article>
  