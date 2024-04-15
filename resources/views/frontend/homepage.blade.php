<!DOCTYPE html>
<html lang="en">
<head>
<!-- basic -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- mobile metas -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<!-- site metas -->
<title>OSSDM:One Stop Solution Data Management</title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content=""> 
<!-- bootstrap css -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assts/css/bootstrap.min.css') }}">
<!-- style css -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assts/css/style.css') }}">

<!-- Responsive-->
<link rel="stylesheet" href="{{ URL::asset('assts/css/responsive.css') }}">
<!-- fevicon -->
<link rel="icon" href="{{ URL::asset('assts/images/fevicon.png') }}" type="image/gif" />
<!-- Scrollbar Custom CSS -->
<link rel="stylesheet" href="{{ URL::asset('assts/css/jquery.mCustomScrollbar.min.css') }}">
<!-- Tweaks for older IEs-->
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
<!-- owl stylesheets --> 
<link rel="stylesheet" href="{{ URL::asset('assts/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assts/css/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
</head>
<body>
  <!--header section start -->
    <div class="header_section">
      <div class="header_left">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="logo"><a href="{{ route('homepage') }}"><img src="{{ URL::asset('assts/images/logo.jpeg') }}"></a></div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="nav-link" href="{{ route('homepage') }}">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
              </li>
            </ul>
          </div>
        </nav>
        <div class="banner_main">
          <h1 class="banner_taital">financial <br>Service</h1>
          <p class="banner_text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever </p>
          
        </div>
      </div>
      <div class="header_right">
        <img src="{{ URL::asset('assts/images/banner-img.png') }}" class="banner_img">
      </div>
    </div>
    <!--header section end -->
    <!--about section start -->
    <div class="services_section layout_padding">
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <h1 class="services_taital">WELCOME TO FINAnCIAL SERVICES</h1>
            <p class="services_text">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it </p>
            
          </div>
          <div class="col-md-4">
            <div><img src="{{ URL::asset('assts/images/img-1.png') }}" class="image_1"></div>
          </div>
        </div>
      </div>
    </div>
    <!--about section end -->
    <!--services section start -->
    <div class="what_we_do_section layout_padding">
      <div class="container">
        <h1 class="what_taital">WHAT WE DO</h1>
        <p class="what_text">It is a long established fact that a reader will be distracted by the readable content of a </p>
        <div class="what_we_do_section_2">
          <div class="row">
          <div class="col-lg-3 col-sm-6">
            <div class="box_main">
              <div class="icon_1"><img src="{{ URL::asset('assts/images/icon-1.png') }}"></div>
              <h3 class="accounting_text">Mediclaim</h3>
              <p class="lorem_text">Lorem Ipsum is simply dummy text of the printing and</p>
              
            </div>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="box_main active">
              <div class="icon_1"><img src="{{ URL::asset('assts/images/icon-2.png') }}"></div>
              <h3 class="accounting_text">Life Insurance</h3>
              <p class="lorem_text">Lorem Ipsum is simply dummy text of the printing and</p>
              
            </div>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="box_main">
              <div class="icon_1"><img src="{{ URL::asset('assts/images/icon-3.png') }}"></div>
              <h3 class="accounting_text">Vehicle Insurance</h3>
              <p class="lorem_text">Lorem Ipsum is simply dummy text of the printing and</p>
              
            </div>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="box_main">
              <div class="icon_1"><img src="{{ URL::asset('assts/images/icon-4.png') }}"></div>
              <h3 class="accounting_text">Mutual Fund</h3>
              <p class="lorem_text">Lorem Ipsum is simply dummy text of the printing and</p>
              
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
    <!--services section end -->
    <!--project section start -->
   
    <div class="project_section_2 layout_padding mt-3">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-sm-6">
            <div class="icon_1"><img src="{{ URL::asset('assts/images/icon-3.png') }}"></div>
            <h3 class="accounting_text_1">1000+</h3>
            <p class="yers_text">Years of Business</p>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="icon_1"><img src="{{ URL::asset('assts/images/icon-4.png') }}"></div>
            <h3 class="accounting_text_1">20000+</h3>
            <p class="yers_text">Projects Delivered</p>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="icon_1"><img src="{{ URL::asset('assts/images/icon-2.png') }}"></div>
            <h3 class="accounting_text_1">10000+</h3>
            <p class="yers_text">Satisfied Customers</p>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="icon_1"><img src="{{ URL::asset('assts/images/icon-1.png') }}"></div>
            <h3 class="accounting_text_1">1500+</h3>
            <p class="yers_text">Services</p>
          </div>
        </div>
      </div>
    </div>
    <!--project section end -->
    
   
    <!--footer section start -->
    <div class="footer_section layout_padding mt-3">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-sm-6">
            <h4 class="about_text">About Financial</h4>
            <div class="location_text"><img src="{{ URL::asset('assts/images/map-icon.png') }}"><span class="padding_left_15">Locations</span></div>
            <div class="location_text"><img src="{{ URL::asset('assts/images/call-icon.png') }}"><span class="padding_left_15">+01 9876543210</span></div>
            <div class="location_text"><img src="{{ URL::asset('assts/images/mail-icon.png') }}"><span class="padding_left_15">demo@gmail.com</span></div>
          </div>
          <div class="col-lg-6 col-sm-6">
            <h4 class="about_text">About Financial</h4>
            <p class="dolor_text">ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt</p>
          </div>
          
          
          </div>
        </div>
        <!-- copyright section start -->
        <div class="copyright_section">
          <div class="copyright_text"><strong>Copyright &copy; 2024-{{now()->format('Y')}}</strong> All rights reserved.</div>
        </div>
        
        
        <!-- copyright section end -->
      </div>
    </div>
    <!--footer section end -->
    <!-- Javascript files-->
    
    <script src="{{ URL::asset('assts/js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('assts/js/popper.min.js') }}"></script>
    <script src="{{ URL::asset('assts/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assts/js/jquery-3.0.0.min.js') }}"></script>
    <script src="{{ URL::asset('assts/js/plugin.js') }}"></script>
    
    <!-- sidebar -->
    <script src="{{ URL::asset('assts/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ URL::asset('assts/js/custom.js') }}"></script>
    <script src="{{ URL::asset('assts/js/owl.carousel.js') }}"></script>
    <!-- javascript --> 
    <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script> 
</body>
</html>