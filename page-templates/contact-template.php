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
        background-color: #F8F8F8;
        padding: 30px;
        border-radius: 8px;
    }

    .wpcf7-form label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        font-size: 12.98px;
        line-height: 150%;
        font-family: 'Noto Sans JP', sans-serif;
    }

    /* 入力フォームのラベル位置調整 */
    .wpcf7-form .form-field-container {
        position: relative;
        margin-bottom: 20px;
    }

    /* フローティングラベルのスタイル */
    .wpcf7-form .floating-label-container {
        position: relative;
        margin-bottom: 30px;
        width: 100%;
    }

    .wpcf7-form .floating-label-container label {
        position: absolute;
        top: 1rem;
        left: 1rem;
        transition: all 0.3s ease;
        pointer-events: none;
        color: #666;
        z-index: 1;
    }

    .wpcf7-form .floating-label-container input:focus ~ label,
    .wpcf7-form .floating-label-container input:not(:placeholder-shown) ~ label,
    .wpcf7-form .floating-label-container textarea:focus ~ label,
    .wpcf7-form .floating-label-container textarea:not(:placeholder-shown) ~ label {
        top: -0.5rem;
        left: 0.5rem;
        font-size: 0.8rem;
        background-color: #F8F8F8;
        padding: 0 0.5rem;
        border-radius: 4px;
        color: #000;
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
        padding: 1rem;
        padding-top: 1.5rem;
        margin-bottom: 0;
        border: none;
        border-radius: 1rem;
        background: #F8F8F8;
        box-shadow: 20px 20px 60px #c5c5c5,
            -20px -20px 60px #ffffff;
        transition: 0.3s;
        font-size: 16px;
        font-family: 'Noto Sans JP', sans-serif;
        font-weight: 400;
        position: relative;
        z-index: 0;
    }

    .wpcf7-form input[type="text"]:focus,
    .wpcf7-form input[type="email"]:focus,
    .wpcf7-form input[type="tel"]:focus,
    .wpcf7-form textarea:focus {
        outline-color: #F8F8F8;
        background: #F8F8F8;
        box-shadow: inset 20px 20px 60px #c5c5c5,
            inset -20px -20px 60px #ffffff;
        transition: 0.3s;
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
        width: 18px;
        height: 18px;
        border-radius: 4px;
        border: none;
        background-color: #F8F8F8;
        box-shadow: inset 5px 5px 10px #c5c5c5,
            inset -5px -5px 10px #ffffff;
        appearance: none;
        -webkit-appearance: none;
        cursor: pointer;
        position: relative;
    }

    .wpcf7-form .privacy-policy-checkbox input[type="checkbox"]:checked::before {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #000;
        font-size: 12px;
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
        background-color: #F8F8F8;
        color: #000000;
        border: none;
        border-radius: 1rem;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        box-shadow: 20px 20px 60px #c5c5c5,
            -20px -20px 60px #ffffff;
    }

    .wpcf7-form .wpcf7-submit:hover {
        transform: translateY(-2px);
    }

    .wpcf7-form .wpcf7-submit:active {
        box-shadow: inset 20px 20px 60px #c5c5c5,
            inset -20px -20px 60px #ffffff;
        transform: translateY(0);
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

        .wpcf7-form input[type="text"],
        .wpcf7-form input[type="email"],
        .wpcf7-form input[type="tel"],
        .wpcf7-form textarea {
            box-shadow: 10px 10px 30px #c5c5c5,
                -10px -10px 30px #ffffff;
        }

        .wpcf7-form .wpcf7-submit {
            box-shadow: 10px 10px 30px #c5c5c5,
                -10px -10px 30px #ffffff;
            padding: 12px 40px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Contact Form 7のフォーム構造を変更してフローティングラベルを実装
    const form = document.querySelector('.wpcf7-form');

    if (form) {
        // 通常の入力フィールドを処理
        const inputFields = form.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], textarea');

        inputFields.forEach(function(field) {
            // 親要素のlabelを取得
            const parentLabel = field.closest('label');

            if (parentLabel) {
                // ラベルテキストを取得（必須マークを含む）
                const labelContent = parentLabel.innerHTML.split(field.outerHTML)[0].trim();

                // 新しい構造を作成
                const container = document.createElement('div');
                container.className = 'floating-label-container';

                // 元のプレースホルダーを空にして、ラベルテキストをプレースホルダーとして使用
                const placeholderText = field.getAttribute('placeholder') || '';
                field.setAttribute('placeholder', ' '); // スペースを入れることで:placeholder-shownが機能する

                // 元のラベルを新しい構造に置き換え
                parentLabel.insertAdjacentElement('beforebegin', container);
                container.appendChild(field);

                // 新しいラベルを作成
                const newLabel = document.createElement('label');
                newLabel.innerHTML = labelContent;
                newLabel.setAttribute('for', field.getAttribute('name'));
                container.appendChild(newLabel);

                // 元のラベル要素を削除
                parentLabel.remove();
            }
        });

        // フォームが送信されたときにフォーカスを外す（アニメーション効果を確認するため）
        form.addEventListener('submit', function() {
            document.activeElement.blur();
        });

        // 初期表示時にすでに入力されているフィールドにクラスを追加
        setTimeout(function() {
            inputFields.forEach(function(field) {
                if (field.value.trim() !== '') {
                    field.classList.add('has-value');
                }
            });
        }, 100);
    }
});
</script>

<?php get_footer(); ?>