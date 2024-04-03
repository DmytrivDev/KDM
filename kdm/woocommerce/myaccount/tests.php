<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

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
?>

<div class="orders__title">
    Мої тести
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
                $sertUrl = get_field('posylannya', $orderId);

                if($order_status == 'completed') {

                    foreach ($order->get_items() as $item_key => $item ):
                        //Product info
                        $product = $item->get_product();

                        if($product) {
                            $id = $product->get_id();
                            $post_status = get_post_status($id);

                            //Type
                            $type = get_field('typ_podiyi', $id);
                            $typeK = $type['value'];
                            $isCourse = false;

                            if($typeK == 'course') {
                                $isCourse = true;
                            }

                            if ($post_status == "publish") {
                                $showHere = true;

                                //Sertificate
                                $sertUrl = get_field('posylannya', $orderId);

                                if(!$isCourse) {
                                    $status = get_field('status_podiyi', $id);

                                    //Bought date
                                    $orderDate = $order->get_date_created();
                                    $orderDateStr = strtotime($orderDate);
                                    $dateEv = get_field('data_podiyi', $id);
                                    $dateEvSt = strtotime($dateEv);

                                    //Test
                                    $testDate = get_field('data_zakinchennya_testu', $id);
                                    $dateTE = date('Y-m-d', strtotime($dateEv. ' + '.$testDate.' days'));
                                    $dateTESt = strtotime($dateTE);
                                    $dateT = date_i18n("j F Y", $dateTESt);
                                    $curDate = strtotime(current_datetime()->format('Y-m-d'));
                                    $testEnd = true;
                                    if($status == 'testing' && $testDate && $curDate > $dateTESt) {
                                        update_field("status_podiyi","compleet",$id);
                                        $testEnd = false;
                                    }

                                    //Conditions
                                    if($status != 'testing' || $sertUrl || !$testEnd) {
                                        $showHere = false;
                                    }
                                } else {
                                    if($sertUrl) {
                                        $showHere = false;
                                    }
                                }

                                if($showHere) {
                                    $item_name    = $product->get_name();
                                    $orderUrl = $order->get_view_order_url();
                                    ?>

                                  <div class="test">
                                    <div class="test__top flex">
                                      <div class="test__left">
                                        <div class="test__upper">
                                          Онлайн тест доступний <?php if($dateT) { echo 'до '; echo $dateT; echo ' включно'; } ?>
                                        </div>
                                        <div class="test__name">
                                            <?php echo $item_name; ?>
                                        </div>
                                      </div>
                                      <a href="<?php echo $orderUrl; ?>/?tab=test" class="thetest__button button full green">
                                        <span>Пройти тест</span>
                                      </a>
                                    </div>
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
            Щоб тести стали доступні, вам потрібно побувати на події
          </div>

            <?php
        }
    } else {
        $index = 0;
        if( have_rows('kursy', 'user_'.$user_id) ) {
            while ( have_rows('kursy', 'user_'.$user_id) ) : the_row();
                $done = get_sub_field('projdeno');

                if(!$done) {
                    $course = get_sub_field('kurs');
                    $image_id = get_post_thumbnail_id($course);
                    $image_url = wp_get_attachment_image_url( $image_id, 'medium' );
                    $item_name = get_the_title($course);
                    ?>

                  <div class="test">
                    <div class="test__top flex">
                      <div class="test__left">
                        <div class="test__upper">
                          Вам доступний тест на тему:
                        </div>
                        <div class="test__name">
                            <?php echo $item_name; ?>
                        </div>
                      </div>
                      <a href="/my-account/course/?crs=<?php echo $course; ?>&tab=test" class="thetest__button button full green">
                        <span>Пройти тест</span>
                      </a>
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
            Щоб тести стали доступні, у вас має бути активний курс
          </div>

            <?php
        }
    }
    ?>


</div>
