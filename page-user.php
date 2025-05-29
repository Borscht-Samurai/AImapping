<?php
/**
 * Template Name: ユーザープロフィール
 */

// ユーザー情報を取得
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : get_current_user_id();
$user = get_userdata($user_id);

// ユーザーが存在しない場合はホームページにリダイレクト
if (!$user) {
    wp_redirect(home_url());
    exit;
}

get_header();

// プロフィール画像を取得
$profile_data = get_user_profile_data($user_id);
$custom_avatar_id = $profile_data['custom_avatar'];
$profile_image = $custom_avatar_id ? wp_get_attachment_image_url($custom_avatar_id, 'thumbnail') : get_avatar_url($user_id, array('size' => 150));

// SNSリンクを取得
$twitter_url = get_user_meta($user_id, 'twitter_url', true);
$facebook_url = get_user_meta($user_id, 'facebook_url', true);
$instagram_url = get_user_meta($user_id, 'instagram_url', true);
$youtube_url = get_user_meta($user_id, 'youtube_url', true);
?>

<!-- グラデーションセクション -->
<section class="gradient-box-section">
    <div class="gradient-box">
        <div class="gradient-box-content">
            <h1 class="profile-title"><?php echo ($user_id === get_current_user_id()) ? 'マイプロフィール' : sprintf('%sさんのプロフィール', esc_html($user->display_name)); ?></h1>
        </div>
    </div>
</section>

<!-- プロフィールセクション -->
<section class="profile-section">
    <div class="profile-container">
        <!-- プロフィール情報 -->
        <div class="profile-info">
            <div class="profile-header">
                <img src="<?php echo esc_url($profile_image); ?>" alt="プロフィール画像" class="profile-image">
                <div class="profile-content">
                    <div class="profile-top">
                        <div class="name-role-container">
                            <h2 class="profile-name"><?php echo esc_html($user->display_name); ?></h2>
                            <?php if (!empty($profile_data['role'])) : ?>
                            <div class="profile-role">
                                <span class="role-value"><?php echo esc_html($profile_data['role']); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                        <!-- プロフィール編集ボタン -->
                        <?php if (is_user_logged_in() && get_current_user_id() === $user_id) : ?>
                        <div class="profile-actions">
                            <a href="<?php echo wp_logout_url(home_url()); ?>" class="logout-button">
                                <i class="fas fa-sign-out-alt"></i> LOGOUT
                            </a>
                            <a href="<?php echo esc_url(home_url('/edit-profile/')); ?>" class="edit-profile-button">
                                <i class="fas fa-edit"></i> EDIT PROFILE
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($profile_data['description'])) : ?>
                    <div class="profile-description">
                        <?php echo wp_kses_post($profile_data['description']); ?>
                    </div>
                    <?php endif; ?>

                    <!-- SNSリンク -->
                    <?php if (!empty($twitter_url) || !empty($facebook_url) || !empty($instagram_url) || !empty($youtube_url)) : ?>
                    <div class="profile-social-links">
                        <?php if (!empty($twitter_url)) : ?>
                            <a href="<?php echo esc_url($twitter_url); ?>" target="_blank" rel="noopener noreferrer" class="social-link">
                                <i class="fab fa-twitter"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($facebook_url)) : ?>
                            <a href="<?php echo esc_url($facebook_url); ?>" target="_blank" rel="noopener noreferrer" class="social-link">
                                <i class="fab fa-facebook"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($instagram_url)) : ?>
                            <a href="<?php echo esc_url($instagram_url); ?>" target="_blank" rel="noopener noreferrer" class="social-link">
                                <i class="fab fa-instagram"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($youtube_url)) : ?>
                            <a href="<?php echo esc_url($youtube_url); ?>" target="_blank" rel="noopener noreferrer" class="social-link">
                                <i class="fab fa-youtube"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <?php if (is_user_logged_in() && get_current_user_id() !== $user_id) : ?>
                        <div class="profile-actions">
                            <?php
                            // フォロー機能（実装されている場合）
                            if (function_exists('is_following_user')) :
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
                                <a href="<?php echo esc_url($follow_url); ?>" class="follow-button <?php echo $is_following ? 'following' : ''; ?>">
                                    <i class="fas fa-<?php echo $is_following ? 'user-minus' : 'user-plus'; ?>"></i>
                                    <?php echo $is_following ? 'フォロー解除' : 'フォローする'; ?>
                                </a>
                            <?php endif; ?>

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
                                <a href="<?php echo esc_url($message_url); ?>" class="message-button">
                                    <i class="fas fa-envelope"></i> メッセージを送る
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- 投稿一覧 -->
        <div class="author-posts">
            <h3 class="posts-title"><?php echo esc_html($user->display_name); ?>さんの投稿</h3>
            
            <div class="recruitment-grid">
                <?php
                $args = array(
                    'post_type' => 'recruitment',
                    'posts_per_page' => 6,
                    'author' => $user_id,
                    'orderby' => 'date',
                    'order' => 'DESC'
                );
                
                $query = new WP_Query($args);
                
                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                        get_template_part('template-parts/content', 'card');
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p class="no-posts">投稿がありません。</p>';
                endif;
                ?>
            </div>

            <?php if ($query->max_num_pages > 1) : ?>
            <div class="load-more-container">
                <button id="load-more" class="load-more-button" data-user="<?php echo esc_attr($user_id); ?>" data-page="1">
                    もっと見る
                </button>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
/* プロフィールページのスタイル */
.profile-section {
    max-width: 1288px;
    margin: 0 auto;
    padding: 2rem;
}

.profile-container {
    background-color: #E7E7E7;
    border-radius: 15px;
    padding: 2rem;
    margin-top: 2rem;
}

.profile-info {
    margin-bottom: 3rem;
}

.profile-header {
    display: flex;
    align-items: flex-start;
    gap: 2rem;
    margin-bottom: 1.5rem;
}

.profile-image {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
}

.profile-content {
    flex-grow: 1;
}

.profile-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.name-role-container {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.profile-name {
    font-size: 1.8rem;
    margin: 0;
    font-weight: 500;
}

.profile-role {
    color: #666;
    font-size: 1.1rem;
}

.role-value {
    color: #333;
}

.profile-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.edit-profile-button,
.logout-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background-color: white;
    color: #333;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    text-decoration: none;
    transition: all 0.3s;
    font-size: 0.9rem;
    font-weight: 500;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.edit-profile-button:hover {
    background-color: #f5f5f5;
    color: #333;
    text-decoration: none;
}

.logout-button {
    background-color: #E7E7E7;
    border: 1px solid #ccc;
}

.logout-button:hover {
    background-color: #FF966C;
    color: white;
    border-color: #FF966C;
    text-decoration: none;
}

.profile-description {
    margin-top: 1rem;
    line-height: 1.6;
    color: #333;
    margin-bottom: 1rem;
}

.profile-social-links {
    display: flex;
    gap: 1rem;
    align-items: center;
    justify-content: flex-start;
    margin-top: 0.5rem;
}

.social-link {
    color: #333;
    font-size: 1.5rem;
    transition: color 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #fff;
}

.social-link:hover {
    color: #FF966C;
    background-color: #f5f5f5;
}

.author-posts {
    margin-top: 3rem;
}

.posts-title {
    font-size: 1.5rem;
    margin-bottom: 2rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #FF966C;
}

.recruitment-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.load-more-container {
    text-align: center;
    margin-top: 2rem;
}

.load-more-button {
    background-color: #FF966C;
    color: white;
    border: none;
    padding: 0.8rem 2rem;
    border-radius: 25px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.load-more-button:hover {
    background-color: #ff8552;
}

.no-posts {
    text-align: center;
    padding: 2rem;
    color: #666;
}

/* レスポンシブデザイン */
@media (max-width: 768px) {
    .profile-header {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 1.5rem;
    }

    .profile-image {
        width: 120px;
        height: 120px;
    }

    .profile-content {
        width: 100%;
    }

    .profile-top {
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .name-role-container {
        justify-content: center;
    }

    .profile-actions {
        margin-top: 0.5rem;
    }

    .recruitment-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    $('#load-more').on('click', function() {
        var button = $(this);
        var userId = button.data('user');
        var page = button.data('page');
        var nextPage = page + 1;
        
        $.ajax({
            url: wpApiSettings.ajaxUrl,
            type: 'GET',
            data: {
                action: 'load_more_posts',
                user_id: userId,
                page: nextPage
            },
            success: function(response) {
                if (response.success) {
                    $('.recruitment-grid').append(response.data.html);
                    button.data('page', nextPage);
                    
                    if (response.data.is_last_page) {
                        button.hide();
                    }
                }
            }
        });
    });
});
</script>

<?php get_footer(); ?>