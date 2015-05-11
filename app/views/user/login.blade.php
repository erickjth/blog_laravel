@extends('layout.app')
@section('title')
Login
@endsection

@section("header")
@include('layout.header')
@stop

@section('content')
<div id="content_wrap">
    <div class="row">
        <div class="col-md-5 col-md-offset-3">
            {{ Form::open(array('url' => 'user/login', 'method' => 'post','class'=>'login_form')) }}
            <h2>@lang('app.signin')</h2>
            <div class="form-group">
                {{Form::label('username',trans('app.username'))}}
                {{Form::text('username', null,array('class' => 'form-control'))}}
            </div>
            <div class="form-group">
                {{Form::label('password',trans('app.password'))}}
                {{Form::password('password',array('class' => 'form-control'))}}
            </div>
            {{Form::submit(trans('app.login'), array('class' => 'btn btn-primary'))}} {{ link_to('user/register',trans('app.signup' ) ) }}

            {{ Form::close() }}
        </div>
    </div>
</div>

@stop

