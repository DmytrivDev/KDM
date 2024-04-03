<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_before_account_navigation' );

global $wp;
$current_url = home_url(add_query_arg(array(),$wp->request));
$dash = home_url('/my-account');
$mainAcc = true;
$courseAcc = false;
$ordersUrl = wc_get_endpoint_url( 'actual' );

if(str_contains($current_url, 'view-order')) {
    $mainAcc = false;
}

if(str_contains($current_url, 'course') && !str_contains($current_url, 'courses')) {
    $mainAcc = false;
    $courseAcc = true;
}

if($mainAcc) {
    ?>
  <aside class="account__side">
    <nav class="woocommerce-MyAccount-navigation">
        <?php
        $current_user = wp_get_current_user();
        $first_role = $current_user->roles;
        $user_roles = reset($first_role);
        $restricted_roles = 'employee';
        $restricted_roles2 = 'administrator';

        if($user_roles == $restricted_roles || $user_roles == $restricted_roles2) {
            $mode_cookie = isset($_COOKIE['mode']) ? $_COOKIE['mode'] : '';
            ?>
            <div class="mode__buttons flex">
              <a href="#" onclick="changeRole('mode', 0, 10)" class="mode__button <?php if(!$mode_cookie) { echo 'active'; } ?>">
                <span>Користувач</span>
              </a>
              <a href="#" onclick="changeRole('mode', 1, 10)" class="mode__button <?php if($mode_cookie) { echo 'active'; } ?>">
                <span>Співробітник</span>
              </a>
            </div>
      <?php
        }
        ?>
      <ul>
          <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
            <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
              <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
                <span class="acc__icon"><img class="contain" src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/<?php echo $endpoint; ?>.svg" alt=""></span>
                  <?php echo esc_html( $label ); ?>
              </a>
            </li>
          <?php endforeach; ?>
      </ul>
    </nav>
    <nav class="woocommerce-MyAccount-navigation lastNav">
      <ul>
        <li class="woocommerce-MyAccount-navigation-link">
          <a href="<?php echo wc_logout_url(); ?>">
            <span class="acc__icon"><img class="contain" src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/logout.svg" alt=""></span>
            Вийти з кабінету
          </a>
        </li>
      </ul>
    </nav>
  </aside>
    <?php
} else {
  if(!$courseAcc) {
      $order_id =  intval( str_replace( 'my-account/view-order/', '', $wp->request ) );
      $order = wc_get_order( $order_id );
      $agreeTest = true;

      foreach ($order->get_items() as $item_key => $item ) {
          //Product info
          $item_name = $item->get_name();
          $product = $item->get_product();
          $id = $product->get_id();
          $actualLink = 'Актуальні події';

          //Bought date
          $orderDate = $order->get_date_created();
          $orderDateStr = strtotime($orderDate);
          $orderDateStrD = date_i18n("Y-m-d", $orderDateStr);
          $orderDateStrM = strtotime($orderDateStrD);
          $dateEv = get_field('data_podiyi', $id);
          $dateEvSt = strtotime($dateEv);

          //Status
          $status = get_field('status_podiyi', $id);

          //Sertificate
          $sertUrl = get_field('posylannya', $order_id);

          //Type
          $type = get_field('typ_podiyi', $id);
          $typeK = $type['value'];

          //Test
          $testDate = get_field('data_zakinchennya_testu', $id);
          $dateTE = date('Y-m-d', strtotime($dateEv. ' + '.$testDate.' days'));
          $dateTESt = strtotime($dateTE);
          $dateT = date_i18n("j F Y", $dateTESt);
          $curDate = strtotime(current_datetime()->format('Y-m-d'));
          $testEnd = true;
          if($status == 'testing' && $testDate && $curDate > $dateTESt) {
              update_field("status_podiyi","compleet",$id);
              $testEnd = false;
          }

          //Conditions
          if($status == 'compleet' || $sertUrl || !$testEnd) {
              $actualLink = 'Завершені події';
              $ordersUrl = wc_get_endpoint_url( 'orders' );
          }

          if($typeK == 'course') {
              $actualLink = 'Курси';
              $ordersUrl = wc_get_endpoint_url( 'courses' );
          }

          if($orderDateStrM > $dateTESt) {
              $agreeTest = false;
          }

          ?>
        <div class="orderMobName noTab hideOnMob">
            <?php echo $item_name; ?>
        </div>
          <?php
      }

      ?>
    <aside class="account__side noTab hideOnMob <?php if($typeK == 'course') { echo 'courseSide'; } ?>">
      <div class="accountnav__inner">
        <nav class="woocommerce-MyAccount-navigation">
          <ul>
              <?php
              if($typeK != 'course') {
                  ?>
                <li class="woocommerce-MyAccount-navigation-link <?php if(!$agreeTest) { echo 'is-active'; } ?>">
                  <a href="#translation" onclick="changeOrderTab($(this))">
                    <span class="acc__icon"><img class="contain" src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/orders.svg" alt=""></span>
                    Запис трансляції
                  </a>
                </li>
                  <?php
              } else {
                  $coursDays = get_field('podiya_dostupna', $id);
                  $orderDateTime = new DateTime($orderDate->date('Y-m-d H:i:s'));
                  $orderDateTime->add(new DateInterval('P' . $coursDays . 'D'));
                  $accessibleDate = strtotime($orderDateTime->format('Y-m-d'));
                  $formattedDate = date_i18n('d F Y', $accessibleDate);
                  $courseAnable = true;

                  if($curDate > $accessibleDate) {
                      $courseAnable = false;
                  }
                  if($courseAnable) {
                      if( have_rows('glavy_копіювати', $id) ):
                          while ( have_rows('glavy_копіювати', $id) ) : the_row();
                              $index = get_row_index();
                              ?>
                            <li class="woocommerce-MyAccount-navigation-link">
                              <a href="#chapter<?php echo $index; ?>" onclick="changeOrderTab($(this))">
                                <span class="acc__icon"><img class="contain" src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/chapter.svg" alt=""></span>
                                Глава <?php echo $index; ?>
                              </a>
                            </li>
                          <?php
                          endwhile;
                      endif;
                  }
              }
              ?>

              <?php
              if($agreeTest || $typeK == 'course') {
                  ?>
                <li class="woocommerce-MyAccount-navigation-link">
                  <a href="#test" onclick="changeOrderTab($(this))">
                    <span class="acc__icon"><img class="contain" src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/tests.svg" alt=""></span>
                    Тест
                  </a>
                </li>
                <li class="woocommerce-MyAccount-navigation-link">
                  <a href="#sertificate" onclick="changeOrderTab($(this))">
                    <span class="acc__icon"><img class="contain" src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/sertificats.svg" alt=""></span>
                    Сертифікат
                  </a>
                </li>
                  <?php
              }
              ?>

          </ul>
        </nav>
        <nav class="woocommerce-MyAccount-navigation lastNav">
          <ul>
            <li class="woocommerce-MyAccount-navigation-link">
              <a href="<?php echo $ordersUrl; ?>">
                <span class="acc__icon"><img class="contain" src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/backarrow.svg" alt=""></span>
                  <?php
                  echo $actualLink;
                  ?>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>
      <?php
  } else {
      $user = wp_get_current_user();
      $user_id = $user->ID;

      $actualLink = 'Актуальні курси';
      $crs = isset($_GET['crs']) ? $_GET['crs'] : null;
      $id = $crs;
      $enabledCourses = [];

      if (have_rows('kursy', 'user_' . $user_id)) {
          while (have_rows('kursy', 'user_' . $user_id)) : the_row();
              $course = get_sub_field('kurs');
              $done = get_sub_field('projdeno');

              if($crs == $course) {
                  if($done) {
                      $actualLink = 'Завершені курси';
                      $ordersUrl = wc_get_endpoint_url( 'orders' );
                  }
              }

              $enabledCourses[] = $course;

          endwhile;
      }
      ?>
    <aside class="account__side noTab hideOnMob courseSide">
      <div class="accountnav__inner">
        <nav class="woocommerce-MyAccount-navigation">
          <ul>
              <?php
              if (in_array($crs, $enabledCourses)) {
                  if( have_rows('glavy_копіювати', $id) ):
                      while ( have_rows('glavy_копіювати', $id) ) : the_row();
                          $index = get_row_index();
                          ?>
                        <li class="woocommerce-MyAccount-navigation-link">
                          <a href="#chapter<?php echo $index; ?>" onclick="changeOrderTab($(this))">
                            <span class="acc__icon"><img class="contain" src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/chapter.svg" alt=""></span>
                            Глава <?php echo $index; ?>
                          </a>
                        </li>
                      <?php
                      endwhile;
                  endif;
                  ?>
                <li class="woocommerce-MyAccount-navigation-link">
                  <a href="#test" onclick="changeOrderTab($(this))">
                    <span class="acc__icon"><img class="contain" src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/tests.svg" alt=""></span>
                    Тест
                  </a>
                </li>
                  <?php
                  if( have_rows('opytuvannya', $id) ): ?>
                      <?php while ( have_rows('opytuvannya', $id) ) : the_row();
                          $link = get_sub_field('posylannya');
                          $name = get_sub_field('nazva');
                          ?>

                      <li class="woocommerce-MyAccount-navigation-link">
                        <a href="<?php echo $link; ?>" target="_blank">
                          <span class="acc__icon"><img class="contain" src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/anketa.svg" alt=""></span>
                            <?php echo $name; ?>
                        </a>
                      </li>
                      <?php
                      endwhile; ?>
                  <?php endif;
              }
              ?>
          </ul>
        </nav>
        <nav class="woocommerce-MyAccount-navigation lastNav">
          <ul>
            <li class="woocommerce-MyAccount-navigation-link">
              <a href="<?php echo $ordersUrl; ?>">
                <span class="acc__icon"><img class="contain" src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/backarrow.svg" alt=""></span>
                  <?php
                  echo $actualLink;
                  ?>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>
      <?php
  }
}

?>




<?php do_action( 'woocommerce_after_account_navigation' ); ?>
