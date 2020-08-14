<?php
/*
 * Full height slider Block for Flexible content
 *
 */
$slider         = get_sub_field('slider', $post->ID);
$block_settings = get_sub_field('slider_radio', $post->ID);
$block_title    = ( $block_settings === 'no' ) ? hcc_get_acf_title(get_sub_field('text', $post->ID), 'title text-white text-center') : false;

if( ( !empty( $slider ) && is_array( $slider ) ) ) : ?>

<section id="flex-big-slider-block" class="flex-banner-text-block flex-big-slider-block full-height-block block-banner d-flex align-items-center">
  <div class="container">
    <div class="row d-flex align-items-center justify-content-center full-width-slider">
       <?php foreach( $slider as $slide ) : 
             $slide_image_arr   = $slide['image']; 
             $slide_image       = ( is_array( $slide_image_arr ) ) ? esc_url( $slide_image_arr['url'] ) : esc_url( $slide_image_arr );
             $slide_image       = ( !wp_is_mobile() ) ? aq_resize( $slide_image, 1920, 1000, true, true, true)
                                                      : aq_resize( $slide_image, 900, 700, true, true, true);
             $image_alt         = esc_attr( $slide_image_arr['alt'] );
             $image_title       = esc_attr( $slide_image_arr['title'] );
             $slide_title       = ( $block_settings === 'yes' ) ? hcc_get_acf_title($slide['text'], 'title text-white text-center') : false;
        ?>
         
          <?php if( is_array( $slide ) && !empty( $slide ) && !empty( $slide_image ) ) : ?>
          <div class="col-12 p-0 m-0 full-width-slider__slide d-flex align-items-center justify-content-center h-100">
              <?php if( !empty( $slide_title ) || !empty( $slide_title ) ) : ?>
                <div class="flex-banner-text-block__title full-height-block__title full-width-slider__slide__title w-100">
                  <?php echo $slide_title; ?>
                </div>
              <?php endif; ?>
              <img src="<?php echo $slide_image; ?>" alt="<?php echo $image_alt; ?>" title="<?php echo $image_title; ?>">
          </div>
          <?php endif; ?>
          
       <?php endforeach; ?>
       
       <?php if( $block_title && !empty($block_title) ) : ?>
          <div class="col-12 p-absolute ml-auto mr-auto">
            <?php echo $block_title; ?>
          </div>
       <?php endif; ?>
    </div>
  </div>
</section>

<?php endif; ?>
