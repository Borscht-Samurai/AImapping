<?php
/**
 * Template Name: プロフィールページ
 *
 * page-templates/profile-template.php - ユーザー自身のプロフィールページテンプレート
 */

// ログインしていないユーザーはログインページにリダイレクト
if (!is_user_logged_in()) {
    wp_redirect(home_url('/login'));
    exit;
}

$current_user = wp_get_current_user();

get_header();
?>

<main class="site-main archive-recruitment-page">
    <div class="profile-header">
        <h1 class="profile-title">My page</h1>
    </div>

    <div class="container">
        <div class="profile-container">
            <?php
            // ユーザープロフィールテンプレートパーツを表示
            get_template_part('template-parts/user-profile', null, array(
                'user_id' => $current_user->ID,
                'show_actions' => true,
                'show_recent_events' => true
            ));
            ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>