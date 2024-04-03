<?php
/**
 * Template name: Сторінка акаунту
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


$current_user = wp_get_current_user();
$first_role = $current_user->roles;
$user_roles = reset($first_role);
$restricted_roles = 'employee';
$restricted_roles2 = 'administrator';

if($user_roles == $restricted_roles || $user_roles == $restricted_roles2) {
    setcookie("temp", 0, time()+3600);
} else {
    setcookie("mode", 0, time()+3600);
}

get_header();

if ( is_account_page() ) {
    global $wp;
    $current_url = home_url(add_query_arg(array(),$wp->request));
    $dash = home_url('/my-account');
    $class = '';

    if($current_url === $dash){
        $class = 'dashMob';
    }

    if(str_contains($current_url, 'view-order')) {
        $class = 'viewOrder';

        $order_id =  intval( str_replace( 'my-account/view-order/', '', $wp->request ) );
        $order = wc_get_order( $order_id );
        $agreeTest = true;

        foreach ($order->get_items() as $item_key => $item ) {
            $item_name = $item->get_name();
            $product = $item->get_product();
            $id = $product->get_id();

            $orderDate = $order->get_date_created();
            $orderDateStr = strtotime($orderDate);
            $dateEv = get_field('data_podiyi', $id);
            $dateEvSt = strtotime($dateEv);

            if($orderDateStr > $dateEvSt) {
                $agreeTest = false;
            }
        }
    }

    if(str_contains($current_url, 'course') && !str_contains($current_url, 'courses')) {
        $class = 'viewOrder';
    }
}
?>

  <section class="section__account <?php echo $class; ?> <?php if(!$agreeTest) { echo 'disTabs'; } ?>">
    <div class="container">
      <h1 class="accoun__title">
        <?php the_title(); ?>
      </h1>

        <?php
        $userId = get_current_user_id();
        $field1 = get_user_meta($userId, 'billing_speciality', true);
        $field2 = get_user_meta($userId, 'billing_place', true);
        $field3 = get_user_meta($userId, 'billing_post', true);
        $field4 = get_user_meta($userId, 'billing_date', true);

        if(!$field1 || !$field2 || !$field3 || !$field4) {
            ?>
                <div class="adddata__cont flex">
                    <div class="adddata__left">
                        <div class="adddata__1">
                            Ваш профіль заповнений не повністю
                        </div>
                        <div class="adddata__2">
                            Для того, щоб це виправити, натисніть на кнопку «Заповнити»
                        </div>
                    </div>
                    <a href="https://gynecology.com.ua/my-account/edit-account/" class="button green full adddata__btn">
                        <span>Заповнити</span>
                    </a>
                </div>
                <?php
        }
        ?>


      <div class="account__content">
          <?php

          the_content();

          ?>
      </div>
    </div>
  </section>



<?php
get_footer();
