<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="header-container">
        <div class="site-branding">
            <?php
            if (has_custom_logo()) {
                the_custom_logo();
            } elseif (get_theme_mod('logo_image')) {
                echo '<a href="' . esc_url(home_url('/')) . '" rel="home">';
                echo '<img src="' . get_template_directory_uri() . '/images/Logo.png" alt="AI Mapping" class="custom-logo">';
                echo '</a>';
            } else {
                echo '<a href="' . esc_url(home_url('/')) . '" rel="home" class="site-title">AI Mapping</a>';
            }
            ?>
        </div>

        <button class="mobile-menu-toggle" aria-label="メニュー">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>

        <nav class="main-navigation">
            <ul class="nav-menu">
                <li><a href="<?php echo esc_url(home_url('/recruitment')); ?>">募集をみる</a></li>
                <li><a href="<?php echo esc_url(home_url('/new-post')); ?>">投稿する</a></li>
                <li><a href="<?php echo esc_url(home_url('/contact')); ?>">問い合わせ</a></li>
            </ul>
        </nav>

        <div class="header-actions">
            <?php if (is_user_logged_in()) : ?>
                <div class="user-menu">
                    <a href="<?php echo esc_url(home_url('/user')); ?>" class="profile-link">マイプロフィール</a>
                </div>
            <?php else : ?>
                <div class="auth-buttons">
                    <a href="<?php echo esc_url(home_url('/login')); ?>" class="login-btn">ログイン</a>
                    <a href="<?php echo esc_url(home_url('/register1')); ?>" class="register-btn">新規登録をする</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>

<div class="site-content">