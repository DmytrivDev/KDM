<?php
/**
 * Template name: Сторінка чекауту
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

get_header('none');
?>

  <style>
    #ship-to-different-address, .col-2 {
      display: none !important;
    }
  </style>

    <section class="section__checkout">
        <div class="checkout__top">
            <a href="#" onclick="history.back()" class="checkout__back">Повернутись назад</a>
        </div>
        <div class="container">
            <div class="checkout_content flex">
                <div class="checkout__main">
                    <h1 class="checkout__title">
                        <?php the_title(); ?>
                    </h1>
                    <div class="checkout__mcont">
                        <?php
                        while ( have_posts() ) :
                            the_post();

                            the_content();

                        endwhile;
                        ?>

                        <?php
                        $user_id = get_current_user_id();
                        $first_name = get_user_meta( $user_id, 'billing_first_name', true);
                        $last_name = get_user_meta( $user_id, 'billing_last_name', true);
                        if(!$first_name) {
                            $first_nameC = get_user_meta( $user_id, 'first_name', true );
                            ?>
                          <script>
                              jQuery('#billing_first_name').val('<?php echo $first_nameC; ?>');
                          </script>
                            <?php
                        }

                        if(!$last_name) {
                            $last_nameC = get_user_meta( $user_id, 'last_name', true );
                            ?>
                          <script>
                              jQuery('#billing_last_name').val('<?php echo $last_nameC; ?>');
                          </script>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>




<?php
get_footer('none');
