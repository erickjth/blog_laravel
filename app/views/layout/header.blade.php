<div id="page_header"><!-- Page header  -->
    <div class="container">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top_menu">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('/') }}">Blog</a>
                </div>

                
                <div class="collapse navbar-collapse" id="top_menu">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{ url('/entry/new') }}">@lang('app.create_new_entry')</a></li>
                        @if (Auth::check())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">@lang('app.hello') {{Auth::User()->username}} <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ action('UserController@profile',array("username"=>Auth::User()->username) ); }}">@lang('my_profile')</a></li>
                                <li class="divider"></li>
                                <li><a href="{{ url('/user/logout') }}">@lang('app.logout')</a></li>
                            </ul>
                        </li>
                        @else
                        <li><a href="{{ url('/user/login') }}">@lang('app.login')</a></li>
                        <li><a href="{{ url('/user/register') }}">@lang('app.register')</a></li>
                        @endif
                    </ul>
                </div>
                
            </div>
        </nav>
    </div><!-- End Page header  -->
</div>