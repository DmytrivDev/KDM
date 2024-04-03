<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package kdm
 */

get_header();
?>

  <section class="section__events events__page">
    <div class="container">


        <?php if ( have_posts() ) : ?>

      <h2 class="video__title">
          <?php
          /* translators: %s: search query. */
          printf( esc_html__( 'Search Results for: %s', 'kdm' ), '<span>' . get_search_query() . '</span>' );
          ?>
      </h2>

      <div class="latest__list flex">
          <?php
          /* Start the Loop */
          while ( have_posts() ) :
              the_post();

              /**
               * Run the loop for the search to output the results.
               * If you want to overload this in a child theme then include a file
               * called content-search.php and that will be used instead.
               */
              get_template_part( 'template-parts/content' );

          endwhile;


          else :

              get_template_part( 'template-parts/content', 'none' );

          endif;
          ?>

      </div>

        <?php wp_custom_pagination(); ?>

    </div>
  </section>

<?php
get_footer();
