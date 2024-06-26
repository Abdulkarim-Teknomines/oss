<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
      <img src="{{ URL::asset('assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">OSS Data Management</span>
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
          <!-- @canany(['create-role', 'edit-role'])
              <li class="nav-item"><a class="nav-link" href="{{ route('roles.index') }}"><i class="nav-icon fa fa-edit"></i><p>Manage Roles</p></a></li>
          @endcanany -->
          @canany(['create-user', 'edit-user'])
              <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}"><i class="nav-icon fa fa-user" aria-hidden="true"></i><p>Manage Users</p></a></li>
          @endcanany
          
          @canany(['create-member', 'edit-member'])
          @if(Auth::User()->hasRole('Agent'))
          <li class="nav-item"><a class="nav-link" href="{{ route('members.index') }}"><i class="nav-icon fa fa-user" aria-hidden="true"></i><p>Manage Member</p></a></li>   
          @endif
          @endcanany
          
          @if(Auth::User()->hasRole('Super Admin'))
            <li class="nav-item">
              <a href="{{ route('admin_users.admin_list') }}" class="nav-link">
                <i class="fa fa-user nav-icon"></i>
                <p>Admin</p>
              </a>
            </li>
          @endif
          @if(Auth::User()->hasRole('Super Admin') || Auth::User()->hasRole('Admin'))
            <li class="nav-item">
              <a href="{{ route('manager_users.manager_list') }}" class="nav-link">
                <i class="fa fa-user nav-icon"></i>
                <p>Manager</p>
              </a>
            </li>
          @endif
          @if(Auth::User()->hasRole('Super Admin') || Auth::User()->hasRole('Admin') || Auth::User()->hasRole('Manager'))
            <li class="nav-item">
              <a href="{{ route('agent_users.agent_list') }}" class="nav-link">
                <i class="fa fa-user nav-icon"></i>
                <p>Agent</p>
              </a>
            </li>
          @endif
          @if(Auth::User()->hasRole('Super Admin') || Auth::User()->hasRole('Admin') || Auth::User()->hasRole('Manager') || Auth::User()->hasRole('Agent'))
          
            <li class="nav-item">
              <a href="{{ route('member_users.member_list') }}" class="nav-link">
                <i class="fa fa-user nav-icon"></i>
                <p>Member</p>
              </a>
            </li>
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-life-ring"></i>
              <p>
                Active / inActive Member
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('member.active_member') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Active Member</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('member.inactive_member') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>inActive Member</p>
                </a>
              </li>
            </ul>
          </li>
            <li class="nav-item"><a class="nav-link" href="{{ route('member_life_insurance') }}"><i class="nav-icon fa fa-life-ring"></i><p>Life Insurance Report</p></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('member_mediclaim') }}"><i class="nav-icon fa fa-hospital"></i><p>Mediclaim Report</p></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('member_vehicle_insurance') }}"><i class="nav-icon fa fa-car"></i><p>Vehicle Insurance Report</p></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('member_mutual_fund') }}"><i class="nav-icon fa fa-dollar-sign"></i><p>Mutual Fund Report</p></a></li>
          @endif
          @if(auth::User()->hasRole('Member'))
            <li class="nav-item"><a class="nav-link" href="{{ route('life_insurance.all_life_insurance') }}"><i class="nav-icon fa fa-life-ring"></i><p>Life Insurance</p></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('mediclaim.all_mediclaim') }}"><i class="nav-icon fa fa-hospital"></i><p>Mediclaim</p></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('vehicle_insurance.all_vehicle_insurance') }}"><i class="nav-icon fa fa-car"></i><p>Vehicle Insurance</p></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('mutual_fund.all_mutual_fund') }}"><i class="nav-icon fa fa-dollar-sign"></i><p>Mutual Fund</p></a></li>
          @endif
          @if(auth::User()->hasRole('Super Admin'))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-life-ring"></i>
              <p>
                Life Insurance
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            @php $date = Date('M'); @endphp
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('life_insurance.all_life_insurance_monthly') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('life_insurance.all_life_insurance_yearly') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Yearly Report</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-hospital"></i>
              <p>
                Mediclaim 
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('mediclaim.all_mediclaim_monthly') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('mediclaim.all_mediclaim_yearly') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Yearly Report</p>
                </a>
              </li>
              
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon  fa fa-car"></i>
              <p>
                Vehicle Insurance
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('vehicle_insurance.all_vehicle_insurance_monthly') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('vehicle_insurance.all_vehicle_insurance_yearly') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Yearly Report</p>
                </a>
              </li>
              
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon  fa fa-dollar-sign"></i>
              <p>
                Mutual Fund
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('mutual_fund.all_mutual_fund_monthly') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('mutual_fund.all_mutual_fund_yearly') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Yearly Report</p>
                </a>
              </li>
            </ul>
          </li>
        @else
            @if(auth::user()->department_id=="1")
                <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-life-ring"></i>
              <p>
                Life Insurance
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            @php $date = Date('M'); @endphp
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('life_insurance.all_life_insurance_monthly') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('life_insurance.all_life_insurance_yearly') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Yearly Report</p>
                </a>
              </li>
            </ul>
          </li>

            @endif
            @if(auth::user()->department_id=="2")
                            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-hospital"></i>
              <p>
                Mediclaim 
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('mediclaim.all_mediclaim_monthly') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('mediclaim.all_mediclaim_yearly') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Yearly Report</p>
                </a>
              </li>
              
            </ul>
          </li>
            @endif
            @if(auth::user()->department_id=="3")
                <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon  fa fa-car"></i>
              <p>
                Vehicle Insurance
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('vehicle_insurance.all_vehicle_insurance_monthly') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('vehicle_insurance.all_vehicle_insurance_yearly') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Yearly Report</p>
                </a>
              </li>
              
            </ul>
          </li>
            @endif
            @if(auth::user()->department_id=="4")
                 <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon  fa fa-dollar-sign"></i>
              <p>
                Mutual Fund
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('mutual_fund.all_mutual_fund_monthly') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('mutual_fund.all_mutual_fund_yearly') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Yearly Report</p>
                </a>
              </li>
            </ul>
          </li>
            @endif
        @endif
         
         @if(Auth::User()->hasRole('Member')=="Member")
         <li class="nav-item">
             <a href="{{ route('members.reports',Auth::User()->id) }}" class="nav-link">
               <i class="fa fa-book nav-icon"></i>
               <p>Annual Report</p>
             </a>
         </li>
         @endif
          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Mediclaim
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('list_mediclaim_company') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Yearly</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('list_life_insurance_company') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly</p>
                </a>
              </li>
              
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Life Insurance
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('list_mediclaim_company') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Yearly</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('list_life_insurance_company') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly</p>
                </a>
              </li>
              
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Vehicle Insurance
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('list_mediclaim_company') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Yearly</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('list_life_insurance_company') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly</p>
                </a>
              </li>
              
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Mutual Fund
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('list_mediclaim_company') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Yearly</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('list_life_insurance_company') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly</p>
                </a>
              </li>
              
            </ul>
          </li> -->
          @canany(['create-company', 'edit-company'])
          @if(Auth::User()->hasRole('Super Admin'))
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
          @endif
          @endcanany
          
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
              document.getElementById('logout-form').submit();" class="nav-link"><i class="fa fa-user nav-icon"></i> {{ __('Logout') }}
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