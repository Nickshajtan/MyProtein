<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
/*
 * Check ZLIB & set ZLIB
 *
 */

$zlib = get_option('hcc-theme-tl-zlib') ? ini_get('zlib.output_compression') : false;
if( isset( $zlib ) && $zlib !== false && $zlib !== 'On' && ini_get('zlib.output_compression_level') !== '1' ) :
    ini_set('zlib.output_compression', 'On');
    ini_set('zlib.output_compression_level', '1');
endif; 

/*
 * Check ZLIB and set GZIP
 *
 */
if( get_option('hcc-theme-tl-gzip') && isset( $zlib ) && $zlib !== 'On' && ini_get('zlib.output_compression_level') !== '1' ) :
	if ( substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') ) :
		ob_start('ob_gzhandler'); 
	endif;
endif;

/*
 * Disable browser caching
 *
 */
$browser_no_cache = get_option('hcc-theme-woo-cache');
if( $browser_no_cache ) :
  header('Cache-Control: no-store, no-cache, must-revalidate');
  header('Cache-Control: post-check=0, pre-check=0', false);
  header('Expires: Mon, 01 Jan 1990 01:00:00 GMT');
  header('Last-Modified: '.gmdate("D, d M Y H:i:s").' GMT');
  header('Pragma: no-cache');
endif;
