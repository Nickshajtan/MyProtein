<?php
/*
 * Banner Block for Flexible content with WP editor & contact information
 *
 */

$block_title   = hcc_get_acf_header('title text-white text-center');
$block_image   = get_sub_field('image', $post->ID);
$block_image   = ( is_array( $block_image ) ) ? esc_url( $block_image['url'] ) : esc_url( $block_image );
$bg            = ( !wp_is_mobile() ) ? aq_resize( $block_image, 1500, 400, true, true, true) : aq_resize( $block_image, 750, 400, true, true, true);
$image         = ( !empty( $bg ) ) ? 'style="background-image: url(' . $bg . ');"' : '';

$data       = get_sub_field('data', $post->ID);
$data_left  = $data['left_column'];
$left_text  = wp_kses_post( $data_left['block_content']);
$data_right = $data['right_column'];
$right_text = wp_kses_post( $data_right['block_content']);

$time         = $data_left['work_time'];
$addresses    = $data_left['addresses'];
$emails       = $data_right['emails'];
$phone_nums   = $data_right['phone_nums'];

if( ( !empty( $block_title ) && is_array( $block_title ) ) || !empty( $block_image ) || !empty( $data ) ) : ?>

<section id="flex-banner-info-columns-block" class="flex-banner-info-columns-block flex-banner-info-block block-banner d-flex align-items-center" <?php echo $image; ?>>
  <div class="container">
    <div class="row d-flex align-items-end justify-content-center">
       
        <?php if( !empty( $block_title ) ) : ?>
        <div class="flex-banner-text-block__title col-12">
          <?php echo $block_title; ?>  
        </div>
        <?php endif; ?>
        
        <?php if( $data_left ) : ?>
        <div class="col-12 col-lg-6 flex-banner-info-block__left-column d-flex align-items-end justify-content-end flex-column">
          <?php if( !empty( $left_text ) ) : ?>
            <div class="w-100 text-left flex-banner-info-block__content">
              <?php echo $left_text; ?>
            </div>
          <?php endif;
          if( !empty( $time ) && is_array( $time ) ) : ?>
            <time class="w-100 text-left flex-banner-info-block__contact-data__block time-block">
                                        <h4><?php echo __('Время работы', 'hcc'); ?></h4>
                                        <?php foreach( $time as $time ) : 
                                        if( !empty($time) ) : ?>
                                         <p class="text-white">
                                             <strong><?php echo wp_kses_post( $time['day'] ); ?></strong>
                                             - 
                                             <time><?php echo wp_kses_post( $time['time'] ); ?></time>
                                          </p>
                                        <?php endif;
                                        endforeach; ?>
            </time>
          <?php endif;
          if( !empty( $addresses ) && is_array( $addresses ) ) : ?>
            <address class="w-100 text-left flex-banner-info-block__contact-data__block addresses-block">
              <?php foreach( $addresses as $adres ) : ?>
                                                <?php $adress = wp_kses_post( trim( $adres['adress'] ) );
                                                $href = esc_url( wp_kses_post( trim( $adres['g_href'] ) ) ); 
                                                if( !empty( $adress ) ) : ?>
                                                    <a href="<?php echo ( !empty( $href )  ) ? $href : '#'; ?>" target="_blank" rel="nofollow" class="d-flex align-items-end justify-content-start mr-auto link_el">
                                                        <span class="body"><?php echo $adress; ?></span>
                                                    </a>
                                                <?php endif; ?>
              <?php endforeach; ?>
            </address>
          <?php endif; ?>
        </div>
        <?php endif;
        if( $data_right ) : ?>
        <div class="col-12 col-lg-6 flex-banner-info-block__right-column justify-content-end d-flex align-items-end flex-column">
          <?php if( !empty( $right_text ) ) : ?>
            <div class="w-100 text-left flex-banner-info-block__content">
              <?php echo $right_text; ?>
            </div>
          <?php endif;
          if( !empty( $emails ) && is_array( $emails ) ) : ?>
            <div class="w-100 text-left flex-banner-info-block__contact-data__block emails-block">
                          
                                        <?php foreach( $emails as $email ) : ?>
                                              <?php $email      = wp_kses_post( trim( $email['email'] ) ); 
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
                                    <div class="w-100 text-left flex-banner-info-block__contact-data__block phones-block">
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
</section>

<?php endif; ?>
