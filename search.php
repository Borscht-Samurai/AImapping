<?php
/**
 * search.php - 検索結果ページテンプレート
 */

get_header();
?>

<main class="site-main">
    <div class="container">
        <div class="search-header">
            <h1 class="search-title">
                <?php printf(esc_html__('「%s」の検索結果', 'aimapping'), '<span>' . get_search_query() . '</span>'); ?>
            </h1>
            
            <div class="search-form-container">
                <?php get_search_form(); ?>
            </div>
            
            <div class="search-meta">
                <?php
                global $wp_query;
                $total_results = $wp_query->found_posts;
                ?>
                <p><?php echo sprintf(_n('%s件のイベントが見つかりました', '%s件のイベントが見つかりました', $total_results, 'aimapping'), number_format_i18n($total_results)); ?></p>
            </div>
        </div>
        
        <div class="search-filters">
            <form class="filter-form" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="hidden" name="s" value="<?php echo esc_attr(get_search_query()); ?>">
                
                <div class="filter-group">
                    <label for="post_type">検索対象：</label>
                    <select name="post_type" id="post_type">
                        <option value="any" <?php selected(!isset($_GET['post_type']) || $_GET['post_type'] === 'any'); ?>>すべて</option>
                        <option value="event" <?php selected(isset($_GET['post_type']) && $_GET['post_type'] === 'event'); ?>>イベント</option>
                        <option value="post" <?php selected(isset($_GET['post_type']) && $_GET['post_type'] === 'post'); ?>>ブログ</option>
                        <option value="page" <?php selected(isset($_GET['post_type']) && $_GET['post_type'] === 'page'); ?>>ページ</option>
                    </select>
                </div>
                
                <?php if (!isset($_GET['post_type']) || $_GET['post_type'] === 'event' || $_GET['post_type'] === 'any') : ?>
                    <div class="filter-group">
                        <label for="event_category">イベントカテゴリー：</label>
                        <?php
                        wp_dropdown_categories(array(
                            'taxonomy' => 'event_category',
                            'name' => 'event_category',
                            'selected' => isset($_GET['event_category']) ? (int)$_GET['event_category'] : 0,
                            'show_option_all' => 'すべてのカテゴリー',
                            'hide_empty' => true,
                        ));
                        ?>
                    </div>
                    
                    <div class="filter-group">
                        <label for="event_is_online">開催形式：</label>
                        <select name="event_is_online" id="event_is_online">
                            <option value="" <?php selected(!isset($_GET['event_is_online'])); ?>>すべて</option>
                            <option value="1" <?php selected(isset($_GET['event_is_online']) && $_GET['event_is_online'] === '1'); ?>>オンライン</option>
                            <option value="0" <?php selected(isset($_GET['event_is_online']) && $_GET['event_is_online'] === '0'); ?>>オフライン</option>
                        </select>
                    </div>
                <?php endif; ?>
                
                <div class="filter-group">
                    <label for="orderby">並び順：</label>
                    <select name="orderby" id="orderby">
                        <option value="relevance" <?php selected(!isset($_GET['orderby']) || $_GET['orderby'] === 'relevance'); ?>>関連性順</option>
                        <option value="date" <?php selected(isset($_GET['orderby']) && $_GET['orderby'] === 'date'); ?>>新着順</option>
                        <option value="views" <?php selected(isset($_GET['orderby']) && $_GET['orderby'] === 'views'); ?>>閲覧数順</option>
                        <option value="likes" <?php selected(isset($_GET['orderby']) && $_GET['orderby'] === 'likes'); ?>>いいね数順</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">検索</button>
            </form>
        </div>
        
        <?php if (have_posts()) : ?>
            <div class="search-results">
                <?php
                if (!isset($_GET['post_type']) || $_GET['post_type'] === 'event' || $_GET['post_type'] === 'any') {
                    echo '<div class="events-grid">';
                    
                    // 表示中の投稿数をカウント
                    $displayed_count = 0;
                    
                    while (have_posts()) :
                        the_post();
                        
                        // イベント投稿タイプの場合のみイベントカードを表示
                        if (get_post_type() === 'event') {
                            get_template_part('template-parts/content', 'card');
                            $displayed_count++;
                        }
                    endwhile;
                    
                    echo '</div>';
                    
                    // 一度目のループで表示したイベント以外のコンテンツがあれば別途表示
                    if ($displayed_count < $wp_query->post_count) {
                        echo '<div class="other-results">';
                        echo '<h2>その他の検索結果</h2>';
                        
                        rewind_posts();
                        
                        while (have_posts()) :
                            the_post();
                            
                            if (get_post_type() !== 'event') {
                                ?>
                                <div class="search-item">
                                    <h3 class="search-item-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <div class="search-item-meta">
                                        <span class="post-type"><?php echo get_post_type_object(get_post_type())->labels->singular_name; ?></span>
                                        <span class="post-date"><?php echo get_the_date(); ?></span>
                                    </div>
                                    <div class="search-item-excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                </div>
                                <?php
                            }
                        endwhile;
                        
                        echo '</div>';
                    }
                } else {
                    // イベント以外の投稿タイプの場合、標準の検索結果表示
                    echo '<div class="standard-results">';
                    
                    while (have_posts()) :
                        the_post();
                        ?>
                        <div class="search-item">
                            <h3 class="search-item-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <div class="search-item-meta">
                                <span class="post-type"><?php echo get_post_type_object(get_post_type())->labels->singular_name; ?></span>
                                <span class="post-date"><?php echo get_the_date(); ?></span>
                            </div>
                            <div class="search-item-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    
                    echo '</div>';
                }
                ?>
                
                <?php
                the_posts_pagination(array(
                    'prev_text' => '前へ',
                    'next_text' => '次へ',
                    'mid_size' => 2,
                ));
                ?>
            </div>
        <?php else : ?>
            <div class="no-results">
                <div class="no-results-content">
                    <h2>検索結果が見つかりませんでした</h2>
                    <p>検索条件を変更して、再度お試しください。</p>
                    
                    <div class="search-suggestions">
                        <h3>検索のヒント：</h3>
                        <ul>
                            <li>キーワードに誤字・脱字がないか確認してください。</li>
                            <li>別のキーワードを試してみてください。</li>
                            <li>より一般的なキーワードを使用してみてください。</li>
                            <li>絞り込み条件を減らしてみてください。</li>
                        </ul>
                    </div>
                </div>
                
                <div class="popular-categories">
                    <h3>人気のカテゴリー</h3>
                    <div class="categories-grid">
                        <?php
                        $categories = get_terms(array(
                            'taxonomy' => 'event_category',
                            'hide_empty' => true,
                            'number' => 4
                        ));

                        if (!empty($categories) && !is_wp_error($categories)) :
                            foreach ($categories as $category) :
                                ?>
                                <a href="<?php echo esc_url(get_term_link($category)); ?>" class="category-card">
                                    <div class="category-icon">
                                        <i class="fas fa-<?php echo esc_attr(get_category_icon($category->slug)); ?>"></i>
                                    </div>
                                    <h3><?php echo esc_html($category->name); ?></h3>
                                </a>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>