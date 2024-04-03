<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package kdm
 */

get_header('none');

$zag = get_field('zag_404', 'options');
$fon = get_field('fon_404', 'options');
?>

  <section class="section__error">
    <div class="container">
      <div class="error__content flex">

          <?php
          if($zag) {
              ?>

            <h1 class="error__title">
                <?php echo $zag; ?>
            </h1>

              <?php
          }
          ?>

        <a href="<?php echo get_home_url(); ?>" class="button big whiteB border error__button">
          <span>На головну</span>
        </a>
      </div>
    </div>

      <?php
      if($fon) {
          ?>

        <img src="<?php echo $fon; ?>" alt="" class="cover">

          <?php
      }
      ?>

  </section>

<?php
get_footer('none');
