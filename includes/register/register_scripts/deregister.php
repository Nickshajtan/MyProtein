<?php
// Deregister styles for gutenberg editor
if( is_admin() ){
    add_action( 'enqueue_block_assets', 'hcc_de_script' );
    add_action( 'admin_enqueue_scripts', 'hcc_de_script' );
}
function hcc_de_script(){
    wp_dequeue_style('base');
    wp_deregister_style('base');
    wp_dequeue_style('less-head');
    wp_deregister_style('less-head');
    wp_dequeue_style('less-other');
    wp_deregister_style('less-other');
    wp_dequeue_style('less-vendor');
    wp_deregister_style('less-vendor');
    wp_dequeue_style('sass-head');
    wp_deregister_style('sass-head');
    wp_dequeue_style('sass-other');
    wp_deregister_style('sass-other');
    wp_dequeue_style('sass-vendor');
    wp_deregister_style('sass-vendor');
    wp_dequeue_style('scss-head');
    wp_deregister_style('scss-head');
    wp_dequeue_style('scss-other');
    wp_deregister_style('scss-other');
    wp_dequeue_style('scss-vendor');
    wp_deregister_style('scss-vendor');
    wp_dequeue_style('stylus-head');
    wp_deregister_style('stylus-head');
    wp_dequeue_style('stylus-other');
    wp_deregister_style('stylus-other');
    wp_dequeue_style('stylus-vendor');
    wp_deregister_style('stylus-vendor');
}
