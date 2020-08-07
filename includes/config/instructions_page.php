<?php
/*
 * Add page with instructions files for admins & moderators
 *
 */
$instructions_page = get_option('hcc-theme-admin-instructions');
if( $instructions_page ) {
    add_action('admin_menu', 'hcc_theme_instructions');
}

function hcc_theme_instructions(){
    add_menu_page( __('Theme Instructions', 'hcc'), __('Instructions', 'hcc'), 'edit_pages', 'hcc-instructions', 'hcc_instructions_page', 'dashicons-welcome-learn-more', 100);
    function hcc_instructions_page(){
        ?>
	    <div class="wrap">
	        <form method="post" enctype="multipart/form-data" action="<?php echo admin_url(); ?>/admin.php?page=hcc-instructions">
                <h2 align="left"><?php echo get_admin_page_title() ?></h2>
                <?php if( get_current_screen()->parent_base !== 'hcc-instructions' ){
                                            settings_errors();
                }
                ?>
                <table class="form-table">
                  <caption align="left" valign="top"></caption>
                  <theader></theader>
                  <tbody>
                       <tr>
                           <th><h2><?php echo __('Files list', 'hcc'); ?></h2></th>
                       </tr>
                       <tr><td width="100%"><p class="description"><b><?php echo __('Online viewing of documents depends on your personal browser and device settings.', 'hcc'); ?></b></p></td></tr>
                        <tr>
                                <?php
                                if( function_exists('hcc_get_mime_files_extension') ){
                                    $files_ext = [ 'xls', 'xlsx', 'pdf', 'txt', 'docx', 'doc', 'odt' ];
                                    $types_ext = hcc_get_mime_files_extension( $files_ext );
                                }
                                else{
                                    $types_ext = array('application/pdf', 'application/msword');
                                }
                                $post_attachments = get_posts( array (
                                    'post_type'        => 'attachment',
                                    'post_mime_type'   => $types_ext,
                                    'orderby'          => 'mime_type title', 
                                    'post_status'      => 'inherit',
                                    'order'            => 'ASC',
                                    'suppress_filters' => true
                                )); ?>
                                <td class="files-none"><?php echo '<p>' . __('Files not found', 'hcc') . '</p>'; ?></td>
                                    <?php $dir  = str_replace( '\\', '/', dirname(dirname(dirname(__FILE__))) . '/instructions/' );
                                          if (is_dir($dir)) {
                                              if ($dh = opendir($dir)){
                                                   while (($file = readdir($dh)) !== false) : ?>
                                                       <?php if( $file !== 'index.php' && is_file( $dir . $file ) && filesize( $dir . $file ) > 0 ) : ?>
                                                       <td class="file-column">
                                                           <?php    $link = THEME_URI . '/instructions/' . $file;
                                                                    $post_ext = wp_check_filetype( $file, get_allowed_mime_types() );
                                                                    echo '<style>.files-none{display:none;}</style>';
                                                                    echo '<p><b>' . __('File name: ', 'hcc') . stristr( basename( $file ), '.', true ). '</b>' 
                                                                    . '<p class="description">' .  __('Type: ', 'hcc') . $post_ext['type'] . '</p>'
                                                                    . '<p class="description">' . __('Extension: ', 'hcc') . $post_ext['ext'] . '</p>'
                                                                    . '</p>';
                                                                    echo '<ul class="file-links">';
                                                                    echo '<li>';
                                                                    echo '<a href="' . $link . '" class="button" target="_blank"><span class="dashicons dashicons-media-document"></span>' . __('Open file', 'hcc') . '</a>';
                                                                    echo '</li>';                                
                                                                    echo '<li>';                                
                                                                    echo '<a href="' . $link . '" class="button" target="_blank" download><span class="dashicons dashicons-media-document"></span>' . __('Download file', 'hcc') . '</a>';
                                                                    echo '</li>';
                                                                    echo '</ul>';
                                                           ?>
                                                       </td>
                                                       <?php endif; endwhile;
                                                   }
                                                   closedir($dh);
                                          }
                                    ?>
                                <?php if( $post_attachments ) : ?>
                                <?php foreach ( $post_attachments as $post_attachment ) : ?>
                                <td class="file-column">
                                <?php   $title    = $post_attachment->post_title;
                                        if( strpos('SITE_Guide', $title ) !== false ){
                                            $link     = $post_attachment->guid;
                                            $post_ext = wp_check_filetype( $link, get_allowed_mime_types() );
                                            echo '<p><b>' . __('File name: ', 'hcc') . $title . '</b>' 
                                            . '<p class="description">' .  __('Type: ', 'hcc') . $post_attachment->post_mime_type . '</p>'
                                            . '<p class="description">' . __('Extension: ', 'hcc') . $post_ext['ext'] . '</p>'
                                            . '</p>';
                                            echo '<style>.files-none{display:none;}</style>';
                                            
                                            if( $link ){
                                                echo '<ul class="file-links">';
                                                echo '<li>';
                                                echo '<a href="' . $link . '" class="button" target="_blank"><span class="dashicons dashicons-media-document"></span>' . __('Open file', 'hcc') . '</a>';
                                                echo '</li>';                                
                                                echo '<li>';                                
                                                echo '<a href="' . $link . '" class="button" target="_blank" download><span class="dashicons dashicons-media-document"></span>' . __('Download file', 'hcc') . '</a>';
                                                echo '</li>';
                                                echo '</ul>';
                                            }
                                        }                                        
                                ?>
                                </td>
                                <?php endforeach; endif; ?>
                        </tr>
                        <?php if( current_user_can('edit_theme_options') ) : ?>
                        <tr><td colspan="2"><hr></td></tr>
                        <tr><th><h2><?php echo __('Uploading', 'hcc'); ?></h2></th></tr>
                        <tr>
                            <td width="100%"><p class="description"><b><?php echo __('The document name must contain the constant', 'hcc') . ' <code>' . ' SITE_Guide ' . '</code> ' . __('otherwise the document will not appear in the list.', 'hcc'); ?></b></p></td>
                        </tr>
                        <tr>
                            <td> 
                                    <p class="description"><?php echo __('Upload file and press "Save" to refresh page', 'hcc'); ?></p>
                                    <button class="hcc_upload_file_button button"><?php echo __('Upload file', 'hcc'); ?></button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php submit_button(null, 'primary'); ?>   
                            </td>
                        </tr>
                        <?php endif; ?>
                  </tbody>
                </table>
            </form>
        </div>
   <?php
    }
    /*
     * Set admin notices
     * 
     */
    if( !empty( $_REQUEST['submit'] ) ){
            add_action( 'admin_notices', 'hcc_saved_notice'); 
    }
}