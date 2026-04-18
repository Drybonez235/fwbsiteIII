<?php
/**
 * Template Name: Ministries Page
 * Description: A template for displaying the Church's ministries.
 */

// 1. Grab the global context (which now includes your 'theme' object from functions.php)
$context = Timber::context();

// 2. Fetch the current page data using Timber 2.x syntax
$context['post'] = Timber::get_post();

// 3. Render the twig file (Timber looks in the /views folder automatically)
Timber::render( 'ministries-page.twig', $context );