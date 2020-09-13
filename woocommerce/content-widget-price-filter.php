<?php
/**
 * The template for displaying product price filter widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-price-filter.php
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.1
 */

defined( 'ABSPATH' ) || exit;

$request_url = explode('?', ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] )[0];
$symbol      = get_woocommerce_currency_symbol();

do_action( 'woocommerce_widget_price_filter_start', $args ); ?>

<form method="get" action="<?php echo esc_url( $form_action ); ?>">
    <div class="price_get_label d-inline-block">
        <div class="from d-inline">
          <?php $link = ( !empty( $current_min_price ) ) ? $request_url . '?min_price=' . $current_min_price : $request_url; ?>
          <a href="<?php echo esc_url( $link ); ?>">
            <?php echo esc_attr( $current_min_price ) . ' ' . $symbol; ?>
          </a>
        </div>
        &mdash;
        <div class="to d-inline">
          <?php $link = ( !empty( $current_min_price )) ? $request_url . '?max_price=' . $current_max_price : $request_url; ?>
          <a href="<?php echo esc_url( $link ); ?>">
            <?php echo esc_attr( $current_max_price ) . ' ' . $symbol; ?>
          </a>
        </div>
    </div>
	<div class="price_slider_wrapper">
		<div class="price_slider" style="display:none;"></div>
		<div class="price_slider_amount d-flex flex-column align-items-start" data-step="<?php echo esc_attr( $step ); ?>">
		    <div class="price_label" style="display:none;">
				<span class="from"></span> &mdash; <span class="to"></span>
			</div>
			<input type="text" id="min_price" name="min_price" value="<?php echo esc_attr( $current_min_price ); ?>" data-min="<?php echo esc_attr( $min_price ); ?>" placeholder="<?php echo esc_attr__( 'Min price', 'woocommerce' ); ?>" />
			<input type="text" id="max_price" name="max_price" value="<?php echo esc_attr( $current_max_price ); ?>" data-max="<?php echo esc_attr( $max_price ); ?>" placeholder="<?php echo esc_attr__( 'Max price', 'woocommerce' ); ?>" />
			<?php /* translators: Filter: verb "to filter" */ ?>
			<button type="submit" class="button ml-auto mr-auto d-block"><?php echo esc_html__( 'Filter', 'woocommerce' ); ?></button>
			<?php echo wc_query_string_form_fields( null, array( 'min_price', 'max_price', 'paged' ), '', true ); ?>
			<div class="clear"></div>
		</div>
	</div>
</form>

<?php do_action( 'woocommerce_widget_price_filter_end', $args ); ?>
