<?php
/*
 * Set up a Network WP-Admin page for managing turning on and off theme features. Example
 *
 * @https://codex.wordpress.org/Function_Reference
 * @link https://wp-kama.ru/function-cat/multisaytovost
 * @link https://misha.blog/wordpress-codex/multisayt
 */

if( is_multisite() ){
    add_action( 'network_admin_menu', 'hcc_theme_add_network_options_page' );
}
function hcc_theme_add_network_options_page(){
    $option_page = add_theme_page(
		__('Network HCC Options', 'hcc'),
		__('Network HCC Options', 'hcc'),
		'manage_options',
		'hcc-network-options',
		'hcc_network_options_page'
	);

	// Call register settings function
	add_action( 'admin_init', 'hcc_theme_network_options' );
    // Call to page assets
    add_action( 'admin_print_scripts-' . $option_page, 'hcc_mu_assets' );
}

/*
 * Assets for Multisite
 * 
 */
add_action( 'admin_init', 'hcc_mu_assets_init' );
function hcc_mu_assets_init(){
    wp_register_script( 'hcc_mu_script', '', array(), null, true );
    wp_register_style( 'hcc_mu_style', '');
}

function hcc_mu_assets(){
     wp_enqueue_script( 'hcc_mu_script' );
     wp_enqueue_style( 'hcc_mu_style' );
}

/*
 * Register settings for the Network WP-Admin page. Example
 * 
 */
function hcc_theme_network_options(){
    add_network_option(null, 'hcc-network-one', '');
    add_network_option(null, 'hcc-network-two', '');
    add_network_option(null, 'hcc-network-three', '');
    
    $sites = get_sites();
    foreach( $sites as $site ){
        if( is_main_site() ){
            add_site_meta( get_main_site_id(), 'hcc-main-site', '', true );
        }
        else{
            add_site_meta( $site['ID'], 'hcc-' . $site['ID'] . '-site', '', true );
        }
    }
}

/*
 * Build the Network WP-Admin settings page. Example
 * 
 */
function hcc_network_options_page() {
    global $pagenow;
    echo '<div class="wrap"><form method="post" enctype="multipart/form-data" action="options.php">'; ?>
    <table class="form-table">
			<tr valign="top">
				<th><?php echo __('HCC Network settngs', 'hcc'); ?></th>
				<td>
                    <p class="description"></p>
                    <ul>
                        <li>
                            <label for="hcc-network-one"></label>
                            <input id="hcc-network-one" name="hcc-network-one" type="text" value="<?php echo get_network_option('hcc-network-one'); ?>" />
                        </li>
                        <li>
                            <label for="hcc-network-two"></label>
                            <input id="hcc-network-two" name="hcc-network-two" type="text" value="<?php echo get_network_option('hcc-network-two'); ?>" />
                        </li>
                        <li>
                            <label for="hcc-network-three"></label>
                            <input id="hcc-network-three" name="hcc-network-three" type="text" value="<?php echo get_network_option('hcc-network-three'); ?>" />
                        </li>
                    </ul>
                </td>
            </tr>
            <tr>
				<th><?php echo __('HCC Sites Options', 'hcc'); ?></th>
				<td>
                    <p class="description"></p>
                    <?php $sites = get_sites();
                    if( $sites ) : ?>
                    <ul>
                        <?php foreach( $sites as $site ) : 
                            if( is_main_site() ) : ?>
                                <li>
                                    <label for="hcc-main-site"></label>
                                    <input id="hcc-main-site" name="hcc-main-site" type="text" value="<?php echo get_site_meta('hcc-main-site'); ?>" />
                                </li>
                            <?php else : ?>
                                <li>
                                    <label for="<?php echo 'hcc-' . $site['ID'] . '-site'; ?>"></label>
                                    <input id="<?php echo 'hcc-' . $site['ID'] . '-site'; ?>" name="<?php echo 'hcc-' . $site['ID'] . '-site'; ?>" type="text" value="<?php echo get_site_meta('hcc-' . $site['ID'] . '-site'); ?>" />
                                </li>
                            <?php endif;
                        endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </td>
            </tr>
    </table>
    <div style="clear: both;">
                <?php submit_button(null, 'primary'); ?>
                <input type="hidden" name="hcc-settings-submit" value="Y" />
    </div>
    <?php echo '</form></div>';
}
