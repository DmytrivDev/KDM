<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package kdm
 */


$url = get_field('posylannya');
$type = get_field('typ_dokumentu');
$typeL = $type['value'];
$typeV = $type['label'];
$typeT = $typeV;
$typeC = 'transparent';

if($typeL == 'yt' || $typeL == 'kdm') {
    $typeT = '';
}

if($typeL == 'pdf') {
    $typeC = '#F15642';
} else if($typeL == 'doc') {
    $typeC = '#334CA8';
} else if($typeL == 'kdm') {
    $typeC = '#43AE4E';
}
?>


<li class="library__item">
  <div class="library__itemtop flex">
    <a href="<?php echo $url; ?>" target="_blank" class="library__icon">
      <span style="background-color: <?php echo $typeC; ?>;" class="library__dockname <?php echo $typeL; ?>"><?php echo $typeT; ?></span>
    </a>
    <a href="<?php echo $url; ?>" target="_blank" class="library__name"><?php the_title(); ?></a>
  </div>
    <?php
    $tags = wp_get_object_terms( get_the_ID(), 'tag' );
    if($tags) {
        echo '<ul class="library__tags flex">';
        foreach ($tags as $tag) {
            echo '<li>' . $tag->name . '</li>';
        }
        echo '</ul>';
    }
    ?>
</li>