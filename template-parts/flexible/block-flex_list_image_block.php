<?php
/*
 * Text Block for Flexible content with image, button & list
 *
 */
$block_title   = hcc_get_acf_header('text-white text-left title');
$block_content = get_sub_field('block_content', $post->ID);
$image_arr     = get_sub_field('image', $post->ID);
$block_image   = ( is_array( $image_arr ) ) ? esc_url( $image_arr['url'] ) : esc_url( $image_arr );
$block_image   = aq_resize( $block_image, 780, 950, true, true, true);
$image_alt     = esc_attr( $image_arr['alt'] );
$image_title   = esc_attr( $image_arr['title'] );
$block_link    = get_sub_field('button', $post->ID);

if( $block_link && is_array( $block_link ) ) :
  $link_target = $block_link['target'] ? esc_attr( $block_link['target'] ) : '_self';
  $link_url    = esc_url( $block_link['url'] );
  $link_text   = wp_kses_post( $block_link['title'] );
endif;

// block settings
$display = get_sub_field('display', $post->ID);
$sizing  = get_sub_field('sizing', $post->ID);

switch( $display ) :
  case $display == 'text_left' :
    $margin     = 'mr-auto';
    $img_float  = 'right';
    $text_float = 'start';
    break;
  case $display == 'text_right':
    $margin     = 'ml-auto';
    $img_float  = 'left';
    $text_float = 'end';
    break;
  default:
    $margin     = 'mr-auto';
    $img_float  = 'right';
    $text_float = 'start';
    break;
endswitch;

if( $sizing === 'yes' && !wp_is_mobile() ) :
  $img_lg_class     = ( empty( $block_title ) || empty( $block_content ) ) ? 12 : 7;
  $img_lg_mode      = ( empty( $block_title ) || empty( $block_content ) ) ? 'full_width' : '';            
  $content_lg_class = ( !$block_image || empty( $block_image ) || is_null( $block_image ) ) ? 12 : 5;
  $content_lg_mode  = ( !$block_image || empty( $block_image ) || is_null( $block_image ) ) ? 'full_width' : '';
else :
  $img_lg_class     = 7;
  $img_lg_mode      = '';            
  $content_lg_class = 5;
  $content_lg_mode  = '';
endif;

if( !empty( $block_image ) || !empty( $block_title ) || !empty( $block_content ) ) : ?>

<section id="flex-text-image-block" class="flex-text-image-block flex-list-image-block d-flex flex-column flex-lg-row align-items-center">
  <div class="container-fluid">
    <?php if( !empty( $block_title ) ) : ?>
      <div class="row-fluid">
          <div class="col-12 col-lg-9 flex-text-image-block__section__title flex-list-image-block__section__title <?php echo $margin . ' ' . $content_lg_mode; ?>">
              <?php echo $block_title; ?>
          </div>
      </div>
    <?php endif; ?>
    <div class="row d-flex align-items-center justify-content-<?php echo $text_float; ?>">
        <?php if( ( $block_link && is_array( $block_link ) ) || !empty( $block_content ) ) : ?>
          <div class="col-12 col-lg-<?php echo $content_lg_class; ?> flex-list-image-block__section flex-text-image-block__section p-relative">
            <?php if( !empty( $block_content ) ) : ?>
            <div class="w-100 flex-text-image-block__section__content flex-list-image-block__section__content <?php echo $margin . ' ' . $content_lg_mode; ?>">
              <?php echo $block_content; ?>
            </div>
            <?php endif;
            if( $block_link && is_array( $block_link ) ) : ?>
             <div class="flex-text-image-block__section__link flex-list-image-block__section__link d-flex justify-content-start w-100">
              <a class="button flex-text-image-block__section__button <?php echo $margin; ?>" href="<?php echo $link_url; ?>" target="<?php echo $link_target; ?>">
                <?php echo $link_text; ?>
              </a>
             </div>
            <?php endif; ?>
        </div>
        <?php endif;
        if( $block_image ) : ?>
        <div class="col-12 col-lg-<?php echo $img_lg_class; ?> p-0 h-100 flex-text-image-block__img-wrapper flex-list-image-block__img-wrapper block_position_<?php echo $img_float . ' ' . $img_lg_mode; ?> d-none d-lg-block p-absolute">
          <img src="<?php echo $block_image; ?>" alt="<?php echo $image_alt; ?>" title="<?php echo $image_title; ?>" class="img-inner img-responsive">
        </div>
        <?php endif; ?>
        
    </div>
  </div>
</section>

<?php endif; ?>
