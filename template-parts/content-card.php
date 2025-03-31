<?php
/**
 * content-card.php - 募集カードのテンプレート
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('event-card'); ?>>
    <a href="<?php the_permalink(); ?>" class="event-card-link">
        <div class="event-card-inner">
            <div class="event-box">
                <h2 class="event-title">
                    <?php the_title(); ?>
                </h2>
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

            <div class="event-card-bottom">
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
        </div>
    </a>
</article>