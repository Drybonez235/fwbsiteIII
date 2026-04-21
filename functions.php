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
add_filter('timber/context', function( $context ) {
    $context['menu'] = Timber::get_menu('primary');
    $context['site'] = new Timber\Site();
    $context['custom_logo_url'] = wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full');

    $events = [];
    for ( $i = 1; $i <= 5; $i++ ) {
        $enabled = get_theme_mod( "church_info_event_{$i}_enabled", 0 );
        
        // Only add to context if the event is enabled
        if ( $enabled ) {
            $events[] = [
                'title'       => get_theme_mod( "church_info_event_{$i}_title" ),
                'image'       => get_theme_mod( "church_info_event_{$i}_image" ),
                'date'        => get_theme_mod( "church_info_event_{$i}_date" ),
                'location'    => get_theme_mod( "church_info_event_{$i}_location" ),
                'description' => get_theme_mod( "church_info_event_{$i}_description" ),
            ];
        }
    }


    // Prepare dynamic individual beliefs array
    $belief_keys = [
        'the_bible', 'the_godhead', 'jesus_christ', 'the_holy_spirit', 
        'human_sinfulness', 'salvation_doctrine', 'salvation_terms', 
        'freedom_of_will', 'salvation_free', 'perseverance', 
        'eternal_future_destiny', 'the_church_universal', 
        'gospel_ordinances', 'tithing', 'the_christian_sabbath'
    ];
    
   $individual_beliefs = [];
    foreach ($belief_keys as $key) {
        $individual_beliefs[] = [
            'id'      => $key,
            'title'   => get_theme_mod('fwbsite_belief_label_' . $key, ['label']), 
        // REACH INTO DATABASE for the content, fallback to the array default
        'content' => get_theme_mod('fwbsite_belief_content_' . $key, ['default'])
        ];
    }
    

    // Prepare Partnerships array
    $affiliations = [];
    for ( $i = 1; $i <= 10; $i++ ) {
        if ( get_theme_mod("fwbsite_affiliation_{$i}_display") ) {
            $affiliations[] = [
                'name' => get_theme_mod("fwbsite_affiliation_{$i}_name"),
                'desc' => get_theme_mod("fwbsite_affiliation_{$i}_description"),
            ];
        }
    }

    // Create the 'theme' object to hold all your sub-function data
    $context['theme'] = [
        // Church Description Section
        'name'               => get_theme_mod('church_name', 'My Church'),
        'image'              => get_theme_mod('church_image'),
        'address'            => get_theme_mod('church_address'),
        'location'           => get_theme_mod('church_location'),
        'email'              => get_theme_mod('church_email'),
        'phone'              => get_theme_mod('church_phone'),
        'mission_statement'  => get_theme_mod('homepage_mission_statement'),
        'mission_subtext'    => get_theme_mod('mission_subtext'),

        // Events Data (The new binding)

        'events' => [
        'title'      => get_theme_mod('fwbsite_events_page_title', 'Upcoming Events'),
        'intro'      => get_theme_mod('fwbsite_events_intro_text'),
        'events_bg' => get_theme_mod('fwbsite_events_page_background_image'),
        'events_array'    => $events,
        ],
        
        'events_bg' => get_theme_mod('fwbsite_events_page_background_image'),
        'events'    => $events,
        
       

        // Service Information Section
        'service' => [
            'message'             => get_theme_mod('service_message'),
            'image'               => get_theme_mod('service_image'),
            'sunday_school'       => get_theme_mod('sunday_school_time'),
            'sunday_school_desc'  => get_theme_mod('sunday_school_description'),
            'sunday_morning'      => get_theme_mod('sunday_service_time'),
            'sunday_morning_desc' => get_theme_mod('sunday_service_description'),
            'night_enabled'       => get_theme_mod('enable_sunday_night'),
            'night_time'          => get_theme_mod('sunday_night_time'),
            'wednesday_enabled'   => get_theme_mod('enable_wednesday_night'),
            'wednesday_time'      => get_theme_mod('wednesday_night_time'),
        ],

        // Pastor Section
        'pastor' => [
            'name'  => get_theme_mod('pastor_name'),
            'bio'   => get_theme_mod('pastor_bio'),
            'image' => get_theme_mod('pastor_image'),
        ],

        // Home page Ministries (Grouped as an array for easier looping)
        // 'ministries' => [
        //     ['name' => get_theme_mod('ministry1_name'), 'desc' => get_theme_mod('ministry1_description'), 'enabled' => true],
        //     ['name' => get_theme_mod('ministry2_name'), 'desc' => get_theme_mod('ministry2_description'), 'enabled' => get_theme_mod('enable_ministry2')],
        //     ['name' => get_theme_mod('ministry3_name'), 'desc' => get_theme_mod('ministry3_description'), 'enabled' => get_theme_mod('enable_ministry3')],
        // ],

        //Ministries Page ministries
        'ministries' => [

        ],

        // Social Media
        'social' => [
            'facebook'  => ['url' => get_theme_mod('church_facebook'),  'enabled' => get_theme_mod('church_facebook_enabled')],
            'instagram' => ['url' => get_theme_mod('church_instagram'), 'enabled' => get_theme_mod('church_instagram_enabled')],
            'youtube'   => ['url' => get_theme_mod('church_youtube'),   'enabled' => get_theme_mod('church_youtube_enabled')],
        ],

        // Beliefs Page Data
        'beliefs' => [
            'bg_image'    => get_theme_mod('fwbsite_beliefs_page_background_image'),
            'title'       => get_theme_mod('fwbsite_beliefs_page_main_title', 'Our Beliefs'),
            'intro'       => get_theme_mod('fwbsite_beliefs_page_intro_text'),
            'items'       => $individual_beliefs,
            'covenant'    => [
                'enabled' => get_theme_mod('fwbsite_display_church_covenant'),
                'title'   => get_theme_mod('fwbsite_church_covenant_title'),
                'content' => get_theme_mod('fwbsite_church_covenant_content'),
            ],
            'partnerships' => [
                'enabled'      => get_theme_mod('fwbsite_display_partnerships'),
                'title'        => get_theme_mod('fwbsite_partnerships_title'),
                'affiliations' => $affiliations,
            ]
        ],
    ];

    // Loop through the 5 ministries defined in your Customizer
    for ( $i = 1; $i <= 5; $i++ ) {
        $enabled = get_theme_mod( "fwbsite_ministry_{$i}_enabled", 0 );
        
        // Only add to the array if the ministry is enabled
        if ( $enabled ) {
            $context['theme']['ministries'][] = [
                'title'       => get_theme_mod( "fwbsite_ministry_{$i}_title" ),
                'image'       => get_theme_mod( "fwbsite_ministry_{$i}_image" ),
                'catchphrase' => get_theme_mod( "fwbsite_ministry_{$i}_catchphrase" ),
                'details'     => get_theme_mod( "fwbsite_ministry_{$i}_details" ),
            ];
        }
    }

    return $context;
});