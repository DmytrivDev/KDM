<?php
/**
 * The template for displaying all pages
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

while ( have_posts() ) :
    the_post();
    ?>

  <section class="section__events events__page">
    <div class="container">
      <div class="text__content">
        <h1 class="page__title">
          <?php the_title(); ?>
        </h1>
        <div class="page__content text__wrapp">
            <?php the_content(); ?>
        </div>
      </div>
    </div>
  </section>

<?php
endwhile;


get_footer();
