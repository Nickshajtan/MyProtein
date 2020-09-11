<?php
/*
 * WP cron ( or PHP cron ) tasks
 *
 */

add_filter( 'cron_schedules', 'hcc_cron_add_custom_time' );
function hcc_cron_add_custom_time( $schedules ) {
    $time = get_option('options_cron_time');
    $time = ( !empty( $time ) ) ? explode( ':', $time ) : null;
    $time = ( !is_null( $time ) && is_array( $time ) ) ? $time[2] + $time[1] * 60 + $time[0] * 3600 : 259200;
	$schedules['cpt_copy'] = array(
		'interval' => $time,
		'display'  => __('Произольный временной промежуток. По умолчанию три дня', 'hcc'),
	);
	return $schedules;
}

add_action( 'admin_head', 'hcc_cpt_insert_cron' );
function hcc_cpt_insert_cron() {
  if( ! wp_next_scheduled( 'hcc_shares_insert' ) ) {
    wp_schedule_event( time(), 'cpt_copy', 'hcc_shares_insert');	
  }
  
  if( ! wp_next_scheduled( 'hcc_reviews_insert' ) ) {
    wp_schedule_event( time(), 'cpt_copy', 'hcc_reviews_insert');
  }
}

// For shares archive page
add_action('init', 'hcc_shares_insert');
function hcc_shares_insert() {
  $tags = array();
  
  foreach( get_terms( array( 'product_tag') ) as $tag ) {
    $tag = (object) $tag;
    array_push( $tags, $tag->slug );
  }
  
  if( !empty( $tags ) && is_array( $tags ) ) {
    $shares = wp_slash( query_posts( array(
        'post_type' => array( 'product' ),
        'tax_query' => array(
              'relation' => 'OR',
              array(
                  'taxonomy'         => 'product_tag',
                  'field'            => 'slug',
                  'terms'            => $tags,
                  'operator'         => 'IN',
                  'include_children' => false,
              )
          )
      ) ) );
    
    if( !empty( $shares ) && is_array( $shares ) ) {
      foreach( $shares as $post ) {
        $args   = array(
          'comment_status' => 'closed',
          'post_author'    => $post->post_author,
          'post_content'   => wp_kses_post( $post->post_content ),
          'post_name'      => wp_strip_all_tags( $post->post_name ),
          'post_title'     => wp_strip_all_tags( $post->post_title ),
          'post_date'      => $post->post_date,
          'post_date_gmt'  => $post->post_date_gmt,
          'post_status'    => 'publish',
          'post_type'      => 'shares',
          'tax_input'      => array( 'product_tag' => $tags ),
          'meta_input'     => array(
            'cpt_settings'  => get_post_meta( $post->ID, 'cpt_settings', true ),
            '_cpt_settings' => get_post_meta( $post->ID, '_cpt_settings', true ),
            '_cpt_settings_date_picker' => get_post_meta( $post->ID, '_cpt_settings_date_picker', true ),
            'cpt_settings_date_picker'  => get_post_meta( $post->ID, 'cpt_settings_date_picker', true ),
            '_cpt_settings_cpt_btn'  => get_post_meta( $post->ID, '_cpt_settings_cpt_btn', true ),
            'cpt_settings_cpt_btn'   => get_post_meta( $post->ID, 'cpt_settings_cpt_btn', true ),
            '_cpt_settings_event_type'   => get_post_meta( $post->ID, '_cpt_settings_event_type', true ),
            'cpt_settings_event_type'    => get_post_meta( $post->ID, 'cpt_settings_event_type', true ),
            '_thumbnail_id'              => get_post_meta( $post->ID, '_thumbnail_id', false )[0],
          ),
        );
        
        $isset_share = get_page_by_title( $post->post_title, 'OBJECT', array('shares') );
        if( isset( $isset_share ) ) {
          $args['ID'] = $isset_share->ID;
        }
        
        $result = wp_insert_post($args, true);
        
        if( is_wp_error($result) ){
          add_action('admin_notices', function(){
            echo '<div class="error notice-error"><p>' .  $result->get_error_message() . '</p></div>';
          });
        }
      }
    }
    
    wp_reset_query();
  }
}

// For reviews archive page
function hcc_reviews_insert() {
  $args = array(
    'number'       => '',
    'orderby'      => 'comment_date',
    'order'        => 'DESC',
    'status'       => 'approve',
    'type'         => 'comment',
    'post_type'    => 'product',
    'count'        => false,
    'fields'       => '',
    'hierarchical' => false, 
  );
  $comments   = wp_slash( get_comments( $args ) );
  unset( $args );
  
  if( !empty( $comments ) && ( is_array( $comments ) || is_object( $comments ) ) ) {
    
    foreach( $comments as $comment ){
      $args   = array(
          'comment_status' => 'closed',
          'post_author'    => get_user_by( 'login', $comment->comment_author )->ID,
          'post_content'   => wp_kses_post( strip_tags( $comment->comment_content ) ),
          'post_title'     => wp_kses_post( get_the_title( $comment->comment_post_ID ) ),
          'post_date'      => $comment->comment_date,
          'post_date_gmt'  => $comment->comment_date_gmt,
          'post_status'    => 'publish',
          'post_type'      => 'reviews',
          'meta_input'     => array(
            'type'      => 'comment',
            'shop_link' => get_permalink( $comment->comment_post_ID ),
          ),
      );
    
      $isset_review = get_page_by_title( wp_kses_post( get_the_title( $comment->comment_post_ID ) ), 'OBJECT', array('reviews') );
      if( isset( $isset_review ) ) {
          $args['ID'] = $isset_review->ID;
      }
      
      $result = wp_insert_post($args, true);

      if( is_wp_error($result) ){
        add_action('admin_notices', function(){
          echo '<div class="error notice-error"><p>' .  $result->get_error_message() . '</p></div>';
        });
      }
    }
  }
}
