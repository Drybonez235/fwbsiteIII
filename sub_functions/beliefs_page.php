<?php
/**
 * Theme functions and definitions
 *
 * This file contains all of the functions and definitions
 * that are used by the theme.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Your_Theme_Name // Replace with your actual theme name
 */

// =====================================================================
// Customizer Setup for "What We Believe" Page
// =====================================================================

/**
 * Registers the "Our Beliefs" Customizer panel, sections, and controls.
 *
 * This function handles the setup for the "What We Believe" page options,
 * including a main panel, a general settings section, individual sections
 * for core beliefs, and a section for the Church Covenant.
 *
 * @param WP_Customize_Manager $wp_customize The WP_Customize_Manager instance.
 */
function fwbsite_customize_beliefs_page( $wp_customize ) {

    // --- 1. Add the new Customizer Panel for "Our Beliefs" ---
    $beliefs_panel_id = 'fwbsite_beliefs_main_panel';
    if ( ! $wp_customize->get_panel( $beliefs_panel_id ) ) {
        $wp_customize->add_panel(
            $beliefs_panel_id,
            array(
                'title'       => __( 'Edit Beliefs Page', 'fwbsite' ),
                'description' => __( 'Customize the content for your "What We Believe" page.', 'fwbsite' ),
                'priority'    => 30,
            )
        );
    }

    // --- 2. Add a GENERAL SECTION for page-level settings (image, title, intro) ---
    $general_beliefs_section_id = 'fwbsite_beliefs_general_page_settings_section';
    if ( ! $wp_customize->get_section( $general_beliefs_section_id ) ) {
        $wp_customize->add_section(
            $general_beliefs_section_id,
            array(
                'title'       => __( 'Beliefs Page Main Settings', 'fwbsite' ),
                'description' => __( 'General settings for the "What We Believe" page, including global image, title, and introduction.', 'fwbsite' ),
                'panel'       => $beliefs_panel_id, // Assign to the new beliefs panel
                'priority'    => 10, // First section in the panel
            )
        );
    }

    // Background Image
    $wp_customize->add_setting(
        'fwbsite_beliefs_page_background_image',
        array(
            'sanitize_callback' => 'esc_url_raw',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'transport'         => 'refresh',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'fwbsite_beliefs_page_background_image',
            array(
                'label'       => __( 'Page Background Image', 'fwbsite' ),
                'section'     => $general_beliefs_section_id,
                'settings'    => 'fwbsite_beliefs_page_background_image',
                'description' => __( 'Upload an image for the "What We Believe" page header or section.', 'fwbsite' ),
            )
        )
    );

    // Page Title
    $wp_customize->add_setting(
        'fwbsite_beliefs_page_main_title',
        array(
            'default'           => __( 'Our Beliefs', 'fwbsite' ),
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        )
    );
    $wp_customize->add_control(
        'fwbsite_beliefs_page_main_title',
        array(
            'label'       => __( 'Main Page Title', 'fwbsite' ),
            'section'     => $general_beliefs_section_id,
            'settings'    => 'fwbsite_beliefs_page_main_title',
            'type'        => 'text',
            'description' => __( 'Title displayed at the top of the "What We Believe" page.', 'fwbsite' ),
        )
    );

    // Introduction Text
    $wp_customize->add_setting(
        'fwbsite_beliefs_page_intro_text',
        array(
            'default'           => __( 'Discover the core beliefs and values that guide our church community. We invite you to explore the foundations of our faith.', 'fwbsite' ),
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport'         => 'refresh',
        )
    );
    $wp_customize->add_control(
        'fwbsite_beliefs_page_intro_text',
        array(
            'label'       => __( 'Introduction Paragraph', 'fwbsite' ),
            'section'     => $general_beliefs_section_id,
            'settings'    => 'fwbsite_beliefs_page_intro_text',
            'type'        => 'textarea',
            'description' => __( 'A short paragraph to introduce your statement of faith.', 'fwbsite' ),
        )
    );

    // --- 3. Define individual belief points and loop through them ---
    $beliefs = [
        'the_bible'          => [
            'label'   => 'The Bible',
            'default' => 'The Scriptures of the Old and New Testaments were given by inspiration of God, and are our only infallible rule of faith and practice.',
        ],
        'the_godhead'            => [
            'label'   => 'God (The Trinity)',
            'default' => 'We believe that there is one God, eternally existent in three persons: the Father, Son and Holy Spirit, and that each person of the Triune Godhead is equal, eternal, and self-existent as God.',
        ],
        'jesus_christ'         => [
            'label'   => 'Jesus Christ',
            'default' => 'We believe in the deity of our Lord Jesus Christ, in His virgin birth, in His sinless life, in His substitutionary death, in His bodily resurrection, in His ascension to the right hand of the Father, and in His personal return in power and glory.',
        ],
        'the_holy_spirit'     => [
            'label'   => 'The Holy Spirit',
            'default' => 'We believe in the present ministry of the Holy Spirit by whose indwelling the Christian is enabled to live a godly life.',
        ],
        'human_sinfulness'     => [
            'label'   => 'Human Sinfulness',
            'default' => 'Man was created innocent, but by disobedience fell into a state of sin and condemnation. All people, therefore, inherit a fallen nature of such tendencies that all who come to years of accountability, sin and become guilty before God.',
        ],
        'salvation_doctrine'      => [
            'label'   => 'Salvation Doctrine',
            'default' => 'We believe that for the salvation of lost and sinful man, regeneration by the Holy Spirit is absolutely essential. We further believe that salvation is a totally free gift from God and cannot be earned by any amount of good deeds or religious activity.',
        ],
        'salvation_terms' => [
            'label'   => 'Terms of Salvation',
            'default' => 'The conditions of salvation are: (1) Repentance of sin or sincere sorrow for sin and hearty renunciation of it. (2) Faith or the unreserved committal of one’s self to Christ as Savior and Lord with purpose to love and obey Him in all things. Repentance and faith are not to be viewed as two separate actions, but two ways of stating the same decision. In the exercise of saving faith, the soul is renewed by the Holy Spirit, freed from the dominion of sin, and becomes a child of God. (3) Continuance in faith unto death.',
        ],
        'freedom_of_will'   => [
            'label'   => 'Freedom of the Will',
            'default' => 'Under the work and influence of the Holy Spirit, the human will is freed and enabled to choose, having power to yield to the influence of the truth and the Spirit, or to resist them and perish.',
        ],
        'salvation_free'         => [
            'label'   => 'Salvation Free',
            'default' => 'We believe that God desires the salvation of all, the Gospel invites all, the Holy Spirit strives with all, and whosoever will may come and take of the water of life freely.',
        ],
        'perseverance'         => [
            'label'   => 'Perseverance',
            'default' => 'We believe that all disciples of Christ, who through grace persevere in faith to the end of life, have promise of eternal salvation.',
        ],
        'eternal_future_destiny' => [
            'label'   => 'Resurrection, Judgement, and Final Retribution',
            'default' => 'We believe in the resurrection of both the saved and the lost; they that are saved unto the resurrection of life and they that are lost unto the resurrection of punishment.',
        ],
        'the_church_universal'         => [
            'label'   => 'The Church',
            'default' => 'We believe in the spiritual unity of believers in our Lord Jesus Christ. Northwest recognizes that we are one gathering of believers who make up just one part of the universal body of Christ, the Church. We share Christian fellowship with all who hold Jesus as their one and only Savior.',
        ],
        'gospel_ordinances'         => [
            'label'   => 'Gospel Ordiances',
            'default' => 'We believe that the New Testament teaches the following perpetual practices in the church: Baptism, or the immersion of believers in water and the Lord’s Supper. Feet Washing, an ordinance teaching humility, is of universal obligation, and is to be ministered to all true believers.',
        ],
        'tithing'         => [
            'label'   => 'Tithing',
            'default' => 'We believe that God commanded tithes and offerings in the Old Testament; Jesus endorsed it in the Gospels, and the apostle Paul said, “Upon the first day of the week let every one of you lay by him in store, as God hath prospered him” (1 Cor. 16:2a).',
        ],
        'the_christian_sabbath'         => [
            'label'   => 'The Christian Sabbath',
            'default' => 'We believe that Divine law teaches that one day in seven be set apart from secular employments and amusements for rest, worship, holy works and activities, and for personal communion with God. In the Christian era this is Sunday in celebration of Jesus Christ’s resurrection on that day.',
        ],
    ];

    // This is the section that will contain all the individual belief content controls
    $indivdual_beliefs_section_id = 'fwbsite_beliefs_indivdual_section';
    if ( ! $wp_customize->get_section( $indivdual_beliefs_section_id ) ) {
        $wp_customize->add_section(
            $indivdual_beliefs_section_id,
            array(
                'title'       => __( 'Edit Beliefs', 'fwbsite' ),
                'description' => __( 'You can reword and customize the beliefs page to match your doctrine.', 'fwbsite' ),
                'panel'       => $beliefs_panel_id, // Assign to the main beliefs panel
                'priority'    => 40, // Position it after the general settings
            )
        );
    }

    $priority_counter = 20; // Start priority for controls within the 'Edit Beliefs' section

    foreach ( $beliefs as $id_suffix => $belief_data ) {
        $belief_setting_id = 'fwbsite_belief_content_' . $id_suffix;

        // Add setting for the belief content
        $wp_customize->add_setting(
            $belief_setting_id,
            array(
                'default'           => $belief_data['default'],
                'type'              => 'theme_mod',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'wp_kses_post', // Use wp_kses_post for rich text content
                'transport'         => 'refresh',
            )
        );

        // Add control for the belief content (textarea)
        $wp_customize->add_control(
            $belief_setting_id, // CONTROL ID matches SETTING ID
            array(
                'label'       => $belief_data['label'], // Use the belief's label for its control
                'section'     => $indivdual_beliefs_section_id, // Link to the single 'Edit Beliefs' section
                'settings'    => $belief_setting_id, // Settings ID
                'type'        => 'textarea',
                'description' => sprintf( __( 'Content for the belief point: %s', 'fwbsite' ), $belief_data['label'] ),
                'priority'    => $priority_counter, // Give each control a unique priority
            )
        );

        $priority_counter += 10;
    }

    // --- 4. Add a NEW SECTION for Church Covenant (parallel to other belief sections) ---
    $covenant_section_id = 'fwbsite_church_covenant_section';
    if ( ! $wp_customize->get_section( $covenant_section_id ) ) {
        $wp_customize->add_section(
            $covenant_section_id,
            array(
                'title'       => __( 'Church Covenant', 'fwbsite' ),
                'description' => __( 'Manage the display and content of your Church Covenant.', 'fwbsite' ),
                'panel'       => $beliefs_panel_id, // Assign to the main 'Edit Beliefs Page' panel
                'priority'    => 50, // Position it after the 'Edit Beliefs' section
            )
        );
    }

    // Toggle for displaying Church Covenant
    $wp_customize->add_setting(
        'fwbsite_display_church_covenant',
        array(
            'default'           => false, // Default to off
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'fwbsite_sanitize_checkbox', // Custom sanitize callback for checkboxes
            'transport'         => 'refresh',
        )
    );
    $wp_customize->add_control(
        'fwbsite_display_church_covenant',
        array(
            'label'       => __( 'Display Church Covenant?', 'fwbsite' ),
            'section'     => $covenant_section_id, // Link to this new 'Church Covenant' section
            'settings'    => 'fwbsite_display_church_covenant',
            'type'        => 'checkbox',
            'description' => __( 'Check to display the Church Covenant section on your beliefs page.', 'fwbsite' ),
            'priority'    => 10,
        )
    );

    // Church Covenant Title
    $wp_customize->add_setting(
        'fwbsite_church_covenant_title',
        array(
            'default'           => __( 'Our Church Covenant', 'fwbsite' ),
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        )
    );
    $wp_customize->add_control(
        'fwbsite_church_covenant_title',
        array(
            'label'       => __( 'Covenant Section Title', 'fwbsite' ),
            'section'     => $covenant_section_id, // Link to this new 'Church Covenant' section
            'settings'    => 'fwbsite_church_covenant_title',
            'type'        => 'text',
            'description' => __( 'Title for the Church Covenant section.', 'fwbsite' ),
            'priority'    => 20,
            //'active_callback' => 'fwbsite_is_church_covenant_enabled', // Only show if toggle is on
        )
    );

    // Church Covenant Content
    $wp_customize->add_setting(
        'fwbsite_church_covenant_content',
        array(
            'default'           => __( 'Having been led, as we believe, by the Spirit of God, to receive the Lord Jesus Christ as our Savior, and on the profession of our faith, having been baptized in the name of the Father, and of the Son, and of the Holy Spirit, we do now, in the presence of God and this assembly, most solemnly and joyfully enter into covenant with one another as one body in Christ.', 'fwbsite' ),
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_kses_post', // Allows HTML for rich text content
            'transport'         => 'refresh',
        )
    );
    $wp_customize->add_control(
        'fwbsite_church_covenant_content',
        array(
            'label'       => __( 'Covenant Content', 'fwbsite' ),
            'section'     => $covenant_section_id, // Link to this new 'Church Covenant' section
            'settings'    => 'fwbsite_church_covenant_content',
            'type'        => 'textarea',
            'description' => __( 'Enter the full text of your church covenant here.', 'fwbsite' ),
            'priority'    => 30,
            //'active_callback' => 'fwbsite_is_church_covenant_enabled', // Only show if toggle is on
        )
    );

    // --- Partnerships & Affiliations Section ---
$partnerships_section_id = 'fwbsite_partnerships_section';
if ( ! $wp_customize->get_section( $partnerships_section_id ) ) {
  $wp_customize->add_section(
    $partnerships_section_id,
    array(
      'title'       => __( 'Partnerships & Affiliations', 'fwbsite' ),
      'description' => __( 'Manage partnerships and affiliations shown on the beliefs page.', 'fwbsite' ),
      'panel'       => $beliefs_panel_id,
      'priority'    => 60,
    )
  );
}

// Global toggle to display partnerships block
$wp_customize->add_setting(
  'fwbsite_display_partnerships',
  array(
    'default'           => false,
    'type'              => 'theme_mod',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'fwbsite_sanitize_checkbox',
    'transport'         => 'refresh',
  )
);
$wp_customize->add_control(
  'fwbsite_display_partnerships',
  array(
    'label'       => __( 'Display Partnerships & Affiliations?', 'fwbsite' ),
    'section'     => $partnerships_section_id,
    'settings'    => 'fwbsite_display_partnerships',
    'type'        => 'checkbox',
    'description' => __( 'Check to display the Partnerships & Affiliations section on your beliefs page.', 'fwbsite' ),
    'priority'    => 5,
  )
);

// Section title
$wp_customize->add_setting(
  'fwbsite_partnerships_title',
  array(
    'default'           => __( 'Partnerships & Affiliations', 'fwbsite' ),
    'type'              => 'theme_mod',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_text_field',
    'transport'         => 'refresh',
  )
);
$wp_customize->add_control(
  'fwbsite_partnerships_title',
  array(
    'label'           => __( 'Section title', 'fwbsite' ),
    'section'         => $partnerships_section_id,
    'settings'        => 'fwbsite_partnerships_title',
    'type'            => 'text',
    'priority'        => 10,
    //'active_callback' => 'fwbsite_is_partnerships_enabled',
  )
);

// Create 10 affiliation controls using a loop
for ( $i = 1; $i <= 10; $i++ ) {
  // display toggle for each affiliation
  $wp_customize->add_setting(
    "fwbsite_affiliation_{$i}_display",
    array(
      'default'           => false,
      'type'              => 'theme_mod',
      'capability'        => 'edit_theme_options',
      'sanitize_callback' => 'fwbsite_sanitize_checkbox',
      'transport'         => 'refresh',
    )
  );
  $wp_customize->add_control(
    "fwbsite_affiliation_{$i}_display",
    array(
      'label'       => sprintf( __( 'Show Affiliation %d', 'fwbsite' ), $i ),
      'section'     => $partnerships_section_id,
      'settings'    => "fwbsite_affiliation_{$i}_display",
      'type'        => 'checkbox',
      'priority'    => 10 + ( $i * 10 ) - 9, // spacing
      //'active_callback' => 'fwbsite_is_partnerships_enabled',
    )
  );

  // affiliation name
  $wp_customize->add_setting(
    "fwbsite_affiliation_{$i}_name",
    array(
      'default'           => sprintf( __( 'Affiliation %d', 'fwbsite' ), $i ),
      'type'              => 'theme_mod',
      'capability'        => 'edit_theme_options',
      'sanitize_callback' => 'sanitize_text_field',
      'transport'         => 'refresh',
    )
  );
  $wp_customize->add_control(
    "fwbsite_affiliation_{$i}_name",
    array(
      'label'           => sprintf( __( 'Affiliation %d Name', 'fwbsite' ), $i ),
      'section'         => $partnerships_section_id,
      'settings'        => "fwbsite_affiliation_{$i}_name",
      'type'            => 'text',
      'priority'        => 10 + ( $i * 10 ) - 8,
     //'active_callback' => 'fwbsite_is_affiliation_enabled',
    )
  );

  // affiliation description
  $wp_customize->add_setting(
    "fwbsite_affiliation_{$i}_description",
    array(
      'default'           => '',
      'type'              => 'theme_mod',
      'capability'        => 'edit_theme_options',
      'sanitize_callback' => 'wp_kses_post',
      'transport'         => 'refresh',
    )
  );
  $wp_customize->add_control(
    "fwbsite_affiliation_{$i}_description",
    array(
      'label'           => sprintf( __( 'Affiliation %d Description', 'fwbsite' ), $i ),
      'section'         => $partnerships_section_id,
      'settings'        => "fwbsite_affiliation_{$i}_description",
      'type'            => 'textarea',
      'priority'        => 10 + ( $i * 10 ) - 7,
      'description'     => __( 'Enter a short description or link for this affiliation.', 'fwbsite' ),
      //'active_callback' => 'fwbsite_is_affiliation_enabled',
    )
  );
}


} // End fwbsite_customize_beliefs_page

add_action( 'customize_register', 'fwbsite_customize_beliefs_page' );


// =====================================================================
// Helper Functions for Customizer (Sanitization and Active Callbacks)
// =====================================================================

/**
 * Customizer Active Callback: Check if the Church Covenant is enabled.
 *
 * @param WP_Customize_Control $control The control instance.
 * @return bool Whether the control should be active.
 */
function fwbsite_is_church_covenant_enabled( $control ) {
    return $control->manager->get_setting('fwbsite_display_church_covenant')->value();
}

/**
 * Sanitize callback for checkbox settings.
 * Ensures the value is either true or false.
 *
 * @param mixed $input The input value.
 * @return bool Sanitized boolean value.
 */
function fwbsite_sanitize_checkbox( $input ) {
    return ( isset( $input ) && true === $input ) ? true : false;
}




/**
 * Return true if Partnerships section toggle is enabled.
 *
 * @param WP_Customize_Control $control
 * @return bool
 */
function fwbsite_is_partnerships_enabled( $control ) {
  return (bool) $control->manager
    ->get_setting( 'fwbsite_display_partnerships' )
    ->value();
}

/**
 * Return true if the specific affiliation's display checkbox is checked.
 * This function infers the affiliation index from the control id.
 *
 * @param WP_Customize_Control $control
 * @return bool
 */
function fwbsite_is_affiliation_enabled( $control ) {
  $id = ( isset( $control->id ) ) ? $control->id : '';
  if ( preg_match( '/fwbsite_affiliation_([0-9]+)_/', $id, $m ) ) {
    $index = $m[1];
    return (bool) $control->manager
      ->get_setting( "fwbsite_affiliation_{$index}_display" )
      ->value();
  }
  return false;
}
