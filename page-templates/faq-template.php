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

    <div class="container">
        <article class="faq-page">
            <div class="faq-container">
                <h2 class="faq-subtitle">よくあるご質問</h2>
                <div class="faq-content">
                    <!-- 利用方法カテゴリー -->
                    <div class="faq-category">
                        <h3 class="faq-category-title">サイトの利用方法について</h3>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h4>AI Mappingとは何ですか？</h4>
                                <i class="fas fa-chevron-down faq-toggle"></i>
                            </div>
                            <div class="faq-answer">
                                <p>AI Mappingは、AIを活用するクリエイター同士が日本全国（またはオンライン）で自由に集まり交流できる募集掲示板型プラットフォームです。イベントや交流会の開催、参加者の募集などができます。</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h4>利用登録はどのように行いますか？</h4>
                                <i class="fas fa-chevron-down faq-toggle"></i>
                            </div>
                            <div class="faq-answer">
                                <p>トップページ右上の「ログイン」ボタンから登録ページにアクセスできます。メールアドレスでの登録のほか、SNS連携（X、Meta、Google）でも簡単に登録できます。</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h4>募集の投稿はどのように行いますか？</h4>
                                <i class="fas fa-chevron-down faq-toggle"></i>
                            </div>
                            <div class="faq-answer">
                                <p>ログイン後、ヘッダーメニューの「投稿する」をクリックすると投稿フォームが表示されます。タイトル、内容、カテゴリー、開催日時、場所などを入力して投稿できます。</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- アカウント関連カテゴリー -->
                    <div class="faq-category">
                        <h3 class="faq-category-title">アカウントについて</h3>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h4>パスワードを忘れてしまいました。どうすればいいですか？</h4>
                                <i class="fas fa-chevron-down faq-toggle"></i>
                            </div>
                            <div class="faq-answer">
                                <p>ログインページの「パスワードをお忘れですか？」リンクをクリックし、登録したメールアドレスを入力してください。パスワードリセット用のリンクが記載されたメールが送信されます。</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h4>プロフィールはどのように編集できますか？</h4>
                                <i class="fas fa-chevron-down faq-toggle"></i>
                            </div>
                            <div class="faq-answer">
                                <p>ログイン後、マイページにアクセスし「プロフィール編集」ボタンをクリックすると、プロフィール情報（名前、自己紹介、プロフィール画像、SNSリンクなど）を編集できます。</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h4>アカウントを削除することはできますか？</h4>
                                <i class="fas fa-chevron-down faq-toggle"></i>
                            </div>
                            <div class="faq-answer">
                                <p>はい、可能です。マイページの設定から「アカウント削除」を選択してください。なお、削除すると投稿やコメントなどのデータも全て削除され、復元できませんのでご注意ください。</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- イベント関連カテゴリー -->
                    <div class="faq-category">
                        <h3 class="faq-category-title">イベント・募集について</h3>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h4>どのような募集が可能ですか？</h4>
                                <i class="fas fa-chevron-down faq-toggle"></i>
                            </div>
                            <div class="faq-answer">
                                <p>AI関連の勉強会、交流会、ワークショップなどのイベント開催の告知や、プロジェクト協力者の募集、スキルシェアなど、AIクリエイターの活動に関連する様々な募集が可能です。</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h4>投稿した募集を編集・削除できますか？</h4>
                                <i class="fas fa-chevron-down faq-toggle"></i>
                            </div>
                            <div class="faq-answer">
                                <p>はい、自分が投稿した募集は、募集詳細ページの下部にある「編集」または「削除」ボタンから編集・削除が可能です。ただし、すでに参加者がいる場合は、参加者への配慮をお願いします。</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h4>イベントへの参加方法を教えてください</h4>
                                <i class="fas fa-chevron-down faq-toggle"></i>
                            </div>
                            <div class="faq-answer">
                                <p>興味のあるイベントの詳細ページにアクセスし、コメント欄で参加の意思を表明するか、主催者が指定した方法（外部フォームなど）で申し込みを行ってください。</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- その他カテゴリー -->
                    <div class="faq-category">
                        <h3 class="faq-category-title">その他</h3>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h4>問題のある投稿を見つけた場合はどうすればいいですか？</h4>
                                <i class="fas fa-chevron-down faq-toggle"></i>
                            </div>
                            <div class="faq-answer">
                                <p>問題のある投稿を発見した場合は、お問い合わせフォームから管理者に報告してください。内容を確認の上、適切な対応を取らせていただきます。</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h4>サイトに関する要望や提案はどこで行えますか？</h4>
                                <i class="fas fa-chevron-down faq-toggle"></i>
                            </div>
                            <div class="faq-answer">
                                <p>サイトの改善要望や新機能の提案は、お問い合わせフォームからお寄せください。ユーザーの皆様のフィードバックを参考に、より良いサービスを目指しています。</p>
                            </div>
                        </div>
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
    .container {
        margin-top: 200px; /* タイトルから200px下に配置 */
    }

    .faq-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .faq-subtitle {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 30px;
        text-align: left;
        padding-left: 30px; /* 本文のパディングに合わせる */
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

        .container {
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
