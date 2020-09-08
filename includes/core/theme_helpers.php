<?php

/*
* hide admin bar front-end
*/ 
show_admin_bar( false );

/*
* allow svg files
*/ 
add_filter('upload_mimes', 'cc_mime_types');
function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}

/*
* limit blog intro title
*/
function get_title( $count, $content ) {
	$title = get_the_title();
	if (!empty($content)) {
		$title = $content;
	}
	if (strlen($title)>$count){
		$title = strip_tags($title);
		$title = substr($title, 0, $count);
		$title = substr($title, 0, strripos($title, " "));
		$title = $title.'...';
	}
	return $title;
}

/*
* limit blog intro text
*/
function get_excerpt( $count, $content ) {
	if (!empty($content)) {
		$excerpt = $content;
	} else {
		$excerpt = get_the_excerpt();
		if (empty($excerpt)) {
			$excerpt = get_the_content();
		}
	}
	if (mb_strlen($excerpt) > $count) {
		$excerpt = strip_tags($excerpt);
		$excerpt = mb_substr($excerpt, 0, $count);
		$excerpt = mb_substr($excerpt, 0, strripos($excerpt, " "));
		$excerpt = $excerpt.'...';
	}
	return $excerpt;
}

/*
* Add styles/classes to the "Styles" drop-down
*/
// add_filter( 'tiny_mce_before_init', 'fb_mce_before_init' );
function fb_mce_before_init( $settings ) {

	$style_formats = array(
		array(
			'title' => 'Title H1',
			'selector' => '*',
			'classes' => 'title-h1'
		),
	);
	$settings['style_formats'] = json_encode( $style_formats );
	return $settings;
}


if ( ! function_exists( 'hcc_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function hcc_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'hcc' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'hcc_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function hcc_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'hcc' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'hcc_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function hcc_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'hcc' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'hcc' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'hcc' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'hcc' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'hcc' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'hcc' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'hcc_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function hcc_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;

/**
  * Apply all hooks the_content to get_the_content()
  *
  */
if ( ! function_exists( 'hcc_get_content' ) ) :
  function hcc_get_content(){
      $content = get_the_content( $post -> ID );
      $content = apply_filters( 'the_content', $content );
      $content = str_replace( ']]>', ']]&gt;', $content );
      echo $content;
  }
endif;

/**
  * Site logo: the_custom_logo() & ACF define
  *
  */
if ( ! function_exists( 'hcc_the_custom_logo' ) ) :
  function hcc_the_custom_logo( $logo_id = false, $separator = '|' ){
      $logo_img = '';
      $logo_id  = ( $logo_id === false ) ? SITE_LOGO : $logo_id;

      if( !empty( $logo_id ) ){
          if( is_front_page() || is_home() ){
               $logo_img = '<div class="site-branding">' . $logo_id .'</div>';
          }
          else{
              if( !empty( THEME_HOME_URL) ){
                  $logo_img = '<a href="' . THEME_HOME_URL . '" target="_self" class="site-branding">' . $logo_id .'</a>';       
              }
              else{
                  $logo_img = '<a href="/" target="_self" class="site-branding">' . get_custom_logo() .'</a>';
              }
          }
      }
      else{
          if( $separator ){
              $first    = substr( SITE_NAME, 0, strpos( SITE_NAME, $separator ) );
              $second   = stristr( SITE_NAME, $separator );   
          }
          else{
              $first = SITE_NAME;
              $second = '';
          }

          if( is_front_page() || is_home() ){
              $logo_img = '<div class="site-branding"><span class="main-part">' . $first . '</span>' . '<span class="separator-part"> ' . $second .'</span></div>';
          }
          else{
              $logo_img = '<a href="' . THEME_HOME_URL . '" target="_self" class="site-branding"><span class="main-part">' . $first . '</span>' . '<span class="separator-part"> ' . $second .'</span></a>';
          }
      }
      echo $logo_img;
  }
endif;

/**
 * Returns mime types of file extensions
 *
 * @param array $ files_ext file extensions
 *
 * @return array
 */
if ( ! function_exists( 'hcc_get_mime_files_extension' ) ) :
  function hcc_get_mime_files_extension( $files_ext ) {
      $mimes = get_allowed_mime_types();
      $need_mimes = [];
      foreach ( $files_ext as $file_ext ) {
          foreach ( $mimes as $type => $mime ) {
              if ( false !== strpos( $type, $file_ext ) ) {
                  $need_mimes[] = $mime;
              }
          }
      }

      return $need_mimes;
  }
endif;

/**
 * Return the iframe code with file
 *
 * @param  $width & $hiight are sizes
 * @param  $url is a url of file
 * @return $attr is a constant
 */
add_shortcode('hcc_file_view', 'hcc_file_viewer');
function hcc_file_viewer($attr, $url, $width = '100%', $height = '500px') {
            return '<iframe
                    src="http://docs.google.com/viewer?url=' . $url . '&embedded=true"
                    style="width: ' . $width . '; height: ' . $height . 'px;"
                    frameborder="0">' . __('Your browser does not support frames', 'hcc') .'</iframe>';
}

/*
* Blog archive pagination
*/
if( !function_exists('hcc_pagination_bar') ) :
  function hcc_pagination_bar( $query_wp ) 
  {
      $pages = $query_wp->max_num_pages;
      $big = 999999999; 
      if ($pages > 1)
      {
          $page_current = max(1, get_query_var('paged'));
          echo paginate_links(array(
              'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
              'format'		=> '?paged=%#%',
              'current'		=> $page_current,
              'total'			=> $pages,
              'type'			=> 'list',
              'prev_text'	=> '<',
              'next_text'	=> '>',
          ));
      }
  }
endif;

/*
 * Render pagination : remove title
 *
 */
add_filter('navigation_markup_template', 'hcc_navigation_template', 10, 2 );
function hcc_navigation_template( $template, $class ){
	return '<nav class="navigation %1$s" role="navigation"><div class="nav-links">%3$s</div></nav>';
}

/*
 * Is isset including im file
 * @param $this_file is this file dirname: dirname( __FILE__ )
 * @param $img_src is string
 * @param $sep is string separator
 */
if ( ! function_exists( 'hcc_isset_img' ) ) :
  function hcc_isset_img( $this_file, $sep, $img_src ) {
    if( !isset( $this_file ) || !isset( $img_src ) ) {
      return false;
    }

    $this_file = trim( $this_file ) . '/';
    $img_src   = esc_url( $img_src );
    $img_src   = ( strpos( $img_src, '/' ) === 0 ) ? $img_src : '/' . $img_src;
    $sep       = ( isset( $sep ) ) ? trim( $sep ) : '';
    $abs       = ( defined('THEME_URI') ) ? THEME_URI : get_template_directory_uri();

    $img_isset  =  wp_normalize_path( $this_file . $sep . $img_src );

    if( file_exists( $img_isset ) ) {
      $img_src    =  wp_normalize_path( $abs . $img_src );
      return $img_src;
    }
    return false;
  }
endif;

/*
 * Replace substrings in string value. Return string
 * @param $string is string for search
 * @param $search is needle string
 * @param $replace is string value for replacing
 */
if ( ! function_exists( 'hcc_symb_replace' ) ) :
  function hcc_symb_replace( $string, $search, $replace ) {

    if( empty( $string ) ) {
      return '';
    }

    if( empty( $search ) || empty( $replace ) ) {
      return $string;
    }

    $string  = trim( $string );
    $search  = trim( $search );
    $replace = trim( $replace );

    return str_ireplace( (string)$search,(string)$replace, (string)$string );
  }
endif;

/*
 * Get ACF options array fields via WP get_option function. Wrapper.
 * @param $repeater  is ACF repeater string name
 * @param $subfields is array of ACF subfields names
 * @param $types is boolean. Types add to result array subarray with type of ACF subfield
 * @return array
 */
if ( ! function_exists( 'hcc_get_option_field' ) ) :
  function hcc_get_option_field( $repeater, $subfields, $types = false ) {
    try {
      if( !is_string( $repeater ) || empty( $repeater ) ) {
        throw new Exception(__('Must have $repeater param is not string or empty', 'hcc'));
        return false;
      }

      if( empty( $subfields ) || is_null( $subfields ) || !is_array( $subfields ) ) {
        throw new Exception(__('Must have $subfields param is not array or empty', 'hcc'));
        return false;
      }

      $types  = ( isset( $types ) ) ?(boolean) $types : false;

      $values = array();
      $count  = intval( get_option($repeater, 0) );

      for ( $i=0; $i<$count; $i++) {
        $value[] = array();
        foreach ($subfields as $subfield => $type) {
          if( $types === false ) {
            $value[$subfield] = get_option($repeater.'_'.$i.'_'.$subfield, '');
          }
          else {
            $value[$subfield][$type] = get_option($repeater.'_'.$i.'_'.$subfield, '');
          }
          $value[$subfield] = get_option($repeater.'_'.$i.'_'.$subfield, '');
        }
        $values[] = $value;
      }

      return $values;

    }
    catch( Exception $e ) {
      echo $e;
    }
  }
endif;

/*
 * Set post views
 *
 *
 */
if ( ! function_exists( 'hcc_setPostViews' ) ) :
function hcc_setPostViews( $post_id, $who_count = 1, $exclude_bots = 1 ) {
  add_action('wp_head', function() {
    $meta_key       = 'hcc_views'; // meta key
    $who_count      = $who_count    ? $who_count : 1; // 0 - for all users, 1 for guests, 2 - only for registered
    $exclude_bots   = $exclude_bots ?  $exclude_bots : 1; // 0 - no, 1 - yes
    
    global $user_ID;
    global $post;
    
    if(is_singular()) {
		$id = (int)$post->ID;
		static $post_views = false;
		if($post_views) {
          return true;
        }
		$post_views = (int)get_post_meta($id, $meta_key, true);
		$should_count = false;
		switch( (int)$who_count ) {
			case 0: $should_count = true;
				break;
			case 1:
				if( (int)$user_ID == 0 )
					$should_count = true;
				break;
			case 2:
				if( (int)$user_ID > 0 )
					$should_count = true;
				break;
		}
		if( (int)$exclude_bots==1 && $should_count ){
			$useragent = $_SERVER['HTTP_USER_AGENT'];
			$notbot    = "Mozilla|Opera"; 
			$bot       = "Bot/|robot|Slurp/|yahoo";
			if ( !preg_match("/$notbot/i", $useragent) || preg_match("!$bot!i", $useragent) )
				$should_count = false;
		}

		if($should_count)
			if( !update_post_meta($id, $meta_key, ($post_views+1)) ) add_post_meta($id, $meta_key, 1, true);
	}
	return true;

  });
  echo get_post_meta ($post_id, 'hcc_views', true);
  
}

endif;

/*
 * Admin notices
 *
 */
function hcc_saved_notice(){
    ?>
    <div class="notice notice-success is-dismissible">
                    <p><?php echo __('Saved.', 'hcc'); ?></p>
    </div>
    <?php 
}

function hcc_error_notice(){
    ?>
    <div class="notice notice-success is-dismissible">
                    <p><?php echo __('Error.', 'hcc'); ?></p>
    </div>
    <?php 
}

add_action( 'save_post', 'hcc_clear_cache_notice');
function hcc_clear_cache_notice(){
    if( is_plugin_active('autoptimize/autoptimize.php') || is_plugin_active('w3-total-cache/w3-total-cache.php') || is_plugin_active('clearfy/clearfy.php') ) :
    ?>
    <div class="notice notice-success is-dismissible">
                    <p><?php echo __('Please clear the cache (top menu) to display changes.', 'hcc'); ?></p>
    </div>
    <?php endif;
}
