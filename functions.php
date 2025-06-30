<?php

/**
 * Starter Theme Functions
 * 
 * @package StarterTheme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}

function enable_svg_upload($upload_mimes)
{
    $upload_mimes['svg'] = 'image/svg+xml';
    $upload_mimes['svgz'] = 'image/svg+xml';
    return $upload_mimes;
}
add_filter('upload_mimes', 'enable_svg_upload', 10, 1);

/**
 * Theme Setup
 */
function starter_theme_setup()
{
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'starter-theme'),
        'footer' => __('Footer Menu', 'starter-theme'),
        'mobile' => __('Mobile Menu', 'starter-theme'),
    ));
}
add_action('after_setup_theme', 'starter_theme_setup');

/**
 * Register Widget Areas
 */
function starter_theme_widgets_init()
{
    register_sidebar(array(
        'name'          => __('Sidebar', 'starter-theme'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here.', 'starter-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Widgets', 'starter-theme'),
        'id'            => 'footer-widgets',
        'description'   => __('Footer widget area.', 'starter-theme'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'starter_theme_widgets_init');

/**
 * Custom Post Types
 */
function starter_theme_custom_post_types()
{
    // Example: Portfolio
    register_post_type('portfolio', array(
        'labels' => array(
            'name' => __('Portfolio', 'starter-theme'),
            'singular_name' => __('Portfolio Item', 'starter-theme'),
            'add_new' => __('Add New', 'starter-theme'),
            'add_new_item' => __('Add New Portfolio Item', 'starter-theme'),
            'edit_item' => __('Edit Portfolio Item', 'starter-theme'),
            'new_item' => __('New Portfolio Item', 'starter-theme'),
            'view_item' => __('View Portfolio Item', 'starter-theme'),
            'search_items' => __('Search Portfolio', 'starter-theme'),
            'not_found' => __('No portfolio items found', 'starter-theme'),
            'not_found_in_trash' => __('No portfolio items found in trash', 'starter-theme'),
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'portfolio'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-portfolio',
        'show_in_rest' => true, // Gutenberg support
    ));

    // Example: Testimonials
    register_post_type('testimonials', array(
        'labels' => array(
            'name' => __('Testimonials', 'starter-theme'),
            'singular_name' => __('Testimonial', 'starter-theme'),
        ),
        'public' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-format-quote',
        'show_in_rest' => true,
    ));
}
add_action('init', 'starter_theme_custom_post_types');

/**
 * Custom Taxonomies
 */
function starter_theme_custom_taxonomies()
{
    // Portfolio Category
    register_taxonomy('portfolio_category', 'portfolio', array(
        'labels' => array(
            'name' => __('Portfolio Categories', 'starter-theme'),
            'singular_name' => __('Portfolio Category', 'starter-theme'),
        ),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'portfolio-category'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'starter_theme_custom_taxonomies');

/**
 * ACF Options Page
 */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Theme General Settings',
        'menu_title' => 'Theme Options',
        'menu_slug' => 'general-settings',
        'capability' => 'edit_posts',
    ));
}

/**
 * Gravity Forms - Remove CSS if using custom styles
 */
add_filter('pre_option_rg_gforms_disable_css', '__return_true');

/**
 * Custom Image Sizes
 */
function starter_theme_image_sizes()
{
    add_image_size('hero-image', 1920, 800, true);
    add_image_size('card-image', 400, 300, true);
    add_image_size('portfolio-thumb', 600, 400, true);
}
add_action('after_setup_theme', 'starter_theme_image_sizes');

/**
 * Excerpt Length
 */
function starter_theme_excerpt_length($length)
{
    return 20;
}
add_filter('excerpt_length', 'starter_theme_excerpt_length');

/**
 * Custom Excerpt More
 */
function starter_theme_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'starter_theme_excerpt_more');

/**
 * Body Classes
 */
function starter_theme_body_classes($classes)
{
    // Add page slug to body class
    if (is_page()) {
        global $post;
        $classes[] = 'page-' . $post->post_name;
    }

    return $classes;
}
add_filter('body_class', 'starter_theme_body_classes');

/**
 * Clean up wp_head
 */
function starter_theme_cleanup()
{
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
}
add_action('init', 'starter_theme_cleanup');

/**
 * Custom Menu Walker (if needed for complex menus)
 */
class Starter_Walker_Nav_Menu extends Walker_Nav_Menu
{
    // Custom walker code here if needed
}

/**
 * Helper Functions
 */

// Get custom field with fallback
function get_theme_field($field_name, $fallback = '')
{
    if (function_exists('get_field')) {
        $value = get_field($field_name);
        return $value ? $value : $fallback;
    }
    return $fallback;
}

// Get options field with fallback
function get_theme_option($field_name, $fallback = '')
{
    if (function_exists('get_field')) {
        $value = get_field($field_name, 'option');
        return $value ? $value : $fallback;
    }
    return $fallback;
}

// Custom pagination
function starter_theme_pagination()
{
    global $wp_query;

    if ($wp_query->max_num_pages <= 1) return;

    $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
    $max = intval($wp_query->max_num_pages);

    if ($paged >= 1) $links[] = $paged;
    if ($paged >= 3) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }
    if (($paged + 2) <= $max) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<div class="pagination"><ul>' . "\n";

    if (get_previous_posts_link())
        printf('<li>%s</li>' . "\n", get_previous_posts_link('&laquo; Previous'));

    if (!in_array(1, $links)) {
        $class = 1 == $paged ? ' class="active"' : '';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');
        if (!in_array(2, $links)) echo '<li>…</li>';
    }

    sort($links);
    foreach ((array) $links as $link) {
        $class = $paged == $link ? ' class="active"' : '';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
    }

    if (!in_array($max, $links)) {
        if (!in_array($max - 1, $links)) echo '<li>…</li>' . "\n";
        $class = $paged == $max ? ' class="active"' : '';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
    }

    if (get_next_posts_link())
        printf('<li>%s</li>' . "\n", get_next_posts_link('Next &raquo;'));

    echo '</ul></div>' . "\n";
}

/**
 * Enqueue scripts and styles.
 */

function enqueue_google_fonts()
{
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'enqueue_google_fonts');

function arc_scripts()
{
    // Main stylesheet
    wp_enqueue_style('starter-theme-style', get_template_directory_uri() . '/assets/css/style.css', array(), _S_VERSION);
    wp_enqueue_script('gsap', get_template_directory_uri() . '/assets/js/gsap.min.js', array(), '1.0.0', true);
    wp_enqueue_script('gsap-scrolltrigger', get_template_directory_uri() . '/assets/js/ScrollTrigger.min.js', array('gsap'), _S_VERSION, true);
    wp_enqueue_script('gsap-smooth-scroll', get_template_directory_uri() . '/assets/js/ScrollSmoother.min.js', array('gsap'), _S_VERSION, true);
    wp_enqueue_script('gsap-splittext', get_template_directory_uri() . '/assets/js/SplitText.min.js', ['gsap'], null, true);
    wp_enqueue_script('gsap-flip', get_template_directory_uri() . '/assets/js/Flip.min.js', array('gsap'), _S_VERSION, true);
    wp_enqueue_script('gsap-draw', get_template_directory_uri() . '/assets/js/DrawSVGPlugin.min.js', array('gsap'), _S_VERSION, true);
    wp_enqueue_script('gsap-motion', get_template_directory_uri() . '/assets/js/MotionPathPlugin.min.js', array('gsap'), _S_VERSION, true);
    wp_enqueue_script('gsap-scrollto', get_template_directory_uri() . '/assets/js/ScrollToPlugin.min.js', array('gsap'), _S_VERSION, true);
    wp_enqueue_script('mixitup', get_template_directory_uri() . '/assets/js/mixitup.min.js', array(), _S_VERSION, true);
    wp_enqueue_script('valmar-main', get_template_directory_uri() . '/assets/js/main.js', array(), _S_VERSION, true);


    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'arc_scripts');
