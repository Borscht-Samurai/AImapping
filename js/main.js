jQuery(document).ready(function($) {
    // いいねボタンの処理はscript.jsに移行しました

    // モバイルメニューの開閉
    $('.mobile-menu-toggle').on('click', function(e) {
        e.stopPropagation();
        $(this).toggleClass('active');
        $('.main-navigation').toggleClass('active');

        // メニューが開いているときは背景スクロールを無効化
        if ($('.main-navigation').hasClass('active')) {
            $('body').addClass('menu-open').css('overflow', 'hidden');
        } else {
            $('body').removeClass('menu-open').css('overflow', '');
        }
    });

    // メニュー外クリックで閉じる
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.mobile-menu-toggle, .main-navigation').length && $('.main-navigation').hasClass('active')) {
            $('.mobile-menu-toggle').removeClass('active');
            $('.main-navigation').removeClass('active');
            $('body').removeClass('menu-open').css('overflow', '');
        }
    });

    // メニュー内のリンククリックでメニューを閉じる
    $('.nav-menu a').on('click', function() {
        $('.mobile-menu-toggle').removeClass('active');
        $('.main-navigation').removeClass('active');
        $('body').removeClass('menu-open').css('overflow', '');
    });

    // メニュー内をクリックしても閉じないようにする
    $('.main-navigation').on('click', function(e) {
        e.stopPropagation();
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

    // ページ読み込み時にハンバーガーメニューの状態をリセット
    $('.mobile-menu-toggle').removeClass('active');
    $('.main-navigation').removeClass('active');
    $('body').removeClass('menu-open').css('overflow', '');
});