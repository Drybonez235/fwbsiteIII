<?php
$context = Timber::context();
$context['posts'] = Timber::get_posts(); // Retrieves the global query posts
Timber::render('index.twig', $context);
