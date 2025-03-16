<?php
/**
 * page.php - 固定ページテンプレート
 */

get_header();
?>

<main class="site-main">
    <div class="container">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('page-content'); ?>>
                <header class="page-header">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="page-thumbnail">
                            <?php the_post_thumbnail('full'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <h1 class="page-title"><?php the_title(); ?></h1>
                </header>

                <div class="page-content-inner">
                    <?php the_content(); ?>
                    
                    <?php
                    wp_link_pages(
                        array(
                            'before' => '<div class="page-links">' . esc_html__('ページ:', 'aimapping'),
                            'after'  => '</div>',
                        )
                    );
                    ?>
                </div>
                
                <?php
                // ページ更新情報
                if (get_the_modified_time() !== get_the_time()) :
                ?>
                <div class="page-footer">
                    <div class="page-meta">
                        <p class="last-updated">
                            <i class="fas fa-clock"></i>
                            最終更新日: <?php the_modified_date('Y年n月j日'); ?>
                        </p>
                    </div>
                </div>
                <?php endif; ?>
            </article>
            
            <?php
            // コメントが有効な場合、コメントテンプレートを表示
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
        endwhile; // End of the loop.
        ?>
    </div>
</main>

<?php get_footer(); ?>