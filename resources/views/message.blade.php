@extends('layouts.app')

@section('content')

{{-- メッセージ相手の表示 --}}
<nav class="container">
    <p class="list-group-item list-group-item-info">
        <a href="{{ route('room.index') }}" class="back-page">＜</a>
        &emsp;&emsp;{{ $room_name }}
    </p>
</nav>

<div class="container" id="load">
    <div class="text-center">
        <button type="button" class="btn btn-link" onclick="OnLoad();">load</button>
    </div>
</div>

{{-- メッセージ --}}
<main id="messageBody" class="container">
    @foreach($messages as $message)
        <row>
            @if($message->user_id == Auth::id())
                <div class="message-box-mine col-xs-7 col-xs-push-5">{{ $message->message }}</div>
            @else
                <div class="message-box-other col-xs-7">{{ $message->message }}</div>
            @endif
        </row>
    @endforeach
</main>

{{-- 入力フォーム --}}
<div id="messageFooter" class="footer">
    <div class="container">
        {{ Form::open(['route' => 'message.store', 'method' => 'POST']) }}
            <div class="input-group">
                {{ csrf_field() }}
                <input type="text" name="message" class="form-control message-form" placeholder="メッセージを入力:">
                <input type="hidden" name="room_id" value="{{ $room_id }}">
                <span class="input-group-btn">
                    <button type="submit"class="btn btn-default">送信</button>
                </span>
            </div>
        {{ Form::close() }}
    </div>
</div>
@endsection

@section('js')
    <script src="{{ asset('js/message.js') }}"></script>
    <script src="https://js.pusher.com/4.0/pusher.min.js"></script>
    <script type="text/javascript">
        /**
         * リアルタイムでメッセージをやり取りする
         */

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        // pusherプロジェクトの情報
        var pusher = new Pusher('3d2f1fcc3ca4ea67f39b', {
            cluster: 'ap1',
            encrypted: true
        });

        // action
        var channel = pusher.subscribe('messageAction');
        channel.bind("App\\Events\\MessageUploaded", function(data) {
            // room_idが一致したら書き込み
            if (data.room_id == {{ $room_id }} && data.user_id != {{ Auth::id() }}) {
                var message_element = '<row><div class="message-box-other col-xs-7">' + data.message + '</div></row>';
                $("#messageBody").append(message_element);
                // 書き込み後スルクロール
                window.scrollTo(0,document.body.scrollHeight);
            }
        });

        /**
         * メッセージを読み込み、表示
         */
        load_number = 2; // 表示の領域
        function OnLoad() {
            $.ajax({
                    type: "POST",
                    url: "{{ route('message.load', [$room_id]) }}",
                    data: {load_number: load_number, _token: "{{ csrf_token() }}"},
                    cache: false,
                }).done(function (data, textStatus) {
                    var message_element = '';
                    var max_index = Object.keys(data).length - 1;
                    // メッセージの書き込み
                    for (key in data) {
                        index = max_index - key;
                        if (data[index]['user_id'] == {{ Auth::id() }}) {
                            message_element += '<row><div class="message-box-mine col-xs-7 col-xs-push-5">';
                        } else {
                            message_element += '<row><div class="message-box-other col-xs-7">';
                        }
                        message_element += data[index]['message'] + '</div></row>';
                    }
                    $("#messageBody").prepend(message_element);

                    // 表示していたあたりまでスクロール
                    var body = window.document.body;
                    var html = window.document.documentElement;
                    var scrollTop = body.scrollTop || html.scrollTop;
                    $(window).scrollTop(html.clientHeight - scrollTop);

                    load_number++;

                    // 読み込むメッセージがなくなったらボタンを削除
                    if (max_index != 9) {
                        $("#load").remove();
                    }
                });
        }
    </script>
@endsection
