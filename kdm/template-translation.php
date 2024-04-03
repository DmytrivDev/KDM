<?php
/**
 * Template name: Сторінка Трансляції
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package kdm
 */

get_header('none');

$event = get_field('podiya');
$acclink = get_permalink( get_option('woocommerce_myaccount_page_id') );
$type = get_field('typ_podiyi', $event);
$stream = get_field('streem', $event);
$upper = $type['label'];
$title = get_the_title($event);
$status = get_field('status_podiyi', $event);
$newDate = strtotime(get_field('data_podiyi', $event));
$date = date_i18n("H:i", $newDate);
?>

  <script>
      document.addEventListener("contextmenu", function(event) {
          event.preventDefault();
      });
  </script>
    <div class="translation__cont">
        <div class="trans__top flex">
            <?php
            if(is_user_logged_in()) {
                ?>
              <a href="<?php echo $acclink; ?>" class="trans__bacl">
                <span>Особистий кабінет</span>
              </a>
                <?php
            } else {
                ?>
              <a href="<?php echo get_home_url(); ?>" class="trans__bacl">
                <span>Головна сторінка</span>
              </a>
                <?php
            }
            ?>

        </div>
        <div class="translation__main">
            <div class="container">
                <?php
                if($status == 'processing' || $status == 'panding' || $status == 'testing') {

                    if(is_user_logged_in()) {
                        $userId =  get_current_user_id();


                        if ( wc_customer_bought_product( '', $userId, $event) ) {
                            if($stream && $status != 'testing') {
                              ?>

                              <div class="transcont__top">
                                <div class="trans__toptitle">
                                    <?php echo $upper; ?>
                                </div>
                                <h1 class="trans__title">
                                    <?php echo $title; ?>
                                </h1>
                              </div>

                              <div class="trans__body flex">
                                <div class="trans__videocont">
                                  <div class="transvideo__inner trreck__inner">
                                    <div class="disablenfo"><a href="#" onclick="fullScreen($(this))" class="fullscreenV"></a></div>
                                    <iframe width="560" height="315" src="//www.youtube.com/embed/<?php echo $stream; ?>?modestbranding=1&autohide=1&showinfo=0&fs=0" frameborder="0" sandbox="allow-scripts allow-same-origin"></iframe>
                                  </div>
                                </div>
                                <div class="trans__chatcont">
                                    <?php echo do_shortcode('[wp_chat_window id='.$event.']')?>
                                </div>
                              </div>

                                <?php
                            } else {
                                if($status != 'testing') {
                                    $dateF = date_i18n("d.m.Y H:i", $newDate);
                                    ?>
                                  <div class="translation__empty">
                                    <div class="tre__top">
                                      Очікуйте початок трансляції
                                    </div>
                                    <div class="tre__title">
                                      Орієнтовний час почтаку <?php echo $dateF; ?>
                                    </div>
                                    <div class="tre__bottom">
                                      Якщо трансляція вже мала б початись - спробуйте перезавантажити сторінку
                                    </div>
                                  </div>
                                    <?php
                                }
                            }

                            if($status == 'testing') {
                                $orderUrl = '';

                                $args = array(
                                    'customer_id' => $userId,
                                    'limit' => -1,
                                    'post_status' => array_keys(wc_get_order_statuses())
                                );
                                $customer_orders = wc_get_orders($args);

                                foreach ( $customer_orders as $order ) {
                                    $order_status  = $order->get_status();

                                    if($order_status == 'completed') {
                                        foreach ($order->get_items() as $item_key => $item ) {
                                            $product = $item->get_product();
                                            $idProd = $product->get_id();

                                            if($idProd == $event) {
                                                $orderUrl = $order->get_view_order_url().'?tab=test';
                                            }
                                        }
                                    }
                                }
                              ?>
                                <div class="trans__body">
                                  <div class="translation__empty">
                                    <div class="tre__top">
                                      Трансляція вже закінчилась
                                    </div>
                                    <div class="tre__title">
                                      Ви можете пройти тест по цій події щоб отримати сертифікат
                                    </div>
                                    <a href="<?php echo $orderUrl; ?>" class="button green full transem__btn">
                                      <span>Пройти тест</span>
                                    </a>
                                    <div class="tre__bottom less__emt">
                                      Тест та запис трансляції буде доступний в вашому особистому кабінеті
                                    </div>
                                  </div>
                                </div>
                                <?php
                            }
                            ?>



                            <?php
                        } else {
                          $eventUrl = get_permalink($event);
                          ?>
                          <div class="trans__body flex">
                            <div class="translation__empty">
                              <div class="tre__top">
                                Ви ще не купили трансляцію
                              </div>
                              <div class="tre__title">
                                Можете придбати квиток і дивитись трансляцію
                              </div>
                              <a href="<?php echo $eventUrl; ?>" class="button green full transem__btn">
                                <span>Купити квиток</span>
                              </a>
                            </div>
                          </div>
                            <?php
                        }
                        ?>



                        <?php
                    } else {
                      ?>
                      <div class="trans__body flex">
                        <div class="translation__empty">
                          <div class="tre__top">
                            Трансляція недоступна
                          </div>
                          <div class="tre__title">
                            Увійдіть в особистий кабінет
                          </div>
                          <a href="#" class="button green full transem__btn lrm-login">
                            <span>Виконати вхід</span>
                          </a>
                        </div>
                      </div>
                        <?php
                    }
                    ?>

                    <?php
                } else {
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => -1,
                        'order' => 'asc',
                        'meta_query' => array(
                            array(
                                'key' => 'podiya_vidbulas',
                                'value' => '1',
                                'compare' => 'NOT IN',
                            )
                        )
                    );
                    $loop = new WP_Query( $args );
                    $arrayDates = array();

                    while ( $loop->have_posts() ) : $loop->the_post();
                       $idPr = get_the_ID();
                       $date = get_field('data_podiyi', $idPr);
                       $newDate = date("Y-m-d", strtotime($date));

                        $arrayDates[] = $newDate;
                    endwhile;
                    $minDate = min($arrayDates);
                  ?>
                    <div class="translation__empty">

                      <div class="tre__top">
                        У даний момент немає активної трансляції
                      </div>
                      <div class="tre__title">
                          <?php
                          if($minDate) {
                              $theDate = date("d.m.Y", strtotime($minDate));
                              ?>
                            Найближча трансляція запланована на <?php echo $theDate; ?>
                              <?php
                          } else {
                              ?>
                            Слідкуйте за оновленнями на сайті
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
    </div>


<?php
get_footer('none');