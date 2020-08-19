<?php
/*
 * Banner block for ACF flexible
 *
 */
$block_id_str  = str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz');
$block_title   = hcc_get_acf_header('text-white text-right');
$block_content = get_sub_field('block_content', $post->ID);

?>

<section id="flex-text-block-<?php echo $block_id_str; ?>" class="flex-text-block d-flex align-items-center">
  <div class="container">
    <div class="row d-flex align-items-center justify-content-center">
        <?php echo $block_title; ?>
        <?php echo $block_content; ?>
    </div>
  </div>
</section>
