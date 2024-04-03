<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package kdm
 */

get_header('none');

$thL = get_the_post_thumbnail_url(get_the_ID(), 'full' );
$tPan = get_field('tekst_u_verhnij_paneli', 'options');
?>

		<?php
		while ( have_posts() ) :
			the_post();
			?>

      <div class="page__cont">
        <div class="newsp__top flex">
          <a href="<?php echo get_home_url(); ?>" class="newsp__back"></a>
          <span><?php echo $tPan; ?></span>
          <div class="news__share">
            <div class="cur"></div>
            <div class="share__list">

                <?php echo do_shortcode('[Sassy_Social_Share]'); ?>

            </div>
          </div>
        </div>
        <div class="newsp__inner popup__cont">
          <div class="container">
            <div class="newsp__content">
              <h2 class="newsp__title">
                  <?php echo get_the_title(); ?>
              </h2>
              <div class="newsp__img">
                <img src="<?php echo $thL; ?>" alt="">
              </div>
              <div class="newsp__text text__wrapp">
                  <?php the_content(); ?>
              </div>

                <?php
                $author = get_the_author();
                $avatar = get_avatar_url(get_the_author_meta('ID'));
                $fname = get_the_author_meta('first_name');
                $lname = get_the_author_meta('last_name');
                $authorName = $lname.' '.$fname;

                if(!$fname && !$lname) {
                    $authorName = the_author_meta( 'nickname', get_the_author_meta('ID') );
                }

                ?>

              <div class="newsp__author flex">

                  <?php
                  if($avatar) {
                      ?>

                    <div class="newsp__authorava">
                      <img src="<?php echo $avatar; ?>" alt="" class="cover">
                    </div>

                      <?php
                  }
                  ?>

                <div class="newsp__authorname"><?php echo $authorName; ?></div>
              </div>
              <div class="newsp__op flex">
                <time class="newsp__date"><?php echo get_the_date(); ?></time>
              </div>
            </div>
          </div>
        </div>
      </div>

    <?php
		endwhile;
		?>


<?php
get_footer('none');