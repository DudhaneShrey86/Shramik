<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
    <link rel="stylesheet" href="/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/css/index.css">
    <style media="screen">
      img{
        width: 100%;
      }
    </style>
  </head>
  <body>
    <header>
      <ul class="sidenav" id="side-menu">
        @if(Auth::user())
        <li><a class="waves-effect modal-trigger" href="#logoutmodal">Logout</a></li>
        @else
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
          <a href="{{ route('providers.logout') }}" class="btn modal-close waves-effect waves-light">Logout</a>
        </div>
      </div>
    </header>
    <main>
      <div class="container">
        <div class="row">
          <br>
          <div class="card col s12 l6 offset-l3">
            <div class="card-content center">
              <p class="card-title">Verify Your Email Address</p>
              <br>
              <div class="divider">

              </div>
              <br>
              <div>
                @if(session()->has('status') && session('status') == 'verification-link-sent')
                    <p style="margin: 10px;" class="green-text text-darken-1">A fresh verification link has been sent to your email address.</p>
                @endif
                <div class="center">
                  <img src="{{ asset('/images/mail.png') }}" alt="">
                </div>
                <p>
                  Before proceeding, please check your email for a verification link.
                </p>
                <p>If you did not receive an email, please click on the button below to get a new link</p>
              </div>
              <br>
              <form class="" method="POST" action="{{ route('verification.send') }}">
                  @csrf
                  <button type="submit" class="btn blue waves-effect waves-light">Click here to request another email</button>.
              </form>

            </div>
          </div>
        </div>
      </div>
    </main>
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
  </body>
</html>
