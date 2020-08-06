<?php
/*
 * Create new category for ACF blocks
 *
 */

$hcc_remove_gtn_widgets = true;
if( $hcc_remove_gtn_widgets === true ) {
  add_filter( 'block_categories', 'hcc_acf_block_categories', 10, 2 );
  add_filter( 'allowed_block_types', 'hcc_allowed_block_types', 10, 3  );
}

function hcc_acf_block_categories( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'acf-blocks',
				'title' => __( 'ACF blocks', 'hcc' ),
				'icon'  => 'vault',
			),
		)
	);
}
function hcc_allowed_block_types( $allowed_blocks, $post  ) {
    $registered_blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();
    // Disable Widgets Blocks
    unset($registered_blocks['core/calendar']);
    unset($registered_blocks['core/legacy-widget']);
    unset($registered_blocks['core/rss']);
    unset($registered_blocks['core/search']);
    unset($registered_blocks['core/tag-cloud']);
    unset($registered_blocks['core/latest-comments']);
    unset($registered_blocks['core/archives']);
    unset($registered_blocks['core/categories']);
    unset($registered_blocks['core/latest-posts']);
    unset($registered_blocks['core/shortcode']);
    
    $registered_blocks = array_keys($registered_blocks);
	return array_merge(
        array('acf/acf-blocks',), $registered_blocks
	);
}
