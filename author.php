<?php
/**
 * author.php - ユーザープロフィールページテンプレート
 */

get_header();
?>

<main class="site-main">
    <div class="container">
        <?php
        $curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
        ?>

        <div class="author-profile">
            <div class="author-header">
                <div class="author-avatar">
                    <?php echo get_avatar($curauth->ID, 120); ?>
                </div>
                <div class="author-info">
                    <h1 class="author-name"><?php echo esc_html($curauth->display_name); ?></h1>
                    
                    <?php if (!empty($curauth->description)) : ?>
                        <div class="author-bio">
                            <?php echo wpautop(esc_html($curauth->description)); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="author-meta">
                        <?php if (!empty($curauth->user_url)) : ?>
                            <div class="author-website">
                                <i class="fas fa-globe"></i>
                                <a href="<?php echo esc_url($curauth->user_url); ?>" target="_blank">
                                    <?php echo esc_html($curauth->user_url); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php
                        // SNSリンクの表示（カスタムフィールドから取得）
                        $social_links = array(
                            'twitter' => get_user_meta($curauth->ID, 'twitter', true),
                            'facebook' => get_user_meta($curauth->ID, 'facebook', true),
                            'instagram' => get_user_meta($curauth->ID, 'instagram', true),
                            'github' => get_user_meta($curauth->ID, 'github', true),
                        );
                        
                        if (array_filter($social_links)) : ?>
                            <div class="author-social">
                                <?php foreach ($social_links as $platform => $url) : ?>
                                    <?php if (!empty($url)) : ?>
                                        <a href="<?php echo esc_url($url); ?>" class="social-link <?php echo $platform; ?>" target="_blank">
                                            <i class="fab fa-<?php echo $platform; ?>"></i>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (is_user_logged_in() && get_current_user_id() === $curauth->ID) : ?>
                        <div class="author-actions">
                            <a href="<?php echo esc_url(home_url('/edit-profile')); ?>" class="btn btn-secondary">
                                <i class="fas fa-user-edit"></i> プロフィールを編集
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- ユーザーの投稿一覧タブ -->
            <div class="author-content">
                <div class="content-tabs">
                    <button class="tab-btn active" data-tab="events">イベント</button>
                    <button class="tab-btn" data-tab="past-events">過去のイベント</button>
                </div>
                
                <div class="tab-content active" id="events">
                    <h2>主催イベント一覧</h2>
                    
                    <?php
                    $args = array(
                        'post_type' => 'event',
                        'posts_per_page' => 10,
                        'author' => $curauth->ID,
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
                    
                    $user_events = new WP_Query($args);
                    
                    if ($user_events->have_posts()) : ?>
                        <div class="events-grid">
                            <?php while ($user_events->have_posts()) : $user_events->the_post(); ?>
                                <?php get_template_part('template-parts/content', 'card'); ?>
                            <?php endwhile; ?>
                        </div>
                        
                        <?php
                        wp_reset_postdata();
                    else : ?>
                        <div class="no-events">
                            <p>現在開催予定のイベントはありません。</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="tab-content" id="past-events">
                    <h2>過去のイベント</h2>
                    
                    <?php
                    $args = array(
                        'post_type' => 'event',
                        'posts_per_page' => 10,
                        'author' => $curauth->ID,
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
                        <div class="events-grid">
                            <?php while ($past_events->have_posts()) : $past_events->the_post(); ?>
                                <?php get_template_part('template-parts/content', 'card'); ?>
                            <?php endwhile; ?>
                        </div>
                        
                        <?php
                        wp_reset_postdata();
                    else : ?>
                        <div class="no-events">
                            <p>過去に開催したイベントはありません。</p>
                        </div>
                    <?php endif; ?>
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