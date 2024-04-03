<?php
/**
 * Email Order Items
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-items.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

$text_align  = is_rtl() ? 'right' : 'left';
$margin_side = is_rtl() ? 'left' : 'right';

foreach ( $items as $item_id => $item ) :
	$product       = $item->get_product();
	$sku           = '';
	$purchase_note = '';
	$image         = '';
	$name          = '';
  $date          = '';
  $price         = '';

	if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
		continue;
	}

	if ( is_object( $product ) ) {
		$id            = $product->get_id();
		$sku           = $product->get_sku();
		$purchase_note = $product->get_purchase_note();
		$image         = $product->get_image( $image_size );
    $image_id      = $product->get_image_id();
    $image         = wp_get_attachment_image_url( $image_id, 'thumbnail' );
    $name          = $product->get_title();
    $newDate       = strtotime(get_field('data_podiyi', $id));
    $date          = date_i18n("d F Y о H:i", $newDate);
    $price         = $product->get_price();
	}

	?>

  <tr>
    <td style="border: none; padding-bottom: 26px;">
      <table cellpadding="0" cellspacing="0" style="border: none; border-bottom: 1px solid #ececec; padding-bottom: 26px;">
        <tr>
          <td valign="middle" width="19%" align="center" style="padding: 0; border: none;">
            <img src="<?php echo $image; ?>" style="width: 100%; height: auto;" alt="">
          </td>
          <td valign="top" width="81%" align="left" style="padding-left: 25px; border: none;">
            <table width="100%" cellpadding="0" cellspacing="0" style="border: none;">
              <tr>
                <td valign="top" width="65%" align="left" style="padding: 0; border: none;">
                  <p style="display: inline-block; font-size: 14px; line-height: 26px; margin: 0; color: #808080;"><?php echo $date; ?></p>
                </td>
                <td valign="top" width="35%" align="right" style="padding: 0; border: none;">
                  <p style="display: inline-block; font-size: 14px; line-height: 26px; margin: 0; color: #808080;"><?php echo $price; ?> грн</p>
                </td>
              </tr>
            </table>
            <p style="font-size: 16px; line-height: 26px; font-weight: 600; margin: 0; margin-top: 7px; color: #000; width: 100%;"><?php echo $name; ?></p>
          </td>
        </tr>
      </table>
    </td>
  </tr>


<?php endforeach; ?>
