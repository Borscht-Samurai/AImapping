<?php
/**
 * 404.php - 404エラーページテンプレート
 */

get_header();
?>

<main class="site-main">
    <div class="container">
        <div class="error-404">
            <div class="error-header">
                <h1 class="error-title">404</h1>
                <p class="error-subtitle">ページが見つかりませんでした</p>
            </div>
            
            <div class="error-content">
                <p>お探しのページは移動または削除された可能性があります。</p>
                <div class="error-actions">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                        <i class="fas fa-home"></i> トップページへ戻る
                    </a>
                    
                    <div class="error-search">


                        <?php get_search_form(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>