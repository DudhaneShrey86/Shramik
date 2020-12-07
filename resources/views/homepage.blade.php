<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shramik</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://kit.fontawesome.com/16df088500.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/materialize.min.css">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/homepage.css">
  </head>
  <body>
    <header>
      <ul class="sidenav" id="side-menu">
        <li class=""><a class="waves-effect" href="{{ route('consumers.login') }}">Login</a></li>
        <li class=""><a class="waves-effect" href="{{ route('consumers.register') }}">Sign Up</a></li>
      </ul>
      <div class="navbar">
        <ul class="dropdown-content" id="userdropdown">
          <li><a href="#">Logout</a></li>
        </ul>
        <nav class="blue darken-2">
          <div class="container nav-wrapper">
            <a href="{{ route('home') }}" class="brand-logo">Shramik</a>
            <a href="#!" data-target="side-menu" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
              <li><a href="{{ route('consumers.login') }}">Login</a></li>
              <li><a href="{{ route('consumers.register') }}">Sign Up</a></li>
            </ul>
          </div>
        </nav>
      </div>
      <div id="header-content">
        <div class="">
          <h3>Get the best out of your neighbouring services</h3>
        </div>
        <div class="header-buttons">
          <a href="{{ route('consumers.register') }}">Hire A Service</a>
          <a href="{{ route('providers.register') }}">Provide Services Online</a>
        </div>
      </div>
      <p class="center"><i class="material-icons small">expand_more</i> </p>
    </header>
    <main>
      <section id="workflow">
        <div class="container center">
          <h4>How It Works</h4>
          <div class="blank-div">

          </div>
          <div class="row"><br>
            <div class="col s12 l4">
              <div class="card z-depth-0">
                <div class="card-image">
                  <i class="material-icons large deep-purple-text">group</i>
                </div>
                <div class="card-content">
                  <p>
                    Search for a service and browse through the best providers in your neighbourhood
                  </p>
                </div>
              </div>
            </div>
            <div class="col s12 l4">
              <div class="card z-depth-0">
                <div class="card-image">
                  <i class="material-icons large green-text text-darken-2">assignment_turned_in</i>
                </div>
                <div class="card-content">
                  <p>
                    Hire a provider on or off-platform and get the job done
                  </p>
                </div>
              </div>
            </div>
            <div class="col s12 l4">
              <div class="card z-depth-0">
                <div class="card-image">
                  <i class="material-icons large blue-text text-darken-2">rate_review</i>
                </div>
                <div class="card-content">
                  <p>
                    Pay safely on or off-platform and submit a review for the provider
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section id="categories">
        <div class="container center">
          <h4>Categories</h4>
          <p>Get work done in these different categories.</p>
          <div id="categories-div">
            @forelse($types as $type)
            <p class="blue-text text-darken-4">{{ $type->name }}</p>
            @empty
            <p class="grey-text">No services found! Query Us</p>
            @endforelse
          </div>
          <p><small>*Query us if your service does not come under any of this categories</small> </p>
        </div>
      </section>
    </main>
    <footer class="blue darken-4">
      <div class="container center">
        <p id="footer-logo"><a href="{{ route('home') }}">Shramik</a></p>
        <div id="footer-grid">
          <div class="site-links">
            <p><b>Links</b></p>
            <p class="links"><a href="#">Home</a></p>
            <p class="links"><a href="#">About</a></p>
            <p class="links"><a href="#">Contact</a></p>
            <p class="links"><a href="#">Queries</a></p>
          </div>
          <div class="">
            <p><b>Follow us on</b></p>
            <p>
              <a href="#" class="social-links"><i class="fab fa-facebook-square"></i></i></a>
              <a href="#" class="social-links"><i class="fab fa-twitter-square"></i></a>
              <a href="#" class="social-links"><i class="fab fa-instagram-square"></i></a>
            </p>
          </div>
        </div>
        <div class="">
          <p><small>&copy; 2020 - Shramik</small></p>
        </div>
      </div>
    </footer>
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
