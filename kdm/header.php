<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kdm
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="profile" href="https://gmpg.org/xfn/11">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <?php wp_head(); ?>

    <?php
    if ( is_account_page() ) {
        global $wp;
        $current_url = home_url(add_query_arg(array(),$wp->request));
        $dash = home_url('/my-account');
        $red = wc_get_endpoint_url('actual');

        if($current_url === $dash){
            ?>

          <script>
              if(jQuery(window).width() > 980) {
                  window.location.replace("<?php echo $red; ?>");
              }
          </script>

            <?php
        }
    }
    ?>

  <!-- Meta Pixel Code -->
  <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,'script',
          'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '298588854787027');
      fbq('track', 'PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none"
                 src="https://www.facebook.com/tr?id=298588854787027&ev=PageView&noscript=1"
    /></noscript>
  <!-- End Meta Pixel Code -->
</head>
<body id="top" <?php if(is_white()) { echo 'class="whiteTheme"'; } ?>>
<?php wp_body_open(); ?>



<?php
if($_COOKIE["passchanged"] == 'true') {
    ?>

  <div class="passwerd__reseted">
    <span>Пароль змінено</span>
  </div>

  <script>
      document.cookie = "passchanged=false; path=/";

      setTimeout(function () {
          jQuery('.passwerd__reseted').fadeOut(300);
      }, 4000);

  </script>

    <?php

}
?>


<div class="progress"></div>
<header class="header">
  <div class="container full">
    <div class="header__content flex">
      <div class="header__part">

          <?php the_custom_logo(); ?>

      </div>
      <div class="header__part flex">
        <div class="search__container">
          <div class="search__inner">
            <div class="search__cont">
              <div class="search__title">
                Пошук подій та курсів:
              </div>
              <form action="https://gynecology.com.ua/" role="search" method="get" class="searchm__form flex">
                <input type="search" name="s" class="searchm__input" placeholder="Я шукаю...">
                <input type="hidden" value="product" name="post_type" id="post_type">
                <button class="searchm__button button full"><span>Пошук</span></button>
                <a href="#" onclick="searchToggle()" class="searchm__close"></a>
              </form>
            </div>
          </div>
        </div>

          <?php
          if(is_front_page()) {
              wp_nav_menu( array(
                  'theme_location' => 'menu-2',
                  'menu' => 'menu',
                  'container'        => 'ul',
                  'menu_class'        => 'header__nav flex',
              ) );
          } else {
              wp_nav_menu( array(
                  'theme_location' => 'menu-1',
                  'menu' => 'menu',
                  'container'        => 'ul',
                  'menu_class'        => 'header__nav flex',
              ) );
          }
          ?>
        <a href="#" onclick="searchToggle()" class="search__icon"></a>
        <?PHP
          if(is_user_logged_in()) {
              $user_info = get_userdata(get_current_user_id());
              $first_name = $user_info->first_name;
              if (strlen($first_name) > 16) {
                  $first_name = substr($first_name, 0, 13) . '...';
              }
              ?>

            <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="header__enter logined">
              <span class="headerenter__text"><span>Особистий кабінет</span><span><?php echo $first_name; ?></span></span>
            </a>

              <?php
          } else {
              ?>

            <a href="#" class="header__enter lrm-login">
              <span class="headerenter__text"><span>Особистий кабінет</span><span>Вхід / Реєстрація</span></span>
            </a>

              <?php
          }


          if( have_rows('soczialni_merezhi', 'options') ): ?>
            <ul class="header__soc flex">
                <?php while ( have_rows('soczialni_merezhi', 'options') ) : the_row();
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
      <a href="#" onclick="openNav()" class="nav__close"></a>
    </div>
  </div>
</header>
<div onclick="openNav()" class="nav__underlay"></div>
<a href="#" onclick="openNav()" class="hamburger">
  <span></span>
  <span></span>
  <span></span>
</a>



<div class="wrapper">
