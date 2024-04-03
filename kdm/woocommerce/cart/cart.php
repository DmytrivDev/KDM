<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="cart__mounce">
    <?php

    do_action( 'woocommerce_before_cart' ); ?>

  <style>
    .section__checkout {
      background-image: url(<?php echo get_template_directory_uri();?>/assets/img/content/event_big.jpg);
    }
  </style>



    <?php do_action( 'woocommerce_after_cart' ); ?>
</div>


