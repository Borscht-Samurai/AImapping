<?php
/**
 * page-faq.php - よくある質問ページテンプレート
 * 
 * このテンプレートはスラッグ「faq」の固定ページに対して適用されます。
 */

get_header();
?>

<main class="site-main">
    <div class="container">
        <article id="post-<?php the_ID(); ?>" <?php post_class('faq-page'); ?>>
            <header class="page-header">
                <h1 class="page-title"><?php the_title(); ?></h1>
                
                <?php if (has_excerpt()) : ?>
                    <div class="page-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                <?php endif; ?>
            </header>

            <div class="faq-container">
                <div class="faq-categories">
                    <ul class="faq-category-list">
                        <li class="faq-category-item active" data-category="all">すべて</li>
                        <li class="faq-category-item" data-category="account">アカウント</li>
                        <li class="faq-category-item" data-category="events">イベント</li>
                        <li class="faq-category-item" data-category="participation">参加方法</li>
                        <li class="faq-category-item" data-category="trouble">トラブル</li>
                    </ul>
                </div>
                
                <div class="faq-search">
                    <input type="text" id="faq-search-input" class="form-control" placeholder="質問を検索...">
                    <button id="faq-search-button" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                
                <div class="faq-items">
                    <!-- アカウント関連 -->
                    <div class="faq-item" data-category="account">
                        <div class="faq-question">
                            <h3>アカウントの登録方法を教えてください。</h3>
                            <i class="fas fa-chevron-down faq-toggle"></i>
                        </div>
                        <div class="faq-answer">
                            <p>トップページの「新規登録」ボタン、またはヘッダーメニューの「新規登録」リンクからアカウント登録ページにアクセスできます。メールアドレス、ユーザー名、パスワードを入力して登録するか、GoogleやGitHubアカウントを利用して簡単に登録することができます。</p>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="account">
                        <div class="faq-question">
                            <h3>パスワードを忘れてしまいました。どうすればいいですか？</h3>
                            <i class="fas fa-chevron-down faq-toggle"></i>
                        </div>
                        <div class="faq-answer">
                            <p>ログインページの「パスワードをお忘れですか？」リンクをクリックして、登録したメールアドレスを入力してください。パスワードリセット用のリンクが記載されたメールが送信されます。</p>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="account">
                        <div class="faq-question">
                            <h3>プロフィール画像の変更方法を教えてください。</h3>
                            <i class="fas fa-chevron-down faq-toggle"></i>
                        </div>
                        <div class="faq-answer">
                            <p>ログイン後、ヘッダーメニューの「プロフィール」をクリックし、プロフィールページの「プロフィールを編集」ボタンをクリックします。プロフィール編集ページでプロフィール画像をアップロードできます。JPGまたはPNG形式の画像をアップロードしてください。</p>
                        </div>
                    </div>
                    
                    <!-- イベント関連 -->
                    <div class="faq-item" data-category="events">
                        <div class="faq-question">
                            <h3>イベントの投稿方法を教えてください。</h3>
                            <i class="fas fa-chevron-down faq-toggle"></i>
                        </div>
                        <div class="faq-answer">
                            <p>ログイン後、ヘッダーメニューの「新規投稿」ボタンをクリックするか、プロフィールページの「新規イベントを作成」ボタンからイベント投稿ページにアクセスできます。タイトル、内容、開催日時、場所などの必要情報を入力して投稿してください。</p>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="events">
                        <div class="faq-question">
                            <h3>投稿したイベントの編集・削除はできますか？</h3>
                            <i class="fas fa-chevron-down faq-toggle"></i>
                        </div>
                        <div class="faq-answer">
                            <p>はい、自分が投稿したイベントであれば編集・削除が可能です。イベント詳細ページの下部に表示される「編集」または「削除」ボタンをクリックしてください。</p>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="events">
                        <div class="faq-question">
                            <h3>オンラインイベントの開催方法を教えてください。</h3>
                            <i class="fas fa-chevron-down faq-toggle"></i>
                        </div>
                        <div class="faq-answer">
                            <p>イベント投稿時に「開催形式」で「オンライン」を選択してください。イベント内容欄にZoom、Google Meet、Discordなどのオンライン会議ツールの情報を記載することができます。参加者にのみURLを公開したい場合は、イベント参加登録者にのみ表示される「参加者向け情報」欄に記載することもできます。</p>
                        </div>
                    </div>
                    
                    <!-- 参加方法関連 -->
                    <div class="faq-item" data-category="participation">
                        <div class="faq-question">
                            <h3>イベントの参加方法を教えてください。</h3>
                            <i class="fas fa-chevron-down faq-toggle"></i>
                        </div>
                        <div class="faq-answer">
                            <p>参加したいイベントの詳細ページにアクセスし、「イベントに参加する」ボタンをクリックするだけで参加登録が完了します。ログインしていない場合は、ログインを求められます。</p>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="participation">
                        <div class="faq-question">
                            <h3>参加登録のキャンセル方法を教えてください。</h3>
                            <i class="fas fa-chevron-down faq-toggle"></i>
                        </div>
                        <div class="faq-answer">
                            <p>参加登録済みのイベント詳細ページにアクセスし、「参加をキャンセル」ボタンをクリックすることでキャンセルできます。また、プロフィールページの「参加予定のイベント」一覧からもキャンセルすることが可能です。</p>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="participation">
                        <div class="faq-question">
                            <h3>参加したイベントの感想や写真を投稿できますか？</h3>
                            <i class="fas fa-chevron-down faq-toggle"></i>
                        </div>
                        <div class="faq-answer">
                            <p>はい、イベント終了後、参加したイベントの詳細ページでコメントを投稿することができます。写真などのメディアもコメントに添付可能です。また、イベント主催者は参加者のフィードバックを基にイベントレポートを作成することもできます。</p>
                        </div>
                    </div>
                    
                    <!-- トラブル関連 -->
                    <div class="faq-item" data-category="trouble">
                        <div class="faq-question">
                            <h3>不適切なイベントや投稿を見つけた場合はどうすればいいですか？</h3>
                            <i class="fas fa-chevron-down faq-toggle"></i>
                        </div>
                        <div class="faq-answer">
                            <p>各イベントページやコメントの右上にある「報告」ボタンをクリックすることで、不適切なコンテンツを運営に報告することができます。報告内容は速やかに確認され、利用規約に違反している場合は適切な対応が取られます。</p>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="trouble">
                        <div class="faq-question">
                            <h3>サイトの利用中に問題が発生した場合はどうすればいいですか？</h3>
                            <i class="fas fa-chevron-down faq-toggle"></i>
                        </div>
                        <div class="faq-answer">
                            <p>フッターの「お問い合わせ」リンクからお問い合わせフォームにアクセスし、問題の詳細を記入して送信してください。また、発生した問題のスクリーンショットなどを添付していただけると、より迅速な解決が可能です。</p>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="trouble">
                        <div class="faq-question">
                            <h3>イベント主催者と連絡が取れなくなった場合はどうすればいいですか？</h3>
                            <i class="fas fa-chevron-down faq-toggle"></i>
                        </div>
                        <div class="faq-answer">
                            <p>イベント詳細ページから主催者にメッセージを送信することができます。メッセージに返信がない場合は、お問い合わせフォームから運営に状況を報告してください。運営側で状況を確認し、適切に対応いたします。</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php the_content(); ?>
            
        </article>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // FAQアコーディオンの機能
        const faqToggles = document.querySelectorAll('.faq-toggle');
        
        faqToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const faqItem = this.closest('.faq-item');
                const faqAnswer = faqItem.querySelector('.faq-answer');
                
                // アクティブ状態の切り替え
                faqItem.classList.toggle('active');
                
                // アイコンの切り替え
                if (faqItem.classList.contains('active')) {
                    this.classList.remove('fa-chevron-down');
                    this.classList.add('fa-chevron-up');
                } else {
                    this.classList.remove('fa-chevron-up');
                    this.classList.add('fa-chevron-down');
                }
            });
        });
        
        // カテゴリーによるフィルタリング
        const categoryBtns = document.querySelectorAll('.faq-category-item');
        const faqItems = document.querySelectorAll('.faq-item');
        
        categoryBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const category = this.getAttribute('data-category');
                
                // アクティブなカテゴリーボタンを更新
                categoryBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                // カテゴリーでフィルタリング
                faqItems.forEach(item => {
                    if (category === 'all' || item.getAttribute('data-category') === category) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
        
        // 検索機能
        const searchInput = document.getElementById('faq-search-input');
        const searchButton = document.getElementById('faq-search-button');
        
        function searchFAQ() {
            const searchTerm = searchInput.value.toLowerCase();
            
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question h3').textContent.toLowerCase();
                const answer = item.querySelector('.faq-answer').textContent.toLowerCase();
                
                if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
            
            // すべてのカテゴリーボタンから「active」クラスを削除
            categoryBtns.forEach(btn => btn.classList.remove('active'));
            // 「すべて」のボタンに「active」クラスを追加
            document.querySelector('[data-category="all"]').classList.add('active');
        }
        
        searchButton.addEventListener('click', searchFAQ);
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                searchFAQ();
            }
        });
    });
</script>

<?php get_footer(); ?>