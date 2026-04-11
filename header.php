<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package fwbsiteIII
 */

$context = Timber::context();

Timber::render( 'sections/header.twig', $context );