<?php


/**
 * Register Church Info Panel event controls in the Customizer.
 *
 * Adds 5 event groups, each with:
 * - enable toggle (checkbox)
 * - image (WP_Customize_Image_Control)
 * - title (text)
 * - date (text)
 * - location (text)
 * - description (textarea)
 *
 * Assumes a Customizer panel with ID 'church_info_panel' already exists.
 */

/**
 * Sanitize a checkbox value (boolean).
 *
 * @param mixed $checked
 * @return bool
 */
function church_info_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && ( true === $checked || '1' === $checked || 1 === $checked ) ) ? 1 : 0 );
}

/**
 * Sanitize a single-line text string.
 *
 * @param string $text
 * @return string
 */
function church_info_sanitize_text( $text ) {
    return sanitize_text_field( $text );
}

/**
 * Sanitize a textarea string (allow limited tags if needed).
 *
 * @param string $text
 * @return string
 */
function church_info_sanitize_textarea( $text ) {
    // Allow basic formatting if desired, otherwise use sanitize_textarea_field.
    // return wp_kses_post( $text );
    return sanitize_textarea_field( $text );
}

/**
 * Sanitize an image URL coming from the Image control.
 *
 * @param string $url
 * @return string
 */
function church_info_sanitize_image( $url ) {
    return esc_url_raw( $url );
}


/**
 * Register the Events section and controls.
 *
 * @param WP_Customize_Manager $wp_customize
 */

function church_info_register_events_customizer( $wp_customize ) {
    $events_panel_id = 'church_events_panel';

    // 1. Add the Main Panel
    if ( ! $wp_customize->get_panel( $events_panel_id ) ) {
        $wp_customize->add_panel( $events_panel_id, array(
            'title'       => __( 'Edit Events Page', 'fwbsite' ),
            'description' => __( 'Manage the display and details of your church events.', 'fwbsite' ),
            'priority'    => 40,
        ));
    }

    // 2. Create the General Section (Required to hold controls)
    $general_section_id = 'fwbsite_events_general_section';
    $wp_customize->add_section( $general_section_id, array(
        'title'    => __( 'Edit Title, Image, and Intro', 'fwbsite' ),
        'panel'    => $events_panel_id,
        'priority' => 1,
    ));

    // --- Page Title ---
    $wp_customize->add_setting( 'fwbsite_events_page_title', array(
        'default'           => 'Upcoming Events',
        'sanitize_callback' => 'church_info_sanitize_text',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control( 'fwbsite_events_page_title', array(
        'label'    => __( 'Custom Page Title', 'fwbsite' ),
        'section'  => $general_section_id,
        'type'     => 'text',
    ));

    // --- Event Intro Text ---
    $wp_customize->add_setting( 'fwbsite_events_intro_text', array(
        'default'           => '',
        'sanitize_callback' => 'church_info_sanitize_textarea',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control( 'fwbsite_events_intro_text', array(
        'label'    => __( 'Event Intro Text', 'fwbsite' ),
        'description' => __( 'A brief description shown below the title.', 'fwbsite' ),
        'section'  => $general_section_id,
        'type'     => 'textarea',
    ));

    // --- Page Background Image ---
    $wp_customize->add_setting( 'fwbsite_events_page_background_image', array(
        'sanitize_callback' => 'esc_url_raw',
        'type'              => 'theme_mod',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fwbsite_events_page_background_image', array(
        'label'       => __( 'Page Background Image', 'fwbsite' ),
        'section'     => $general_section_id,
        'settings'    => 'fwbsite_events_page_background_image',
    )));

	// Settings prefix
	$prefix = 'church_info_event_';
	$total  = 5;

	for ( $i = 1; $i <= $total; $i++ ) {

          // --- 2. Add a new Section for EACH individual event ---
        $event_section_id = $prefix . $i . '_section'; // e.g., 'church_info_event_1_section'
        $wp_customize->add_section(
            $event_section_id,
            array(
                'title'       => sprintf( __( 'Event %d Details', 'your-textdomain' ), $i ), // e.g., 'Event 1 Details'
                'description' => sprintf( __( 'Configure details for Event %d.', 'your-textdomain' ), $i ),
                'panel'       => $events_panel_id, // IMPORTANT: Assign this section to the main Events panel
                'priority'    => ( $i * 10 ), // Give each event section a distinct priority within the panel
            )
        );

		// Setting IDs
		$enabled_id     = $prefix . $i . '_enabled';
		$image_id       = $prefix . $i . '_image';
		$title_id       = $prefix . $i . '_title';
		$date_id        = $prefix . $i . '_date';
		$location_id    = $prefix . $i . '_location';
		$description_id = $prefix . $i . '_description';

		// Enabled toggle
		$wp_customize->add_setting(
			$enabled_id,
			array(
				'default'           => 0,
				'sanitize_callback' => 'church_info_sanitize_checkbox', // Assuming this is defined globally or earlier
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$enabled_id,
			array(
				'label'   => __( 'Enable Event', 'your-textdomain' ), // Label simplified as it's within "Event X Details"
				'section' => $event_section_id, // IMPORTANT: Link to this specific event's section
				'type'    => 'checkbox',
			)
		);

		// Image
		$wp_customize->add_setting(
			$image_id,
			array(
				'default'           => '',
				'sanitize_callback' => 'church_info_sanitize_image', // Assuming this is defined globally or earlier
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$image_id,
				array(
					'label'    => __( 'Event Image', 'your-textdomain' ), // Label simplified
					'section'  => $event_section_id, // IMPORTANT: Link to this specific event's section
					'settings' => $image_id,
				)
			)
		);

		// Title
		$wp_customize->add_setting(
			$title_id,
			array(
				'default'           => '',
				'sanitize_callback' => 'church_info_sanitize_text', // Assuming this is defined globally or earlier
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$title_id,
			array(
				'label'   => __( 'Event Title', 'your-textdomain' ), // Label simplified
				'section' => $event_section_id, // IMPORTANT: Link to this specific event's section
				'type'    => 'text',
			)
		);

		// Date
		$wp_customize->add_setting(
			$date_id,
			array(
				'default'           => '',
				'sanitize_callback' => 'church_info_sanitize_text', // Assuming this is defined globally or earlier
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$date_id,
			array(
				'label'   => __( 'Event Date/Time', 'your-textdomain' ), // Label simplified
				'section' => $event_section_id, // IMPORTANT: Link to this specific event's section
				'type'    => 'text',
			)
		);

		// Location
		$wp_customize->add_setting(
			$location_id,
			array(
				'default'           => '',
				'sanitize_callback' => 'church_info_sanitize_text', // Assuming this is defined globally or earlier
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$location_id,
			array(
				'label'   => __( 'Event Location', 'your-textdomain' ), // Label simplified
				'section' => $event_section_id, // IMPORTANT: Link to this specific event's section
				'type'    => 'text',
			)
		);

		// Description (textarea)
		$wp_customize->add_setting(
			$description_id,
			array(
				'default'           => '',
				'sanitize_callback' => 'church_info_sanitize_textarea', // Assuming this is defined globally or earlier
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$description_id,
			array(
				'label'   => __( 'Event Description', 'your-textdomain' ), // Label simplified
				'section' => $event_section_id, // IMPORTANT: Link to this specific event's section
				'type'    => 'textarea',
			)
		);
	}
}
add_action( 'customize_register', 'church_info_register_events_customizer' );