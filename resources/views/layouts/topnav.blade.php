<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('dashboard')}}" class="nav-link" style="color:#007bff;">Home</a>
      </li>
      
    </ul>

    <!-- <ul class="navbar-nav ml-auto">
      <li clases="">
        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          <img src="{{ URL::asset('assets/images/img.jpg') }}" alt="">{{ Auth::user()->name }} -->
          <!-- <span class=" fa fa-angle-down"></span> -->
        <!-- </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <li><a href="{{ route('profile') }}"> Profile</a></li>
          <li>
              <a href="{{ route('logout') }}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i> {{ __('Logout') }}
              </a>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
              </div>
          </li>
        </ul>
      </li>
    </ul> -->
         <p style="margin: 0 auto;font-weight:bold;font-size:24px;color:#007bff;">One Stop Solution</p>   
  </nav>
  