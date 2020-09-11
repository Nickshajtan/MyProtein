<?php
/*
 * Content single render for archive
 * 
 *
 */ 
//var_dump( wp_get_post_terms( get_the_ID(), 'product_tag', array('names') ) );
//wp_die();

$post_id   = 'post' . get_the_ID();
$post_type = get_post_type();
$tags      = wp_get_post_terms( get_the_ID(), 'product_tag', array('names') );

$settings = get_field('cpt_settings', get_the_ID());
$type     = wp_kses_post( $settings['event_type'] );
$link     = ( !empty( $tags ) && empty( $settings['cpt_btn'] ) ) ? esc_url( get_permalink( get_the_ID() ) ) : $settings['cpt_btn'];

$date    = get_the_date();
$autor   = get_the_author_meta('display_name');
$cats    = get_the_category(','); 
$title   = wp_kses_post( get_the_title() );
$content = ( $post_type !== 'product' ) ? wp_kses_post( get_the_content() ) : '';
$content = apply_filters( 'the_content',  wp_trim_words( $content, 200, '...') );

if( !empty( $tags ) && !$settings ) {
  $text = $content;
  for ($i = 0; $i < strlen($text); $i++){
    if ($text[$i]=="." || $text[$i]=="!" || $text[$i]=="?") {
      $pretext .= $text[$i]; break;
    }
    $pretext .= $text[$i];
  }
  $content = $pretext;
}

if( !is_null( $link ) && is_array( $link ) ) {
  $link_url = ( $link ) ? esc_url( $link['url'] ) : '#';
  $link_tgt = ( $link ) ? esc_attr( $link['target'] ) : '_self';
  $link_txt = ( $link ) ? wp_kses_post( $link['title'] ) : __('Купить', 'hcc');
}
else {
  $link_url = ( $link ) ? esc_url( $link ) : '#';
  $link_tgt = '_self';
  $link_txt = __('Купить', 'hcc');
}

$time     = $settings['date_picker'];

if( is_array($tags) ) {
  foreach( $tags as $tag ) {
    $type    .= (!empty($type)) ? ' ' . wp_kses_post( $tag->name ) . ' ' : wp_kses_post( $tag->name ) . ' ';
    $content  = ( empty( $content ) ) ? wp_trim_words( wp_kses_post( $tag->description ), 200, '...' ) : $content;
  }
}

$type     = ( !empty( $type ) ) ? $type : __('Акция', 'hcc'); 

if( function_exists('hcc_getPostViews') ) {
  $views = hcc_getPostViews( get_the_ID() ); 
} 

?>

<article id="<?php echo $post_id; ?>" <?php post_class( array('post-' . $post_type, $post_id, 'col-12') ); ?>>
    <div class="row">
      <div class="col-12 post__data">
        <?php if( !empty( $type ) ) : ?>
        <div class="w-100 d-flex justify-content-start post__data__type text-white">
           <?php echo $type; ?>
        </div>
        <?php endif;
        if( !empty( $title ) ) : ?>
          <div class="w-100 post__data__title">
            <h3><?php echo $title; ?></h3>
          </div>
        <?php endif;
        if( !empty( $content ) ) : ?>
          <div class="w-100 post__data__content text-white">
            <?php echo $content; ?>
          </div>
        <?php endif;
        if( !empty( $link ) || !empty( $time ) ) : 
          $class = 'between';
          if( !empty( $link ) && !empty( $time ) ) :
            $class = 'between';
          endif;
          if( !empty( $time ) && empty( $link ) ) :
              $class = 'start';
          endif;
          if( !empty( $link ) && empty( $time ) ) : 
              $class = 'end';
          endif; ?>
        <div class="w-100 post__data__addons d-flex justify-content-<?php echo $class; ?>">
           <?php if( !empty( $time ) ) : ?>
           <date class="text-white post__data__addons__time">
             <?php echo '<b>' . __('Годен до:', 'hcc') . '</b> ' . $time; ?>
           </date>
           <?php endif;
           if( !is_null( $link ) && ( is_array( $link ) || is_string( $link ) ) ) : ?>
              <a href="<?php echo $link_url; ?>" class="button post__data__addons__link" target="<?php echo $link_tgt; ?>">
               <?php echo $link_txt; ?>
              </a>
           <?php endif; ?>
        </div>
        <?php endif; ?>
      </div>
    </div>
</article>
  