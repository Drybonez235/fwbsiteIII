<footer class="site-footer">
    <div class="footer-container">

        <!-- Church Logo & Name -->
        <div class="footer-branding">
            <?php
    if ( function_exists('the_custom_logo') && has_custom_logo() ) {
        the_custom_logo();
    } else {
        // Fallback: site title if no logo is set
        echo '<h1><a href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a></h1>';
    }
    ?>
        </div>
        <!-- Service Information -->
        <div class="footer-service-info">
            <p>Sunday School:
                <?php echo get_theme_mod('sunday_school_time', '9:30 AM'); ?>
            </p>
            <p>Sunday Service:
                <?php echo get_theme_mod('sunday_service_time', '11:00 AM'); ?>
            </p>

            <?php if ( get_theme_mod('enable_sunday_night', false) ) : ?>
                <p>
                    Sunday Night:
                    <?php echo get_theme_mod('sunday_night_time', '6:00 PM'); ?>
                </p>
            <?php endif; ?>

            <?php if ( get_theme_mod('enable_wednesday_night', false) ) : ?>
                <p>
                    Wednesday Night:
                    <?php echo get_theme_mod('wednesday_night_time', '7:00 PM'); ?>
                </p>
            <?php endif; ?>
        </div>


        <div class="footer-right">
            <!-- Church Info -->
            <div class="footer-info">
                <p class="footer-phone">
                    <a href="tel:<?php echo esc_attr( get_theme_mod('church_phone', '(555) 123-4567') ); ?>">
                        <?php echo esc_html( get_theme_mod('church_phone', '(555) 123-4567') ); ?>
                    </a>
                </p>
                <p class="footer-email">
                    <a href="mailto:<?php echo antispambot( get_theme_mod('church_email', 'info@yourchurch.org') ); ?>">
                        <?php echo esc_html( get_theme_mod('church_email', 'info@yourchurch.org') ); ?>
                    </a>
                </p>
                <p class="footer-address">
                    <?php echo esc_html( get_theme_mod('church_address', '123 Main Street, Hometown, USA') ); ?>
                </p>
            </div>
            <!-- Social Media (conditionally rendered) -->
            <div class="footer-social">
                <ul class="social-links">
                    <?php if ( get_theme_mod('church_facebook_enabled') && get_theme_mod('church_facebook') ) : ?>
                    <li><a href="<?php echo esc_url( get_theme_mod('church_facebook') ); ?>" target="_blank"
                            rel="noopener"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.675 0h-21.35C.597 0 0 .597 0 1.326v21.348C0 23.403.597 24 1.326 
24h11.494v-9.294H9.691v-3.622h3.129V8.413c0-3.1 1.894-4.788 4.659-4.788 
1.325 0 2.464.099 2.796.143v3.24l-1.918.001c-1.505 0-1.796.716-1.796 
1.765v2.313h3.587l-.467 3.622h-3.12V24h6.116C23.403 24 24 23.403 24 
22.674V1.326C24 .597 23.403 0 22.675 0z" />
                            </svg>
                        </a></li>
                    <?php endif; ?>


                    <?php if ( get_theme_mod('church_instagram_enabled') && get_theme_mod('church_instagram') ) : ?>
                    <li><a href="<?php echo esc_url( get_theme_mod('church_instagram') ); ?>" target="_blank"
                            rel="noopener"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 
4.85.07 1.366.062 2.633.35 
3.608 1.325.975.975 1.262 2.242 
1.324 3.608.058 1.266.07 1.646.07 
4.85s-.012 3.584-.07 4.85c-.062 
1.366-.35 2.633-1.324 
3.608-.975.975-2.242 1.262-3.608 
1.324-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.35-3.608-1.324-.975-.975-1.262-2.242-1.324-3.608C2.175 
15.747 2.163 15.367 2.163 
12s.012-3.584.07-4.85c.062-1.366.35-2.633 
1.324-3.608.975-.975 2.242-1.262 
3.608-1.324C8.416 2.175 8.796 2.163 
12 2.163zm0-2.163C8.741 0 8.332.014 
7.052.072 5.773.13 4.638.428 
3.678 1.388c-.96.96-1.258 2.095-1.316 
3.374C2.014 5.04 2 5.449 2 
8.708v6.584c0 3.259.014 3.668.072 
4.948.058 1.279.356 2.414 1.316 
3.374.96.96 2.095 1.258 3.374 
1.316 1.28.058 1.689.072 
4.948.072s3.668-.014 
4.948-.072c1.279-.058 2.414-.356 
3.374-1.316.96-.96 1.258-2.095 
1.316-3.374.058-1.28.072-1.689.072-4.948V8.708c0-3.259-.014-3.668-.072-4.948-.058-1.279-.356-2.414-1.316-3.374-.96-.96-2.095-1.258-3.374-1.316C15.668.014 
15.259 0 12 0z" />
                                <path d="M12 5.838a6.162 6.162 0 100 12.324 6.162 
6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 
4 0 010 8zM18.406 4.594a1.44 1.44 0 100 
2.881 1.44 1.44 0 000-2.881z" />
                            </svg>
                        </a></li>
                    <?php endif; ?>

                    <?php if ( get_theme_mod('church_youtube_enabled') && get_theme_mod('church_youtube') ) : ?>
                    <li><a href="<?php echo esc_url( get_theme_mod('church_youtube') ); ?>" target="_blank"
                            rel="noopener"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a2.974 2.974 0 00-2.09-2.106C19.505 
3.5 12 3.5 12 3.5s-7.505 0-9.408.58a2.974 2.974 0 00-2.09 
2.106C0 8.1 0 12 0 12s0 3.9.502 
5.814a2.974 2.974 0 002.09 
2.106C4.495 20.5 12 20.5 12 
20.5s7.505 0 9.408-.58a2.974 2.974 
0 002.09-2.106C24 15.9 24 12 
24 12s0-3.9-.502-5.814zM9.75 
15.568V8.432L15.818 12 9.75 
15.568z" />
                            </svg>
                        </a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</footer>