<?php
get_header();
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">募集一覧</h1>

    <!-- カテゴリーフィルター -->
    <div class="mb-8 p-4 bg-white rounded-lg shadow-neumorphism">
        <h2 class="text-xl font-semibold mb-4">カテゴリーで絞り込む</h2>
        <div class="flex flex-wrap gap-2">
            <?php
            $categories = get_terms(array(
                'taxonomy' => 'recruitment_category',
                'hide_empty' => false,
            ));
            foreach ($categories as $category) :
            ?>
                <a href="<?php echo get_term_link($category); ?>" class="px-4 py-2 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors">
                    <?php echo esc_html($category->name); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- 募集一覧 -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article class="bg-white rounded-lg shadow-neumorphism overflow-hidden">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="aspect-w-16 aspect-h-9">
                        <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover')); ?>
                    </div>
                <?php endif; ?>
                
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-2">
                        <a href="<?php the_permalink(); ?>" class="hover:text-primary">
                            <?php the_title(); ?>
                        </a>
                    </h2>
                    
                    <?php
                    $deadline = get_post_meta(get_the_ID(), 'recruitment_deadline', true);
                    $event_date = get_post_meta(get_the_ID(), 'recruitment_event_date', true);
                    $location_type = get_post_meta(get_the_ID(), 'recruitment_location_type', true);
                    ?>
                    
                    <div class="text-sm text-gray-600 mb-4">
                        <p class="mb-1">
                            <i class="fas fa-clock mr-2"></i>
                            募集期限: <?php echo esc_html(date_i18n('Y年n月j日', strtotime($deadline))); ?>
                        </p>
                        <p class="mb-1">
                            <i class="fas fa-calendar mr-2"></i>
                            開催日時: <?php echo esc_html(date_i18n('Y年n月j日 H:i', strtotime($event_date))); ?>
                        </p>
                        <p>
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            開催形式: <?php echo esc_html(ucfirst($location_type)); ?>
                        </p>
                    </div>
                    
                    <div class="mb-4">
                        <?php the_excerpt(); ?>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <?php echo get_avatar(get_the_author_meta('ID'), 40, '', '', array('class' => 'rounded-full')); ?>
                            <span class="ml-2 text-sm"><?php the_author(); ?></span>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="inline-block px-4 py-2 bg-primary text-white rounded-full hover:bg-primary-dark transition-colors">
                            詳細を見る
                        </a>
                    </div>
                </div>
            </article>
        <?php endwhile; ?>
        
        <!-- ページネーション -->
        <div class="col-span-full mt-8">
            <?php
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => '&laquo; 前へ',
                'next_text' => '次へ &raquo;',
                'screen_reader_text' => 'ページ送り',
            ));
            ?>
        </div>
        
        <?php else : ?>
            <div class="col-span-full text-center py-8">
                <p>募集はまだありません。</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
?> 