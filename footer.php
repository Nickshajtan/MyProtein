<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hcc
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly  ?>
                </main>
            </div><!-- #content -->
            
            <footer id="colophon" class="site-footer">
              <?php 
                /*** Logo, socials & menu ***/
                get_template_part('template-parts/footer/footer', 'row_top');
                /*** Contact info ***/
                get_template_part('template-parts/footer/footer', 'row_middle');
                /*** Copyright ***/
                get_template_part('template-parts/footer/footer', 'row_bottom');
                /*** Ajax error modal ***/
                get_template_part('template-parts/modals/message', 'error');
                /*** Custom contact form Modal ***/
                get_template_part('template-parts/modals/modal', 'custom_form');
                /*** Custom modal via Remodal ***/
                get_template_part('template-parts/modals/modal', 'custom_remodal');
                /*** Custom fixed contact us button ***/
                get_template_part('template-parts/widgets/fixed', 'custom_ctus_btn');
              ?>  
            </footer><!-- #colophon -->
        </div><!-- #page -->
        <!-- include custom widgets -->
        <?php //get_template_part('template-parts/widgets', 'fixed'); ?>
        
        <div class="overlay"></div>
        <?php wp_footer(); ?>
        
        <?php $browsersync = get_option('hcc-theme-tl-reload', false); 
        if( $browsersync === true ) : ?>
            <script id="__bs_script__">//<![CDATA[
                document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.js?v=2.23.6'><\/script>".replace("HOST", location.hostname));
            //]]></script>
        <?php endif;

        /*** Customizer ***/
        $customizing = ( defined( 'SITE_CUSTOMIZE' ) ) ? SITE_CUSTOMIZE : get_option('hcc-theme-wp-customizing', false); 
        if( $customizing ) :
          // settings
          get_template_part('template-parts/footer/footer', 'customizer');
          // frontend color scheme switcher
          get_template_part('template-parts/widgets/fixed', 'theme_color_switcher');
        endif; ?>
    </body>
</html>
