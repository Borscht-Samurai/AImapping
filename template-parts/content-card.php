<?php
/**
 * イベントカードのテンプレート
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('event-card'); ?>>
    <div class="event-card-inner">
        <?php if (has_post_thumbnail()) : ?>
            <div class="event-thumbnail">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('medium'); ?>
                </a>
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
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>

            <div class="event-excerpt">
                <?php the_excerpt(); ?>
            </div>

            <div class="event-footer">
                <div class="event-author">
                    <?php echo get_avatar(get_the_author_meta('ID'), 32); ?>
                    <span class="author-name"><?php the_author(); ?></span>
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
    </div>
</article> 