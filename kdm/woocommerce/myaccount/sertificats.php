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
?>

<div class="orders__title">
    Мої сертифікати
</div>

<div class="orders__list">
    <?php if ( $customer_orders ) { ?>

        <?php
        foreach ( $customer_orders as $order ) {
            $orderId = $order->get_id();
            $item_count = $order->get_item_count() - $order->get_item_count_refunded();
            $order_status  = $order->get_status();
            $sertUrl = get_field('posylannya', $orderId);
            $sertId = get_field('id', $orderId);

            if($order_status == 'completed') {

                foreach ($order->get_items() as $item_key => $item ):

                    $product = $item->get_product();

                    if($product) {
                        $id = $product->get_id();

                        //Type
                        $type = get_field('typ_podiyi', $id);
                        $typeK = $type['value'];
                        $isCourse = false;

                        if($typeK == 'course') {
                            $isCourse = true;
                        }

                        if($sertUrl) {
                            $item_name    = $product->get_name();
                            ?>

                          <div class="sertificat">
                            <div class="sertificat__top flex">
                              <div class="sertificat__left flex">
                                <div class="sertificat__icon"></div>
                                <div class="sertificat__info">
                                    <?php
                                    $t1 = 'онлайн семінар';
                                    if($isCourse) {
                                        $t1 = 'курс';
                                    }
                                    ?>
                                  <div class="sertificat__upper">
                                    Ви пройшли <?php echo $t1; ?> на тему:
                                  </div>
                                  <div class="sertificat__name">
                                      <?php echo $item_name; ?>
                                  </div>
                                </div>
                              </div>
                              <div class="serificat__actions flex">
                                <a href="<?php echo $sertUrl; ?>" download="<?php echo $sertId; ?>" class="sertificat__button button full green">
                                  <span>Зантажити</span>
                                </a>
                                <a href="<?php echo $sertUrl; ?>" target="_blank" class="sertificat__see">
                                  <span>Переглянути сертифікат</span>
                                </a>
                              </div>
                            </div>
                            <div class="sertificat__id">
                              Номер сертифікату: <?php echo $sertId; ?>
                            </div>
                          </div>

                            <?php
                            $index++;
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
             У вас поки що немає сертифікатів
        </div>

        <?php
    }

    ?>

</div>
