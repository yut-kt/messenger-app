@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="list-group">
                    <div class="list-group-item-heading">&emsp;プロフィール</div>
                    <div class="list-group-item">
                        <pre><a href="{{ route('profile.index') }}">{{ Auth::user()->name }}</a> ID: @if(!Auth::user()->search_id)登録されていません@endif{{ Auth::user()->search_id }}</pre>
                    </div>
                    <ul class="nav nav-tabs">
                        <li role="presentation" class="active"><a href="#">友だち</a></li>
                        <li role="presentation"><a href="{{ route('room.index') }}">トーク</a></li>
                    </ul>
                    <div class="list-group-item-heading">
                        <a href="{{ route('friend.index') }}"><span class="glyphicon glyphicon-plus">友だち追加</span></a>
                    </div>
                    <div class="list-group-item">
                        {{-- 友達一覧 --}}
                        @foreach ($friends as $friend)
                            <pre>{{ $friend->name }}  <a href="{{ route('room.show', ['id' => $friend->id]) }}">トーク</a></pre>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
