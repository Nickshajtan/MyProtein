<?php
/**
 * Template name: Contacts
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
get_header();
if( have_posts() ) : 
    while ( have_posts() ) :
        the_post();
        $content = get_the_content();
        $content = apply_filters( 'the_content', $content );
        $post_id = get_the_ID();

        $data         = get_field('contact_data', $post_id);
        $time         = $data['work_time'];
        $addresses    = $data['addresses'];
        $emails       = $data['emails'];
        $phone_nums   = $data['phone_nums'];
        $socials_vis  = get_field('socials', $post_id);
        $g_map_vis    = get_field('socials', $post_id);

        $flex = get_field('flexible_content', $post_id);

         if ( $content || ( $data && is_array( $data ) ) || ( $flex && is_array( $flex ) ) ) : ?>
                
            <div class="contacts-page d-flex align-items-center justify-content-center">
              <section class="contacts-page__section">
                  <div class="contacts-page__contact-data col-12 p-0 d-flex flex-column flex-lg-row">
                    <?php if( has_post_thumbnail() && strpos( get_the_post_thumbnail_url(), 'wp-header-logo' ) === false ) : 
                          if( !wp_is_mobile() ) :
                            $image = esc_url( aq_resize( get_the_post_thumbnail_url(), 707, 707, true, true, true) );
                          else:
                            $image = esc_url( aq_resize( get_the_post_thumbnail_url(), 550, 550, true, true, true) );
                          endif;
                          
                          if( $image ) : 
                    ?>
                      <div class="col-12 col-lg-6 contacts-page__contact-data__thumbnail-wrapper p-0">
                          <img src="<?php echo $image; ?>" alt="<?php echo esc_attr( wp_kses_post( get_the_title() ) ); ?>" title="<?php echo esc_attr( wp_kses_post( get_bloginfo('name') ) . '|' . wp_kses_post( get_the_title() ) ); ?>" class="img-inner img-responsive contacts-page-image <?php echo get_post_type() . "-image"; ?>">
                      </div>
                      <?php endif;
                      endif;
                      if( $time || $addresses || $emails || $phone_nums ) : ?>
                          <div class="col-12 col-lg-6 contacts-page__contact-data__data-wrapper">
                              <div class="row d-flex justify-content-start m-0">
                                <?php if( !empty( $time ) && is_array( $time ) ) : ?>
                                    <div class="w-100 text-left contacts-page__contact-data__block time-block">
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
                                    </div>
                                <?php endif;
                                if( !empty( $addresses ) && is_array( $addresses ) ) : ?>
                                    <adress class="w-100 text-left contacts-page__contact-data__block addresses-block">
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
                                    <div class="w-100 text-left contacts-page__contact-data__block emails-block">
                                        <?php foreach( $emails as $email ) : ?>
                                              <?php $email      = wp_kses_post( filter_var( trim( $email['email'] ), FILTER_VALIDATE_EMAIL ) ); 
                                                    $icon_path  = '/assets/public/img/icons/proto-mail.svg';
                                                    $icon_src   = hcc_isset_img( dirname(__FILE__), '..', $icon_path );
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
                                    <div class="w-100 text-left contacts-page__contact-data__block phones-block">
                                        <?php foreach( $phone_nums as $phone ) : ?>
                                              <?php $tel = sanitize_text_field( trim( $phone['phone_num'] ) );
                                              $href = preg_replace( '~[^0-9]+~', '', $tel ); 
                                              $icon_path  = '/assets/public/img/icons/proto-telephone.svg';
                                              $icon_src   = hcc_isset_img( dirname(__FILE__), '..', $icon_path );
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
                                <?php endif;
                                if( $socials_vis === 'show' ) : 
                                    $socials     = get_field('socials', 'options');
                                ?>
                                    <div class="w-100 text-left contacts-page__contact-data__block socials-block">
                                        <h4><?php echo __('Мы в социальных сетях', 'hcc'); ?></h4>
                                        <?php foreach( $socials as $social ) : 
                                                $image = $social['icon'];
                                                $href  = esc_url( wp_kses_post( trim( $social['link'] ) ) );
                                                if( !empty( $image ) ) : ?>
                                                    <a href="<?php echo ( !empty( $href )  ) ? $href : '#'; ?>" target="_blank">
                                                        <img src="<?php echo esc_url( $image['url'] ); ?>" title="<?php echo esc_attr( $image['title'] ) ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" class="svg-icon" >
                                                    </a>
                                                <?php endif; ?>
                                          <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>    
                              </div>
                          </div>
                      <?php endif; ?>
                  </div>
                <?php if ( $content ) : ?>
                  <div class="contacts-page__content"><?php echo $content; ?></div>
                <?php endif; ?>
              </section>
            </div>    
            
            <?php /*** Google Map ***/
            if( get_field('locations','options') ) :
                // get_template_part('template-parts/google-map/google_map', 'many_maps');
                // get_template_part('template-parts/google-map/google_map', 'many_markers');
            endif; ?>
               
            <?php /*** Flexible Bloks ***/

           if( $flex && !is_null( $flex ) && is_array( $flex ) || have_rows( 'flexible_content', $post_id ) ) : 
                 while (has_sub_field('flexible_content', $post_id)) :
                                   $row_layout_slug = get_row_layout();
                                   get_template_part('template-parts/flexible/block', $row_layout_slug);
                 endwhile;
            endif; ?>
                
          <?php else : 
                get_template_part('template-parts/content/content', 'none');
          endif; 
        
    endwhile; 
endif; 
get_footer();
