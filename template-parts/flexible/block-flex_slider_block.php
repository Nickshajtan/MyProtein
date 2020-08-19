<?php
/*
 * Slider Block for Flexible content
 *
 */
$block_id_str   = str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz');
$slider         = get_sub_field('slider', $post->ID);
$block_settings = get_sub_field('slider_radio', $post->ID);
$block_title    = ( $block_settings === 'no' ) ? hcc_get_acf_title(get_sub_field('text', $post->ID), 'title text-white text-left') : false;

if( ( !empty( $slider ) && is_array( $slider ) ) ) : ?>

<section id="flex-slider-block-<?php echo $block_id_str; ?>" class="flex-slider-block d-flex align-items-center">
  <div class="container-fluid flex-slider-block__slider slider-block pl-0 pr-0">
      <div class="row-fluid slick-slider">
       <?php foreach( $slider as $slide ) : 
             $slide_image_arr   = $slide['image']; 
             $slide_image       = ( is_array( $slide_image_arr ) ) ? esc_url( $slide_image_arr['url'] ) : esc_url( $slide_image_arr );
             $slide_image       = ( !wp_is_mobile() ) ? aq_resize( $slide_image, 1920, 1400, true, true, true)
                                                      : aq_resize( $slide_image, 900, 700, true, true, true);
             $image_alt         = esc_attr( $slide_image_arr['alt'] );
             $image_title       = esc_attr( $slide_image_arr['title'] );
             $slide_title       = ( $block_settings === 'yes' ) ? hcc_get_acf_title($slide['text'], 'title text-white text-center') : false;
        ?>
        
          <?php if( is_array( $slide ) && !empty( $slide ) && !empty( $slide_image ) ) : ?>
           <div class="col-12 d-flex align-items-center justify-content-start slider-block__slide pl-0 pr-0">
               <div class="row">
                 <?php if( !empty( $slide_title ) || !empty( $slide_title ) ) : ?>
                 <div class="container col-12 col-lg-9 slider-block__slide__title">
                    <?php echo $slide_title; ?>
                 </div>
                 <?php endif; ?>
                 <div class="col-12 col-lg-8 p-absolute slider-block__slide__image">
                    <img src="<?php echo $slide_image; ?>" alt="<?php echo $image_alt; ?>" title="<?php echo $image_title; ?>">
                 </div>
               </div>
           </div>
          <?php endif; ?>
          
       <?php endforeach; ?>
       </div>
       
       <?php if( $block_title && !empty($block_title) ) : ?>
          <div class="container p-absolute ml-auto mr-auto flex-slider-block__slider__title">
              <?php echo $block_title; ?>
          </div>
       <?php endif; ?>
       <div class="flex-slider-block__slider__arrows-container slider-navigation p-absolute w-100"></div>
  </div>
</section>

<?php endif; ?>
