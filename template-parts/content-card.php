<?php
/**
 * イベントカードのテンプレート
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('event-card'); ?>>
    <a href="<?php the_permalink(); ?>" class="event-card-link">
        <div class="event-card-inner">
            <?php if (has_post_thumbnail()) : ?>
                <div class="event-thumbnail">
                    <?php the_post_thumbnail('medium'); ?>
                </div>
            <?php endif; ?>

            <div class="event-content">
                <h2 class="event-title">
                    <?php the_title(); ?>
                </h2>

                <div class="event-meta">
                    <?php
                    // カテゴリー表示
                    $categories = get_the_terms(get_the_ID(), 'recruitment_category');
                    if ($categories && !is_wp_error($categories)) :
                        foreach ($categories as $category) :
                            $icon = get_category_icon($category->slug);
                            ?>
                            <span class="event-category">
                                <i class="fas fa-<?php echo esc_attr($icon); ?>"></i>
                                <?php echo esc_html($category->name); ?>
                            </span>
                            <?php
                        endforeach;
                    else:
                        ?>
                        <span class="event-category">
                            <i class="fas fa-calendar-alt"></i>
                            その他
                        </span>
                        <?php
                    endif;
                    ?>
                </div>

                <div class="event-details">
                    <div class="event-info">
                        <span class="event-date">
                            <i class="fas fa-calendar-alt"></i>
                            <?php echo esc_html(get_event_date()); ?>
                        </span>
                        <?php
                        $is_online = get_post_meta(get_the_ID(), 'event_is_online', true);
                        $location_class = $is_online ? 'online' : 'offline';
                        $location_icon = $is_online ? 'video' : 'map-marker-alt';
                        ?>
                        <span class="event-location <?php echo esc_attr($location_class); ?>">
                            <i class="fas fa-<?php echo esc_attr($location_icon); ?>"></i>
                            <?php echo esc_html(get_event_location()); ?>
                        </span>
                    </div>
                </div>

                <div class="event-excerpt">
                    <?php the_excerpt(); ?>
                </div>

                <div class="event-stats">
                    <span class="event-views">
                        <i class="fas fa-eye"></i>
                        <?php echo get_post_views(get_the_ID()); ?>
                    </span>
                    <span class="event-likes">
                        <i class="fas fa-heart"></i>
                        <?php echo get_post_likes(get_the_ID()); ?>
                    </span>
                </div>
            </div>
        </div>
    </a>
</article>

<style>
.event-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    margin-bottom: 1.5rem;
}

.event-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
}

.event-card-link {
    display: block;
    text-decoration: none;
    color: inherit;
}

.event-card-link:hover {
    text-decoration: none;
    color: inherit;
}

.event-card-inner {
    height: 100%;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 6px 6px 12px #d1d9e6, -6px -6px 12px #ffffff;
    padding: 1.5rem;
}

.event-thumbnail img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
}

.event-content {
    padding: 1rem 0;
}

.event-title {
    font-size: 1.25rem;
    font-weight: bold;
    margin-bottom: 1rem;
    color: #333;
}

.event-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.event-category {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    background: #f0f4f8;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    color: #4a5568;
}

.event-details {
    margin: 1rem 0;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 8px;
}

.event-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.event-date, .event-location {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #4a5568;
}

.event-location.online {
    color: #2563eb;
}

.event-location.offline {
    color: #059669;
}

.event-excerpt {
    font-size: 0.875rem;
    color: #666;
    margin: 1rem 0;
    line-height: 1.5;
}

.event-stats {
    display: flex;
    gap: 1rem;
    font-size: 0.875rem;
    color: #666;
}

.event-views, .event-likes {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
</style> 