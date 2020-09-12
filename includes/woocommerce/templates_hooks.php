<?php
/*
 * Global template hooks
 * 
 */
get_template_part('includes/woocommerce/hooks/global');

/*
 * Global loop template hooks
 * 
 */
get_template_part('includes/woocommerce/hooks/loop');

/*
 * WOO sidebar template hooks
 * 
 */
get_template_part('includes/woocommerce/hooks/sidebar');

/*
 * WOO categories loop template hooks
 * 
 */
get_template_part('includes/woocommerce/hooks/category', 'loop');

/*
 * WOO categories template page hooks
 * 
 */
get_template_part('includes/woocommerce/hooks/category', 'page');

/*
 * WOO categories item template hooks
 * 
 */
get_template_part('includes/woocommerce/hooks/category', 'item');

/*
 * WOO products item template hooks
 * 
 */
get_template_part('includes/woocommerce/hooks/product', 'item');
