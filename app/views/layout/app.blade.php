<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Blog::@yield('title')</title>

        
        <!-- Bootstrapt minified CSS -->
        <link rel="stylesheet" href="{{ asset('assets/lib/bootstrap/css/bootstrap.min.css') }}">
        <!-- bootstrap3_wysihtml5 minified CSS -->
        <link rel="stylesheet" href="{{ asset('assets/lib/bootstrap3_wysihtml5/bootstrap3-wysihtml5.min.css') }}">
        <!-- Fonts from Google Fonts-->
        <link href='http://fonts.googleapis.com/css?family=Oswald|Open+Sans:400,700,300' rel='stylesheet' type='text/css'>
        <!-- Style for application -->
        <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">

        @yield('style')
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        @yield('header')<!--Page header -->

        <!-- Flash alert section, show if exist -->
        @if ( Session::has('error') || Session::has('warning') || Session::has('notice') || Session::has('info'))
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    @if ( Session::has('error')  )
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ Session::get('error') }}
                    </div>
                    @endif
                    @if ( Session::has('warning')  )
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ Session::get('warning') }}
                    </div>
                    @endif
                    @if ( Session::has('notice')  )
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ Session::get('notice') }}
                    </div>
                    @endif
                    @if ( Session::has('info')  )
                    <div class="alert alert-info alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ Session::get('info') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <div id="page_wrap"><!--Global page warpper -->
            <div class="container">
                @yield('breadcrumb')
            </div>
            <div class="container">
                @yield('content')
            </div>
        </div><!--End Global page warpper -->


        <footer id="page_footer"><!--Page footer -->
            <div class="container">
                @yield('footer')
            </div>
        </footer><!--End Page footer -->

        @include('blog.modal')

        <!-- Load jquery library from google -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <!-- Bootstrap core JavaScript -->
        <script src="{{ asset('assets/lib/bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- Load Editor HTML bootstrap3 wysihtml5 -->
        <script src="{{ asset('assets/lib/bootstrap3_wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
        <!--MomentJs for Date javascript Libs-->
        <script src="{{ asset('assets/lib/moment-with-locales.min.js') }}"></script>
        <!--Linkify a jQuery plugin javascript Libs-->
        <script src="{{ asset('assets/lib/jquery.linkify.min.js') }}"></script>
        <!--bootstrap-notify plugin javascript Libs-->
        <script src="{{ asset('assets/lib/bootstrap-notify.min.js') }}"></script>
        
        <script>
            //Save logged user in javascript var
            @if (Auth::guest())
                var auth_user = {};
            @else
                var auth_user = {{ json_encode(Auth::user()->toArray()) }};
            @endif
        </script>
        
        <script src="{{ asset('assets/js/app.js') }}"></script>
        <!--Custom scripts section load-->
        @yield('script')

        <script>
        $(document).ready(function() {
            //include custom code when page ready
            @yield('js_on_ready')
        });
        </script>
    </body>
</html>
