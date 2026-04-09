<?php
/**
 * Registers the "Our Ministries" Customizer panel, individual ministry sections, and controls.
 *
 * This function creates a top-level Customizer panel for "Our Ministries".
 * Within this panel, it dynamically creates a separate section for each of 5 ministries,
 * allowing for individual configuration of each ministry's details.
 *
 * @param WP_Customize_Manager $wp_customize The WP_Customize_Manager instance.
 */
function fwbsite_customize_ministries_page( $wp_customize ) {

	// --- 1. Add the new Customizer Panel for "Our Ministries" ---
    // RENAMED PANEL ID: 'fwbsite_ministries_main_panel'
	$ministries_panel_id = 'fwbsite_ministries_main_panel';
	if ( ! $wp_customize->get_panel( $ministries_panel_id ) ) {
		$wp_customize->add_panel(
			$ministries_panel_id,
			array(
				'title'       => __( 'Ediit Ministries Page', 'fwbsite' ), // Top-level title in the Customizer
				'description' => __( 'Manage the details and display of your church ministries.', 'fwbsite' ),
				'priority'    => 50, // Adjust priority to position it appropriately (e.g., after Beliefs)
			)
		);
	}

	$prefix = 'fwbsite_ministry_'; // Use a new, consistent prefix for clarity
	$total  = 5;

	for ( $i = 1; $i <= $total; $i++ ) {
        // --- 2. Add a new Section for EACH individual ministry ---
        // RENAMED SECTION ID: 'fwbsite_ministry_' . $i . '_details_section'
        $ministry_section_id = $prefix . $i . '_details_section'; // e.g., 'fwbsite_ministry_1_details_section'
        $wp_customize->add_section(
            $ministry_section_id,
            array(
                'title'       => sprintf( __( 'Ministry %d Details', 'fwbsite' ), $i ), // e.g., 'Ministry 1 Details'
                'description' => sprintf( __( 'Configure the details for Ministry %d.', 'fwbsite' ), $i ),
                'panel'       => $ministries_panel_id, // IMPORTANT: Assign this section to the main Ministries panel
                'priority'    => ( $i * 10 ), // Give each ministry section a distinct priority within the panel
            )
        );

		// Setting IDs (all renamed with the new prefix)
		$enabled_id   = $prefix . $i . '_enabled';
		$image_id     = $prefix . $i . '_image';
		$title_id     = $prefix . $i . '_title';
		$catch_id     = $prefix . $i . '_catchphrase';
		$details_id   = $prefix . $i . '_details';

		// Enabled toggle
		$wp_customize->add_setting(
			$enabled_id,
			array(
				'default'           => 0,
				'sanitize_callback' => 'church_ministries_sanitize_checkbox', // Reusing your existing, robust function
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$enabled_id,
			array(
				'label'   => __( 'Enable Ministry', 'fwbsite' ), // Simplified label for clarity within individual section
				'section' => $ministry_section_id, // IMPORTANT: Link to this specific ministry's section
				'type'    => 'checkbox',
			)
		);

		// Image
		$wp_customize->add_setting(
			$image_id,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw', // Using built-in WordPress sanitization
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$image_id, // CONTROL ID matches SETTING ID
				array(
					'label'    => __( 'Ministry Image', 'fwbsite' ), // Simplified label
					'section'  => $ministry_section_id, // IMPORTANT: Link to this specific ministry's section
					'settings' => $image_id,
				)
			)
		);

		// Title
		$wp_customize->add_setting(
			$title_id,
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field', // Using built-in WordPress sanitization
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$title_id, // CONTROL ID matches SETTING ID
			array(
				'label'   => __( 'Ministry Title', 'fwbsite' ), // Simplified label
				'section' => $ministry_section_id, // IMPORTANT: Link to this specific ministry's section
				'type'    => 'text',
			)
		);

		// Catchphrase / short description (single-line text)
		$wp_customize->add_setting(
			$catch_id,
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field', // Using built-in WordPress sanitization
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$catch_id, // CONTROL ID matches SETTING ID
			array(
				'label'   => __( 'Catchphrase / Slogan', 'fwbsite' ), // Simplified label
				'section' => $ministry_section_id, // IMPORTANT: Link to this specific ministry's section
				'type'    => 'text',
			)
		);

		// Details (multi-line plain text)
		$wp_customize->add_setting(
			$details_id,
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_textarea_field', // Using built-in WordPress sanitization
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$details_id, // CONTROL ID matches SETTING ID
			array(
				'label'   => __( 'Ministry Details', 'fwbsite' ), // Simplified label
				'section' => $ministry_section_id, // IMPORTANT: Link to this specific ministry's section
				'type'    => 'textarea',
			)
		);
	}
}
add_action( 'customize_register', 'fwbsite_customize_ministries_page' );

// Keep your custom sanitization functions. Ensure they are loaded before this function.
// For example, you might place these in inc/sanitization-functions.php
/**
 * Sanitize checkbox value.
 *
 * @param mixed $checked
 * @return int 0|1
 */
function church_ministries_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && ( true === $checked || '1' === $checked || 1 === $checked ) ) ? 1 : 0 );
}

/*
// The following built-in WordPress sanitization functions are used above,
// so you generally don't need these custom ones if they're identical.
// If you have specific, additional logic in yours, keep them and use them.

function church_ministries_sanitize_text( $text ) {
	return sanitize_text_field( $text );
}

function church_ministries_sanitize_textarea_plain( $text ) {
	return sanitize_textarea_field( $text ); // wp_strip_all_tags, preg_replace already covered/handled differently by built-in
}

function church_ministries_sanitize_image( $url ) {
	return esc_url_raw( $url );
}
*/