// いいねボタンの機能
document.addEventListener('DOMContentLoaded', function() {
    const likeButtons = document.querySelectorAll('.like-button');
    
    likeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const postId = this.dataset.postId;
            const likeCount = this.querySelector('.like-count');
            const heartIcon = this.querySelector('i');
            
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
                    } else {
                        console.error('いいねの処理に失敗しました。');
                    }
                },
                error: function() {
                    console.error('Error:', error);
                }
            });
        });
    });
}); 