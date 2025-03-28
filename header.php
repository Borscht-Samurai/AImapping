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
            <a href="<?php echo esc_url(home_url('/')); ?>" class="custom-logo-link">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    echo '<span class="site-title">AI Mapping</span>';
                }
                ?>
            </a>
        </div>

        <nav class="main-navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class' => 'nav-menu',
                'container' => false,
                'fallback_cb' => false,
                'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                'depth' => 1,
            ));
            ?>
        </nav>

        <div class="header-actions">
            <?php if (is_user_logged_in()) : ?>
                <div class="user-menu">
                    <a href="<?php echo esc_url(home_url('/user')); ?>" class="profile-link">プロフィール</a>
                    <a href="<?php echo esc_url(home_url('/recruitment')); ?>" class="posts-link">募集をみる</a>
                    <a href="<?php echo esc_url(home_url('/new-post')); ?>" class="new-post-btn">投稿する</a>
                    <a href="<?php echo wp_logout_url(home_url()); ?>" class="logout-btn">ログアウト</a>
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