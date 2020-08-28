<?php
/*
 * Change admin login page style
 * return html code
 */

add_action( 'login_enqueue_scripts', 'hcc_login_logo_one' );
function hcc_login_logo_one() { 
	$logo_img = '';
    $name = '';
	if( $custom_logo_id = get_theme_mod('custom_logo') ){
		$logo_img = wp_get_attachment_image_url( $custom_logo_id, 'full');
        if( $logo_img ){
            $result = $logo_img;
            $name = '';
        }
    }
    else{
            $result = 'none';
            $name = get_bloginfo('name');
    }
		echo '<div id="gradient"></div>';
		echo '<style type="text/css"> body.login div#login h1:after{content: "' . $name . '"; display: block; font-size: 1rem; max-width: 68%; margin-left: auto; margin-right: auto; margin-bottom: 30px; color: #fff;
    text-shadow: 2px 4px 6px rgba(11,9,9,0.35);} body.login div#login h1 a {background-image: url('. $result .'); background-size: contain; background-position: center; width: 150px; height: 100px; } #login{position:relative; z-index:100; } #login form{background: rgba(255,255,255,.5) !important; } #login a, #login a:hover{color: #fff !important; } #gradient{position: fixed; left:0; right:0; top:0; bottom:0; background: linear-gradient(-45deg, #ee7752, #3ce7e7, #23a6d5, #23d5ab); background-size: 400% 400%; animation: gradientBG 15s ease infinite; } @keyframes gradientBG {0% {background-position: 0% 50%; } 50% {background-position: 100% 50%; } 100% {background-position: 0% 50%; } } </style>'; 
} 
add_filter( 'login_headerurl', 'hcc_custom_loginlogo_url' );
function hcc_custom_loginlogo_url($url) {
	return GET_THEME_HOME_URL;
}
  
/*
 * Do things upon theme activation
 *
 */
add_action("after_switch_theme", "hcc_theme_do_something");
function hcc_theme_do_something(){
	$pages = array(
		'contact' => array(
			'new_page_title' => __('Contacts', 'hcc'),
			'new_page_name' => '',
			'new_page_content' => '',
			'new_page_template' => 'templates/template-contacts.php',
		),
		'404' => array(
			'new_page_title' => __('404 error', 'hcc'),
			'new_page_name' => 'error-404',
			'new_page_content' => '',
			'new_page_template' => '',
		),
        '403' => array(
			'new_page_title' => __('403 error', 'hcc'),
			'new_page_name' => 'error-403',
			'new_page_content' => '',
			'new_page_template' => '',
		),
        '401' => array(
			'new_page_title' => __('401 error', 'hcc'),
			'new_page_name' => 'error-401',
			'new_page_content' => '',
			'new_page_template' => '',
		),
		'thank-you' => array(
			'new_page_title' => __('Thank you', 'hcc'),
			'new_page_name' => '',
			'new_page_content' => '',
			'new_page_template' => 'templates/template-thanks.php',
		),
        'privacy' => array(
			'new_page_title' => __('Privacy Policy', 'hcc'),
			'new_page_name' => '',
			'new_page_content' => '',
			'new_page_template' => 'templates/template-privacy.php',
		),
	);
	foreach ($pages as $page) {
		$page_check = get_page_by_title($page['new_page_title']);
		$new_page = array(
			'post_type'			=> 'page',
			'post_title'		=> $page['new_page_title'],
			'post_name'			=> $page['new_page_name'],
			'post_content'	    => $page['new_page_content'],
			'post_status'		=> 'publish',
			'post_author'		=> 1,
		);
		if(!isset($page_check->ID)){
			$new_page_id = wp_insert_post($new_page);
			if(!empty($page['new_page_template'])){
				update_post_meta($new_page_id, '_wp_page_template', $page['new_page_template']);
			}
		}
	}
    /*
     * Custom error pages args
     *
     */
    add_action('wp','hcc_custom_error_pages');
    function hcc_custom_error_pages(){
        global $wp_query;
      
        if(isset($_REQUEST['status']) && $_REQUEST['status'] == 404)
        {
            $wp_query->is_404 = TRUE;
            $wp_query->is_page = TRUE;
            $wp_query->is_singular = TRUE;
            $wp_query->is_single = FALSE;
            $wp_query->is_home = FALSE;
            $wp_query->is_archive = FALSE;
            $wp_query->is_category = FALSE;
            add_filter('wp_title','hcc_custom_error_title', 65000, 2);
            add_filter('document_title_parts','hcc_custom_error_title', 65000, 2);
            add_filter('body_class','hcc_custom_error_class');
            status_header(404);
            get_template_part('404');
            exit;
        }
      
        if(isset($_REQUEST['status']) && $_REQUEST['status'] == 403)
        {
            $wp_query->is_404 = FALSE;
            $wp_query->is_page = TRUE;
            $wp_query->is_singular = TRUE;
            $wp_query->is_single = FALSE;
            $wp_query->is_home = FALSE;
            $wp_query->is_archive = FALSE;
            $wp_query->is_category = FALSE;
            add_filter('wp_title','hcc_custom_error_title', 65000, 2);
            add_filter('body_class','hcc_custom_error_class');
            status_header(403);
            get_template_part('403');
            exit;
        }

        if(isset($_REQUEST['status']) && $_REQUEST['status'] == 401)
        {
            $wp_query->is_404 = FALSE;
            $wp_query->is_page = TRUE;
            $wp_query->is_singular = TRUE;
            $wp_query->is_single = FALSE;
            $wp_query->is_home = FALSE;
            $wp_query->is_archive = FALSE;
            $wp_query->is_category = FALSE;
            add_filter('wp_title','hcc_custom_error_title', 65000, 2);
            add_filter('body_class','hcc_custom_error_class');
            status_header(401);
            get_template_part('401');
            exit;
        }
    }

    function hcc_custom_error_title($title='', $sep='')
    {
        $tag  = wp_get_document_title();
        $name = ( !empty( SITE_NAME ) ) ? SITE_NAME : wp_kses_post( get_bloginfo('name') );
        
        if(isset($_REQUEST['status']) && $_REQUEST['status'] == 404)
            $title = ( $title ) ? wp_kses_post( $title ) : __('404: not found','hcc');
            return $title . $sep . " " . $name;
      
        if(isset($_REQUEST['status']) && $_REQUEST['status'] == 403)
            $title = ( $title ) ? wp_kses_post( $title ) : __('Forbidden','hcc');
            return $title . $sep ." ". $name;

        if(isset($_REQUEST['status']) && $_REQUEST['status'] == 401)
            $title = ( $title ) ? wp_kses_post( $title ) : __('Unauthorized','hcc');
            return $title . $sep . " " . $name;
    }

    function hcc_custom_error_class($classes)
    {
        if(isset($_REQUEST['status']) && $_REQUEST['status'] == 404)
        {
            $classes[]="error404";
            return $classes;
        }
      
        if(isset($_REQUEST['status']) && $_REQUEST['status'] == 403)
        {
            $classes[]="error403";
            return $classes;
        }

        if(isset($_REQUEST['status']) && $_REQUEST['status'] == 401)
        {
            $classes[]="error401";
            return $classes;
        }
    }

	/*
     * Activate required plugins
     *
     */
	foreach (array(
		'cyr2lat/cyr-to-lat.php',
		'cyr3lat/cyr-to-lat.php',
		'wp-mail-smtp/wp-mail-smtp.php',
	) as $plugin) {
		$path = sprintf($plugin);
		$result = activate_plugin( $path );
		if ( !is_wp_error( $result ) ) {
			add_action( 'admin_notices', function() use ($plugin) {
				echo '<div class="notice notice-success"><p>' . sprintf('<strong>%s</strong>' . __(' plugin is required & auto-enabled by the current theme.', 'hcc'), $plugin) . '</p></div>';
			} );
		} else {
			add_action( 'admin_notices', function() use ($plugin) {
				echo '<div class="notice notice-error"><p>' . sprintf('<strong>%s</strong>' . __(' plugin can\'t be auto-enabled by the current theme.', 'hcc'), $plugin) . '</p></div>';
			} );
		}
	}
}

/*
 * Add post states
 *
 */
add_filter( 'display_post_states', 'hcc_add_post_state', 10, 2 );
function hcc_add_post_state( $post_states, $post ) {
	if( $post->post_name == 'error-404' ) {
		$post_states[] = __('404 error page', 'hcc');
	}
    if( $post->post_name == 'error-403' ) {
		$post_states[] = __('403 error page', 'hcc');
	}
    if( $post->post_name == 'error-401' ) {
		$post_states[] = __('401 error page', 'hcc');
	}
	if( get_page_template_slug( $post->ID ) == 'templates/template-thanks.php' ) {
		$post_states[] = __('Thank you page', 'hcc');
	}
    if( get_page_template_slug( $post->ID ) == 'templates/template-contacts.php' ) {
		$post_states[] = __('Contacts page', 'hcc');
	}
    if( get_page_template_slug( $post->ID ) == 'templates/template-privacy.php' ) {
		$post_states[] = __('Privacy Policy page', 'hcc');
        update_option( 'wp_page_for_privacy_policy', $post->ID );
	}
	return $post_states;
}

/*
 * Add post notice
 *
 */
add_action( 'admin_notices', 'hcc_add_post_notice' );
function hcc_add_post_notice() {
	global $post;
	if( @get_page_template_slug( $post->ID ) == 'templates/template-contacts.php' ) {
		/* Add a notice to the edit page */
		//add_action( 'edit_form_after_title', 'hcc_add_page_notice_cnt', 1 );
		/* Remove the WYSIWYG editor */
		//remove_post_type_support( 'page', 'editor' );
	}

	if( isset( $post->post_name ) && ( $post->post_name == 'error-404' || $post->post_name == 'error-403' || $post->post_name == 'error-401' )) {
		/* Add a notice to the edit page */
		add_action( 'edit_form_after_title', 'hcc_add_page_notice_err', 1 );
	}
}

function hcc_add_page_notice_cnt() {
	echo '<div class="notice notice-warning inline"><p>' . __( 'Contents of this pager are edited from the Theme options -> Contacts or follow this', 'hcc') . '<a href="/wp-admin/admin.php?page=acf-options-contacts">' . __('link', 'hcc' ) . '</a></p></div>';
}
function hcc_add_page_notice_err() {
	echo '<div class="notice notice-warning inline"><p>' . __( 'This page is used to display error page content. DO NOT CHANGE ITS SLAG!', 'hcc' ) . '</p></div>';
}

/*
 * Add menu message
 *
 */
if( class_exists('HCC_Nav_Walker') ) {
    add_filter('admin_print_scripts-nav-menus.php', 'hcc_add_nav_message', 10, 2);
}
function hcc_add_nav_message(){
        wp_register_script( 'admin-nav-js', THEME_URI . '/includes/config/admin/assets/js/nav-message.min.js', array('jquery'), '', true );
        wp_localize_script( 'admin-nav-js', 'hcc_nav_params', array(
		    'message' =>  __('If you want to add a link to an existing page element use #ID, ID - a unique identifier for your item. Use constructs like %home% or %page_name% at the beginning of the line to indicate the page of the element. This option using HCC_Nav_Walker class', 'hcc'),
        ) );
        wp_enqueue_script( 'admin-nav-js' );
        wp_register_style( 'admin-nav-css', THEME_URI . '/includes/config/admin/assets/css/nav-message.css' );
        wp_enqueue_style( 'admin-nav-css' );
}
// Security helpers
get_template_part('includes/helpers/security_helpers');