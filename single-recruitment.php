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
    <div class="gradient-box" style="height: 365px; display: flex; justify-content: center; align-items: center;">
        <div style="width: 100%; max-width: 1100px; padding: 0 20px; text-align: center;">
            <!-- タイトル -->
            <h1 class="text-5xl font-bold text-white drop-shadow-lg"><?php the_title(); ?></h1>
        </div>
    </div>
</section>

<article class="container mx-auto px-4 py-8" style="position: relative; z-index: 10; margin:100px 70px;">
    <!-- タイトル -->
    <h1 class="text-5xl font-bold mb-8"><?php the_title(); ?></h1>

    <!-- アカウント情報 -->
    <div class="flex items-center gap-4 text-gray-600 mb-8">
        <?php echo get_avatar(get_the_author_meta('ID'), 40, '', '', array('class' => 'rounded-full')); ?>
        <span class="text-sm"><?php the_author(); ?></span>
    </div>

    <!-- イベント詳細テキスト -->
    <div class="bg-white rounded-lg shadow-neumorphism p-6 mb-8">
        <div class="prose max-w-none">
            <?php the_content(); ?>
        </div>
    </div>

    <!-- 開催情報 -->
    <div class="bg-white rounded-lg shadow-neumorphism p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">開催情報</h2>
        <div class="space-y-4">
            <div>
                <h3 class="font-semibold text-gray-600">
                    <i class="fas fa-clock mr-2"></i>募集期限
                </h3>
                <p><?php echo esc_html(date_i18n('Y年n月j日', strtotime($deadline))); ?></p>
            </div>

            <div>
                <h3 class="font-semibold text-gray-600">
                    <i class="fas fa-calendar mr-2"></i>開催日時
                </h3>
                <p><?php echo esc_html(date_i18n('Y年n月j日 H:i', strtotime($event_date))); ?></p>
            </div>

            <div>
                <h3 class="font-semibold text-gray-600">
                    <i class="fas fa-map-marker-alt mr-2"></i>開催形式
                </h3>
                <p><?php echo esc_html(ucfirst($location_type)); ?></p>
            </div>

            <?php if ($location) : ?>
            <div>
                <h3 class="font-semibold text-gray-600">
                    <i class="fas fa-location-dot mr-2"></i>開催場所
                </h3>
                <p><?php echo esc_html($location); ?></p>
            </div>
            <?php endif; ?>

            <!-- 参加ボタン -->
            <div class="mt-6">
                <button class="w-full bg-primary text-white py-3 px-6 rounded-full hover:bg-primary-dark transition-colors">
                    参加を申し込む
                </button>
            </div>
        </div>
    </div>

    <!-- コメントセクション -->
    <div class="bg-white rounded-lg shadow-neumorphism p-6">
        <?php
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        ?>
    </div>
</article>

<?php
endwhile;
get_footer();
?>