<?php
/**
 * Template name: Сторінка "Про нас"
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

$dis2 = get_field('dis_2');
?>


  <section class="section__abfirst">

      <?php
      $zag1 = get_field('zag_1');
      $under1 = get_field('under_1');
      ?>

    <div class="container">
      <div class="abfirst__container flex">
        <div class="abfirst__content">

            <?php
            if($zag1) {
                ?>

              <h1 class="abfirst__title">
                  <?php echo $zag1; ?>
              </h1>

                <?php
            }

            if($under1) {
                ?>

              <div class="abfirst__text">
                  <?php echo $under1; ?>
              </div>

                <?php
            }
          ?>

        </div>
      </div>
    </div>

      <?php
      $images = get_field('galereya');
      if( $images ): ?>
        <div class="about__carousel carSt owl-carousel owl-theme">
            <?php foreach( $images as $image_id ):
                $img = $image_id;
                $size = 'full';
                ?>

              <div class="about__item">
                <img src="<?php echo wp_get_attachment_image_url( $img, $size ); ?>" alt="" class="cover">
              </div>

                <?php
            endforeach; ?>
        </div>
      <?php endif; ?>

      <?php
      if(!$dis2) {
          ?>

        <a href="#second" class="dirst__arrow ankor">
          <img src="<?php echo get_template_directory_uri();?>/assets/img/icons/arrow.svg" alt="">
        </a>

          <?php

      }
      ?>

  </section>


<?php
if(!$dis2) {
    $zag2 = get_field('zag_2');
    $under2 = get_field('under_2');
    $text2 = get_field('tekst');
    ?>

  <section id="second" class="section__about">
    <div class="container">
      <div class="avout__content flex">
        <div class="about__images">

            <?php
            if( have_rows('kolazh') ): ?>
              <div class="about__imagesin">
                  <?php while ( have_rows('kolazh') ) : the_row();
                      $image = get_sub_field('foto');
                      $index = get_row_index();
                      ?>

                    <div class="about__img ing<?php echo $index; ?>">
                      <div class="ab__imginner">
                        <img src="<?php echo $image; ?>" alt="" class="cover">
                      </div>
                    </div>

                  <?php
                  endwhile; ?>
              </div>
            <?php endif;
            ?>

        </div>
        <div class="about__info">

            <?php
            if($zag2) {
                ?>

              <h2 class="abput__title">
                  <?php echo $zag2; ?>
              </h2>

                <?php
            }

            if($under2) {
                ?>

              <div class="abput__short">
                  <?php echo $under2; ?>
              </div>

                <?php
            }

            if($text2) {
                ?>

              <div class="about__text">
                  <?php echo $text2; ?>
              </div>

                <?php
            }
            ?>

        </div>
      </div>
    </div>
  </section>

    <?php

}
?>


<?php
$dis3 = get_field('dis_3');
if(!$dis3) {
    $zag3 = get_field('zag_3');
    $under3 = get_field('under_3');
    $homeId = get_option('page_on_front');
    ?>

  <section class="section__success">
    <div class="container">
      <div class="success__top">

          <?php
          if($zag3) {
              ?>

            <h2 class="video__title">
                <?php echo $zag3; ?>
            </h2>

              <?php
          }

          if($under3) {
              ?>

            <div class="team__undertitle">
                <?php echo $under3; ?>
            </div>

              <?php
          }
          ?>

      </div>
      <div class="suxxess__bottom">

          <?php
          if( have_rows('perevagy', $homeId) ): ?>
            <ul class="advent__list flex">
                <?php while ( have_rows('perevagy', $homeId) ) : the_row();
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
    </div>
    <div class="suxxess__decor">
      <img src="<?php echo get_template_directory_uri();?>/assets/img/decor/event_dec.png" alt="">
    </div>
  </section>

    <?php

}
?>


<?php
$dis4 = get_field('dis_4');
if(!$dis4) {
    $zag4 = get_field('zag_4');
    $under4 = get_field('under_4');
    ?>

  <section class="section__team">
    <div class="container">

        <?php
        if($zag4) {
            ?>

          <h2 class="video__title">
              <?php echo $zag4; ?>
          </h2>

            <?php
        }

        if($under4) {
            ?>

          <div class="team__undertitle">
              <?php echo $under4; ?>
          </div>

            <?php
        }
        ?>

      <ul class="team__list flex">

          <?php
          $the_query = new WP_Query( array(
              'posts_per_page'   => -1,
              'post_type'        => 'team',
              'post_status'      => 'publish',
          ));

          if ( $the_query->have_posts() ) : ?>
              <?php while ( $the_query->have_posts() ) : $the_query->the_post();

                  $prodId = get_the_ID();
                  $add = get_field('dodatkova_informacziya', $prodId);
                  $th = get_the_post_thumbnail_url($prodId, 'large' );
              ?>

              <li class="team__item">
                <div class="team__img">
                  <div class="team__imginner">
                    <img src="<?php echo $th; ?>" alt="" class="cover">
                  </div>
                </div>
                <div class="team__info">
                  <h3 class="team__name">
                      <?php the_title(); ?>
                  </h3>
                  <div class="team__text">
                      <?php the_content(); ?>
                  </div>

                    <?php
                    if($add) {
                        ?>

                      <div class="team__add">
                          <?php echo $add; ?>
                      </div>

                        <?php
                    }
                    ?>

                    <?php
                    if( have_rows('soczialni_merezhi', $prodId) ): ?>
                      <ul class="team__soc flex">
                          <?php while ( have_rows('soczialni_merezhi', $prodId) ) : the_row();
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
              </li>

              <?php
              endwhile; ?>
              <?php wp_reset_postdata(); ?>
          <?php endif; ?>

      </ul>
    </div>
  </section>


    <?php

}
?>


<?php
$dis5 = get_field('dis_5');
if(!$dis5) {
    $zag5 = get_field('zag_5');
    ?>

  <section class="section___reviews">
    <div class="container">
      <div class="reviews__container">

          <?php
          if($zag5) {
              ?>

            <h2 class="reviews__title">
                <?php echo $zag5; ?>
            </h2>

              <?php
          }
          ?>

        <div class="reviews__content">

            <?php
            if( have_rows('vidguky') ): ?>

              <div class="reviews__carousel carSt owl-carousel owl-theme">
                  <?php while ( have_rows('vidguky') ) : the_row();
                      $ava = get_sub_field('avatar');
                      $name = get_sub_field('imya');
                      $sici = get_sub_field('soczialna_merezha_ikonka');
                      $sicu = get_sub_field('soczialna_merezha_pos');
                      $text = get_sub_field('tekst_vidguku');
                      $text2 = get_sub_field('dodatkovyj_tekst');
                      ?>

                    <div class="reviews__item">

                        <?php
                        if($ava) {
                            ?>

                          <div class="reviews__ava">
                            <img src="<?php echo $ava; ?>" class="cover" alt="">
                          </div>

                            <?php
                        }

                        if($text) {
                            ?>

                          <div class="reviews__maintext">
                              <?php echo $text; ?>
                          </div>

                            <?php
                        }

                        if($name) {
                            ?>

                          <div class="reviews__name">
                              <?php echo $name; ?>
                          </div>

                            <?php
                        }

                        if($text2) {
                            ?>

                          <div class="reviews__small">
                              <?php echo $text2; ?>
                          </div>

                            <?php
                        }

                        if($sici && $sicu) {
                            ?>

                          <ul class="reviews__soc flex">
                            <li>
                              <a href="<?php echo $sicu; ?>" target="_blank">
                                <img src="<?php echo $sici; ?>" alt="">
                              </a>
                            </li>
                          </ul>

                            <?php
                        }
                        ?>


                    </div>

                  <?php
                  endwhile; ?>
              </div>

            <?php endif;
            ?>

        </div>
      </div>
    </div>
    <img src="<?php echo get_template_directory_uri();?>/assets/img/content/rev.jpg" alt="" class="cover">
  </section>


    <?php

}
?>



<?php
get_footer();