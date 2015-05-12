
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
                @lang('app.new_entry')
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
            <div class="panel panel-default">
                <div class="panel-body">
                    {{ Form::open(array('url' => 'entry/new', 'method' => 'post','class'=>'entry_form')) }}
                    <div class="form-group">
                        {{Form::label('title',trans('app.title'))}}
                        {{Form::text('title', null,array('class' => 'form-control'))}}
                    </div>
                    <div class="form-group">
                        {{Form::label('content',trans('app.content'))}}
                        {{Form::textarea('content', null,array('class' => 'form-control editor'))}}
                    </div>
                    <div class="form-group">
                        {{Form::label('tags',trans('app.tags'))}}
                        {{Form::text('tags', null,array('class' => 'tags form-control'))}}
                    </div>
                    {{Form::submit(trans('app.create_entry'), array('class' => 'btn btn-primary'))}}

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>

@stop