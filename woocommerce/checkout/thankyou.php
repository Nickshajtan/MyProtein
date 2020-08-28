<?php
/*
 * WOO thank you page template
 * 
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
defined( 'ABSPATH' ) || exit;

if ( $order ) :
  if ( $order->has_status( 'failed' ) ) :
    $text    = esc_html__( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' );
    $classes = esc_attr( 'woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed' );
  else:
    $text    = apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), $order );
    $classes = esc_attr( 'woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received' );
  endif;
else :
  $text    = apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'ВАША ЗАЯВКА ПРИНЯТА!', 'hcc' ), null );
  $classes = esc_attr( 'woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received' );
endif;

$text    = ( !isset( $text ) || !empty( $text ) )    ? $text    : __('ВАША ЗАЯВКА ПРИНЯТА!', 'hcc');
$content = ( !isset( $text ) || !empty( $content ) ) ? $content :  __('В скором времени с Вами свяжется наш оператор для уточнения заказа 🙂', 'hcc'); 

$link_url  = esc_url( get_page_link( wc_get_page_id('shop') ) );
$link_text = esc_html__('ВЕРНУТЬСЯ В МАГАЗИН', 'hcc');

get_header(); ?>

<div class="thanks-page d-flex align-items-center justify-content-center">
  <section class="thanks-page__section woo-thanks">
      <div class="container">
                  <div class="row">
                   
                    <?php if ( $order ) :
		                  do_action( 'woocommerce_before_thankyou', $order->get_id() );
                    ?>
                    <div class="col-12 d-flex align-items-center justify-content-center flex-column thanks-page__content-wrapper woo-thanks__content-wrapper">
                      <?php if( !empty( $text ) ) : ?>
                        <h1 class="text-white page-title thanks-page__title woo-thanks__title <?php echo $classes; ?>"><?php echo $title; ?></h1>
                      <?php endif;
                      if ( $order && !$order->has_status( 'failed' ) ) : ?>
                        <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">
                          <li class="woocommerce-order-overview__order order">
                              <?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
                              <strong><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
                          </li>

                          <li class="woocommerce-order-overview__date date">
                              <?php esc_html_e( 'Date:', 'woocommerce' ); ?>
                              <strong><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
                          </li>

                          <?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
                              <li class="woocommerce-order-overview__email email">
                                  <?php esc_html_e( 'Email:', 'woocommerce' ); ?>
                                  <strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
                              </li>
                          <?php endif; ?>

                          <li class="woocommerce-order-overview__total total">
                              <?php esc_html_e( 'Total:', 'woocommerce' ); ?>
                              <strong><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
                          </li>

                          <?php if ( $order->get_payment_method_title() ) : ?>
                              <li class="woocommerce-order-overview__payment-method method">
                                  <?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
                                  <strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
                              </li>
                          <?php endif; ?>
                        </ul>
                      <?php endif; 
                      if( !empty( $content ) ) : ?>
                        <div class="thanks-page__content woo-thanks__content"><?php echo $content; ?></div>
                      <?php endif; 
                      if( !empty( $link_text ) && !empty( $link_url ) ) :?>
                        <a class="button thanks-page__button" href="<?php echo $link_url; ?>" target="_self">
                          <?php echo $link_text; ?>
                        </a>
                      <?php endif; 
                      if ( $order ) :
                      
                        if ( $order->has_status( 'failed' ) ) : ?>
                        <p class="w-100 d-flex justify-content-between woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                            <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button thanks-page__button woo-thanks__button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
                            <?php if ( is_user_logged_in() ) : ?>
                                <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button thanks-page__button woo-thanks__button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
                            <?php endif; ?>
                        </p>
                        <?php endif;
                        
                        do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() );
                        do_action( 'woocommerce_thankyou', $order->get_id() );
                      endif; ?>
                  
                    </div>
                    
                  </div>
      </div>
  </section>
</div>

<?php get_footer(); ?>