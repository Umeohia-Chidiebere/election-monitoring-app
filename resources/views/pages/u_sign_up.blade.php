
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> User sign up - {{ app_name() }} </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('login/plugins/fontawesome-free/css/all.min.css ')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('login/plugins/icheck-bootstrap/icheck-bootstrap.min.css ')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('login/dist/css/adminlte.min.css ')}}">

</head>
<body class="hold-transition login-page bg-dark">
<div class="login-box">
  <div class="login-logo">
    <a href="#" class="text-white text-md"><b> <i class="fa fa-lock"></i> {{app_name() }} </b> </a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
     <p class="login-box-msg"> User Sign Up </p>
      
      @include("partials.alert_msg")
      <form action="{{ route('register_user') }}" method="post">
        <input type="hidden" name="new_user" value="1">
          @csrf()

        <div class="input-group mb-3">
          <input type="text" name="name" required value="" class="form-control" placeholder="Name (surname first)...">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>   

        <div class="input-group mb-3">
          <input type="email" name="email" required value="" class="form-control" placeholder="Your Email...">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="number" name="phone_number" required value="" class="form-control" placeholder="Phone number...">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>
        </div>
        
        <div class="input-group mb-3">
          @include('partials.all_lga')
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-map-marker"></span>
            </div>
          </div>
        </div>  

        <div class="input-group mb-3">
          <input type="password" name="password" required class="form-control" placeholder="Password******">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-block btn-outline-success"> Sign up </button>
          </div>
          <!-- /.col -->

          <div class="col-12 mt-3 text-center">
            <a href="{{ route('login')}}" class="text-sm text-muted"> Have account? Login </a>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- 
        <p class="mb-1">
         <a href="#">I forgot my password</a>
        </p> -->
 
    </div>
    <!-- /.login-card-body -->
  </div>
</div>

</body>
</html>
