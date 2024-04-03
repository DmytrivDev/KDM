<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kdm
 */

?>

</div>



<?php wp_footer(); ?>

<?php
$transUrl = get_field('storinka_translyacziyi', 'options')->ID;
$eventCur = get_field('podiya', $transUrl);
$isGoing = get_field('status_podiyi', $eventCur);

if($isGoing == 'processing') {
    global $wp_query;
    $pageId = $wp_query->post->ID;

    if($pageId != $transUrl) {
        if(is_user_logged_in()) {
            $userId =  get_current_user_id();
            if ( wc_customer_bought_product( '', $userId, $eventCur) ) {
                ?>
              <a href="<?php echo get_permalink($transUrl); ?>" class="translation__btn">
                <span><span>Трансляція триває</span><span>Дивитись семінар</span></span>
              </a>
                <?php
            }
        }
    }
}

?>

</body>
</html>
