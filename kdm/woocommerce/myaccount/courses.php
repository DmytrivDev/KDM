<?php

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
  Курси
</div>

<div class="orders__list">
    <?php if ( $customer_orders ) {
        $curDate = strtotime(current_datetime()->format('Y-m-d'));
        ?>

        <?php
        foreach ( $customer_orders as $order ) {
            $orderId = $order->get_id();
            $item_count = $order->get_item_count() - $order->get_item_count_refunded();
            $order_status  = $order->get_status();
            $transId = get_field('storinka_translyacziyi', 'options');
            $transUrl = get_permalink($transId);
            $orderDate = $order->get_date_created();

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

                        if($typeK != 'course') {
                            $showHere = false;
                        }

                        //Sertificate
                        $sertUrl = get_field('posylannya', $orderId);

                        if($showHere) {
                            //Item info
                            $item_name    = $product->get_name();
                            $image_id  = $product->get_image_id();
                            $image_url = wp_get_attachment_image_url( $image_id, 'medium' );
                            $upper = $type['label'];
                            $orderUrl = $order->get_view_order_url();
                            $coursDays = get_field('podiya_dostupna', $id);
                            $orderDateTime = new DateTime($orderDate->date('Y-m-d H:i:s'));
                            $orderDateTime->add(new DateInterval('P' . $coursDays . 'D'));
                            $accessibleDate = strtotime($orderDateTime->format('Y-m-d'));
                            $formattedDate = date_i18n('d F Y', $accessibleDate);
                            $courseAnable = true;

                            if($curDate > $accessibleDate) {
                                $courseAnable = false;
                            }
                            ?>

                          <div class="order">
                            <div class="order__top flex">
                              <div class="order__main flex <?php echo $topClass; ?>">

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

                                  <div class="order__actions">
                                    <div class="actions__top courseActions flex">
                                        <?php
                                        if($courseAnable) {
                                            ?>
                                          <a href="<?php echo $orderUrl; ?>/?tab=chapter1" class="button green full record__button courseBtn">
                                            Перейти до курсу
                                          </a>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        if(!$sertUrl) {
                                            ?>

                                          <a href="<?php echo $orderUrl; ?>/?tab=test" class="test__button button green border black">
                                            <span>Пройти тест</span>
                                          </a>

                                            <?php
                                        }

                                        if($courseAnable) {
                                            ?>
                                          <div class="test__help">
                                            Курс доступний до <?php echo $formattedDate; ?> р. включно
                                          </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                  </div>

                                </div>

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
        У вас поки немає придбаних курсів
      </div>

        <?php
    }

    ?>

</div>
