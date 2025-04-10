<?php
get_header();

// メタ情報の取得
while (have_posts()) :
    the_post();
    $deadline = get_post_meta(get_the_ID(), 'recruitment_deadline', true);
    $event_date = get_post_meta(get_the_ID(), 'recruitment_event_date', true);
    $location_type = get_post_meta(get_the_ID(), 'recruitment_location_type', true);
    $location = get_post_meta(get_the_ID(), 'recruitment_location', true);
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
                            <i class="fas fa-clock"></i>募集期限
                        </p>
                        <p class="event-detail-value"><?php echo esc_html(date_i18n('Y年n月j日', strtotime($deadline))); ?></p>
                    </div>

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
                        <p class="event-detail-value"><?php echo esc_html(ucfirst($location_type)); ?></p>
                    </div>

                    <?php if ($location) : ?>
                    <div class="event-detail-item">
                        <p class="event-detail-label">
                            <i class="fas fa-location-dot"></i>開催場所
                        </p>
                        <p class="event-detail-value"><?php echo esc_html($location); ?></p>
                    </div>
                    <?php endif; ?>

                    <!-- 参加ボタン -->
                    <div class="join-button-container">
                        <button class="join-button">
                            参加を申し込む
                        </button>
                    </div>
                </div>
            </div>
        </article>
    </div>
    <div class="right-box">
        <!-- 右側のボックスコンテンツ -->
    </div>
</section>

<?php
endwhile;
get_footer();
?>