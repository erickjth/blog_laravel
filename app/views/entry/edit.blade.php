
@extends('layout.app')
@section('title')
Register user
@endsection

@section("header")
@include('layout.header')
@stop

@section('content')
<div id="content_wrap">
    <!--Header page title -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
            <h1 class="page-header">
                @lang('app.edit_entry')
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
            {{ Form::open(array('url' => action("EntryController@update",array("id"=>$entry->id )), 'method' => 'post','class'=>'entry_form')) }}
            <div class="form-group">
                {{Form::label('title',trans('app.title'))}}
                {{Form::text('title', $entry->title,array('class' => 'form-control'))}}
            </div>
            <div class="form-group">
                {{Form::label('content',trans('app.content'))}}
                {{Form::textarea('content', $entry->content,array('class' => 'form-control editor'))}}
            </div>
            <div class="form-group">
                {{Form::label('tags',trans('app.tags'))}}
                {{Form::text('tags', $entry->tags,array('class' => 'tags form-control'))}}
            </div>
            {{Form::submit(trans('app.update_entry'), array('class' => 'btn btn-primary'))}}

            {{ Form::close() }}
        </div>
    </div>
</div>
@stop