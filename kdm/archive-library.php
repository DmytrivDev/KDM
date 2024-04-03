<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package kdm
 */

get_header();
?>


  <section class="section__events events__page">
    <div class="container">
      <div class="lebrary__container flex">
        <aside class="library__aside">
          <div class="filter__mobtop">
            <div class="filter__mobtitle">
              Пошук та фільтри
            </div>
            <a href="#" onclick="openFilter()" class="filter__close"></a>
          </div>
          <div class="library__filtercont">
            <div class="filter__content">
              <div class="filter__part">
                <div class="filter__title">
                  Пошук методичних матеріалів:
                </div>
                <div class="search__form">
                    <?php echo do_shortcode('[facetwp facet="search"]'); ?>
                </div>
              </div>
              <div class="filter__part">
                <div class="filter__title">
                  Формат матеріалу:
                </div>
                <div class="filter__form flex">
                    <?php echo do_shortcode('[facetwp facet="format"]'); ?>
                </div>
              </div>
              <div class="filter__part">
                <div class="filter__title">
                  Тип матеріалу:
                </div>
                <div class="filter__form">
                    <?php echo do_shortcode('[facetwp facet="type"]'); ?>
                </div>
              </div>
              <div class="filter__part">
                <div class="filter__title">
                  Пошук за тегами:
                </div>
                <div class="filter__form flex labels">
                    <?php echo do_shortcode('[facetwp facet="tags"]'); ?>
                </div>
              </div>
            </div>
          </div>
          <div class="openfilter__cont">
            <a href="#" onclick="openFilter()" class="button full green filter__btn">
              <span>Показати результат</span>
            </a>
          </div>
        </aside>
        <div class="library__main">
          <h1 class="library__title">
            Бібліотека методичних матеріалів для гінекологів
          </h1>
          <ul class="library__list flex">
              <?php if ( have_posts() ) : ?>


                  <?php
                  while ( have_posts() ) :
                      the_post();

                      get_template_part( 'template-parts/content-library' );

                  endwhile;

              else :

                  get_template_part( 'template-parts/content', 'none' );

              endif;
              ?>
          </ul>
          <div class="library__pag flex">
              <?php echo do_shortcode('[facetwp facet="pages"]'); ?>
          </div>

        </div>
      </div>
      <div class="openfilter__cont">
        <a href="#" onclick="openFilter()" class="button full green filter__btn">
          <span>Пошук та фільтри</span>
        </a>

        <style>
          @media screen and (max-width: 767px) {
            .footer__bottom {
              padding-bottom: 105px;
            }
          }
        </style>

      </div>
    </div>
  </section>

<?php
get_footer();
