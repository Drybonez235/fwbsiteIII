<?php
$context = Timber::context();
$context['post'] = Timber::get_post(); // Timber 2.x uses get_post() instead of a new Post()
Timber::render('front-page.twig', $context);