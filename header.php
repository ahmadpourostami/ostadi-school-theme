<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <span class="brand-mark" aria-hidden="true">ا</span>
            <span><?php bloginfo( 'name' ); ?></span>
        </a>
        <nav class="primary-nav" aria-label="<?php esc_attr_e( 'منوی اصلی', 'ostadi-school' ); ?>">
            <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'fallback_cb' => false ) ); ?>
        </nav>
        <div class="header-actions">
            <a class="btn btn-light" href="<?php echo esc_url( wp_login_url() ); ?>">ورود</a>
            <a class="btn btn-primary" href="<?php echo esc_url( home_url( '/courses/' ) ); ?>">مشاهده دوره‌ها</a>
        </div>
    </div>
</header>
