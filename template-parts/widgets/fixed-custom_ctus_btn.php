<?php
/*
 * Custom Contact Us Button
 *
 *
 */
if( function_exists( 'get_field' ) ) :
            $visibility  = get_field('contact_button_visibility', 'options');
                    if( $visibility === 'true' ) :
                        $links       = get_field('socials_копия', 'options');
                        $phones      = get_field('phone_nums', 'options');
                        $name        = !empty( SITE_NAME ) ? SITE_NAME : '';
                        $theme_url   = !empty( THEME_URI ) ? THEME_URI : get_template_directory_uri();
                    endif;
endif; 
$modal = get_option('hcc-theme-cf-modal'); 

if( $visibility === 'true' ) : ?>
       
        <div class="contact-button-wrap">
            <div class="button-tel">
                <div class="button-tel-icon"></div>
                <div class="button-tel-content">
                    <span class="text"><?php echo __('Свяжитесь с нами', 'hcc'); ?></span>
                </div>
            </div>
            <div class="buttons-socials <?php if( !$modal ) : ?> no-msg <?php endif; ?>">
                <?php 
                $icon_path = esc_url( $theme_url . '/assets/public/img/icons/icon-email.svg');
                $icon_src  = hcc_isset_img( dirname(__FILE__), '../..', $icon_path );
                if( $modal ) : ?>
                <a href="#" class="one-social message social-1" target="_self">
                    <?php if( $icon_src !== false ) : ?>
                          <img src="<?php echo $icon_src; ?>" title="<?php echo __('Email icon') . $name; ?>" alt="<?php echo __('Email icon'); ?>">
                    <?php endif; ?>
                </a>
                <?php endif; ?>
                <?php if( $links ) : 
                            $socialCounter = 2;
                            foreach( $links as $link) :
                                $actions     = $link['actions'];
                                $link_name   = mb_strtolower( wp_kses_post( $link['nazvanie'] ) );
                                $href        = $link['link'] ? wp_kses_post( trim( $link['link'] ) ): '#'; 
                                $mobile_href = $link['link_mobile'] ? wp_kses_post( trim( $link['link_mobile'] ) ) : '#'; 
                                $image       = $link['icon'];
                                $target      = ( mb_strpos($href, 'http') !== false ) ? '_blank' : '_self'; 
                                if( $actions === 'computer' ) : 
                                    if( $href ) : ?>
                                        <a href="<?php echo $href; ?>" class="one-social social-<?php echo $socialCounter . ' ' . $link_name; ?>" target="<?php echo $target; ?>">
                                            <?php if( $image && is_array( $image ) ) : ?>
                                                <img src="<?php echo esc_url( $image['url'] ); ?>" title="<?php echo esc_attr( $image['title'] ) ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
                                            <?php endif; ?>
                                        </a>
                                    <?php endif;
                                elseif( $actions === 'mobile' ) : 
                                    if( $href && !is_mobile() ) : ?>
                                        <a href="<?php echo $href; ?>" class="one-social social-<?php echo $socialCounter . ' ' . $link_name; ?>" target="<?php echo $target; ?>">
                                            <?php if( $image && is_array( $image ) ) : ?>
                                                <img src="<?php echo esc_url( $image['url'] ); ?>" title="<?php echo esc_attr( $image['title'] ) ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
                                            <?php endif; ?>
                                        </a>
                                    <?php endif;
                                    if( $mobile_href && is_mobile() ) : ?>
                                        <a href="<?php echo $href; ?>" class="one-social social-<?php echo $socialCounter . ' ' . $link_name; ?>" target="<?php echo $target; ?>">
                                            <?php if( $image ) : ?>
                                                <img src="<?php echo esc_url( $image['url'] ); ?>" title="<?php echo esc_attr( $image['title'] ) ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
                                            <?php endif; ?>
                                        </a>
                                    <?php endif;
                                endif;
                            $socialCounter++; endforeach; 
                endif;
                if( $phones ) : 
                            $phone     = $phones[0];
                            $tel       = sanitize_text_field( trim( $phone['phone_num'] ) );
                            $href_tel  = preg_replace( '~[^0-9]+~', '', $tel );
                            $icon_path = esc_url( $theme_url . '/assets/public/img/icons/phone.svg' );
                            $icon_src  = hcc_isset_img( dirname(__FILE__), '../..', $icon_path );
                            if( !empty( $href_tel ) ) : ?>
                                <a href="tel:+38<?php echo $href_tel; ?>" class="one-social phone social-<?php echo $socialCounter++; ?>" target="_self">
                                    <?php if( $icon_src !== false ) : ?>
                                          <img src="<?php echo $icon_src; ?>" title="<?php echo __('Phone icon') . ' ' . $name; ?>" alt="<?php echo __('Phone icon'); ?>">
                                    <?php endif; ?>
                                </a>
                            <?php endif; 
                  endif; ?>
            </div>
        </div>
<?php endif; ?>
