<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
      <img src="{{ URL::asset('assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">OSS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div> -->

      <!-- SidebarSearch Form -->
      <!-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      
      
        
      
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}"><i class="nav-icon fa fa-home"></i><p>Dashboard</p></a></li>
          @canany(['create-role', 'edit-role', 'delete-role'])
              <li class="nav-item"><a class="nav-link" href="{{ route('roles.index') }}"><i class="nav-icon fa fa-edit"></i><p>Manage Roles</p></a></li>
          @endcanany
          @canany(['create-user', 'edit-user', 'delete-user'])
              <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}"><i class="nav-icon fa fa-user" aria-hidden="true"></i><p>Manage Users</p></a></li>
          @endcanany
          @canany(['create-member', 'edit-member', 'delete-member'])
          <li class="nav-item"><a class="nav-link" href="{{ route('members.index') }}"><i class="nav-icon fa fa-user" aria-hidden="true"></i><p>Manage Member</p></a></li>          
          @endcanany
          <li class="nav-item"><a class="nav-link" href="{{ route('mediclaim.all_mediclaim') }}"><i class="nav-icon fa fa-hospital"></i><p>Mediclaim</p></a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('vehicle_insurance.all_vehicle_insurance') }}"><i class="nav-icon fa fa-car"></i><p>Vehicle Insurance</p></a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('life_insurance.all_life_insurance') }}"><i class="nav-icon fa fa-life-ring"></i><p>Life Insurance</p></a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('mutual_fund.all_mutual_fund') }}"><i class="nav-icon fa fa-dollar-sign"></i><p>Mutual Fund</p></a></li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('list_mediclaim_company') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Mediclaim Company</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('list_life_insurance_company') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Life Insurance Company</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('list_vehicle_insurance_company') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vehicle Insurance Company</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Profile Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('profile') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Profile Update</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('change_password') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Change Password</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();" class="nav-link"><i class="far fa-circle nav-icon"></i> {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>