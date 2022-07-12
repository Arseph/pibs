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

    <title>Login PIBS</title>
  </head>
  <body>
  

  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('{{ asset('public/login/images/bg.jpg') }}');"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7">
            <div class="mb-4">
              <h3 class="mt-3">Register</h3>
            </div>
            <form id="register_form" method="post">
                @csrf
              <div class="form-group first">
                User type
                <select class="form-control" name="level" required>
                    <option value="patient">Patient</option>
                </select>

              </div>
              <div class="form-group middle">
                <label for="fname">First name</label>
                <input type="text" class="form-control" name="fname" required>
              </div>
              <div class="form-group middle">
                <label for="mname">Middle name</label>
                <input type="text" class="form-control" name="mname" required>
              </div>
              <div class="form-group middle">
                <label for="lname">Last name</label>
                <input type="text" class="form-control" name="lname" required>
              </div>
              <div class="form-group middle">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" required>
              </div>
              <div class="form-group middle">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" required>
              </div>
              <div class="form-group last mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" required>
              </div>

              <input type="submit" value="REGISTER" class="btn btn-block btn-primary">
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
    <script src="{{ asset('public/assets/js/jquery.form.min.js') }}"></script>
    <script>
        $('#register_form').on('submit',function(e){
        e.preventDefault();
        $('#register_form').ajaxSubmit({
            url:  "{{ asset('register-account') }}",
            type: "POST",
            success: function(data){
                setTimeout(function(){
                    window.location.reload(false);
                },500);
            },
            error: function (data) {
                
            },
        });
    });
    </script>
  </body>
</html>