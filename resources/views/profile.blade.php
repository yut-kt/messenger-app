@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="list-group">
                    <div class="list-group-item-heading">&emsp;プロフィール</div>
                    <div class="list-group-item">
                        <p>{{ Auth::user()->name }}</p>
                    </div>
                    @if (Auth::user()->search_id)
                        <div class="list-group-item">
                            <p>ID: {{ Auth::user()->search_id }}</p>
                        </div>
                    @else
                        <div class="list-group-item">
                            <p>ID: 登録されていません</p>
                        </div>

                        <div class="list-group-item">
                            <div class="panel-body">
                                {{ Form::open(['route' => 'profile.store', 'method' => 'POST']) }}
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="search_id" class="col-md-4 control-label">ID Register</label>

                                        <div class="col-md-6">
                                            <input id="search_id" class="form-control" name="search_id" required>
                                            @if ($errors->has('search_id'))
                                                <span class="help-block">
                                                    <div class="alert alert-warning">{{ $errors->first('search_id') }}</div>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
