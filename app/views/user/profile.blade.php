@extends('layout.app')

@section('title')
@lang('app.entries_of', array('user'=>$user->username))
@endsection

@section("script")
    <script>
        var user = {{json_encode($user)}};
        //Javascript var for URL generate by laravel. 
        //This variables used in internal ajax function
        var route = {
            get_entries: '{{ action("UserController@profile",array("username"=>$user->username)) }}',
            get_tweet: '{{ action("UserController@getTwitterTimeline",array("username"=>$user->username)) }}',
            sync_tweets: '{{ action("UserController@syncTwitterTimeLine",array("username"=>$user->username,"count"=>5)) }}',
            toggle_tweet: '{{ action("UserController@toggle_tweet",array("username"=>$user->username)) }}',
        };
    </script>
    <!--Add script module for entries and user-->
    <script src="{{ asset('assets/js/modules/entry.js') }}"></script>
    <script src="{{ asset('assets/js/modules/user.js') }}"></script>
@stop

@section("header")
@include('layout.header')
@stop

@section("breadcrumb")
<ol class="breadcrumb">
    <li><a href="{{ url("/") }}">@lang('app.home')</a></li>
    <li><a href="{{ action('UserController@profile',array("username"=>$user->username) ) }}">{{ $user->username }}</a></li>
</ol>
@stop

@section('content')
<div id="content_wrap">
    <!--Header page title -->
    <div class="row">
        <div class="col-md-8">
            <h1 class="page-header">
                @lang('app.entries_of', array('user'=>$user->username))
            </h1>
        </div>
        <div class="col-md-4">
            <a class="btn btn-success btn-lg pull-right" href="{{ url('/entry/new') }}">@lang('app.create_new_entry')</a>
        </div>
    </div>

    <div class="row">
        <!-- List all entries -->
        <div class="col-md-8">
            <div id="entry_list">
                @include('entry.list')
            </div>
        </div>
        <!--Side bar -->
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">@lang('app.tweets', array('twitter_account'=>$user->twitter_account) ) <a href="javascript:void(0);" id="sync_tweets" class="pull-right"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> @lang('app.refresh')</a></div>
                <div class="panel-body">
                    <div id="twitter_timeline">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

<!--Add function in document reader-->
@section("js_on_ready")
APP.entry.register_local_handler();
APP.user.init();
@stop