<?php
/*
* Register Gutenberg styles & scripts for ACF blocks
*
*/
add_action( 'enqueue_block_editor_assets', 'hcc_myguten_enqueue' );
function hcc_myguten_enqueue(){
	wp_register_script(
		'hcc-acf-guten-script',
		THEME_STYLE_URI . '/includes/helpers/gutenberg/blocks.min.js',
		array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' )
	);
    wp_enqueue_script('hcc-acf-guten-script');
	wp_register_style( 
		'hcc-acf-guten-style', 
		THEME_STYLE_URI . '/assets/public/css/gtb.min.css'
	);
    wp_enqueue_style('hcc-acf-guten-style');
}

/*
* Register Gutenberg styles & scripts with WP Gutenberg Block API
*
*/
add_action( 'enqueue_block_assets', 'hcc_gtb_load_front_end' );
function hcc_gtb_load_front_end(){
    if( !is_admin() ){
        // enqueue frontend only scripts and styles here
        // scripts: array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components' )
        // styles: array( 'wp-edit-blocks' )
    }
}

add_action( 'enqueue_block_editor_assets', 'hcc_gtb_load_admin' );
function hcc_gtb_load_admin(){
    wp_register_script(
        'hcc-guten-script',
        THEME_STYLE_URI . '/includes/helpers/gutenberg/gtn-api.min.js',
        array('wp-blocks','wp-editor', 'wp-dom-ready', 'wp-edit-post'),
		true
    );
    wp_enqueue_script('hcc-guten-script');
    wp_register_style( 
		'hcc-guten-style', 
		THEME_STYLE_URI . '/assets/public/css/gtb-wp.min.css'
	);
    wp_enqueue_style('hcc-guten-style');
}

/*
* Register meta for Gutenberg
*
*/
add_action( 'init', 'hcc_gtb_meta_block_init' );
function hcc_gtb_meta_block_init() {
	register_meta( 'post_type', 'meta_key', array(
		'show_in_rest' => true,
		'single' => true,
	) );
}

/*
* Register Gutenberg blocks with WP Gutenberg Block API
*
*/
add_action('init', 'hcc_register_gtb_blocks');
function hcc_register_gtb_blocks(){
    register_block_type( 'hcc/get-post', array(
       'attributes'      => array(
                'postType' => array(
                    'type'    => 'string',
                    'default' => 'portfolio',
                ),
				'postsPerPage' => array(
					'type'    => 'number',
					'default' => 3,
				),
				'order'        => array(
					'type'    => 'string',
					'default' => 'desc',
				),
        ),
	   'render_callback' => 'hcc_render_block_get_post',
       'editor_script'   => 'hcc-guten-script',
       'category'        => 'hcc-blocks',
    ) );
    function hcc_render_block_get_post( $attribites, $content ) {
        $args = [
			'posts_per_page' => $attributes['postsPerPage'],
			'post_status'    => 'publish',
			'order'          => $attributes['order'],
            'post_type'      => $attributes['postType'],
		];
        $posts = get_posts( $args );
        $html  = '';
        if ( $posts ) {
			$html .= '<div class="wp-block-get-post-wrapper"><ul>';
            foreach ( $posts as $item ) {
                $html .= sprintf( '<li><a class="wp-block-get-post" href="%1$s">%2$s</a></li>', esc_url( get_the_permalink( $item->ID ) ), esc_html( get_the_title( $item->post_title ) ) );
			}
            $html .= '</ul></div>';
        }

		return $html;
    }
}