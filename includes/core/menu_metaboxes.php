<?php
/*
*  Register and add a tab in accardion to create a menu
*  @link https://gist.github.com/nikolov-tmw/8698598
*/
add_action( 'admin_head-nav-menus.php', 'hcc_register_meta_box_accordion_nav_menus' );
function hcc_register_meta_box_accordion_nav_menus(){
	add_meta_box( 'hcc-menu-meta-box', __('Menu files', 'hcc'), 'hcc_render_meta_box_accordion_nav_menus', 'nav-menus', 'side', 'default' );
    remove_meta_box( 'add-post-type-post', 'nav-menus', 'side' );
    //remove_meta_box( 'add-post-type-shares', 'nav-menus', 'side' );
    //remove_meta_box( 'add-post-type-reviews', 'nav-menus', 'side' );
    remove_meta_box( 'woocommerce_endpoints_nav_link', 'nav-menus', 'side' );
}
/**
 * Output to the metabox "Files"
 *
 * @param string $ object Not used.
 * @param array $ args Parameters and arguments.
 */
function hcc_render_meta_box_accordion_nav_menus(){
    global $nav_menu_selected_id;
	$files_ext = [ 'xls', 'xlsx', 'pdf', 'zip', 'txt', 'docx', 'doc', 'ppt', 'pptx', 'pps', 'ppsx' ];
    if( function_exists('hcc_get_mime_files_extension') ){
        $types_ext = hcc_get_mime_files_extension( $files_ext );
    }
    else{
        $mimes = get_allowed_mime_types();
        $need_mimes = [];
        foreach ( $files_ext as $file_ext ) {
            foreach ( $mimes as $type => $mime ) {
                if ( false !== strpos( $type, $file_ext ) ) {
                    $need_mimes[] = $mime;
                }
            }
        }
    }
    
	$my_items = get_posts( [
		'numberposts'    => - 1,
		'post_type'      => 'attachment',
		'post_mime_type' => hcc_get_mime_files_extension( $files_ext ),
	] );

	$walker       = new Walker_Nav_Menu_Checklist();
	$removed_args = [
		'action',
		'customlink-tab',
		'edit-menu-item',
		'menu-item',
		'page-tab',
		'_wpnonce',
	]; ?>
	<div id="tab-files-div">
	<div id="tabs-panel-list-files" class="tabs-panel tabs-panel-active">
		<p><?php _e('Отображаются только файлы с расширением', 'hcc'); ?>: <b><?php echo implode( ', ', $files_ext ); ?></b>.</p>

		<ul id="tab-files-checklist-pop" class="categorychecklist form-no-clear">
			<?php echo walk_nav_menu_tree( array_map( 'wp_setup_nav_menu_item', $my_items ), 0, (object) [ 'walker' => $walker ] ); ?>
		</ul>

		<p class="button-controls">
			<span class="list-controls">
				<a href="<?php
				echo esc_url( add_query_arg(
					[
						'list-files' => 'all',
						'selectall'  => 1,
					],
					remove_query_arg( $removed_args )
				) );
				?>#menu-media-files-metabox" class="select-all"><?php _e( 'Select All', 'hcc' ); ?></a>
			</span>

			<span class="add-to-menu">
				<input type="submit"<?php wp_nav_menu_disabled_check( $nav_menu_selected_id ); ?>
					   class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e( 'Add to Menu', 'hcc' ); ?>"
					   name="add-tab-files-menu-item" id="submit-tab-files-div"/>
				<span class="spinner"></span>
			</span>
		</p>
	</div>
	<?php
}

/**
 * Replaces the link to the media page with a link to the media file itself
 *
 * @param string $ link link to the media page
 * @param string $ post_id media ID
 *
 * @return string
 */
add_filter( 'attachment_link', 'hcc_change_attachment_link', 1000, 2 );
function hcc_change_attachment_link( $link, $post_id ) {
	return wp_get_attachment_url( $post_id );
}