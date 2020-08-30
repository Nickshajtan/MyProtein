<?php
/*
 * WOO account settings
 *
 */

/*
 * Menu order
 *
 */
add_filter ( 'woocommerce_account_menu_items', 'hcc_account_menu_order' );
function hcc_account_menu_order() {
   $menu_order = array(
 		'orders'             => __( 'Заказы', 'woocommerce' ),
 		'downloads'          => __( 'Загрузки', 'woocommerce' ),
 		'edit-address'       => __( 'Адреса', 'woocommerce' ),
 		'edit-account'       => __( 'Личные данные', 'woocommerce' ),
 		'customer-logout'    => __( 'Выйти', 'woocommerce' ),
        'dashboard'          => __( 'Консоль', 'woocommerce' ),
 	);
 	return $menu_order;
}

/*
 * Login redirect
 *
 */
//add_filter( 'woocommerce_login_redirect', 'hcc_woo_login_redirect' );
function hcc_woo_login_redirect($redirect_to) {
   $redirect_to = wc_customer_edit_account_url();
   return $redirect_to;
}
