@forelse($entries as $entry)
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="blob_entry">
                <h2 class="title"> {{ link_to_action('EntryController@read', $entry->title , array("id"=>$entry->id),array("class"=>" ") )  }}</h2>
                <p class="date"><span class="glyphicon glyphicon-time"></span> {{ date('F j, Y, g:i a',$entry->time_created)  }}</p>
                <p class="author"><span class="glyphicon glyphicon-user"></span> @lang('app.by'): {{ link_to_action('UserController@profile',$entry->user->username , array("username"=>$entry->user->username) ) ; }}</p>
                <div class="content">
                    {{ str_limit($entry->content, $limit = 100, $end = '...') }}
                </div>
                <hr/>
                <p>@lang('app.tags'):
                    @foreach( $entry->get_tags_array() as $tag  )
                    <span class="label label-primary">{{ trim($tag) }}</span>
                    @endforeach
                </p>
                <div class="options pull-right">
                    {{ link_to_action('EntryController@read', trans("app.view_entry"), array("id"=>$entry->id),array("class"=>"btn btn-info load_modal") )  }}
                    @if ($entry->is_owner() )
                    {{ link_to_action('EntryController@update', trans("app.edit_entry"), array("id"=>$entry->id),array("class"=>"btn btn-primary ") )  }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@empty
    <p>@lang('app.empty_list'). {{ link_to('entry/new', "Create new entry", array("class"=>"btn btn-primary ")) }}</p>
@endforelse  
<!--Pgination-->
{{$entries->links()}}
