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
            
            // いいねの状態を切り替え
            this.classList.toggle('active');
            heartIcon.classList.toggle('far');
            heartIcon.classList.toggle('fas');
            
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
                        likeCount.textContent = response.data.likes;
                    } else {
                        // エラー時は元の状態に戻す
                        button.classList.toggle('active');
                        heartIcon.classList.toggle('far');
                        heartIcon.classList.toggle('fas');
                    }
                },
                error: function() {
                    console.error('Error:', error);
                    // エラー時は元の状態に戻す
                    button.classList.toggle('active');
                    heartIcon.classList.toggle('far');
                    heartIcon.classList.toggle('fas');
                }
            });
        });
    });
}); 