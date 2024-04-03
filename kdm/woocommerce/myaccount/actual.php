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

$isUn = false;
$mode_cookie = isset($_COOKIE['mode']) ? $_COOKIE['mode'] : '';
if($mode_cookie == 1) {
    $isUn = true;
}

if(!$isUn) {
  $tabName = 'Актуальні події';
} else {
    $tabName = 'Актуальні курси';
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
                $transId = get_field('storinka_translyacziyi', 'options');
                $transUrl = get_permalink($transId);

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
                                    $showHere = false;
                                }

                                //Bought date
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
                                if($status == 'testing' && $testDate && $curDate > $dateTESt) {
                                    update_field("status_podiyi","compleet",$id);
                                    $testEnd = false;
                                }

                                //Conditions
                                if($status == 'compleet' || $sertUrl || !$testEnd) {
                                    $showHere = false;
                                }


                                if($showHere) {
                                    //Item info
                                    $item_name    = $product->get_name();
                                    $image_id  = $product->get_image_id();
                                    $image_url = wp_get_attachment_image_url( $image_id, 'medium' );
                                    $upper = $type['label'];
                                    $newDate = strtotime(get_field('data_podiyi', $id));
                                    $date = date_i18n("d F Y о H:i", $newDate);
                                    $orderUrl = $order->get_view_order_url();

                                    //Stream
                                    $streemUrl = get_field('streem', $id);

                                    //Record
                                    $record = get_field('zapys_podiyi', $id);

                                    //Part width
                                    $topClass = '';
                                    if($status != 'panding' && $status != 'processing') {
                                        $topClass = 'partWidth';
                                    }

                                    //Show record
                                    $showRecord = false;
                                    if($status != 'panding' && $status != 'processing' && $record) {
                                        $showRecord = true;
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

                                            <?php
                                            if($showRecord) {
                                                ?>

                                              <div class="order__actions">
                                                <a href="<?php echo $orderUrl; ?>/?tab=translation" class="button green full record__button">
                                                  Запис трансляції
                                                </a>
                                              </div>

                                                <?php
                                            }

                                            if($status == 'panding' || $status == 'processing') {
                                                ?>

                                              <div class="order__actions">
                                                <div class="actions__top flex">

                                                    <?php
                                                    if($status == 'panding' || !$streemUrl) {
                                                        ?>
                                                      <div class="action__button button disable">
                                                        <span>Очікуйте початок</span>
                                                      </div>
                                                        <?php
                                                    }

                                                    if($status == 'processing' && $streemUrl) {
                                                        ?>
                                                      <a href="<?php echo $transUrl; ?>" class="action__button button">
                                                        <span>Трансляція триває</span>
                                                      </a>
                                                        <?php
                                                    }
                                                    ?>

                                                  <div class="trans__date">
                                                    <div class="transd__top">
                                                      Початок:
                                                    </div>
                                                    <div class="transd__date">
                                                        <?php echo $date; ?>
                                                    </div>
                                                  </div>

                                                    <?php
                                                    if($status == 'panding' || !$streemUrl) {
                                                        ?>
                                                      <div class="action__bottom">
                                                        Кнопка стане активною, коли трансляція розпочнеться
                                                      </div>
                                                        <?php
                                                    }

                                                    if($status == 'processing' && $streemUrl){
                                                        ?>
                                                      <a href="" class="action__bottom">
                                                        Натисніть на кнопку, щоб перейти на трансляцію
                                                      </a>
                                                        <?php
                                                    }
                                                    ?>

                                                </div>
                                              </div>

                                                <?php
                                            }
                                            ?>

                                        </div>

                                      </div>

                                        <?php
                                        if($status != 'panding' && $status != 'processing') {
                                            ?>
                                          <div class="order__date">
                                              <?php echo $date; ?>
                                          </div>
                                            <?php
                                        }
                                        ?>

                                    </div>

                                      <?php
                                      if($status == 'testing') {
                                          ?>

                                        <div class="order__bittom flex">
                                          <a href="<?php echo $orderUrl; ?>/?tab=test" class="test__button button green border black">
                                            <span>Пройти тест</span>
                                          </a>
                                          <div class="test__help">

                                              <?php if($testDate) {
                                                  ?>

                                                <div class="test__date">Тест доступний до <?php echo $dateT; ?> включно</div>

                                                  <?php
                                              } ?>

                                            <span>Пройдіть тест, щоб отримати сертифікат про відвідування семінару</span>
                                          </div>
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
            У вас поки немає подій що скоро мають відбутись
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
                              <a href="/my-account/course/?crs=<?php echo $course; ?>" class="test__button button green border black">
                                <span>Перейти до курсу</span>
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
            У вас поки немає курсів для проходження
          </div>

            <?php
        }
    }



    ?>

</div>
