@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
             <div class="panel panel-default">
                <div class="list-group">
                    <div class="list-group-item-heading">&emsp;ルーム</div>
                    <div class="list-group-item">
                        <pre><a href="{{ route('profile.index') }}">{{ Auth::user()->name }}</a> ID: @if(!Auth::user()->search_id)登録されていません@endif{{ Auth::user()->search_id }}</pre>
                    </div>
                    <ul class="nav nav-tabs">
                        <li role="presentation"><a href="{{ route('home') }}">友だち</span> </a></li>
                        <li role="presentation" class="active"><a href="#">トーク</a></li>
                    </ul>
                    <div class="list-group-item">
                        @foreach($users as $user)
                            @foreach($user_rooms as $user_room)
                                @if($user->id == $user_room->user_id)
                                    <a href="{{ route('message.show', [$user_room->room_id]) }}"><pre>{{ $user->name }}  @if(!$user_room->read)<span class="badge">N</span>@endif</pre></a>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
