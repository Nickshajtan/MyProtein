<?php

$block_title   = hcc_get_acf_header('text-white text-right');
$block_content = get_sub_field('block_content', $post->ID);

?>

<section id="flex-text-block" class="flex-text-block d-flex align-items-center">
  <div class="container">
    <div class="row d-flex align-items-center justify-content-center">
        <?php echo $block_title; ?>
        <?php echo $block_content; ?>
    </div>
  </div>
</section>
