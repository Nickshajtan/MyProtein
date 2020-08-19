<?php
/*
 * Chess images Block for Flexible content with information
 *
 */

$block_id_str  = str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz');
// block content
$first_row  = get_sub_field('first_row', $post->ID);
$second_row = get_sub_field('second_row', $post->ID);

$block_title   = hcc_get_acf_title( $first_row, 'title text-white text-left' );
$block_im_arr  = $first_row['image_first'];
$first_image   = ( is_array( $block_im_arr ) ) ? esc_url( $block_im_arr['url'] ) : esc_url( $block_im_arr );
$first_image   = aq_resize( $first_image, 780, 900, true, true, true);
$first_alt     = esc_attr( $block_im_arr['alt'] );
$first_title   = esc_attr( $block_im_arr['title'] );

$block_im_arr   = $second_row['image_sec'];
$second_image   = ( is_array( $block_im_arr ) ) ? esc_url( $block_im_arr['url'] ) : esc_url( $block_im_arr );
$second_image   = aq_resize( $second_image, 890, 870, true, true, true);
$second_alt     = esc_attr( $block_im_arr['alt'] );
$second_title   = esc_attr( $block_im_arr['title'] );
$second_content = wp_kses_post(   $second_row['data']['block_content'] );
$work_time      = $second_row['data']['work_time'];
$addresses      = $second_row['data']['addresses'];
$emails         = $second_row['data']['emails'];
$phone_nums     = $second_row['data']['phone_nums'];

// block settings
$display = get_sub_field('display', $post->ID);
$sizing  = get_sub_field('sizing', $post->ID);

switch( $display ) :
  case $display == 'text_left' :
    $img_first_float   = 'right';
    $img_second_float  = 'left';
    $text_first_float  = 'start';
    $text_second_float = 'end';

    break;
  case $display == 'text_right':
    $img_first_float   = 'left';
    $img_second_float  = 'right';
    $text_first_float  = 'end';
    $text_second_float = 'start';
    break;
  default:
    $img_first_float   = 'right';
    $img_second_float  = 'left';
    $text_first_float  = 'start';
    $text_second_float = 'end';
    break;
endswitch;

if( $sizing === 'yes' && !wp_is_mobile() ) :
  $img_first_lg_class      = ( empty( $block_title ) ) ? 12 : 7;
  $img_first_lg_mode       = ( empty( $block_title ) ) ? 'full_width' : ''; 
  $img_second_lg_class     = ( is_null( $second_row['data'] ) || empty( $second_row['data'] ) ) ? 12 : 7;
  $img_second_lg_mode      = ( is_null( $second_row['data'] ) || empty( $second_row['data'] ) ) ? 'full_width' : '';
  $title_lg_class          = ( !$first_image || empty( $first_image ) || is_null( $first_image ) ) ? 12 : 8;
  $title_lg_mode           = ( !$first_image || empty( $first_image ) || is_null( $first_image ) ) ? 'full_width' : '';
  $content_lg_class        = ( !$second_image || empty( $second_image ) || is_null( $second_image ) ) ? 12 : 6;
  $content_lg_mode         = ( !$second_image || empty( $second_image ) || is_null( $second_image ) ) ? 'full_width' : '';
else :          
  $content_lg_class    = 6;
  $content_lg_mode     = '';
  $title_lg_class      = 8;
  $title_lg_mode       = '';
  $img_first_lg_class  = 7;
  $img_first_lg_mode   = '';
  $img_second_lg_class = 7;
  $img_second_lg_mode  = '';
  
endif;

if( is_array( $first_row ) && !empty( $first_row ) || is_array( $second_row ) && !empty( $second_row ) ) : ?>

<section id="flex-chess-image-block-<?php echo $block_id_str; ?>" class="flex-chess-image-block">
  <?php if( is_array( $first_row ) && !empty( $first_row ) ) : ?>
   <?php if( !empty( $block_title ) ) : ?>
    <div class="container flex-chess-image-block__row row_first">
      <div class="row d-flex justify-content-<?php echo $text_first_float; ?>">
          <div class="col-12 col-lg-<?php echo $title_lg_class . ' ' . $title_lg_mode; ?> flex-chess-image-block__row__title">
            <?php echo $block_title; ?>
          </div>
      </div>
    </div>
    <?php endif; ?>
    <?php if( $first_image ) : ?>
          <div class="col-12 col-lg-<?php echo $img_first_lg_class; ?> p-0 flex-chess-image-block__img-wrapper row_first_image block_position_<?php echo $img_first_float . ' ' . $img_first_lg_mode; ?> d-none d-lg-block p-absolute">
            <img src="<?php echo $first_image; ?>" alt="<?php echo $first_alt; ?>" title="<?php echo $first_title; ?>" class="img-inner img-responsive">
          </div>
    <?php endif; ?>
  <?php endif;
  if( is_array( $second_row ) && !empty( $second_row ) ) : ?>
    <div class="container-fluid site-container flex-chess-image-block__row row_second">
      <div class="row-fluid d-flex justify-content-<?php echo $text_second_float; ?>">
        <?php if( $second_image ) : ?>
          <div class="col-12 col-lg-<?php echo $img_second_lg_class; ?> p-0 flex-chess-image-block__img-wrapper row_second_image block_position_<?php echo $img_second_float . ' ' . $img_second_lg_mode; ?> d-block h-100 p-absolute">
            <img src="<?php echo $second_image; ?>" alt="<?php echo $second_alt; ?>" title="<?php echo $second_title; ?>" class="img-inner img-responsive">
          </div>
        <?php endif; ?>
        
        <?php if( $second_content || $work_time || $addresses || $emails || $phone_nums ) : ?>
        <div class="col-12 col-lg-<?php echo $content_lg_class . ' ' . $content_lg_mode; ?> flex-chess-image-block__row__content">
          <?php if( $second_content ) : ?>
          <div class="w-100 flex-chess-image-block__row__content__text">
              <?php echo $second_content; ?>
          </div>
          <?php endif;
          if( !empty( $work_time ) && is_array( $work_time ) ) : ?>
                                    <div class="w-100 text-left flex-chess-image-block__contact-data__block time-block">
                                        <h4><?php echo __('Время работы', 'hcc'); ?></h4>
                                        <?php foreach( $work_time as $time ) : 
                                        if( !empty($time) ) : ?>
                                         <p class="text-white">
                                             <strong><?php echo wp_kses_post( $time['day'] ); ?></strong>
                                             - 
                                             <time><?php echo wp_kses_post( $time['time'] ); ?></time>
                                          </p>
                                        <?php endif;
                                        endforeach; ?>
                                    </div>
           <?php endif;
           if( !empty( $addresses ) && is_array( $addresses ) ) : ?>
                                    <adress class="w-100 text-left flex-chess-image-block__contact-data__block addresses-block d-block">
                                        <?php foreach( $addresses as $adres ) : ?>
                                                <?php $adress = wp_kses_post( trim( $adres['adress'] ) );
                                                $href = esc_url( wp_kses_post( trim( $adres['g_href'] ) ) ); 
                                                if( !empty( $adress ) ) : ?>
                                                    <a href="<?php echo ( !empty( $href )  ) ? $href : '#'; ?>" target="_blank" rel="nofollow" class="d-flex align-items-end justify-content-start mr-auto link_el">
                                                        <span class="body"><?php echo $adress; ?></span>
                                                    </a>
                                                <?php endif; ?>
                                          <?php endforeach; ?>
                                    </adress>
           <?php endif;
           if( !empty( $emails ) && is_array( $emails ) ) : ?>
                                    <div class="w-100 text-left flex-chess-image-block__contact-data__block emails-block">
                                        <?php foreach( $emails as $email ) : ?>
                                              <?php $email      = wp_kses_post( filter_var( trim( $email['email'] ), FILTER_VALIDATE_EMAIL ) ); 
                                                    $icon_path  = '/assets/public/img/icons/proto-mail.svg';
                                                    $icon_src   = hcc_isset_img( dirname(__FILE__), '../..', $icon_path );
                                              if( !empty( $email ) ) : ?>
                                                  <a href="mailto:<?php echo $email; ?>" class="d-flex align-items-end justify-content-start mr-auto link_el">
                                                      <?php if( $icon_src !== false ) : ?>
                                                          <img src="<?php echo $icon_src; ?>" alt="<?php echo __('Mail icon'); ?>" title="<?php echo __('Mail icon') . '|' . SITE_NAME; ?>" class="icon">
                                                      <?php endif; ?>
                                                      <span class="body"><?php echo $email; ?></span>
                                                  </a>
                                              <?php endif; ?>
                                          <?php endforeach; ?>
                                    </div>
              <?php endif;
              if( !empty( $phone_nums ) && is_array( $phone_nums ) ) : ?>
                                    <div class="w-100 text-left flex-chess-image-block__contact-data__block phones-block">
                                        <?php foreach( $phone_nums as $phone ) : ?>
                                              <?php $tel = sanitize_text_field( trim( $phone['phone_num'] ) );
                                              $href = preg_replace( '~[^0-9]+~', '', $tel ); 
                                              $icon_path  = '/assets/public/img/icons/proto-telephone.svg';
                                              $icon_src   = hcc_isset_img( dirname(__FILE__), '../..', $icon_path );
                                              if( !empty( $tel ) ) : ?>
                                                  <a href="tel:<?php echo $href; ?>" class="d-flex align-items-end justify-content-start mr-auto link_el">
                                                      <?php if( $icon_src !== false ) : ?>
                                                        <img src="<?php echo $icon_src; ?>" alt="<?php echo __('Phone icon'); ?>" title="<?php echo __('Phone icon') . '|' . SITE_NAME; ?>" class="icon">
                                                      <?php endif; ?>
                                                      <span class="body"><?php echo $tel; ?></span>
                                                  </a>
                                              <?php endif; ?>
                                          <?php endforeach; ?>
                                    </div>
                <?php endif; ?>
        </div>
        <?php endif; ?>
        
      </div>
    </div>
  <?php endif; ?>
</section>

<?php endif; ?>