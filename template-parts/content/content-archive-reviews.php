<?php
/*
 * Content single render for archive
 * 
 *
 */ 

$type = get_post_meta( $post->ID, 'type', true );
$type = ( empty( $type ) ) ? 'reviews' : $type;

$post_id = 'post-' . $type . '-' . $post->ID;
$date    = get_the_date();
$cats    = get_the_category(',');
$title   = wp_kses_post( get_the_title() );
$content = wp_kses_post( get_the_content() );
$content = apply_filters( 'the_content', $content ); 

if( function_exists('hcc_getPostViews') ) {
  $views = hcc_getPostViews( get_the_ID() ); 
} 

if( $type !== 'comment' ) {
  $settings = get_field('cpt_settings', get_the_ID());
  $link     = esc_url( $settings['cpt_btn'] );
  $link     = ( !empty( $link ) ) ? $link : '#';
  $client   = ( !empty( $settings['client_name'] ) ) ? wp_kses_post( $settings['client_name'] ) : get_the_author_meta('display_name');
  $photo    = rawurlencode( esc_url( wp_get_attachment_url( $settings['client_photo'] ) ) );
  $photo    = ( empty( $photo ) ) ? '<img src="' . wp_normalize_path( wp_upload_dir('2020/09')['url'] . '/avatar.png' ) . '" >' : $photo;
}
else {
  if( is_object( $post ) ) {
    $link     = esc_url( get_post_meta( $post->ID, 'shop_link', true ) );
    $link     = (!empty( $link )) ? $link : '#';
    $client   = get_the_author_meta('display_name');
    $photo    = get_avatar( $client, 50, '', '', array('class' => 'img-inner img-responsive') );
    $photo    = ( empty( $photo ) ) ? '<img src="' . wp_normalize_path( wp_upload_dir('2020/09')['url'] . '/avatar.png' ) . '" >' : $photo;
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
        <div class="w-100 post__data__addons d-flex align-items-center justify-content-start">
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
  