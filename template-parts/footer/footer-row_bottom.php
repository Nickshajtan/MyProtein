<?php
/*
 * Including Privacy Police link & copyright
 *
 */

$copyright = get_option('options_copyright_display', 'yes'); 
$polytic   = get_option('options_confedential_display', 'no'); 
                
if( $copyright === 'yes' || $polytic === 'yes' ) : ?>
                  <div class="site-footer__bottom">
                    <div class="container-fluid site-container">
                      <div class="row d-flex justify-content-center">
                          <a href="<?php echo get_privacy_policy_url(); ?>" class="link_el" rel="nofollow">
                                  <?php if( !empty( COPYRIGHT ) ) : echo COPYRIGHT; endif; ?>
                          </a>
                          <?php if( $polytic === 'yes' ) : ?>
                            <a href="<?php echo get_privacy_policy_url(); ?>" class="link_el" rel="nofollow">
                                  <?php echo __('Privacy Police', 'hcc'); ?>
                            </a>
                          <?php endif;
                          if( !empty( SITE_FOR_CLIENT ) ) : ?>
                              <div class="col-12 col-md-6 d-flex justify-content-end align-items-center text-white">Created by HCC</div>
                          <?php endif; ?>
                      </div>
                    </div>  
                  </div>
<?php endif; ?>
