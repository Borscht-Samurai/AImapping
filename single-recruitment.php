<?php
get_header();

// メタ情報の取得
while (have_posts()) :
    the_post();
    $event_date = get_post_meta(get_the_ID(), 'event_date', true);
    $event_is_online = get_post_meta(get_the_ID(), 'event_is_online', true);
    $event_location = get_post_meta(get_the_ID(), 'event_location', true);
?>

<!-- グラデーションセクション -->
<section class="gradient-box-section">
    <div class="gradient-box">
        <div class="gradient-box-content">
            <!-- タイトル -->
            <h1 class="recruitment-title"><?php the_title(); ?></h1>
        </div>
    </div>
</section>

<!-- 2つのボックスセクション -->
<section class="two-boxes-section">
    <div class="left-box">
        <article class="recruitment-container">
            <!-- タイトル -->
            <h1 class="recruitment-title"><?php the_title(); ?></h1>

            <!-- アカウント情報 -->
            <div class="author-info">
                <?php echo get_avatar(get_the_author_meta('ID'), 15, '', '', array('class' => 'author-avatar')); ?>
                <span class="author-name"><?php the_author(); ?></span>
            </div>

            <!-- イベント詳細テキスト -->
            <div class="content-box">
                <div class="content-wrapper">
                    <?php the_content(); ?>
                </div>
            </div>

            <!-- 開催情報 -->
            <div class="event-info-box">
                <h3 class="event-info-title">開催情報</h3>
                <div class="event-details">
                    <div class="event-detail-item">
                        <p class="event-detail-label">
                            <i class="fas fa-calendar"></i>開催日時
                        </p>
                        <p class="event-detail-value"><?php echo esc_html(date_i18n('Y年n月j日 H:i', strtotime($event_date))); ?></p>
                    </div>

                    <div class="event-detail-item">
                        <p class="event-detail-label">
                            <i class="fas fa-map-marker-alt"></i>開催形式
                        </p>
                        <p class="event-detail-value"><?php echo $event_is_online == '1' ? 'オンライン' : 'オフライン'; ?></p>
                    </div>

                    <?php if (!$event_is_online || ($event_is_online == '0' && !empty($event_location))) : ?>
                    <div class="event-detail-item">
                        <p class="event-detail-label">
                            <i class="fas fa-location-dot"></i>開催場所
                        </p>
                        <p class="event-detail-value"><?php echo esc_html($event_location); ?></p>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- いいねボタンセクション -->
                <div class="like-button-section">
                    <button class="like-button <?php echo user_liked_post(get_the_ID()) ? 'active' : ''; ?>" data-post-id="<?php echo get_the_ID(); ?>">
                        <i class="<?php echo user_liked_post(get_the_ID()) ? 'fas' : 'far'; ?> fa-heart"></i>
                        <span class="like-count"><?php echo get_post_likes(get_the_ID()); ?></span>
                    </button>
                </div>

                <!-- SNSシェアセクション -->
                <div class="social-share-section">
                    <div class="social-share-line"></div>
                    <div class="social-share-icons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="social-icon x-icon"><i class="fas fa-times"></i></a>
                        <a href="https://www.threads.net/" target="_blank" class="social-icon threads-icon"><i class="fas fa-at"></i></a>
                        <a href="#" onclick="navigator.clipboard.writeText('<?php echo esc_url(get_permalink()); ?>');alert('URLをコピーしました');return false;" class="social-icon"><i class="fas fa-share-alt"></i></a>
                    </div>
                    <div class="social-share-line"></div>
                </div>

                <!-- 編集・削除ボタンセクション（投稿者本人のみ表示） -->
                <?php if (is_user_logged_in() && get_current_user_id() === get_the_author_meta('ID')) : ?>
                <div class="post-edit-delete-section">
                    <a href="<?php echo esc_url(home_url('/new-post?post_id=' . get_the_ID())); ?>" class="edit-button">
                        <i class="fas fa-edit"></i> 編集
                    </a>
                    <?php
                    $delete_url = add_query_arg(
                        array(
                            'action' => 'delete_post',
                            'post_id' => get_the_ID(),
                            'nonce' => wp_create_nonce('delete_post_' . get_the_ID())
                        ),
                        admin_url('admin-post.php')
                    );
                    ?>
                    <a href="<?php echo esc_url($delete_url); ?>" class="delete-button" onclick="return confirm('この投稿を削除してもよろしいですか？');">
                        <i class="fas fa-trash"></i> 削除
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </article>
    </div>
    <div class="right-box">
        <div class="google-adsense-box">
            <!-- ここにコンテンツを追加 -->
        </div>

        <!-- カテゴリーセクション -->
        <div class="categories-sidebar" style="margin-top: 30px;">
            <h3 class="categories-title">Categories</h3>
            <ul class="categories-list">
                <?php
                // データベースから実際のカテゴリーを取得
                $categories = get_terms(array(
                    'taxonomy' => 'recruitment_category',
                    'hide_empty' => false, // 投稿がないカテゴリーも表示
                    'orderby' => 'name', // 名前順で並び替え
                    'order' => 'ASC'
                ));

                if (!empty($categories) && !is_wp_error($categories)) :
                    foreach ($categories as $category) :
                        // カテゴリーのリンクを生成
                        $category_link = add_query_arg(array(
                            'category' => $category->term_id
                        ), home_url('/recruitment'));
                ?>
                    <li class="category-item">
                        <a href="<?php echo esc_url($category_link); ?>" class="category-link">
                            <?php echo esc_html($category->name); ?>
                        </a>
                    </li>
                <?php
                    endforeach;
                else :
                    // カテゴリーが存在しない場合のメッセージ
                    echo '<li class="no-categories">カテゴリーがありません</li>';
                endif;
                ?>
            </ul>
        </div>

        <!-- 応援ボタンセクション -->
        <div class="support-button-section">
            <button class="support-button">
                応援する <i class="fas fa-coffee"></i>
            </button>
        </div>
    </div>
</section>

<style>
.categories-sidebar {
    background-color: #ffffff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.categories-title {
    font-size: 1.2rem;
    font-weight: bold;
    margin-bottom: 15px;
    color: #333;
}

.categories-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.category-item {
    margin-bottom: 10px;
}

.category-link {
    display: block;
    padding: 8px 12px;
    color: #666;
    text-decoration: none;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.category-link:hover {
    background-color: #f5f5f5;
    color: #333;
    transform: translateX(5px);
}

.no-categories {
    color: #999;
    font-style: italic;
}
</style>

<?php
endwhile;
get_footer();
?>