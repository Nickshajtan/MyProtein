<?php

$block_id_str  = str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz');
$block_title   = hcc_get_acf_header('text-white text-left title');
$shortcode     = trim( get_sub_field('shortcode') );

var_dump( $shortcode );

?>

<section id="flex-text-block-<?php echo $block_id_str; ?>" class="flex-text-block d-flex align-items-center">
  <div class="container">
    <div class="row d-flex align-items-center justify-content-start">
        <?php echo $block_title; 
            if( function_exists('apply_shortcode') ) {
              apply_shortcode( $shortcode );
            }
            else {
              do_shortcode( $shortcode );
            }
        ?>
    </div>
  </div>
</section>
