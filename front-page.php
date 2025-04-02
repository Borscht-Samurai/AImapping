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
    <section class="latest-events" style="margin: 0 50px;"> <?php // TODO: インラインスタイルを削除し、CSSクラスに移行することを推奨します ?>
        <div class="container">
            <h2 style="font-size: 40px;">Events</h2> <?php // TODO: インラインスタイルを削除し、CSSクラスに移行することを推奨します ?>
            <!-- style.cssで統一されたevents-gridクラスを使用 -->
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
            <div class="view-more" style="text-align: center; margin-top: 40px;"> <?php // TODO: インラインスタイルを削除し、CSSクラスに移行することを推奨します ?>
                <a href="<?php echo esc_url(home_url('/recruitment')); ?>" class="btn btn-outline" style="background-color: white; border: 2px solid black; padding: 10px 30px; border-radius: 25px; color: black; text-decoration: none; display: inline-block;font-size: 18px;">もっと見る</a> <?php // TODO: インラインスタイルを削除し、CSSクラス (例: .btn-view-more) に移行することを推奨します ?>
            </div>
        </div>
    </section>

    <!-- 新しいセクション - もっと見るボタンの下のボックス -->
    <section class="aqua-box-section" style="margin-top: 20px; background-color: #A5FDF7; width: 100%; height: 252px; display: flex; justify-content: center; align-items: center;">
        <div class="container" style="text-align: left; padding: 20px; margin-left: 20px; max-width: 100%; box-sizing: border-box;">
            <h2 style="font-weight: bold; font-size: 34px; margin-bottom: -10px;">イベントを登録する</h2>
            <p>全国のAIクリエイターとつながり、<br>新しいプロジェクトを始めましょう</p>
            <a href="<?php echo esc_url(home_url('/register')); ?>" class="btn btn-primary" style="background-color: #FF966C; color: white; padding: 10px 20px; border-radius: 50px; text-decoration: none; border: none; display: inline-block; width: 208px; height: 35px; font-size: 15px; text-align: center; line-height: 35px;">新規登録をする</a>
        </div>
        <img src="<?php echo esc_url(get_template_directory_uri() . '/images/9_Mindset_3D_Metal_Calendar.png'); ?>" alt="カレンダー" style="max-width: 100%; height: auto; margin-left: 120px; margin-top: -90px;" />
        <style>
            @media screen and (max-width: 768px) {
                .aqua-box-section .container {
                    margin-left: 20px !important;
                    padding: 15px !important;
                }
                .aqua-box-section h2 {
                    font-size: 28px !important;
                }
                .aqua-box-section br {
                    display: none;
                }
            }
            @media screen and (max-width: 480px) {
                .aqua-box-section .container {
                    margin-left: 10px !important;
                    padding: 10px !important;
                }
                .aqua-box-section h2 {
                    font-size: 24px !important;
                }
            }
        </style>
    </section>

    <!-- カテゴリー一覧 -->
    <section class="categories" style="margin: 0 50px;"> <?php // TODO: インラインスタイルを削除し、CSSクラスに移行することを推奨します ?>
        <div class="container">
            <h2 style="font-size: 40px;">Category</h2> <?php // TODO: インラインスタイルを削除し、CSSクラスに移行することを推奨します ?>
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
</main>

<?php get_footer(); ?> 