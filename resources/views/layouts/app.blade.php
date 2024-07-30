<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{asset('public/front_assets/images/favicon.png')}}">
    <title> @yield('title') </title>

    <!--bootstarp -->
    @yield('style') 
<!--     <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> -->
</head>
<body class="hetero">
@yield('header') 

  @yield('content') 



@yield('footer') 

   <!-- Jquery-->
  @yield('script') 
  <!-- Jquery-->
</body>
</html>