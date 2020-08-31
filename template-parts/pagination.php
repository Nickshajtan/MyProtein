<?php
/*
 * Site Pagination
 *
 *
 */

$args = array(
  'end_size'           => 1,
  'mid_size'           => 1,
  'prev_next'          => true,
  'prev_text'          => '&#8592',
  'next_text'          => '&#8594',
);
$pagination = get_the_posts_pagination( $args );
if( $pagination ) : ?>
    <div class="col-12 d-flex justify-content-end"><?php echo $pagination; ?></div>
<?php endif; ?>
      