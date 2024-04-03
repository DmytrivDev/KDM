<?php
$user = wp_get_current_user();
$user_id = $user->ID;

$crs = isset($_GET['crs']) ? $_GET['crs'] : null;
$courseIs = false;
$backUrl = wc_get_endpoint_url( 'actual' );
$sertUrl = false;
$iterat = 0;

$enabledCourses = [];

if (have_rows('kursy', 'user_' . $user_id)) {
    while (have_rows('kursy', 'user_' . $user_id)) : the_row();
        $course = get_sub_field('kurs');
        $index = get_row_index() - 1;

        if($course == $crs) {
            $courseIs = true;
            $done = get_sub_field('projdeno');
            $iterat = $index;

            if($done) {
                $sertUrl = true;
                $backUrl = wc_get_endpoint_url( 'orders' );
                break;
            }
        }

    endwhile;
}


if($courseIs) {
    $id = $crs;
    $nameCourse = get_the_title($id);
    ?>
  <script>
      document.addEventListener("contextmenu", function(event) {
          event.preventDefault();
      });
  </script>
  <div class="view__tabs">
      <?php
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
                        ?>
                      <a href="#test" onclick="changeOrderTab($(this))" class="chapter__link chapter__next">
                        Тест
                      </a>
                        <?php
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
      ?>

      <?php
      $userId = get_current_user_id();
      $repeater_index = $iterat;
      $current_value = get_field('kursy', 'user_' . $user_id);
      $testMark = 0;


      if (isset($current_value[$repeater_index]['rezultat'])) {
          $testMark = $current_value[$repeater_index]['rezultat'];
      }

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
                $t1 = 'по курсу';
                ?>
              <div class="test__uppertitle">
                Онлайн тест <?php echo $t1;?>:
              </div>
              <div class="test__title">
                  <?php
                  echo $nameCourse;
                  ?>
              </div>
              <a href="#" data-id="<?php echo $id; ?>" data-order="<?php echo $iterat; ?>" onclick="startTest($(this))" class="test__startbtn button green full">
                <span>Пройти тест</span>
              </a>
                <?php

            } else {
                ?>
              <div class="test__content flex">
                <div class="test__result">
                  Ви відповіли правильно на <?php echo $testMark; ?> питань
                </div>
                <div class="test__restext">
                  Вітаємо! Ви успішно пройшли онлайн тест
                </div>
              </div>
                <?php
            }
            ?>
        </div>
      </div>
    </div>

  </div>
    <?php
} else {
    ?>
  <div class="no__orders">
    У вас немає доступу до цього курсу або його не існує
  </div>
    <?php
}
