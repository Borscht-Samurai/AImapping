<?php
// archive-recruitment.php - 募集一覧ページテンプレート
get_header();
?>

<main class="site-main">
    <div class="container mx-auto py-8" style="margin: 0 50px;">
        <div class="archive-header mb-8">
            <h1 class="text-3xl font-bold mb-4">Events</h1>
            <div class="archive-description">
                <p class="text-gray-600">AIを活用するクリエイター同士が集まる募集を探すことができます。</p>
            </div>
        </div>

        <!-- 検索フィルター -->
        <div class="archive-filters mb-8">
            <form class="filter-form bg-white rounded-lg shadow-neumorphism p-6" method="get" action="<?php echo esc_url(home_url('/recruitment/')); ?>">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="filter-group">
                        <label for="category" class="block text-gray-700 font-medium mb-2">カテゴリー：</label>
                        <select name="category" id="category" class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary">
                            <option value="0">すべてのカテゴリー</option>
                            <?php
                            $categories = get_recruitment_categories();
                            $selected_category = isset($_GET['category']) ? $_GET['category'] : 0;
                            
                            // すべてのカテゴリーを表示
                            foreach ($categories as $slug => $name) {
                                $term = get_term_by('slug', $slug, 'recruitment_category');
                                
                                // 存在しないカテゴリーの場合は新規作成
                                if (!$term) {
                                    $term_info = wp_insert_term($name, 'recruitment_category', array('slug' => $slug));
                                    if (!is_wp_error($term_info)) {
                                        $term_id = $term_info['term_id'];
                                        $selected = selected($selected_category, $term_id, false);
                                        echo '<option value="' . esc_attr($term_id) . '"' . $selected . '>' . esc_html($name) . '</option>';
                                    }
                                } else {
                                    $selected = selected($selected_category, $term->term_id, false);
                                    echo '<option value="' . esc_attr($term->term_id) . '"' . $selected . '>' . esc_html($name) . '</option>';
                                }
                            }
                            ?>
                        </select>
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
            <!-- 募集一覧グリッド - style.cssで統一されたクラス使用 -->
            <div class="events-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/content', 'card'); ?>
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

<?php get_footer(); ?>