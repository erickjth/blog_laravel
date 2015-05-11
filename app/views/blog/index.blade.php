@extends('layout.app')

@section('title')
@lang('app.entries')
@endsection

@section("script")
<script>
    //Javascript var for URL generate by laravel. 
    //This variables used in internal ajax function
    var route = {
        get_entries : '{{ action("HomeController@index") }}',
    }
</script>
@stop

@section("header")
    @include('layout.header')
@stop

@section("breadcrumb")
<ol class="breadcrumb">
    <li><a href="{{ url("/") }}">@lang('app.home')</a></li>
</ol>
@stop

@section('content')
<!--Header page title -->
<div class="row">
    <div class="col-md-8">
        <h1 class="page-header">
            @lang('app.blog_entries_list')
        </h1>
    </div>
    <div class="col-md-4">
        <a class="btn btn-success btn-lg pull-right " href="{{ url('/entry/new') }}">@lang('app.create_new_entry')</a>
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
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.entries_by_user')</div>
            <ul class="list-group">
                @foreach( $users as $user )
                <li class="list-group-item">
                    <a href="{{ action('UserController@profile', array("username"=>$user->username) ) ; }}">
                        {{ $user->username }}
                        <span class="badge pull-right">{{ count( $user->entries  ) }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.tags')</div>
            <ul class="list-group">
                
            </ul>
        </div>
    </div>
</div>
@stop
<!--Add function in document reader-->
@section("js_on_ready")
    APP.entry.register_local_handler();
@stop