<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
    <div class="logo-info-wrapper">
        <div class="site-logo">
        <?php
        if ( function_exists('the_custom_logo') && has_custom_logo() ) {
            the_custom_logo();
        } else {
            // Fallback: site title if no logo is set
            echo '<h1><a href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a></h1>';
     }
         ?>
        </div>
        <h2 class="church-name">
    <?php echo esc_html( get_theme_mod('church_name', 'Our Church')); ?>
    </h2>
</div>
    <nav class="primary-menu">
        <?php
        wp_nav_menu([
            'theme_location' => 'primary',
            'menu_class'     => 'primary-menu',
            'container'      => false,
            'fallback_cb'    => false, // Don't auto-generate pages
        ]);
        ?>
    </nav>
</header>
