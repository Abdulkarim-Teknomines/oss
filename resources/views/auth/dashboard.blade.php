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
                 
          <!-- ./col -->
        </div>
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
                      <th>Policy Holder Name</th>
                      <th>Birth Date</th>
                      <th>Policy Start Date</th>
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
                      <th>Policy Holder Name</th>
                      <th>Birth Date</th>
                      <th>Policy Start Date</th>
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
                      <th>Insurance Company Name</th>
                      <th>Policy Number</th>  
                      <th>Insurance Policy Type</th>  
                      <th>Policy Premium</th>
                      <th>Vehicle Owner Name</th>
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
                      <th>Mutual Fund Holder Name</th>
                      <th>Mutual Fund Type</th>
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
        <!-- /.row -->
        <!-- Main row -->
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
</div>
</div>
    @endsection