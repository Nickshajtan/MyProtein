<?php 
/*
 * ACF pages content for TinyMCE & Gutenberg
 */
if( is_page_template( 'templates/template-acf.php' ) || is_page_template( 'templates/template-acf-mixed.php' ) || is_404() || is_page_template( 'templates/template-contacts.php' ) || is_page_template( 'templates/template-privacy.php' ) || is_page_template( 'templates/template-thanks.php' ) ){
    add_filter( 'the_content', 'hcc_content_acf_pages' );
    function hcc_content_acf_pages( $content ){
        global $post;
        $meta = get_post_meta( $post->ID );
        if( !empty( $meta ) || !has_blocks( $content ) ){
            if (get_field('flexible_content')){
                 while (has_sub_field('flexible_content')){
                     $row_layout_slug = get_row_layout();
                     $flexible = get_template_part('template-parts/flexible', $row_layout_slug);
                 }
            }
            return $flexible . $content;
        }else{
            return $content;
        }
    }   
}

