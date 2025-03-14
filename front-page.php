<?php get_header(); ?>

<main class="site-main">
    <!-- ヒーローセクション -->
    <section class="hero-section">
        <div class="hero-content">
            <h1>AIを活用するクリエイターのための<br>コミュニティプラットフォーム</h1>
            <p>全国のAIクリエイターとつながり、新しいプロジェクトを始めましょう</p>
            <div class="hero-buttons">
                <a href="<?php echo esc_url(home_url('/register')); ?>" class="btn btn-primary">新規登録</a>
                <a href="<?php echo esc_url(home_url('/events')); ?>" class="btn btn-secondary">イベントを見る</a>
            </div>
        </div>
    </section>

    <!-- 最新のイベント -->
    <section class="latest-events">
        <div class="container">
            <h2>最新のイベント</h2>
            <div class="events-grid">
                <?php
                $args = array(
                    'post_type' => 'event',
                    'posts_per_page' => 6,
                    'orderby' => 'date',
                    'order' => 'DESC'
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
                <a href="<?php echo esc_url(home_url('/events')); ?>" class="btn btn-outline">もっと見る</a>
            </div>
        </div>
    </section>

    <!-- カテゴリー一覧 -->
    <section class="categories">
        <div class="container">
            <h2>カテゴリーから探す</h2>
            <div class="categories-grid">
                <?php
                $categories = get_terms(array(
                    'taxonomy' => 'event_category',
                    'hide_empty' => true,
                ));

                if (!empty($categories) && !is_wp_error($categories)) :
                    foreach ($categories as $category) :
                        ?>
                        <a href="<?php echo esc_url(get_term_link($category)); ?>" class="category-card">
                            <div class="category-icon">
                                <i class="fas fa-<?php echo esc_attr(get_category_icon($category->slug)); ?>"></i>
                            </div>
                            <h3><?php echo esc_html($category->name); ?></h3>
                            <p><?php echo esc_html($category->description); ?></p>
                        </a>
                        <?php
                    endforeach;
                endif;
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