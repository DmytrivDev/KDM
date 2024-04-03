<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

?>

  <section class="section__events events__page">
    <div class="container">
        <?php
        if(is_search()) {
            $search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
            $src = $wp_query->found_posts;
            $srcT = 'й';

            $n = abs($src) % 100;
            $n1 = $n % 10;

            if ($n1 > 1 && $n1 < 5) {
                $srcT = 'ї';
            }
            if ($n1 == 1) {
                $srcT = 'ю';
            }
            if ($n > 10 && $n < 20) {
                $srcT = 'й';
            }
            ?>
          <div class="searchm__top flex">
            <div class="search__res">
              Результат пошуку: «<span><?php echo $search_query; ?></span>»
            </div>
            <div class="search__found">
              Знайдено <?php echo $src; ?> поді<?php echo $srcT; ?>
            </div>
          </div>
            <?php
        }
        ?>
        <?php
        if (is_product_category()) {
            $category = get_queried_object();
            $zag = $category->name;
            ?>
          <h2 class="video__title">
              <?php echo $zag; ?>
          </h2>
        <?php } ?>
        <?php
        if ( woocommerce_product_loop() ) {

            woocommerce_product_loop_start();

            if ( wc_get_loop_prop( 'total' ) ) {
                while ( have_posts() ) {
                    the_post();

                    /**
                     * Hook: woocommerce_shop_loop.
                     */
                    do_action( 'woocommerce_shop_loop' );

                    wc_get_template_part( 'content', 'product' );
                }
            }

            woocommerce_product_loop_end();


            /**
             * Hook: woocommerce_after_shop_loop.
             *
             * @hooked woocommerce_pagination - 10
             */
            do_action( 'woocommerce_after_shop_loop' );


        } else {
            /**
             * Hook: woocommerce_no_products_found.
             *
             * @hooked wc_no_products_found - 10
             */
            do_action( 'woocommerce_no_products_found' );
        }

        /**
         * Hook: woocommerce_after_main_content.
         *
         * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
         */
        do_action( 'woocommerce_after_main_content' );


        ?>
    </div>
  </section>
<?php

get_footer( 'shop' );
