<?php
/*
 * C7 accessability
 *
 */
define( 'WPCF7_ADMIN_READ_CAPABILITY', 'manage_options' );
define( 'WPCF7_ADMIN_READ_WRITE_CAPABILITY', 'manage_options' );

/*
 * Remove assets
 *
 */
add_action( 'wpcf7_init', function() {
  add_filter( 'wpcf7_load_js', '__return_false' );
  add_filter( 'wpcf7_load_css', '__return_false' );
});

/*
 * Add assets for pages with C7 shortcodes
 *
 */
add_filter( 'shortcode_atts_wpcf7', 'hcc_wpcf7_add_assets' );
function hcc_wpcf7_add_assets( $atts ) {
	wpcf7_enqueue_styles();
	return $atts;
}

/*
 * Disable C7 Pipe - second message
 *
 */
add_action('init', 'hcc_wpc7_disable_pipe');
function hcc_wpc7_disable_pipe() {
  define( 'WPCF7_USE_PIPE', false );
}
