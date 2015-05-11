
@extends('layout.app')
@section('title')
Register user
@endsection

@section("header")
@include('layout.header')
@stop

@section('content')
<div id="content_wrap">
    <div class="row">
        <div class="col-md-5 col-md-offset-3">
            {{ Form::open(array('url' => 'user/register', 'method' => 'post','class'=>'register_form')) }}
            <h2>@lang('app.signup')</h2>
            <div class="form-group">
                {{Form::label('username', trans('app.username') )}}
                {{Form::text('username', null,array('class' => 'form-control'))}}
            </div>
            <div class="form-group">
                {{Form::label('email',trans('app.email') )}}
                {{Form::text('email', null,array('class' => 'form-control'))}}
            </div>
            <div class="form-group">
                {{Form::label('twitter_account',trans('app.twitter_account') )}}
                {{Form::text('twitter_account', null,array('class' => 'form-control'))}}
            </div>
            <div class="form-group">
                {{Form::label('password',trans('app.password'))}}
                {{Form::password('password',array('class' => 'form-control'))}}
            </div>
            <div class="form-group">
                {{Form::label('password_confirmation',trans('app.repeat_password'))}}
                {{Form::password('password_confirmation',array('class' => 'form-control'))}}
            </div>
            {{Form::token()}}
            {{Form::submit(trans('app.register'), array('class' => 'btn btn-primary'))}}

            {{ Form::close() }}
        </div>
    </div>
</div>

@stop