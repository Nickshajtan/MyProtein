<?php 
/*
 * Header middle line template
 *
 */

$phones      = hcc_get_option_field( 'options_phone_nums', 
    array(
      'phone_num' => 'text-type',
    ), 
false );
$emails      = hcc_get_option_field( 'options_emails', 
    array(
      'email' => 'text-type',
    ), 
false );
$addresses   = hcc_get_option_field( 'options_addresses', 
    array(
      'adress' => 'text-type',
      'g_href' => 'text-type',
    ), 
false );

$phones_check    = get_option('options_phones_display');
$emails_check    = get_option('options_emails_display');
$addresses_check = get_option('options_addresses_display');

$phones_display    = ( is_array( $phones_check ) && in_array('header', $phones_check ) )    ? true : false; 
$emails_display    = ( is_array( $emails_check ) && in_array('header', $emails_check ) )    ? true : false; 
$addresses_display = ( is_array( $addresses_check ) && in_array('header', $addresses_check ) ) ? true : false; 

if( $phones && $phones_display || $emails && $emails_display || $addresses && $addresses_display ) : ?>
                 <div class="site-header__middle col-12 d-flex order-2 order-xl-2 pl-0 pr-0">
                   <div class="container">
                     <div class="row">
                       <?php if( $phones && is_array( $phones ) ) : ?>
                                <div class="col-12 col-lg-4 order-1 phones">
                                            <?php foreach( $phones as $phone ) : ?>
                                                <?php $tel = sanitize_text_field( trim( $phone['phone_num'] ) );
                                                $href = preg_replace( '~[^0-9]+~', '', $tel ); 
                                                if( !empty( $tel ) ) : ?>
                                                    <a href="tel:<?php echo $href; ?>" class="d-flex align-items-end justify-content-end ml-auto link_el">
                                                        <span class="icon"></span><span class="body"><?php echo $tel; ?></span>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                </div>
                              <?php endif;
                              if( $emails && is_array( $emails ) ) : ?>
                              <div class="col-12 col-lg-4 order-2 emails">
                                            <?php foreach( $emails as $email ) : ?>
                                                <?php $email = wp_kses_post( trim( $email['email'] ) ); 
                                                if( !empty( $email ) ) : ?>
                                                    <a href="mailto:<?php echo $email; ?>" class="d-flex align-items-end justify-content-end ml-auto link_el">
                                                        <span class="icon"></span><span class="body"><?php echo $email; ?></span>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                              </div>
                              <?php endif;
                              if( $addresses && is_array( $addresses ) ) : ?>
                                <adress class="col-12 col-lg-4 order-3 d-block">
                                              <?php foreach( $addresses as $adres ) : ?>
                                                  <?php $adress = wp_kses_post( trim( $adres['adress'] ) );
                                                  $href = esc_url( wp_kses_post( trim( $adres['g_href'] ) ) ); 
                                                  if( !empty( $adress ) ) : ?>
                                                      <a href="<?php echo ( !empty( $href )  ) ? $href : '#'; ?>" target="_blank" rel="nofollow" class="d-flex align-items-end justify-content-end ml-auto link_el">
                                                          <span class="icon"></span><span class="body"><?php echo $adress; ?></span>
                                                      </a>
                                                  <?php endif; ?>
                                              <?php endforeach; ?>
                                </adress>
                              <?php endif; ?>
                     </div>
                   </div>
                 </div>
<?php endif; 

unset( $phones_check );
unset( $emails_check );
unset( $addresses_check );

?>
                 