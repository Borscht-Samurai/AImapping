<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="header-container">
        <div class="site-branding">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="custom-logo-link">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    echo '<img src="' . get_template_directory_uri() . '/images/Logo.png" alt="AI Mapping" class="custom-logo" style="height: auto;">';
                }
                ?>
            </a>
        </div>

        <nav class="main-navigation">
            <ul class="nav-menu">
                <li><a href="<?php echo esc_url(home_url('/about')); ?>">わたしたち</a></li>
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