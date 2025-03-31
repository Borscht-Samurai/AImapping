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
                    <?php
                    // イベント日付を取得してフォーマット
                    $event_date = get_post_meta(get_the_ID(), 'event_date', true);
                    if ($event_date) {
                        $date_obj = new DateTime($event_date);
                        $month = $date_obj->format('n'); // 月（先頭のゼロなし）
                        $day = $date_obj->format('j'); // 日（先頭のゼロなし）
                    }
                    ?>
                    <div class="event-date-container">
                        <div class="event-date-display">
                            <span class="event-month"><?php echo isset($month) ? esc_html($month . '月') : ''; ?></span>
                            <span class="event-day"><?php echo isset($day) ? esc_html($day) : ''; ?></span>
                        </div>
                        <div class="event-details">
                            <?php
                            $is_online = get_post_meta(get_the_ID(), 'event_is_online', true);
                            $location_class = $is_online ? 'online' : 'offline';
                            $location_icon = $is_online ? 'video' : 'map-marker-alt';
                            ?>
                            <span class="event-location <?php echo esc_attr($location_class); ?>">
                                <i class="fas fa-<?php echo esc_attr($location_icon); ?>"></i>
                                <?php echo esc_html(get_event_location()); ?>
                            </span>
                            
                            <div class="event-excerpt">
                                <?php 
                                // 投稿の抜粋を取得
                                $excerpt = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 30);
                                echo esc_html($excerpt);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</article>