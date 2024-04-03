<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

$order_status  = $order->get_status();
$order_id  = $order->get_id();

foreach ($order->get_items() as $item_key => $item ):
    $product = $item->get_product();
    $id = $product->get_id();
    $item_name = $product->get_name();

    //Type
    $type = get_field('typ_podiyi', $id);
    $typeK = $type['value'];
    $isCourse = false;

    if($typeK == 'course') {
        $isCourse = true;
    }

    $orderDate = $order->get_date_created();
    $backUrl = $order->get_view_order_url();
    $curDate = strtotime(current_datetime()->format('Y-m-d'));

    if(!$isCourse) {
        $vidoe = get_field('zapys_podiyi', $id);
        $disabled1 = get_field('video_zablokovane', $id);
        $agreeTest = true;
        $access = true;
        $dayEccess = get_field('podiya_dostupna', $id);

        $orderDateStr = strtotime($orderDate);
        $dateEv = get_field('data_podiyi', $id);
        $dateEvSt = strtotime($dateEv);

        $testDate = get_field('data_zakinchennya_testu', $id);
        $dateTE = date('Y-m-d', strtotime($dateEv. ' + '.$testDate.' days'));
        $dateTESt = strtotime($dateTE);
        $orderDateStrD = date_i18n("Y-m-d", $orderDateStr);
        $orderDateStrM = strtotime($orderDateStrD);

        if($orderDateStrM > $dateTESt) {
            $agreeTest = false;
        }

        if($dayEccess > 0) {
            $endDate = date('Y-m-d', strtotime($dateEv. ' + '.$dayEccess.' days'));
            $mustActive = false;

            if($orderDateStrM > $dateTESt) {
                $endDate = date('Y-m-d', strtotime($orderDate. ' + '.$dayEccess.' days'));
                $mustActive = true;
                $backUrl = wc_get_endpoint_url( 'orders' );
                $agreeTest = false;

            }

            $dateTheEnd = strtotime($endDate);
            $theEndDateFormat = date('d.m.Y', strtotime($endDate));

            if($curDate > $dateTheEnd) {
                $access = false;
            }
        }

        //Chat date
        $chatDate = strtotime(get_field('chat_dostupnyj_do', $id));
        $chatIs = true;

        if($chatDate && $curDate > $chatDate) {
            $chatIs = false;
        }
    } else {
        $agreeTest = true;
        $backUrl = 'https://gynecology.com.ua/my-account/courses/';
    }



    if($order_status == 'completed') {
      ?>
      <script>
          document.addEventListener("contextmenu", function(event) {
              event.preventDefault();
          });
      </script>
      <div class="view__tabs">
          <?php
          if(!$isCourse) {
            ?>
            <div class="view__tab <?php if($mustActive) { echo 'mustActive'; } ?>" id="translation">
                <?php
                if($access) {
                    if($vidoe) {
                        ?>
                      <div class="record__top">
                        <a href="<?php echo $backUrl; ?>" class="backto__acc back__toview">Повернутись</a>
                        <div class="record__to">
                            <?php
                            if($theEndDateFormat) {
                                ?>
                              Запис трансляції доступний до <?php echo $theEndDateFormat; ?>
                                <?php
                            } else {
                                echo 'Запис трансляції доступний необмежений час';
                            }
                            ?>

                        </div>
                        <h1 class="record__ttle">
                            <?php echo $item_name; ?>
                        </h1>
                      </div>
                      <div class="record__main">
                          <?php
                          if(!$disabled1) {
                              ?>
                            <div class="record__video course__minfo">
                              <div class="record__videoinner trreck__inner">
                                <div class="disablenfo"><a href="#" onclick="fullScreen($(this))" class="fullscreenV"></a></div>
                                <iframe width="560" height="315" src="//www.youtube.com/embed/<?php echo $vidoe; ?>?modestbranding=1&autohide=1&showinfo=0&fs=0" frameborder="0" sandbox="allow-scripts allow-same-origin"></iframe>
                              </div>
                            </div>
                              <?php
                          } else {
                              ?>
                            <div class="record__video course__minfo">
                              <div class="record__videoinner trreck__inner">
                                <div class="iframevideo">
                                  <img src="https://i3.ytimg.com/vi/<?php echo $vidoe; ?>/maxresdefault.jpg" alt="" class="cover">
                                  <a href="https://www.youtube.com/watch?v=<?php echo $vidoe; ?>" target="_blank" class="button full big">
                                    <span>Переглянути відео</span>
                                  </a>
                                </div>
                              </div>
                            </div>
                              <?php
                          }

                          if($chatIs) {
                              ?>
                            <div class="trans__chatcont record__chatcont">
                                <?php echo do_shortcode('[wp_chat_window id='.$id.']')?>
                            </div>
                              <?php
                          } else {
                              ?>
                            <div class="trans__chatcont record__chatcont chatDisabled">
                                <?php echo do_shortcode('[wp_chat_window id='.$id.']')?>
                            </div>
                              <?php
                          }
                          ?>

                          <?php
                          $addInfo = get_field('dodatkova_informacziya', $id);
                          $addDocks = get_field('dodatkovi_metodychni_materialy', $id);

                          if($addInfo || $addDocks) {
                              ?>
                            <div class="viev__additionalcont">
                                <?php
                                if($addInfo) {
                                    ?>
                                  <div class="viewadd__part">
                                    <h3 class="viewadd__title">
                                      Додаткова інформація
                                    </h3>
                                    <div class="viewadd__textblock">
                                      <div class="viewadd__textinner text__wrapp">
                                          <?php echo $addInfo; ?>
                                      </div>
                                    </div>
                                  </div>
                                    <?php
                                }

                                if($addDocks) {
                                    ?>
                                  <div class="viewadd__part">
                                    <h3 class="viewadd__title">
                                      Додаткові методичні матеріали
                                    </h3>
                                    <ul class="library__list flex">
                                        <?php while ( have_rows('dodatkovi_metodychni_materialy', $id) ) : the_row();
                                            $name = get_sub_field('nazva_dokumentu');
                                            $url = get_sub_field('posylannya');
                                            $type = get_sub_field('typ_dokumentu');
                                            $typeL = $type['value'];
                                            $typeV = $type['label'];
                                            $typeT = $typeV;
                                            $typeC = 'transparent';

                                            if($typeL == 'yt' || $typeL == 'kdm') {
                                                $typeT = '';
                                            }

                                            if($typeL == 'pdf') {
                                                $typeC = '#F15642';
                                            } else if($typeL == 'doc') {
                                                $typeC = '#334CA8';
                                            } else if($typeL == 'kdm') {
                                                $typeC = '#43AE4E';
                                            }
                                            ?>

                                          <li class="library__item">
                                            <div class="library__itemtop flex">
                                              <a href="<?php echo $url; ?>" target="_blank" class="library__icon">
                                                <span style="background-color: <?php echo $typeC; ?>;" class="library__dockname <?php echo $typeL; ?>"><?php echo $typeT; ?></span>
                                              </a>
                                              <a href="<?php echo $url; ?>" class="library__name"><?php echo $name; ?></a>
                                            </div>
                                          </li>

                                        <?php
                                        endwhile; ?>

                                    </ul>
                                  </div>
                                    <?php
                                }
                                ?>


                            </div>
                              <?php
                          }
                          ?>

                      </div>
                        <?php
                    } else {
                        ?>
                      <div class="record__top test__topP">
                        <a href="<?php echo $backUrl; ?>" class="backto__acc back__toview">Повернутись</a>
                        <h2 class="record__ttle">
                          Запис трансляції
                        </h2>
                      </div>
                      <div class="test__container flex">
                        <div class="test__content flex">
                          <div class="notaxx__top">
                            Відбувається завантаження запису на сайт
                          </div>
                          <div class="notaxx__title">
                            Запис трансляції поки недоступний
                          </div>
                        </div>
                      </div>
                        <?php
                    }
                    ?>
                    <?php
                } else {
                    ?>
                  <div class="record__top test__topP">
                    <a href="<?php echo $backUrl; ?>" class="backto__acc back__toview">Повернутись</a>
                    <h2 class="record__ttle">
                      Запис трансляції
                    </h2>
                  </div>
                  <div class="test__container flex">
                    <div class="test__content flex">
                      <div class="notaxx__top">
                        У вас закінчився термін доступу
                      </div>
                      <div class="notaxx__title">
                        Запис цієї події більше не доступний
                      </div>
                    </div>
                  </div>
                    <?php
                }
                ?>
            </div>
              <?php
          } else {
              $coursDays = get_field('podiya_dostupna', $id);
              $orderDateTime = new DateTime($orderDate->date('Y-m-d H:i:s'));
              $orderDateTime->add(new DateInterval('P' . $coursDays . 'D'));
              $accessibleDate = strtotime($orderDateTime->format('Y-m-d'));
              $formattedDate = date_i18n('d F Y', $accessibleDate);
              $courseAnable = true;
              $sertUrl = get_field('posylannya', $order_id);

              if($curDate > $accessibleDate) {
                  $courseAnable = false;
              }
              if($courseAnable) {
                  if( have_rows('glavy_копіювати', $id) ):
                      $count = count(get_field('glavy_копіювати', $id));
                      while ( have_rows('glavy_копіювати', $id) ) : the_row();
                          $index = get_row_index();
                          $name = get_sub_field('glava');
                          ?>
                        <div class="view__tab" id="chapter<?php echo $index; ?>">
                          <div class="record__top">
                            <a href="<?php echo $backUrl; ?>" class="backto__acc back__toview">Повернутись</a>
                            <h1 class="record__ttle">
                              <?php echo $name;?>
                            </h1>
                            <div class="course__mobikebav">
                                <?php
                                if($index > 1) {
                                  ?>
                                  <a href="#chapter<?php echo $index - 1; ?>" onclick="changeOrderTab($(this))" class="chapter__link chapter__prev">
                                    Глава <?php echo $index - 1; ?>
                                  </a>
                                  <?php
                                }
                                ?>
                              <div class="current__chap">
                                Глава <?php echo $index; ?>
                              </div>
                                <?php
                                if($index < $count) {
                                    ?>
                                  <a href="#chapter<?php echo $index + 1; ?>" onclick="changeOrderTab($(this))"
                                     class="chapter__link chapter__next">
                                    Глава <?php echo $index + 1; ?>
                                  </a>
                                    <?php
                                } else {
                                  if(!$sertUrl) {
                                    ?>
                                    <a href="#test" onclick="changeOrderTab($(this))" class="chapter__link chapter__next">
                                      Тест
                                    </a>
                                    <?php
                                  } else {
                                      ?>
                                    <a href="#sertificate" onclick="changeOrderTab($(this))" class="chapter__link chapter__next">
                                      Сертифікат
                                    </a>
                                      <?php
                                  }
                                }
                                ?>
                            </div>
                          </div>
                          <div class="record__main mainParts">
                              <?php
                              if( have_rows('chastyny_glavy') ) {
                                  while (have_rows('chastyny_glavy')) : the_row();

                                      if (get_row_layout() == 'video') {
                                        $zag = get_sub_field('zagolovok');
                                        $vidoe = get_sub_field('id_video');
                                        $disabled = get_sub_field('video_zablokovane');
                                          ?>
                                          <div class="course__mpart">
                                              <?php
                                              if($zag) {
                                                  ?>
                                                <h3 class="viewadd__title course__title">
                                                    <?php echo $zag; ?>
                                                </h3>
                                                  <?php
                                              }

                                              if(!$disabled) {
                                                ?>
                                                <div class="record__video course__minfo">
                                                  <div class="record__videoinner trreck__inner">
                                                    <div class="disablenfo"><a href="#" onclick="fullScreen($(this))" class="fullscreenV"></a></div>
                                                    <iframe width="560" height="315" src="//www.youtube.com/embed/<?php echo $vidoe; ?>?modestbranding=1&autohide=1&showinfo=0&fs=0" frameborder="0" sandbox="allow-scripts allow-same-origin"></iframe>
                                                  </div>
                                                </div>
                                                <?php
                                              } else {
                                                ?>
                                                <div class="record__video course__minfo">
                                                  <div class="record__videoinner trreck__inner">
                                                    <div class="iframevideo">
                                                      <img src="https://i3.ytimg.com/vi/<?php echo $vidoe; ?>/maxresdefault.jpg" alt="" class="cover">
                                                      <a href="https://www.youtube.com/watch?v=<?php echo $vidoe; ?>" target="_blank" class="button full big">
                                                        <span>Переглянути відео</span>
                                                      </a>
                                                    </div>
                                                  </div>
                                                </div>
                                                <?php
                                              }
                                              ?>
                                          </div>
                                          <?php
                                      } elseif (get_row_layout() == 'text') {
                                          $zag = get_sub_field('zagolovok');
                                          $text = get_sub_field('dodatkova_informacziya');
                                          ?>
                                        <div class="course__mpart">
                                            <?php
                                            if($zag) {
                                                ?>
                                              <h3 class="viewadd__title course__title">
                                                  <?php echo $zag; ?>
                                              </h3>
                                                <?php
                                            }
                                            ?>
                                          <div class="viewadd__textblock course__minfo">
                                            <div class="viewadd__textinner text__wrapp">
                                                <?php echo $text; ?>
                                            </div>
                                          </div>
                                        </div>
                                          <?php
                                      } elseif (get_row_layout() == 'docks') {
                                          $zag = get_sub_field('zagolovok');
                                          ?>
                                        <div class="course__mpart">
                                            <?php
                                            if($zag) {
                                              ?>
                                              <h3 class="viewadd__title course__title">
                                                  <?php echo $zag; ?>
                                              </h3>
                                              <?php
                                            }
                                            ?>
                                          <ul class="library__list third course__minfo flex">
                                              <?php while ( have_rows('dodatkovi_metodychni_materialy') ) : the_row();
                                                  $name = get_sub_field('nazva_dokumentu');
                                                  $url = get_sub_field('posylannya');
                                                  $type = get_sub_field('typ_dokumentu');
                                                  $typeL = $type['value'];
                                                  $typeV = $type['label'];
                                                  $typeT = $typeV;
                                                  $typeC = 'transparent';

                                                  if($typeL == 'yt' || $typeL == 'kdm') {
                                                      $typeT = '';
                                                  }

                                                  if($typeL == 'pdf') {
                                                      $typeC = '#F15642';
                                                  } else if($typeL == 'doc') {
                                                      $typeC = '#334CA8';
                                                  } else if($typeL == 'kdm') {
                                                      $typeC = '#43AE4E';
                                                  }
                                                  ?>

                                                <li class="library__item">
                                                  <div class="library__itemtop flex">
                                                    <a href="<?php echo $url; ?>" target="_blank" class="library__icon">
                                                      <span style="background-color: <?php echo $typeC; ?>;" class="library__dockname <?php echo $typeL; ?>"><?php echo $typeT; ?></span>
                                                    </a>
                                                    <a href="<?php echo $url; ?>" class="library__name"><?php echo $name; ?></a>
                                                  </div>
                                                </li>

                                              <?php
                                              endwhile; ?>

                                          </ul>
                                        </div>
                                          <?php
                                      }

                                  endwhile;

                              } else {
                                ?>
                                <div class="no__orders">
                                  Матеріали відсутні
                                </div>
                                <?php
                              }
                              ?>
                          </div>
                        </div>
                      <?php
                      endwhile;
                  endif;
              }
          }
          ?>

          <?php
          if($agreeTest) {
            $userId = get_current_user_id();
            $testMark = get_field('oczinka', $order_id);
            $sertNum = get_field('id', $order_id);
            $status = get_field('status_podiyi', $id);
            $sertUrl = get_field('posylannya', $order_id);

              ?>
            <div class="view__tab" id="test">
              <div class="record__top test__topP">
                <a href="<?php echo $backUrl; ?>" class="backto__acc back__toview">Повернутись</a>
                <h2 class="record__ttle">
                  Онлайн тест
                </h2>
              </div>
              <div id="testCont" class="test__container flex">
                <div class="test__content start__testcont flex">
                    <?php
                    if(!$sertUrl) {
                      if(!$isCourse) {
                          if($status == 'panding' || $status == 'processing') {
                              ?>
                            <div class="notaxx__top">
                              Тест ще не доступний
                            </div>
                            <div class="notaxx__title">
                              Зачекайте закінчення семінару
                            </div>
                              <?php
                          }
                      }

                      if($status == 'testing' || $isCourse) {
                        $t1 = 'за семінаром';
                        if($isCourse) {
                            $t1 = 'по курсу';
                        }
                        ?>
                        <div class="test__uppertitle">
                          Онлайн тест <?php echo $t1;?>:
                        </div>
                        <div class="test__title">
                            <?php
                            echo $item_name;
                            ?>
                        </div>
                          <?php
                          $field1 = get_user_meta($userId, 'billing_speciality', true);
                          $field2 = get_user_meta($userId, 'billing_place', true);
                          $field3 = get_user_meta($userId, 'billing_post', true);
                          $field4 = get_user_meta($userId, 'billing_date', true);
                          $fst = 1;

                          if($field1 && $field2 && $field3 && $field4) {
                              $fst = 0;
                          }
                          ?>
                          <a href="#" data-id="<?php echo $id; ?>" data-fst="<?php echo $fst; ?>" data-order="<?php echo $order_id; ?>" onclick="startTest($(this))" class="test__startbtn button green full">
                              <span>Пройти тест</span>
                          </a>
                        <?php
                      }

                        if($status == 'compleet') {
                            ?>
                          <div class="notaxx__top">
                            Тест вже не доступний
                          </div>
                          <div class="notaxx__title">
                            На жаль, ви не встигли пройти тест
                          </div>
                            <?php
                        }

                    } else {
                      ?>
                      <div class="test__content flex">
                        <div class="test__result">
                          Ви відповіли правильно на <?php echo $testMark; ?>% питань
                        </div>
                        <div class="test__restext">
                          Вітаємо! Ви успішно пройшли онлайн тест
                        </div>
                        <div class="test__successcont">
                          <a href="<?php echo $sertUrl; ?>" download="<?php echo $sertNum; ?>" class="testsert__btn button green full">
                            <span>Завантажити сертифікат</span>
                          </a>
                          <a href="<?php echo $sertUrl; ?>" class="test__sertview" target="_blank">Переглянути сертифікат</a>
                          <div class="test__account">
                            Сертифікат також доступний у вашому <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">особистому кабінеті</a>
                          </div>
                        </div>
                      </div>
                      <?php
                    }
                    ?>
                </div>
              </div>
            </div>
            <div class="view__tab" id="sertificate">
              <div class="record__top test__topP">
                <a href="<?php echo $backUrl; ?>" class="backto__acc back__toview">Повернутись</a>
                <h2 class="record__ttle">
                  Сертифікат
                </h2>
              </div>
              <div class="test__container flex">
                  <?php
                  if($testMark) {
                      $t2 = 'за онлайн семінар';
                      if($isCourse) {
                          $t2 = 'по курсу';
                      }
                      ?>
                    <div class="test__content flex">
                      <div class="sertp__num">
                        Номер сертифікату: <?php echo $sertNum; ?>
                      </div>
                      <div class="sertp__title">
                        Вам доступний сертифікат <?php echo $t2; ?> на тему:
                      </div>
                      <div class="sertp__under">
                          <?php
                          echo $item_name;
                          ?>
                      </div>
                      <div class="test__successcont">
                        <a href="<?php echo $sertUrl; ?>" download="<?php echo $sertNum; ?>" class="testsert__btn button green full">
                          <span>Завантажити сертифікат</span>
                        </a>
                        <a href="<?php echo $sertUrl; ?>" class="test__sertview" target="_blank">Переглянути сертифікат</a>
                        <div class="test__account">
                          Сертифікат також доступний у вашому <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">особистому кабінеті</a>
                        </div>
                      </div>
                    </div>
                      <?php
                  } else {
                    if(!$isCourse) {
                        if($status == 'panding' || $status == 'processing') {
                            ?>
                          <div class="notaxx__top">
                            Щоб отримати сертифікат потрібно пройти тест
                          </div>
                          <div class="notaxx__title">
                            Тест ще не доступний
                          </div>
                            <?php
                        }
                    }

                      if($status == 'testing' || $isCourse) {
                          ?>
                        <div class="test__uppertitle">
                          Щоб отримати сертифікат потрібно пройти тест
                        </div>
                        <div class="test__title">
                            Пройдіть тест
                        </div>

                        <a href="#test" onclick="changeOrderTab($(this))" class="test__startbtn button green full">
                          <span>Пройти тест</span>
                        </a>
                          <?php
                      }

                      if($status == 'compleet') {
                          ?>
                        <div class="notaxx__top">
                          Щоб отримати сертифікат потрібно пройти тест
                        </div>
                        <div class="notaxx__title">
                          На жаль, ви не встигли пройти тест
                        </div>
                          <?php
                      }
                  }
                  ?>
              </div>
            </div>
              <?php
          }
          ?>

      </div>
      <?php
    } else {
      ?>
      <div class="test__container flex">
        <div class="test__content flex">
          <div class="notaxx__top">
            Ваше замовлення не дійсне
          </div>
          <div class="notaxx__title">
            У вам немає цього замовлення, або воно не ваше
          </div>
        </div>
      </div>
      <?php
    }

    ?>




<?php
endforeach;
?>
