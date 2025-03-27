<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            } else {
                echo '<h1 class="site-title"><a href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a></h1>';
                echo '<p class="site-description">' . get_bloginfo('description') . '</p>';
            }
            ?>
        </div>

        <nav class="main-navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class' => 'nav-menu',
                'container' => false,
                'fallback_cb' => false,
            ));
            ?>
        </nav>

        <div class="header-actions">
            <?php if (is_user_logged_in()) : ?>
                <div class="user-menu">
                    <a href="<?php echo esc_url(home_url('/user')); ?>" class="profile-link">プロフィール</a>
                    <a href="<?php echo esc_url(home_url('/recruitment')); ?>" class="posts-link">募集一覧</a>
                    <a href="<?php echo esc_url(home_url('/new-post')); ?>" class="new-post-btn">新規投稿</a>
                    <a href="<?php echo wp_logout_url(home_url()); ?>" class="logout-btn">ログアウト</a>
                </div>
            <?php else : ?>
                <div class="auth-buttons">
                    <a href="<?php echo esc_url(home_url('/login')); ?>" class="login-btn">ログイン</a>
                    <a href="<?php echo esc_url(home_url('/register1')); ?>" class="register-btn">新規登録</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>

<div class="site-content"> 