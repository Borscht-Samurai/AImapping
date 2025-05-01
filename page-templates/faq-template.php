<?php
/**
 * Template Name: FAQ
 * Description: FAQページ用のテンプレート
 */

get_header();
?>

<main class="site-main">
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

<style>
    /* フォントの読み込み */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&family=Noto+Sans+JP:wght@400;500;700&display=swap');

    .faq-header {
        margin: 40px 0 0 20px;
    }
    .faq-title {
        font-size: 160px;
        line-height: 1;
        margin: 0;
        text-align: left;
        font-weight: 500; /* Medium */
        font-family: 'Poppins', sans-serif;
        letter-spacing: -0.08em; /* -8% */
    }

    /* FAQのスタイル */
    .faq-container {
        width: 100%;
        max-width: 1100px;
        margin: 200px auto 0;
        padding: 0 20px;
    }

    .faq-subtitle {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 30px;
        text-align: left;
        font-family: 'Noto Sans JP', sans-serif;
    }

    .faq-content {
        background-color: var(--white-color);
        padding: 30px;
        border-radius: 8px;
        font-family: 'Noto Sans JP', sans-serif;
        font-weight: 400;
        font-size: 12.98px;
        line-height: 150%;
        letter-spacing: 0%;
    }

    .faq-category {
        margin-bottom: 40px;
    }

    .faq-category-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
        color: #333;
        font-family: 'Noto Sans JP', sans-serif;
    }

    .faq-item {
        margin-bottom: 15px;
        border-radius: 8px;
        overflow: hidden;
        background-color: #F8F8F8;
    }

    .faq-question {
        padding: 15px 20px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .faq-question h4 {
        margin: 0;
        font-size: 14px;
        font-weight: 500;
        font-family: 'Noto Sans JP', sans-serif;
    }

    .faq-toggle {
        transition: transform 0.3s ease;
    }

    .faq-item.active .faq-toggle {
        transform: rotate(180deg);
    }

    .faq-answer {
        padding: 0 20px;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease, padding 0.3s ease;
    }

    .faq-item.active .faq-answer {
        padding: 0 20px 15px;
        max-height: 500px; /* 十分な高さを確保 */
    }

    .faq-answer p {
        margin: 0;
        font-family: 'Noto Sans JP', sans-serif;
        font-weight: 400;
        font-size: 12.98px;
        line-height: 150%;
        letter-spacing: 0%;
    }



    /* レスポンシブ対応 */
    @media (max-width: 768px) {
        .faq-title {
            font-size: 80px;
        }

        .faq-container {
            margin-top: 100px;
        }

        .faq-content {
            padding: 20px;
        }

        .faq-question h4 {
            font-size: 13px;
        }
    }
</style>

<script>
    jQuery(document).ready(function($) {
        // FAQ項目のトグル機能
        $('.faq-question').on('click', function() {
            $(this).parent('.faq-item').toggleClass('active');
        });
    });
</script>

<?php get_footer(); ?>
