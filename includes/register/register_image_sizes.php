<?php
/**
 * Register & setup your image sizes
 * 
 */
?>
<?php
add_action('after_setup_theme', 'hcc_register_image_sizes');
function hcc_register_image_sizes(){
  
}

add_filter('intermediate_image_sizes_advanced', 'hcc_remove_default_image_sizes');
function hcc_remove_default_image_sizes( $sizes ) {
	unset( $sizes['thumbnail']);
	unset( $sizes['medium']);
	unset( $sizes['large']);

	return $sizes;
}
