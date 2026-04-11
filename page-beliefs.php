<?php
/**
 * Template Name: Beliefs Page
 * Description: A template for displaying the church's statement of faith and core beliefs.
 */

// 1. Grab the global context (which now includes your 'theme' object from functions.php)
$context = Timber::context();

// 2. Fetch the current page data using Timber 2.x syntax
$context['post'] = Timber::get_post();

// 3. Render the twig file (Timber looks in the /views folder automatically)
Timber::render( 'beliefs-page.twig', $context );