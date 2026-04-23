// single-event.php
$context = Timber::context();
$timber_post = Timber::get_post();
$context['post'] = $timber_post;

Timber::render('single-event.twig', $context);