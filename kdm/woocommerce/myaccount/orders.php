<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

$user = wp_get_current_user();
$user_id = $user->ID;
$index = 0;

$args = array(
    'customer_id' => $user_id,
    'limit' => -1,
    'post_status' => array_keys(wc_get_order_statuses())
);
$customer_orders = wc_get_orders($args);

$isUn = false;
$mode_cookie = isset($_COOKIE['mode']) ? $_COOKIE['mode'] : '';
if($mode_cookie == 1) {
    $isUn = true;
}

if(!$isUn) {
    $tabName = 'Завершені події';
} else {
    $tabName = 'Завершені курси';
}
?>

<div class="orders__title">
    <?php echo $tabName; ?>
</div>

<div class="orders__list">
<?php

if (!$isUn) {
    if ( $customer_orders ) { ?>

        <?php
        foreach ( $customer_orders as $order ) {
            $orderId = $order->get_id();
            $item_count = $order->get_item_count() - $order->get_item_count_refunded();
            $order_status  = $order->get_status();

            if($order_status == 'completed') {

                foreach ($order->get_items() as $item_key => $item ):
                    //Product info
                    $product = $item->get_product();

                    if($product) {
                        $id = $product->get_id();
                        $post_status = get_post_status($id);

                        if ($post_status == "publish") {
                            $showHere = true;

                            //Type
                            $type = get_field('typ_podiyi', $id);
                            $typeK = $type['value'];

                            if($typeK == 'course') {
                                $showHere = true;
                            }

                            //Bought date
                            $orderDate = $order->get_date_created();
                            $orderDateStr = strtotime($orderDate);
                            $dateEv = get_field('data_podiyi', $id);
                            $dateEvSt = strtotime($dateEv);

                            //Status
                            $status = get_field('status_podiyi', $id);

                            //Sertificate
                            $sertUrl = get_field('posylannya', $orderId);

                            //Test
                            $testDate = get_field('data_zakinchennya_testu', $id);
                            $dateTE = date('Y-m-d', strtotime($dateEv. ' + '.$testDate.' days'));
                            $dateTESt = strtotime($dateTE);
                            $dateT = date_i18n("j F Y", $dateTESt);
                            $curDate = strtotime(current_datetime()->format('Y-m-d'));
                            $testEnd = true;
                            if($status == 'testing' && $testDate && $curDate >= $dateTESt) {
                                update_field("status_podiyi","compleet",$id);
                                $testEnd = false;
                            }

                            //Conditions
                            if($status == 'compleet' || $sertUrl || !$testEnd) {
                                $showHere = false;
                            }


                            if(!$showHere) {
                                //Item info
                                $item_name    = $product->get_name();
                                $image_id  = $product->get_image_id();
                                $image_url = wp_get_attachment_image_url( $image_id, 'medium' );
                                $type = get_field('typ_podiyi', $id);
                                $upper = $type['label'];
                                $newDate = strtotime(get_field('data_podiyi', $id));
                                $date = date_i18n("d F Y о H:i", $newDate);
                                $orderUrl = $order->get_view_order_url();

                                //Record
                                $record = get_field('zapys_podiyi', $id);

                                //Record access
                                $access = true;
                                $dayEccess = get_field('podiya_dostupna', $id);
                                if($dayEccess > 0) {
                                    $orderDate = $order->get_date_created();
                                    $orderDateStr = strtotime($orderDate);
                                    $curDate = strtotime(current_datetime()->format('Y-m-d'));
                                    $dateEv = get_field('data_podiyi', $id);
                                    $dateEvSt = strtotime($dateEv);
                                    $endDate = date('Y-m-d', strtotime($dateEv. ' + '.$dayEccess.' days'));

                                    if($orderDateStr > $dateEvSt) {
                                        $endDate = date('Y-m-d', strtotime($orderDate. ' + '.$dayEccess.' days'));
                                    }

                                    $dateTheEnd = strtotime($endDate);

                                    if($curDate > $dateTheEnd) {
                                        $access = false;
                                    }
                                }
                                ?>

                              <div class="order">
                                <div class="order__top flex">
                                  <div class="order__main flex partWidth">

                                      <?php
                                      if($image_url) {
                                          ?>

                                        <div class="order__thymb">
                                          <img src="<?php echo $image_url; ?>" alt="" class="cover">
                                        </div>

                                          <?php
                                      }
                                      ?>

                                    <div class="order__mainright">
                                      <div class="order__type">
                                          <?php echo $upper; ?>
                                      </div>
                                      <div class="order__name">
                                          <?php echo $item_name; ?>
                                      </div>

                                        <?php
                                        if($record && $access) {
                                            ?>

                                          <div class="order__actions">
                                            <a href="<?php echo $orderUrl; ?>/?tab=translation" class="button green full record__button">
                                              Запис трансляції
                                            </a>
                                          </div>

                                            <?php
                                        }
                                        ?>

                                    </div>
                                  </div>

                                  <div class="order__date">
                                      <?php echo $date; ?>
                                  </div>

                                </div>

                                  <?php
                                  if($sertUrl) {
                                      $sertId = get_field('id', $orderId);
                                      ?>

                                    <div class="order__bittom flex">
                                      <a href="<?php echo $sertUrl; ?>" download="<?php echo $sertId; ?>" class="test__button button border black">
                                        <span>Зантажити сертифікат</span>
                                      </a>
                                      <a href="<?php echo $sertUrl; ?>" target="_blank" class="sert__see">
                                        Переглянути сертифікат
                                      </a>
                                    </div>

                                      <?php
                                  }
                                  ?>

                              </div>

                                <?php
                                $index++;
                            }
                        }
                    }


                endforeach;

            }
        }
        ?>

    <?php }

    if($index == 0) {
        ?>

      <div class="no__orders">
        Ви ще не зробили жодного замовлення
      </div>

        <?php
    }
} else {
    $index = 0;
    if( have_rows('kursy', 'user_'.$user_id) ) {
        while ( have_rows('kursy', 'user_'.$user_id) ) : the_row();
            $course = get_sub_field('kurs');
            $done = get_sub_field('projdeno');

            if($done) {
                $image_id = get_post_thumbnail_id($course);
                $image_url = wp_get_attachment_image_url( $image_id, 'medium' );
                $item_name = get_the_title($course);
                ?>

              <div class="order">
                <div class="order__top flex">
                  <div class="order__main flex">

                      <?php
                      if($image_url) {
                          ?>

                        <div class="order__thymb">
                          <img src="<?php echo $image_url; ?>" alt="" class="cover">
                        </div>

                          <?php
                      }
                      ?>

                    <div class="order__mainright">
                      <div class="order__type">
                        Курс
                      </div>
                      <div class="order__name">
                          <?php echo $item_name; ?>
                      </div>
                      <div class="order__actions">
                        <div class="actions__top flex">
                          <a href="/my-account/course/?crs=<?php echo $course; ?>&tab=test" class="test__button button green border black">
                            <span>Переглянути результат</span>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

                <?php
                $index++;
            }

        endwhile;
    }

    if($index == 0) {
        ?>

      <div class="no__orders">
        У вас поки немає пройдених курсів
      </div>

        <?php
    }
}
?>

</div>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
