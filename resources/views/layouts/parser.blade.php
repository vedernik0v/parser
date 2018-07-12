<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="robots" content="noindex, nofollow">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Index</title>

  <!-- Styles -->
  <style>
    html,body{background-color:#fff;color:#636b6f;font-family:'Raleway', sans-serif;font-weight:100;height:100vh;margin:0;}
    .full-height{height: 100vh;}
    .flex-center{align-items:center;display:flex;justify-content:center;}
    .position-ref{position:relative;}
    .title{text-align:center;}
    .dev{display:none;}
    .alert-danger{color:red;border:1px solid red;border-radius:3px;}
    .alert-danger ul{padding:0 1.5em;}
  </style>
</head>
<body>
  <div class="flex-center position-ref full-height" id="app">
    @yield('content')
  </div>

@yield('js')
</body>
</html>
