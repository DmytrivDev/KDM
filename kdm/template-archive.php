<?php
/**
 * Template name: Сторінка архіву
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

$zag = get_field('zagolovok');
?>


  <section class="section__events events__page">
    <div class="container">

        <?php
        if($zag) {
            ?>

          <h2 class="video__title">
              <?php echo $zag; ?>
          </h2>

            <?php
        }
        ?>

      <div class="events__list flex">

          <?php
          $paged = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);
          $the_query = new WP_Query( array(
              'posts_per_page'   => 15,
              'order'            => 'DESC',
              'post_type'        => 'product',
              'paged'            => $paged,
              'post_status'      => 'publish',
              'meta_key'         => 'data_podiyi',
              'orderby'          => 'meta_value',
              'meta_query'       => array(
                  'relation'     => 'AND',
                  array(
                      'key'              => 'podiya_vidbulas',
                      'value'            => true,
                      'compare'          => '=='
                  ),
                  array(
                      'key'      => 'publication_date',
                      'value'    => date('Y-m-d'),
                      'compare'  => 'NOT EXISTS'
                  )
              ),
          ));

          if ( $the_query->have_posts() ) : ?>
              <?php while ( $the_query->have_posts() ) : $the_query->the_post();

                  wc_get_template_part( 'content', 'product' );

              endwhile;

              wp_reset_query();
              endif; ?>

      </div>

        <?php post_pagination($paged, $the_query->max_num_pages);  ?>

    </div>
  </section>



<?php
get_footer();