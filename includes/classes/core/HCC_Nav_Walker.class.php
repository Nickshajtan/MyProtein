<?php
/**
 * Create custom menu template
 * Walker_Nav_Menu class inheritance
 *
 * @link: https://developer.wordpress.org/reference/classes/walker_nav_menu/
 */
namespace Core;

class HCC_Nav_Walker extends \Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		global $wp_query;           
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        
        //LI
        $class_names = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
        
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';
        
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
        
        $output .= $indent . '<li' . $id . $value . $class_names .'>';
        
        //LINKS
        $atts = array();
        $atts['title']     = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target']    = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']       = ! empty( $item->xfn )        ? $item->xfn        : '';
        
		$matches	  = '';
        $tag          = preg_match('#%(.*?)%#', $item->url, $matches, PREG_OFFSET_CAPTURE);
        $tag_matches  = ( isset( $matches[0] ) && !is_null( $matches[0] ) && !$matches[0] == false ) ? str_replace( '%', '', $matches[0] ) : '';
        $item_url     = str_replace( 'https://%', '', $item->url );
        $item_url     = str_replace( 'http://%', '', $item_url );
        $item_url     = str_replace( $tag_matches.'%', '', $item_url );
        
        if( $tag_matches === 'home' && $tag !== false ){
            
            if( ( !is_home() && !is_front_page() && ! empty( $item_url ) ) ){
                 $atts['href'] = ( strpos( $item_url, '#' ) !== false ) ? esc_url( home_url() ) . $item_url : $item_url;
            }
            else{
                 $atts['href'] = ! empty( $item_url )        ? $item_url       : '';
            }
            
        }
        elseif( $tag !== false && $tag_matches !== '' ){
            
            if( ! empty( $item->url )  &&  strpos( $item->url, $tag_matches ) !== false ){
                $atts['href'] = ( strpos( $item_url, '#' ) !== false ) ? esc_url( home_url('/') ) . $tag_matches . '/' . $item_url : $item_url;
            }
            else{
                $atts['href'] = ! empty( $item->url )        ? $item_url        : '';
            }
        
        }
        else{
                 $atts['href'] = ! empty( $item->url )        ? $item_url        : '';
        }
        
        
        $anchor = ( strpos( $item->url, '#' ) !== false ) ? 'inside-link' : 'outside-link';
        $atts['class']     = $anchor . ' nav-link nav-link-' . $item->ID . ( $depth > 0 ? 'sub-menu-link' : '' );
        
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
        
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
              if ( ! empty( $value ) ) {
                  $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                  $attributes .= ' ' . $attr . '="' . $value . '"';
              }
        }
        
        $title = apply_filters( 'the_title', $item->title, $item->ID );
        
        $item_output = $args->before;
        $item_output .= '<a id="link-item-' . $item->ID . '"' . $attributes . '>';  
        $item_output .= $args->link_before . $title . $args->link_after;
        if (strpos($class_names, 'has-children')){
            $item_output .= '</a>';
        }
        else{
            $item_output .= '</a>';   
        }
        $item_output .= $args->after;
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}