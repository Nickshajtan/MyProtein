<?php
/*
 * Text Block for Flexible content with image & button
 *
 */

$block_title   = hcc_get_acf_header('title text-white text-left');
$block_content = get_sub_field('block_content', $post->ID);
$image_arr     = get_sub_field('image', $post->ID);
$block_image   = ( is_array( $image_arr ) ) ? esc_url( $image_arr['url'] ) : esc_url( $image_arr );
$block_image   = aq_resize( $block_image, 680, 500, true, true, true);
$block_link    = get_sub_field('button', $post->ID);

if( $block_link && is_array( $block_link ) ) :
  $link_target = $block_link['target'] ? esc_attr( $block_link['target'] ) : '_self';
  $link_url    = esc_url( $block_link['url'] );
  $link_text   = wp_kses_post( $block_link['title'] );
endif;

if( !empty( $block_image ) || !empty( $block_title ) || !empty( $block_content ) ) : ?>

<section id="flex-text-image-block" class="flex-text-image-block d-flex flex-column flex-lg-row align-items-center">
  <div class="container">
    <div class="row d-flex align-items-center justify-content-start order-1">
        <div class="col-12 col-lg-7 flex-text-image-block__section">
          <?php if( !empty( $block_title ) ) : ?>
          <div class="w-100 flex-text-image-block__title">
            <?php echo $block_title; ?>
          </div>
          <?php endif;
          if( !empty( $block_content ) ) : ?>
          <div class="w-100 flex-text-image-block__content">
            <?php echo $block_content; ?>
          </div>
          <?php endif;
          if( $block_link && is_array( $block_link ) ) : ?>
           <div class="flex-text-image-block__link d-flex justify-content-start w-100">
            <a class="button flex-text-image-block__button" href="<?php echo $link_url; ?>" target="<?php echo $link_target; ?>">
              <?php echo $link_text; ?>
            </a>
           </div>
          <?php endif; ?>
        </div>
    </div>
  </div>
  <?php if( $block_image ) : ?>
        <div class="col-12 col-lg-5 p-0 flex-text-image-block__img-wrapper d-none">
          <img src="<?php echo $block_image; ?>" alt="<?php echo esc_attr( $image_arr['alt'] ); ?>" title="<?php echo esc_attr( $image_arr['title'] ); ?>" class="img-inner img-responsive">
        </div>
  <?php endif; ?>
</section>

<?php endif; ?>
