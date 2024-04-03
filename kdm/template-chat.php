<?php
/**
 * Template name: Чати
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

  <section class="section__account">
    <div class="container thecont">
        <?php
        $current_date = date('Y-m-d');
        $current_url = get_permalink();

        if (!isset($_GET['chat'])) {
            $args = array(
                'post_type' => 'product',
                'posts_per_page'   => -1,
                'post_status'      => 'publish',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'status_podiyi',
                        'value' => 'panding',
                        'compare' => '!=',
                    ),
                ),
            );

            $products = new WP_Query($args);

            if ($products->have_posts()) {
                while ($products->have_posts()) {
                    $products->the_post();
                    $event = get_the_id();
                    $chatDate = get_field('chat_dostupnyj_do');

                    if($chatDate) {
                        if (strtotime($chatDate) > strtotime($current_date)) {
                            ?>
                          <div class="chat__item">
                            <h3 class="chat__name">
                                <?php the_title(); ?>
                            </h3>
                            <a href="<?php echo $current_url; ?>?chat=<?php echo $event; ?>" class="button green full">
                              <span>Відкрити чат</span>
                            </a>
                          </div>
                            <?php
                        }
                    } else {
                        ?>
                      <div class="chat__item">
                        <h3 class="chat__name">
                            <?php the_title(); ?>
                        </h3>
                        <a href="<?php echo $current_url; ?>?chat=<?php echo $event; ?>" class="button green full">
                          <span>Відкрити чат</span>
                        </a>
                      </div>
                        <?php
                    }

                }
                wp_reset_postdata();
            }
        } else {
            $event = $_GET['chat'];
            $post_title = get_the_title($event);
            ?>
            <div class="chatadmin__content">
              <div class="back__chatcont">
                <a href="<?php echo $current_url; ?>" class="backtochat">
                  <span class="acc__icon"><img class="contain" src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/backarrow.svg" alt=""></span>
                  Повернутись до списку чатів
                </a>
              </div>
              <h1 class="postcheat__title">
                <?php echo $post_title; ?>
              </h1>
              <div class="chatpage__container">
                <div class="trans__chatcont">
                    <?php echo do_shortcode('[wp_chat_window id='.$event.']')?>
                </div>
              </div>
            </div>
            <?php
        }


        ?>
    </div>
  </section>

  <style>
    .chat__item {
      margin-bottom: 40px;
    }
    .chat__item:last-child {
      margin-bottom: 0;
    }
    .chat__name {
      font-size: 1.2em;
      font-weight: 600;
    }
    .button {
      margin-top: 12px;
    }
    .postcheat__title {
      font-size: 1.4em;
      text-align: center;
      font-weight: 600;
    }
    .chatpage__container {
      margin-top: 40px;
      display: flex;
      justify-content: center;
    }
    .trans__chatcont {
      width: 600px;
      max-width: 100%;
    }
    .back__chatcont {
      display: flex;
      justify-content: center;
    }
    .backtochat {
      display: flex;
      margin: 0 auto;
      margin-bottom: 20px;
      color: #43AE4E;
      align-items: center;
      align-content: center;
    }
    .backtochat .acc__icon {
      width: 15px;
      height: 15px;
      margin-right: 10px;
      transform: none;
      position: relative;
      top: 0;
    }
    .backtochat .acc__icon img {
      filter: invert(62%) sepia(16%) saturate(1723%) hue-rotate(75deg) brightness(90%) contrast(86%);
    }
  </style>



<?php
get_footer();