<?php
/* Register ACF blocks for gutenberg
* https://www.advancedcustomfields.com/resources/blocks/
* https://www.advancedcustomfields.com/resources/acf_register_block_type/
*/
if( function_exists('acf_register_block') || function_exists('acf_register_block_type') ) {
	add_action('init', 'hcc_register_acf_block_types');
}

function hcc_register_acf_block_types() {
    //Example
    acf_register_block( 
		array(
			'name'						=> 'contact_form',
			'title'						=> __('Contact form', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/FILE_NAME.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			// 'post_types'			=> array('post', 'page'),
		));
}

