<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <div class="archive-header">
            <h1 class="archive-title">
                <?php
                if (is_post_type_archive('event')) {
                    echo 'イベント一覧';
                } elseif (is_tax('event_category')) {
                    echo single_term_title('', false);
                } else {
                    echo 'アーカイブ';
                }
                ?>
            </h1>
            
            <?php if (is_post_type_archive('event')) : ?>
                <div class="archive-description">
                    <p>AIを活用するクリエイター同士が集まるイベントを探すことができます。</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="archive-filters">
            <form class="filter-form" method="get">
                <div class="filter-group">
                    <label for="category">カテゴリー：</label>
                    <?php
                    wp_dropdown_categories(array(
                        'taxonomy' => 'event_category',
                        'name' => 'category',
                        'selected' => get_query_var('event_category'),
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
                <p>該当するイベントが見つかりませんでした。</p>
                <a href="<?php echo esc_url(home_url('/events')); ?>" class="btn btn-primary">すべてのイベントを見る</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?> 