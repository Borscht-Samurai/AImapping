<?php
/**
 * front-page.php - トップページテンプレート
 */

get_header();
?>

<main class="site-main">
    <!-- メインビジュアル ボックスレイアウト -->
    <section class="main-visual">
        <div class="box-container">
            <!-- 左上: テキスト+ボタン -->
            <div class="box text-box">
                <div class="box-content">
                    <h2 class="box-title">FOR<br>EVERYONE BUT<br>NOTANYONE</h2>
                    <p class="box-description">AIを活用するクリエイター同士が集まり、新しいプロジェクトが生まれる場所</p>
                    <div class="box-buttons">
                        <a href="<?php echo esc_url(home_url('/register')); ?>" class="btn btn-primary">SHOP NOW</a>
                        <a href="<?php echo esc_url(home_url('/events')); ?>" class="btn btn-circle">
                            <span class="btn-arrow">→</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- 右上: 画像1 -->
            <div class="box image-box main-image">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/box-image-1.jpg" alt="メイン画像">
                <div class="image-overlay">
                    <div class="overlay-content">
                        <span class="overlay-tag">#RIPSTOP</span>
                    </div>
                </div>
            </div>
            
            <!-- 左下: 画像2 -->
            <div class="box image-box">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/box-image-2.jpg" alt="サブ画像1">
                <div class="image-overlay">
                    <div class="overlay-content">
                        <span class="overlay-tag">#INSULATED</span>
                    </div>
                </div>
            </div>
            
            <!-- 右下: 画像3 -->
            <div class="box image-box">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/box-image-3.jpg" alt="サブ画像2">
                <div class="image-overlay">
                    <div class="overlay-content">
                        <a href="<?php echo esc_url(home_url('/events')); ?>" class="overlay-btn">LEARN MORE</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- カテゴリーセクション（タグ風デザイン） -->
    <section class="categories-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">カテゴリーから探す</h2>
            </div>
            <div class="categories-tags">
                <?php
                $categories = get_terms(array(
                    'taxonomy' => 'event_category',
                    'hide_empty' => true,
                ));

                if (!empty($categories) && !is_wp_error($categories)) :
                    foreach ($categories as $category) :
                        ?>
                        <a href="<?php echo esc_url(get_term_link($category)); ?>" class="category-tag">
                            <span class="tag-icon">#</span><?php echo esc_html($category->name); ?>
                        </a>
                        <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- 最新のイベント（モダンなカードデザイン） -->
    <section class="latest-events">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">最新のイベント</h2>
                <a href="<?php echo esc_url(home_url('/events')); ?>" class="view-all">すべて見る →</a>
            </div>
            <div class="events-grid">
                <?php
                $args = array(
                    'post_type' => 'event',
                    'posts_per_page' => 3,
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
        </div>
    </section>

    <!-- 人気のイベント（大きい特集カード） -->
    <section class="featured-events">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">人気のイベント</h2>
            </div>
            <div class="featured-grid">
                <?php
                $featured_args = array(
                    'post_type' => 'event',
                    'posts_per_page' => 1,
                    'meta_key' => 'post_views',
                    'orderby' => 'meta_value_num',
                    'order' => 'DESC',
                );
                $featured_query = new WP_Query($featured_args);

                if ($featured_query->have_posts()) :
                    while ($featured_query->have_posts()) : $featured_query->the_post();
                    ?>
                    <div class="featured-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="featured-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('large'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="featured-content">
                            <div class="featured-meta">
                                <?php $event_date = get_event_date(); ?>
                                <?php if ($event_date) : ?>
                                    <span class="featured-date"><?php echo esc_html($event_date); ?></span>
                                <?php endif; ?>
                                
                                <?php
                                $categories = get_the_terms(get_the_ID(), 'event_category');
                                if ($categories && !is_wp_error($categories)) :
                                    foreach ($categories as $category) :
                                        ?>
                                        <span class="featured-category"><?php echo esc_html($category->name); ?></span>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </div>
                            <h3 class="featured-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <div class="featured-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary">詳細を見る</a>
                        </div>
                    </div>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- サイトの特徴（シンプルなアイコンとテキスト） -->
    <section class="features-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">AIMappingの特徴</h2>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="feature-title">クリエイター同士の交流</h3>
                    <p class="feature-text">AIを活用するクリエイター同士が集まり、知識や経験を共有できます。</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="feature-title">イベント開催</h3>
                    <p class="feature-text">オンライン・オフライン問わず、自由にイベントを開催できます。</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <h3 class="feature-title">プロジェクト協力</h3>
                    <p class="feature-text">新しいプロジェクトのパートナーを見つけたり、協力者を募集できます。</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTAセクション -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">あなたもAIクリエイターコミュニティに参加しませんか？</h2>
                <p class="cta-text">新しいアイデアやプロジェクトが始まるきっかけを見つけましょう</p>
                <a href="<?php echo esc_url(home_url('/register')); ?>" class="btn btn-primary btn-large">今すぐ登録する</a>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>