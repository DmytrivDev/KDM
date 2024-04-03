<?php
/**
 * Customer completed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email );
$name = $order->get_billing_first_name();
$lname = $order->get_billing_last_name();
$items = $order->get_items();
foreach ( $items as $item_id => $item ) :
    $product       = $item->get_product();
    $id            = $product->get_id();
    $type = get_field('typ_podiyi', $id);
    $typeK = $type['value'];
    $iscourse = false;

    if($typeK = 'course') {
        $iscourse = true;
    }
    ?>

<?php endforeach;
?>

<?php /* translators: %s: Customer first name */ ?>
  <tr>
    <td valign="middle" style="padding-top: 70px; padding-bottom: 0;">
      <table border="0" width="650" cellpadding="0" cellspacing="0">
        <tr>
          <td valign="middle" align="center">
            <p style="text-align: center; font-size: 21px; line-height: 36px; font-weight: 800; color: #06ac5b; margin: 0;"><?php echo $lname; ?> <?php echo $name; ?>, дякуємо за замовлення!</p>
            <p style="text-align: center; margin-bottom: 0; margin-top: 11px; font-size: 14px; line-height: 24px;">
                <?php
                if(!$iscourse) {
                    ?>
                  Посилання на трансляцію буде доступне у вашому <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" style="color: #1A325C; text-decoration: underline;">особистому кабінеті</a> <br>а також буде надіслане вам на електронну пошту за 2 години до початку
                    <?php
                } else {
                    ?>
                  Матеріали курсу і тестування доступне у вашому <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>/courses" style="color: #1A325C; text-decoration: underline;">особистому кабінеті</a>
                    <?php
                } ?>
            </p>
          </td>
        </tr>
      </table>
    </td>
  </tr>
<?php

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );



/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
