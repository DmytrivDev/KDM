<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="shop_table woocommerce-checkout-review-order-table">
	<div>
    <div class="checkout__products">

		<?php
		do_action( 'woocommerce_review_order_before_cart_contents' );
		$index = 0;

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

			    $theId = $_product->get_id();
          $image_id  = $_product->get_image_id();
          $image_url = wp_get_attachment_image_url( $image_id, 'medium' );
          $image_url2 = wp_get_attachment_image_url( $image_id, 'full' );
          $newDate = strtotime(get_field('data_podiyi', $theId));
          $date = date_i18n("d.m.Y о H:i", $newDate);
          $type = get_field('typ_podiyi', $theId);
          $status = get_field('podiya_vidbulas', $theId);
          $typeText = $type['label'];
          $dataText = $date;

          if($status) {
              $dataText = 'Подія відбулась';
          }

          if($index == 0) {
            ?>

            <style>
              .section__checkout {
                background-image: url(<?php echo $image_url2; ?>);
              }
            </style>

              <?php
          }

			  ?>
				<div class="checkout__product">
					<div class="product__left">

              <?php
              if($image_url) {
                  ?>

                <div class="chorid__img">
                  <img src="<?php echo $image_url; ?>" alt="" class="cover">
                </div>

                  <?php
              }
              ?>

            <div class="chprod__namecpnt">
              <div class="chprod__title">
                  <?php echo $typeText; ?>
              </div>
              <div class="chprod__name">
                  <?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) . '&nbsp;'; ?>
              </div>
            </div>
					</div>
          <div class="chprod__middle">
            <div class="chprod__title">
              Дата:
            </div>
            <div class="chprod__date">
              <?php echo $dataText; ?>
            </div>
          </div>
					<div class="product-total">
            <div class="chprod__title">
              Вартість квитка:
            </div>
            <div class="chprod__price">
                <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
					</div>
				</div>
				<?php
			}
        $index++;
		}
		?>

    </div>

      <?php
		do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	</div>
	<div class="chackout__bottom">

    <div class="ccheckout__prices">


        <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
          <div class="cart-subtotal ch__price">
            <div>Проміжна сума:</div>
            <div><?php wc_cart_totals_subtotal_html(); ?></div>
          </div>

          <div class="cart-discount ch__price coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
            <div>Знижка:</div>
            <div><?php wc_cart_totals_coupon_html( $coupon ); ?></div>
          </div>
        <?php endforeach; ?>

        <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

            <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

            <?php wc_cart_totals_shipping_html(); ?>

            <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

        <?php endif; ?>

        <?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

      <div class="order-total ch__price">
        <div>До сплати:</div>
        <div><?php wc_cart_totals_order_total_html(); ?></div>
      </div>
    </div>

    <div class="place-order">
        <?php do_action( 'woocommerce_pay_order_before_submit' ); ?>

        <?php echo apply_filters( 'woocommerce_pay_order_button_html', '<button type="submit" class="button wp-element-button alt' . esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ) . '" id="place_order" value="Підтвердити замовлення" data-value="Підтвердити замовлення">Підтвердити замовлення</button>' ); ?>

        <?php do_action( 'woocommerce_pay_order_after_submit' ); ?>
    </div>



	</div>
</div>
