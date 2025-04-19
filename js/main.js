jQuery(document).ready(function($) {
    // いいねボタンの処理はscript.jsに移行しました

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