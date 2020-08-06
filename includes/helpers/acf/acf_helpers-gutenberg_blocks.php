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
    //Project Bloks
    acf_register_block( 
		array(
			'name'						=> 'main_banner',
			'title'						=> __('Main banner', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/main_banner-block.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			'post_types'			=> array('page'),
		));
    acf_register_block( 
		array(
			'name'						=> 'site_adv',
			'title'						=> __('We offer', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/site_adv-block.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			'post_types'			=> array('page'),
		));
    acf_register_block( 
		array(
			'name'						=> 'site_price',
			'title'						=> __('Our prices', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/site_price-block.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			'post_types'			=> array('page'),
		));
    acf_register_block( 
		array(
			'name'						=> 'site_action',
			'title'						=> __('Actions', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/site_action-block.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			'post_types'			=> array('page'),
		));
    acf_register_block( 
		array(
			'name'						=> 'site_portfolio',
			'title'						=> __('Portfolio', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/site_portfolio-block.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			'post_types'			=> array('page'),
		));
    acf_register_block( 
		array(
			'name'						=> 'site_reviews',
			'title'						=> __('Reviews', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/site_reviews-block.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			'post_types'			=> array('page'),
		));
     acf_register_block( 
		array(
			'name'						=> 'work_scheme',
			'title'						=> __('Work scheme', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/work_scheme-block.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			'post_types'			=> array('page'),
		));
     acf_register_block( 
		array(
			'name'						=> 'site_faq',
			'title'						=> __('FAQ', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/site_faq-block.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			'post_types'			=> array('page'),
		));
    acf_register_block( 
		array(
			'name'						=> 'site_addon',
			'title'						=> __('Text & image block', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/site_addon-block.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			'post_types'			=> array('page'),
		));
    acf_register_block( 
		array(
			'name'						=> 'site_text',
			'title'						=> __('Text block', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/site_text-block.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			'post_types'			=> array('page'),
		));
    acf_register_block( 
		array(
			'name'						=> 'site_contacts',
			'title'						=> __('Contacts', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/site_contacts-block.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			'post_types'			=> array('page'),
		));
}

