<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$image_id  = $product->get_image_id();
$image_url = wp_get_attachment_image_url( $image_id, 'large' );
$eventDone = get_field('podiya_vidbulas');

if(!$eventDone) {
    $date = get_field('data_podiyi');
    $curDate = strtotime(current_datetime()->format('Y-m-d H:i:s'));
    $evDate = strtotime($date);

    if($evDate <= $curDate) {
        update_field("podiya_vidbulas",1,get_the_ID());
    }
}
?>


<li class="events__item">
  <a href="<?php the_permalink(); ?>" class="event__img">
    <img src="<?php echo $image_url; ?>" alt="<?php the_title(); ?>" class="cover">
  </a>
  <div class="events__info">
    <a href="<?php the_permalink(); ?>" class="events__name">
        <?php the_title(); ?>
    </a>
    <div class="events__desc">
      <?php the_content(); ?>
    </div>
    <div class="events__pricecont flex">
      <div class="event__price">
        <?php echo wc_price($product->get_price()); ?>
      </div>

        <?php
        if($product->get_sale_price()) { ?>

          <div class="event__price old">
            <del><?php echo wc_price($product->get_regular_price()); ?></del>
          </div>

        <?php }
        ?>

    </div>

    <div class="events__btncont">
      <a href="<?php the_permalink(); ?>" class="button border black">
        <span>Дізнатись більше</span>
      </a>
    </div>
  </div>
</li>

