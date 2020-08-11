<?php
/*
 * Text Block for Flexible content. Including WP editor with styles
 *
 */

$block_title   = hcc_get_acf_header('title text-white text-left');
$block_content = wp_kses_post( get_sub_field('block_content', $post->ID) );

if( ( !empty( $block_title ) && is_array( $block_title ) ) || !empty( $block_content ) ) : ?>

<section id="flex-text-block" class="flexible-content flex-text-block d-flex align-items-center">
  <div class="container">
    <div class="row d-flex align-items-center justify-content-start">
        
        <?php if( !empty( $block_title ) ) : ?>
          <div class="flex-text-block__title col-12 text-left">
            <?php echo $block_title; ?>
          </div>
        <?php endif; ?>
        
        <?php if( !empty( $block_content ) ) : ?>
          <div class="flex-text-block__content col-12 text-left">
            <?php echo $block_content; ?>  
          </div>
        <?php endif; ?>
        
    </div>
  </div>
</section>

<?php endif; ?>
