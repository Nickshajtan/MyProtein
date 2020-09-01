<?php
/*
 * Full height banner Block for Flexible content with text & button
 *
 */

$block_id_str   = str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz');
$block_title    = hcc_get_acf_header('title text-white text-center');
$block_subtitle = apply_filters( 'the_content', wp_kses_post( get_sub_field('block_subtitle', $post->ID) ) );
$block_link     = get_sub_field('button', $post->ID);
$block_image    = get_sub_field('image', $post->ID);
$block_image    = ( is_array( $block_image ) ) ? esc_url( $block_image['url'] ) : esc_url( $block_image );
$bg             = ( !wp_is_mobile() ) ? aq_resize( $block_image, 1920, 1100, true, true, true) : aq_resize( $block_image, 750, 800, true, true, true);
$image          = ( !empty( $bg ) ) ? 'style="background-image: url(' . $bg . ');"' : '';
$arrow          = ( get_sub_field('display_arrow') === 'show' ) ? true : false;
$icon_path      = '/assets/public/img/icons/proto-arrow.svg';
$icon_src       = hcc_isset_img( dirname(__FILE__), '../..', $icon_path );

if( $block_link && is_array( $block_link ) ) :
  $link_target = $block_link['target'] ? esc_attr( $block_link['target'] ) : '_self';
  $link_url    = esc_url( $block_link['url'] );
  $link_text   = wp_kses_post( $block_link['title'] );
endif;

if( ( !empty( $block_title ) && is_array( $block_title ) ) || !empty( $block_image ) ) : ?>

<section id="flex-big-banner-text-block-<?php echo $block_id_str; ?>" class="flex-banner-text-block full-height-block block-banner d-flex align-items-center" <?php echo $image; ?>>
  <div class="container">
    <div class="row d-flex align-items-center justify-content-center">
        
        <?php if( !empty( $block_title ) || !empty( $block_subtitle ) ) : ?>
        <div class="flex-banner-text-block__title full-height-block__title col-12">
          <?php echo $block_title; ?> 
          
          <?php if( !empty( $block_subtitle ) ) : ?>
          <div class="w-100 text-white text-center flex-banner-text-block__subtitle full-height-block__subtitle">
             <?php echo $block_subtitle; ?> 
          </div>
          <?php endif; ?>
          
        </div>
        <?php endif; ?>
        
        <?php if( $block_link && is_array( $block_link ) ) : ?>
        <div class="flex-banner-text-block__link d-flex justify-content-center col-12">
          <a class="button flex-banner-text-block__button" href="<?php echo $link_url; ?>" target="<?php echo $link_target; ?>">
            <?php echo $link_text; ?>
          </a>
        </div>                
        <?php endif; ?>
        
    </div>
    
    <?php if( $arrow ) : ?>
    <?php endif; ?>
  </div>
</section>

<?php endif; ?>
