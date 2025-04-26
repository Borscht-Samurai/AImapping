<?php
/**
 * Template Name: お問い合わせページ
 */

get_header();
?>

<main class="site-main">
    <div class="contact-header">
        <h1 class="contact-title">Contact</h1>
    </div>

    <div class="container">
        <article class="contact-page">
            <div class="contact-form-container">
                <h2 class="contact-subtitle">お問い合わせ</h2>
                <div class="contact-content">
                    <!-- ここにContact Form 7やその他のフォームを配置 -->
                    <?php the_content(); ?>
                </div>
            </div>
        </article>
    </div>
</main>

<style>
    /* Poppinsフォントの読み込み (Medium) */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

    .contact-header {
        margin: 40px 0 30px 20px;
    }
    .contact-title {
        font-size: 160px;
        line-height: 1;
        margin: 0;
        text-align: left;
        font-weight: 500; /* Medium */
        font-family: 'Poppins', sans-serif;
        letter-spacing: -0.08em; /* -8% */
    }
</style>

<?php get_footer(); ?>