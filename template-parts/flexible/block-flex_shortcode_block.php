<?php

$block_id_str  = str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz');
$block_title   = hcc_get_acf_header('text-white text-left title');
$shortcode     = trim( get_sub_field('shortcode') );

?>

<section id="flex-shortcodes-block-<?php echo $block_id_str; ?>" class="flex-shortcodes-block d-flex align-items-center">
  <div class="container">
    <div class="row d-flex align-items-center justify-content-center">
       <div class="col-12">
         <?php if( !empty( $block_title ) ) : ?>
         <div class="flex-shortcodes-block__title">
           <?php echo $block_title; ?>
         </div>
         <?php endif;

          if( function_exists('apply_shortcode') ) {
                echo apply_shortcodes( $shortcode );
          }
          else {
                echo do_shortcode( $shortcode );
          } ?>
       </div>
    </div>
  </div>
</section>
