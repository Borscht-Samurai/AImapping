<?php
/**
 * Template Name: 利用規約
 * Description: 利用規約ページ用のテンプレート
 */

get_header();
?>

<main class="site-main">
    <div class="terms-header">
        <h1 class="terms-title">Terms of Service</h1>
    </div>

    <div class="container">
        <article class="terms-page">
            <div class="terms-of-service-container">
                <h2 class="terms-subtitle">利用規約</h2>
                <div class="terms-content">
                    <p>AI Mapping（以下、「当サイト」といいます）の利用に際して、以下の利用規約に同意いただく必要があります。本サービスを利用することにより、利用者は本規約に同意したものとみなされます。</p>

                    <h3>第1条（適用範囲）</h3>
                    <p>本規約は、当サイトが提供するすべてのサービスの利用に関して適用されます。利用者は本規約に同意の上、サービスを利用するものとします。</p>

                    <h3>第2条（利用登録）</h3>
                    <p>当サイトのサービスを利用するためには、所定の方法により利用登録を行う必要があります。当サイトは、利用登録の申請者に以下の事由があると判断した場合、利用登録を承認しないことがあります。</p>
                    <ul>
                        <li>虚偽の情報を提供した場合</li>
                        <li>過去に本規約違反等により、利用停止措置を受けたことがある場合</li>
                        <li>その他、当サイトが利用登録を適当でないと判断した場合</li>
                    </ul>

                    <h3>第3条（ユーザーIDおよびパスワードの管理）</h3>
                    <p>利用者は、自己の責任においてユーザーIDおよびパスワードを管理するものとします。ユーザーIDおよびパスワードの管理不十分、使用上の過誤、第三者の使用等による損害の責任は利用者が負うものとし、当サイトは一切の責任を負いません。</p>

                    <h3>第4条（禁止事項）</h3>
                    <p>利用者は、当サイトの利用にあたり、以下の行為をしてはなりません。</p>
                    <ol>
                        <li>法令または公序良俗に違反する行為</li>
                        <li>犯罪行為に関連する行為</li>
                        <li>当サイトのサーバーまたはネットワークの機能を破壊したり、妨害したりする行為</li>
                        <li>当サイトのサービスの運営を妨害するおそれのある行為</li>
                        <li>他の利用者に関する個人情報等を収集または蓄積する行為</li>
                        <li>他の利用者に成りすます行為</li>
                        <li>当サイトのサービスに関連して、反社会的勢力に対して直接または間接に利益を供与する行為</li>
                        <li>その他、当サイトが不適切と判断する行為</li>
                    </ol>

                    <h3>第5条（サービス内容の変更・停止）</h3>
                    <p>当サイトは、利用者に通知することなく、サービスの内容を変更したり、提供を停止したりすることができるものとします。これによって利用者に生じた損害について、当サイトは一切の責任を負いません。</p>

                    <h3>第6条（利用制限および登録抹消）</h3>
                    <p>当サイトは、以下の場合には、事前の通知なく、利用者に対してサービスの全部もしくは一部の利用を制限し、または利用者としての登録を抹消することができるものとします。</p>
                    <ul>
                        <li>本規約のいずれかの条項に違反した場合</li>
                        <li>登録事項に虚偽の事実があることが判明した場合</li>
                        <li>その他、当サイトが利用の継続を適当でないと判断した場合</li>
                    </ul>

                    <h3>第7条（免責事項）</h3>
                    <p>当サイトの利用によって生じた損害に関して、当サイトは一切の責任を負わないものとします。また、利用者と他の利用者または第三者との間において生じた取引、連絡または紛争等について、当サイトは一切責任を負いません。</p>

                    <h3>第8条（サービス内容の保証）</h3>
                    <p>当サイトは、サービスの内容が利用者の特定の目的に適合すること、期待する機能・商品的価値・正確性・有用性を有すること、および不具合が生じないことについて、何ら保証するものではありません。</p>

                    <h3>第9条（規約の変更）</h3>
                    <p>当サイトは、必要と判断した場合には、利用者に通知することなく本規約を変更することができるものとします。変更後の利用規約は、当サイトに掲載された時点で効力を生じるものとします。</p>

                    <h3>第10条（準拠法・裁判管轄）</h3>
                    <p>本規約の解釈にあたっては、日本法を準拠法とします。当サイトに関して紛争が生じた場合には、当サイトの本店所在地を管轄する裁判所を専属的合意管轄とします。</p>

                    <p class="policy-dates">制定日：2025年5月5日<br>最終改定日：2025年5月18日</p>
                </div>
            </div>
        </article>
    </div>
</main>

<style>
    /* フォントの読み込み */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&family=Noto+Sans+JP:wght@400;500;700&display=swap');

    .terms-header {
        margin: 40px 0 0 20px;
    }
    .terms-title {
        font-size: 150px;
        line-height: 1;
        margin: 0;
        text-align: left;
        font-weight: 500; /* Medium */
        font-family: 'Poppins', sans-serif;
        letter-spacing: -0.08em; /* -8% */
    }

    /* 利用規約のスタイル */
    .container {
        margin-top: 200px; /* タイトルから100px下に配置 */
    }

    .terms-of-service-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .terms-subtitle {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 30px;
        text-align: left;
        padding-left: 30px; /* 本文のパディングに合わせる */
        font-family: 'Noto Sans JP', sans-serif;
    }

    .terms-content {
        background-color: #E7E7E7;
        padding: 30px;
        border-radius: 8px;
        font-family: 'Noto Sans JP', sans-serif;
        font-weight: 400;
        font-size: 12.98px;
        line-height: 150%;
        letter-spacing: 0%;
    }

    .terms-content h3 {
        font-size: 14px;
        font-weight: bold;
        margin: 25px 0 15px;
        color: #333;
        font-family: 'Noto Sans JP', sans-serif;
        line-height: 150%;
        letter-spacing: 0%;
    }

    .terms-content p {
        margin-bottom: 15px;
        font-family: 'Noto Sans JP', sans-serif;
        font-weight: 400;
        font-size: 12.98px;
        line-height: 150%;
        letter-spacing: 0%;
    }

    .terms-content ul {
        margin-bottom: 15px;
        padding-left: 20px;
    }

    .terms-content ul li {
        margin-bottom: 5px;
        font-family: 'Noto Sans JP', sans-serif;
        font-weight: 400;
        font-size: 12.98px;
        line-height: 150%;
        letter-spacing: 0%;
    }

    .terms-content ol {
        margin-bottom: 15px;
        padding-left: 0; /* 左パディングを削除 */
        list-style-position: inside; /* 数字を内側に配置 */
        font-family: 'Noto Sans JP', sans-serif;
        font-weight: 400;
        font-size: 12.98px;
        line-height: 150%;
        letter-spacing: 0%;
    }

    .terms-content ol li {
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
        .terms-title {
            font-size: 80px;
        }

        .terms-content {
            padding: 20px;
        }
    }
</style>

<?php get_footer(); ?>
