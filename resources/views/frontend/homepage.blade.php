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
          <div class="logo"><a href="{{ route('homepage') }}"><img src="{{ URL::asset('assts/images/logo.png') }}"></a></div>
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
          <h1 class="banner_taital" style="color:orange">Data Management <br>Service</h1>
          <p class="banner_text" style="color:blue;font-family:sans-serif;"><b>We are into the business of data management from the past 25 years. 
We manage and give advice to our valued customers about the best investment plans and policy.
We will help you know your total investment  for the year in advance. We will also help you to know the details of your investments on a monthly basis. Our data management team will guide you to organise your investments and keep track of all the money you invest at your fingertips. </b></p>
          
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
            <h1 class="services_taital" style="color:red">RESEARCH, GUIDE, SERVICE AND EXPERTISE FOR OUR CUSTOMER</h1>
            <p class="services_text" style="color:blue;font-family:sans-serif;">Our research team has  worked hard to design this for you. With an experience of more than 25 years and guiding more than 10000 people we  are ready to grow and guide many more of our customers and help them invest right and get more returns.

Our expert team of managers will constantly guide you in different products. </p>
            
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
        <h1 class="what_taital" style="color: seagreen;">WHAT WE DO</h1>
        <p class="what_text" style="color: blue;font-family: sans-serif;font-size: 21px;">We manage your policy and all your investment data We Believe and Promote<span style="color:crimson;"> <b>DIGITAL INDIA</b></span>  </p><p class="what_text" style="color: blue;font-family: sans-serif;font-size: 21px;">Our research team giving Best advice to Our Customer.</p>
        <div class="what_we_do_section_2">
          <div class="row">
          <div class="col-lg-3 col-sm-6">
            <div class="box_main"  style="background-color: orange;">
              <div class="icon_1"><img src="{{ URL::asset('assts/images/icon-1.png') }}"></div>
              <h3 class="accounting_text" style="color: blue;font-size: 24px;font-family: cursive;">Mediclaim</h3>
              <p class="lorem_text" style="color:black;font-family:sans-serif;">Our aim is to find the best medical insurance plan for you and show you the lowest premium.</p>
              
            </div>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="box_main active" style="background-color: cadetblue;">
              <div class="icon_1"><img src="{{ URL::asset('assts/images/icon-2.png') }}"></div>
              <h3 class="accounting_text" style="color: chartreuse;font-size: 24px;font-family: cursive;">Life Insurance</h3>
              <p class="lorem_text" style="color:black;font-family:sans-serif;">We will inform you when - in which month - and how much is your premium.</p>
              
            </div>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="box_main"  style="background-color: coral;">
              <div class="icon_1"><img src="{{ URL::asset('assts/images/icon-3.png') }}"></div>
              <h3 class="accounting_text" style="color: purple;font-size: 24px;font-family: cursive;">Vehicle Insurance</h3>
              <p class="lorem_text" style="color:black;font-family:sans-serif;">All vehicle insurance information and suggestions for low premiums and reminders of all premiums</p>
              
            </div>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="box_main"  style="background-color: burlywood;">
              <div class="icon_1"><img src="{{ URL::asset('assts/images/icon-4.png') }}"></div>
              <h3 class="accounting_text" style="color: purple;font-size: 24px;font-family: cursive;">Mutual Fund</h3>
              <p class="lorem_text" style="color:black;font-family:sans-serif;">Mutual funds that give good interest and also information about which fund to invest in is free.</p>
              
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
            <h3 class="accounting_text_1">30+</h3>
            <p class="yers_text">Members Research Team</p>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="icon_1"><img src="{{ URL::asset('assts/images/icon-4.png') }}"></div>
            <h3 class="accounting_text_1">5000+</h3>
            <p class="yers_text">Data Management</p>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="icon_1"><img src="{{ URL::asset('assts/images/icon-2.png') }}"></div>
            <h3 class="accounting_text_1">2500+</h3>
            <p class="yers_text">Satisfied Customers</p>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="icon_1"><img src="{{ URL::asset('assts/images/icon-1.png') }}"></div>
            <h3 class="accounting_text_1">8+</h3>
            <p class="yers_text">Services</p>
          </div>
        </div>
      </div>
    </div>
    <!--project section end -->
    
   
    <!--footer section start -->
    <div class="footer_section layout_padding mt-3" style="background-color: bisque;">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-sm-6">
            <h4 class="about_text" style="color:#000">Contact Us</h4>
            <div class="location_text" style="color:#000"><img src="{{ URL::asset('assts/images/map-icon.png') }}"><span class="padding_left_15">Locations : Satellite, Ahmedabad.</span></div>
            
            <div class="location_text" style="color:#000"><img src="{{ URL::asset('assts/images/call-icon.png') }}"><span class="padding_left_15">+91 9173257965</span></div>
            <div class="location_text" style="color:#000"><img src="{{ URL::asset('assts/images/mail-icon.png') }}"><span class="padding_left_15">onestopsolutiondatamanagement@gmail.com</span></div>
          </div>
          <div class="col-lg-6 col-sm-6">
            <h4 class="about_text" style="color:#000">About Data Management</h4>
            <p class="dolor_text" style="color:#000">How long will you keep your financial information in diaries and Excel files?  Go digital and keep your important financial information and policies at hand - go digital and upgrade your financial information</p>
          </div>
          
          
          </div>
        </div>
        <!-- copyright section start -->
        <div class="copyright_section">
          <div class="copyright_text"  style="color:#000"><strong>Copyright &copy; 2024-{{now()->format('Y')}}</strong> All rights reserved.</div>
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