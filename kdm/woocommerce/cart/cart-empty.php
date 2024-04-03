<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
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

/*
 * @hooked wc_empty_cart_message - 10
 */
?>
<div class="cart__mounce">
<?php
do_action( 'woocommerce_cart_is_empty' );

if ( wc_get_page_id( 'shop' ) > 0 ) :

  if(is_user_logged_in()) {
  ?>
  <div class="cartempty__text">
    Щоб переглянути свої покупки - перейдіть в особистий кабінет
  </div>
  <div class="cartempty__buttons flex">
    <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="button green full">
      <span>Особистий кабінет</span>
    </a>
  </div>
    <?php
} else {
    ?>
  <div class="cartempty__text">
    Щоб продовжити свої покупки - перейдіть до списку подій. Також можете увійти у свій особистий кабінет або зареєструватись
  </div>
  <div class="cartempty__buttons flex">
    <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="button green full">
      <span>Переглянути події</span>
    </a>
    <a href="#" class="button green full lrm-login">
      <span>Особистий кабінет</span>
    </a>
  </div>
    <?php
}

endif; ?>
</div>
