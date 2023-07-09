
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Sign up - {{ app_name() }} </title>
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
     <p class="login-box-msg font-weight-bold"> Sign Up </p>
      
      @include("partials.alert_msg")
      <form action="{{ route('register_user') }}" method="post">
      @csrf()
        <input name="register_organization" value="1" type="hidden">
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
          <input type="password" name="password" required class="form-control" placeholder="Password******">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        
        <div class="input-group mb-3">
          @include('partials.all_states')
          
        </div>  

        <div class="input-group mb-3">
          <input type="text" name="organization_name" required value="" class="form-control" placeholder="Name of Organization...">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-home"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <textarea name="organization_description" required class="form-control" placeholder="Organization Description...."></textarea>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-edit"></span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-block btn-outline-success"> Create account </button>
          </div>
          <!-- /.col -->

          <div class="col-12 mt-3 text-center">
            <a href="{{ route('login')}}" class="text-sm text-muted"> Have account? Login </a>
          </div>
          <!-- /.col -->
          
          <!-- <div class="col-12 mt-3 text-center">
            <a href="javascript:void(0)" onClick="window.history.back()" class="text-sm text-muted"> Go back </a>
          </div> -->

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

