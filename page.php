<?php
/**
 * The template for displaying all pages
 */

$context = Timber::context();
$timber_post = Timber::get_post();
$context['post'] = $timber_post;

Timber::render( [ 'page-' . $timber_post->post_name . '.twig', 'page.twig' ], $context );