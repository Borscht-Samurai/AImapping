jQuery(document).ready(function($) {
    // いいねボタンのクリックイベント
    $('.like-button').on('click', function(e) {
        e.preventDefault();
        
        const $button = $(this);
        const postId = $button.data('post-id');
        const $likesCount = $button.find('.likes-count');
        
        // いいね済みの場合は処理を中断
        if ($button.hasClass('liked')) {
            return;
        }
        
        // いいねボタンを無効化
        $button.prop('disabled', true);
        
        // AJAXリクエスト
        $.ajax({
            url: aimapping_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'handle_like',
                post_id: postId,
                nonce: aimapping_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    // いいね数を更新
                    $likesCount.text(response.data.likes);
                    // いいね済みのスタイルを適用
                    $button.addClass('liked');
                }
            },
            error: function() {
                // エラー時はボタンを再度有効化
                $button.prop('disabled', false);
            }
        });
    });
    
    // モバイルメニューの開閉
    $('.mobile-menu-toggle').on('click', function() {
        $('.main-navigation').toggleClass('active');
    });
    
    // スクロールトップボタン
    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
            $('.scroll-top').fadeIn();
        } else {
            $('.scroll-top').fadeOut();
        }
    });
    
    $('.scroll-top').click(function() {
        $('html, body').animate({scrollTop: 0}, 500);
        return false;
    });
}); 