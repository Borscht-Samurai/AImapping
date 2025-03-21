<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <div class="archive-header">
            <h1 class="archive-title">
                <?php
                if (is_post_type_archive('recruitment')) {
                    echo '募集一覧';
                } elseif (is_tax('recruitment_category')) {
                    echo single_term_title('', false);
                } else {
                    echo 'アーカイブ';
                }
                ?>
            </h1>
            
            <?php if (is_post_type_archive('recruitment')) : ?>
                <div class="archive-description">
                    <p>AIを活用するクリエイター同士が集まる募集を探すことができます。</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="archive-filters">
            <form class="filter-form" method="get">
                <div class="filter-group">
                    <label for="category">カテゴリー：</label>
                    <?php
                    wp_dropdown_categories(array(
                        'taxonomy' => 'recruitment_category',
                        'name' => 'category',
                        'selected' => get_query_var('recruitment_category'),
                        'show_option_all' => 'すべてのカテゴリー',
                        'hide_empty' => true,
                    ));
                    ?>
                </div>

                <div class="filter-group">
                    <label for="orderby">並び順：</label>
                    <select name="orderby" id="orderby">
                        <option value="date" <?php selected(get_query_var('orderby'), 'date'); ?>>新着順</option>
                        <option value="views" <?php selected(get_query_var('orderby'), 'views'); ?>>閲覧数順</option>
                        <option value="likes" <?php selected(get_query_var('orderby'), 'likes'); ?>>いいね数順</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="location">開催形式：</label>
                    <select name="location" id="location">
                        <option value="">すべて</option>
                        <option value="online" <?php selected(get_query_var('location'), 'online'); ?>>オンライン</option>
                        <option value="offline" <?php selected(get_query_var('location'), 'offline'); ?>>オフライン</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">検索</button>
            </form>
        </div>

        <?php if (have_posts()) : ?>
            <div class="events-grid">
                <?php
                while (have_posts()) :
                    the_post();
                    get_template_part('template-parts/content', 'card');
                endwhile;
                ?>
            </div>

            <?php
            the_posts_pagination(array(
                'prev_text' => '前へ',
                'next_text' => '次へ',
                'mid_size' => 2,
            ));
            ?>

        <?php else : ?>
            <div class="no-events">
                <p>該当する募集が見つかりませんでした。</p>
                <a href="<?php echo esc_url(home_url('/recruitment')); ?>" class="btn btn-primary">すべての募集を見る</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?> 