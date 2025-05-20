<?php
/**
 * Template Name: プライバシーポリシー
 * Description: プライバシーポリシーページ用のテンプレート
 */

get_header();
?>

<main class="site-main">
    <div class="privacy-header">
        <h1 class="privacy-title">Privacy Policy</h1>
    </div>

    <div class="container">
        <article class="privacy-page">
            <div class="privacy-policy-container">
                <h2 class="privacy-subtitle">プライバシーポリシー</h2>
                <div class="privacy-content">
                    <p>AI Mapping（以下、「当サイト」といいます）は、利用者の皆様のプライバシーを尊重し、個人情報の保護に最大限の注意を払っています。以下に、当サイトにおける個人情報の取り扱いに関する方針（プライバシーポリシー）を定めます。</p>

                    <h3>第1条（個人情報の定義）</h3>
                    <p>「個人情報」とは、生存する個人に関する情報であって、氏名、生年月日、住所、電話番号、メールアドレス、その他の記述等により特定の個人を識別できるもの、及び他の情報と照合することで特定の個人を識別できる情報をいいます。</p>

                    <h3>第2条（個人情報の収集方法）</h3>
                    <p>当サイトでは、ユーザーが登録・投稿・お問い合わせ等を行う際に、必要に応じて以下の個人情報を収集する場合があります。</p>
                    <ul>
                        <li>氏名またはニックネーム</li>
                        <li>メールアドレス</li>
                        <li>IPアドレス</li>
                        <li>Cookie情報</li>
                        <li>その他ユーザーが入力した情報</li>
                    </ul>

                    <h3>第3条（個人情報の利用目的）</h3>
                    <p>収集した個人情報は、以下の目的のために利用します。</p>
                    <ol>
                        <li>サービスの提供およびユーザーサポート</li>
                        <li>不正行為・迷惑行為の防止および対応</li>
                        <li>メンテナンス、重要なお知らせ等の連絡</li>
                        <li>サービス改善のための分析（アクセス解析含む）</li>
                        <li>法令・利用規約違反への対応</li>
                    </ol>

                    <h3>第4条（個人情報の第三者提供）</h3>
                    <p>当サイトは、法令に定める場合を除き、事前にユーザーの同意を得ることなく第三者に個人情報を提供することはありません。ただし、以下の場合はこの限りではありません。</p>
                    <ul>
                        <li>法令に基づく場合</li>
                        <li>人の生命、身体または財産の保護のために必要がある場合</li>
                        <li>公衆衛生の向上や児童の健全育成に特に必要な場合</li>
                        <li>国の機関または地方公共団体等に協力する必要がある場合</li>
                    </ul>

                    <h3>第5条（個人情報の管理）</h3>
                    <p>当サイトは、個人情報の漏洩、滅失、毀損等を防止するため、適切な安全対策を講じます。</p>

                    <h3>第6条（個人情報の開示・訂正・削除）</h3>
                    <p>ユーザーは、自己の個人情報について開示、訂正、追加、削除、利用停止を求めることができます。ご希望の場合は、当サイトの窓口までご連絡ください。本人確認が取れ次第、法令に基づき対応いたします。</p>

                    <h3>第7条（Cookieの使用について）</h3>
                    <p>当サイトでは、アクセス解析や利便性向上のためにCookieを使用することがあります。Cookieはブラウザ設定により無効にすることが可能ですが、一部サービスが利用できなくなる場合があります。</p>

                    <h3>第8条（プライバシーポリシーの変更）</h3>
                    <p>本ポリシーの内容は、法令その他本ポリシーに別段の定めがある事項を除き、ユーザーに通知することなく変更することがあります。変更後のプライバシーポリシーは、当サイトに掲載された時点で効力を生じるものとします。</p>

                    <h3>第9条（お問い合わせ窓口）</h3>
                    <p>本ポリシーに関するお問い合わせは、下記の窓口までお願いいたします。<br>
                    Niina<br> aimapping.gmail.com</p>

                    <p class="policy-dates">制定日：2025年5月5日<br>最終改定日：2025年5月18日</p>
                </div>
            </div>
        </article>
    </div>
</main>

<style>
    /* フォントの読み込み */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&family=Noto+Sans+JP:wght@400;500;700&display=swap');

    .site-main {
        background-color: #E7E7E7;
    }

    .privacy-header {
        margin: 40px 0 0 20px;
    }
    .privacy-title {
        font-size: 160px;
        line-height: 1;
        margin: 0;
        text-align: left;
        font-weight: 500; /* Medium */
        font-family: 'Poppins', sans-serif;
        letter-spacing: -0.08em; /* -8% */
    }

    /* プライバシーポリシーのスタイル */
    .container {
        margin-top: 200px; /* タイトルから100px下に配置 */
    }

    .privacy-policy-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .privacy-subtitle {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 30px;
        text-align: left;
        padding-left: 30px; /* 本文のパディングに合わせる */
        font-family: 'Noto Sans JP', sans-serif;
    }

    .privacy-content {
        background-color: #E7E7E7;
        padding: 30px;
        border-radius: 8px;
        font-family: 'Noto Sans JP', sans-serif;
        font-weight: 400;
        font-size: 12.98px;
        line-height: 150%;
        letter-spacing: 0%;
    }

    .privacy-content h3 {
        font-size: 14px;
        font-weight: bold;
        margin: 25px 0 15px;
        color: #333;
        font-family: 'Noto Sans JP', sans-serif;
        line-height: 150%;
        letter-spacing: 0%;
    }

    .privacy-content p {
        margin-bottom: 15px;
        font-family: 'Noto Sans JP', sans-serif;
        font-weight: 400;
        font-size: 12.98px;
        line-height: 150%;
        letter-spacing: 0%;
    }

    .privacy-content ul {
        margin-bottom: 15px;
        padding-left: 20px;
    }

    .privacy-content ul li {
        margin-bottom: 5px;
        font-family: 'Noto Sans JP', sans-serif;
        font-weight: 400;
        font-size: 12.98px;
        line-height: 150%;
        letter-spacing: 0%;
    }

    .privacy-content ol {
        margin-bottom: 15px;
        padding-left: 0; /* 左パディングを削除 */
        list-style-position: inside; /* 数字を内側に配置 */
        font-family: 'Noto Sans JP', sans-serif;
        font-weight: 400;
        font-size: 12.98px;
        line-height: 150%;
        letter-spacing: 0%;
    }

    .privacy-content ol li {
        margin-bottom: 5px;
        font-family: 'Noto Sans JP', sans-serif;
        font-weight: 400;
        font-size: 12.98px;
        line-height: 150%;
        letter-spacing: 0%;
    }

    .policy-dates {
        margin-top: 30px;
        color: #666;
        text-align: right;
        font-family: 'Noto Sans JP', sans-serif;
        font-weight: 400;
        font-size: 12.98px;
        line-height: 150%;
        letter-spacing: 0%;
    }

    /* レスポンシブ対応 */
    @media (max-width: 768px) {
        .privacy-title {
            font-size: 80px;
        }

        .privacy-content {
            padding: 20px;
        }
    }
</style>

<?php get_footer(); ?>
