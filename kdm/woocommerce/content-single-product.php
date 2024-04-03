<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$type = get_field('typ_podiyi');
$upper = $type['label'];
$typeK = $type['value'];
$zag1 = get_field('zag_1');
$under1 = get_field('under_1');
$btn1 = get_field('kupyty', 'options');
$image_id  = $product->get_image_id();
$image_url = wp_get_attachment_image_url( $image_id, 'full' );
$newDate = strtotime(get_field('data_podiyi'));
$date = date_i18n("d F Y о H:i", $newDate);
$status = get_field('podiya_vidbulas');
$dataAdd = '';

if($typeK == 'course') {
    $btn1 = get_field('kupyty_c', 'options');
}

if($status) {
    $dataAdd = ' Подія відбулась ';
}


?>

<section class="section__evfirst">
  <div class="container">
    <div class="evfirst__container flex">
      <div class="evfirst__content">

          <?php
          if($upper) {
              ?>

            <div class="evfirst__topgreen">
                <?php echo $upper; ?>
            </div>

              <?php
          }

          if($zag1) {
              ?>

            <h1 class="evfirst__title">
                <?php echo $zag1; ?>
            </h1>

              <?php
          }

          if($under1) {
              ?>

            <div class="evfirst__text">
                <?php echo $under1; ?>
            </div>

              <?php
          }

          if($date && $typeK != 'course') {
              ?>

            <div class="evfirst__date">
                <?php echo $dataAdd; echo $date; ?> за Києвом
            </div>

              <?php
          }

          if($btn1) {
              ?>

            <a href="#ticket" class="button border whiteB big evfirst__button ankor">
              <span><?php echo $btn1; ?></span>
            </a>

              <?php
          }
          ?>

      </div>
    </div>
  </div>

    <?php
    if($image_url) {
        ?>

      <img src="<?php echo $image_url; ?>" alt="" class="event__bg cover">

        <?php
    }
    ?>

  <div class="event__dec"><img src="<?php echo get_template_directory_uri();?>/assets/img/decor/event_dec.png" alt=""></div>
</section>


<?php
$dis2 = get_field('dis_2');

if(!$dis2) {
    $thtle2 = get_field('zag_2');
    $under2 = get_field('under_2');
    $col21 = get_field('kolonka_1');
    $col22 = get_field('kolonka_2');
    ?>

  <section class="section__evabout">
    <div class="container">
      <div class="evabout__cont flex">
        <div class="evabout__part">
          <div class="evabout__top">

              <?php
              if($thtle2) {
                  ?>

                <h2 class="evabout__title">
                    <?php echo $thtle2; ?>
                </h2>

                  <?php
              }

              if($under2) {
                  ?>

                <div class="evabout__short">
                    <?php echo $under2; ?>
                </div>

                  <?php
              }
              ?>

          </div>

            <?php
            if($col21) {
                ?>

              <div class="evabout__text text__wrapp">
                  <?php echo $col21; ?>
              </div>

                <?php
            }
            ?>

        </div>
        <div class="evabout__part flex">

            <?php
            if($col22) {
                ?>

              <div class="evabout__text text__wrapp">
                  <?php echo $col22; ?>
              </div>

                <?php
            }

            if($btn1) {
                ?>

              <a href="#ticket" class="button full evabout__btn ankor">
                <span><?php echo $btn1; ?></span>
              </a>

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
    $thtle3 = get_field('zag_3');
    $video3 = get_field('video');
    ?>

  <section class="section__video">
    <div class="container">

        <?php
        if($thtle3) {
            ?>

          <h2 class="video__title">
              <?php echo $thtle3; ?>
          </h2>

            <?php
        }

        if($video3) {
            ?>

          <div class="video__container">
            <div class="video__inner">
              <iframe src="https://www.youtube.com/embed/<?php echo $video3; ?>" frameborder="0"></iframe>
            </div>
          </div>

            <?php
        }


        if( have_rows('perevagy') ): ?>
          <ul class="video__infogr flex">
              <?php while ( have_rows('perevagy') ) : the_row();
                  $icon = get_sub_field('ikonka');
                  $name = get_sub_field('tekst');
                  ?>

                <li class="infogr__item">
                  <div class="infogr__img">
                    <img src="<?php echo $icon; ?>" class="contain" alt="">
                  </div>
                  <div class="infogr__text">
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
$dis4 = get_field('dis_4');

if(!$dis4) {
    $thtle4 = get_field('zag_4');
    $under4 = get_field('under_4');
    ?>

  <section class="section__team">
    <div class="container">

        <?php
        if($thtle4) {
            ?>

          <h2 class="video__title">
              <?php echo $thtle4; ?>
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


        <?php
        $featured_posts = get_field('spikery');
        if( $featured_posts ): ?>
          <ul class="team__list flex">
              <?php foreach( $featured_posts as $post ):

                  setup_postdata($post);

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
                                $not = get_sub_field('ne_vidkyvaty');
                                ?>

                              <li>
                                <a href="<?php echo $link; ?>" <?php if(!$not) { echo 'target="_blank"'; } ?>>
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

              <?php endforeach; ?>

          </ul>

            <?php
            wp_reset_postdata(); ?>
        <?php endif; ?>

        <?php
        $btnText = get_field('knopka4_tekst_knopky');
        if($btnText) {
            $btnType = get_field('knopka4_typ_knopky');
            $btnUrl = get_field('knopka4_storinka');

            if($btnType == 'link') {
                $btnUrl = get_field('knopka4_posylannya');
            } else if($btnType == 'ankor') {
                $btnUrl = '#'. get_field('knopka4_yakir');
            }

            ?>

          <div class="team__bottom flex">
            <a href="<?php echo $btnUrl; ?>" class="button border black big team__button <?php if($btnType == 'ankor') { echo 'ankor'; } ?>">
              <span><?php echo $btnText; ?></span>
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
    $thtle5 = get_field('zag_5');
    $under5 = get_field('under_5');
    ?>

  <section class="section__program">
    <div class="container">

        <?php
        if($thtle5) {
            ?>

          <h2 class="video__title">
              <?php echo $thtle5; ?>
          </h2>

            <?php
        }

        if($under5) {
            ?>

          <div class="team__undertitle">
              <?php echo $under5; ?>
          </div>

            <?php
        }
        ?>

        <?php
        if( have_rows('programa') ): ?>
          <ul class="program__list flex">
              <?php while ( have_rows('programa') ) : the_row();
                  $st = get_sub_field('pochatok');
                  $ed = get_sub_field('kinecz');
                  $name = get_sub_field('zagolovok');
                  $text = get_sub_field('tekst');
                  ?>

                <li class="program__item">

                    <?php
                    if($st) {
                        ?>

                      <div class="program__time">
                          <?php echo $st; ?><?php if($ed) { echo '-'; echo $ed; } ?>
                      </div>

                        <?php
                    }

                    if($name) {
                        ?>

                      <h3 class="program__name">
                          <?php echo $name; ?>
                      </h3>

                        <?php
                    }

                    if($text) {
                        ?>

                      <div class="program__text">
                          <p><?php echo $text; ?></p>
                      </div>

                        <?php
                    }
                    ?>

                </li>

              <?php
              endwhile; ?>
          </ul>
        <?php endif;


        $btnText = get_field('knopka5_tekst_knopky');
        if($btnText) {
            $btnType = get_field('knopka5_typ_knopky');
            $btnUrl = get_field('knopka5_storinka');

            if($btnType == 'link') {
                $btnUrl = get_field('knopka5_posylannya');
            } else if($btnType == 'ankor') {
                $btnUrl = '#'. get_field('knopka5_yakir');
            }

            ?>

          <div class="program__bottom flex">
            <a href="<?php echo $btnUrl; ?>" class="button big full program__button <?php if($btnType == 'ankor') { echo 'ankor'; } ?>">
              <span><?php echo $btnText; ?></span>
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


	<section style="background-image: url(<?php echo $image_url; ?>);" class="section__ticket parallaxSec" id="ticket">
		<div class="container">
			<div class="ticket__container flex">
				<div class="ticket__logo">

            <?php
            $custom_logo_id = get_theme_mod( 'custom_logo' );
            $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
            ?>

					<img src="<?php echo $image[0]; ?>" alt="">
				</div>
				<div class="ticket__main">

            <?php
            if($upper) {
                ?>

              <div class="ticket__green">
                  <?php echo $upper; ?>
              </div>

                <?php
            }

            if($zag1) {
                ?>

              <h2 class="ticket__title">
                  <?php echo $zag1; ?>
              </h2>

                <?php
            }

            if($under1) {
                ?>

              <div class="ticket__short">
                  <?php echo $under1; ?>
              </div>

                <?php
            }

            if($date  && $typeK != 'course') {
                ?>

              <div class="ticket__date">
                  <?php echo $dataAdd; echo $date; ?> за Києвом
              </div>

                <?php
            }
            ?>

					<div class="ticket__sumcont">
              <?php
              $t0 = 'Вартість участі в семінарі';

              if($typeK == 'course') {
                  $t0 = 'Вартість курсу';
              }
              ?>
            <div class="ticket__sumtext">
              <?php echo $t0; ?>
            </div>

              <?php
              $no_repeats_id = get_the_id();
              $no_repeats_product = wc_get_product( $no_repeats_id );
              $t1 = 'Ви вже придбали цей вебінар';
              $t2 = 'Щоб переглянути свої покупки - увійдіть в особистий кабінет';

              if($typeK == 'course') {
                $t1 = 'Ви вже придбали цей курс';
              }

              if ( $no_repeats_id === $product->get_id() ) {
                  if ( wc_customer_bought_product( get_current_user()->user_email, get_current_user_id(), $no_repeats_id ) ) {
                      ?>
                    <div class="button button__bought green full">
                      <?php echo $t1; ?>
                    </div>
                      <div class="bought__mess">
                          <?php echo $t2; ?>
                      </div>
                      <?php
                  } else {
                      /**
                       * Hook: woocommerce_single_product_price.
                       *
                       * @hooked woocommerce_template_single_price - 10
                       * @hooked woocommerce_template_single_add_to_cart - 30
                       */
                      do_action( 'woocommerce_single_product_options' );

                      $trial = get_field('vidkryty_probnyj_urok');

                      if($trial && $typeK == 'course') {
                          ?>
                        <div class="trial__container">
                            <?php
                            if(!is_user_logged_in()) {
                              ?>
                              <a href="#" class="button lrm-login">
                                <span>Пробний урок</span>
                              </a>
                                <div class="trial__help">Щоб переглянути пробний урок потрібно <a href="#" class="lrm-login">авторизуватись</a></div>
                                <?php
                            } else {
                              ?>
                              <a href="#" onclick="openCoursePop()" class="button">
                                <span>Пробний урок</span>
                              </a>
                                <?php
                            }
                            ?>
                        </div>
                          <?php
                      }
                  }
              }
              ?>

					</div>
				</div>
			</div>
		</div>
	</section>

<?php
$dis6 = get_field('dis_6');

if(!$dis6) {
    $thtle6 = get_field('zag_6');
    $address = get_field('adresa');
    $dop = get_field('dopovnennya');
    $map = get_field('karta');
    ?>

  <section class="section__map">
    <div class="map__part">
      <div class="map__content">

          <?php
          if($thtle6) {
              ?>

            <h3 class="map__title">
                <?php echo $thtle6; ?>
            </h3>

              <?php
          }
          ?>

        <div class="map__contact">

            <?php
            if($address) {
                ?>

              <address class="map__address">
                  <?php echo $address; ?>
              </address>

                <?php
            }

            if($dop) {
                ?>

              <div class="map__text">
                  <?php echo $dop; ?>
              </div>

                <?php
            }


            if( have_rows('kontakty') ): ?>
              <ul class="map__list">
                  <?php while ( have_rows('kontakty') ) : the_row();
                      $text = get_sub_field('tekst');
                      $link = get_sub_field('posylannya');
                      ?>

                    <li>
                      <a href="<?php echo $link; ?>"><?php echo $link; ?></a>
                    </li>

                  <?php
                  endwhile; ?>
              </ul>
            <?php endif;


            if( have_rows('soczialni_merezhi') ): ?>
              <ul class="map__soc flex">
                  <?php while ( have_rows('soczialni_merezhi') ) : the_row();
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
    </div>

      <?php
      if($map) {
          ?>

        <div class="map__part">
            <?php echo $map; ?>
        </div>

          <?php
      }
      ?>

  </section>

    <?php
}
?>


<?php
$desRev = get_field('disrev');
if(!$desRev) {

    /**
     * Hook: woocommerce_after_single_product_summary.
     *
     * @hooked woocommerce_output_product_data_tabs - 10
     * @hooked woocommerce_upsell_display - 15
     * @hooked woocommerce_output_related_products - 20
     */
    do_action( 'woocommerce_after_single_product_reviews' );

  ?>


<?php
}
?>

<style>
  .wrapper {
    position: static !important;
  }
</style>
