<?php
/**
 * Spartak functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Spartak
 */

if ( ! function_exists( 'spartak_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function spartak_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Spartak, use a find and replace
		 * to change 'spartak' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'spartak', get_template_directory() . '/languages' );

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
		add_image_size('spartak-large-thumb', 1500, 300, true);
		add_image_size('spartak-small-thumb', 805, 540,true);

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'spartak' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'spartak_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'spartak_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function spartak_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'spartak_content_width', 640 );
}
add_action( 'after_setup_theme', 'spartak_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function spartak_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'spartak' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'spartak' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'spartak_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function spartak_scripts() {
	wp_enqueue_style( 'spartak-style', get_stylesheet_uri() );

	wp_enqueue_script( 'spartak-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'spartak-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'spartak_scripts' );


/* Social Sharing buttons */

// Function to handle the thumbnail request
function get_the_post_thumbnail_src($img)
{
	return (preg_match('~\bsrc="([^"]++)"~', $img, $matches)) ? $matches[1] : '';
}
function pgeorgiev_social_buttons($content) {
	global $post;
	if(is_singular() || is_home()){

		// Get current page URL
		$sb_url = urlencode(get_permalink());

		// Get current page title
		$sb_title = str_replace( ' ', '%20', get_the_title());




		// Based on popular demand added Pinterest too
		$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$sb_url.'&amp;media='.$sb_thumb[0].'&amp;description='.$sb_title;
		$gplusURL ='https://plus.google.com/share?url='.$sb_title.'';

		// Add sharing button at the end of page/page content
		$content .= '<div class="social-box"><div class="social-btn">';
		$content .= '<a class="col-1 sbtn s-twitter" href="'. $twitterURL .'" target="_blank" rel="nofollow"><span>Twitter</span></a>';
		$content .= '<a class="col-1 sbtn s-facebook" href="'.$facebookURL.'" target="_blank" rel="nofollow"><span>Facebook</span></a>';
		$content .= '</div></div>';

		return $content;
	}else{
		// if not a post/page then don't include sharing button
		return $content;
	}
};
// Enable the_content if you want to automatically show social buttons below your post.

add_filter( 'the_content', 'pgeorgiev_social_buttons');

// This will create a wordpress shortcode [social].
// Please it in any widget and social buttons appear their.
// You will need to enabled shortcode execution in widgets.
add_shortcode('social','pgeorgiev_social_buttons');

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

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
