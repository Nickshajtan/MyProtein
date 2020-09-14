<?php
/*
 * Some function for comments functionality
 *
 */

/*
 * Add new default avatar
 *
 */
add_filter( 'avatar_defaults', 'hcc_add_default_avatar_option' );
function hcc_add_default_avatar_option( $avatars ){
	$url = wp_upload_dir('2020/09')['url'] . '/avatar.png';
	$avatars[ $url ] = '<img src="' . $url . '" class="avatar">' . __('Аватар сайта', 'hcc');
	return $avatars;
}
