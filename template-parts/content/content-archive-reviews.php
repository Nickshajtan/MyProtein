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
$content = wp_trim_words( $content, 200, '...'); 

if( function_exists('hcc_getPostViews') ) {
  $views = hcc_getPostViews( get_the_ID() ); 
} 

$settings = get_field('cpt_settings', get_the_ID());
$type     = wp_kses_post( $settings['event_type'] ); 
$link     = esc_url( $settings['cpt_btn'] );
$client   = $settings['client_name'];
$photo    = rawurlencode( esc_url( wp_get_attachment_url( $settings['client_photo'] ) ) );
$photo    = ( empty( $photo ) ) ? '' : $photo;

?>

<article id="<?php echo $post_id; ?>" <?php post_class( array('post', $post_id, 'col-12', 'col-lg-6') ); ?>>
    <div class="row">
      <div class="col-12 post__data">
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
      </div>
    </div>
</article>
  