<?php
get_header();

while (have_posts()) :
    the_post();
    
    // メタ情報の取得
    $deadline = get_post_meta(get_the_ID(), 'recruitment_deadline', true);
    $event_date = get_post_meta(get_the_ID(), 'recruitment_event_date', true);
    $location_type = get_post_meta(get_the_ID(), 'recruitment_location_type', true);
    $location = get_post_meta(get_the_ID(), 'recruitment_location', true);
?>

<article class="container mx-auto px-4 py-8">
    <!-- ヘッダー部分 -->
    <header class="mb-8">
        <h1 class="text-4xl font-bold mb-4"><?php the_title(); ?></h1>
        
        <div class="flex flex-wrap items-center gap-4 text-gray-600 mb-4">
            <div class="flex items-center">
                <?php echo get_avatar(get_the_author_meta('ID'), 40, '', '', array('class' => 'rounded-full mr-2')); ?>
                <span><?php the_author(); ?></span>
            </div>
            <div>
                <i class="fas fa-clock mr-1"></i>
                <?php echo get_the_date('Y年n月j日'); ?>
            </div>
            <?php
            $categories = get_the_terms(get_the_ID(), 'recruitment_category');
            if ($categories) :
                foreach ($categories as $category) :
            ?>
                <a href="<?php echo get_term_link($category); ?>" class="px-3 py-1 bg-gray-100 rounded-full hover:bg-gray-200 transition-colors">
                    <?php echo esc_html($category->name); ?>
                </a>
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </header>

    <!-- メイン情報 -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- 左カラム：メインコンテンツ -->
        <div class="lg:col-span-2">
            <!-- アイキャッチ画像 -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="mb-8 rounded-lg overflow-hidden shadow-neumorphism">
                    <?php the_post_thumbnail('large', array('class' => 'w-full h-auto')); ?>
                </div>
            <?php endif; ?>

            <!-- 本文 -->
            <div class="bg-white rounded-lg shadow-neumorphism p-6 mb-8">
                <div class="prose max-w-none">
                    <?php the_content(); ?>
                </div>
            </div>

            <!-- コメントセクション -->
            <div class="bg-white rounded-lg shadow-neumorphism p-6">
                <?php
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>
            </div>
        </div>

        <!-- 右カラム：イベント詳細 -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-neumorphism p-6 sticky top-4">
                <h2 class="text-xl font-bold mb-4">イベント詳細</h2>
                
                <div class="space-y-4">
                    <div>
                        <h3 class="font-semibold text-gray-600">
                            <i class="fas fa-clock mr-2"></i>募集期限
                        </h3>
                        <p><?php echo esc_html(date_i18n('Y年n月j日', strtotime($deadline))); ?></p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-600">
                            <i class="fas fa-calendar mr-2"></i>開催日時
                        </h3>
                        <p><?php echo esc_html(date_i18n('Y年n月j日 H:i', strtotime($event_date))); ?></p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-600">
                            <i class="fas fa-map-marker-alt mr-2"></i>開催形式
                        </h3>
                        <p><?php echo esc_html(ucfirst($location_type)); ?></p>
                    </div>

                    <?php if ($location) : ?>
                    <div>
                        <h3 class="font-semibold text-gray-600">
                            <i class="fas fa-location-dot mr-2"></i>開催場所
                        </h3>
                        <p><?php echo esc_html($location); ?></p>
                    </div>
                    <?php endif; ?>

                    <!-- 参加ボタン -->
                    <div class="mt-6">
                        <button class="w-full bg-primary text-white py-3 px-6 rounded-full hover:bg-primary-dark transition-colors">
                            参加を申し込む
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 関連募集 -->
    <?php
    $related_args = array(
        'post_type' => 'recruitment',
        'posts_per_page' => 3,
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'rand',
    );

    if ($categories) {
        $category_ids = wp_list_pluck($categories, 'term_id');
        $related_args['tax_query'] = array(
            array(
                'taxonomy' => 'recruitment_category',
                'field' => 'term_id',
                'terms' => $category_ids,
            ),
        );
    }

    $related_query = new WP_Query($related_args);

    if ($related_query->have_posts()) :
    ?>
    <section class="mt-12">
        <h2 class="text-2xl font-bold mb-6">関連する募集</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php
            while ($related_query->have_posts()) :
                $related_query->the_post();
                $related_deadline = get_post_meta(get_the_ID(), 'recruitment_deadline', true);
            ?>
            <article class="bg-white rounded-lg shadow-neumorphism overflow-hidden">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="aspect-w-16 aspect-h-9">
                        <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover')); ?>
                    </div>
                <?php endif; ?>
                
                <div class="p-4">
                    <h3 class="font-bold mb-2">
                        <a href="<?php the_permalink(); ?>" class="hover:text-primary">
                            <?php the_title(); ?>
                        </a>
                    </h3>
                    
                    <p class="text-sm text-gray-600 mb-2">
                        <i class="fas fa-clock mr-1"></i>
                        募集期限: <?php echo esc_html(date_i18n('Y年n月j日', strtotime($related_deadline))); ?>
                    </p>
                    
                    <div class="text-sm mb-4">
                        <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                    </div>
                    
                    <a href="<?php the_permalink(); ?>" class="inline-block px-4 py-2 bg-primary text-white rounded-full hover:bg-primary-dark transition-colors text-sm">
                        詳細を見る
                    </a>
                </div>
            </article>
            <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </section>
    <?php endif; ?>
</article>

<?php
endwhile;
get_footer();
?> 