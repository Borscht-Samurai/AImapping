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
            <form class="filter-form bg-white rounded-lg shadow-neumorphism p-6" method="get" action="<?php echo esc_url(home_url('/recruitment/')); ?>">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="filter-group">
                        <label for="category" class="block text-gray-700 font-medium mb-2">カテゴリー：</label>
                        <select name="category" id="category" class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary">
                            <option value="0">すべてのカテゴリー</option>
                            <?php
                            $categories = get_recruitment_categories();
                            $selected_category = isset($_GET['category']) ? $_GET['category'] : 0;
                            
                            // タームを取得
                            foreach ($categories as $slug => $name) {
                                $term = get_term_by('slug', $slug, 'recruitment_category');
                                if ($term) {
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
            <div class="recruitment-list">
                <?php while (have_posts()) : the_post(); ?>
                    <article class="recruitment-card shadow-neumorphism">
                        <a href="<?php the_permalink(); ?>" class="recruitment-card__link">
                            <div class="recruitment-card__header">
                                <div class="recruitment-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    <?php
                                    $event_date = get_post_meta(get_the_ID(), 'event_date', true);
                                    echo esc_html(date_i18n('Y年n月j日', strtotime($event_date)));
                                    ?>
                                </div>
                                <div class="recruitment-location">
                                    <?php
                                    $is_online = get_post_meta(get_the_ID(), 'event_is_online', true);
                                    $location = get_post_meta(get_the_ID(), 'event_location', true);
                                    if ($is_online === '1') {
                                        echo '<i class="fas fa-video"></i> オンライン';
                                    } else {
                                        echo '<i class="fas fa-map-marker-alt"></i> ';
                                        echo $location ? esc_html($location) : '場所未定';
                                    }
                                    ?>
                                </div>
                            </div>
                            
                            <h2 class="recruitment-card__title">
                                <?php the_title(); ?>
                            </h2>
                            
                            <div class="recruitment-card__content">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <div class="recruitment-card__footer">
                                <div class="author-info">
                                    <?php
                                    $author_id = get_the_author_meta('ID');
                                    $author_avatar = get_avatar_url($author_id, ['size' => 40]);
                                    $author_name = get_the_author_meta('display_name');
                                    ?>
                                    <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>" class="author-avatar">
                                    <span class="author-name"><?php echo esc_html($author_name); ?></span>
                                </div>
                                <div class="post-meta">
                                    <span class="views-count"><i class="fas fa-eye"></i> <?php echo get_post_views(get_the_ID()); ?></span>
                                    <span class="likes-count"><i class="fas fa-heart"></i> <?php echo get_post_likes(get_the_ID()); ?></span>
                                </div>
                            </div>
                        </a>
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
/* カラーパレットの定義 */
:root {
    --color-primary: #6C63FF;      /* 明るい紫色 */
    --color-primary-dark: #5A52D5;
    --color-background: #E6E9EF;   /* 薄いグレー */
    --color-text: #2D3748;         /* ダークグレー */
    --shadow-light: #FFFFFF;
    --shadow-dark: #D1D9E6;
}

body {
    background-color: var(--color-background);
}

/* ニューモーフィズムの基本スタイル */
.shadow-neumorphism {
    background: var(--color-background);
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

/* 新しい募集カードのスタイル */
.recruitment-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    gap: 30px;
    margin-top: 30px;
}

.recruitment-card {
    width: 360px;
    position: relative;
}

.recruitment-card__link {
    display: block;
    padding: 25px;
    text-decoration: none;
    color: inherit;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.recruitment-card:hover {
    transform: translateY(-3px);
}

.recruitment-card__header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 16px;
    font-size: 14px;
    color: var(--color-text);
}

.recruitment-date,
.recruitment-location {
    display: flex;
    align-items: center;
}

.recruitment-date i,
.recruitment-location i {
    margin-right: 6px;
    color: var(--color-primary);
}

.recruitment-card__title {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 16px;
    line-height: 1.4;
    color: var(--color-text);
}

.recruitment-card__link:hover .recruitment-card__title {
    color: var(--color-primary);
}

.recruitment-card__content {
    font-size: 14px;
    color: #4A5568;
    margin-bottom: 20px;
    flex-grow: 1;
    line-height: 1.6;
}

.recruitment-card__footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    padding-top: 20px;
    border-top: 1px solid #EDF2F7;
}

.author-info {
    display: flex;
    align-items: center;
}

.author-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    margin-right: 10px;
}

.author-name {
    font-size: 14px;
    color: var(--color-text);
}

.post-meta {
    display: flex;
    gap: 12px;
    color: #718096;
    font-size: 14px;
}

.views-count i,
.likes-count i {
    color: var(--color-primary);
    margin-right: 4px;
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

/* レスポンシブ調整 */
@media (max-width: 768px) {
    .recruitment-list {
        justify-content: center;
    }
    
    .recruitment-card {
        width: 100%;
        max-width: 360px;
    }
    
    .shadow-neumorphism {
        box-shadow: 
            6px 6px 12px var(--shadow-dark),
            -6px -6px 12px var(--shadow-light);
    }
}
</style>

<?php get_footer(); ?> 