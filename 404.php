<?php
/**
 * 404.php - 404エラーページテンプレート
 */

get_header();
?>

<main class="site-main">
    <div class="container">
        <div class="error-404">
            <div class="error-header">
                <h1 class="error-title">404</h1>
                <p class="error-subtitle">ページが見つかりませんでした</p>
            </div>
            
            <div class="error-content">
                <p>お探しのページは移動または削除された可能性があります。</p>
                <div class="error-actions">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                        <i class="fas fa-home"></i> トップページへ戻る
                    </a>
                    
                    <div class="error-search">
                        <p>または、キーワードで検索してみてください：</p>
                        <?php get_search_form(); ?>
                    </div>
                </div>
            </div>
            
            <div class="suggested-content">
                <h2>人気のイベントカテゴリー</h2>
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
                                <p><?php echo esc_html($category->description); ?></p>
                            </a>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </div>
                
                <div class="recent-events">
                    <h2>最新のイベント</h2>
                    <div class="events-grid">
                        <?php
                        $args = array(
                            'post_type' => 'event',
                            'posts_per_page' => 3,
                            'orderby' => 'date',
                            'order' => 'DESC'
                        );
                        $recent_events = new WP_Query($args);

                        if ($recent_events->have_posts()) :
                            while ($recent_events->have_posts()) : $recent_events->the_post();
                                get_template_part('template-parts/content', 'card');
                            endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<p class="no-events">現在開催予定のイベントはありません。</p>';
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>