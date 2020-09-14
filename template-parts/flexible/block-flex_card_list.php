<?php
/*
 * Card list Block for Flexible content with text & link
 *
 */
$block_id_str  = str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz');
$block_content = get_sub_field('card_list', $post->ID);
$count         = (int) count( $block_content );

if( $count % 3 == 0 ) :
  $class = 3;
elseif( $count % 2 == 0 ) :
  $class = 2;
else :
  $class = 1;
endif;

if( !empty( $block_content ) && is_array( $block_content ) ) : ?>

<section id="flex-card-list-<?php echo $block_id_str; ?>" class="flex-card-list d-grid grid-column-<?php echo $class; ?> p-0">

  <?php foreach( $block_content as $card ) : 
          $card_title       = hcc_get_acf_title( $card, 'text-center' );
          $card_text        = apply_filters( 'the_content', wp_kses_post( $card['block_content'] ) );
          $card_text_hover  = apply_filters( 'the_content', wp_kses_post( $card['block_content_hover'] ) );
          $card_link        = ( !empty( $card['link'] ) && is_string( $card['link'] ) ) ? esc_url( trim( $card['link'] ) ) : '#';
          $card_target      = ( $card['link_target'] === 'yes' ) ? 'target="_blank"' : 'target="_self"';
          $card_image       = $card['image'];
          $card_image       = ( is_array( $card_image ) ) ? esc_url( $card_image['url'] ) : esc_url( $card_image );
          $card_image_alt   = ( is_array( $card_image ) ) ? esc_attr( $card_image['alt'] ) : '';
          $card_image_title = ( is_array( $card_image ) ) ? esc_attr( $card_image['title'] ) : '';;
          $card_bg          = aq_resize( $card_image, 480, 400, true, true, true);
  ?>
  
      <a href="<?php echo $card_link; ?>" <?php echo $card_target; ?> class="d-block flex-card-list__card w-100 p-0">
        <?php if( !empty( $card_bg ) ) : ?>
          <div class="flex-card-list__card__img-line-wrapper"></div>
          <img src="<?php echo $card_bg; ?>" alt="<?php echo $card_image_alt; ?>" title="<?php echo $card_image_title; ?>" class="flex-card-list__card__img">
        <?php endif;
        if( !empty( $card_title ) ) : ?>
          <div class="flex-card-list__card__title">
            <?php echo $card_title; ?>
          </div>
        <?php endif;
        if( !empty( $card_text ) ) : ?>
          <div class="flex-card-list__card__text">
            <?php echo $card_text; ?>
          </div>
        <?php endif; 
        if( !empty( $card_text_hover ) ) : ?>
          <div class="flex-card-list__card__text_hover">
            <?php echo $card_text_hover; ?>
          </div>
        <?php endif; ?>
      </a>
  
  <?php endforeach; ?>

</section>

<?php endif; ?>
