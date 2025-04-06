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
            <!-- タイトルのみを中央に配置 -->
            <h1 class="text-4xl font-bold text-white drop-shadow-lg"><?php the_title(); ?></h1>
        </div>
    </div>
</section>

<article class="container mx-auto px-4 py-8" style="position: relative; z-index: 10;">
    <!-- ヘッダー部分 -->
    <header class="mb-8">
        <!-- アカウント情報 -->
        <div class="flex flex-wrap items-center gap-4 text-gray-600 mb-4">
            <div class="flex items-center">
                <?php echo get_avatar(get_the_author_meta('ID'), 40, '', '', array('class' => 'rounded-full mr-2')); ?>
                <span><?php the_author(); ?></span>
            </div>
            <div>
                <i class="fas fa-clock mr-1"></i>
                <?php echo get_the_date('Y年n月j日'); ?>
            </div>
            <?php
            $categories = get_the_terms(get_the_ID(), 'recruitment_category');
            if ($categories) :
                foreach ($categories as $category) :
            ?>
                <a href="<?php echo get_term_link($category); ?>" class="px-3 py-1 bg-gray-100 rounded-full hover:bg-gray-200 transition-colors">
                    <?php echo esc_html($category->name); ?>
                </a>
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </header>

    <!-- メイン情報 -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- 左カラム：メインコンテンツ -->
        <div class="lg:col-span-2">
            <!-- アイキャッチ画像 -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="mb-8 rounded-lg overflow-hidden shadow-neumorphism">
                    <?php the_post_thumbnail('large', array('class' => 'w-full h-auto')); ?>
                </div>
            <?php endif; ?>

            <!-- 本文 -->
            <div class="bg-white rounded-lg shadow-neumorphism p-6 mb-8">
                <div class="prose max-w-none">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>

        <!-- 右カラム：イベント詳細 -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-neumorphism p-6 sticky top-4">
                <h2 class="text-xl font-bold mb-4">イベント詳細</h2>

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
        </div>
    </div>

    <!-- 投稿者アクション -->
    <?php if (is_user_logged_in() && get_current_user_id() === get_the_author_meta('ID')) : ?>
    <div class="mt-8 bg-white rounded-lg shadow-neumorphism p-6">
        <div class="flex justify-end gap-4">
            <a href="<?php echo esc_url(get_edit_post_link()); ?>" class="inline-flex items-center px-4 py-2 rounded-full border border-gray-300 hover:bg-gray-100 transition-colors">
                <i class="fas fa-edit mr-2"></i> 編集
            </a>
            <a href="<?php echo esc_url(get_delete_post_link()); ?>" class="inline-flex items-center px-4 py-2 rounded-full border border-red-300 text-red-600 hover:bg-red-50 transition-colors" onclick="return confirm('この投稿を削除してもよろしいですか？');">
                <i class="fas fa-trash mr-2"></i> 削除
            </a>
        </div>
    </div>
    <?php endif; ?>

    <!-- コメントセクション -->
    <div class="mt-8 bg-white rounded-lg shadow-neumorphism p-6">
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