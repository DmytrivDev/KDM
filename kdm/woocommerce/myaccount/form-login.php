<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

 ?>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>


<div class="loginPage">
  <p>Ви не авторизовані в особистому кабінеті. Щоб авторизуватись <a href="#" class="lrm-login">увійдіть</a> у вже існуючий особистий кабінет або <a href="#" class="lrm-register">зареєструйтесь</a></p>
  <div class="loginpage__buttons flex">
    <a href="#" class="button green full lrm-login">Увійти</a>
    <a href="#" class="button green full lrm-register">Зареєструватись</a>
  </div>
</div>

<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
