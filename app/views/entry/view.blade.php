
@extends('layout.app')
@section('title')
Register user
@endsection

@section("header")
@include('layout.header')
@stop

@section("breadcrumb")
<ol class="breadcrumb">
    <li><a href="{{ url("/") }}">@lang('app.home')</a></li>
    <li><a href="{{ action('UserController@profile',array("username"=>$entry->user->username) ) }}">{{ $entry->user->username }}</a></li>
    <li><a href="{{ action('EntryController@read', array("id"=>$entry->id)) }}">{{ $entry->title }}</a></li>
</ol>
@stop

@section('content')
<div id="content_wrap">
    <!--Header page title -->
    <div class="row">
        <div class="col-md-12  ">
            <h1 class="page-header">
                {{ $entry->title  }}
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 ">
            <div class="blob_entry">
                <h1 class="title"></h1>
                <p class="date"><span class="glyphicon glyphicon-time"></span> {{ date('F j, Y, g:i a',$entry->time_created)  }}</p>
                <p class="author"><span class="glyphicon glyphicon-user"></span> @lang('app.by'): {{ link_to_action('UserController@profile',$entry->user->username , array("username"=>$entry->user->username) ) }}</p>
                <div class="content">
                    {{ $entry->content }}
                </div>
                <p>@lang('app.tags'): 
                    @foreach( $entry->get_tags_array() as $tag  )
                    <span class="label label-primary">{{ $tag }}</span>
                    @endforeach
                </p>
                <div class="options pull-right">
                    {{ link_to_action('UserController@profile',trans('app.go_back') , array("username"=>$entry->user->username), array("class"=>"btn btn-primary") ) }}
                    @if ($entry->is_owner() )
                    {{ link_to_action('EntryController@update', trans("app.edit_entry"), array("id"=>$entry->id),array("class"=>"btn btn-primary ") ) ; }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@stop