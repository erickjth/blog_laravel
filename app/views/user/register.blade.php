@extends('layout.app')

@section('title')
@lang('app.signup')
@endsection

@section("header")
@include('layout.header')
@stop

@section('content')
<div id="content_wrap">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    {{ Form::open(array('url' => 'user/register', 'method' => 'post','class'=>'register_form')) }}
                    <h2 class="text-center login-title">@lang('app.signup')</h2>
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
                    
                    <div class="form-action">
                        {{Form::submit(trans('app.register'), array('class' => 'btn btn-primary'))}}
                    </div>       
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>

@stop