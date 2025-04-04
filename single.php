<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('event-single'); ?>>
                <div class="event-header">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="event-thumbnail">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

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

                    <h1 class="event-title"><?php the_title(); ?></h1>

                    <div class="event-author">
                        <?php echo get_avatar(get_the_author_meta('ID'), 48); ?>
                        <div class="author-info">
                            <span class="author-name"><?php the_author(); ?></span>
                            <span class="post-date"><?php echo get_the_date(); ?></span>
                        </div>
                    </div>
                </div>

                <div class="event-content">
                    <?php the_content(); ?>
                </div>

                <div class="event-footer">
                    <div class="event-stats">
                        <span class="event-views">
                            <i class="fas fa-eye"></i>
                            <?php echo get_post_views(get_the_ID()); ?> 回の閲覧
                        </span>
                        <button class="like-button" data-post-id="<?php echo get_the_ID(); ?>">
                            <i class="fas fa-heart"></i>
                            <span class="likes-count"><?php echo get_post_likes(get_the_ID()); ?></span>
                        </button>
                    </div>

                    <?php if (is_user_logged_in() && get_current_user_id() === get_the_author_meta('ID')) : ?>
                        <div class="event-actions">
                            <a href="<?php echo esc_url(get_edit_post_link()); ?>" class="btn btn-secondary">
                                <i class="fas fa-edit"></i> 編集
                            </a>
                            <a href="<?php echo esc_url(get_delete_post_link()); ?>" class="btn btn-danger" onclick="return confirm('このイベントを削除してもよろしいですか？');">
                                <i class="fas fa-trash"></i> 削除
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <?php
                // コメントテンプレート
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?> 