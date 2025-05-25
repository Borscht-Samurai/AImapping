<?php
/**
 * Template Name: プロフィールページ
 *
 * page-templates/profile-template.php - ユーザー自身のプロフィールページテンプレート
 */

// ログインしていないユーザーはログインページにリダイレクト
if (!is_user_logged_in()) {
    wp_redirect(home_url('/login'));
    exit;
}

$current_user = wp_get_current_user();

get_header();
?>

<main class="site-main">
    <div class="profile-header">
        <h1 class="profile-title">My page</h1>
    </div>

    <div class="container">
        <div class="profile-container">
            <?php
            // ユーザープロフィールテンプレートパーツを表示
            get_template_part('template-parts/user-profile', null, array(
                'user_id' => $current_user->ID,
                'show_actions' => true,
                'show_recent_events' => true
            ));
            ?>

            <div class="profile-main-content">
                <div class="profile-tabs content-max-width-centered">
                    <div class="tab-buttons">
                        <button class="tab-btn active" data-tab="upcoming-events">参加予定の募集</button>
                        <button class="tab-btn" data-tab="past-events">過去の参加募集</button>
                        <button class="tab-btn" data-tab="my-events">主催募集</button>
                    </div>

                    <div id="upcoming-events" class="tab-content active">
                        <div class="tab-inner-content">
                            <h2>参加予定の募集</h2>

                            <?php
                            // 参加予定のイベントを取得
                            $attended_events = get_user_meta($current_user->ID, 'attended_events', true);

                            if ($attended_events) {
                                $attended_events_array = explode(',', $attended_events);

                                $args = array(
                                    'post_type' => 'recruitment',
                                    'posts_per_page' => 10,
                                    'post__in' => $attended_events_array,
                                    'meta_query' => array(
                                        array(
                                            'key' => 'event_date',
                                            'value' => date('Y-m-d'),
                                            'compare' => '>=',
                                            'type' => 'DATE'
                                        )
                                    ),
                                    'orderby' => 'meta_value',
                                    'meta_key' => 'event_date',
                                    'order' => 'ASC'
                                );

                                $upcoming_events = new WP_Query($args);

                                if ($upcoming_events->have_posts()) : ?>
                                    <div class="events-grid content-max-width-centered">
                                        <?php while ($upcoming_events->have_posts()) : $upcoming_events->the_post(); ?>
                                            <?php get_template_part('template-parts/content', 'card'); ?>
                                        <?php endwhile; ?>
                                    </div>

                                    <?php
                                    wp_reset_postdata();
                                else : ?>
                                    <div class="no-events">
                                        <p>参加予定の募集はありません。</p>
                                        <a href="<?php echo esc_url(home_url('/recruitment')); ?>" class="btn btn-primary">募集を探す</a>
                                    </div>
                                <?php endif;
                            } else { ?>
                                <div class="no-events">
                                    <p>参加予定の募集はありません。</p>
                                    <a href="<?php echo esc_url(home_url('/recruitment')); ?>" class="btn btn-primary">募集を探す</a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div id="past-events" class="tab-content">
                        <div class="tab-inner-content">
                            <h2>過去の参加募集</h2>

                            <?php
                            // 過去の参加イベントを取得
                            $attended_events = get_user_meta($current_user->ID, 'attended_events', true);

                            if ($attended_events) {
                                $attended_events_array = explode(',', $attended_events);

                                $args = array(
                                    'post_type' => 'recruitment',
                                    'posts_per_page' => 10,
                                    'post__in' => $attended_events_array,
                                    'meta_query' => array(
                                        array(
                                            'key' => 'event_date',
                                            'value' => date('Y-m-d'),
                                            'compare' => '<',
                                            'type' => 'DATE'
                                        )
                                    ),
                                    'orderby' => 'meta_value',
                                    'meta_key' => 'event_date',
                                    'order' => 'DESC'
                                );

                                $past_events = new WP_Query($args);

                                if ($past_events->have_posts()) : ?>
                                    <div class="events-grid content-max-width-centered">
                                        <?php while ($past_events->have_posts()) : $past_events->the_post(); ?>
                                            <?php get_template_part('template-parts/content', 'card'); ?>
                                        <?php endwhile; ?>
                                    </div>

                                    <?php
                                    wp_reset_postdata();
                                else : ?>
                                    <div class="no-events">
                                        <p>過去に参加した募集はありません。</p>
                                    </div>
                                <?php endif;
                            } else { ?>
                                <div class="no-events">
                                    <p>過去に参加した募集はありません。</p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div id="my-events" class="tab-content">
                        <div class="tab-inner-content">
                            <h2>主催募集一覧</h2>

                            <?php
                            // ユーザーが投稿したイベントを取得
                            $args = array(
                                'post_type' => 'recruitment',
                                'posts_per_page' => 10,
                                'author' => $current_user->ID,
                                'orderby' => 'date',
                                'order' => 'DESC'
                            );

                            $user_events = new WP_Query($args);

                            if ($user_events->have_posts()) : ?>
                                <div class="events-grid content-max-width-centered">
                                    <?php while ($user_events->have_posts()) : $user_events->the_post(); ?>
                                        <?php get_template_part('template-parts/content', 'card'); ?>
                                    <?php endwhile; ?>
                                </div>

                                <?php
                                wp_reset_postdata();
                            else : ?>
                                <div class="no-events">
                                    <p>投稿した募集はありません。</p>
                                    <a href="<?php echo esc_url(home_url('/new-post')); ?>" class="btn btn-primary">募集を投稿する</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // タブ切り替え機能
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // すべてのタブからアクティブクラスを削除
                tabBtns.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                // クリックされたタブとそれに対応するコンテンツをアクティブに
                this.classList.add('active');
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
    });
</script>

<?php get_footer(); ?>