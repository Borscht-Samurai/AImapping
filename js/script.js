// いいねボタンの機能
document.addEventListener('DOMContentLoaded', function() {
    const likeButtons = document.querySelectorAll('.like-button');

    // いいね処理中かどうかを追跡するフラグ
    let isProcessing = false;

    likeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            // すでに処理中の場合は何もしない
            if (isProcessing) {
                return;
            }

            // 処理中フラグをセット
            isProcessing = true;

            const postId = this.dataset.postId;
            const likeCount = this.querySelector('.like-count');
            const heartIcon = this.querySelector('i');

            // ボタンを無効化
            this.disabled = true;

            // AJAXでいいねを送信
            jQuery.ajax({
                url: aimapping_ajax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'handle_like',
                    post_id: postId,
                    nonce: aimapping_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        // いいねの状態を更新
                        button.classList.toggle('active', response.data.is_liked);
                        heartIcon.classList.toggle('far', !response.data.is_liked);
                        heartIcon.classList.toggle('fas', response.data.is_liked);
                        likeCount.textContent = response.data.likes;

                        // アニメーションを追加
                        heartIcon.style.animation = 'heartBeat 0.3s ease';
                        setTimeout(function() {
                            heartIcon.style.animation = '';
                            // アニメーション完了後にボタンを再度有効化
                            button.disabled = false;
                            // 処理中フラグを解除
                            isProcessing = false;
                        }, 300);
                    } else {
                        // ログインが必要な場合
                        if (response.data && response.data.require_login) {
                            if (confirm('いいねを付けるにはログインが必要です。\nログインページに移動しますか？')) {
                                // サイトのルートURLを取得
                                const rootUrl = window.location.origin;
                                window.location.href = rootUrl + '/login?redirect_to=' + encodeURIComponent(window.location.href);
                            }
                        } else {
                            console.error('いいねの処理に失敗しました。');
                        }
                        // エラー時はすぐにボタンを再度有効化
                        button.disabled = false;
                        isProcessing = false;
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
                    // エラー時もボタンを再度有効化
                    button.disabled = false;
                    isProcessing = false;
                }
            });
        });
    });
});