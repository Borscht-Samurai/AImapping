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
                    <!-- Contact Form 7のショートコード -->
                    <?php echo do_shortcode('[contact-form-7 id="ffce507" title="コンタクトフォーム 1"]'); ?>
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

    /* お問い合わせフォームのスタイル */
    .contact-form-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .contact-subtitle {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 30px;
        text-align: left;
        padding-left: 30px; /* フォームのパディングに合わせる */
    }

    .wpcf7-form {
        background-color: var(--background-color);
        padding: 30px;
        border-radius: 8px;
    }

    .wpcf7-form label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .wpcf7-form .required {
        color: #ff4757;
        margin-left: 5px;
    }

    .wpcf7-form input[type="text"],
    .wpcf7-form input[type="email"],
    .wpcf7-form input[type="tel"],
    .wpcf7-form textarea {
        width: 100%;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        background-color: var(--background-color);
        font-size: 16px;
    }

    .wpcf7-form textarea {
        height: 200px;
        resize: vertical;
    }

    .wpcf7-form .privacy-policy-checkbox {
        margin: 20px 0;
        text-align: center; /* 中央揃えに変更 */
    }

    .wpcf7-form .privacy-policy-checkbox .wpcf7-list-item {
        margin: 0;
        display: inline-block; /* インラインブロック要素として表示 */
    }

    .wpcf7-form .privacy-policy-checkbox label {
        display: flex;
        align-items: center;
        justify-content: center; /* チェックボックスとテキストを中央に配置 */
    }

    .wpcf7-form .privacy-policy-checkbox input[type="checkbox"] {
        margin-right: 8px;
    }

    .wpcf7-form .privacy-policy-checkbox a {
        color: #FF966C;
        text-decoration: underline;
    }

    .submit-button-container {
        text-align: center;
        margin-top: 30px;
    }

    .wpcf7-form .wpcf7-submit {
        display: inline-block;
        padding: 15px 60px;
        background-color: #FF966C;
        color: #000000;
        border: none;
        border-radius: 30px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }

    .wpcf7-form .wpcf7-submit:hover {
        background-color: #ff8552;
    }

    /* reCAPTCHAの中央揃え */
    .wpcf7 .wpcf7-recaptcha {
        display: flex;
        justify-content: center;
        margin: 20px 0;
    }

    /* レスポンシブ対応 */
    @media (max-width: 768px) {
        .wpcf7-form {
            padding: 20px;
        }
    }
</style>

<?php get_footer(); ?>