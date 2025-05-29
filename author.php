<?php
/**
 * author.php - ユーザープロフィールページテンプレート
 */

get_header();

// 現在表示中の著者情報を取得
$author = get_queried_object();
$author_id = $author->ID;

// プロフィール画像を取得
$custom_avatar_id = get_user_meta($author_id, 'custom_avatar', true);
$profile_image = $custom_avatar_id ? wp_get_attachment_image_url($custom_avatar_id, 'thumbnail') : get_avatar_url($author_id, array('size' => 150));

// SNSリンクを取得
$twitter_url = get_user_meta($author_id, 'twitter_url', true);
$facebook_url = get_user_meta($author_id, 'facebook_url', true);
$instagram_url = get_user_meta($author_id, 'instagram_url', true);
$youtube_url = get_user_meta($author_id, 'youtube_url', true);
?>

<!-- グラデーションセクション -->
<section class="gradient-box-section">
    <div class="gradient-box">
        <div class="gradient-box-content">
            <h1 class="profile-title"><?php echo esc_html($author->display_name); ?>のプロフィール</h1>
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
                <h2 class="profile-name"><?php echo esc_html($author->display_name); ?></h2>
            </div>

            <?php if (!empty($author->description)) : ?>
            <div class="profile-description">
                <?php echo wp_kses_post($author->description); ?>
            </div>
            <?php endif; ?>

            <!-- SNSリンク -->
            <?php if (!empty($twitter_url) || !empty($facebook_url) || !empty($instagram_url) || !empty($youtube_url)) : ?>
            <div class="social-links">
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
        </div>

        <!-- 投稿一覧 -->
        <div class="author-posts">
            <h3 class="posts-title"><?php echo esc_html($author->display_name); ?>の投稿</h3>
            
            <div class="recruitment-grid">
                <?php
                $args = array(
                    'post_type' => 'recruitment',
                    'posts_per_page' => 6,
                    'author' => $author_id,
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
                <button id="load-more" class="load-more-button" data-user="<?php echo esc_attr($author_id); ?>" data-page="1">
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
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.profile-image {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
}

.profile-name {
    font-size: 1.8rem;
    margin: 0;
}

.profile-description {
    margin: 1.5rem 0;
    line-height: 1.6;
}

.social-links {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.social-link {
    color: #333;
    font-size: 1.5rem;
    transition: color 0.3s;
}

.social-link:hover {
    color: #FF966C;
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
        text-align: center;
    }

    .profile-image {
        width: 120px;
        height: 120px;
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