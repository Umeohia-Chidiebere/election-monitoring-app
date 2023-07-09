<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Language" content="en">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title> {{ app_name() }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
        <meta name="description" content="">
        <meta name="app name" id="app_name" content="{{ app_name() }}">
        <meta name="csrf token" id="csrf_token" content="{{ csrf_token() }}">
        <meta name="main party" id="main_party" content="{{ main_party() }}">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="theme-color" content="green" />
        <link rel="manifest" href="{{asset('app_manifest.json') }}">
         <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link href="{{ logo() }}" rel="shortcut icon" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">

   
{{-- JQUERY--}}
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    <link href="{{asset('assets/datatables/datatables.min.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('assets/datatables/datatables.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    
    <!-- Live Graph -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts" defer></script>
    <!-- live map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" defer integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    
    <!-- Push Notifications -->
    {{-- <script id="script">
        var s = document.createElement("script")
        s.src = "https://notix.io/ent/current/enot.min.js"
        s.onload = function (sdk) {
            sdk.startInstall({
                appId: "10055f62863b7cbc6648c4f4292b6c3",
                loadSettings: true
            })
        }
        document.head.append(s)
    </script> --}}
    <!-- //Push Notifications  -->
      
    <style>
        .float_2{
	position: fixed;
	width: 60px;
	height: 60px;
	bottom: 200px;
	right: 30px;
	border-radius: 50px;
	text-align: center;
	z-index: 1;
}
.float_btn_2{
	margin-top: 20px;
}
.text_pre_line{
  white-space: pre-line;
}
.cursor{ cursor: pointer;}
body::-webkit-scrollbar{
  display: none;
}
nav::-webkit-scrollbar{
  display: none;
}
section::-webkit-scrollbar{
  display: none;
}
div::-webkit-scrollbar{
  display: none;
}
.table-responsive::-webkit-scrollbar{
  display: none;
}
    </style>

<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  window.OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "537f9527-64bb-4124-9eb9-178c9e2a6dc7",
    });
  });
</script>

    </head>
@routes 
<body>

    <div id="v-app" >  
        <v-app style="background:whitesmoke;">
             <!-- ADD TO HOME SCREEN---->
        <a href="javascript:void(0)" class="float_2 add_to_homescreen_btn">
          <i style="color: green;" class="fa fa-download float_btn_2 fa-2x"></i>
        </a>
          <router-view></router-view>
        </v-app>
    </div>
          <!-- Add 2 homescreen -->
    <script type="text/javascript" src="{{ asset('add_to_homescreen.js') }}"></script>
    <script defer src="{{ mix('js/app.js') }}"></script>
</body>
</html>
