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
            </div>
        </article>
    </div>
    <div class="right-box">
        <div class="google-adsense-box">
            <!-- ここにコンテンツを追加 -->
        </div>

        <!-- カテゴリーセクション -->
        <div class="categories-sidebar">
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
    </div>
</section>

<?php
endwhile;
get_footer();
?>