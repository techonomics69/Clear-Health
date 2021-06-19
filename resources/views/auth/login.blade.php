
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <!-- <meta name="description" content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
  <meta name="keywords" content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app"> -->
  <meta name="author" content="PIXINVENT">
  <title>clearHealth | Login</title>
   <!-- <link rel="apple-touch-icon" href="{{ asset('theme/logo.png') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('theme/logo.png') }}"> -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
  rel="stylesheet">
  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/css/vendors.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/vendors/css/forms/icheck/icheck.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/vendors/css/forms/icheck/custom.css') }}">
  <!-- END VENDOR CSS-->
  <!-- BEGIN STACK CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/css/app.css') }}">
  <!-- END STACK CSS-->
  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/css/core/colors/palette-gradient.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/css/pages/login-register.css') }}">
  <!-- END Page Level CSS-->
  <!-- BEGIN Custom CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('theme/assets/css/style.css') }}">
  <!-- END Custom CSS-->
</head>
<body class="vertical-layout vertical-menu 1-column  bg-cyan bg-lighten-2 menu-expanded blank-page blank-page"
data-open="click" data-menu="vertical-menu" data-col="1-column">
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="flexbox-container">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-md-4 col-10 box-shadow-2 p-0">
              <div class="card border-grey border-lighten-3 m-0">
                <div class="card-header border-0">
                  <div class="card-title text-center">
                    <div class="p-1">
                      <img src="{{ asset('theme/logo.png') }}" alt="ClearHealth logo">

                      
                      <!-- <h4>ClearHealth</h4> -->
                    </div>
                  </div>
                  <!-- <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                    <span>Easily Using</span>
                  </h6> -->
                </div>
                <div class="card-content">
                  <!-- <div class="card-body pt-0 text-center">
                    <a href="#" class="btn btn-social mb-1 mr-1 btn-outline-facebook">
                      <span class="fa fa-facebook"></span>
                      <span class="px-1">facebook</span>
                    </a>
                    <a href="#" class="btn btn-social mb-1 mr-1 btn-outline-google">
                      <span class="fa fa-google-plus font-medium-4"></span>
                      <span class="px-1">google</span>
                    </a>
                  </div>
                  <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2">
                    <span>OR Using Account Details</span>
                  </p> -->
                  
                 

                  

                  <div class="card-body pt-0 mylogin">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                      @csrf
                      <fieldset class="form-group floating-label-form-group">
                        <label for="user-name">Email address</label>
                        <input type="text" class="form-control" id="user-name" placeholder="Email address" name="email">
                      </fieldset>
                      <fieldset class="form-group floating-label-form-group mb-1">
                        <label for="user-password">Password</label>
                        <input type="password" class="form-control" id="user-password" name="password" placeholder="Password">
                      </fieldset>
                      <div class="form-group row">
                        <div class="col-md-12 col-12 text-center text-sm-left">
                             @error(session('error'))
                               @foreach($errors->all() as $error)
                                  {{$error}}
                               @endforeach
                            @enderror
                        </div>
                        
                      </div>
                      <!-- <button type="submit" class="btn btn-outline-primary btn-block"><i class="ft-unlock"></i> Login</button> -->
                      <button type="submit" class="btn btn-secondry btn-block"><i class="ft-unlock"></i> Login</button>

                     
                    </form>
                  </div>
                  <!-- <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                    <span>New to Stack ?</span>
                  </p> -->
                  <!-- <div class="card-body">
                    <a href="register-with-bg.html" class="btn btn-outline-danger btn-block"><i class="ft-user"></i> Register</a>
                  </div> -->
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>

  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <!-- BEGIN VENDOR JS-->
  <script src="{{ asset('theme/app-assets/vendors/js/vendors.min.js') }}" type="text/javascript"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="{{ asset('theme/app-assets/vendors/js/forms/icheck/icheck.min.js') }}" type="text/javascript"></script>
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN STACK JS-->
  <script src="{{ asset('theme/app-assets/js/core/app-menu.js') }}" type="text/javascript"></script>
  <script src="{{ asset('theme/app-assets/js/core/app.js') }}" type="text/javascript"></script>
  <!-- <script src="{{ asset('theme/app-assets/js/scripts/customizer.js') }}" type="text/javascript"></script> -->
  <!-- END STACK JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <script src="{{ asset('theme/app-assets/js/scripts/forms/form-login-register.js') }}" type="text/javascript"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script type="text/javascript">
  
  </script>
  <!-- END PAGE LEVEL JS-->
</body>
</html>