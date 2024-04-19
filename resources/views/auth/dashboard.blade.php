@extends('layouts.default')
@section('content')
<div class="card pt-3">
  <div class="card-body">
<section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        @if(Auth::User()->hasRole('Member'))
        <div class="row">
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-orange">
              <div class="inner">
                <h3 style="color:#fff">{{$mediclaim_count+$life_insurance_count+$vehicle_insurance_count+$mutual_fund_count}}</h3>
                <p style="color:#fff">Total Policy</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
               <a href="javascript:void(0)" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a> 
            </div>

          </div>
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-pink">
              <div class="inner">
                <h3  style="color:#fff">{{$mediclaim_premium+$lifeinsurance_premium+$vehicleinsurance_premium+$mutualfund_premium}}</h3>
                <p  style="color:#fff">Annual Payment Premium</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
               <a href="javascript:void(0)" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a> 
            </div>

          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-purple">
              <div class="inner">
                <h3 style="color:#fff">{{$mediclaim_count}}</h3>
                <p style="color:#fff">Mediclaim</p>
              </div>
              <div class="icon"> 
                <i class=" fa fa-hospital"></i>
              </div>
              <a href="{{route('mediclaim.all_mediclaim')}}" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box  -->
            <div class="small-box bg-green">
              <div class="inner">
                <h3 style="color:#fff">{{$life_insurance_count}}</h3>
                <p style="color:#fff">Life Insurance</p>
              </div>
              <div class="icon">
                <i class="fa fa-life-ring"></i>
              </div>
              <a href="{{route('life_insurance.all_life_insurance')}}" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div> 
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3  style="color:#fff">{{$vehicle_insurance_count}}</h3>
                <p  style="color:#fff">Vehicle Insurance</p>
              </div>
              <div class="icon">
                <i class="fa fa-car"></i>
              </div>
              <a href="{{route('vehicle_insurance.all_vehicle_insurance')}}" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3 style="color:#fff">{{$mutual_fund_count}}</h3>
                <p style="color:#fff">Mutual Fund</p>
              </div>
              <div class="icon">
                <i class=" fa fa-dollar-sign"></i>
              </div>
              <a href="{{route('mutual_fund.all_mutual_fund')}}" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-purple">
              <div class="inner">
                <h3  style="color:#fff">{{$mediclaim_premium}}</h3>
                <p  style="color:#fff">Mediclaim Premium</p>
              </div>
              <div class="icon">
                <i class="fa fa-hospital"></i>
              </div>
              <a href="{{route('mediclaim.all_mediclaim')}}" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h3  style="color:#fff">{{$lifeinsurance_premium}}</h3>
                <p  style="color:#fff">Life Insurance Premium</p>
              </div>
              <div class="icon">
                <i class="fa fa-life-ring"></i>
              </div>
              <a href="{{route('life_insurance.all_life_insurance')}}" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3  style="color:#fff">{{$vehicleinsurance_premium}}</h3>
                <p  style="color:#fff">Vehicle Insurance Premium</p>
              </div>
              <div class="icon">
                <i class="fa fa-car"></i>
              </div>
              <a href="{{route('vehicle_insurance.all_vehicle_insurance')}}" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3 style="color:#fff">{{$mutualfund_premium}}</h3>
                <p style="color:#fff">Mutual Fund Premium</p>
              </div>
              <div class="icon">
                <i class=" fa fa-rupee-sign"></i>
              </div>
              <a href="{{route('mutual_fund.all_mutual_fund')}}" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
      </div>

      
      <div class="row">
              <div class="col-md-6">
                <!-- DIRECT CHAT -->
                <div class="card ">
                  <div class="card-header  bg-green">
                    <h3 class="card-title" style="font-weight:bold;font-size:24px;">Agent Contact Details</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus" style="color:#fff;"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <!-- Conversations are loaded here -->
                    <div class="row">
                    <div class="col-md-12" style="padding:0px 0px 0px 25px;font-weight:bold;font-size:24px;color:#007bff;">
                      <h4 style="font-weight:bold;font-size:24px;">Name : {{isset($agent_details[0]->name)?$agent_details[0]->name:''}} </h4>
                      <h4 style="font-weight:bold;font-size:24px;">Mobile Number : {{isset($agent_details[0]->mobile_number)?$agent_details[0]->mobile_number:''}}</h4>
                      <h4 style="font-weight:bold;font-size:24px;">Email ID : {{isset($agent_details[0]->email)?$agent_details[0]->email:''}}</h4>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <!-- USERS LIST -->
                <div class="card">
                <div class="card-header bg-green">
                    <h3 class="card-title" style="font-weight:bold;font-size:24px;">Manager Contact Details</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus" style="color:#fff;"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12" style="padding:0px 0px 0px 25px;color:#007bff;">
                        <h4 style="font-weight:bold;font-size:24px;">Name : {{isset($manager_details[0]->name)?$manager_details[0]->name:''}}</h4>
                        <h4 style="font-weight:bold;font-size:24px;">Mobile Number : {{isset($manager_details[0]->mobile_number)?$manager_details[0]->mobile_number:''}}</h4>
                        <h4 style="font-weight:bold;font-size:24px;">Email ID : {{isset($manager_details[0]->email)?$manager_details[0]->email:''}}</h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          @else
          <div class="row">
          @if(Auth::User()->hasRole('Super Admin')|| Auth::User()->hasRole('Admin')|| Auth::User()->hasRole('Manager')|| Auth::User()->hasRole('Agemt'))
          @if(Auth::User()->hasRole('Super Admin'))
          <div class="col-lg-3 col-6">
          @endif
          @if(Auth::User()->hasRole('Admin'))
          <div class="col-lg-4 col-6">
          @endif
          @if(Auth::User()->hasRole('Manager'))
          <div class="col-lg-6 col-6">
          @endif
          @if(Auth::User()->hasRole('Agent'))
          <div class="col-lg-12 col-6">
          @endif
            <!-- small box -->
            <div class="small-box bg-gray">
              <div class="inner">
                <h3 style="color:#fff">{{$users}}</h3>
                <p style="color:#fff">Users</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{route('users.index')}}" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          @endif
          @if(Auth::User()->hasRole('Super Admin'))
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-orange">
              <div class="inner">
                <h3 style="color:#fff">{{$admin}}</h3>
                <p style="color:#fff">Admin</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{route('admin_users.admin_list')}}" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          @endif
          @if(Auth::User()->hasRole('Super Admin') || Auth::User()->hasRole('Admin'))
          @if(Auth::User()->hasRole('Super Admin'))
          <div class="col-lg-3 col-6">
            @endif
          @if(Auth::User()->hasRole('Admin'))
          <div class="col-lg-4 col-6">
          @endif
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3 style="color:#fff">{{$manager}}</h3>

                <p style="color:#fff">Manager</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{route('manager_users.manager_list')}}" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          @endif
          
          @if(Auth::User()->hasRole('Super Admin') || Auth::User()->hasRole('Admin')||Auth::User()->hasRole('Manager'))
          
          @if(Auth::User()->hasRole('Super Admin'))
          <div class="col-lg-3 col-6">
          @endif
          @if(Auth::User()->hasRole('Admin'))
          <div class="col-lg-4 col-6">
          @endif
          @if(Auth::User()->hasRole('Manager'))
          <div class="col-lg-6 col-6">
          @endif
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3  style="color:#fff">{{$agent}}</h3>
                <p  style="color:#fff">Agent</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{route('agent_users.agent_list')}}" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>

          </div>
          @endif
        </div>
        
        <div class="row">
          <div class="col-lg-4 col-4">
            <!-- small box -->
            <div class="small-box bg-purple">
              <div class="inner">
                <h3  style="color:#fff">{{$member_count}}</h3>
                <p  style="color:#fff">Member</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{route('members.index')}}" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-4">
            <!-- small box -->
            <div class="small-box bg-orange">
              <div class="inner">
                <h3  style="color:#fff">{{$mediclaim_count+$life_insurance_count+$vehicle_insurance_count+$mutual_fund_count}}</h3>
                <p  style="color:#fff">Total Policy</p>
              </div>
              <div class="icon">
                <i class="ion-stats-bars"></i>
              </div>
               <a href="javascript:void(0)" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a> 
            </div>

          </div>
          <div class="col-lg-4 col-4">
            <!-- small box -->
            <div class="small-box bg-pink">
              <div class="inner">
              <h3 style="color:#fff">{{$mediclaim_premium+$lifeinsurance_premium+$vehicleinsurance_premium+$mutualfund_premium}}</h3>
                <p style="color:#fff">Annual Payment Premium</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
               <a href="javascript:void(0)" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a> 
            </div>

          </div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-purple">
              <div class="inner">
                <h3 style="color:#fff">{{$mediclaim_count}}</h3>
                <p style="color:#fff">Mediclaim</p>
              </div>
              <div class="icon">
                <i class="fa fa-hospital"></i>
              </div>
              <a href="{{route('member_mediclaim')}}" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box  -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3 style="color:#fff">{{$life_insurance_count}}</h3>
                <p style="color:#fff">Life Insurance</p>
              </div>
              <div class="icon">
                <i class="fa fa-life-ring"></i>
              </div>
              <a href="{{route('member_life_insurance')}}" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div> 
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3 style="color:#fff">{{$vehicle_insurance_count}}</h3>
                <p style="color:#fff">Vehicle Insurance</p>
              </div>
              <div class="icon">
                <i class="fa fa-car"></i>
              </div>
              <a href="{{route('member_vehicle_insurance')}}" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3 style="color:#fff">{{$mutual_fund_count}}</h3>
                <p style="color:#fff">Mutual Fund</p>
              </div>
              <div class="icon">
                <i class="fa fa-rupee-sign"></i>
              </div>
              <a href="{{route('member_mutual_fund')}}" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-purple">
              <div class="inner">
                <h3 style="color:#fff">{{$mediclaim_premium}}</h3>
                <p style="width:50%;color:#fff">Mediclaim Yearly Premium</p>
              </div>
              <div class="icon">
                <i class="fa fa-hospital"></i>
              </div>
              <a href="{{route('member_mediclaim')}}" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h3>{{$lifeinsurance_premium}}</h3>
                <p style="width:50%;color:#fff">Life Insurance Yearly Premium</p>
              </div>
              <div class="icon">
                <i class="fa fa-life-ring"></i>
              </div>
              <a href="{{route('member_life_insurance')}}" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3>{{$vehicleinsurance_premium}}</h3>
                <p style="width:50%;color:#fff">Vehicle Insurance Yearly Premium</p>
              </div>
              <div class="icon">
                <i class="fa fa-car"></i>
              </div>
              <a href="{{route('member_vehicle_insurance')}}" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3 style="color:#fff">{{$mutualfund_premium}}</h3>
                <p style="width:50%;color:#fff">Mutual Fund Yearly Premium</p>
              </div>
              <div class="icon">
                <i class="fa fa-rupee-sign"></i>
              </div>
              <a href="{{route('member_mutual_fund')}}" class="small-box-footer" style="color:#fff">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        @if(Auth::User()->hasRole('Super Admin'))
        <div class="row">
            
        <div class="col-md-3 col-sm-12">
          <div class="card">
            <div class="card-header border-transparent bg-red">
              <h3 class="card-title">Member Birth Date</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0 member_birth_date" >
                  <thead>
                  <tr>
                    <th>Member Name</th>
                    <th>Birth Date</th>
                  </tr>
                  </thead>
                  <tbody>
                    @forelse($member_birth_date as $med)
                    <tr>
                      <td><input type="hidden" value="{{$med['name']}}" class="member_name">
                      <input type="hidden" value="{{$med['birth_date']}}" class="member_birth_dates">
                      <input type="hidden" value="{{$med['added_by']}}" class="added_by">
                      <input type="hidden" value="{{$med['father_name']}}" class="father_name">
                      <input type="hidden" value="{{$med['mother_name']}}" class="mother_name">
                      <input type="hidden" value="{{$med['spouse_name']}}" class="spouse_name">
                      <input type="hidden" value="{{$med['spouse_dob']}}" class="spouse_dob">
                      <input type="hidden" value="{{$med['anniversary_date']}}" class="anniversary_date">
                      <input type="hidden" value="{{$med['mobile_number']}}" class="member_mobile_number">
                      <input type="hidden" value="{{$med['email_id']}}" class="member_email_id">
                      {{$med['name']}}</td>
                      <td>{{$med['birth_date']}}</td>
                    </tr>
                    @empty
                    <tr><td>No Record Found</td></tr>
                  @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
       
        <div class="col-md-3 col-sm-12">
          <div class="card">
            <div class="card-header border-transparent bg-red">
              <h3 class="card-title">Member Anniversary Date</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0 member_anniversary_date">
                  <thead>
                  <tr>
                    <th>Member Name</th>
                    <th>Anniversary Date</th>
                  </tr>
                  </thead>
                  <tbody>
                    
                    @forelse($member_anniversary_date as $med)
                  <tr>
                  
                    <td><input type="hidden" value="{{$med['name']}}" class="member_name">
                      <input type="hidden" value="{{$med['birth_date']}}" class="member_birth_dates">
                      <input type="hidden" value="{{$med['father_name']}}" class="father_name">
                      <input type="hidden" value="{{$med['added_by']}}" class="added_by">
                      <input type="hidden" value="{{$med['mother_name']}}" class="mother_name">
                      <input type="hidden" value="{{$med['spouse_name']}}" class="spouse_name">
                      <input type="hidden" value="{{$med['spouse_dob']}}" class="spouse_dob">
                      <input type="hidden" value="{{$med['anniversary_date']}}" class="anniversary_date">
                      <input type="hidden" value="{{$med['mobile_number']}}" class="member_mobile_number">
                      <input type="hidden" value="{{$med['email_id']}}" class="member_email_id">
                  {{$med['name']}}</td>
                    <td>{{$med['anniversary_date']}}</td>
                  </tr>
                    @empty
                    <tr><td>No Record Found</td></tr>
                  @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-12">
          <div class="card">
            <div class="card-header border-transparent bg-red">
              <h3 class="card-title">Member Spouse Birth Date</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0 spouse_dob">
                  <thead>
                  <tr>
                    <th>Member Name</th>
                    <th>Spouse Birth Date</th>
                  </tr>
                  </thead>
                  <tbody>
                    
                    @forelse($member_spouse_date as $med)
                  <tr>
                    <td>
                    <input type="hidden" value="{{$med['name']}}" class="member_name">
                      <input type="hidden" value="{{$med['birth_date']}}" class="member_birth_dates">
                      <input type="hidden" value="{{$med['father_name']}}" class="father_name">
                      <input type="hidden" value="{{$med['added_by']}}" class="added_by">
                      <input type="hidden" value="{{$med['mother_name']}}" class="mother_name">
                      <input type="hidden" value="{{$med['spouse_name']}}" class="spouse_name">
                      <input type="hidden" value="{{$med['spouse_dob']}}" class="spouse_dob">
                      <input type="hidden" value="{{$med['anniversary_date']}}" class="anniversary_date">
                      <input type="hidden" value="{{$med['mobile_number']}}" class="member_mobile_number">
                      <input type="hidden" value="{{$med['email_id']}}" class="member_email_id">{{$med['name']}}</td>
                    <td>{{$med['spouse_dob']}}</td>
                  </tr>
                    @empty
                    <tr><td>No Record Found</td></tr>
                  @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-12">
          <div class="card">
            <div class="card-header border-transparent bg-red">
              <h3 class="card-title">Member Child Birth Date</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0 child_dob">
                  <thead>
                  <tr>
                    <th>Member Name</th>
                    <th>Child Name</th>
                    <th>Child Birth Date</th>
                  </tr>
                  </thead>
                  <tbody>
                    
                    @forelse($child_birth_date as $med)
                  <tr>
                    <td>
                    <input type="hidden" value="{{$med['name']}}" class="member_name">
                      <input type="hidden" value="{{$med['birth_date']}}" class="member_birth_dates">
                      <input type="hidden" value="{{$med['father_name']}}" class="father_name">
                      <input type="hidden" value="{{$med['added_by']}}" class="added_by">
                      <input type="hidden" value="{{$med['mother_name']}}" class="mother_name">
                      <input type="hidden" value="{{$med['spouse_name']}}" class="spouse_name">
                      <input type="hidden" value="{{$med['spouse_dob']}}" class="spouse_dob">
                      <input type="hidden" value="{{$med['anniversary_date']}}" class="anniversary_date">
                      <input type="hidden" value="{{$med['mobile_number']}}" class="member_mobile_number">
                      <input type="hidden" value="{{$med['email_id']}}" class="member_email_id">{{$med['name']}}</td>
                    <td>{{$med['child_name']}}</td>
                    <td>{{$med['child_birth_date']}}</td>
                  </tr>
                    @empty
                    <tr><td>No Record Found</td></tr>
                  @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
       @endif
      <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header border-transparent bg-purple">
                <h3 class="card-title">Members Latest 10</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Name</th>
                      <th>Mobile Number</th>
                      <th>Pancard Number</th>
                      <th>Adharcard Number</th>
                      <th>Email</th>
                      <th>Father Name</th>
                      <th>Mother Name</th>
                      
                    </tr>
                    </thead>
                    <tbody>
                      @forelse($members as $med)
                    <tr>
                      <td>{{$med->name .'   '.$med->middle_name.' '.$med->surname}}</td>
                      <td>{{$med->mobile_number}}</td>
                      <td>{{$med->pancard_number}}</span></td>
                      <td>{{$med->adharcard_number}}</td>
                      <td>{{$med->email}}</td>
                      <td>{{$med->member->father_name}}</td>
                      <td>{{$med->member->mother_name}}</td>
                    </tr>
                      @empty
                        <tr><td>No Record Found</td></tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div> 
        </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="card">
              <div class="card-header border-transparent bg-purple">
                <h3 class="card-title">Mediclaims</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Holder Name</th>
                      <th>Birth Date</th>
                      <th>Start Date</th>
                      <th>Company Name</th>
                      <!-- <th>Policy Number</th>
                      <th>Policy Type</th>  
                      <th>Policy Name</th>  
                      <th>Premium Amount</th>
                      <th>Yearly Premium Amount</th> -->
                    </tr>
                    </thead>
                    <tbody>
                      @forelse($mediclaim as $med)
                    <tr>
                      <td>{{$med->policy_holder_name}}</td>
                      <td>{{$med->birth_date}}</td>
                      <td><span class="badge badge-success">{{$med->policy_start_date}}</span></td>
                      <td>{{$med->company_name->name}}</td>
                        <!-- <td>{{$med->policy_number}}</td>
                        <td>{{$med->policy_type->name}}</td>
                        <td>{{$med->policy_name}}</td>
                        <td>{{$med->premium_amount}}</td>
                        <td>{{$med->yearly_premium_amount}}</td> -->
                    </tr>
                    @empty
                      <tr><td>No Record Found</td></tr>
                    @endforelse
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              
              <!-- /.card-body -->
              <!-- <div class="card-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
              </div> -->
              <!-- /.card-footer -->
            </div>
          </div>
        
          <div class="col-sm-6">
            <div class="card">
              <div class="card-header border-transparent bg-green">
                <h3 class="card-title">Life Insurances</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Holder Name</th>
                      <th>Birth Date</th>
                      <th>Start Date</th>
                      <th>Company Name</th>
                      <!-- <th>Policy Number</th>
                      <th>Sum Assured</th>  
                      <th>Plan Name</th>  
                      <th>PPT</th>
                      <th>Policy Term</th> -->
                    </tr>
                    </thead>
                    <tbody>
                      
                      @forelse($life_insurance as $med)
                    <tr>
                      <td>{{$med->policy_holder_name}}</td>
                      <td>{{$med->birth_date}}</td>
                      <td><span class="badge badge-success">{{$med->policy_start_date}}</span></td>
                      <td>{{$med->company_name->name}}</td>
                      
                    </tr>
                    @empty
                      <tr><td>No Record Found</td></tr>
                    @endforelse
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              
              <!-- /.card-body -->
              <!-- <div class="card-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
              </div> -->
              <!-- /.card-footer -->
            </div>
          </div>
          <div class="col-sm-6">
            <div class="card">
              <div class="card-header border-transparent bg-red">
                <h3 class="card-title">Vehicle Insurances</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Vehicle Category</th>
                      <th>Vehicle Number</th>
                      <th>Vehicle Name</th>
                      <th>Chasis Number</th>
                      <!-- <th>Company Name</th>
                      <th>Policy Number</th>  
                      <th>Policy Type</th>  
                      <th>Policy Premium</th>
                      <th>Owner Name</th> -->
                    </tr>
                    </thead>
                    <tbody>
                      
                      @forelse($vehicle_insurance as $med)
                    <tr>
                      <td>{{$med->vehicle_category->name}}</td>
                      <td>{{$med->vehicle_number}}</td>
                      <td>{{$med->vehicle_name}}</span></td>
                      <td>{{$med->chasis_number}}</td>
                      <!-- <td>{{$med->company_name->name}}</td>
                      <td>{{$med->policy_number}}</td>
                      <td>{{$med->insurance_policy_type->name}}</td>
                      <td>{{$med->policy_premium}}</td>
                      <td>{{$med->vehicle_owner_name}}</td> -->
                    </tr>
                    @empty
                      <tr><td>No Record Found</td></tr>
                    @endforelse
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <!-- <div class="card-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
              </div> -->
              <!-- /.card-footer -->
            </div>
          </div>
          <div class="col-sm-6">
            <div class="card">
              <div class="card-header border-transparent bg-yellow">
                <h3 class="card-title">Mutual Funds</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Holder Name</th>
                      <th>Type</th>
                      <th>Folio Number</th>
                      <th>Fund Name</th>
                      <!-- <th>Fund Type</th>
                      <th>Purchase Date</th>  
                      <th>Amount</th>  
                      <th>Yearly Amount</th>
                      <th>Nominee Name</th> -->
                    </tr>
                    </thead>
                    <tbody>
                      
                      @forelse($mutual_fund as $med)
                    <tr>
                      <td>{{$med->mutual_fund_holder_name}}</td>
                      <td>{{$med->mutual_fund_type->name}}</td>
                      <td>{{$med->folio_number}}</span></td>
                      <td>{{$med->fund_name}}</td>
                      <!-- <td>{{$med->fund_type}}</td>
                      <td>{{$med->purchase_date}}</td>
                      <td>{{$med->amount}}</td>
                      <td>{{$med->yearly_amount}}</td>
                      <td>{{$med->nominee_name}}</td> -->
                    </tr>
                      @empty
                      <tr><td>No Record Found</td></tr>
                    @endforelse
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              
              <!-- /.card-body -->
              <!-- <div class="card-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
              </div> -->
              <!-- /.card-footer -->
            </div>
          </div>
        </div>
      </div>
     
        
          @endif
          <!-- ./col -->
          <!-- ./col -->
          <!-- ./col -->
            <!-- /.row -->
        <!-- Main row -->
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
</div>
</div>
<div class="modal fade" id="member_birth_datee" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="float-left">
                <h4 class="modal-title" id="myModal">Member Details </h4>
                </div>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 row">
                    <label for="User_ids" class="col-md-4 col-form-label text-md-end text-start">Member Name</label>
                    <span class="col-md-6 member_namee"></span>
                </div>
                <div class="mb-3 row">
                    <label for="added_by" class="col-md-4 col-form-label text-md-end text-start">Added By</label>
                    <span class="col-md-6 added_bye"></span>
                </div>
                <div class="mb-3 row">
                    <label for="user_names" class="col-md-4 col-form-label text-md-end text-start">Member Birth Date</label>
                    <span class="col-md-6 member_birth_datee"></span>
                </div>
                <div class="mb-3 row">
                    <label for="user_names" class="col-md-4 col-form-label text-md-end text-start">Member Mobile Number</label>
                    <span class="col-md-6 member_mobile_numbere"></span>
                </div>
                <div class="mb-3 row">
                    <label for="sr_nos" class="col-md-4 col-form-label text-md-end text-start">Member Email ID</label>
                    <span class="col-md-6 member_emailide"></span>
                </div>
                <div class="mb-3 row">
                    <label for="policy_holder_name" class="col-md-4 col-form-label text-md-end text-start">Father Name</label>
                    <span class="col-md-6 member_mother_father_namee"></span>
                </div>
            </div>
        </div>
    </div>
</div>  

<div class="modal fade" id="member_anniversary_datee" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="float-left">
                <h4 class="modal-title" id="myModal">Member Details </h4>
                </div>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 row">
                    <label for="User_ids" class="col-md-4 col-form-label text-md-end text-start">Member Name</label>
                    <span class="col-md-6 member_namee"></span>
                </div>
                <div class="mb-3 row">
                    <label for="added_by" class="col-md-4 col-form-label text-md-end text-start">Added By</label>
                    <span class="col-md-6 added_bye"></span>
                </div>
                <div class="mb-3 row">
                    <label for="user_names" class="col-md-4 col-form-label text-md-end text-start">Member Birth Date</label>
                    <span class="col-md-6 member_birth_datee"></span>
                </div>
                <div class="mb-3 row">
                    <label for="user_names" class="col-md-4 col-form-label text-md-end text-start">Member Mobile Number</label>
                    <span class="col-md-6 member_mobile_numbere"></span>
                </div>
                <div class="mb-3 row">
                    <label for="sr_nos" class="col-md-4 col-form-label text-md-end text-start">Member Email ID</label>
                    <span class="col-md-6 member_emailide"></span>
                </div>
                <div class="mb-3 row">
                    <label for="policy_holder_name" class="col-md-4 col-form-label text-md-end text-start">Father Name</label>
                    <span class="col-md-6 member_mother_father_namee"></span>
                </div>
                
            </div>
        </div>
    </div>
</div>  
<div class="modal fade" id="member_spouse_birth_datee" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="float-left">
                <h4 class="modal-title" id="myModal">Member Details </h4>
                </div>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 row">
                    <label for="User_ids" class="col-md-4 col-form-label text-md-end text-start">Member Name</label>
                    <span class="col-md-6 member_namee"></span>
                </div>
                <div class="mb-3 row">
                    <label for="added_by" class="col-md-4 col-form-label text-md-end text-start">Added By</label>
                    <span class="col-md-6 added_bye"></span>
                </div>
                <div class="mb-3 row">
                    <label for="user_names" class="col-md-4 col-form-label text-md-end text-start">Member Birth Date</label>
                    <span class="col-md-6 member_birth_datee"></span>
                </div>
                <div class="mb-3 row">
                    <label for="user_names" class="col-md-4 col-form-label text-md-end text-start">Member Mobile Number</label>
                    <span class="col-md-6 member_mobile_numbere"></span>
                </div>
                <div class="mb-3 row">
                    <label for="sr_nos" class="col-md-4 col-form-label text-md-end text-start">Member Email ID</label>
                    <span class="col-md-6 member_emailide"></span>
                </div>
                <div class="mb-3 row">
                    <label for="policy_holder_name" class="col-md-4 col-form-label text-md-end text-start">Father Name</label>
                    <span class="col-md-6 member_mother_father_namee"></span>
                </div>
                
            </div>
        </div>
    </div>
</div>  
<div class="modal fade" id="member_child_birth_datee" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="float-left">
                <h4 class="modal-title" id="myModal">Member Details </h4>
                </div>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 row">
                    <label for="User_ids" class="col-md-4 col-form-label text-md-end text-start">Member Name</label>
                    <span class="col-md-6 member_namee"></span>
                </div>
                <div class="mb-3 row">
                    <label for="added_by" class="col-md-4 col-form-label text-md-end text-start">Added By</label>
                    <span class="col-md-6 added_bye"></span>
                </div>
                <div class="mb-3 row">
                    <label for="user_names" class="col-md-4 col-form-label text-md-end text-start">Member Birth Date</label>
                    <span class="col-md-6 member_birth_datee"></span>
                </div>
                <div class="mb-3 row">
                    <label for="user_names" class="col-md-4 col-form-label text-md-end text-start">Member Mobile Number</label>
                    <span class="col-md-6 member_mobile_numbere"></span>
                </div>
                <div class="mb-3 row">
                    <label for="sr_nos" class="col-md-4 col-form-label text-md-end text-start">Member Email ID</label>
                    <span class="col-md-6 member_emailide"></span>
                </div>
                <div class="mb-3 row">
                    <label for="policy_holder_name" class="col-md-4 col-form-label text-md-end text-start">Father Name</label>
                    <span class="col-md-6 member_mother_father_namee"></span>
                </div>
                
            </div>
        </div>
    </div>
</div>  
<!-- 'name' => $member_dat->name.' '.$member_dat->middle_name.' '.$member_dat->surname,
                        'birth_date' => $member_dat->birth_date,
                        'father_name'=>  $member_dat->member->father_name,
                        'mother_name'=>$member_dat->member->mother_name,
                        'spouse_name'=>$member_dat->member->spouse_name,
                        'spouse_dob'=>$member_dat->member->spouse_dob,
                        'anniversary_date' => $member_dat->member->anniversary_date -->
<script src="{{ URL::asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script>
$('.member_birth_date tr').click(function () {
  $("#member_birth_datee").modal('show');
  var mother_name = $(this).closest('tr').find('.mother_name').val();
  var father_name = $(this).closest('tr').find('.father_name').val();
  var member_name = $(this).closest('tr').find('.member_name').val();
  var added_by = $(this).closest('tr').find('.added_by').val();
  var spouse_dob = $(this).closest('tr').find('.spouse_dob').val();
  var spouse_name = $(this).closest('tr').find('.spouse_name').val();
  var member_mobile_number = $(this).closest('tr').find('.member_mobile_number').val();
  var member_emailid = $(this).closest('tr').find('.member_email_id').val();
  var member_birth_date = $(this).closest('tr').find('.member_birth_dates').val();
  
  $('.spouse_dobe').text(spouse_dob);
  $(".added_bye").text(added_by);
  $('.spouse_namee').text(spouse_name);
  $('.member_birth_datee').text(member_birth_date);
  $('.member_namee').text(member_name);
  $('.member_mother_namee').text(mother_name);
  $('.member_mother_father_namee').text(father_name);
  $(".member_emailide").text(member_emailid);
  $(".member_mobile_numbere").text(member_mobile_number);
});
$('.member_anniversary_date tr').click(function () {
  $("#member_anniversary_datee").modal('show');
  var mother_name = $(this).closest('tr').find('.mother_name').val();
  var father_name = $(this).closest('tr').find('.father_name').val();
  var added_by = $(this).closest('tr').find('.added_by').val();
  var member_name = $(this).closest('tr').find('.member_name').val();
  var spouse_dob = $(this).closest('tr').find('.spouse_dob').val();
  var spouse_name = $(this).closest('tr').find('.spouse_name').val();
  var member_mobile_number = $(this).closest('tr').find('.member_mobile_number').val();
  var member_emailid = $(this).closest('tr').find('.member_email_id').val();
  var member_birth_date = $(this).closest('tr').find('.member_birth_dates').val();
  
  $('.spouse_dobe').text(spouse_dob);
  $('.spouse_namee').text(spouse_name);
  $(".added_bye").text(added_by);
  $('.member_birth_datee').text(member_birth_date);
  $('.member_namee').text(member_name);
  $('.member_mother_namee').text(mother_name);
  $('.member_mother_father_namee').text(father_name);
  $(".member_emailide").text(member_emailid);
  $(".member_mobile_numbere").text(member_mobile_number);
});
$('.spouse_dob tr').click(function () {
  $("#member_spouse_birth_datee").modal('show');
  var mother_name = $(this).closest('tr').find('.mother_name').val();
  var father_name = $(this).closest('tr').find('.father_name').val();
  var member_name = $(this).closest('tr').find('.member_name').val();
  var added_by = $(this).closest('tr').find('.added_by').val();
  var spouse_dob = $(this).closest('tr').find('.spouse_dob').val();
  var spouse_name = $(this).closest('tr').find('.spouse_name').val();
  var member_mobile_number = $(this).closest('tr').find('.member_mobile_number').val();
  var member_emailid = $(this).closest('tr').find('.member_email_id').val();
  var member_birth_date = $(this).closest('tr').find('.member_birth_dates').val();
  
  $('.spouse_dobe').text(spouse_dob);
  $('.spouse_namee').text(spouse_name);
  $('.member_birth_datee').text(member_birth_date);
  $(".added_bye").text(added_by);
  $('.member_namee').text(member_name);
  $('.member_mother_namee').text(mother_name);
  $('.member_mother_father_namee').text(father_name);
  $(".member_emailide").text(member_emailid);
  $(".member_mobile_numbere").text(member_mobile_number);
});
$('.child_dob tr').click(function () {
  $("#member_child_birth_datee").modal('show');
  var mother_name = $(this).closest('tr').find('.mother_name').val();
  var father_name = $(this).closest('tr').find('.father_name').val();
  var member_name = $(this).closest('tr').find('.member_name').val();
  var added_by = $(this).closest('tr').find('.added_by').val();
  var spouse_dob = $(this).closest('tr').find('.spouse_dob').val();
  var spouse_name = $(this).closest('tr').find('.spouse_name').val();
  var member_mobile_number = $(this).closest('tr').find('.member_mobile_number').val();
  var member_emailid = $(this).closest('tr').find('.member_email_id').val();
  var member_birth_date = $(this).closest('tr').find('.member_birth_dates').val();
  
  $('.spouse_dobe').text(spouse_dob);
  $('.spouse_namee').text(spouse_name);
  $('.member_birth_datee').text(member_birth_date);
  $('.member_namee').text(member_name);
  $(".added_bye").text(added_by);
  $('.member_mother_namee').text(mother_name);
  $('.member_mother_father_namee').text(father_name);
  $(".member_emailide").text(member_emailid);
  $(".member_mobile_numbere").text(member_mobile_number);
});

</script>
    @endsection