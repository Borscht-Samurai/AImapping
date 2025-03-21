<?php get_header(); ?>

<main class="site-main">
    <div class="container mx-auto px-4 py-8">
        <div class="archive-header mb-8">
            <h1 class="text-3xl font-bold mb-4">募集一覧</h1>
            <div class="archive-description">
                <p class="text-gray-600">AIを活用するクリエイター同士が集まる募集を探すことができます。</p>
            </div>
        </div>

        <!-- 検索フィルター -->
        <div class="archive-filters mb-8">
            <form class="filter-form bg-white rounded-lg shadow-neumorphism p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="filter-group">
                        <label for="category" class="block text-gray-700 font-medium mb-2">カテゴリー：</label>
                        <?php
                        wp_dropdown_categories(array(
                            'taxonomy' => 'recruitment_category',
                            'name' => 'category',
                            'selected' => get_query_var('recruitment_category'),
                            'show_option_all' => 'すべてのカテゴリー',
                            'hide_empty' => true,
                            'class' => 'w-full px-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary'
                        ));
                        ?>
                    </div>

                    <div class="filter-group">
                        <label for="orderby" class="block text-gray-700 font-medium mb-2">並び順：</label>
                        <select name="orderby" id="orderby" class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary">
                            <option value="date" <?php selected(get_query_var('orderby'), 'date'); ?>>新着順</option>
                            <option value="views" <?php selected(get_query_var('orderby'), 'views'); ?>>閲覧数順</option>
                            <option value="likes" <?php selected(get_query_var('orderby'), 'likes'); ?>>いいね数順</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="location" class="block text-gray-700 font-medium mb-2">開催形式：</label>
                        <select name="location" id="location" class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary">
                            <option value="">すべて</option>
                            <option value="online" <?php selected(get_query_var('location'), 'online'); ?>>オンライン</option>
                            <option value="offline" <?php selected(get_query_var('location'), 'offline'); ?>>オフライン</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <button type="submit" class="inline-block px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors shadow-neumorphism">
                        <i class="fas fa-search mr-2"></i>検索する
                    </button>
                </div>
            </form>
        </div>

        <!-- 募集一覧 -->
        <?php if (have_posts()) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php while (have_posts()) : the_post(); ?>
                    <article class="bg-white rounded-lg shadow-neumorphism overflow-hidden">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="aspect-w-16 aspect-h-9">
                                <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover')); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="p-6">
                            <!-- カテゴリー表示 -->
                            <div class="mb-4">
                                <?php
                                $categories = get_the_terms(get_the_ID(), 'recruitment_category');
                                if ($categories && !is_wp_error($categories)) :
                                    foreach ($categories as $category) :
                                        $icon = get_category_icon($category->slug);
                                ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-700 mr-2">
                                            <i class="fas fa-<?php echo esc_attr($icon); ?> mr-1"></i>
                                            <?php echo esc_html($category->name); ?>
                                        </span>
                                <?php
                                    endforeach;
                                endif;
                                ?>
                            </div>

                            <h2 class="text-xl font-bold mb-4">
                                <a href="<?php the_permalink(); ?>" class="hover:text-primary">
                                    <?php the_title(); ?>
                                </a>
                            </h2>

                            <div class="text-sm text-gray-600 mb-4">
                                <?php
                                $event_date = get_post_meta(get_the_ID(), 'event_date', true);
                                $is_online = get_post_meta(get_the_ID(), 'event_is_online', true);
                                $location = get_post_meta(get_the_ID(), 'event_location', true);
                                ?>
                                <p class="mb-2">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    開催日時: <?php echo esc_html(date_i18n('Y年n月j日 H:i', strtotime($event_date))); ?>
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-<?php echo $is_online === '1' ? 'video' : 'map-marker-alt'; ?> mr-2"></i>
                                    開催形式: <?php echo $is_online === '1' ? 'オンライン' : 'オフライン'; ?>
                                </p>
                                <?php if (!$is_online && $location) : ?>
                                    <p>
                                        <i class="fas fa-map-pin mr-2"></i>
                                        開催場所: <?php echo esc_html($location); ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="mb-4 text-gray-600">
                                <?php the_excerpt(); ?>
                            </div>

                            <div class="flex items-center justify-between mt-4">
                                <div class="flex items-center text-sm text-gray-500">
                                    <span class="mr-4">
                                        <i class="fas fa-eye mr-1"></i>
                                        <?php echo get_post_views(get_the_ID()); ?>
                                    </span>
                                    <span>
                                        <i class="fas fa-heart mr-1"></i>
                                        <?php echo get_post_likes(get_the_ID()); ?>
                                    </span>
                                </div>
                                <a href="<?php the_permalink(); ?>" class="inline-block px-4 py-2 bg-primary text-white rounded-full hover:bg-primary-dark transition-colors">
                                    詳細を見る
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <!-- ページネーション -->
            <div class="mt-8">
                <?php
                the_posts_pagination(array(
                    'prev_text' => '<i class="fas fa-chevron-left mr-1"></i>前へ',
                    'next_text' => '次へ<i class="fas fa-chevron-right ml-1"></i>',
                    'mid_size' => 2,
                    'class' => 'pagination-neumorphism',
                ));
                ?>
            </div>

        <?php else : ?>
            <div class="text-center py-12 bg-white rounded-lg shadow-neumorphism">
                <p class="text-gray-600 mb-4">該当する募集が見つかりませんでした。</p>
                <a href="<?php echo esc_url(home_url('/recruitment')); ?>" class="inline-block px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                    すべての募集を見る
                </a>
            </div>
        <?php endif; ?>
    </div>
</main>

<style>
/* ニューモーフィズムスタイル */
.shadow-neumorphism {
    box-shadow: 6px 6px 12px #d1d9e6, -6px -6px 12px #ffffff;
}

/* ページネーションのニューモーフィズム */
.pagination-neumorphism .page-numbers {
    display: inline-block;
    padding: 8px 16px;
    margin: 0 4px;
    border-radius: 8px;
    background: #fff;
    box-shadow: 4px 4px 8px #d1d9e6, -4px -4px 8px #ffffff;
    color: #4a5568;
    transition: all 0.3s ease;
}

.pagination-neumorphism .page-numbers.current,
.pagination-neumorphism .page-numbers:hover {
    background: #f0f4f8;
    color: #2d3748;
    box-shadow: inset 4px 4px 8px #d1d9e6, inset -4px -4px 8px #ffffff;
}

/* プライマリーカラーの定義 */
:root {
    --color-primary: #4299e1;
    --color-primary-dark: #3182ce;
}

.bg-primary {
    background-color: var(--color-primary);
}

.hover\:bg-primary-dark:hover {
    background-color: var(--color-primary-dark);
}

.text-primary {
    color: var(--color-primary);
}

.ring-primary {
    --tw-ring-color: var(--color-primary);
}
</style>

<?php get_footer(); ?> 