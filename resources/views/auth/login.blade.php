<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('public/login/fonts/icomoon/style.css') }}">

    <link rel="stylesheet" href="{{ asset('public/login/css/owl.carousel.min.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('public/login/css/bootstrap.min.css') }}">
    
    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('public/login/css/style.css') }}">

    <title>Login #6</title>
  </head>
  <body>
  

  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('{{ asset('public/login/images/bg.jpg') }}');"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7">
            <div class="mb-4">
              <h3>Log In</h3>
              <p class="mb-4">to start your session.</p>
            </div>
            <span class="help-block">
              @if($errors->any())
                  <strong style="color: #A52A2A;">{{$errors->first()}}</strong>
              @endif
            </span>
            <form method="POST" action="{{ asset('login') }}">
                @csrf
              <div class="form-group first">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" autocomplete="off">

              </div>
              <div class="form-group last mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password">
              </div>

              <input type="submit" value="LOGIN" class="btn btn-block btn-primary">
              <a href="{{ asset('register') }}" style="text-decoration: none;"><button type="button" class="btn btn-block btn-info mt-3">REGISTER</button></a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
    <script src="{{ asset('public/login/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('public/login/js/popper.min.js') }}"></script>
    <script src="{{ asset('public/login/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/login/js/main.js') }}"></script>
  </body>
</html>