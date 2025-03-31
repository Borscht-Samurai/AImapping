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
            <!-- フロントページと同じスタイルの募集一覧グリッド -->
            <div class="events-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(345px, 1fr)); gap: 30px; margin-top: 30px;">
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

<style>
/* カラーパレットの定義 */
:root {
    --color-primary: #FF966C;      /* テーマカラー1: FF966C */
    --color-secondary: #A5FDF7;    /* テーマカラー2: A5FDF7 */
    --color-primary-dark: #e87e50; /* 暗めのプライマリカラー */
    --color-background: #FFFFFF;   /* 背景色を白に設定 */
    --color-text: #2D3748;         /* テキストカラー - ダークグレー */
    --shadow-light: #FFFFFF;
    --shadow-dark: #D1D9E6;
}

body {
    background-color: #FFFFFF; /* 背景色を白色に設定 */
}

/* ニューモーフィズムの基本スタイル */
.shadow-neumorphism {
    background: #FFFFFF; /* ニューモーフィズムの背景も白色に変更 */
    box-shadow: 
        8px 8px 16px var(--shadow-dark),
        -8px -8px 16px var(--shadow-light);
    border-radius: 20px;
    transition: all 0.3s ease;
}

.shadow-neumorphism:hover {
    transform: translateY(-2px);
    box-shadow: 
        10px 10px 20px var(--shadow-dark),
        -10px -10px 20px var(--shadow-light);
}

/* フォームコントロールのニューモーフィズム */
.filter-form select,
.filter-form input {
    background: var(--color-background);
    border: none;
    box-shadow: 
        inset 4px 4px 8px var(--shadow-dark),
        inset -4px -4px 8px var(--shadow-light);
    transition: all 0.3s ease;
}

.filter-form select:focus,
.filter-form input:focus {
    box-shadow: 
        inset 6px 6px 12px var(--shadow-dark),
        inset -6px -6px 12px var(--shadow-light);
}

/* ボタンのニューモーフィズム */
.bg-primary {
    background: var(--color-primary);
    box-shadow: 
        6px 6px 12px var(--shadow-dark),
        -6px -6px 12px var(--shadow-light);
    transition: all 0.3s ease;
}

.bg-primary:hover {
    background: var(--color-primary-dark);
    transform: translateY(-2px);
}

/* ページネーションの改善 */
.pagination-neumorphism {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 40px;
}

.pagination-neumorphism .page-numbers {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: var(--color-background);
    box-shadow: 
        6px 6px 12px var(--shadow-dark),
        -6px -6px 12px var(--shadow-light);
    border-radius: 12px;
    transition: all 0.3s ease;
    color: var(--color-text);
    text-decoration: none;
}

.pagination-neumorphism .page-numbers.current,
.pagination-neumorphism .page-numbers:hover {
    background: var(--color-background);
    box-shadow: 
        inset 6px 6px 12px var(--shadow-dark),
        inset -6px -6px 12px var(--shadow-light);
    color: var(--color-primary);
}

/* メディアクエリでモバイル表示を調整 */
@media (max-width: 768px) {
    .events-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>