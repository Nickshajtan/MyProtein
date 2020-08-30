<?php 
/*
 * Additional functions & hooks for WOO
 *
 *
 */ 

// before & after 
//remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
//remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

//add_action('woocommerce_before_main_content', 'hcc_wrapper_start', 10);
function hcc_wrapper_start() {}

//add_action('woocommerce_after_main_content', 'hcc_wrapper_end', 10);
function hcc_wrapper_end() {}
