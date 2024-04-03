<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

$zag = get_field('zag_ch', 'options');
$fon = get_field('fon_ch', 'options');
?>

<style>
  .checkout__top {
    display: none !important;
  }
  .checkout__title {
    display: none !important;
  }
  .checkout__mcont {
    padding: 0 !important;
  }
  .checkout_content {
    padding: 0 !important;
  }
</style>



<section class="section__error">
  <div class="container">
    <div class="error__content flex">
        <?php
        $order_id = absint( get_query_var( 'order-received' ) );
        $order = wc_get_order( $order_id );
        $payment_method = $order->get_payment_method_title();
        $status = $order->get_status();
        if ($status != 'completed') {
            ?>

          <h1 class="error__title">
              Вибачте, але ваша оплата не пройшла. Спробуйте ще раз.
          </h1>

          <a href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) );; ?>" class="button big whiteB border error__button">
            <span>Події</span>
          </a>

            <?php
        } else {
            if($zag) {
                ?>

              <h1 class="error__title">
                  <?php echo $zag; ?>
              </h1>

              <a href="<?php echo get_home_url(); ?>" class="button big whiteB border error__button">
                <span>На головну</span>
              </a>

                <?php
            }
        }
        ?>
        <?php

        ?>
    </div>
  </div>

    <?php
    if($fon) {
        ?>

      <img src="<?php echo $fon; ?>" alt="" class="cover">

        <?php
    }
    ?>

</section>
