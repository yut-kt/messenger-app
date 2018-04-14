// 読み込み時に下までスクロール
window.scrollTo(0,document.body.scrollHeight);

/**
 * 相手の名前をヘッダーとして固定
 */
$(document).ready(function() {
    var $win = $(window),
        $main = $('main'),
        $nav = $('nav.container'),
        navHeight = $nav.outerHeight(),
        navPos = $nav.offset().top,
        fixedClass = 'message-header';

    // スクロールイベント
    $win.on('load scroll', function() {
        var value = $(this).scrollTop();
        //　スクロールの値が固定したい要素の位置より大きければ固定するクラスを付与、小さければ削除
        if ( value > navPos ) {
            $nav.addClass(fixedClass);
            $main.css('margin-top', navHeight);
        } else {
            $nav.removeClass(fixedClass);
            $main.css('margin-top', '0');
        }
    });
});

/**
 * 日本語が入力されたら予測変換が出てフォームが見えなくなってしまうので一番下までスクロール
 */
$(document).ready(function() {

    // 非ASCII
    var noSbcRegex = /[^\x00-\x7E]+/g;

    // 文字入力イベント
    $('.message-form').on('keyup', function(e) {

            // 2バイト文字が入力されたらスクロール
            var target = jQuery(this);
            if(!target.val().match(noSbcRegex)) return;
            window.setTimeout( function() {
                window.scrollTo(0,document.body.scrollHeight);
            }, 5);
        });
});
