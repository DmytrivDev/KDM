<?php
/**
 * Order details table shown in emails.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-details.php.
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

defined( 'ABSPATH' ) || exit;

$text_align = is_rtl() ? 'right' : 'left';

do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email );
$subtota = $order->get_subtotal();
$subtota2 = number_format($subtota, 0);
$tota = $order->get_total();
$disc = $order->get_discount_total();
$disc2 = number_format($disc, 0);
?>


<tr>
  <td valign="middle" style="padding-top: 45px; padding-bottom: 0;">
    <table border="1" width="650" cellpadding="0" cellspacing="0" style="border-radius: 0; border: solid #ececec; padding: 26px;">

        <?php
        echo wc_get_email_order_items( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            $order,
            array(
                'show_sku'      => $sent_to_admin,
                'show_image'    => false,
                'image_size'    => array( 32, 32 ),
                'plain_text'    => $plain_text,
                'sent_to_admin' => $sent_to_admin,
            )
        );
        ?>

      <tr>
        <td style="border: none">
          <table cellpadding="0" cellspacing="0" width="100%" style="border: none">
            <tr>
              <td valign="middle" width="60%" align="left" style="padding: 0; border: none;">
                <p style="margin: 0; margin-right: 15px; display: inline-block; font-size: 14px; line-height: 17px; color: #808080;">Проміжна сумма: <?php echo $subtota2; ?> грн</p>
                  <?php
                  if($disc2) {
                      ?>
                    <p style="margin: 0; display: inline-block; font-size: 14px; line-height: 17px; color: #808080;">Знижка: -<?php echo $disc2; ?> грн</p>
                      <?php
                  }
                  ?>
              </td>
              <td valign="top" width="40%" align="right" style="padding-left: 25px; border: none;">
                <p style="font-size: 14px; line-height: 17px; color: #000; font-weight: 600; margin: 0; text-align: right; width: 100%;">Сплачено: <?php echo $tota; ?> грн</p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </td>
</tr>


<?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>
