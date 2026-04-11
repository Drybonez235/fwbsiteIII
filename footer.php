<?php
/**
 * The template for displaying the footer
 *
 * Displays all of the footer section and everything up until </html>
 *
 * @package fwbsiteIII
 */

$context = Timber::context();

Timber::render( 'sections/footer.twig', $context );