<?php
/*
 * WP cron ( or PHP cron ) tasks
 *
 */
add_filter( 'cron_schedules', 'hcc_cron_add_three_days' );
function cron_add_five_min( $schedules ) {
	$schedules['three_days'] = array(
		'interval' => 60 * 60 * 24 *3,
		'display' => __('Каждые три дня', 'hcc'),
	);
	return $schedules;
}

add_action( 'admin_head', 'hcc_cpt_insert_cron' );
function hcc_cpt_insert_cron() {
  if( ! wp_next_scheduled( 'hcc_shares_insert' ) ) {
		wp_schedule_event( time(), 'three_days', 'hcc_shares_insert');
  }
}

function hcc_shares_insert() {
  $tags = array();
  
  foreach( get_terms( array( 'product_tag') ) as $tag ) {
    $tag = (object) $tag;
    array_push( $tags, $tag->slug );
  }
  
  if( !empty( $tags ) && is_array( $tags ) ) {
    $shares = query_posts( array(
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
      ) );
    
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
            'cpt_settings'  => get_post_meta( $post->ID, 'cpt_settings', false ),
            '_cpt_settings' => get_post_meta( $post->ID, '_cpt_settings', false ),
            '_cpt_settings_date_picker' => get_post_meta( $post->ID, '_cpt_settings_date_picker', false ),
            'cpt_settings_date_picker'  => get_post_meta( $post->ID, 'cpt_settings_date_picker', false ),
            '_cpt_settings_cpt_btn'  => get_post_meta( $post->ID, '_cpt_settings_cpt_btn', false ),
            'cpt_settings_cpt_btn'   => get_post_meta( $post->ID, 'cpt_settings_cpt_btn', false ),
            '_cpt_settings_event_type'   => get_post_meta( $post->ID, '_cpt_settings_event_type', false ),
            'cpt_settings_event_type'    => get_post_meta( $post->ID, 'cpt_settings_event_type', false ),
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
