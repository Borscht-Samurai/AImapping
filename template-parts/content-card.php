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
                <div class="event-meta">
                    <?php
                    $categories = get_the_terms(get_the_ID(), 'event_category');
                    if ($categories && !is_wp_error($categories)) :
                        foreach ($categories as $category) :
                            ?>
                            <span class="event-category">
                                <i class="fas fa-tag"></i>
                                <?php echo esc_html($category->name); ?>
                            </span>
                            <?php
                        endforeach;
                    endif;
                    ?>
                    <span class="event-date">
                        <i class="fas fa-calendar"></i>
                        <?php echo esc_html(get_event_date()); ?>
                    </span>
                    <span class="event-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <?php echo esc_html(get_event_location()); ?>
                    </span>
                </div>

                <h2 class="event-title">
                    <?php the_title(); ?>
                </h2>

                <div class="event-excerpt">
                    <?php the_excerpt(); ?>
                </div>
            </div>
        </div>
    </a>
</article>

<style>
.event-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
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
}

.event-thumbnail img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.event-content {
    padding: 1.5rem;
}

.event-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1rem;
    font-size: 0.875rem;
    color: #666;
}

.event-category, .event-date, .event-location {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.event-title {
    font-size: 1.25rem;
    font-weight: bold;
    margin: 0.5rem 0;
    color: #333;
}

.event-excerpt {
    font-size: 0.875rem;
    color: #666;
    margin-top: 0.5rem;
}
</style> 