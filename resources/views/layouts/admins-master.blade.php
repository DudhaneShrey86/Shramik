<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/admins.css">
    @yield('csslinks')
  </head>
  <body>
    <header>
      <ul class="sidenav sidenav-fixed" id="side-menu">
        <li>
          <div class="user-view">
            <a href="#email"><span class="username">{{Auth::user()->name ?? ''}}</span></a>
            <a href="#email"><span class="email">{{Auth::user()->email ?? ''}}</span></a>
          </div>
        </li>
        @include('partials.admins-sidemenu')
        <li><div class="divider"></div></li>
        @if(Auth::user())
        <li id="edit-user-{{ Auth::user()->id }}"><a class="waves-effect" href="{{ route('admins.edit', Auth::user()->id) }}">User Profile</a></li>
        <li><a class="waves-effect modal-trigger" href="#logoutmodal">Logout</a></li>
        @else
        <li><a class="waves-effect" href="/trustusers">Login</a></li>
        @endif
      </ul>
      <div class="navbar">
        <ul class="dropdown-content" id="userdropdown">
          <li><a href="#logoutmodal" class="modal-trigger">Logout</a></li>
        </ul>
        <nav class="blue darken-2">
          <div class="container nav-wrapper">
            <a href="{{ route('home') }}" class="brand-logo">Shramik</a>
            <a href="#!" data-target="side-menu" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
              @if(Auth::user())
              <li><a style="background: transparent !important">Hello {{Auth::user()->name}}</a></li>
              <li><a class="dropdown-trigger" href="#!" data-target="userdropdown"><i class="material-icons">account_circle</i></a></li>
              @else
              <li><a href="/admins">Login</a></li>
              @endif
            </ul>
          </div>
        </nav>
      </div>
      <div class="modal" id="logoutmodal">
        <div class="modal-content center">
          <i class="large material-icons white amber-text text-lighten-1 circle">info</i>
          <p class="flow-text">Are you sure you want to logout?</p>
        </div>
        <div class="modal-footer">
          <button class="btn modal-close waves-effect waves-light white teal-text">Cancel</button>
          <a href="{{ route('admins.logout') }}" class="btn modal-close waves-effect waves-light">Logout</a>
        </div>
      </div>
    </header>
    <main>
      <div class="container">

      </div>
      @yield('content')
    </main>
    <footer></footer>
    <script src="/js/jquery.js" charset="utf-8"></script>
    <script src="/js/materialize.min.js" charset="utf-8"></script>
    <script src="/js/index.js" charset="utf-8"></script>
    <script type="text/javascript">
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    </script>
    @yield('scripts')
  </body>
</html>
