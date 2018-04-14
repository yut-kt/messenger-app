@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Friend Register</div>
                <div class="panel-body">
                    {{-- search_id登録フォーム --}}
                    {{ Form::open(['route' => 'friend.store', 'method' => 'POST']) }}
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('search_id') ? ' has-error' : '' }}">
                            <label for="search_id" class="col-md-4 control-label">Friend ID</label>
                            <div class="col-md-6">
                                <input id="search_id" class="form-control" name="search_id" value="{{ old('search_id') }}" required autofocus>

                            </div>
                        </div>
                    {{ Form::close() }}
                </div>

                {{-- フラッシュメッセージの表示 --}}
                <span class="help-block">
                    @if (Session::has('success_message'))
                        <div class="alert alert-success">{{ Session::get('success_message') }}</div>
                    @elseif (Session::has('warning_message'))
                        <div class="alert alert-warning">{{ Session::get('warning_message') }}</div>
                    @endif
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
