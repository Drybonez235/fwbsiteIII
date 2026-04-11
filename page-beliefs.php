<?php
/**
 * Template Name: Beliefs Page
 * Description: A template for displaying the church's statement of faith and core beliefs.
 */


$context = Timber::context();
$context['post'] = Timber::get_post(); // Timber 2.x uses get_post() instead of a new Post()
Timber::render('beliefs-page.twig', $context);