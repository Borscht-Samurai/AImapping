<?php get_header(); ?>

<main class="site-main">
    <!-- 白い四角セクション -->
    <section class="white-box-section">
        <div class="white-box">
            <div class="white-box-content">AI Mapping</div>
        </div>
    </section>

    <!-- グラデーションセクション -->
    <section class="gradient-box-section">
        <div class="gradient-box"></div>
    </section>

    <!-- Events -->
    <section class="latest-events" style="margin: 0 50px;">
        <div class="container">
            <h2 style="font-size: 40px;">Events</h2>
            <div class="events-grid">
                <?php
                $args = array(
                    'post_type' => 'recruitment',
                    'posts_per_page' => 6,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'meta_query' => array(
                        'relation' => 'OR',
                        array(
                            'key' => 'event_date',
                            'value' => current_time('mysql'),
                            'compare' => '>=',
                            'type' => 'DATETIME'
                        ),
                        array(
                            'key' => 'event_date',
                            'compare' => 'NOT EXISTS'
                        )
                    )
                );
                $events_query = new WP_Query($args);

                if ($events_query->have_posts()) :
                    while ($events_query->have_posts()) : $events_query->the_post();
                        get_template_part('template-parts/content', 'card');
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
            <div class="view-more">
                <a href="<?php echo esc_url(home_url('/recruitment')); ?>" class="btn btn-outline">もっと見る</a>
            </div>
        </div>
    </section>

    <!-- カテゴリー一覧 -->
    <section class="categories">
        <div class="container">
            <h2>カテゴリーから探す</h2>
            <div class="categories-grid">
                <?php
                $categories = get_recruitment_categories();
                foreach ($categories as $slug => $name) :
                    $term = get_term_by('slug', $slug, 'recruitment_category');
                    if ($term) :
                ?>
                    <a href="<?php echo esc_url(get_term_link($term)); ?>" class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-<?php echo esc_attr(get_category_icon($slug)); ?>"></i>
                        </div>
                        <h3><?php echo esc_html($name); ?></h3>
                        <p><?php echo esc_html($term->description); ?></p>
                    </a>
                <?php
                    endif;
                endforeach;
                ?>
            </div>
        </div>
    </section>

    <!-- サイトの特徴 -->
    <section class="features">
        <div class="container">
            <h2>AIMappingの特徴</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <i class="fas fa-users"></i>
                    <h3>クリエイター同士の交流</h3>
                    <p>AIを活用するクリエイター同士が集まり、知識や経験を共有できます。</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-calendar-alt"></i>
                    <h3>イベント開催</h3>
                    <p>オンライン・オフライン問わず、自由にイベントを開催できます。</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-project-diagram"></i>
                    <h3>プロジェクト協力</h3>
                    <p>新しいプロジェクトのパートナーを見つけたり、協力者を募集できます。</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?> 