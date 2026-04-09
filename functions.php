<?php
/**
 * fwbsiteIII Functions
 */

// 1. BOOT TIMBER (The New Engine)
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once( __DIR__ . '/vendor/autoload.php' );
}
Timber\Timber::init();
Timber::$dirname = ['views'];

// 2. DEFINE PATHS (Keeping your organization style)
define( 'MYTHEME_SUB_FUNCTIONS_DIR', get_template_directory() . '/sub_functions/' );

// Require our separate function files.
require_once MYTHEME_SUB_FUNCTIONS_DIR . 'beliefs_page.php';
require_once MYTHEME_SUB_FUNCTIONS_DIR . 'events_page.php';
require_once MYTHEME_SUB_FUNCTIONS_DIR . 'home_page.php';
require_once MYTHEME_SUB_FUNCTIONS_DIR . 'ministries_page.php';

// 3. THEME SETUP
function mychurch_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('custom-logo', [
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    register_nav_menus([
        'primary' => __('Primary Menu', 'mychurch'),
    ]);
}
add_action('after_setup_theme', 'mychurch_setup');

// 4. ENQUEUE TAILWIND (Replaces your old enqueue file)
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('tailwind-style', get_template_directory_uri() . '/dist/style.css', [], '1.0');
});

// 5. GLOBAL CONTEXT (The Secret Sauce)
// This makes your Menu and Logo available on EVERY page automatically.
add_filter('timber/context', function( $context ) {
    $context['menu'] = Timber::get_menu('primary');
    $context['site'] = new Timber\Site();
    $context['custom_logo_url'] = wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full');
    return $context;
});
