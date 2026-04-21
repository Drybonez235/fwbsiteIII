$context = Timber::context();
$context['posts'] = Timber::get_posts(); // Required for Timber 2.x
Timber::render( 'index.twig', $context );