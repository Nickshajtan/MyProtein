<?php
/*
 * ACF json sync
 *
 */
add_filter('acf/settings/save_json', 'hcc_acf_json');
function hcc_acf_json( $path ) {
    $path = THEME_URI . '/acf-json';
    return $path;  
}

/*
 * ACF options page
 *
 */
add_action('init', 'hcc_acf_init');
function hcc_acf_init() {
    if( function_exists('acf_add_options_page') ) {
        // add parent
        $parent = acf_add_options_page(array(
            'page_title'	=> __('Theme General Settings', 'hcc'),
            'menu_title'	=> __('Theme Settings', 'hcc'),
            'menu_slug'		=> 'theme-general-settings',
            'icon_url'		=> 'dashicons-info',
            'capability'	=> 'edit_posts',
            'redirect'		=> true
        ));

        // add sub page
        acf_add_options_sub_page(array(
            'page_title'	=> __('General settings', 'hcc'),
            'menu_title'	=> __('General', 'hcc'),
            'parent_slug'	=> $parent['menu_slug'],
        ));
    
    }
}

/*
 * Pasting custom user code in head
 *
 */
add_action("wp_head", "hcc_wp_head_extra_code");
function hcc_wp_head_extra_code() {
    echo get_field('header_code','options');
}
/*
 * Pasting custom user code after <body> tag
 *
 */
add_action("wp_body_open", "hcc_wp_body_open_extra_code");
function hcc_wp_body_open_extra_code() {
    echo get_field('body_code_top','options');
}
/*
 * Pasting custom user code after <body> tag
 *
 */
add_action("wp_footer", "hcc_wp_body_close_extra_code");
function hcc_wp_body_close_extra_code() {
    echo get_field('body_code_bottom','options');
}
/*
 * Get acf title with tags
 * @param $class is html class of tag element
 * Function return first child element with block_title ACF id
 */
function hcc_get_acf_header( $class = '' ){
            $tag   = get_sub_field('tag');
            $title = wp_kses_post( get_sub_field('block_title') );
            if (empty($tag)) { $tag = 'div';	};
            if (empty($title)) { $title = '';	};
  
            if (!empty($title) && function_exists('hcc_symb_replace') ) {
              $title = hcc_symb_replace( $title, '%enter%', '<br />' );
              $title = hcc_symb_replace( $title, '%color_start%', '<span class="color_el">' );
              $title = hcc_symb_replace( $title, '%color_end%', '</span>' );
              $title = hcc_symb_replace( $title, '%start_size%', '<span class="size_el">' );
              $title = hcc_symb_replace( $title, '%end_size%', '</span>' );
            }
            
            return '<'.$tag.' class="'.$class.'">'. $title .'</'.$tag.'>';    
}
/*
 *  Get acf subtitle with tags
 *  @param $class return html class of tag element
 *  @param $element is a parent element 
 *  Function return first child element with block_title ACF id in $element
 */    
function hcc_get_acf_title( $element, $class = '' ){
            $tag   = $element['tag'];
            $title = wp_kses_post( $element['block_title'] );
            if (empty($tag)) { $tag = 'div';	};
            if (empty($title)) { $title = '';	};
  
            if (!empty($title) && function_exists('hcc_symb_replace') ) {
              $title = hcc_symb_replace( $title, '%enter%', '<br />' );
              $title = hcc_symb_replace( $title, '%color_start%', '<span class="color_el">' );
              $title = hcc_symb_replace( $title, '%color_end%', '</span>' );
              $title = hcc_symb_replace( $title, '%start_size%', '<span class="size_el">' );
              $title = hcc_symb_replace( $title, '%end_size%', '</span>' );
            }
            
            return '<'.$tag.' class="'.$class.'">'. $title .'</'.$tag.'>';    
}
/*
 *  Get acf subtitle with tags
 *  @param $class return html class of tag element
 *  @param $element is a parent element 
 *  Function return first child element with block_title ACF id in $element
 */    
function hcc_get_acf_sub_title( $element, $class = '' ){
            $tag   = $element['sub_tag'];
            $title = wp_kses_post( $element['block_sub_title'] );
            if (empty($tag)) { $tag = 'div'; };
            if (empty($title)) { $title = ''; };
  
            if (!empty($title) && function_exists('hcc_symb_replace') ) {
              $title = hcc_symb_replace( $title, '%enter%', '<br />' );
              $title = hcc_symb_replace( $title, '%color_start%', '<span class="color_el">' );
              $title = hcc_symb_replace( $title, '%color_end%', '</span>' );
              $title = hcc_symb_replace( $title, '%start_size%', '<span class="size_el">' );
              $title = hcc_symb_replace( $title, '%end_size%', '</span>' );
            }
            
            return '<'.$tag.' class="'.$class.'">'. $title .'</'.$tag.'>';    
}
/*
 * Google map key
 *
 */
if( !empty( API_KEY ) ){
    function hcc_acf_google_map_api( $api ){
        $api['key'] = API_KEY; 
        return $api;
    }
    add_filter('acf/fields/google_map/api', 'hcc_acf_google_map_api');
}
