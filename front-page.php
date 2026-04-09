<?php
// front-page.php in theme root
$context = Timber::context();
$context['post'] = Timber::get_post();

Timber::render('front-page.twig', $context);