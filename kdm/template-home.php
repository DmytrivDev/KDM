<?php
/**
 * Template name: Головна сторінка
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

get_header();
?>


  <section class="section__first">

      <?php
      $zag1 = get_field('zagolovok_1');
      $text1 = get_field('tekst_pid_zagolovkom_1');
      $video1 = get_field('video_1');
      $bg1 = get_field('fon_mob');
      ?>

    <div class="container">
      <div class="first__container">

          <?php
          if($zag1) {
              ?>

            <h1 class="first__title">
                <?php echo $zag1; ?>
            </h1>

              <?php
          }

          if($text1) {
              ?>

            <div class="first__text">
              <p><?php echo $text1; ?></p>
            </div>

              <?php
          }

          $btnText = get_field('knopka_1_tekst_knopky');
          if($btnText) {
              $btnType = get_field('knopka_1_typ_knopky');
              $btnUrl = get_field('knopka_1_storinka');

              if($btnType == 'link') {
                  $btnUrl = get_field('knopka_1_posylannya');
              } else if($btnType == 'ankor') {
                  $btnUrl = '#'. get_field('knopka_1_yakir');
              }

              ?>

            <a href="<?php echo $btnUrl; ?>" class="button border big first__button <?php if($btnType == 'ankor') { echo 'ankor'; } ?>">
              <span><?php echo $btnText; ?></span>
            </a>

              <?php

          }
          ?>


      </div>
    </div>

      <?php
      if(!get_field('dis_2')) {
          ?>

        <a href="#second" class="dirst__arrow ankor">
          <img src="<?php echo get_template_directory_uri();?>/assets/img/icons/arrow.svg" alt="">
        </a>

          <?php
      }

      if($video1) {
          ?>

        <video class="first__video" loop="" autoplay="" muted="">
          <source src="<?php echo $video1; ?>" type="video/mp4">
        </video>

          <?php
      }

      if($bg1) {
          ?>

        <img src="<?php echo $bg1; ?>" alt="" class="first__mobbg cover">

          <?php
      }
      ?>

  </section>


<?php
$dis2 = get_field('dis_2');

if(!$dis2) {
    ?>

  <section id="second" class="section__advent point">
    <div class="container">

        <?php
        if( have_rows('perevagy') ): ?>
          <ul class="advent__list flex">
              <?php while ( have_rows('perevagy') ) : the_row();
                  $title = get_sub_field('zagolovok');
                  $name = get_sub_field('tekst');
                  ?>

                <li class="advent__item">
                  <h3 class="advent__name">
                      <?php echo $title; ?>
                  </h3>
                  <div class="advent__text">
                      <?php echo $name; ?>
                  </div>
                </li>

              <?php
              endwhile; ?>
          </ul>
        <?php endif;
        ?>

    </div>
  </section>

    <?php
}
?>



<?php
$dis3 = get_field('dis_3');

if(!$dis3) {
    $thtle3 = get_field('zag_3');
    $btn3 = get_field('tekst_knopky');
    ?>

  <section id="events" class="section__events point">
    <div class="container">

        <?php
        if($thtle3) {
            ?>

          <h2 class="events__title">
              <?php echo $thtle3; ?>
          </h2>

            <?php
        }
        ?>

      <ul class="events__list flex">
          <?php
          $count = get_field('kilkist_vyvedenyh_podij');
          $the_query = new WP_Query( array(
              'posts_per_page' => $count,
              'order'           => 'ASC',
              'post_type'       => 'product',
              'post_status'     => 'publish',
              'meta_key'        => 'data_podiyi',
              'orderby'         => 'meta_value',
              'meta_query'      => array(
                  'relation'      => 'AND',
                  array(
                      'key'       => 'podiya_vidbulas',
                      'value'     => true,
                      'compare'   => '!=',
                  ),
                  array(
                      'key'       => 'publication_date',
                      'value'     => date('Y-m-d'),
                      'compare'   => 'NOT EXISTS',
                  ),
              ),
              'tax_query'       => array(
                  array(
                      'taxonomy' => 'product_cat',
                      'field'    => 'slug',
                      'terms'    => 'podiyi'
                  ),
              ),
          ));

          if ( $the_query->have_posts() ) :
              while ( $the_query->have_posts() ) : $the_query->the_post();
                  wc_get_template_part( 'content', 'product' );
              endwhile;
              wp_reset_postdata();
          endif;
          ?>
      </ul>

        <?php
        if($btn3) {
            $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
            ?>

          <div class="events__bottom flex">
            <a href="<?php echo $shop_page_url; ?>" class="button full big">
              <span><?php echo $btn3; ?></span>
            </a>
          </div>

            <?php
        }
        ?>

    </div>
  </section>

    <?php
}
?>

<?php
$dis6 = get_field('dis_6');

if(!$dis6) {
    $thtle6 = get_field('zag_6');
    $btn6 = get_field('tekst_knopky_6');
    $btnUrl6 = get_field('posylannya_knopky_6');
    ?>

  <section id="courses" class="section__events point">
    <div class="container">

        <?php
        if($thtle6) {
            ?>

          <h2 class="events__title">
              <?php echo $thtle6; ?>
          </h2>

            <?php
        }
        ?>

      <ul class="events__list flex">

          <?php
          $count6 = get_field('kilkist_vyvedenyh_podij_2');
          $the_query = new WP_Query( array(
              'posts_per_page' => $count6,
              'order'            => 'DESC',
              'post_type'        => 'product',
              'post_status'      => 'publish',
              'orderby'         => 'date',
              'tax_query'       => array(
                  array(
                      'taxonomy' => 'product_cat',
                      'field'    => 'slug',
                      'terms'    => 'kursy'
                  ),
              ),
          ));

          if ( $the_query->have_posts() ) : ?>
              <?php while ( $the_query->have_posts() ) : $the_query->the_post();

                  wc_get_template_part( 'content', 'product' );

              endwhile; ?>
              <?php wp_reset_postdata(); ?>
          <?php endif; ?>

      </ul>

        <?php
        if($btn6 && $btnUrl6) {
            $shop_page_url = get_term_link($btnUrl6, 'product_cat');
            ?>

          <div class="events__bottom flex">
            <a href="<?php echo $shop_page_url; ?>" class="button full big">
              <span><?php echo $btn6; ?></span>
            </a>
          </div>

            <?php
        }
        ?>

    </div>
  </section>

    <?php
}
?>



<?php
$dis4 = get_field('dis_4');

if(!$dis4) {
    $thtle4 = get_field('zag_4');
    $under4 = get_field('under_4');
    $btn4 = get_field('tekst_knopky_4');
    ?>

  <section id="news" class="section__latest point">
    <div class="container">

        <?php
        if($thtle4) {
            ?>

          <h2 class="news__title">
              <?php echo $thtle4; ?>
          </h2>

            <?php
        }

        if($under4) {
            ?>

          <div class="latest__undertitle">
              <?php echo $under4; ?>
          </div>

            <?php
        }
        ?>

      <div class="latest__list flex">

          <?php
          $count4 = get_field('kilkist_vyvedenyh_novyn');
          $the_query = new WP_Query( array(
              'posts_per_page' => $count4,
              'order'            => 'DESC',
              'post_type'        => 'post',
              'post_status'      => 'publish',
              'orderby' => 'date',
          ));

          if ( $the_query->have_posts() ) : ?>
              <?php while ( $the_query->have_posts() ) : $the_query->the_post();

                  get_template_part( 'template-parts/content', get_post_type() );

              endwhile; ?>
              <?php wp_reset_postdata(); ?>
          <?php endif; ?>

      </div>

        <?php
        if($btn4) {
            $blog_page_url = get_permalink( get_option( 'page_for_posts' ));
            ?>

          <div class="events__bottom flex">
            <a href="<?php echo $blog_page_url; ?>" class="button full big">
              <span><?php echo $btn4; ?></span>
            </a>
          </div>

            <?php
        }
        ?>


    </div>
  </section>

    <?php
}
?>



<?php
$dis5 = get_field('dis_5');

if(!$dis5) {
    ?>

  <div class="section__gal point">

      <?php
      $images = get_field('galereya');
      $index = 0;
      if( $images ): ?>
        <ul class="gal__list gallery flex">
            <?php foreach( $images as $image_id ):
                $img = $image_id;
                $size = 'full';
                $size2 = 'large';
                ?>

              <li class="gal__item">
                <a href="<?php echo wp_get_attachment_image_url( $img, $size ); ?>" data-index="<?php echo $index; ?>" onclick="openImg($(this))" class="gal__link falitem">
                  <img class="cover" src="<?php echo wp_get_attachment_image_url( $img, $size2 ); ?>" alt="">
                </a>
              </li>

                <?php
                $index++;
            endforeach; ?>
        </ul>
      <?php endif; ?>

  </div>

    <?php
}
?>

<?php
if (isset($_GET['somresetpass']) && !is_user_logged_in()) {
    ?>
  <div class="reset__popup">
    <div onclick="closePass()" class="overlay__reset"></div>
    <div class="liginTop">
      <div class="loginTopT">Авторизація</div>
      <a href="#" onclick="closePass()" class="lrm-close-formn"></a>
    </div>
    <div class="reset__popcont">
        <?php
        echo do_shortcode('[reset_password]');
        ?>

      <a href="#" onclick="gotPass()" class="gotpass">Я згадав свій пароль</a>
    </div>
  </div>
    <?php
}
?>




<?php
get_footer();
