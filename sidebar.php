<?php
/**
 * sidebar.php - サイドバーテンプレート
 */

// サイドバーが登録されていない場合は終了
if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside id="secondary" class="widget-area">
    <div class="sidebar-inner">
        <?php dynamic_sidebar('sidebar-1'); ?>
        
        <?php
        // イベントアーカイブページやイベント詳細ページの場合、追加のウィジェットを表示
        if (is_post_type_archive('event') || is_singular('event') || is_tax('event_category')) :
        ?>
            <div class="widget event-categories-widget">
                <h2 class="widget-title">イベントカテゴリー</h2>
                <ul class="event-categories-list">
                    <?php
                    $categories = get_terms(array(
                        'taxonomy' => 'event_category',
                        'hide_empty' => true,
                    ));
                    
                    if (!empty($categories) && !is_wp_error($categories)) :
                        foreach ($categories as $category) :
                            ?>
                            <li class="event-category-item">
                                <a href="<?php echo esc_url(get_term_link($category)); ?>" class="event-category-link">
                                    <i class="fas fa-<?php echo esc_attr(get_category_icon($category->slug)); ?>"></i>
                                    <?php echo esc_html($category->name); ?>
                                    <span class="count">(<?php echo esc_html($category->count); ?>)</span>
                                </a>
                            </li>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </ul>
            </div>
            
            <div class="widget popular-events-widget">
                <h2 class="widget-title">人気のイベント</h2>
                <ul class="popular-events-list">
                    <?php
                    $popular_args = array(
                        'post_type' => 'event',
                        'posts_per_page' => 5,
                        'meta_key' => 'post_views',
                        'orderby' => 'meta_value_num',
                        'order' => 'DESC',
                    );
                    
                    $popular_events = new WP_Query($popular_args);
                    
                    if ($popular_events->have_posts()) :
                        while ($popular_events->have_posts()) : $popular_events->the_post();
                            ?>
                            <li class="popular-event-item">
                                <a href="<?php the_permalink(); ?>" class="popular-event-link">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="popular-event-thumbnail">
                                            <?php the_post_thumbnail('thumbnail'); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="popular-event-content">
                                        <h3 class="popular-event-title"><?php the_title(); ?></h3>
                                        <div class="popular-event-meta">
                                            <span class="event-date">
                                                <i class="fas fa-calendar"></i>
                                                <?php echo esc_html(get_event_date()); ?>
                                            </span>
                                            <span class="event-views">
                                                <i class="fas fa-eye"></i>
                                                <?php echo get_post_views(get_the_ID()); ?>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        echo '<li class="no-events">現在開催予定のイベントはありません。</li>';
                    endif;
                    ?>
                </ul>
            </div>
            
            <div class="widget upcoming-events-widget">
                <h2 class="widget-title">開催予定のイベント</h2>
                <ul class="upcoming-events-list">
                    <?php
                    $upcoming_args = array(
                        'post_type' => 'event',
                        'posts_per_page' => 5,
                        'meta_key' => 'event_date',
                        'orderby' => 'meta_value',
                        'order' => 'ASC',
                        'meta_query' => array(
                            array(
                                'key' => 'event_date',
                                'value' => date('Y-m-d'),
                                'compare' => '>=',
                                'type' => 'DATE'
                            )
                        )
                    );
                    
                    $upcoming_events = new WP_Query($upcoming_args);
                    
                    if ($upcoming_events->have_posts()) :
                        while ($upcoming_events->have_posts()) : $upcoming_events->the_post();
                            ?>
                            <li class="upcoming-event-item">
                                <a href="<?php the_permalink(); ?>" class="upcoming-event-link">
                                    <div class="upcoming-event-content">
                                        <h3 class="upcoming-event-title"><?php the_title(); ?></h3>
                                        <div class="upcoming-event-meta">
                                            <span class="event-date">
                                                <i class="fas fa-calendar"></i>
                                                <?php echo esc_html(get_event_date()); ?>
                                            </span>
                                            <span class="event-location">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <?php echo esc_html(get_event_location()); ?>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        echo '<li class="no-events">現在開催予定のイベントはありません。</li>';
                    endif;
                    ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php
        // ユーザープロフィールページの場合、ユーザー関連のウィジェットを表示
        if (is_author()) :
            $author = get_user_by('slug', get_query_var('author_name'));
            if ($author) :
                $recent_activities = get_user_recent_activities($author->ID);
                if ($recent_activities) :
                ?>
                <div class="widget user-activities-widget">
                    <h2 class="widget-title"><?php echo esc_html($author->display_name); ?>さんの最近の活動</h2>
                    <ul class="user-activities-list">
                        <?php foreach ($recent_activities as $activity) : ?>
                            <li class="activity-item">
                                <span class="activity-icon">
                                    <i class="fas fa-<?php echo esc_attr($activity['icon']); ?>"></i>
                                </span>
                                <div class="activity-content">
                                    <div class="activity-description">
                                        <?php echo wp_kses_post($activity['description']); ?>
                                    </div>
                                    <span class="activity-date">
                                        <?php echo esc_html($activity['date']); ?>
                                    </span>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</aside>