<?php
/*
 * Write static post link into guid of wp_posts table
 *
 *
 */

//add_action( 'save_post', 'hcc_guid_write', 100 );
function hcc_guid_write( $id ){
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) {
        return false;
    }

	if( $id = intval($id) ){
		global $wpdb;
		$wpdb->update( $wpdb->posts, ['guid'=>( get_permalink($id) ) ], ['ID'=>$id] ); //wp_make_link_relative
	}

	clean_post_cache( $post_id );
}
