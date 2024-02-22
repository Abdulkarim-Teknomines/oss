@extends('layouts.default')
@section('content')
<div class="card pt-3">
  <div class="card-body">
<section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$users}}</h3>
                <p>Users</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{route('users.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$admin}}</h3>
                <p>Admin</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{route('users.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$manager}}</h3>

                <p>Manager</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{route('users.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$agent}}</h3>
                <p>Agent</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{route('users.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$mediclaim_count}}</h3>
                <p>Mediclaim</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{route('mediclaim.all_mediclaim')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$life_insurance_count}}</h3>
                <p>Life Insurance</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{route('life_insurance.all_life_insurance')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$vehicle_insurance_count}}</h3>
                <p>Vehicle Insurance</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{route('vehicle_insurance.all_vehicle_insurance')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$mutual_fund_count}}</h3>
                <p>Mutual Fund</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{route('mutual_fund.all_mutual_fund')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="card">
              <div class="card-header border-transparent">
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
                      <th>Policy Number</th>
                      <th>Policy Type</th>  
                      <th>Policy Name</th>  
                      <th>Premium Amount</th>
                      <th>Yearly Premium Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                      
                      @forelse($mediclaim as $med)
                    <tr>
                      <td>{{$med->policy_holder_name}}</td>
                      <td>{{$med->birth_date}}</td>
                      <td><span class="badge badge-success">{{$med->policy_start_date}}</span></td>
                      <td>{{$med->company_name->name}}</td>
                      <td>{{$med->policy_number}}</td>
                      <td>{{$med->policy_type->name}}</td>
                      <td>{{$med->policy_name}}</td>
                      <td>{{$med->premium_amount}}</td>
                      <td>{{$med->yearly_premium_amount}}</td>
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
              <div class="card-header border-transparent">
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
                      <th>Policy Number</th>
                      <th>Sum Assured</th>  
                      <th>Plan Name</th>  
                      <th>PPT</th>
                      <th>Policy Term</th>
                    </tr>
                    </thead>
                    <tbody>
                      
                      @forelse($life_insurance as $med)
                    <tr>
                      <td>{{$med->policy_holder_name}}</td>
                      <td>{{$med->birth_date}}</td>
                      <td><span class="badge badge-success">{{$med->policy_start_date}}</span></td>
                      <td>{{$med->company_name->name}}</td>
                      <td>{{$med->policy_number}}</td>
                      <td>{{$med->sum_assured}}</td>
                      <td>{{$med->plan_name}}</td>
                      <td>{{$med->ppt->name}}</td>
                      <td>{{$med->policy_term}}</td>
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
              <div class="card-header border-transparent">
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
                      <th>Company Name</th>
                      <th>Policy Number</th>  
                      <th>Policy Type</th>  
                      <th>Policy Premium</th>
                      <th>Owner Name</th>
                    </tr>
                    </thead>
                    <tbody>
                      
                      @forelse($vehicle_insurance as $med)
                    <tr>
                      <td>{{$med->vehicle_category->name}}</td>
                      <td>{{$med->vehicle_number}}</td>
                      <td>{{$med->vehicle_name}}</span></td>
                      <td>{{$med->chasis_number}}</td>
                      <td>{{$med->company_name->name}}</td>
                      <td>{{$med->policy_number}}</td>
                      <td>{{$med->insurance_policy_type->name}}</td>
                      <td>{{$med->policy_premium}}</td>
                      <td>{{$med->vehicle_owner_name}}</td>
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
              <div class="card-header border-transparent">
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
                      <th>Fund Type</th>
                      <th>Purchase Date</th>  
                      <th>Amount</th>  
                      <th>Yearly Amount</th>
                      <th>Nominee Name</th>
                    </tr>
                    </thead>
                    <tbody>
                      
                      @forelse($mutual_fund as $med)
                    <tr>
                      <td>{{$med->mutual_fund_holder_name}}</td>
                      <td>{{$med->mutual_fund_type->name}}</td>
                      <td>{{$med->folio_number}}</span></td>
                      <td>{{$med->fund_name}}</td>
                      <td>{{$med->fund_type}}</td>
                      <td>{{$med->purchase_date}}</td>
                      <td>{{$med->amount}}</td>
                      <td>{{$med->yearly_amount}}</td>
                      <td>{{$med->nominee_name}}</td>
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
          <div class="row">
            <div class="col-sm-12">
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Members</h3>

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
                      <!-- <th>Country</th>
                      <th>State</th>
                      <th>City</th>
                      <th>Address</th> -->
                      <th>Email</th>
                      <th>Father Name</th>
                      <th>Mother Name</th>
                      <th>Spouse Name</th>
                      <th>Spouse DOB</th>
                      <th>Anniversary Date</th>
                    </tr>
                    </thead>
                    <tbody>
                      @forelse($members as $med)
                    <tr>
                      <td>{{$med->name .'   '.$med->middle_name.' '.$med->surname}}</td>
                      <td>{{$med->mobile_number}}</td>
                      <td>{{$med->pancard_number}}</span></td>
                      <td>{{$med->adharcard_number}}</td>
                        <!-- <td>{{$med->country->name}}</td>
                        <td>{{$med->state->name}}</td>
                        <td>{{$med->city->name}}</td>
                        <td>{{$med->address}}</td> -->
                      <td>{{$med->email}}</td>
                      <td>{{$med->member->father_name}}</td>
                      <td>{{$med->member->mother_name}}</td>
                      <td>{{$med->member->spouse_name}}</td>
                      <td>{{$med->member->spouse_dob}}</td>
                      <td>{{$med->member->anniversary_date}}</td>
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
            
        <!-- /.row -->
        <!-- Main row -->
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
</div>
</div>
    @endsection