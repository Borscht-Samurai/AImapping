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