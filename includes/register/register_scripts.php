<?php
/**
 * Registering & setuping theme styles & scripts
 * 
 */
?>
<?php
if( !defined('PATH') ) {
    define( 'PATH', wp_normalize_path( str_replace( '\\', '/', dirname(dirname(dirname(__FILE__))) ) ) );
}

remove_action( 'wp_head', 'wp_custom_css_cb', 101 );

if( version_compare('5.0.0', get_bloginfo('version'), '>=') ) {
    add_action( 'after_setup_theme', 'hcc_add_editor_styles' );
}
function hcc_add_editor_styles() {
    add_theme_support( 'editor-styles' );
    add_theme_support( 'editor-style' );
	add_editor_style( 'editor-styles.css' );
}

get_template_part('includes/register/register_scripts/styles', 'header');
get_template_part('includes/register/register_scripts/scripts', 'main');

$libs = get_option('hcc-theme-tl-libs-off');
if( $libs ) {
    $syntax = get_option('hcc-theme-tl-libs-syntax');
    if( $syntax ) {
      get_template_part('includes/register/register_scripts/libs_include', 'if-syntax');
    }
    else {
      get_template_part('includes/register/register_scripts/libs_include', 'case-syntax');
    }
}

get_template_part('includes/register/register_scripts/styles', 'footer');
get_template_part('includes/register/register_scripts/deregister');

//--remove version css, js--//
add_filter( 'script_loader_src', 'hcc_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'hcc_remove_script_version', 15, 1 );
function hcc_remove_script_version( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
