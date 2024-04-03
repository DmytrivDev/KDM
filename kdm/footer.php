<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kdm
 */

?>

</div>


<footer id="contact" class="footer point">

    <?php
    $subBtn = get_field('tekst_knopky_pidpysky', 'options');
    $copyright = get_field('tekst_kopirajtu', 'options');
    $copyrightY = get_field('pochatkovyj_rik', 'options');
    ?>

  <div class="container">

      <?php
      if($subBtn) {
          ?>

        <div class="footer__top flex">
          <button sp-show-form="214803" class="button big border sub__btn">
            <span><?php echo $subBtn; ?></span>
          </button>
        </div>

          <?php
      }
      ?>

    <div class="footer__main flex">
      <div class="footer__part">

          <?php the_custom_logo(); ?>

      </div>
      <div class="footer__part">

          <?php
          if( have_rows('kontakty', 'options') ): ?>
            <ul class="footer__contact">
                <?php while ( have_rows('kontakty', 'options') ) : the_row();
                    $link = get_sub_field('posylannya');
                    $name = get_sub_field('tekst');
                    ?>

                  <li>
                    <a href="<?php echo $link; ?>"><?php echo $name; ?></a>
                  </li>

                <?php
                endwhile; ?>
            </ul>
          <?php endif;
          ?>

      </div>
      <div class="footer__part">

          <?php
          if( have_rows('soczialni_merezhi', 'options') ): ?>
            <ul class="header__soc flex">
                <?php while ( have_rows('soczialni_merezhi', 'options') ) : the_row();
                    $icon = get_sub_field('ikonka');
                    $link = get_sub_field('posylannya');
                    $name = get_sub_field('nazva');
                    ?>

                  <li>
                    <a href="<?php echo $link; ?>" target="_blank">
                      <img src="<?php echo $icon; ?>" alt="<?php echo $name; ?>">
                    </a>
                  </li>

                <?php
                endwhile; ?>
            </ul>
          <?php endif;
          ?>

      </div>
    </div>
    <div class="footer__bottom flex">

        <?php
        if($copyright && $copyrightY) {
            ?>

          <div class="copyright">
            © <?php echo $copyrightY; ?>-<?php echo date('Y'); ?> <?php echo $copyright; ?>
          </div>

            <?php
        }


        wp_nav_menu( array(
            'theme_location' => 'menu-3',
            'menu' => 'menu',
            'container'        => 'ul',
            'menu_class'        => 'footer__nav flex',
        ) );
        ?>

    </div>
  </div>
</footer>

<?php
echo do_shortcode('[sendpulse-form id="308"]');
?>

<?php
$transUrl = get_field('storinka_translyacziyi', 'options')->ID;
$eventCur = get_field('podiya', $transUrl);
$isGoing = get_field('status_podiyi', $eventCur);

if($isGoing == 'processing') {
    global $wp_query;
    $pageId = $wp_query->post->ID;

    if($pageId != $transUrl) {
        if(is_user_logged_in()) {
            $userId =  get_current_user_id();
            if ( wc_customer_bought_product( '', $userId, $eventCur) ) {
                ?>
              <a href="<?php echo get_permalink($transUrl); ?>" class="translation__btn">
                <span><span>Трансляція триває</span><span>Дивитись семінар</span></span>
              </a>
                <?php
            }
        }
    }
}

?>

<a href="#top" class="to__top ankor"></a>



<div class="popup carPop" id="gal__popup">
  <div class="popup__content">
    <a href="#gal__popup" onclick="openPopup($(this))" class="popup__close"></a>
    <div class="gallery__carousel owl-carousel owl-theme"></div>
  </div>
</div>


<?php
if(is_product() && is_user_logged_in()) {
    $type = get_field('typ_podiyi');
    $typeK = $type['value'];
    $trial = get_field('vidkryty_probnyj_urok');

    if($typeK == 'course' && $trial) {
        ?>
      <div id="coursePopup" class="newsp__inner popup__cont">
        <div class="newsp__top flex">
          <a href="#" onclick="openCoursePop()" class="newsp__back"></a>
          <span>Пробний урок</span>
        </div>
        <div class="container">
          <div class="newsp__content">
              <?php
              if( have_rows('glavy_копіювати', $id) ):
                  $count = count(get_field('glavy_копіювати'));
                  while ( have_rows('glavy_копіювати') ) : the_row();
                      $index = get_row_index();
                      $name = get_sub_field('glava');
                      if($index == 1) {
                          ?>
                        <h1 class="newsp__title">
                            <?php echo $name;?>
                        </h1>
                        <div class="record__main mainParts">
                            <?php
                            if( have_rows('chastyny_glavy') ) {
                                while (have_rows('chastyny_glavy')) : the_row();

                                    if (get_row_layout() == 'video') {
                                        $zag = get_sub_field('zagolovok');
                                        $vidoe = get_sub_field('id_video');
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
                                        <div class="record__video course__minfo">
                                          <div class="record__videoinner trreck__inner">
                                            <div class="disablenfo"><a href="#" onclick="fullScreen($(this))" class="fullscreenV"></a></div>
                                            <iframe width="560" height="315" src="//www.youtube.com/embed/<?php echo $vidoe; ?>?modestbranding=1&autohide=1&showinfo=0&fs=0" frameborder="0" sandbox="allow-scripts allow-same-origin"></iframe>
                                          </div>
                                        </div>
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
                                        <ul class="library__list course__minfo flex">
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
                          <?php
                      }
                      ?>
                  <?php
                  endwhile;
              endif;
              ?>
          </div>
        </div>
      </div>
        <?php
    }
}
?>





<?php wp_footer(); ?>


</body>
</html>
