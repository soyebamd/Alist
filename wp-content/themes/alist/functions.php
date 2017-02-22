<?php

/**
 * Twenty Sixteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
/**
 * Twenty Sixteen only works in WordPress 4.4 or later.
 */

function alist_show_cpt_archives( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;    
    }
    if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
        $query->set( 'post_type', array(
        'post', 'nav_menu_item'
        ));
        return $query;
    }
}
add_filter( 'pre_get_posts', 'alist_show_cpt_archives' );

/*** category page pagination */
function wpa85791_category_posts_per_page( $query ) {
    if ( $query->is_category() && $query->is_main_query() )
        $query->set( 'posts_per_page', 10 );
}
add_action( 'pre_get_posts', 'wpa85791_category_posts_per_page' );
/*** category page pagination */

// added for cart ajax ////////////////////////////////////////////////////////////////
function my_enqueue() {
    wp_enqueue_script( 'ajax-script', get_template_directory_uri() . '/js/my-ajax-script.js', array('jquery') );
    wp_localize_script( 'ajax-script', 'my_ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'my_enqueue' );

function example_ajax_request() {
    global $woocommerce;
    if( WC()->cart->cart_contents_count == 0){
        $cart_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
    } else if(WC()->cart->cart_contents_count > 0){
        $cart_url = $woocommerce->cart->get_cart_url();
    }
    echo $cart_url;
   die();
}
add_action( 'wp_ajax_example_ajax_request', 'example_ajax_request' );
add_action( 'wp_ajax_nopriv_example_ajax_request', 'example_ajax_request' );

// If you wanted to also use the function for non-logged in users (in a theme for example)
// add_action( 'wp_ajax_nopriv_example_ajax_request', 'example_ajax_request' );

if (version_compare($GLOBALS['wp_version'], '4.4-alpha', '<')) {
    require get_template_directory() . '/inc/back-compat.php';
}

/**
* Adds categories support in testimonials post type
**/
//* Link e4gf_events CPT to categories taxonomy
add_action( 'init', 'alist_add_category_taxonomy_to_testimonials' );
function alist_add_category_taxonomy_to_testimonials() {
	register_taxonomy_for_object_type( 'category', 'testimonials' );
}

/**
* Adds meta box on page screen
**/
add_action( 'add_meta_boxes', 'alist_add_meta_box');
function alist_add_meta_box(){
    add_meta_box(
            'psmi_menu_items',								// HTML id  attribute of the edit screen section
            __('Page Specific Modules', 'page-specific-menu-items'),	// title of the edit screen section
            'alist_display_meta_box', 			//callback function that prints html
            array('post', 'page'), 										// post type on which to show edit screen
            'side', 											// context - part of page where to show the edit screen
            'high'												// priority where the boxes should show
    );

}
/**
* Prints html for meta box
**/
function alist_display_meta_box(){
    global $post;
    $postId = $_GET['post'];
    $menu_options= get_page_options($postId);
    $sidebar= $menu_options->hide_sidebar;
    $testimonial= $menu_options->hide_testimonial;
    $map= $menu_options->hide_map;
    ?>
    <input type="checkbox" name="hide_sidebar" value="1" <?php if (!empty($menu_options->hide_sidebar)){?> checked=""<?php }?>>Hide Sidebar on This Page <br> 
    <input type="checkbox" name="testimonial" value="1" <?php if (!empty($menu_options->hide_testimonial)){?> checked=""<?php }?>>Hide testimonials on This Page <br> 
    <input type="checkbox" name="hide_map" value="1" <?php if (!empty($menu_options->hide_map)){?> checked=""<?php }?>>Hide Map on This Page 
    <?php
}
add_action('save_post', 'add_menu_option', 10, 2);

function add_menu_option($post_id, $post_data) {
    if( wp_is_post_revision( $post_id) || wp_is_post_autosave( $post_id )) {
        $sidebar=0;    
        $testimonial=1;
        $hide_map=1;   
    }else{
        $sidebar = $_REQUEST['hide_sidebar'];
        $testimonial=$_REQUEST['testimonial']; 
        $hide_map=$_REQUEST['hide_map'];
    }
    global $wpdb;
    $postTable = $wpdb->prefix . 'posts';
    $query = "Update $postTable SET hide_sidebar = '$sidebar',hide_testimonial = '$testimonial',hide_map='$hide_map'  WHERE id =  $post_id";
    $res = $wpdb->query($query);
    
}

/**
 * Registers an editor stylesheet for the theme.
 */
function wpdocs_theme_add_editor_styles() {
    add_editor_style( array('css/bootstrap.css', 'style.css', 'css/custom.css') );
}
add_action( 'admin_init', 'wpdocs_theme_add_editor_styles' );

if (!function_exists('twentysixteen_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     *
     * Create your own twentysixteen_setup() function to override in a child theme.
     *
     * @since Twenty Sixteen 1.0
     */
    function twentysixteen_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Twenty Sixteen, use a find and replace
         * to change 'twentysixteen' to the name of your theme in all the template files
         */
        load_theme_textdomain('twentysixteen', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for custom logo.
         *
         *  @since Twenty Sixteen 1.2
         */
        add_theme_support('custom-logo', array(
            'height' => 240,
            'width' => 240,
            'flex-height' => true,
        ));

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(1200, 9999);
        add_image_size('team_thumb', 148, 148, TRUE);
        // add_image_size('flag_thumb', 86, 53, TRUE);
        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus(array(
            'primary' => __('Primary Menu', 'twentysixteen'),
            'social' => __('Social Links Menu', 'twentysixteen'),
        ));


        /*         * *******Abrar*************
         * Register new menus
         * 
         */

        function register_my_menus() {
            register_nav_menus(
                    array(
                        'top-menu' => __('Top Menu'),
                        'side-menu' => __('Side Menu'),
                        'footer-menu' => __('Footer Menu'),
                        'uk-main' => __('UK Menu'),
                        'uk-side' => __('UK Sidebar Menu'),
                        'turkey-main' => __('Turkey Menu'),
                        'turkey-side' => __('Turkey Sidebar Menu'),
                        'uae-main' => __('UAE Menu'),
                        'uae-side' => __('UAE Sidebar Menu'),
                        'china-main' => __('CHINA Menu'),
                        'china-side' => __('CHINA Sidebar Menu'),
                        'cms-menu' => __('CMS Menu'),
                        'parents-menu' => __('Parents Left Menu'),
                        'schools-menu' => __('Schools Left Menu'),
                        'traning-menu' => __('Training Left Menu'),
                    )
            );
        }

        add_action('init', 'register_my_menus');

        //add multiple featured images
        if (class_exists('MultiPostThumbnails')) {

            new MultiPostThumbnails(array(
                'label' => 'Secondary Image',
                'id' => 'secondary-image',
                'post_type' => 'page'
            ));
        }

        if (class_exists('MultiPostThumbnails')) {

            new MultiPostThumbnails(array(
                'label' => 'Third Image',
                'id' => 'third-image',
                'post_type' => 'page'
            ));
        }

        if (class_exists('MultiPostThumbnails')) {

            new MultiPostThumbnails(array(
                'label' => 'Country Flag',
                'id' => 'flag',
                'post_type' => 'page'
            ));
        }

        if (class_exists('MultiPostThumbnails')) {

            new MultiPostThumbnails(array(
                'label' => 'Secondary Image',
                'id' => 'post-secondary-image',
                'post_type' => 'post'
            ));
        }

        /*         * Resize image on fly** */
        if (function_exists('fly_add_image_size')) {
            fly_add_image_size('flag-crop', 37, 24, true);
        }

        // resize secondry featured image for country 
        // add_image_size('alist-country', 86, 53, TRUE);

        add_action('init', 'my_add_excerpts_to_pages');

        function my_add_excerpts_to_pages() {

            add_post_type_support('page', 'excerpt');
        }

        /*         * *******Abrar end************ */




        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        /*
         * Enable support for Post Formats.
         *
         * See: https://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
            'status',
            'audio',
            'chat',
        ));

        /*
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, icons, and column width.
         */
        add_editor_style(array('css/editor-style.css', twentysixteen_fonts_url()));

        // Indicate widget sidebars can use selective refresh in the Customizer.
        add_theme_support('customize-selective-refresh-widgets');
    }

endif; // twentysixteen_setup
// Abrar Khan
// Insert contact form 7 data in database
add_action('wpcf7_before_send_mail', 'save_my_data');

function save_my_data($cf7) {
    global $wpdb;
    $tableName = $wpdb->prefix . 'forms';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = array();
        $data['fname'] = $_REQUEST['student-name'];
        $data['parent_name'] = $_REQUEST['parent-name'];
        $data['phone'] = $_REQUEST['contact-phone'];
        $data['contact_email'] = $_REQUEST['contact-email'];
        $data['school'] = $_REQUEST['school'];
        $data['year'] = $_REQUEST['school-year'];
        $data['tutor_name'] = $_REQUEST['tutor-name'];
        $data['test_type'] = $_REQUEST['menu-730'];
        $data['more_info'] = $_REQUEST['more-info'];
        $data['academic_Strength'] = $_REQUEST['academic-Strengths'];
        $data['academic_weakness'] = $_REQUEST['academic-weaknesses'];
        $data['message'] = $_REQUEST['your-message'];
        $data['week_days'] = $_REQUEST['week-days'];
        $data['about_us'] = $_REQUEST['about-us'];
        $data['preferred_location'] = $_REQUEST['menu-732'];
        $wpdb->insert($tableName, $data); // insert data
    }
}

add_action('after_setup_theme', 'twentysixteen_setup');

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_content_width() {
    $GLOBALS['content_width'] = apply_filters('twentysixteen_content_width', 840);
}

add_action('after_setup_theme', 'twentysixteen_content_width', 0);

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'twentysixteen'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here to appear in your sidebar.', 'twentysixteen'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Content Bottom 1', 'twentysixteen'),
        'id' => 'sidebar-2',
        'description' => __('Appears at the bottom of the content on posts and pages.', 'twentysixteen'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Content Bottom 2', 'twentysixteen'),
        'id' => 'sidebar-3',
        'description' => __('Appears at the bottom of the content on posts and pages.', 'twentysixteen'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    //register for Newsletter
    register_sidebar(array(
        'name' => 'Newsletter Place here ',
        'id' => 'newsletter-1',
        'description' => 'Appears in the footer area',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title red">',
        'after_title' => '</h3>',
    ));
}

add_action('widgets_init', 'twentysixteen_widgets_init');

if (!function_exists('twentysixteen_fonts_url')) :

    /**
     * Register Google fonts for Twenty Sixteen.
     *
     * Create your own twentysixteen_fonts_url() function to override in a child theme.
     *
     * @since Twenty Sixteen 1.0
     *
     * @return string Google fonts URL for the theme.
     */
    function twentysixteen_fonts_url() {
        $fonts_url = '';
        $fonts = array();
        $subsets = 'latin,latin-ext';

        /* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Merriweather font: on or off', 'twentysixteen')) {
            $fonts[] = 'Merriweather:400,700,900,400italic,700italic,900italic';
        }

        /* translators: If there are characters in your language that are not supported by Montserrat, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Montserrat font: on or off', 'twentysixteen')) {
            $fonts[] = 'Montserrat:400,700';
        }

        /* translators: If there are characters in your language that are not supported by Inconsolata, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Inconsolata font: on or off', 'twentysixteen')) {
            $fonts[] = 'Inconsolata:400';
        }

        if ($fonts) {
            $fonts_url = add_query_arg(array(
                'family' => urlencode(implode('|', $fonts)),
                'subset' => urlencode($subsets),
                    ), 'https://fonts.googleapis.com/css');
        }

        return $fonts_url;
    }

endif;

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_javascript_detection() {
    echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}

add_action('wp_head', 'twentysixteen_javascript_detection', 0);

/**
 * Enqueues scripts and styles.
 *
 * @since Twenty Sixteen 1.0
 */

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}


function twentysixteen_scripts() {
    // Add custom fonts, used in the main stylesheet.
    wp_enqueue_style('twentysixteen-fonts', twentysixteen_fonts_url(), array(), null);

    // Add Genericons, used in the main stylesheet.
    wp_enqueue_style('genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1');

    // Theme stylesheet.
    wp_enqueue_style('twentysixteen-style', get_stylesheet_uri());

    // Load the Internet Explorer specific stylesheet.
    wp_enqueue_style('twentysixteen-ie', get_template_directory_uri() . '/css/ie.css', array('twentysixteen-style'), '20160412');
    wp_style_add_data('twentysixteen-ie', 'conditional', 'lt IE 10');

    // Load the Internet Explorer 8 specific stylesheet.
    wp_enqueue_style('twentysixteen-ie8', get_template_directory_uri() . '/css/ie8.css', array('twentysixteen-style'), '20160412');
    wp_style_add_data('twentysixteen-ie8', 'conditional', 'lt IE 9');

    // Load the Internet Explorer 7 specific stylesheet.
    wp_enqueue_style('twentysixteen-ie7', get_template_directory_uri() . '/css/ie7.css', array('twentysixteen-style'), '20160412');
    wp_style_add_data('twentysixteen-ie7', 'conditional', 'lt IE 8');

    // Load the html5 shiv.
    wp_enqueue_script('twentysixteen-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3');
    wp_script_add_data('twentysixteen-html5', 'conditional', 'lt IE 9');

    wp_enqueue_script('twentysixteen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20160412', true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    if (is_singular() && wp_attachment_is_image()) {
        wp_enqueue_script('twentysixteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array('jquery'), '20160412');
    }

    wp_enqueue_script('twentysixteen-script', get_template_directory_uri() . '/js/functions.js', array('jquery'), '20160412', true);

    wp_localize_script('twentysixteen-script', 'screenReaderText', array(
        'expand' => __('expand child menu', 'twentysixteen'),
        'collapse' => __('collapse child menu', 'twentysixteen'),
    ));
}

add_action('wp_enqueue_scripts', 'twentysixteen_scripts');

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function twentysixteen_body_classes($classes) {
    // Adds a class of custom-background-image to sites with a custom background image.
    if (get_background_image()) {
        $classes[] = 'custom-background-image';
    }

    // Adds a class of group-blog to sites with more than 1 published author.
    if (is_multi_author()) {
        $classes[] = 'group-blog';
    }

    // Adds a class of no-sidebar to sites without active sidebar.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    return $classes;
}

add_filter('body_class', 'twentysixteen_body_classes');

/**
 * Converts a HEX value to RGB.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function twentysixteen_hex2rgb($color) {
    $color = trim($color, '#');

    if (strlen($color) === 3) {
        $r = hexdec(substr($color, 0, 1) . substr($color, 0, 1));
        $g = hexdec(substr($color, 1, 1) . substr($color, 1, 1));
        $b = hexdec(substr($color, 2, 1) . substr($color, 2, 1));
    } else if (strlen($color) === 6) {
        $r = hexdec(substr($color, 0, 2));
        $g = hexdec(substr($color, 2, 2));
        $b = hexdec(substr($color, 4, 2));
    } else {
        return array();
    }

    return array('red' => $r, 'green' => $g, 'blue' => $b);
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentysixteen_content_image_sizes_attr($sizes, $size) {
    $width = $size[0];

    840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

    if ('page' === get_post_type()) {
        840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
    } else {
        840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
        600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
    }

    return $sizes;
}

add_filter('wp_calculate_image_sizes', 'twentysixteen_content_image_sizes_attr', 10, 2);

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function twentysixteen_post_thumbnail_sizes_attr($attr, $attachment, $size) {
    if ('post-thumbnail' === $size) {
        is_active_sidebar('sidebar-1') && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
        !is_active_sidebar('sidebar-1') && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
    }
    return $attr;
}

add_filter('wp_get_attachment_image_attributes', 'twentysixteen_post_thumbnail_sizes_attr', 10, 3);

/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @since Twenty Sixteen 1.1
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
function twentysixteen_widget_tag_cloud_args($args) {
    $args['largest'] = 1;
    $args['smallest'] = 1;
    $args['unit'] = 'em';
    return $args;
}

add_filter('widget_tag_cloud_args', 'twentysixteen_widget_tag_cloud_args');

function get_page_options($postid) {
    global $wpdb;
    $tableName = $wpdb->prefix . 'posts';
    $menu_options = $wpdb->get_results("SELECT hide_sidebar,hide_testimonial,hide_map FROM $tableName where id=$postid");
    return $menu_options[0];
}

/*
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

function my_theme_wrapper_start() {
  echo '<section id="main">';
}

function my_theme_wrapper_end() {
  echo '</section>';
}*/

add_filter('gettext', 'translate_reply');
add_filter('ngettext', 'translate_reply');

function translate_reply($translated) {
$translated = str_ireplace('Shipping', 'Shipping & Handling', $translated);
return $translated;
}

add_filter( 'template_include', 'var_template_include', 1000 );
function var_template_include( $t ){
    $GLOBALS['current_theme_template'] = basename($t);
    return $t;
}

function get_current_template( $echo = false ) {
    if( !isset( $GLOBALS['current_theme_template'] ) )
        return false;
    if( $echo )
        echo $GLOBALS['current_theme_template'];
    else
        return $GLOBALS['current_theme_template'];
}
