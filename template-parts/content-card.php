<?php
/**
 * イベントカードのテンプレート
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

<style>
* {
    box-sizing: border-box;
}

.event-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    margin-bottom: 1.5rem;
    max-width: 345px;
    height: 335px;
}

.event-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
}

.event-card-link {
    display: block;
    text-decoration: none;
    color: inherit;
    height: 100%;
}

.event-card-link:hover {
    text-decoration: none;
    color: inherit;
}

.event-card-inner {
    display: flex;
    flex-direction: column;
    height: 100%;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 6px 6px 12px #d1d9e6, -6px -6px 12px #ffffff;
    background-color: #ffffff;
    padding: 0;
}

.event-box {
    background-image: url('<?php echo get_template_directory_uri(); ?>/images/Rectangle1.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
    height: 190px;
    width: 100%;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}

.event-title {
    font-size: 1.25rem;
    font-weight: bold;
    color: #333;
    margin: 0;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    padding: 0 1.5rem;
    text-align: center;
    width: 100%;
}

.event-stats {
    display: flex;
    gap: 1rem;
    font-size: 0.875rem;
    color: #666;
    position: absolute;
    bottom: 1rem;
    right: 1rem;
}

.event-views, .event-likes {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.event-card-bottom {
    background-color: #ffffff;
    padding: 1.5rem;
    height: 145px;
}

.event-info {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    overflow: hidden;
}

.event-date, .event-location {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #4a5568;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.event-location.online {
    color: #2563eb;
}

.event-location.offline {
    color: #059669;
}

@media (max-width: 768px) {
    .event-card {
        max-width: 100%;
        height: 335px;
        margin: 0 auto 1.5rem;
    }
}

@media (max-width: 480px) {
    .event-card {
        height: auto;
    }
    
    .event-card-bottom {
        height: auto;
        min-height: 120px;
    }
}
</style> 