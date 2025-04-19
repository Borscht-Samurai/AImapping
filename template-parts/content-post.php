<?php
/**
 * content-post.php - 投稿詳細のレイアウト
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('event-post'); ?>>
    <div class="post-header">
        <?php if (has_post_thumbnail()) : ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail('full'); ?>
            </div>
        <?php endif; ?>

        <div class="post-meta">
            <?php
            $categories = get_the_terms(get_the_ID(), 'event_category');
            if ($categories && !is_wp_error($categories)) :
                foreach ($categories as $category) :
                    ?>
                    <span class="post-category">
                        <i class="fas fa-tag"></i>
                        <?php echo esc_html($category->name); ?>
                    </span>
                    <?php
                endforeach;
            endif;
            ?>

            <?php if (get_post_type() === 'event') : ?>
                <span class="post-date">
                    <i class="fas fa-calendar"></i>
                    <?php echo esc_html(get_event_date()); ?>
                </span>
                <span class="post-location">
                    <i class="fas fa-map-marker-alt"></i>
                    <?php echo esc_html(get_event_location()); ?>
                </span>
            <?php else : ?>
                <span class="post-date">
                    <i class="fas fa-clock"></i>
                    <?php echo get_the_date(); ?>
                </span>
            <?php endif; ?>
        </div>

        <h1 class="post-title"><?php the_title(); ?></h1>

        <div class="post-author">
            <?php echo get_avatar(get_the_author_meta('ID'), 48); ?>
            <div class="author-info">
                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="author-name"><?php the_author(); ?></a>
                <span class="post-published"><?php echo get_the_date(); ?></span>
            </div>
        </div>
    </div>

    <div class="post-content">
        <?php the_content(); ?>
    </div>

    <div class="post-footer">
        <div class="post-stats">
            <span class="post-views">
                <i class="fas fa-eye"></i>
                <?php echo get_post_views(get_the_ID()); ?> 回の閲覧
            </span>
            <button class="like-button <?php echo user_liked_post(get_the_ID()) ? 'active' : ''; ?>" data-post-id="<?php echo get_the_ID(); ?>">
                <i class="<?php echo user_liked_post(get_the_ID()) ? 'fas' : 'far'; ?> fa-heart"></i>
                <span class="like-count"><?php echo get_post_likes(get_the_ID()); ?></span>
            </button>
        </div>

        <?php if (is_user_logged_in() && get_current_user_id() === get_the_author_meta('ID')) : ?>
            <div class="post-actions">
                <a href="<?php echo esc_url(home_url('/edit-post?post_id=' . get_the_ID())); ?>" class="btn btn-secondary">
                    <i class="fas fa-edit"></i> 編集
                </a>
                <?php
                $delete_url = add_query_arg(
                    array(
                        'action' => 'delete_post',
                        'post_id' => get_the_ID(),
                        'nonce' => wp_create_nonce('delete_post_' . get_the_ID())
                    ),
                    admin_url('admin-post.php')
                );
                ?>
                <a href="<?php echo esc_url($delete_url); ?>" class="btn btn-danger" onclick="return confirm('このイベントを削除してもよろしいですか？');">
                    <i class="fas fa-trash"></i> 削除
                </a>
            </div>
        <?php endif; ?>

        <?php
        // イベントの場合、参加ボタンを表示
        if (get_post_type() === 'event' && get_post_status() === 'publish') :
            $event_date = get_post_meta(get_the_ID(), 'event_date', true);
            $is_past_event = strtotime($event_date) < current_time('timestamp');

            if (!$is_past_event) :
                // ユーザーがすでに参加登録しているか確認
                $is_attending = false;
                if (is_user_logged_in()) {
                    $attendees = get_post_meta(get_the_ID(), 'event_attendees', true);
                    $attendees = $attendees ? explode(',', $attendees) : array();
                    $is_attending = in_array(get_current_user_id(), $attendees);
                }
                ?>
                <div class="event-participation">
                    <?php if (is_user_logged_in()) : ?>
                        <?php if ($is_attending) : ?>
                            <button class="btn btn-success participation-btn" disabled>
                                <i class="fas fa-check"></i> 参加登録済み
                            </button>

                            <?php
                            $cancel_url = add_query_arg(
                                array(
                                    'action' => 'cancel_attendance',
                                    'post_id' => get_the_ID(),
                                    'nonce' => wp_create_nonce('cancel_attendance_' . get_the_ID())
                                ),
                                admin_url('admin-post.php')
                            );
                            ?>
                            <a href="<?php echo esc_url($cancel_url); ?>" class="btn btn-outline">
                                <i class="fas fa-times"></i> 参加をキャンセル
                            </a>
                        <?php else : ?>
                            <?php
                            $attend_url = add_query_arg(
                                array(
                                    'action' => 'attend_event',
                                    'post_id' => get_the_ID(),
                                    'nonce' => wp_create_nonce('attend_event_' . get_the_ID())
                                ),
                                admin_url('admin-post.php')
                            );
                            ?>
                            <a href="<?php echo esc_url($attend_url); ?>" class="btn btn-primary participation-btn">
                                <i class="fas fa-user-plus"></i> イベントに参加する
                            </a>
                        <?php endif; ?>
                    <?php else : ?>
                        <a href="<?php echo esc_url(home_url('/login?redirect_to=' . urlencode(get_permalink()))); ?>" class="btn btn-primary participation-btn">
                            <i class="fas fa-sign-in-alt"></i> ログインして参加する
                        </a>
                    <?php endif; ?>

                    <?php
                    // 参加者数を表示
                    $attendees = get_post_meta(get_the_ID(), 'event_attendees', true);
                    $attendees = $attendees ? explode(',', $attendees) : array();
                    $attendees_count = count($attendees);
                    ?>

                    <div class="attendees-count">
                        <i class="fas fa-users"></i> <?php echo esc_html($attendees_count); ?> 人が参加予定
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <?php
    // タグがある場合は表示
    $tags = get_the_tags();
    if ($tags) : ?>
        <div class="post-tags">
            <i class="fas fa-tags"></i>
            <?php foreach ($tags as $tag) : ?>
                <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag-link">
                    <?php echo esc_html($tag->name); ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php
    // 関連イベントがある場合は表示
    if (get_post_type() === 'event') :
        $related_args = array(
            'post_type' => 'event',
            'posts_per_page' => 3,
            'post__not_in' => array(get_the_ID()),
            'orderby' => 'rand',
            'tax_query' => array(
                array(
                    'taxonomy' => 'event_category',
                    'field' => 'id',
                    'terms' => wp_get_post_terms(get_the_ID(), 'event_category', array('fields' => 'ids')),
                ),
            ),
        );

        $related_query = new WP_Query($related_args);

        if ($related_query->have_posts()) : ?>
            <div class="related-events">
                <h3>関連イベント</h3>
                <div class="events-grid">
                    <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
                        <?php get_template_part('template-parts/content', 'card'); ?>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php
            wp_reset_postdata();
        endif;
    endif;
    ?>
</article>