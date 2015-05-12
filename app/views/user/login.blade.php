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
        <div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-body">

                    {{ Form::open(array('url' => 'user/login', 'method' => 'post','class'=>'login_form')) }}
                    <h2 class="text-center login-title">@lang('app.signin')</h2>
                    <div class="form-group">
                        {{Form::text('username', null,array('class' => 'form-control','placeholder'=>trans('app.username')))}}
                    </div>
                    <div class="form-group">
                        {{Form::password('password',array('class' => 'form-control','placeholder'=>trans('app.password')))}}
                    </div>
                    
                    <div class="form-action">
                           {{Form::submit(trans('app.login'), array('class' => 'btn btn-primary'))}} {{ link_to('user/register',trans('app.signup' ) ,array("class"=>"btn btn-success btn-xs")) }}
                    </div>        

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>

@stop

