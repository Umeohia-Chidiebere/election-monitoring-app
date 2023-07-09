<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Login - {{ app_name() }} </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('login/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('login/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('login/dist/css/adminlte.min.css')}}">

</head>

<body class="hold-transition login-page bg-dark">
<div class="login-box">
  <div class="login-logo">
    <a href="#" class="text-white text-md"><b> <i class="fa fa-lock"></i> {{app_name() }} </b> </a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <center>
        <img src="{{ logo() }}" style="height:70px; width:auto;">
      </center>
     <p class="login-box-msg font-weight-bold"> Secured Login </p>
      
      @include("partials.alert_msg")
      <form action="{{ route('login_user') }}" method="post">
          @csrf()

          <div class="input-group mb-3">
          <input type="email" name="email" required value="" class="form-control" placeholder="Your Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>      

        <div class="input-group mb-3">
          <input type="password" name="password" required class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-block btn-outline-success"> Login </button>
          </div>
          <!-- /.col -->

          <div class="col-6 mt-3">
            <a href="{{ route('forgot_password_page')}}" class="text-sm text-muted"> Forgot Password? </a>
          </div>
          <!-- /.col -->

          <!-- col ---
            <div class="col-6 mt-3 text-center">
            <a href="{{ route('organization_registration_page') }}" class="text-sm text-muted"> Create Account</a>
            </div> 
            -->
          <!-- /.col -->

          <!-- <div class="col-12 mt-3 text-center">
            <a href="{{ route('user_registration_page') }}" class="text-sm text-muted"> New user? sign up ! </a>
          </div> -->
          <!-- /.col -->

        </div>
      </form>
      
      <!-- 
        <p class="mb-1">
         <a href="#">I forgot my password</a>
        </p> 
      -->
 
    </div>
    <!-- /.login-card-body -->
  </div>
</div>

</body>
</html>
