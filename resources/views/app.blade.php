<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Muster</title>

    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/css/bootstrap-theme.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body role="document">
    @if( !Auth::guest() )
      <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Muster</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              @if( Auth::user()->can('league-show') )
                <li><a href="{{ route('leagues.index') }}">Leagues</a></li>
              @endif
              @if( Auth::user()->can('user-show') )
                <li><a href="{{ route('users.index') }}">Users</a></li>
              @endif
              @if( Auth::user()->can('event-show') )
                <li><a href="{{ route('events.index') }}">Audit Log</a></li>
              @endif
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ url('/auth/password-change') }}">Change Password</a></li>
                    <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                  </ul>
                </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </nav>
    @endif

    <div class="container" role="main">
      @if( Session::has('message') )
        <div class="flash alert-info">
          <p>{{ Session::get('message') }}</p>
        </div>
      @endif

      @if( $errors->any() || Session::has('error') )
        <div class='flash alert-danger'>
          @foreach( $errors->all() as $error )
            <p>{{ $error }}</p>
          @endforeach
          @if( Session::has('error') )
            <p>{{ Session::get('error') }}</p>
          @endif
        </div>
      @endif

      @yield('content')
    </div>
    @if( !Auth::guest() )
    <footer>
      <p style="text-align: right; padding: 10px 30px;"><a href="http://ukrda.org.uk/" target="_blank">United Kingdom Roller Derby Association</a></p>
    </footer>
    @endif
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
  </body>
</html>
