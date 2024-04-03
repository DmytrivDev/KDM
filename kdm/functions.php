<?php
/**
 * kdm functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package kdm
 */

if ( ! defined( '_S_VERSION' ) ) {
    // Replace the version number of the theme on each release.
    define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function kdm_setup() {
    /*
          * Make theme available for translation.
          * Translations can be filed in the /languages/ directory.
          * If you're building a theme based on kdm, use a find and replace
          * to change 'kdm' to the name of your theme in all the template files.
          */
    load_theme_textdomain( 'kdm', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
          * Let WordPress manage the document title.
          * By adding theme support, we declare that this theme does not use a
          * hard-coded <title> tag in the document head, and expect WordPress to
          * provide it for us.
          */
    add_theme_support( 'title-tag' );

    /*
          * Enable support for Post Thumbnails on posts and pages.
          *
          * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
          */
    add_theme_support( 'post-thumbnails' );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(
        array(
            'menu-1' => esc_html__( 'Головне меню', 'kdm' ),
            'menu-2' => esc_html__( 'Головне меню (домашня сторынка)', 'kdm' ),
            'menu-3' => esc_html__( 'Меню в футері', 'kdm' ),
        )
    );

    /*
          * Switch default core markup for search form, comment form, and comments
          * to output valid HTML5.
          */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Set up the WordPress core custom background feature.
    add_theme_support(
        'custom-background',
        apply_filters(
            'kdm_custom_background_args',
            array(
                'default-color' => 'ffffff',
                'default-image' => '',
            )
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support( 'customize-selective-refresh-widgets' );

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );
}
add_action( 'after_setup_theme', 'kdm_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function kdm_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'kdm_content_width', 640 );
}
add_action( 'after_setup_theme', 'kdm_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function kdm_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__( 'Sidebar', 'kdm' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here.', 'kdm' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action( 'widgets_init', 'kdm_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function kdm_scripts() {
    wp_enqueue_style( 'kdm-style', get_stylesheet_uri(), array(), _S_VERSION );
    wp_style_add_data( 'kdm-style', 'rtl', 'replace' );

    wp_enqueue_style( 'kdm-vendorCss', get_template_directory_uri() . '/assets/css/vendor.min.css' );
    wp_enqueue_style( 'kdm-mainCss', get_template_directory_uri() . '/assets/css/main.min.css' );

    wp_enqueue_script( 'kdm-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

    wp_enqueue_script( 'kdm-vendorJs', get_template_directory_uri() . '/assets/js/vendor.min.js', array('jquery'), '1.2', true );
    wp_enqueue_script( 'kdm-customJs', get_template_directory_uri() . '/assets/js/custom.min.js', array('jquery'), '1.2', true );
    wp_register_script( 'ajax_comment', get_stylesheet_directory_uri() . '/assets/js/ajax-comment.js', array('jquery') );

    wp_localize_script( 'ajax_comment', 'misha_ajax_comment_params', array(
        'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php'
    ) );

    wp_enqueue_script( 'ajax_comment' );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'kdm_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
    require get_template_directory() . '/inc/jetpack.php';
}

///////////////////////////////////////////

//Wocommerce category
function mytheme_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );


add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );



function is_white() {
    return (is_shop() || is_home() || is_page_template( 'template-archive.php' ) || is_page_template( 'template-cert.php' ) || is_page_template( 'template-chat.php' ) || is_account_page() || is_archive() || is_author() || is_category() || is_tag() || is_page() && !is_page_template());
}



//Add option page
acf_add_options_page(array(
    'page_title' 	=> 'Опції',
    'menu_title'	=> 'Опції',
    'menu_slug' 	=> 'theme-general-settings',
    'capability'	=> 'edit_posts',
    'redirect'		=> false
));

/////////////////////////////////////////

/**
 * Change a currency symbol
 */
add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);

function change_existing_currency_symbol( $currency_symbol, $currency ) {
    switch( $currency ) {
        case 'UAH': $currency_symbol = 'грн'; break;
    }
    return $currency_symbol;
}



///////////////////////////
///////////////////////////
///////////////////////////
function exclude_featured_post( $query ) {
    if (!is_admin() && is_archive() && is_shop() && $query->is_main_query() && !is_search() ) {

        $meta_query = $query->get('meta_query') ? $query->get('meta_query') : array();

        // append yours
        $meta_query[] = array(
            'key' => 'podiya_vidbulas',
            'value' => true,
            'compare' => '!='
        );

        $tax_query = $query->get('tax_query') ? $query->get('tax_query') : array();

        // append taxonomy query
        $tax_query[] = array(
            'taxonomy' => 'product_cat', // Назва таксономії
            'field' => 'slug',
            'terms' => 'podiyi', // Слаг категорії "podiyi"
        );

        $query->set('meta_query', $meta_query);
        $query->set('tax_query', $tax_query);

    }
}
add_action( 'pre_get_posts', 'exclude_featured_post' );


add_action( 'woocommerce_product_query', 'vzm_product_query_by_meta' );
function vzm_product_query_by_meta( $q ) {
    $meta_key = 'data_podiyi';
    if ( ! isset( $_GET['orderby'] )) {
        $q->set( 'orderby', 'meta_value' );   // for numeric value
        $q->set( 'value', 'date("Y-m-d")' );
        $q->set( 'order', 'ASC' );
        $q->set( 'meta_key', $meta_key);
    }
}



add_action( 'init', 'codex_team_init' );
/**
 * Register a team post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function codex_team_init() {
    $labels = array(
        'name'               => _x( 'Спікер', 'post type general name', 'your-plugin-textdomain' ),
        'singular_name'      => _x( 'Спікери', 'post type singular name', 'your-plugin-textdomain' ),
        'menu_name'          => _x( 'Спікери', 'admin menu', 'your-plugin-textdomain' ),
        'name_admin_bar'     => _x( 'Спікер', 'add new on admin bar', 'your-plugin-textdomain' ),
        'add_new'            => _x( 'Створити', 'спікера', 'your-plugin-textdomain' ),
        'add_new_item'       => __( 'Створити спікера', 'your-plugin-textdomain' ),
        'new_item'           => __( 'Новий спікер', 'your-plugin-textdomain' ),
        'edit_item'          => __( 'Редагувати спікера', 'your-plugin-textdomain' ),
        'view_item'          => __( 'Переглянути спікер', 'your-plugin-textdomain' ),
        'all_items'          => __( 'Всі спікери', 'your-plugin-textdomain' ),
        'search_items'       => __( 'Знайти спікера', 'your-plugin-textdomain' ),
        'parent_item_colon'  => __( 'Родитель:', 'your-plugin-textdomain' ),
        'not_found'          => __( 'Спікерів не знайдено.', 'your-plugin-textdomain' ),
        'not_found_in_trash' => __( 'В кршику екмає спікерів.', 'your-plugin-textdomain' )
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Description.', 'your-plugin-textdomain' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'team' ),
        'capability_type'    => 'page',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'thumbnail', 'title', 'editor' ),
    );

    register_post_type( 'team', $args );
}



function custom_remove_all_quantity_fields( $return, $product ) {return true;}
add_filter( 'woocommerce_is_sold_individually','custom_remove_all_quantity_fields', 10, 2 );

add_action('woocommerce_single_product_options', 'woocommerce_template_single_price', 10);
add_action('woocommerce_single_product_options', 'woocommerce_template_single_add_to_cart', 30);



add_action( 'woocommerce_after_single_product_reviews', 'your_theme_review_replacing_reviews_position');

function your_theme_review_replacing_reviews_position()
{
    comments_template();
}

add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['reviews'] );

    return $tabs;
}


function get_pros_cons_fields_html() {
    ob_start();
    ?>

  <div class="form-submit submitN">
    <a href="#" onclick="subRev($(this))" class="button big full review__button">
      <span>Опублікувати</span>
    </a>
  </div>

    <?php
    return ob_get_clean();
}


add_filter( 'comment_form_field_comment', 'render_pros_cons_fields', 99, 1 );
function render_pros_cons_fields( $comment_field ) {
    if ( ! is_product() ) {
        return $comment_field;
    }

    return $comment_field . get_pros_cons_fields_html();
}




add_action( 'wp_ajax_ajaxcomments', 'misha_submit_ajax_comment' );
add_action( 'wp_ajax_nopriv_ajaxcomments', 'misha_submit_ajax_comment' );

function misha_submit_ajax_comment(){

    $comment = wp_handle_comment_submission( wp_unslash( $_POST ) );
    if ( is_wp_error( $comment ) ) {
        $error_data = intval( $comment->get_error_data() );
        if ( ! empty( $error_data ) ) {
            wp_die( '<p>' . $comment->get_error_message() . '</p>', __( 'Comment Submission Failure' ), array( 'response' => $error_data, 'back_link' => true ) );
        } else {
            wp_die( 'Unknown error' );
        }
    }

    $user = wp_get_current_user();
    do_action('set_comment_cookies', $comment, $user);

    $comment_depth = 1;
    $comment_parent = $comment->comment_parent;
    while( $comment_parent ){
        $comment_depth++;
        $parent_comment = get_comment( $comment_parent );
        $comment_parent = $parent_comment->comment_parent;
    }


    $GLOBALS['comment'] = $comment;
    $GLOBALS['comment_depth'] = $comment_depth;
    $rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );


    $comment_html = '<li class="review byuser comment-author-admin bypostauthor odd alt thread-odd thread-alt depth-1">
		<div id="comment-' . get_comment_ID() . '" class="comment_container">
		  <div class="comment-text">
		    <div class="star-rating" role="img" aria-label="Оцінено в '.$rating.' з 5"><div class="stars"><span class="star-'.$rating.'"><span class="star-1"></span><span class="star-2"></span><span class="star-3"></span><span class="star-4"></span><span class="star-5"></span></span></div></div>
			  <p class="meta">
				<strong class="woocommerce-review__author">' . get_comment_author() . '</strong>
				<time class="woocommerce-review__published-date">
					<span>' . get_comment_date() . '</span></time>';


    $comment_html .= '</p>';
    if ( $comment->comment_approved == '0' )
        $comment_html .= '<p style="margin-bottom: 1em;" class="comment-awaiting-moderation">Ваш відгук в очікуванні модерації.</p>';

    $comment_html .= '<div class="description">' . apply_filters( 'comment_text', get_comment_text( $comment ), $comment ) . '</div>
		 </div>
	  </div>
	</li>';
    echo $comment_html;

    die();

}




function wp_custom_pagination($args = [], $class = 'pagination') {
    if ($GLOBALS['wp_query']->max_num_pages <= 1) return;

    $args = wp_parse_args( $args, [
        'mid_size'  => 2,
        'end_size'  => 1,
        'prev_text' => '',
        'next_text' => '',
        'screen_reader_text' => __('Posts navigation', 'textdomain'),
    ]);

    $links       = paginate_links($args);
    $next_link = get_previous_posts_link($args['next_text']);
    $prev_link = get_next_posts_link($args['prev_text']);
    $template    = apply_filters( 'navigation_markup_template', '
    <div class="events__bottom flex">
        <nav class="paging-navigation">
          <div class="nav-links">
            <div class="pages">'.$links.'</li>
          </div>
        </nav>
    </div>
    ', $args, $class);

    echo sprintf($template, $class, $args['screen_reader_text'], $prev_link, $links, $next_link);
}





// Remove category archives
add_action('template_redirect', 'jltwp_adminify_remove_archives_category');
function jltwp_adminify_remove_archives_category()
{
    if (is_category() || is_tag() || is_author()){
        $target = get_option('siteurl');
        $status = '301';
        wp_redirect($target, 301);
        die();
    }
}



//function wpb_filter_query( $query, $error = true ) {
//    if ( is_search() ) {
//        $query->is_search = false;
//        $query->query_vars['s'] = false;
//        $query->query['s'] = false;
//        if ( $error == true )
//            $query->is_404 = true;
//    }
//}
//add_action( 'parse_query', 'wpb_filter_query' );
//add_filter( 'get_search_form', create_function( '$a', "return null;" ) );
//function remove_search_widget() {
//    unregister_widget('WP_Widget_Search');
//}
//add_action( 'widgets_init', 'remove_search_widget' );




function post_pagination($paged = '', $max_page = '') {
    if (!$paged) {
        $paged = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);
    }

    if (!$max_page) {
        global $wp_query;
        $max_page = isset($wp_query->max_num_pages) ? $wp_query->max_num_pages : 1;
    }

    $big  = 999999999;

    $html = paginate_links(array(
        'base'       => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format'     => '?paged=%#%',
        'current'    => max(1, $paged),
        'total'      => $max_page,
        'mid_size'  => 2,
        'end_size'  => 1,
        'prev_text'  => __(''),
        'next_text'  => __(''),
    ));

    $html = '<div class="events__bottom flex">
        <nav class="paging-navigation">
          <div class="nav-links">
            <div class="pages">'.$html.'</li>
          </div>
        </nav>
    </div>';

    echo $html;
}


/////////////////////
/////////////////////
/////////////////////
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );


/////////////////////
////// Library //////
/////////////////////
add_action( 'init', 'codex_library_init' );
/**
 * Register a team post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function codex_library_init() {
    $labels = array(
        'name'               => _x( 'Документ', 'post type general name', 'your-plugin-textdomain' ),
        'singular_name'      => _x( 'Документ', 'post type singular name', 'your-plugin-textdomain' ),
        'menu_name'          => _x( 'Документи', 'admin menu', 'your-plugin-textdomain' ),
        'name_admin_bar'     => _x( 'Документ', 'add new on admin bar', 'your-plugin-textdomain' ),
        'add_new'            => _x( 'Створити', 'документ', 'your-plugin-textdomain' ),
        'add_new_item'       => __( 'Створити документ', 'your-plugin-textdomain' ),
        'new_item'           => __( 'Новий документ', 'your-plugin-textdomain' ),
        'edit_item'          => __( 'Редагувати документ', 'your-plugin-textdomain' ),
        'view_item'          => __( 'Переглянути документ', 'your-plugin-textdomain' ),
        'all_items'          => __( 'Всі документи', 'your-plugin-textdomain' ),
        'search_items'       => __( 'Знайти документ', 'your-plugin-textdomain' ),
        'parent_item_colon'  => __( 'Родитель:', 'your-plugin-textdomain' ),
        'not_found'          => __( 'Документів не знайдено.', 'your-plugin-textdomain' ),
        'not_found_in_trash' => __( 'В кошику екмає документів.', 'your-plugin-textdomain' )
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Description.', 'your-plugin-textdomain' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'library' ),
        'capability_type'    => 'page',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title' )
    );

    register_post_type( 'library', $args );
}



function fq_disable_single_cpt_views() {
    $queried_post_type = get_query_var('post_type');
    $cpts_without_single_views = array( 'library' );
    if ( is_single() && in_array( $queried_post_type, $cpts_without_single_views )  ) {
        wp_redirect( home_url( '/' . $queried_post_type . '/' ), 301 );
        exit;
    }
}

add_action( 'template_redirect', 'fq_disable_single_cpt_views' );


// Format //
add_action( 'init', 'create_format_taxonomies', 0 );
//create two taxonomies, genres and tags for the post type "tag"
function create_format_taxonomies()
{
    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
        'name' => _x( 'Формати', 'taxonomy general name' ),
        'singular_name' => _x( 'Формат', 'taxonomy singular name' ),
        'search_items' =>  __( 'Знайти  формат' ),
        'popular_items' => __( 'Популярні формати' ),
        'all_items' => __( 'Усі формати' ),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Редагувати формат' ),
        'update_item' => __( 'Оновити формат' ),
        'add_new_item' => __( 'Додати новий формат' ),
        'new_item_name' => __( 'Назва нового формату' ),
        'separate_items_with_commas' => __( 'Розділіть формати комою' ),
        'add_or_remove_items' => __( 'Додати або видалити формат' ),
        'choose_from_most_used' => __( 'Обрати з найпопулярніших форматів' ),
        'menu_name' => __( 'Формати' ),
    );

    register_taxonomy('format','library',array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'format' ),
    ));
}




// Typw //
add_action( 'init', 'create_type_taxonomies', 0 );
//create two taxonomies, genres and tags for the post type "tag"
function create_type_taxonomies()
{
    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
        'name' => _x( 'Типи', 'taxonomy general name' ),
        'singular_name' => _x( 'Тип', 'taxonomy singular name' ),
        'search_items' =>  __( 'Знайти  тип' ),
        'popular_items' => __( 'Популярні типи' ),
        'all_items' => __( 'Усі теги' ),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Редагувати тип' ),
        'update_item' => __( 'Оновити тип' ),
        'add_new_item' => __( 'Додати новий тип' ),
        'new_item_name' => __( 'Назва нового типу' ),
        'separate_items_with_commas' => __( 'Розділіть типи комою' ),
        'add_or_remove_items' => __( 'Додати або видалити тип' ),
        'choose_from_most_used' => __( 'Обрати з найпопулярніших типів' ),
        'menu_name' => __( 'Типи' ),
    );

    register_taxonomy('type','library',array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'type' ),
    ));
}


// Tag //
add_action( 'init', 'create_tag_taxonomies', 0 );
//create two taxonomies, genres and tags for the post type "tag"
function create_tag_taxonomies()
{
    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
        'name' => _x( 'Теги', 'taxonomy general name' ),
        'singular_name' => _x( 'Тег', 'taxonomy singular name' ),
        'search_items' =>  __( 'Знайти  тег' ),
        'popular_items' => __( 'Популярні теги' ),
        'all_items' => __( 'Усі теги' ),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Редагувати тег' ),
        'update_item' => __( 'Оновити тег' ),
        'add_new_item' => __( 'Додати новий тег' ),
        'new_item_name' => __( 'Назва нового тегу' ),
        'separate_items_with_commas' => __( 'Розділіть теги комою' ),
        'add_or_remove_items' => __( 'Додати або видалити тег' ),
        'choose_from_most_used' => __( 'Обрати з найпопулярніших тегів' ),
        'menu_name' => __( 'Теги' ),
    );

    register_taxonomy('tag','library',array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'tag' ),
    ));
}



/////////////////////////
/////////////////////////
/////////////////////////
add_action('init','custom_login');
function custom_login(){
    global $pagenow;

    $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    $params = parse_url($link);
    parse_str($params['query'], $params);
    $login = $params['login'];
    $user = get_userdatabylogin($login);
    $userId = $user->ID;

    if( 'wp-login.php' == $pagenow && $params['action'] == 'rp') {
        wp_redirect( get_site_url() . "/?somresetpass=true&somfrp_action=rp&key=" . $params['key'] . "&uid=" . $userId, 301 );
        exit();
    }
}




add_filter ( 'woocommerce_account_menu_items', 'my_remove_my_account_links' );
function my_remove_my_account_links( $menu_links ){

    unset($menu_links['dashboard']);
    unset($menu_links['downloads']);
    unset($menu_links['edit-address']);
    unset($menu_links['customer-logout']);

    return $menu_links;
}


add_filter ( 'woocommerce_account_menu_items', 'wpsh_custom_endpoint', 40 );
function wpsh_custom_endpoint( $menu_links ){
    $current_user = wp_get_current_user();
    $user_roles = $current_user->roles;
    $first_role = reset($user_roles);
    $isEmp = false;

    if($first_role == 'employee' || $first_role == 'administrator') {
        $isEmp = true;
    }

    if(!$isEmp) {
        $menu_links = array_slice( $menu_links, 0, 5, true )
            + array( 'tests' => 'Мої тести' )
            + array( 'sertificats' => 'Мої сертифікати' )
            + array_slice( $menu_links, 5, NULL, true );

        return $menu_links;
    } else {
        $menu_links = array_slice( $menu_links, 0, 5, true )
            + array( 'tests' => 'Мої тести' )
            + array_slice( $menu_links, 5, NULL, true );

        return $menu_links;
    }
}


add_action( 'init', 'wpsh_new_endpoint' );
function wpsh_new_endpoint() {
    add_rewrite_endpoint( 'actual', EP_PAGES ); // Don’t forget to change the slug here
    add_rewrite_endpoint( 'courses', EP_PAGES ); // Don’t forget to change the slug here
    add_rewrite_endpoint( 'tests', EP_PAGES ); // Don’t forget to change the slug here
    add_rewrite_endpoint( 'sertificats', EP_PAGES ); // Don’t forget to change the slug here
    add_rewrite_endpoint( 'course', EP_PAGES ); // Don’t forget to change the slug here
}




add_action('woocommerce_account_actual_endpoint', function() {
    $actual = [];  // Replace with function to return licenses for current logged in user

    wc_get_template('myaccount/actual.php', [
        'actual' => $actual
    ]);
});

add_action('woocommerce_account_courses_endpoint', function() {
    $courses = [];  // Replace with function to return licenses for current logged in user

    wc_get_template('myaccount/courses.php', [
        'courses' => $courses
    ]);
});

add_action('woocommerce_account_course_endpoint', function() {
    $course = [];  // Replace with function to return licenses for current logged in user

    wc_get_template('myaccount/course.php', [
        'course' => $course
    ]);
});


add_action('woocommerce_account_tests_endpoint', function() {
    $tests = [];  // Replace with function to return licenses for current logged in user

    wc_get_template('myaccount/tests.php', [
        'tests' => $tests
    ]);
});



add_action('woocommerce_account_sertificats_endpoint', function() {
    $sertificats = [];  // Replace with function to return licenses for current logged in user

    wc_get_template('myaccount/sertificats.php', [
        'sertificats' => $sertificats
    ]);
});


add_filter ( 'woocommerce_account_menu_items', 'wpsh_custom_endpoint_order' );
function wpsh_custom_endpoint_order() {
    $isUn = false;
    $mode_cookie = isset($_COOKIE['mode']) ? $_COOKIE['mode'] : '';
    if($mode_cookie == 1) {
        $isUn = true;
    }

    if(!$isUn) {
        $myorder = array(
            'actual'             => __( 'Актуальні події', 'woocommerce' ),
            'orders'             => __( 'Завершені події', 'woocommerce' ),
            'courses'            => __( 'Курси', 'woocommerce' ),
            'edit-account'       => __( 'Особисті дані', 'woocommerce' ),
            'tests'              => __( 'Мої тести', 'woocommerce' ),
            'sertificats'        => __( 'Мої сертифікати', 'woocommerce' ),
        );

        return $myorder;
    } else {
        $myorder = array(
            'actual'             => __( 'Актуальні курси', 'woocommerce' ),
            'orders'             => __( 'Завершені курси', 'woocommerce' ),
            'tests'              => __( 'Мої тести', 'woocommerce' ),
            'edit-account'       => __( 'Особисті дані', 'woocommerce' ),
        );

        return $myorder;
    }

}


add_action('wp_logout','njengah_homepage_logout_redirect');
function njengah_homepage_logout_redirect(){
    wp_redirect( home_url() );
    exit;
}
define( 'DB_NAME', "drmedved_dev" );

/** Database username */
define( 'DB_USER', "drmedved_dev" );

/** Database password */
define( 'DB_PASSWORD', "3R2)R^3tnx" );

/** Database hostname */
define( 'DB_HOST', "drmedved.mysql.tools" );




function iconic_remove_password_strength() {
    wp_dequeue_script( 'wc-password-strength-meter' );
}
add_action( 'wp_print_scripts', 'iconic_remove_password_strength', 10 );






add_action('wp_ajax_save_account_details', 'save_account_details');
add_action('wp_ajax_nopriv_save_account_details', 'save_account_details');
function save_account_details() {

    $response = '';
    $user_ID = get_current_user_id();
    $user = wp_get_current_user();
    $login = $user->user_login;
    $fN = $_POST['account_first_name'];
    $lN = $_POST['account_last_name'];
    $email = $_POST['account_email'];
    $phone = $_POST['billing_phone'];
    $spec = $_POST['billing_speciality'];
    $place = $_POST['billing_place'];
    $post = $_POST['billing_post'];
    $date = $_POST['billing_date'];
    $password = $_POST['password_current'];
    $password1 = $_POST['password_1'];
    $password2 = $_POST['password_2'];

    if(!$password && !$password1 && !$password2) {
        if(!$fN) {
            $response .= "<p class='error'><b>Іи'я</b> - обов'язкове поле</p>";
        }
        if(!$lN) {
            $response .= "<p class='error'><b>Прізвище</b> - обов'язкове поле</p>";
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response .= "<p class='error'><b>E-mail адреса</b> - обов'язкове поле і має бути введене коректно</p>";
        }
        if(!$phone) {
            $response .= "<p class='error'><b>Номер телефону</b> - обов'язкове поле</p>";
        }
        if(!$spec) {
            $response .= "<p class='error'><b>Спецільність</b> - обов'язкове поле</p>";
        }
        if(!$place) {
            $response .= "<p class='error'><b>Місце роботи</b> - обов'язкове поле</p>";
        }
        if(!$post) {
            $response .= "<p class='error'><b>Посада</b> - обов'язкове поле</p>";
        }
        if(!$date) {
            $response .= "<p class='error'><b>Дата народження</b> - обов'язкове поле</p>";
        }

        if($fN && $lN && filter_var($email, FILTER_VALIDATE_EMAIL) && $phone && $spec && $place && $post && $date) {
            wp_update_user( array(
                'ID' => $user_ID,
                'first_name' => $fN,
                'last_name' => $lN,
                'user_email' => $email,
                'billing_phone' => $phone,
            ) );

            update_user_meta( $user_ID, 'billing_phone', $phone );
            update_user_meta( $user_ID, 'billing_speciality', $spec );
            update_user_meta( $user_ID, 'billing_place', $place );
            update_user_meta( $user_ID, 'billing_post', $post );
            update_user_meta( $user_ID, 'billing_date', $date );
            $response .= "<p class='mess'>Ваші дані успішно оновленні</p>";
        }

    } else {
        $credentials = [
            'user_login' => $login,
            'user_password' => $password,
            'rememberme' => true,
        ];

        $signon = wp_signon($credentials, true);

        if(is_wp_error($signon) || !$password) {
            $response .= "Пароль неправильний";
        } else {
            if(!$password1) {
                $response .= "Введіть новий пароль";
            } else {
                if($password1 != $password2) {
                    $response .= "Паролі не співпадають";
                } else {
                    wp_update_user( array(
                        'ID' => $user_ID,
                        'user_pass' => $password2
                    ) );

                    $response .= "<p class='mess'>Пароль успішно змінено</p>";
                }
            }
        }
    }

    // Don't forget to exit at the end of processing
    echo $response;
    die();

}

add_action('wp_ajax_save_additional_details', 'save_additional_details');
add_action('wp_ajax_nopriv_save_additional_details', 'save_additional_details');
function save_additional_details() {

    $response = '';
    $user_ID = get_current_user_id();
    $spec = $_POST['billing_speciality'];
    $place = $_POST['billing_place'];
    $post = $_POST['billing_post'];
    $date = $_POST['billing_date'];

    update_user_meta( $user_ID, 'billing_speciality', $spec );
    update_user_meta( $user_ID, 'billing_place', $place );
    update_user_meta( $user_ID, 'billing_post', $post );
    update_user_meta( $user_ID, 'billing_date', $date );

    $response = $place;

    echo $response;
    die();

}


add_filter( 'woocommerce_add_to_cart_validation', 'woocommerce_add_to_cart_validation', 10, 3 );

function woocommerce_add_to_cart_validation( $is_valid, $product_id, $quantity ) {

    // Перевіряємо, чи вже є товар у кошику
    if (WC()->cart->get_cart_contents_count() > 0) {
        wc_add_notice( 'В кошику може бути тільки один товар', 'error' );
        return false;
    }

    return $is_valid;
}





/**
 * Helper function to see if a customer has purchased a product
 * in a given category
 *
 * @param \WC_Product $product the WooCommerce product instance
 * @return bool - true if product is in category and has been purchased
 */
function sv_wc_customer_purchased_product_in_cat( $product ) {

    // enter the category for which a single purchase is allowed
    $non_repeatable = 'uncategorized';

    // bail if this product is in not in our target category
    if ( ! has_term( $non_repeatable, 'product_cat', $product->get_id() ) ) {
        return false;
    }

    // the product has our target category, so return whether the customer purchased
    return wc_customer_bought_product( wp_get_current_user()->user_email, get_current_user_id(), $product->get_id() );
}


/**
 * Disables repeat purchase for a product category; checks if a product is in the category
 * and if it's already been purchased, then disables purchasing if so
 *
 * @param bool $purchasable true if product can be purchased
 * @param \WC_Product $product the WooCommerce product
 * @return bool - the updated is_purchasable check
 */
function sv_wc_disable_repeat_purchase( $purchasable, $product ) {

    if ( sv_wc_customer_purchased_product_in_cat( $product ) ) {
        $purchasable = false;
    }


    return $purchasable;
}
add_filter( 'woocommerce_variation_is_purchasable', 'sv_wc_disable_repeat_purchase', 10, 2 );
add_filter( 'woocommerce_is_purchasable', 'sv_wc_disable_repeat_purchase', 10, 2 );


/**
 * Shows a "purchase disabled" message to the customer
 */
function sv_wc_purchase_disabled_message() {

    // get the current product to check if purchasing should be disabled
    global $product;

    // now we know we're in the category, check if we've purchased already
    if ( sv_wc_customer_purchased_product_in_cat( $product ) ) {
        // Create your message for the customer here
        echo '<div class="woocommerce"><div class="woocommerce-info wc-nonpurchasable-message">
        You\'ve already purchased this product! It can only be purchased once.
        </div></div>';
    }
}
add_action( 'woocommerce_single_product_summary', 'sv_wc_purchase_disabled_message', 31 );








//add_filter( 'woocommerce_payment_complete_order_status', function( $status, $order_id, $order ) {
//    $order->update_status( 'completed' );
//    return 'completed';
//}, 10, 3 );

add_action('woocommerce_checkout_order_processed', 'check_order_amount', 10, 1);

function check_order_amount($order_id) {
    // Отримуємо об'єкт замовлення за його ідентифікатором
    $order = wc_get_order($order_id);

    // Перевіряємо, чи дорівнює сума замовлення 0
    if ($order->get_total() == 0) {
        // Якщо так, змінюємо статус замовлення на "виконано"
        $order->update_status('completed');
    }
}




add_action( 'wp_footer', 'custom_checkout_jquery_script' );
function custom_checkout_jquery_script() {
    if ( is_checkout() && ! is_wc_endpoint_url() ) :
        ?>
      <script type="text/javascript">

        //To detect woocommerce error trigger JS event
        jQuery( document.body ).on( 'checkout_error', function(event){
          var
            errorList = jQuery('.woocommerce-error li');

          errorList.each(function () {
            if(jQuery(this).is(':contains("Обліковий запис вже зареєстровано")')) {
              var
                email = jQuery('#billing_email').val();

              jQuery('.lrm-user-modal').addClass('is-visible');
              jQuery('.lrm-signin-section').addClass('is-selected');
              jQuery('.lrm-signin-section').find('input[name="username"]').val(email);
              jQuery('.lrm-reset-password-section, .lrm-signin-section').addClass('marginLess');
              jQuery('.lrm-switcher').html('<li class="needAuthLi"><div class="needAuthText">Ваша електронна пошта вже зареєстрована</div><h2 class="needAuthTitle">Авторизуйтесь, щоб продовжити покупку</h2></li>');

            }
          });

        } );

      </script>
    <?php
    endif;
}




////////////////////////////
////////////////////////////
////////////////////////////
add_action('save_post','save_post_callback');
function save_post_callback($post_id){
    global $post;
    if ($post->post_type == 'product'){
        $status = get_field('status_podiyi', $post_id);

        //Translation
        $stream = get_field('streem', $post_id);
        $sendSt = get_field('send_start', $post_id);
        $sendedSt = get_field('start_sended', $post_id);

        if($status == 'panding' && $stream) {
            update_field('status_podiyi', 'processing', $post_id);
        }

        //Testing
        $startTest = get_field('pochaty_testuvannya', $post_id);
        $sendTest = get_field('vidpravyty_test', $post_id);
        $sendedTest = get_field('test_sended', $post_id);

        if($status == 'processing' && $startTest) {
            update_field('status_podiyi', 'testing', $post_id);
        }

        //Translation
        if($sendSt && !$sendedSt) {
            $title = get_the_title($post_id);
            $newDate = strtotime(get_field('data_podiyi', $post_id));
            $date = date_i18n("H:i", $newDate);
            $transUrl = get_field('storinka_translyacziyi', 'options');

            global $wpdb;
            $statuses = array_map( 'esc_sql', wc_get_is_paid_statuses() );
            $customer_emails = $wpdb->get_col( "
            SELECT DISTINCT pm.meta_value FROM {$wpdb->posts} AS p
            INNER JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id
            INNER JOIN {$wpdb->prefix}woocommerce_order_items AS i ON p.ID = i.order_id
            INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS im ON i.order_item_id = im.order_item_id
            WHERE p.post_status IN ( 'wc-" . implode( "','wc-", $statuses ) . "' )
            AND pm.meta_key IN ( '_billing_email' )
            AND im.meta_key IN ( '_product_id', '_variation_id' )
            AND im.meta_value = $post_id
         " );

            $name = get_bloginfo('name');
            $adEm = get_bloginfo('admin_email');
            $headers = array(
                'From: '.$name.' <'.$adEm.'>',
                'Reply-To: '.$name.' <'.$adEm.'>',
                'content-type: text/html',
            );

            $subject = '<!DOCTYPE html>
            <html <?php language_attributes(); ?>
              <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <title>Нагадування про трансляцію</title>
              </head>
              <body marginwidth="0" topmargin="0" marginheight="0" offset="0">
                <div style="width:100%;min-width:700px;font-family:Arial;font-size:16px;line-height:20px;color:#000;background-image:url('.get_site_url().'/wp-content/themes/kdm/assets/img/backgrounds/bg2.png);background-repeat:repeat;background-position:center center;background-size:cover;padding-top:15px">
                  <table width="700" border="0" cellpadding="25" cellspacing="0" style="width: 700px;margin: 0 auto">
                    <tr>
                      <td valign="middle" style="padding-bottom: 0">
                        <table border="0" width="650" cellpadding="0" cellspacing="0">
                          <tr>
                            <td valign="middle" align="center">
                              <a href="'.get_site_url().'" target="_blank" style="width: 200px;display: block"><img src="'.get_site_url().'/wp-content/uploads/2023/01/logo.png" style="width: 100%;height: auto" alt="" /></a>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td valign="middle" style="padding-top: 70px; padding-bottom: 0;">
                        <table border="0" width="650" cellpadding="0" cellspacing="0">
                          <tr>
                            <td valign="middle" align="center">
                              <p style="text-align: center; font-size: 21px; line-height: 36px; font-weight: 800; color: #06ac5b; margin: 0;">Трансляція розпочинається сьогодні о '.$date.'</p>
                              <p style="text-align: center; margin-bottom: 0; margin-top: 11px; font-size: 14px; line-height: 24px; color: #808080;">Онлайн семінар “'.$title.'” розпочнеться зовсім скоро</p>
                            </td>
                          </tr>
                        </table>
                      </td>   
                    </tr>
                    <tr>
                      <td valign="middle" style="padding-top: 56px;padding-bottom: 0">
                        <table border="0" width="650" cellpadding="0" cellspacing="0">
                          <tr>
                            <td valign="middle" width="100%" align="center" style="padding: 0;border: none">
                              <p style="text-align: center;color: grey;margin: 0;"><a href="'.get_permalink($transUrl->ID).'" target="_blank" style="padding: 18px 60px;border-radius: 50px;color:#fff;background-color: #43AE4E;font-size: 15px;line-height: 19px;text-decoration: none;display: inline-block;font-weight: 600;">Дивитись трансляцію</a></p>
                              <p style="text-align: center;color: #000;margin-top: 15px;margin-bottom: 0; font-size: 14px; line-height: 21px;">Трансляція доступна у вашому <a href="'.get_permalink( get_option('woocommerce_myaccount_page_id') ).'" style="color: #1A325C; text-decoration: underline;">особистому кабінеті</a></p>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td valign="middle" style="padding-top: 100px;padding-bottom: 0">
                        <table border="0" width="650" cellpadding="0" cellspacing="0" style="border-top: 1px solid #ececec">
                          <tr>
                            <td valign="middle" width="50%" style="padding: 25px 0;border: none"><p style="font-size: 12px;line-height: 14px;color: grey;margin: 0">© 2016-'.date("Y").' KDM CME project.</p></td>
                            <td valign="middle" width="50%" align="center" style="padding: 25px 0;border: none">
                              <p style="font-size: 12px;line-height: 14px;color: grey;margin: 0;text-align: right">
                                <a href="'.get_site_url().'/public/" target="_blank" style="display: inline-block;color: #1a325c;margin-right: 15px;font-size: 12px;line-height: 14px">Публічний договір</a><a style="color: #1a325c;font-size: 12px;line-height: 14px" target="_blank" href="'.get_site_url().'/privacy-policy/">Політика кон-сті</a>
                              </p>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </div>
              </body>
            </html>';

            foreach ($customer_emails as &$mail) {
                $sendAgree = false;
                $orderArg = array(
                    'customer' => $mail,
                    'limit' => -1,
                );

                $orders = wc_get_orders($orderArg);
                if($orders){
                    foreach ($orders as $order) {
                        $order_status  = $order->get_status();

                        if($order_status == 'completed') {
                            $items = $order->get_items();
                            foreach ( $items as $item_id => $item ) {
                                $product_id = $item->get_product_id();
                                if ( $product_id == $post_id ) {
                                    $sendAgree = true;
                                    break;
                                }
                            }
                        }
                    }
                }

                if($sendAgree) {
                    wp_mail( $mail, 'Нагадування про трансляцію', $subject, $headers );
                }
            }

            update_field('start_sended', true, $post_id);
        }

        //Test
        if($sendTest && !$sendedTest) {
            $title = get_the_title($post_id);

            global $wpdb;
            $statuses = array_map( 'esc_sql', wc_get_is_paid_statuses() );
            $customer_emails = $wpdb->get_col( "
              SELECT DISTINCT pm.meta_value FROM {$wpdb->posts} AS p
              INNER JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id
              INNER JOIN {$wpdb->prefix}woocommerce_order_items AS i ON p.ID = i.order_id
              INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS im ON i.order_item_id = im.order_item_id
              WHERE p.post_status IN ( 'wc-" . implode( "','wc-", $statuses ) . "' )
              AND pm.meta_key IN ( '_billing_email' )
              AND im.meta_key IN ( '_product_id', '_variation_id' )
              AND im.meta_value = $post_id
           " );

            $name = get_bloginfo('name');
            $adEm = get_bloginfo('admin_email');
            $headers = array(
                'From: '.$name.' <'.$adEm.'>',
                'Reply-To: '.$name.' <'.$adEm.'>',
                'content-type: text/html',
            );

            foreach ($customer_emails as &$mail) {
                $orderUrl = '';
                $orderArg = array(
                    'customer' => $mail,
                    'limit' => -1,
                );

                $orders = wc_get_orders($orderArg);
                if($orders){
                    foreach ($orders as $order) {
                        $order_status  = $order->get_status();

                        if($order_status == 'completed') {
                            $items = $order->get_items();
                            foreach ( $items as $item_id => $item ) {
                                $product_id = $item->get_product_id();
                                if ( $product_id == $post_id ) {
                                    $orderUrl = $order->get_view_order_url();
                                    break;
                                }
                            }
                        }
                    }
                }

                if($orderUrl) {
                    $orderUrl = $orderUrl.'?tab=test';

                    $subject = '<!DOCTYPE html>
                    <html <?php language_attributes(); ?>
                      <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                        <title>Нагадування про тестування</title>
                      </head>
                      <body marginwidth="0" topmargin="0" marginheight="0" offset="0">
                        <div style="width:100%;min-width:700px;font-family:Arial;font-size:16px;line-height:20px;color:#000;background-image:url('.get_site_url().'/wp-content/themes/kdm/assets/img/backgrounds/bg2.png);background-repeat:repeat;background-position:center center;background-size:cover;padding-top:15px">
                          <table width="700" border="0" cellpadding="25" cellspacing="0" style="width: 700px;margin: 0 auto">
                            <tr>
                              <td valign="middle" style="padding-bottom: 0">
                                <table border="0" width="650" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td valign="middle" align="center">
                                      <a href="'.get_site_url().'" target="_blank" style="width: 200px;display: block"><img src="'.get_site_url().'/wp-content/uploads/2023/01/logo.png" style="width: 100%;height: auto" alt="" /></a>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td valign="middle" style="padding-top: 70px; padding-bottom: 0;">
                                <table border="0" width="650" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td valign="middle" align="center">
                                      <p style="text-align: center; font-size: 21px; line-height: 36px; font-weight: 800; color: #06ac5b; margin: 0;">Тест вже доступний</p>
                                      <p style="text-align: center; margin-bottom: 0; margin-top: 11px; font-size: 14px; line-height: 24px; color: #808080;">Щоб отримати сертифікат про відвідування семінару “'.$title.'” пройдіть онлайн тест</p>
                                    </td>
                                  </tr>
                                </table>
                              </td>   
                            </tr>
                            <tr>
                              <td valign="middle" style="padding-top: 56px;padding-bottom: 0">
                                <table border="0" width="650" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td valign="middle" width="100%" align="center" style="padding: 0;border: none">
                                      <p style="text-align: center;color: grey;margin: 0;"><a href="'.$orderUrl.'" target="_blank" style="width: 282px; padding: 18px 60px;border-radius: 50px;color:#fff;background-color: #43AE4E;font-size: 15px;line-height: 19px;text-decoration: none;display: inline-block;font-weight: 600;">Пройти тест</a></p>
                                      <p style="text-align: center;color: #000;margin-top: 15px;margin-bottom: 0; font-size: 14px; line-height: 21px;">Тест доступний у вашому <a href="'.get_permalink( get_option('woocommerce_myaccount_page_id') ).'/tests/" style="color: #1A325C; text-decoration: underline;">особистому кабінеті</a></p>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td valign="middle" style="padding-top: 100px;padding-bottom: 0">
                                <table border="0" width="650" cellpadding="0" cellspacing="0" style="border-top: 1px solid #ececec">
                                  <tr>
                                    <td valign="middle" width="50%" style="padding: 25px 0;border: none"><p style="font-size: 12px;line-height: 14px;color: grey;margin: 0">© 2016-'.date("Y").' KDM CME project.</p></td>
                                    <td valign="middle" width="50%" align="center" style="padding: 25px 0;border: none">
                                      <p style="font-size: 12px;line-height: 14px;color: grey;margin: 0;text-align: right">
                                        <a href="'.get_site_url().'/public/" target="_blank" style="display: inline-block;color: #1a325c;margin-right: 15px;font-size: 12px;line-height: 14px">Публічний договір</a><a style="color: #1a325c;font-size: 12px;line-height: 14px" target="_blank" href="'.get_site_url().'/privacy-policy/">Політика кон-сті</a>
                                      </p>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </body>
                    </html>';

                    wp_mail( $mail, 'Нагадування про тестування', $subject, $headers );
                }
            }

            update_field('test_sended', true, $post_id);
        }

        return;
    }
}


/////////////////////
/////////////////////
/////////////////////
add_action('wp_ajax_test__start' , 'test__start');
add_action('wp_ajax_nopriv_test__start','test__start');
function test__start(){
    $userId = get_current_user_id();
    $pageId = $_POST['page'];
    $order = $_POST['order'];
    $fst = $_POST['fst'];
    $count = count(get_field('test', $pageId));


    if(!$fst) {
        if( have_rows('test', $pageId) ): ?>
            <div class="test__content test__listcont flex">
                <form class="test__form">
                    <ul class="test__main flex">
                        <?php while ( have_rows('test', $pageId) ) : the_row();
                            $title = get_sub_field('pytannya');
                            $index = get_row_index();
                            ?>

                            <li id="quest<?php echo $index;?>" class="test__question <?php if($index == 1) { echo 'activeQ activeQB'; } ?>">
                                <div class="test__number">
                                    Питання №<?php echo $index; ?>
                                </div>
                                <div class="test__nameP">
                                    <?php echo $title; ?>
                                </div>
                                <ul class="test_vars flex">
                                    <?php while ( have_rows('varianty') ) : the_row();
                                        $var = get_sub_field('variant');
                                        $indexVar = get_row_index();
                                        ?>

                                        <li class="test__var">
                                            <label for="q<?php echo $index; echo $indexVar;?>" class="var__label">
                                                <input type="radio" onchange="unDis($(this))" id="q<?php echo $index; echo $indexVar;?>" name="<?php echo $index; ?>" value="<?php echo $indexVar; ?>">
                                                <span class="test__vartext"><?php echo $var; ?></span>
                                            </label>
                                        </li>

                                    <?php
                                    endwhile; ?>
                                </ul>
                                <?php
                                if($count != $index) {
                                    ?>
                                    <a href="#" data-num="<?php echo $index; ?>" data-id="<?php echo $pageId; ?>" onclick="answerTest($(this))" class="testans__button button green full disabled">
                                        <span>Відповісти</span>
                                    </a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="#" data-num="<?php echo $index; ?>" data-id="<?php echo $pageId; ?>" data-order="<?php echo $order; ?>" onclick="endTest($(this))" class="testans__button button green full disabled">
                                        <span>Завершити тест</span>
                                    </a>
                                    <?php
                                }
                                ?>

                            </li>

                        <?php
                        endwhile; ?>
                    </ul>
                </form>
                <ul class="test__story flex">
                    <?php while ( have_rows('test', $pageId) ) : the_row();
                        $index = get_row_index();
                        ?>

                        <li id="sq<?php echo $index; ?>" class="test__questnum <?php if($index == 1) { echo 'active'; } ?>">
                            <?php echo $index; ?>
                        </li>

                    <?php
                    endwhile; ?>
                </ul>
            </div>
        <?php endif;
    } else {
        ?>
        <div class="test__content test__listcont flex">
            <form class="fst__form" action="save_additional_details" method="post">
                <h2 class="fst__title">
                    Заповнішь ваші дані
                </h2>
                <div class="fst__text">
                    Для того, щоб почати тест заповність поля нижче та збережіть інформацію
                </div>
                <div class="fst__fields flex">
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="billing_date">Дата народження:&nbsp;<span class="required">*</span></label>
                        <input type="date" required class="woocommerce-Input woocommerce-Input--tel input-text" name="billing_date" id="billing_date" data-required="1" value="<?php echo esc_attr( get_user_meta($userId,'billing_date',true) ); ?>" />
                    </p>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="billing_speciality">Спецільність:&nbsp;<span class="required">*</span></label>
                        <textarea required class="woocommerce-Input woocommerce-Input--textarea input-textarea" name="billing_speciality" id="billing_speciality" data-required="1" ><?php echo esc_attr( get_user_meta($userId,'billing_speciality',true) ); ?></textarea>
                    </p>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="billing_place">Місце роботи:&nbsp;<span class="required">*</span></label>
                        <textarea required class="woocommerce-Input woocommerce-Input--textarea input-textarea" name="billing_place" id="billing_place" data-required="1" ><?php echo esc_attr( get_user_meta($userId,'billing_place',true) ); ?></textarea>
                    </p>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="billing_post">Посада:&nbsp;<span class="required">*</span></label>
                        <textarea required class="woocommerce-Input woocommerce-Input--textarea input-textarea" name="billing_post" id="billing_post" data-required="1" ><?php echo esc_attr( get_user_meta($userId,'billing_post',true) ); ?></textarea>
                    </p>
                </div>
                <a href="#" data-id="<?php echo $pageId; ?>" data-fst="0" data-order="<?php echo $order; ?>" onclick="desdData($(this))" class="test__startbtn button green full">
                    <span>Зберегти</span>
                </a>
                <input type="hidden" name="action" value="save_additional_details" />
            </form>
        </div>
        <?php
    }



    die();
}





add_action('wp_ajax_test__end' , 'test__end');
add_action('wp_ajax_nopriv_test__end','test__end');
function test__end(){

    $pageId = $_POST['page'];
    $form = $_POST['form'];
    $order = $_POST['order'];
    parse_str($form, $formarray);
    $count = count(get_field('test', $pageId));
    $point = get_field('prohidnyj_al', $pageId);
    $mark = 0;
    $ifIs = get_field('posylannya', $order);

    //Type
    $type = get_field('typ_podiyi', $pageId);
    $typeK = $type['value'];
    $isCourse = false;
    $isInternal = false;

    if($typeK == 'course') {
        $isCourse = true;
    }
    if($typeK == 'internal') {
        $isInternal = true;
    }

    if(!$ifIs) {
        while ( have_rows('test', $pageId) ) : the_row();
            $index = get_row_index();
            while ( have_rows('varianty') ) : the_row();
                $corr = get_sub_field('pravylno');
                $indexVar = get_row_index();

                if($corr) {
                    if($formarray[$index] == $indexVar) {
                        $mark++;
                    }
                }

            endwhile;
        endwhile;

        $finaleMark = round($mark / $count * 100);

        if($finaleMark < $point) {
            ?>
          <div class="test__content start__testcont hideTest flex">
            <div class="test__result">
              Ви відповіли правильно на <?php echo $finaleMark;?>% питань
            </div>
            <div class="test__restext">
              У вас недостатня кількість правильних відповідей
            </div>
            <a href="#" data-id="<?php echo $pageId; ?>" data-order="<?php echo $order; ?>" onclick="startTest($(this))" class="test__endbtn button green full">
              <span>Пройти тест повторно</span>
            </a>
          </div>
            <?php
        } else {
          if(!$isInternal) {
              $sertNum = get_field('nomer_sertyfikatu', $pageId);
              $sertGet = get_field('vydano_sertyfikativ', $pageId);
              $numLen = strlen(strval($sertGet));
              $numFinale = '70000'.$sertGet;

              if($numLen == 2) {
                  $numFinale = '7000'.$sertGet;
              } else if($numLen == 3) {
                  $numFinale = '700'.$sertGet;
              } else if($numLen == 4) {
                  $numFinale = '70'.$sertGet;
              } else if($numLen == 5) {
                  $numFinale = '7'.$sertGet;
              }

              if(!$sertGet) {
                  $sertGet = 1;
              } else {
                  $sertGet = $sertGet + 1;
              }

              $realcert = str_replace(' ', '', $sertNum);
              $certificat = ltrim($realcert, '№');
              $sertrl = get_template_directory_uri().'/certificat/generated/'.$certificat.'-'.$numFinale.'.pdf';

              update_field('vydano_sertyfikativ', $sertGet, $pageId);
              update_post_meta( $order, 'posylannya', $sertrl);
              update_post_meta( $order, 'id', $sertNum.' - '.$numFinale);
              update_post_meta( $order, 'oczinka', $finaleMark);
          } else {
              $user = wp_get_current_user();
              $user_id = $user->ID;
              $repeater_index = $order;
              $values = ['rezultat', 'projdeno', 'vidpravlenyj_email'];

              foreach ($values as $value) :

                  $current_value1 = get_field('kursy', 'user_' . $user_id);
                  if (isset($current_value1[$repeater_index])) {
                      $current_value1[$repeater_index][$value] = $finaleMark.'%';
                  }

                  update_field('kursy', $current_value1, 'user_' . $user_id);
              endforeach;
          }

            ?>
          <div class="test__content start__testcont hideTest flex">
            <div class="test__result">
              Ви відповіли правильно на <?php echo $finaleMark;?>% питань
            </div>
            <div class="test__restext">
              Вітаємо! Ви успішно пройшли онлайн тест
            </div>
              <?php
              if(!$isInternal) {
                ?>
                <div class="test__successcont">
                  <a href="<?php echo $sertrl; ?>" download class="testsert__btn button green full">
                    <span>Завантажити сертифікат</span>
                  </a>
                  <a href="<?php echo $sertrl; ?>" class="test__sertview" target="_blank">Переглянути сертифікат</a>
                  <div class="test__account">
                    Сертифікат також буде доступний у вашому <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">особистому кабінеті</a>
                  </div>
                </div>
                  <?php
              }
              ?>
          </div>

            <?php
            $thema = get_the_title($pageId);

            $user = wp_get_current_user();
            $fn = $user->user_firstname;
            $ln = $user->user_lastname;
            $mail = $user->user_email;
            $phone = get_user_meta( $user->ID, 'billing_phone', true );
            $dateob = get_user_meta( $user->ID, 'billing_date', true );
            $spec = get_user_meta( $user->ID, 'billing_speciality', true );
            $work = get_user_meta( $user->ID, 'billing_place', true );
            $post = get_user_meta( $user->ID, 'billing_post', true );
            $mainThemOpt = get_field('golovna_tema', 'options');
            $mainThemOpt2 = get_field('golovna_tema2', 'options');
            $mainThemPod = get_field('golovna_tema', $pageId);
            $themaNew = get_field('tema', $pageId);
            $type = get_field('type_c', $pageId);
            if($themaNew) {
                $thema = $themaNew;
            }
            $balls = get_field('kilkist_baliv', $pageId);
            if($mainThemPod) {
                $mainThemOpt = $mainThemPod;
                $mainThemOpt2 = get_field('golovna_tema_2', $pageId);
            }
            $url = get_permalink($pageId);
            $place = get_field('chas_i_miscze', $pageId);
            if(!$isInternal) {
              ?>
              <form id="sertificateForm">
                <input name="numeric" type="hidden" value="<?php echo $numFinale; ?>">
                <input name="moznumer" type="hidden" value="<?php echo $sertNum; ?>">
                <input name="name" type="hidden" value="<?php echo $fn; ?> <?php echo $ln; ?>">
                <input name="mainthem" type="hidden" value="<?php echo $thema; ?>">
                <input name="option" type="hidden" value="<?php echo $balls; ?>">
                <input name="specialization" type="hidden" value="<?php echo $mainThemOpt; ?>">
                <input name="specialization2" type="hidden" value="<?php echo $mainThemOpt2; ?>">
                <input name="url" type="hidden" value="<?php echo $url; ?>">
                <input name="location" type="hidden" value="<?php echo $place; ?>">
                <input name="type" type="hidden" value="<?php echo $type; ?>">
              </form>
                <?php
            }
            ?>
            <?php

            $name = get_bloginfo('name');
            $adEm = get_bloginfo('admin_email');
            $headers = array(
                'From: '.$name.' <'.$adEm.'>',
                'Reply-To: '.$name.' <'.$adEm.'>',
                'content-type: text/html',
            );

            $t1 = 'відвідування семінару';
            $textStart = 'Ви отримали сертифікат!';
            $textSuccess = 'Вітаємо! Ви успішно пройшли онлайн тест';
            $messMain = 'Сертифікат отримано!';
            if($isCourse) {
                $t1 = 'проходження курсу';
            }

            $sertCode = '<p style="text-align: center; margin-bottom: 0; margin-top: 11px; font-size: 14px; line-height: 24px; color: #808080;">Ви отримали сертифікат про '.$t1.' “'.$thema.'”</p>';
            $sertCode2 = '<tr>
                              <td valign="middle" style="padding-top: 56px;padding-bottom: 0">
                                <table border="0" width="650" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td valign="middle" width="100%" align="center" style="padding: 0;border: none">
                                      <p style="text-align: center;color: grey;margin: 0;"><a href="'.$sertrl.'" target="_blank" style="width: 282px; padding: 18px 60px;border-radius: 50px;color:#fff;background-color: #43AE4E;font-size: 15px;line-height: 19px;text-decoration: none;display: inline-block;font-weight: 600;">Переглянути сертифікат</a></p>
                                      <p style="text-align: center;color: #000;margin-top: 15px;margin-bottom: 0; font-size: 14px; line-height: 21px;">Сертифікат доступний у вашому <a href="'.get_permalink( get_option('woocommerce_myaccount_page_id') ).'/sertificats/" style="color: #1A325C; text-decoration: underline;">особистому кабінеті</a></p>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>';

            if($isInternal) {
                $textStart = 'Ви пройшли курс!';
                $textSuccess = 'Ви пройшли курс на тему “'.$thema.'”!';
                $sertCode = '';
                $sertCode2 = '';
                $messMain = 'Курс пройдено!';
            }

            $subject = '<!DOCTYPE html>
                    <html <?php language_attributes(); ?>
                      <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                        <title>'.$textStart.'</title>
                      </head>
                      <body marginwidth="0" topmargin="0" marginheight="0">
                        <div style="width:100%;min-width:700px;font-family:Arial;font-size:16px;line-height:20px;color:#000;background-image:url('.get_site_url().'/wp-content/themes/kdm/assets/img/backgrounds/bg2.png);background-repeat:repeat;background-position:center center;background-size:cover;padding-top:15px">
                          <table width="700" border="0" cellpadding="25" cellspacing="0" style="width: 700px;margin: 0 auto">
                            <tr>
                              <td valign="middle" style="padding-bottom: 0">
                                <table border="0" width="650" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td valign="middle" align="center">
                                      <a href="'.get_site_url().'" target="_blank" style="width: 200px;display: block"><img src="'.get_site_url().'/wp-content/uploads/2023/01/logo.png" style="width: 100%;height: auto" alt="" /></a>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td valign="middle" style="padding-top: 70px; padding-bottom: 0;">
                                <table border="0" width="650" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td valign="middle" align="center">
                                      <p style="text-align: center; font-size: 16; line-height: 20px; font-weight: 600; color: #000; margin: 0;">Ви відповіли правильно на '.$finaleMark.'% питань</p>
                                      <p style="text-align: center; font-size: 21px; line-height: 26px; font-weight: 600; color: #06ac5b; margin: 0; margin-top: 12px">'.$textSuccess.'</p>
                                      '.$sertCode.'
                                    </td>
                                  </tr>
                                </table>
                              </td>   
                            </tr>
                            '.$sertCode2.'
                            <tr>
                              <td valign="middle" style="padding-top: 100px;padding-bottom: 0">
                                <table border="0" width="650" cellpadding="0" cellspacing="0" style="border-top: 1px solid #ececec">
                                  <tr>
                                    <td valign="middle" width="50%" style="padding: 25px 0;border: none"><p style="font-size: 12px;line-height: 14px;color: grey;margin: 0">© 2016-'.date("Y").' KDM CME project.</p></td>
                                    <td valign="middle" width="50%" align="center" style="padding: 25px 0;border: none">
                                      <p style="font-size: 12px;line-height: 14px;color: grey;margin: 0;text-align: right">
                                        <a href="'.get_site_url().'/public/" target="_blank" style="display: inline-block;color: #1a325c;margin-right: 15px;font-size: 12px;line-height: 14px">Публічний договір</a><a style="color: #1a325c;font-size: 12px;line-height: 14px" target="_blank" href="'.get_site_url().'/privacy-policy/">Політика кон-сті</a>
                                      </p>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </body>
                    </html>';

            wp_mail( $mail, $messMain, $subject, $headers );

            if($isInternal) {
                $fullName = $fn.' '.$ln;
                sendToAdmin($fullName, $thema, $finaleMark);
            }


            global $wpdb;

            if(!$isCourse && !$isInternal) {
                $wpdb->insert(
                    'certificate',
                    array(
                        'sertificate'        => $sertNum.' - '.$numFinale,
                        'mark'        => $finaleMark.'%',
                        'name'       => $fn.' '.$ln,
                        'email'        => $mail,
                        'phone'     => $phone,
                        'url'      => $sertrl,
                        'dateofbirth'      => $dateob,
                        'speciality' => $spec,
                        'work'      => $work,
                        'post'      => $post,
                    )
                );
            }

            if($isCourse) {
                $wpdb->insert(
                    'courses',
                    array(
                        'sertificate'        => $sertNum.' - '.$numFinale,
                        'mark'        => $finaleMark.'%',
                        'name'       => $fn.' '.$ln,
                        'email'        => $mail,
                        'phone'     => $phone,
                        'url'      => $sertrl,
                        'dateofbirth'      => $dateob,
                        'speciality' => $spec,
                        'work'      => $work,
                        'post'      => $post,
                    )
                );
            }

            if($isInternal) {
                $wpdb->insert(
                    'internal',
                    array(
                        'course'       => $thema,
                        'name'       => $fn.' '.$ln,
                        'mark'        => $finaleMark.'%',
                    )
                );
            }

        }
    } else {
        ?>
      <div class="test__content start__testcont hideTest flex">
        <div class="test__result">
          Ви вже пройшли тест на достатній бал
        </div>
          <?php
          if($isInternal) {
              $user = wp_get_current_user();
              $user_id = $user->ID;
              $repeater_index = $order;
              $current_value = get_field('kursy', 'user_' . $user_id);
              $finaleMark = 0;


              if (isset($current_value[$repeater_index]['rezultat'])) {
                  $finaleMark = $current_value[$repeater_index]['rezultat'];
              }
              ?>
            <div class="test__result">
              Ваш бал - <?php echo $finaleMark; ?>
            </div>
              <?php
          }
          if(!$isInternal) {
            ?>
            <div class="test__restext">
              У вас вже є сертифікат
            </div>
            <div class="test__successcont">
              <a href="<?php echo $ifIs; ?>" download class="testsert__btn button green full">
                <span>Завантажити сертифікат</span>
              </a>
              <a href="<?php echo $ifIs; ?>" class="test__sertview" target="_blank">Переглянути сертифікат</a>
              <div class="test__account">
                Сертифікат також буде доступний у вашому <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>/sertificats/">особистому кабінеті</a>
              </div>
            </div>
              <?php
          }
          ?>
      </div>
        <?php
    }




    die();
}

function sendToAdmin($nameC, $them, $mark) {
    $name = get_bloginfo('name');
    $adEm = get_bloginfo('admin_email');
    $headers = array(
        'From: '.$name.' <'.$adEm.'>',
        'Reply-To: '.$name.' <'.$adEm.'>',
        'content-type: text/html',
    );

    $subject = '<!DOCTYPE html>
                    <html <?php language_attributes(); ?>
                      <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                        <title>Пройдене тестування</title>
                      </head>
                      <body marginwidth="0" topmargin="0" marginheight="0">
                        <div style="width:100%;min-width:700px;font-family:Arial;font-size:16px;line-height:20px;color:#000;background-image:url('.get_site_url().'/wp-content/themes/kdm/assets/img/backgrounds/bg2.png);background-repeat:repeat;background-position:center center;background-size:cover;padding-top:15px">
                          <table width="700" border="0" cellpadding="25" cellspacing="0" style="width: 700px;margin: 0 auto">
                            <tr>
                              <td valign="middle" style="padding-bottom: 0">
                                <table border="0" width="650" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td valign="middle" align="center">
                                      <a href="'.get_site_url().'" target="_blank" style="width: 200px;display: block"><img src="'.get_site_url().'/wp-content/uploads/2023/01/logo.png" style="width: 100%;height: auto" alt="" /></a>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td valign="middle" style="padding-top: 70px; padding-bottom: 0;">
                                <table border="0" width="650" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td valign="middle" align="center">
                                      <p style="text-align: center; font-size: 16; line-height: 20px; font-weight: 600; color: #000; margin: 0;">Тест з курсу "'.$them.'" пройдено на '.$mark.'% питань</p>
                                      <p style="text-align: center; font-size: 21px; line-height: 26px; font-weight: 600; color: #06ac5b; margin: 0; margin-top: 12px">Тест пройшов(ла) '.$nameC.'</p>
                                    </td>
                                  </tr>
                                </table>
                              </td>   
                            </tr>
                            <tr>
                              <td valign="middle" style="padding-top: 100px;padding-bottom: 0">
                                <table border="0" width="650" cellpadding="0" cellspacing="0" style="border-top: 1px solid #ececec">
                                  <tr>
                                    <td valign="middle" width="50%" style="padding: 25px 0;border: none"><p style="font-size: 12px;line-height: 14px;color: grey;margin: 0">© 2016-'.date("Y").' KDM CME project.</p></td>
                                    <td valign="middle" width="50%" align="center" style="padding: 25px 0;border: none">
                                      <p style="font-size: 12px;line-height: 14px;color: grey;margin: 0;text-align: right">
                                        <a href="'.get_site_url().'/public/" target="_blank" style="display: inline-block;color: #1a325c;margin-right: 15px;font-size: 12px;line-height: 14px">Публічний договір</a><a style="color: #1a325c;font-size: 12px;line-height: 14px" target="_blank" href="'.get_site_url().'/privacy-policy/">Політика кон-сті</a>
                                      </p>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </body>
                    </html>';

    wp_mail($adEm, 'Тест пройдено', $subject, $headers );
}

function replace_error_text( $translated_text, $untranslated_text, $domain ) {

    // Замінюємо текст помилки, якщо в ньому є фраза "The password you entered for the email address"
    if (strpos($untranslated_text, 'The password you entered for the email address') !== false) {
        $translated_text = 'Ваш пароль не дійсний. Спробуйте знову.';
    }

    return $translated_text;
}
add_filter('gettext', 'replace_error_text', 20, 3);



add_action('wp_ajax_course' , 'course');
add_action('wp_ajax_nopriv_course','course');
function course(){

    $title = $_POST['name'];
    $url = $_POST['url'];

    $current_user = wp_get_current_user();
    $first_name = $current_user->first_name;
    $last_name = $current_user->last_name;
    $email = $current_user->user_email;

    $name = get_bloginfo('name');
    $adEm = get_bloginfo('admin_email');
    $headers = array(
        'From: '.$name.' <'.$adEm.'>',
        'Reply-To: '.$name.' <'.$adEm.'>',
        'content-type: text/html',
    );

    $subject = '<!DOCTYPE html>
                    <html <?php language_attributes(); ?>
                      <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                        <title>Користувач зацікавився курсом</title>
                      </head>
                      <body marginwidth="0" topmargin="0" marginheight="0">
                        <div style="width:100%;min-width:700px;font-family:Arial;font-size:16px;line-height:20px;color:#000;background-image:url('.get_site_url().'/wp-content/themes/kdm/assets/img/backgrounds/bg2.png);background-repeat:repeat;background-position:center center;background-size:cover;padding-top:15px">
                          <table width="700" border="0" cellpadding="25" cellspacing="0" style="width: 700px;margin: 0 auto">
                            <tr>
                              <td valign="middle" style="padding-bottom: 0">
                                <table border="0" width="650" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td valign="middle" align="center">
                                      <a href="'.get_site_url().'" target="_blank" style="width: 200px;display: block"><img src="'.get_site_url().'/wp-content/uploads/2023/01/logo.png" style="width: 100%;height: auto" alt="" /></a>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td valign="middle" style="padding-top: 70px; padding-bottom: 0;">
                                <table border="0" width="650" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td valign="middle" align="center">
                                      <p style="text-align: center; font-size: 18px; line-height: 24px; font-weight: 400; color: #000; margin: 0; margin-top: 0"><span style="font-weight: 700;">'.$first_name.' '.$last_name.'</span> (<a style="color: #001c45; font-weight: 700;" href="mailto:'.$email.'">'.$email.'</a>) зацікавився(лась) курсом на тему "<a style="color: #001c45; font-weight: 700;" href="'.$url.'">'.$title.'</a>"</p>
                                    </td>
                                  </tr>
                                </table>
                              </td>   
                            </tr>
                            <tr>
                              <td valign="middle" style="padding-top: 100px;padding-bottom: 0">
                                <table border="0" width="650" cellpadding="0" cellspacing="0" style="border-top: 1px solid #ececec">
                                  <tr>
                                    <td valign="middle" width="50%" style="padding: 25px 0;border: none"><p style="font-size: 12px;line-height: 14px;color: grey;margin: 0">© 2016-'.date("Y").' KDM CME project.</p></td>
                                    <td valign="middle" width="50%" align="center" style="padding: 25px 0;border: none">
                                      <p style="font-size: 12px;line-height: 14px;color: grey;margin: 0;text-align: right">
                                        <a href="'.get_site_url().'/public/" target="_blank" style="display: inline-block;color: #1a325c;margin-right: 15px;font-size: 12px;line-height: 14px">Публічний договір</a><a style="color: #1a325c;font-size: 12px;line-height: 14px" target="_blank" href="'.get_site_url().'/privacy-policy/">Політика кон-сті</a>
                                      </p>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </body>
                    </html>';

    wp_mail( $adEm, 'Користувач зацікавився курсом', $subject, $headers );


    die();
}



/////////////////////////////////////////////////
function add_employee_role() {
    // Додаємо роль "Співробітник"
    add_role(
        'employee',
        __('Співробітник', 'textdomain'),
        array(
            'read'         => true,
            'edit_posts'   => false,
            'delete_posts' => false,
            'publish_posts' => false,
            'upload_files' => false,
        )
    );
}

// Додаємо роль під час активації теми або плагіна
add_action('init', 'add_employee_role');



add_action( 'init', 'codex_course_init' );
/**
 * Register a team post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function codex_course_init() {
    $labels = array(
        'name'               => _x( 'Курс', 'post type general name', 'your-plugin-textdomain' ),
        'singular_name'      => _x( 'Курси', 'post type singular name', 'your-plugin-textdomain' ),
        'menu_name'          => _x( 'Курси', 'admin menu', 'your-plugin-textdomain' ),
        'name_admin_bar'     => _x( 'Курс', 'add new on admin bar', 'your-plugin-textdomain' ),
        'add_new'            => _x( 'Створити', 'курс', 'your-plugin-textdomain' ),
        'add_new_item'       => __( 'Створити курс', 'your-plugin-textdomain' ),
        'new_item'           => __( 'Новий курс', 'your-plugin-textdomain' ),
        'edit_item'          => __( 'Редагувати курс', 'your-plugin-textdomain' ),
        'view_item'          => __( 'Переглянути курс', 'your-plugin-textdomain' ),
        'all_items'          => __( 'Всі курси', 'your-plugin-textdomain' ),
        'search_items'       => __( 'Знайти курс', 'your-plugin-textdomain' ),
        'parent_item_colon'  => __( 'Родитель:', 'your-plugin-textdomain' ),
        'not_found'          => __( 'Курсів не знайдено.', 'your-plugin-textdomain' ),
        'not_found_in_trash' => __( 'В кршику екмає курсів.', 'your-plugin-textdomain' )
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Description.', 'your-plugin-textdomain' ),
        'public'             => false,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'course' ),
        'capability_type'    => 'page',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'thumbnail', 'title' ),
    );

    register_post_type( 'course', $args );
}



//function restrict_purchase_for_user_roles($can_purchase, $product) {
//    // Отримати ролі користувача
//    $current_user = wp_get_current_user();
//    $first_role = $current_user->roles;
//    $user_roles = reset($first_role);
//
//    // Заборонити покупку для користувачів з певними ролями
//    $restricted_roles = 'employee';
//
//    if ($user_roles === $restricted_roles) {
//        $can_purchase = false;
//    }
//
//    return $can_purchase;
//}
//
//add_filter('woocommerce_is_purchasable', 'restrict_purchase_for_user_roles', 10, 2);


///////////////////////////////////
function remove_user_social_links($contactmethods) {
    // Приховати посилання на соціальні мережі
    unset($contactmethods['twitter']);
    unset($contactmethods['facebook']);
    unset($contactmethods['linkedin']);
    unset($contactmethods['instagram']);
    unset($contactmethods['myspace']);
    unset($contactmethods['pinterest']);
    unset($contactmethods['soundcloud']);
    unset($contactmethods['tumblr']);
    unset($contactmethods['youtube']);
    unset($contactmethods['wikipedia']);

    return $contactmethods;
}

add_filter('user_contactmethods', 'remove_user_social_links', 10, 1);


function custom_admin_js() {
  ?>
  <script>
      jQuery(document).ready(function($) {
          if($(".user-edit-php .acf-field").length > 0) {
              $("#url").closest("tr").remove();
              $("#description").closest(".form-table").prev("h2").remove();
              $("#description").closest(".form-table").remove();
              $("#billing_first_name").closest(".form-table").prev("h2").remove();
              $("#billing_first_name").closest(".form-table").remove(); $("#shipping_first_name").closest(".form-table").prev("h2").remove();
              $("#shipping_first_name").closest(".form-table").remove();
              $(".application-passwords").remove();
              $(".application-passwords").remove();
              $(".acf-field-message").after('<tr class="acf-field acf-field-true-false"><td class="acf-label"><label>Відправити повідомлення про нові курси</label></td><td class="acf-input"><div class="acf-true-false"><label><input type="checkbox" name="vidpr"></label></div></td></tr>');
          }
      });
  </script>
    <?php
}

add_action('admin_head', 'custom_admin_js');







add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;

    $status = $_POST['vidpr'];

    if($status) {
        if( have_rows('kursy', 'user_'.$user_id) ):
            while ( have_rows('kursy', 'user_'.$user_id) ) : the_row();
                $em = get_sub_field('vidpravlenyj_email');
                $pass = get_sub_field('projdeno');

                if(!$em && !$pass) {
                    $id = get_sub_field('kurs');
                    $cname = get_the_title($id);
                    $url = get_permalink( get_option('woocommerce_myaccount_page_id') ).'/course/?crs='.$id;
                    $user_data = get_userdata($user_id);
                    $user_email = $user_data->user_email;

                    sendCourse($cname, $url, $user_email);
                }

            endwhile;
        endif;
    }
}


function sendCourse($nameC, $url, $email) {
    $name = get_bloginfo('name');
    $adEm = get_bloginfo('admin_email');
    $headers = array(
        'From: '.$name.' <'.$adEm.'>',
        'Reply-To: '.$name.' <'.$adEm.'>',
        'content-type: text/html',
    );

    $subject = '<!DOCTYPE html>
                    <html <?php language_attributes(); ?>
                      <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                        <title>Відкритий курс</title>
                      </head>
                      <body marginwidth="0" topmargin="0" marginheight="0">
                        <div style="width:100%;min-width:700px;font-family:Arial;font-size:16px;line-height:20px;color:#000;background-image:url('.get_site_url().'/wp-content/themes/kdm/assets/img/backgrounds/bg2.png);background-repeat:repeat;background-position:center center;background-size:cover;padding-top:15px">
                          <table width="700" border="0" cellpadding="25" cellspacing="0" style="width: 700px;margin: 0 auto">
                            <tr>
                              <td valign="middle" style="padding-bottom: 0">
                                <table border="0" width="650" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td valign="middle" align="center">
                                      <a href="'.get_site_url().'" target="_blank" style="width: 200px;display: block"><img src="'.get_site_url().'/wp-content/uploads/2023/01/logo.png" style="width: 100%;height: auto" alt="" /></a>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td valign="middle" style="padding-top: 70px; padding-bottom: 0;">
                                <table border="0" width="650" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td valign="middle" align="center">
                                      <p style="text-align: center; font-size: 16; line-height: 20px; font-weight: 600; color: #000; margin: 0;">Вам відкрито курс на тему:</p>
                                      <p style="text-align: center; font-size: 21px; line-height: 26px; font-weight: 600; color: #06ac5b; margin: 0; margin-top: 12px">'.$nameC.'</p>
                                    </td>
                                  </tr>
                                </table>
                              </td>   
                            </tr>
                            <tr>
                              <td valign="middle" style="padding-top: 56px;padding-bottom: 0">
                                <table border="0" width="650" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td valign="middle" width="100%" align="center" style="padding: 0;border: none">
                                      <p style="text-align: center;color: grey;margin: 0;"><a href="'.$url.'" target="_blank" style="width: 282px; padding: 18px 60px;border-radius: 50px;color:#fff;background-color: #43AE4E;font-size: 15px;line-height: 19px;text-decoration: none;display: inline-block;font-weight: 600;">Пройти курс</a></p>
                                      <p style="text-align: center;color: #000;margin-top: 15px;margin-bottom: 0; font-size: 14px; line-height: 21px;">Також ви можете знайти курс в <a href="'.get_permalink( get_option('woocommerce_myaccount_page_id') ).'/actual/" style="color: #1A325C; text-decoration: underline;">особистому кабінеті</a></p>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td valign="middle" style="padding-top: 100px;padding-bottom: 0">
                                <table border="0" width="650" cellpadding="0" cellspacing="0" style="border-top: 1px solid #ececec">
                                  <tr>
                                    <td valign="middle" width="50%" style="padding: 25px 0;border: none"><p style="font-size: 12px;line-height: 14px;color: grey;margin: 0">© 2016-'.date("Y").' KDM CME project.</p></td>
                                    <td valign="middle" width="50%" align="center" style="padding: 25px 0;border: none">
                                      <p style="font-size: 12px;line-height: 14px;color: grey;margin: 0;text-align: right">
                                        <a href="'.get_site_url().'/public/" target="_blank" style="display: inline-block;color: #1a325c;margin-right: 15px;font-size: 12px;line-height: 14px">Публічний договір</a><a style="color: #1a325c;font-size: 12px;line-height: 14px" target="_blank" href="'.get_site_url().'/privacy-policy/">Політика кон-сті</a>
                                      </p>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </body>
                    </html>';

    wp_mail($email, 'Відкритий курс!', $subject, $headers );
}
