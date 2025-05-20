<?php
/**
 * Template Name: FAQ
 * Description: FAQページ用のテンプレート
 */

get_header();
?>

<main class="site-main faq-page-main">
    <div class="faq-header">
        <h1 class="faq-title">FAQ</h1>
    </div>

    <div class="faq-container">
        <article class="faq-page">
            <h2 class="faq-subtitle">よくあるご質問</h2>
            <div class="faq-content">
                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Q1. 登録しないと何も使えませんか？</h4>
                        <i class="fas fa-chevron-down faq-toggle"></i>
                    </div>
                    <div class="faq-answer">
                        <p>登録なしでも一部コンテンツはご覧いただけますが、クリエイター検索や交流機能、掲示板投稿などは登録が必要です。ぜひ無料登録してご活用ください！</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Q2. どんな人が登録していますか？</h4>
                        <i class="fas fa-chevron-down faq-toggle"></i>
                    </div>
                    <div class="faq-answer">
                        <p>AIを使ってアート、音楽、映像、文章、プログラムなどを制作しているクリエイターが中心です。初心者の方も大歓迎です！</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Q3. 登録したら、必ず誰かと交流しなきゃいけないですか？</h4>
                        <i class="fas fa-chevron-down faq-toggle"></i>
                    </div>
                    <div class="faq-answer">
                        <p>いいえ、自由にご利用いただけます。まずは他の人の作品を見たり、気になる情報をチェックするだけでもOKです。</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Q4. どうやって他のクリエイターと交流できますか？</h4>
                        <i class="fas fa-chevron-down faq-toggle"></i>
                    </div>
                    <div class="faq-answer">
                        <p>気になるクリエイターのプロフィールからSNSやポートフォリオにアクセスして、直接コンタクトを取ることができます。また、掲示板やイベント情報もぜひご活用ください。</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Q5. 企業や団体も利用できますか？</h4>
                        <i class="fas fa-chevron-down faq-toggle"></i>
                    </div>
                    <div class="faq-answer">
                        <p>はい、企業・団体の方も大歓迎です。クリエイター発掘やコラボレーション、採用目的でご利用いただけます。掲示板での情報発信も可能です。</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Q6. どの地域にどんなクリエイターがいるか知るには？</h4>
                        <i class="fas fa-chevron-down faq-toggle"></i>
                    </div>
                    <div class="faq-answer">
                        <p>地域ごとにクリエイターを検索できる機能があります。マップや一覧ページから、気になる地域のクリエイターを簡単に探せます。</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Q7. プロフィールはどこまで詳しく書くべき？</h4>
                        <i class="fas fa-chevron-down faq-toggle"></i>
                    </div>
                    <div class="faq-answer">
                        <p>使用しているAIツールや得意な分野、活動内容などを詳しく書くと、コラボや交流につながりやすくなります！無理のない範囲で、あなたらしくご記入ください。</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Q8. 料金はかかりますか？</h4>
                        <i class="fas fa-chevron-down faq-toggle"></i>
                    </div>
                    <div class="faq-answer">
                        <p>現在、基本利用は無料です。（※将来的に一部有料機能が追加される場合は、事前にお知らせいたします。）</p>
                    </div>
                </div>
            </div>
        </article>
    </div>
</main>

<script>
    jQuery(document).ready(function($) {
        // FAQ項目のトグル機能
        $('.faq-question').on('click', function() {
            $(this).parent('.faq-item').toggleClass('active');
        });
    });
</script>

<?php get_footer(); ?>
