<?php
/**
 * Template Name: プロフィールページ
 *
 * page-templates/profile-template.php - ユーザープロフィールページテンプレート
 */

// プロフィールを表示するユーザーのIDを取得
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : get_current_user_id();
$user = get_userdata($user_id);

// ユーザーが存在しない場合はホームページにリダイレクト
if (!$user) {
    wp_redirect(home_url());
    exit;
}

get_header();
?>

<main class="site-main archive-recruitment-page">
    <div class="profile-header">
        <h1 class="profile-title"><?php echo ($user_id === get_current_user_id()) ? 'My page' : sprintf('%sさんのプロフィール', esc_html($user->display_name)); ?></h1>
    </div>

    <div class="container">
        <div class="user-profile-card">
            <div class="profile-content">
                <div class="profile-header">
                    <div class="avatar-container">
                        <?php echo get_avatar($user_id, 150); ?>
                    </div>

                    <div class="profile-info">
                        <div class="profile-name-container">
                            <h2 class="profile-name"><?php echo esc_html($user->display_name); ?></h2>
                            <?php if (is_user_logged_in() && get_current_user_id() === $user_id) : ?>
                            <div class="profile-buttons">
                                <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="btn btn-danger btn-sm">
                                    <i class="fas fa-sign-out-alt"></i> ログアウト
                                </a>
                                <a href="<?php echo esc_url(home_url('/edit-profile')); ?>" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-user-edit"></i> プロフィール編集
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="profile-role">
                            <?php
                            $role = get_user_meta($user_id, 'role', true);
                            if (!empty($role)) :
                            ?>
                                <div class="current-role">
                                    <span class="role-label">Current role</span>
                                    <span class="role-value"><?php echo esc_html($role); ?></span>
                                </div>
                            <?php else : ?>
                                <div class="current-role">
                                    <span class="role-label">Current role</span>
                                    <span class="role-value">Software Engineer</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php if (!empty($user->description)) : ?>
                    <div class="profile-bio">
                        <?php echo wpautop(esc_html($user->description)); ?>
                    </div>
                <?php endif; ?>

                <div class="profile-meta">
                    <?php if (!empty($user->user_url)) : ?>
                        <div class="profile-website">
                            <i class="fas fa-globe"></i>
                            <a href="<?php echo esc_url($user->user_url); ?>" target="_blank">
                                <?php echo esc_html($user->user_url); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="profile-stats">
                        <?php
                        // 投稿数
                        $post_count = count_user_posts($user_id, 'recruitment');
                        ?>
                        <span class="post-count">
                            <i class="fas fa-calendar-alt"></i>
                            <?php echo esc_html($post_count); ?> 募集
                        </span>

                        <?php
                        // 参加イベント数（メタデータから取得）
                        $attended_events = get_user_meta($user_id, 'attended_events', true);
                        $attended_count = $attended_events ? count(explode(',', $attended_events)) : 0;
                        ?>
                        <span class="attendance-count">
                            <i class="fas fa-user-check"></i>
                            <?php echo esc_html($attended_count); ?> 参加
                        </span>
                    </div>

                    <?php
                    // SNSリンクの表示
                    $social_links = array(
                        'twitter' => get_user_meta($user_id, 'twitter', true),
                        'facebook' => get_user_meta($user_id, 'facebook', true),
                        'instagram' => get_user_meta($user_id, 'instagram', true),
                        'github' => get_user_meta($user_id, 'github', true),
                    );

                    if (array_filter($social_links)) : ?>
                        <div class="profile-social">
                            <?php foreach ($social_links as $platform => $url) : ?>
                                <?php if (!empty($url)) : ?>
                                    <a href="<?php echo esc_url($url); ?>" class="social-link <?php echo $platform; ?>" target="_blank">
                                        <i class="fab fa-<?php echo $platform; ?>"></i>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (is_user_logged_in() && get_current_user_id() !== $user_id) : ?>
                <div class="profile-actions">
                    <?php
                    // フォロー機能（実装されている場合）
                    $is_following = is_following_user($user_id);
                    $follow_url = add_query_arg(
                        array(
                            'action' => $is_following ? 'unfollow_user' : 'follow_user',
                            'user_id' => $user_id,
                            'nonce' => wp_create_nonce(($is_following ? 'unfollow_' : 'follow_') . $user_id)
                        ),
                        admin_url('admin-post.php')
                    );
                    ?>
                    <a href="<?php echo esc_url($follow_url); ?>" class="btn <?php echo $is_following ? 'btn-secondary' : 'btn-primary'; ?>">
                        <i class="fas fa-<?php echo $is_following ? 'user-minus' : 'user-plus'; ?>"></i>
                        <?php echo $is_following ? 'フォロー解除' : 'フォローする'; ?>
                    </a>

                    <?php
                    // メッセージ機能（実装されている場合）
                    if (function_exists('send_message_to_user')) :
                        $message_url = add_query_arg(
                            array(
                                'recipient' => $user_id
                            ),
                            home_url('/messages')
                        );
                    ?>
                        <a href="<?php echo esc_url($message_url); ?>" class="btn btn-secondary">
                            <i class="fas fa-envelope"></i> メッセージを送る
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php
            // 最近のイベントを表示
            $recent_events_args = array(
                'post_type' => 'recruitment',
                'posts_per_page' => 3,
                'author' => $user_id,
                'orderby' => 'date',
                'order' => 'DESC'
            );

            $recent_events = new WP_Query($recent_events_args);

            if ($recent_events->have_posts()) : ?>
                <div class="recent-events">
                    <h3><?php echo esc_html($user->display_name); ?>さんの最近の募集</h3>
                    <div class="events-grid-container">
                        <div class="events-grid profile-events-grid" id="profile-events-grid">
                            <?php while ($recent_events->have_posts()) : $recent_events->the_post(); ?>
                                <?php get_template_part('template-parts/content', 'card'); ?>
                            <?php endwhile; ?>
                        </div>
                    </div>

                    <div class="view-all">
                        <a href="#" class="btn btn-outline load-more-posts" data-user="<?php echo esc_attr($user_id); ?>" data-page="1" data-loading="false">
                            もっと見る
                        </a>
                    </div>
                </div>
                <?php
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.querySelector('.load-more-posts');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            if (this.dataset.loading === 'true') return;
            
            const userId = this.dataset.user;
            const nextPage = parseInt(this.dataset.page) + 1;
            const container = document.getElementById('profile-events-grid');
            
            this.dataset.loading = 'true';
            this.textContent = '読み込み中...';

            // Ajax リクエスト
            fetch(`${wpApiSettings.ajaxUrl}?action=load_more_posts&user_id=${userId}&page=${nextPage}`, {
                method: 'GET',
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // 新しい投稿を追加
                    container.insertAdjacentHTML('beforeend', data.data.html);
                    this.dataset.page = nextPage;
                    
                    // 全ての投稿を読み込んだ場合
                    if (data.data.is_last_page) {
                        this.style.display = 'none';
                    }
                }
                
                this.dataset.loading = 'false';
                this.textContent = 'もっと見る';
            })
            .catch(error => {
                console.error('Error:', error);
                this.dataset.loading = 'false';
                this.textContent = 'もっと見る';
            });
        });
    }
});
</script>

<?php get_footer(); ?>