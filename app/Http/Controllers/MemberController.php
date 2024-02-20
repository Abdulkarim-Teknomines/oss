<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\User;
use App\Models\Member;
use App\Models\State;
use App\Models\City;
use App\Models\PolicyType;
use App\Models\VehicleCategory;
use App\Models\VehicleInsurance;
use App\Models\Children;
use App\Models\CompanyName;
use App\Models\InsurancePolicyType;
use App\Models\Lifeinsurance;
use App\Models\Mediclaim;
use App\Models\Mutualfund;
use App\Models\MutualFundType;
use App\Models\PolicyMode;
use App\Models\Ppt;
use App\Models\Bloodgroup;
// use PDF;
use Auth;
use App\Mail\DemoMail;
use App\Exports\MembersExport;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use DataTables;


class MemberController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('auth');
        $this->middleware('permission:create-member|edit-member|delete-member', ['only' => ['index','show']]);
        $this->middleware('permission:create-member', ['only' => ['create','store']]);
        $this->middleware('permission:edit-member', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-member', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            // $data = User::find(auth()->user()->id)->descendants()->depthFirst()->get();
            $data = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles')->whereHas('roles', function($query) {
                $query->where('name','member');
            })->get();
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('id', function($row){
                        return $row['user_id'];
                    }) 
                    ->addColumn('name', function($row){
                        return $row['name'];
                    }) 
                    ->addColumn('mediclaim', function($row){
                        return '<a href="javascript:void(0)" class="edit fa fa-plus btn-lg" id="edits" onClick="add_mediclaim('.$row->id.')"></a>
                        <a href="javascript:void(0)" class="edit fa fa-eye btn-lg" id="edits" onClick="view_mediclaim('.$row->id.')"></a>'
                        ;
                    }) 
                    ->addColumn('mutual_fund', function($row){
                        return '<a href="javascript:void(0)" class="edit fa fa-plus btn-lg" id="edits" onClick="add_mutual_fund('.$row->id.')"></a>
                        <a href="javascript:void(0)" class="edit fa fa-eye btn-lg" id="edits" onClick="view_mutual_fund('.$row->id.')"></a>';
                    }) 
                    ->addColumn('vehicle_insurance', function($row){
                        return '<a href="javascript:void(0)" class="edit fa fa-plus btn-lg" id="edits" onClick="add_vehicle_insurance('.$row->id.')"></a>
                        <a href="javascript:void(0)" class="edit fa fa-eye btn-lg" id="edits" onClick="view_vehicle_insurance('.$row->id.')"></a>';
                    }) 
                    ->addColumn('life_insurance', function($row){
                        return '<a href="javascript:void(0)" class="edit fa fa-plus btn-lg" id="edits" onClick="add_life_insurance('.$row->id.')"></a>
                        <a href="javascript:void(0)" class="edit fa fa-eye btn-lg" id="edits" onClick="view_life_insurance('.$row->id.')"></a>';
                    }) 
                    ->addColumn('action', function ($row){
                        $btn='';
                        $btn .= '<a href="members/'.$row['id'].'" class="edit btn btn-info btn-sm">View</a>&nbsp;&nbsp;';
                        if(Auth::user()->can('edit-member')) {
                            $btn.='<a href="members/'.$row['id'].'/edit" class="edit btn btn-primary btn-sm" id="edit">Edit</a>';
                        }
                        $btn.='<a href="members/'.$row['id'].'/reports" class="ml-1 edit btn btn-dark btn-sm" id="view_report">Report</a>';
                        return $btn;
                    })
                    ->rawColumns(['action','life_insurance','mediclaim','mutual_fund','vehicle_insurance'])
                    ->make(true);
        }
        
        return view('members.index', [
            // 'users' => $data,
            'title'=>'Member',
            'content'=>'Manage Member'
        ]);
    }
    public function show(Request $request,User $user){
        $user =User::with('mediclaim','vehicle_insurance','life_insurance','mutual_fund','member','country','state','city','children')->where('id',$user->id)->get();
        // dd($user);
        return view('members.show', [
            'user' => $user,
            'title'=>'Member',
            'content'=>'View Members'
        ]);
    }
    public function create()
    {
        $data['blood_group'] = Bloodgroup::get(["name", "id"]);
        $data['countries'] = Country::get(["name", "id"]);
        $data['title']='Members';
        $data['content']='Create Members';
        return view('members.create', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'middle_name' => 'required',
            'surname' => 'required',
            'mobile_number' => 'required|numeric',
            'birth_date' => 'required',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
            'father_name' => 'required',
            'mother_name' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
        ]); 
        $password = Str::random(8);
        // dd($request->all());
        $input['parent_id'] = Auth::user()->id;
        $input['name'] = $request->name;
        $input['surname'] = $request->surname;
        $input['middle_name'] = $request->middle_name;
        $input['pancard_number'] = $request->pancard_number;
        $input['mobile_number'] = $request->mobile_number;
        $input['adharcard_number'] = $request->adharcard_number;
        $input['country_id'] = $request->country_id;
        $input['state_id'] = $request->state_id;
        $input['city_id'] = $request->city_id;
        $input['address'] = $request->address;
        $input['password'] = Hash::make($password);
        $input['birth_date'] = $request->birth_date;
        $input['email'] = $request->email;
        $input['isActive'] = 0;
        $user = User::create($input);
        if($user){
            $user_id = 'USR'.str_pad($user->id, 5, '0', STR_PAD_LEFT);
            User::whereId($user->id)->update([
                'user_id' => $user_id,
            ]);
            $user->assignRole('Member');
            $member['father_name'] = $request->father_name;
            $member['mother_name'] = $request->mother_name;
            $member['spouse_name'] = $request->spouse_name;
            $member['spouse_dob'] = $request->spouse_dob;
            $member['anniversary_date'] = $request->anniversary_date;
            $member['user_id'] = $user->id;
            $members = Member::create($member);
            if(isset($request->child_name) && !empty($request->child_name)){
                for($i=0;$i<count($request->child_name);$i++){
                    $child['name'] =$request->child_name[$i];
                    $child['birth_date'] =$request->child_dob[$i];
                    $child['user_id']=$user->id;
                    $members = Children::create($child);
                }
            }
            return redirect()->route('members.index')
                    ->withSuccess('Member is added successfully.');

        }
    }
    public function edit(User $user)
    {
        // $user = User::with('member')->where('id',$member->id)->get();
        $user =User::with('member','children')->where('id',$user->id)->get();
        // Check Only Super Admin can update his own Profile
        
        // $user[0]->user->mobile_number
        return view('members.edit', [
            'user' => $user,
            'roles' => Role::pluck('name')->all(),
            // 'userRoles' => $user->roles->pluck('name')->all(),
            'title'=>'members',
            'content'=>'Edit Member',
            'countries'=>Country::get(["name", "id"]),
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // dd($user);
        // $input = $regit quest->all();
        $input['name'] = $request->name;
        $input['surname'] = $request->surname;
        $input['middle_name'] = $request->middle_name;
        $input['pancard_number'] = $request->pancard_number;
        $input['mobile_number'] = $request->mobile_number;
        $input['adharcard_number'] = $request->adharcard_number;
        $input['country_id'] = $request->country_id;
        $input['state_id'] = $request->state_id;
        $input['city_id'] = $request->city_id;
        $input['address'] = $request->address;
        $input['birth_date'] = $request->birth_date;
        $input['email'] = $request->email;
        if($request->isActive=="0"){
            $input['isActive']=0;
        }else{
            $input['isActive']=1;
        }
        $users = User::where('id', $user->id)->update($input);
        // echo $this->db->last_query();die;
        if($users){
            
            $member['father_name'] = $request->father_name;
            $member['mother_name'] = $request->mother_name;
            $member['spouse_name'] = $request->spouse_name;
            $member['spouse_dob'] = $request->spouse_dob;
            $member['anniversary_date'] = $request->anniversary_date;
            $members = Member::where('user_id', $user->id)->update($member);
            
            Children::where('user_id',$user->id)->delete();
            if(isset($request->child_name) && !empty($request->child_name)){
                for($i=0;$i<count($request->child_name);$i++){
                    $child['name'] =$request->child_name[$i];
                    $child['birth_date'] =$request->child_dob[$i];
                    $child['user_id']=$user->id;
                    $members = Children::create($child);
                }
            }
        }
        
        return redirect()->route('members.index')->withSuccess('Member is updated successfully.');
    }
    public function add_mediclaim(User $user){
        $data['user_id']=$user->id;
        $data['company_name'] = CompanyName::get(["name", "id"]);
        $data['policy_type'] = PolicyType::get(["name", "id"]);
        $data['policy_mode'] = PolicyMode::get(["name", "id"]);
        
        $data['title']='Members';
        $data['content']='Create Mediclaim';
        return view('mediclaim.create', $data);
    }
    public function store_mediclaim(Request $request){

        
        
        $request->validate([
            'sr_no' => 'required|numeric',
            'policy_holder_name' => 'required',
            'birth_date' => 'required',
            'policy_start_date' => 'required',
            'company_name' => 'required',
            'policy_number' => 'required|numeric',
            'policy_type' => 'required',
            'sum_assured' => 'required|numeric',
            'policy_name' => 'required',
            'policy_mode' => 'required',
            'premium_amount' => 'required|numeric',
            'yearly_premium_amount' => 'required|numeric',
        ]);
        $input['parent_id'] = auth()->user()->id;
        $input['user_id'] = $request->user_id;
        $input['sr_no'] = $request->sr_no;
        $input['policy_holder_name'] = $request->policy_holder_name;
        $input['birth_date'] = $request->birth_date;
        $input['policy_start_date'] = $request->policy_start_date;
        $input['company_name_id'] = $request->company_name;
        $input['policy_number'] = $request->policy_number;
        $input['policy_type_id'] = $request->policy_type;
        $input['sum_assured'] = $request->sum_assured;
        $input['policy_name'] = $request->policy_name;
        $input['policy_mode_id'] = $request->policy_mode;
        $input['premium_amount'] = $request->premium_amount;
        $input['yearly_premium_amount'] = $request->yearly_premium_amount;
        $input['agent_name'] = $request->agent_name;
        $input['agent_mobile_number'] = $request->agent_mobile_number;
        $input['branch_name'] = $request->branch_name;
        $input['branch_address'] = $request->branch_address;
        $input['branch_contact_no'] = $request->branch_contact_number;
        $input['other_details'] = $request->other_details;
        $start_month = date('m',strtotime($request->policy_start_date));
        if($request->policy_mode=='1'){
            $input['jan'] = $request->premium_amount;
            $input['feb'] = $request->premium_amount;
            $input['mar'] = $request->premium_amount;
            $input['apr'] = $request->premium_amount;
            $input['may'] = $request->premium_amount;
            $input['jun'] = $request->premium_amount;
            $input['jul'] = $request->premium_amount;
            $input['aug'] = $request->premium_amount;
            $input['sep'] = $request->premium_amount;
            $input['oct'] = $request->premium_amount;
            $input['nov'] = $request->premium_amount;
            $input['dec'] = $request->premium_amount;
            $input['single'] = 0;
        }elseif($request->policy_mode=='2'){
            if($start_month==01 || $start_month==04 || $start_month==07 || $start_month==10){
                $input['jan'] = $request->premium_amount;
                $input['apr'] = $request->premium_amount;
                $input['jul'] = $request->premium_amount;
                $input['oct'] = $request->premium_amount;
            }elseif($start_month==02 || $start_month==05  || $start_month=="0008" || $start_month==11 ){
                $input['feb'] = $request->premium_amount;
                $input['may'] = $request->premium_amount;
                $input['aug'] =$request->premium_amount;
                $input['nov'] = $request->premium_amount;
            }elseif($start_month==03 ||$start_month==06 || $start_month=='0009' || $start_month==12){
                $input['mar'] = $request->premium_amount;
                $input['jun'] = $request->premium_amount;
                $input['sep'] = $request->premium_amount;
                $input['dec'] = $request->premium_amount;
            }
        }elseif($request->policy_mode=='3'){
            if($start_month==01 || $start_month==07){
                $input['jan'] = $request->premium_amount;
                $input['jul'] = $request->premium_amount;
            }elseif($start_month==02 || $start_month=='0008'){
                $input['feb'] = $request->premium_amount;
                $input['aug'] = $request->premium_amount;
            }elseif($start_month==03 || $start_month=='0009'){
                $input['mar'] = $request->premium_amount;
                $input['sep'] = $request->premium_amount;
            }elseif($start_month==04 || $start_month==10){
                $input['apr'] = $request->premium_amount;
                $input['oct'] = $request->premium_amount;
            }elseif($start_month==05 || $start_month==11){
                $input['may'] = $request->premium_amount;
                $input['nov'] = $request->premium_amount;
            }elseif($start_month==06 || $start_month==12){
                $input['jun'] = $request->premium_amount;
                $input['dec'] = $request->premium_amount;
            }
        }
        elseif($request->policy_mode=='4'){
            if($start_month==01){
                $input['jan'] = $request->premium_amount;
            }elseif($start_month==02){
                $input['feb'] = $request->premium_amount;
            }elseif($start_month==03){
                $input['mar'] = $request->premium_amount;
            }elseif($start_month==04){
                $input['apr'] = $request->premium_amount;
            }elseif($start_month==05){
                $input['may'] = $request->premium_amount;
            }elseif($start_month==06){
                $input['jul'] = $request->premium_amount;
            }elseif($start_month==07){
                $input['jul'] = $request->premium_amount;
            }elseif($start_month=='0008'){
                $input['aug'] = $request->premium_amount;
            }elseif($start_month=='0009'){
                $input['sep'] = $request->premium_amount;
            }elseif($start_month==10){
                $input['oct'] = $request->premium_amount;
            }elseif($start_month==11){
                $input['nov'] = $request->premium_amount;
            }else{
                $input['dec'] = $request->premium_amount;
            }
        }elseif($request->policy_mode=='5'){
            $input['single'] = $request->premium_amount;
        }
        
        $user = Mediclaim::create($input);
            return redirect()->route('members.index')
                    ->withSuccess('Mediclaim is added successfully.');

        
    }
    public function add_life_insurance(User $user){
        $data['user_id']=$user->id;
        $data['company_name'] = CompanyName::get(["name", "id"]);
        $data['ppt'] = Ppt::get(["name", "id"]);
        $data['policy_mode'] = PolicyMode::get(["name", "id"]);
        
        $data['title']='Members';
        $data['content']='Create Life Insurance';
        return view('life_insurance.create', $data);
    }
    public function store_life_insurance(Request $request){
        
        $request->validate([
            'sr_no' => 'required|numeric',
            'policy_holder_name' => 'required',
            'birth_date' => 'required',
            'policy_start_date' => 'required',
            'company_name' => 'required',
            'policy_number' => 'required|numeric',
            'sum_assured' => 'required|numeric',
            'plan_name' => 'required',
            'ppt' => 'required',
            'policy_term' => 'required',
            'premium_mode' => 'required',
            'premium_amount' => 'required|numeric',
            'yearly_premium_amount' => 'required|numeric',
            'nominee_name' => 'required',
            'nominee_relation' => 'required',
            'nominee_dob' => 'required',
        ]);
        $input['parent_id'] = auth()->user()->id;
        $input['user_id'] = $request->user_id;
        $input['sr_no'] = $request->sr_no;
        $input['policy_holder_name'] = $request->policy_holder_name;
        $input['birth_date'] = $request->birth_date;
        $input['policy_start_date'] = $request->policy_start_date;
        $input['company_name_id'] = $request->company_name;
        $input['policy_number'] = $request->policy_number;
        $input['sum_assured'] = $request->sum_assured;
        $input['plan_name'] = $request->plan_name;
        $input['ppt_id'] = $request->ppt;
        $input['policy_term'] = $request->policy_term;
        $input['policy_mode_id'] = $request->premium_mode;
        $input['premium_amount'] = $request->premium_amount;
        $input['yearly_premium_amount'] = $request->yearly_premium_amount;
        $input['nominee_name'] = $request->nominee_name;
        $input['nominee_relation'] = $request->nominee_relation;
        $input['nominee_dob'] = $request->nominee_dob;
        $input['agent_name'] = $request->agent_name;
        $input['agent_mobile_number'] = $request->agent_mobile_number;
        $input['branch_name'] = $request->branch_name;
        $input['branch_address'] = $request->branch_address;
        $input['branch_contact_no'] = $request->branch_contact_number;
        $input['other_details'] = $request->other_details;
        $start_month = date('m',strtotime($request->policy_start_date));
        if($request->premium_mode=='1'){
            $input['jan'] = $request->premium_amount;
            $input['feb'] = $request->premium_amount;
            $input['mar'] = $request->premium_amount;
            $input['apr'] = $request->premium_amount;
            $input['may'] = $request->premium_amount;
            $input['jun'] = $request->premium_amount;
            $input['jul'] = $request->premium_amount;
            $input['aug'] = $request->premium_amount;
            $input['sep'] = $request->premium_amount;
            $input['oct'] = $request->premium_amount;
            $input['nov'] = $request->premium_amount;
            $input['dec'] = $request->premium_amount;
        }elseif($request->premium_mode=='2'){
            if($start_month==01){
                $input['jan'] = $request->premium_amount;
                $input['apr'] = $request->premium_amount;
                $input['jul'] = $request->premium_amount;
                $input['oct'] = $request->premium_amount;
            }elseif($start_month==02){
                $input['feb'] = $request->premium_amount;
                $input['may'] = $request->premium_amount;
                $input['aug'] = $request->premium_amount;
                $input['nov'] = $request->premium_amount;
            }elseif($start_month==03){
                $input['mar'] = $request->premium_amount;
                $input['jun'] = $request->premium_amount;
                $input['sep'] = $request->premium_amount;
                $input['dec'] = $request->premium_amount;
            }elseif($start_month==04){
                $input['apr'] = $request->premium_amount;
                $input['jul'] = $request->premium_amount;
                $input['oct'] = $request->premium_amount;
                $input['jan'] = $request->premium_amount;
            }elseif($start_month==05){
                $input['may'] = $request->premium_amount;
                $input['aug'] = $request->premium_amount;
                $input['nov'] = $request->premium_amount;
                $input['feb'] = $request->premium_amount;
            }elseif($start_month==06){
                $input['jun'] = $request->premium_amount;
                $input['sep'] = $request->premium_amount;
                $input['dec'] = $request->premium_amount;
                $input['mar'] = $request->premium_amount;
            }elseif($start_month==07){
                $input['jul'] = $request->premium_amount;
                $input['oct'] = $request->premium_amount;
                $input['jan'] = $request->premium_amount;
                $input['apr'] = $request->premium_amount;
            }elseif($start_month=='0008'){
                $input['aug'] = $request->premium_amount;
                $input['nov'] = $request->premium_amount;
                $input['feb'] = $request->premium_amount;
                $input['may'] = $request->premium_amount;
            }elseif($start_month=='0009'){
                $input['sep'] = $request->premium_amount;
                $input['dec'] = $request->premium_amount;
                $input['mar'] = $request->premium_amount;
                $input['jun'] = $request->premium_amount;
            }elseif($start_month==10){
                $input['oct'] = $request->premium_amount;
                $input['jan'] = $request->premium_amount;
                $input['apr'] = $request->premium_amount;
                $input['jul'] = $request->premium_amount;
            }elseif($start_month==11){
                $input['nov'] = $request->premium_amount;
                $input['feb'] = $request->premium_amount;
                $input['may'] = $request->premium_amount;
                $input['aug'] = $request->premium_amount;
            }else{
                $input['dec'] = $request->premium_amount;
                $input['mar'] = $request->premium_amount;
                $input['jun'] = $request->premium_amount;
                $input['sep'] = $request->premium_amount;
            }
        }elseif($request->premium_mode=='3'){
            if($start_month==01){
                $input['jan'] = $request->premium_amount;
                $input['jul'] = $request->premium_amount;
            }elseif($start_month==02){
                $input['feb'] = $request->premium_amount;
                $input['aug'] = $request->premium_amount;
            }elseif($start_month==03){
                $input['mar'] = $request->premium_amount;
                $input['sep'] = $request->premium_amount;
            }elseif($start_month==04){
                $input['apr'] = $request->premium_amount;
                $input['oct'] = $request->premium_amount;
            }elseif($start_month==05){
                $input['may'] = $request->premium_amount;
                $input['nov'] = $request->premium_amount;
            }elseif($start_month==06){
                $input['jun'] = $request->premium_amount;
                $input['dec'] = $request->premium_amount;
            }elseif($start_month==07){
                $input['jul'] = $request->premium_amount;
                $input['jan'] = $request->premium_amount;
            }elseif($start_month=='0008'){
                $input['aug'] = $request->premium_amount;
                $input['feb'] = $request->premium_amount;
            }elseif($start_month=='0009'){
                $input['sep'] = $request->premium_amount;
                $input['mar'] = $request->premium_amount;
            }elseif($start_month==10){
                $input['oct'] = $request->premium_amount;
                $input['apr'] = $request->premium_amount;
            }elseif($start_month==11){
                $input['nov'] = $request->premium_amount;
                $input['may'] = $request->premium_amount;
            }else{
                $input['dec'] = $request->premium_amount;
                $input['jun'] = $request->premium_amount;
            }
        }
        elseif($request->premium_mode=='4'){
            if($start_month==01){
                $input['jan'] = $request->premium_amount;
            }elseif($start_month==02){
                $input['feb'] = $request->premium_amount;
            }elseif($start_month==03){
                $input['mar'] = $request->premium_amount;
            }elseif($start_month==04){
                $input['apr'] = $request->premium_amount;
            }elseif($start_month==05){
                $input['may'] = $request->premium_amount;
            }elseif($start_month==06){
                $input['jun'] = $request->premium_amount;
            }elseif($start_month==07){
                $input['jul'] = $request->premium_amount;
            }elseif($start_month=='0008'){
                $input['aug'] = $request->premium_amount;
            }elseif($start_month=='0009'){
                $input['sep'] = $request->premium_amount;
            }elseif($start_month==10){
                $input['oct'] = $request->premium_amount;
            }elseif($start_month==11){
                $input['nov'] = $request->premium_amount;
            }else{
                $input['dec'] = $request->premium_amount;
            }
        }elseif($request->premium_mode=='5'){
            $input['single'] = $request->premium_amount;
        }
        $user = Lifeinsurance::create($input);
            return redirect()->route('members.index')
                    ->withSuccess('Life Insurance is added successfully.');

        
    }
    public function add_vehicle_insurance(User $user){
        $data['user_id']=$user->id;
        $data['vehicle_category'] = VehicleCategory::get(["name", "id"]);
        $data['policy_type'] = InsurancePolicyType::get(["name", "id"]);
        $data['ppt'] = Ppt::get(["name", "id"]);
        $data['title']='Members';
        $data['content']='Create Vehicle Insurance';
        return view('vehicle_insurance.create', $data);
    }
    public function store_vehicle_insurance(Request $request){
        
        $request->validate([
            'sr_no' => 'required|numeric',
            'vehicle_category' => 'required',
            'vehicle_number' => 'required',
            'vehicle_name' => 'required',
            'insurance_company_name' => 'required',
            'policy_number' => 'required',
            'chasis_number' => 'required',
            'policy_type' => 'required',
            'policy_premium' => 'required|numeric',
            'vehicle_owner_name' => 'required',
            'policy_start_date' => 'required',
            'policy_end_date' => 'required',
        ]);
        $input['parent_id'] = auth()->user()->id;
        $input['user_id'] = $request->user_id;
        $input['sr_no'] = $request->sr_no;
        $input['vehicle_category_id'] = $request->vehicle_category;
        $input['vehicle_number'] = $request->vehicle_number;
        $input['vehicle_name'] = $request->vehicle_name;
        $input['insurance_company_name'] = $request->insurance_company_name;
        $input['policy_number'] = $request->policy_number;
        $input['chasis_number'] = $request->chasis_number;
        $input['insurance_policy_type_id'] = $request->policy_type;
        $input['policy_premium'] = $request->policy_premium;
        $input['vehicle_owner_name'] = $request->vehicle_owner_name;
        $input['policy_start_date'] = $request->policy_start_date;
        $input['policy_end_date'] = $request->policy_end_date;
        $input['agent_name'] = $request->agent_name;
        $input['agent_mobile_number'] = $request->agent_mobile_number;
        $input['other_details'] = $request->other_details;
        $start_month = date('m',strtotime($request->policy_start_date));
        if($start_month==1){
            $input['jan'] = $request->policy_premium;
        }elseif($start_month==2){
            $input['feb'] = $request->policy_premium;
        }elseif($start_month==3){
            $input['mar'] = $request->policy_premium;
        }elseif($start_month==4){
            $input['apr'] = $request->policy_premium; 
        }elseif($start_month==5){
            $input['may'] = $request->policy_premium;
        }elseif($start_month==6){
            $input['jun'] = $request->policy_premium;
        }elseif($start_month==7){
            $input['jul'] = $request->policy_premium;
        }elseif($start_month=='0008'){
            $input['aug'] = $request->policy_premium;
        }elseif($start_month=='0009'){
            $input['sep'] = $request->policy_premium;
        }elseif($start_month==10){
            $input['oct'] = $request->policy_premium;
        }elseif($start_month==11){
            $input['nov'] = $request->policy_premium;
        }elseif($start_month==12){
            $input['dec'] = $request->policy_premium;
        }else{
            $input['single'] = 0;
        }
        $user = VehicleInsurance::create($input);
            return redirect()->route('members.index')
                    ->withSuccess('Vehicle Insurance is added successfully.');

        
    }
    public function add_mutual_fund(User $user){
        $data['user_id']=$user->id;
        $data['mutual_fund_type'] = MutualFundType::get(["name", "id"]);
        $data['title']='Members';
        $data['content']='Create Mutual Fund';
        return view('mutual_fund.create', $data);
    }
    public function store_mutual_fund(Request $request){
        
        $request->validate([
            'sr_no' => 'required|numeric',
            'mutual_fund_holder_name' => 'required',
            'mutual_fund_type' => 'required',
            'folio_number' => 'required|numeric',
            'fund_name' => 'required',
            'fund_type' => 'required',
            'purchase_date' => 'required',
            'amount' => 'required|numeric',
            'yearly_amount' => 'required|numeric',
            'nominee_name' => 'required',
            'nominee_relation' => 'required',
            'nominee_dob' => 'required'
        ]);
        $input['parent_id'] = auth()->user()->id;
        $input['user_id'] = $request->user_id;
        $input['sr_no'] = $request->sr_no;
        $input['mutual_fund_holder_name'] = $request->mutual_fund_holder_name;
        $input['mutual_fund_type_id'] = $request->mutual_fund_type;
        $input['folio_number'] = $request->folio_number;
        $input['fund_name'] = $request->fund_name;
        $input['fund_type'] = $request->fund_type;
        $input['purchase_date'] = $request->purchase_date;
        $input['amount'] = $request->amount;
        $input['yearly_amount'] = $request->yearly_amount;
        $input['nominee_name'] = $request->nominee_name;
        $input['nominee_relation'] = $request->nominee_relation;
        $input['nominee_dob'] = $request->nominee_dob;
        $input['agent_name'] = $request->agent_name;
        $input['agent_mobile_number'] = $request->agent_mobile_number;
        $input['other_details'] = $request->other_details;
        $start_month = date('m',strtotime($request->purchase_date));
        if($request->mutual_fund_type=='1'){
            $input['jan'] = 0;
            $input['feb'] = 0;
            $input['mar'] = 0;
            $input['apr'] = 0;
            $input['may'] = 0;
            $input['jun'] = 0;
            $input['jul'] = 0;
            $input['aug'] = 0;
            $input['sep'] = 0;
            $input['oct'] = 0;
            $input['nov'] = 0;
            $input['dec'] = 0;
            $input['single'] = $request->amount;
        }elseif($request->mutual_fund_type=='2'){
            if($start_month==1){
                $input['jan'] = $request->amount;
            }elseif($start_month==2){
                $input['feb'] = $request->amount;
            }elseif($start_month==3){
                $input['mar'] = $request->amount;
            }elseif($start_month==4){
                $input['apr'] = $request->amount; 
            }elseif($start_month==5){
                $input['may'] = $request->amount;
            }elseif($start_month==6){
                $input['jun'] = $request->amount;
            }elseif($start_month==7){
                $input['jul'] = $request->amount;
            }elseif($start_month=='0008'){
                $input['aug'] = $request->amount;
            }elseif($start_month=='0009'){
                $input['sep'] = $request->amount;
            }elseif($start_month==10){
                $input['oct'] = $request->amount;
            }elseif($start_month==11){
                $input['nov'] = $request->amount;
            }elseif($start_month==12){
                $input['dec'] = $request->amount;
            }else{
                $input['single'] = 0;
            }
        }
        $user = Mutualfund::create($input);
            return redirect()->route('members.index')
                    ->withSuccess('Mutual Fund is added successfully.');
    }
    public function list_mediclaim(Request $request,User $user){
        
        if ($request->ajax()) {
            $data =Mediclaim::with('company_name','policy_type','policy_mode')->where('user_id',$user->id)->get();            
            // $data = User::find(auth()->user()->id)->descendants()->depthFirst()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('sr_no', function($row){
                        return $row['sr_no'];
                    }) 
                    ->addColumn('policy_holder_name', function($row){
                        return $row['policy_holder_name'];
                    }) 
                    ->addColumn('birth_date', function($row){
                        return $row['birth_date'];
                    }) 
                    ->addColumn('policy_start_date', function($row){
                        return $row['policy_start_date'];
                    }) 
                    ->addColumn('company_name', function($row){
                        return $row->company_name['name'];
                    }) 
                    ->addColumn('policy_number', function($row){
                        return $row['policy_number'];
                    }) 
                    ->addColumn('policy_type', function($row){
                        return $row->policy_type['name'];
                    }) 
                    ->addColumn('sum_assured', function($row){
                        return $row['sum_assured'];
                    }) 
                    ->addColumn('action', function ($row){
                        $btn='';
                        $btn .= '<a href="javascript:void(0)" class="view_mediclaim btn btn-info btn-sm" id="view_mediclaim" onClick="view_mediclaim('.$row->id.')">View</a>&nbsp;&nbsp;';
                        if(Auth::user()->can('edit-mediclaim')) {
                            $btn.='<a href="javascript:void(0)" class="edit_mediclaim btn btn-primary btn-sm" id="edit_mediclaim"  onClick="edit_mediclaim('.$row->id.')">Edit</a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('mediclaim.view', [
            // 'users' => $data,
            'title'=>'Member',
            'content'=>'Manage Mediclaim'
        ]);
    }
   
    public function list_mutual_fund(Request $request,User $user){
        if ($request->ajax()) {
            $data =Mutualfund::with('mutual_fund_type')->where('user_id',$user->id)->get();            
            // $data = User::find(auth()->user()->id)->descendants()->depthFirst()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('sr_no', function($row){
                        return $row['sr_no'];
                    }) 
                    ->addColumn('mutual_fund_holder_name', function($row){
                        return $row['mutual_fund_holder_name'];
                    }) 
                    ->addColumn('mutual_fund_type_id', function($row){
                        return $row->mutual_fund_type['name'];
                    }) 
                    ->addColumn('folio_number', function($row){
                        return $row['folio_number'];
                    }) 
                    ->addColumn('fund_name', function($row){
                        return $row['fund_name'];
                    }) 
                    ->addColumn('fund_type', function($row){
                        return $row['fund_type'];
                    }) 
                    ->addColumn('purchase_date', function($row){
                        return $row['purchase_date'];
                    }) 
                    ->addColumn('amount', function($row){
                        return $row['amount'];
                    }) 
                    ->addColumn('action', function ($row){
                        $btn='';
                        $btn .= '<a href="javascript:void(0)" class="edit btn btn-info btn-sm" onClick="view_mutual_fund('.$row->id.')">View</a>&nbsp;&nbsp;';
                        if(Auth::user()->can('edit-member')) {
                            $btn.='<a href="javascript:void(0)" class="edit btn btn-primary btn-sm" id="edit" onClick="edit_mutual_fund('.$row->id.')">Edit</a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('mutual_fund.view', [
            // 'users' => $data,
            'title'=>'Member',
            'content'=>'Manage Mutual Fund'
        ]);
    }

    
    public function list_vehicle_insurance(Request $request,User $user){
        
        if ($request->ajax()) {
            $data =VehicleInsurance::with('insurance_policy_type','vehicle_category')->where('user_id',$user->id)->get();    
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('sr_no', function($row){
                        return $row['sr_no'];
                    }) 
                    ->addColumn('vehicle_category_id', function($row){
                        return $row->vehicle_category['name'];
                    }) 
                    ->addColumn('vehicle_number', function($row){
                        return $row['vehicle_number'];
                    }) 
                    ->addColumn('vehicle_name', function($row){
                        return $row['vehicle_name'];
                    }) 
                    ->addColumn('insurance_company_name', function($row){
                        return $row['insurance_company_name'];
                    }) 
                    ->addColumn('policy_number', function($row){
                        return $row['policy_number'];
                    }) 
                    ->addColumn('insurance_policy_type_id', function($row){
                        return $row->insurance_policy_type['name'];
                    }) 
                    ->addColumn('action', function ($row){
                        $btn='';
                        $btn .= '<a href="javascript:void(0)" class="edit btn btn-info btn-sm" onClick="view_vehicle_insurance('.$row->id.')">View</a>&nbsp;&nbsp;';
                        if(Auth::user()->can('edit-member')) {
                            $btn.='<a href="javascript:void(0)" class="edit btn btn-primary btn-sm" id="edit" onClick="edit_vehicle_insurance('.$row->id.')">Edit</a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('vehicle_insurance.view', [
            // 'users' => $data,
            'title'=>'Member',
            'content'=>'Manage Vehicle Insurance'
        ]);
    }
    public function list_life_insurance(Request $request,User $user){
        if ($request->ajax()) {
            $data =Lifeinsurance::with('company_name','policy_mode','ppt')->where('user_id',$user->id)->get();    
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('sr_no', function($row){
                        return $row['sr_no'];
                    }) 
                    ->addColumn('policy_holder_name', function($row){
                        return $row['policy_holder_name'];
                    }) 
                    ->addColumn('birth_date', function($row){
                        return $row['birth_date'];
                    }) 
                    ->addColumn('policy_start_date', function($row){
                        return $row['policy_start_date'];
                    }) 
                    ->addColumn('company_name_id', function($row){
                        return $row->company_name['name'];
                    }) 
                    ->addColumn('policy_number', function($row){
                        return $row['policy_number'];
                    }) 
                    ->addColumn('plan_name', function($row){
                        return $row['plan_name'];
                    }) 
                    ->addColumn('ppt_id', function($row){
                        return $row->ppt['name'];
                    }) 
                    ->addColumn('premium_mode_id', function($row){
                        return $row->policy_mode['name'];
                    }) 
                    ->addColumn('action', function ($row){
                        $btn='';
                        $btn .= '<a href="javascript:void(0)" class="edit btn btn-info btn-sm" onClick="view_life_insurance('.$row->id.')">View</a>&nbsp;&nbsp;';
                        if(Auth::user()->can('edit-member')) {
                            $btn.='<a href="javascript:void(0)" class="edit btn btn-primary btn-sm" id="edit"onClick="edit_life_insurance('.$row->id.')">Edit</a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('life_insurance.view', [
            // 'users' => $data,
            'title'=>'Member',
            'content'=>'Manage Life Insurance'
        ]);
    }
    public function show_mediclaim(Request $request,Mediclaim $mediclaim){
        $mediclaims =Mediclaim::with('company_name','policy_type','policy_mode','user')->where('id',$mediclaim->id)->get();
        return view('mediclaim.show', [
            'mediclaim' => $mediclaims,
            'title'=>'Member',
            'content'=>'View Mediclaim'
        ]);
    }
    public function show_vehicle_insurance(Request $request,VehicleInsurance $vehicle_insurance){
        $vehicle_insurances =VehicleInsurance::with('vehicle_category','insurance_policy_type','user')->where('id',$vehicle_insurance->id)->get();
        return view('vehicle_insurance.show', [
            'vehicle_insurance' => $vehicle_insurances,
            'title'=>'Member',
            'content'=>'View Vehicle Insurance'
        ]);
    }
    public function show_mutual_fund(Request $request,Mutualfund $mutual_fund){
        $mutual_funds =Mutualfund::with('mutual_fund_type','user')->where('id',$mutual_fund->id)->get();
        
        return view('mutual_fund.show', [
            'mutual_funds' => $mutual_funds,
            'title'=>'Member',
            'content'=>'View Mutual Fund'
        ]);
    }
    public function show_life_insurance(Request $request,Lifeinsurance $life_insurance){
        $life_insurances =Lifeinsurance::with('company_name','policy_mode','ppt','user')->where('id',$life_insurance->id)->get();
        
        return view('life_insurance.show', [
            'life_insurance' => $life_insurances,
            'title'=>'Member',
            'content'=>'View Life Insurance'
        ]);
    }
    public function edit_mediclaim(Mediclaim $mediclaim){
        $data['mediclaim_id']=$mediclaim->id;
        $data['company_name'] = CompanyName::get(["name", "id"]);
        $data['policy_type'] = PolicyType::get(["name", "id"]);
        $data['policy_mode'] = PolicyMode::get(["name", "id"]);
        $data['mediclaim']=$mediclaim;
        $data['title']='Members';
        $data['content']='Edit Mediclaim';
        return view('mediclaim.edit', $data);
    }
    public function update_mediclaim(Request $request, Mediclaim $mediclaim)
    {
        $request->validate([
            'sr_no' => 'required|numeric',
            'policy_holder_name' => 'required',
            'birth_date' => 'required',
            'policy_start_date' => 'required',
            'company_name' => 'required',
            'policy_number' => 'required|numeric',
            'policy_type' => 'required',
            'sum_assured' => 'required|numeric',
            'policy_name' => 'required',
            'policy_mode' => 'required',
            'premium_amount' => 'required|numeric',
            'yearly_premium_amount' => 'required|numeric',
        ]);
        $input['parent_id'] = auth()->user()->id;
        $input['sr_no'] = $request->sr_no;
        $input['policy_holder_name'] = $request->policy_holder_name;
        $input['birth_date'] = $request->birth_date;
        $input['policy_start_date'] = $request->policy_start_date;
        $input['company_name_id'] = $request->company_name;
        $input['policy_number'] = $request->policy_number;
        $input['policy_type_id'] = $request->policy_type;
        $input['sum_assured'] = $request->sum_assured;
        $input['policy_name'] = $request->policy_name;
        $input['policy_mode_id'] = $request->policy_mode;
        $input['premium_amount'] = $request->premium_amount;
        $input['yearly_premium_amount'] = $request->yearly_premium_amount;
        $input['agent_name'] = $request->agent_name;
        $input['agent_mobile_number'] = $request->agent_mobile_number;
        $input['branch_name'] = $request->branch_name;
        $input['branch_address'] = $request->branch_address;
        $input['branch_contact_no'] = $request->branch_contact_number;
        $input['other_details'] = $request->other_details;
        $start_month = date('m',strtotime($request->policy_start_date));
        if($request->policy_mode=='1'){
            $input['jan'] = $request->premium_amount;
            $input['feb'] = $request->premium_amount;
            $input['mar'] = $request->premium_amount;
            $input['apr'] = $request->premium_amount;
            $input['may'] = $request->premium_amount;
            $input['jun'] = $request->premium_amount;
            $input['jul'] = $request->premium_amount;
            $input['aug'] = $request->premium_amount;
            $input['sep'] = $request->premium_amount;
            $input['oct'] = $request->premium_amount;
            $input['nov'] = $request->premium_amount;
            $input['dec'] = $request->premium_amount;
            $input['single'] = 0;
        }elseif($request->policy_mode=='2'){
            if($start_month==01 || $start_month==04 || $start_month==07 || $start_month==10){
                $input['jan'] = $request->premium_amount;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = $request->premium_amount;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = $request->premium_amount;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = $request->premium_amount;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==02 || $start_month==05  || $start_month=="0008" || $start_month==11 ){
                $input['jan'] = 0;
                $input['feb'] = $request->premium_amount;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = $request->premium_amount;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] =$request->premium_amount;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = $request->premium_amount;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==03 ||$start_month==06 || $start_month=='0009' || $start_month==12){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = $request->premium_amount;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = $request->premium_amount;
                $input['jul'] = 0;
                $input['aug'] =0;
                $input['sep'] = $request->premium_amount;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = $request->premium_amount;
                $input['single'] = 0;
            }
        }elseif($request->policy_mode=='3'){
            if($start_month==01 || $start_month==07){
                $input['jan'] = $request->premium_amount;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = $request->premium_amount;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==02 || $start_month=='0008'){
                $input['jan'] = 0;
                $input['feb'] = $request->premium_amount;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = $request->premium_amount;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==03 || $start_month=='0009'){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = $request->premium_amount;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = $request->premium_amount;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==04 || $start_month==10){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = $request->premium_amount;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = $request->premium_amount;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==05 || $start_month==11){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = $request->premium_amount;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = $request->premium_amount;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==06 || $start_month==12){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = $request->premium_amount;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = $request->premium_amount;
                $input['single'] = 0;
            }
        }
        elseif($request->policy_mode=='4'){
            if($start_month==01){
                $input['jan'] = $request->premium_amount;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==02){
                $input['jan'] = 0;
                $input['feb'] = $request->premium_amount;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==03){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = $request->premium_amount;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==04){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = $request->premium_amount;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==05){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = $request->premium_amount;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==06){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = $request->premium_amount;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==07){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = $request->premium_amount;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month=='0008'){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = $request->premium_amount;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month=='0009'){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = $request->premium_amount;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==10){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = $request->premium_amount;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==11){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = $request->premium_amount;
                $input['dec'] = 0;
                $input['single'] = 0;
            }else{
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = $request->premium_amount;
                $input['single'] = 0;
            }
        }elseif($request->policy_mode=='5'){
            $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = $request->premium_amount;
        }
        $mediclaim->update($input);
        return redirect()->route('mediclaim.edit',$mediclaim->id)->withSuccess('Mediclaim is updated successfully.');
    }
    public function edit_mutual_fund(Mutualfund $mutual_fund){
        $data['mutual_fund_id']=$mutual_fund->id;
        $data['mutual_fund_type'] = MutualFundType::get(["name", "id"]);
        $data['title']='Members';
        $data['mutual_fund']= $mutual_fund;
        $data['content']='Edit Mutual Fund';
        return view('mutual_fund.edit', $data);
    }
    public function update_mutual_fund(Request $request, Mutualfund $mutual_fund)
    {
        
        $request->validate([
            'sr_no' => 'required|numeric',
            'mutual_fund_holder_name' => 'required',
            'mutual_fund_type' => 'required',
            'folio_number' => 'required|numeric',
            'fund_name' => 'required',
            'fund_type' => 'required',
            'purchase_date' => 'required',
            'amount' => 'required|numeric',
            'yearly_amount' => 'required|numeric',
            'nominee_name' => 'required',
            'nominee_relation' => 'required',
            'nominee_dob' => 'required'
        ]);
        $input['parent_id'] = auth()->user()->id;
        $input['sr_no'] = $request->sr_no;
        $input['mutual_fund_holder_name'] = $request->mutual_fund_holder_name;
        $input['mutual_fund_type_id'] = $request->mutual_fund_type;
        $input['folio_number'] = $request->folio_number;
        $input['fund_name'] = $request->fund_name;
        $input['fund_type'] = $request->fund_type;
        $input['purchase_date'] = $request->purchase_date;
        $input['amount'] = $request->amount;
        $input['yearly_amount'] = $request->yearly_amount;
        $input['nominee_name'] = $request->nominee_name;
        $input['nominee_relation'] = $request->nominee_relation;
        $input['nominee_dob'] = $request->nominee_dob;
        $input['agent_name'] = $request->agent_name;
        $input['agent_mobile_number'] = $request->agent_mobile_number;
        $input['other_details'] = $request->other_details;
        $start_month = date('m',strtotime($request->purchase_date));
        if($request->mutual_fund_type=='1'){
            $input['jan'] = 0;
            $input['feb'] = 0;
            $input['mar'] = 0;
            $input['apr'] = 0;
            $input['may'] = 0;
            $input['jun'] = 0;
            $input['jul'] = 0;
            $input['aug'] = 0;
            $input['sep'] = 0;
            $input['oct'] = 0;
            $input['nov'] = 0;
            $input['dec'] = 0;
            $input['single'] = $request->amount;
        }elseif($request->mutual_fund_type=='2'){
            if($start_month==1){
                $input['jan'] = $request->amount;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==2){
                $input['jan'] = 0;
                $input['feb'] = $request->amount;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==3){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = $request->amount;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==4){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = $request->amount; 
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==5){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0; 
                $input['may'] = $request->amount;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==6){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0; 
                $input['may'] = 0;
                $input['jun'] = $request->amount;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==7){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0; 
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = $request->amount;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month=='0008'){
                
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0; 
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = $request->amount;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month=='0009'){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0; 
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = $request->amount;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==10){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0; 
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = $request->amount;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==11){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0; 
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = $request->amount;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==12){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0; 
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = $request->amount;
                $input['single'] = 0;
            }
        }
        $mutual_fund->update($input);
        
        return redirect()->route('mutual_fund.edit',$mutual_fund->id)->withSuccess('Mutual Fund is updated successfully.');
    }
    public function edit_vehicle_insurance(VehicleInsurance $vehicle_insurance){
        $data['vehicle_insurance_id']=$vehicle_insurance->id;
        $data['vehicle_category'] = VehicleCategory::get(["name", "id"]);
        $data['policy_type'] = InsurancePolicyType::get(["name", "id"]);
        $data['ppt'] = Ppt::get(["name", "id"]);
        $data['title']='Members';
        $data['vehicle_insurance']= $vehicle_insurance;
        $data['content']='Edit Vehicle Insurance';
        return view('vehicle_insurance.edit', $data);
        
    }
    public function update_vehicle_insurance(Request $request, VehicleInsurance $vehicle_insurance)
    {
        $request->validate([
            'sr_no' => 'required|numeric',
            'vehicle_category' => 'required',
            'vehicle_number' => 'required',
            'vehicle_name' => 'required',
            'insurance_company_name' => 'required',
            'policy_number' => 'required',
            'chasis_number' => 'required',
            'policy_type' => 'required',
            'policy_premium' => 'required|numeric',
            'vehicle_owner_name' => 'required',
            'policy_start_date' => 'required',
            'policy_end_date' => 'required',
        ]);

        $input['parent_id'] = auth()->user()->id;
        $input['sr_no'] = $request->sr_no;
        $input['vehicle_category_id'] = $request->vehicle_category;
        $input['vehicle_number'] = $request->vehicle_number;
        $input['vehicle_name'] = $request->vehicle_name;
        $input['insurance_company_name'] = $request->insurance_company_name;
        $input['policy_number'] = $request->policy_number;
        $input['chasis_number'] = $request->chasis_number;
        $input['insurance_policy_type_id'] = $request->policy_type;
        $input['policy_premium'] = $request->policy_premium;
        $input['vehicle_owner_name'] = $request->vehicle_owner_name;
        $input['policy_start_date'] = $request->policy_start_date;
        $input['policy_end_date'] = $request->policy_end_date;
        $input['agent_name'] = $request->agent_name;
        $input['agent_mobile_number'] = $request->agent_mobile_number;
        $input['other_details'] = $request->other_details;
        $start_month = date('m',strtotime($request->policy_start_date));
        if($start_month==1){
            $input['jan'] = $request->policy_premium;
            $input['feb'] = 0;
            $input['mar'] = 0;
            $input['apr'] = 0;
            $input['may'] = 0;
            $input['jun'] = 0;
            $input['jul'] = 0;
            $input['aug'] = 0;
            $input['sep'] = 0;
            $input['oct'] = 0;
            $input['nov'] = 0;
            $input['dec'] = 0;
            $input['single'] = 0;
        }elseif($start_month==2){
            $input['jan'] = 0;
            $input['feb'] = $request->policy_premium;
            $input['mar'] = 0;
            $input['apr'] = 0;
            $input['may'] = 0;
            $input['jun'] = 0;
            $input['jul'] = 0;
            $input['aug'] = 0;
            $input['sep'] = 0;
            $input['oct'] = 0;
            $input['nov'] = 0;
            $input['dec'] = 0;
            $input['single'] = 0;
        }elseif($start_month==3){
            $input['jan'] = 0;
            $input['feb'] = 0;
            $input['mar'] = $request->policy_premium;
            $input['apr'] = 0;
            $input['may'] = 0;
            $input['jun'] = 0;
            $input['jul'] = 0;
            $input['aug'] = 0;
            $input['sep'] = 0;
            $input['oct'] = 0;
            $input['nov'] = 0;
            $input['dec'] = 0;
            $input['single'] = 0;
        }elseif($start_month==4){
            $input['jan'] = 0;
            $input['feb'] = 0;
            $input['mar'] = 0;
            $input['apr'] = $request->policy_premium; 
            $input['may'] = 0;
            $input['jun'] = 0;
            $input['jul'] = 0;
            $input['aug'] = 0;
            $input['sep'] = 0;
            $input['oct'] = 0;
            $input['nov'] = 0;
            $input['dec'] = 0;
            $input['single'] = 0;
        }elseif($start_month==5){
            $input['jan'] = 0;
            $input['feb'] = 0;
            $input['mar'] = 0;
            $input['apr'] = 0; 
            $input['may'] = $request->policy_premium;
            $input['jun'] = 0;
            $input['jul'] = 0;
            $input['aug'] = 0;
            $input['sep'] = 0;
            $input['oct'] = 0;
            $input['nov'] = 0;
            $input['dec'] = 0;
            $input['single'] = 0;
        }elseif($start_month==6){
            $input['jan'] = 0;
            $input['feb'] = 0;
            $input['mar'] = 0;
            $input['apr'] = 0; 
            $input['may'] = 0;
            $input['jun'] = $request->policy_premium;
            $input['jul'] = 0;
            $input['aug'] = 0;
            $input['sep'] = 0;
            $input['oct'] = 0;
            $input['nov'] = 0;
            $input['dec'] = 0;
            $input['single'] = 0;
        }elseif($start_month==7){
            $input['jan'] = 0;
            $input['feb'] = 0;
            $input['mar'] = 0;
            $input['apr'] = 0; 
            $input['may'] = 0;
            $input['jun'] = 0;
            $input['jul'] = $request->policy_premium;
            $input['aug'] = 0;
            $input['sep'] = 0;
            $input['oct'] = 0;
            $input['nov'] = 0;
            $input['dec'] = 0;
            $input['single'] = 0;
        }elseif($start_month=='0008'){
            
            $input['jan'] = 0;
            $input['feb'] = 0;
            $input['mar'] = 0;
            $input['apr'] = 0; 
            $input['may'] = 0;
            $input['jun'] = 0;
            $input['jul'] = 0;
            $input['aug'] = $request->policy_premium;
            $input['sep'] = 0;
            $input['oct'] = 0;
            $input['nov'] = 0;
            $input['dec'] = 0;
            $input['single'] = 0;
        }elseif($start_month=='0009'){
            $input['jan'] = 0;
            $input['feb'] = 0;
            $input['mar'] = 0;
            $input['apr'] = 0; 
            $input['may'] = 0;
            $input['jun'] = 0;
            $input['jul'] = 0;
            $input['aug'] = 0;
            $input['sep'] = $request->policy_premium;
            $input['oct'] = 0;
            $input['nov'] = 0;
            $input['dec'] = 0;
            $input['single'] = 0;
        }elseif($start_month==10){
            $input['jan'] = 0;
            $input['feb'] = 0;
            $input['mar'] = 0;
            $input['apr'] = 0; 
            $input['may'] = 0;
            $input['jun'] = 0;
            $input['jul'] = 0;
            $input['aug'] = 0;
            $input['sep'] = 0;
            $input['oct'] = $request->policy_premium;
            $input['nov'] = 0;
            $input['dec'] = 0;
            $input['single'] = 0;
        }elseif($start_month==11){
            $input['jan'] = 0;
            $input['feb'] = 0;
            $input['mar'] = 0;
            $input['apr'] = 0; 
            $input['may'] = 0;
            $input['jun'] = 0;
            $input['jul'] = 0;
            $input['aug'] = 0;
            $input['sep'] = 0;
            $input['oct'] = 0;
            $input['nov'] = $request->policy_premium;
            $input['dec'] = 0;
            $input['single'] = 0;
        }elseif($start_month==12){
            $input['jan'] = 0;
            $input['feb'] = 0;
            $input['mar'] = 0;
            $input['apr'] = 0; 
            $input['may'] = 0;
            $input['jun'] = 0;
            $input['jul'] = 0;
            $input['aug'] = 0;
            $input['sep'] = 0;
            $input['oct'] = 0;
            $input['nov'] = 0;
            $input['dec'] = $request->policy_premium;
            $input['single'] = 0;
        }
        $vehicle_insurance->update($input);
        
        return redirect()->route('vehicle_insurance.edit',$vehicle_insurance->id)->withSuccess('Vehicle Insurance is updated successfully.');
    }
    public function edit_life_insurance(Lifeinsurance $life_insurance){
        $data['life_insurance_id']=$life_insurance->id;
        $data['company_name'] = CompanyName::get(["name", "id"]);
        $data['ppt'] = Ppt::get(["name", "id"]);
        $data['policy_mode'] = PolicyMode::get(["name", "id"]);
        $data['title']='Members';
        $data['life_insurance']= $life_insurance;
        $data['content']='Edit Life Insurance';
        return view('life_insurance.edit', $data);
    }
    public function update_life_insurance(Request $request, Lifeinsurance $life_insurance)
    {
        $request->validate([
            'sr_no' => 'required|numeric',
            'policy_holder_name' => 'required',
            'birth_date' => 'required',
            'policy_start_date' => 'required',
            'company_name' => 'required',
            'policy_number' => 'required|numeric',
            'sum_assured' => 'required|numeric',
            'plan_name' => 'required',
            'ppt' => 'required',
            'policy_term' => 'required',
            'premium_mode' => 'required',
            'premium_amount' => 'required|numeric',
            'yearly_premium_amount' => 'required|numeric',
            'nominee_name' => 'required',
            'nominee_relation' => 'required',
            'nominee_dob' => 'required',
        ]);
        // $input['user_id'] = $request->user_id;
        $input['parent_id'] = auth()->user()->id;
        $input['sr_no'] = $request->sr_no;
        $input['policy_holder_name'] = $request->policy_holder_name;
        $input['birth_date'] = $request->birth_date;
        $input['policy_start_date'] = $request->policy_start_date;
        $input['company_name_id'] = $request->company_name;
        $input['policy_number'] = $request->policy_number;
        $input['sum_assured'] = $request->sum_assured;
        $input['plan_name'] = $request->plan_name;
        $input['ppt_id'] = $request->ppt;
        $input['policy_term'] = $request->policy_term;
        $input['policy_mode_id'] = $request->premium_mode;
        $input['premium_amount'] = $request->premium_amount;
        $input['yearly_premium_amount'] = $request->yearly_premium_amount;
        $input['nominee_name'] = $request->nominee_name;
        $input['nominee_relation'] = $request->nominee_relation;
        $input['nominee_dob'] = $request->nominee_dob;
        $input['agent_name'] = $request->agent_name;
        $input['agent_mobile_number'] = $request->agent_mobile_number;
        $input['branch_name'] = $request->branch_name;
        $input['branch_address'] = $request->branch_address;
        $input['branch_contact_no'] = $request->branch_contact_number;
        $input['other_details'] = $request->other_details;
        $start_month = date('m',strtotime($request->policy_start_date));
        if($request->premium_mode=='1'){
            $input['jan'] = $request->premium_amount;
            $input['feb'] = $request->premium_amount;
            $input['mar'] = $request->premium_amount;
            $input['apr'] = $request->premium_amount;
            $input['may'] = $request->premium_amount;
            $input['jun'] = $request->premium_amount;
            $input['jul'] = $request->premium_amount;
            $input['aug'] = $request->premium_amount;
            $input['sep'] = $request->premium_amount;
            $input['oct'] = $request->premium_amount;
            $input['nov'] = $request->premium_amount;
            $input['dec'] = $request->premium_amount;
            $input['single'] = 0;
        }elseif($request->premium_mode=='2'){
            if($start_month==01 || $start_month==04 || $start_month==07 || $start_month==10){
                $input['jan'] = $request->premium_amount;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = $request->premium_amount;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = $request->premium_amount;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = $request->premium_amount;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==02 || $start_month==05  || $start_month=="0008" || $start_month==11 ){
                $input['jan'] = 0;
                $input['feb'] = $request->premium_amount;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = $request->premium_amount;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] =$request->premium_amount;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = $request->premium_amount;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==03 ||$start_month==06 || $start_month=='0009' || $start_month==12){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = $request->premium_amount;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = $request->premium_amount;
                $input['jul'] = 0;
                $input['aug'] =0;
                $input['sep'] = $request->premium_amount;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = $request->premium_amount;
                $input['single'] = 0;
            }
        }elseif($request->premium_mode=='3'){
            if($start_month==01 || $start_month==07){
                $input['jan'] = $request->premium_amount;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = $request->premium_amount;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==02 || $start_month=='0008'){
                $input['jan'] = 0;
                $input['feb'] = $request->premium_amount;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = $request->premium_amount;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==03 || $start_month=='0009'){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = $request->premium_amount;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = $request->premium_amount;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==04 || $start_month==10){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = $request->premium_amount;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = $request->premium_amount;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==05 || $start_month==11){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = $request->premium_amount;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = $request->premium_amount;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==06 || $start_month==12){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = $request->premium_amount;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = $request->premium_amount;
                $input['single'] = 0;
            }
        }
        elseif($request->premium_mode=='4'){
            if($start_month==01){
                $input['jan'] = $request->premium_amount;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==02){
                $input['jan'] = 0;
                $input['feb'] = $request->premium_amount;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==03){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = $request->premium_amount;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==04){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = $request->premium_amount;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0; 
            }elseif($start_month==05){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = $request->premium_amount;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==06){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = $request->premium_amount;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==07){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = $request->premium_amount;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month=='0008'){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = $request->premium_amount;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month=='0009'){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = $request->premium_amount;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==10){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = $request->premium_amount;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = 0;
            }elseif($start_month==11){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = $request->premium_amount;
                $input['dec'] = 0;
                $input['single'] = 0;
            }else{
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = $request->premium_amount;
                $input['single'] = 0;
            }
        }elseif($request->premium_mode=='5'){
                $input['jan'] = 0;
                $input['feb'] = 0;
                $input['mar'] = 0;
                $input['apr'] = 0;
                $input['may'] = 0;
                $input['jun'] = 0;
                $input['jul'] = 0;
                $input['aug'] = 0;
                $input['sep'] = 0;
                $input['oct'] = 0;
                $input['nov'] = 0;
                $input['dec'] = 0;
                $input['single'] = $request->premium_amount;
        }
        $life_insurance->update($input);
        return redirect()->route('life_insurance.edit',$life_insurance->id)->withSuccess('Life Insurance is updated successfully.');
    }
    public function view_insurance_report(Request $request,User $user){
        
        if ($request->ajax()) {
            $d3=array();
            $data = User::with('mediclaim','life_insurance','mutual_fund','vehicle_insurance')->where('id',$user->id)->first()->toArray();
            
            $d3 = array_merge($data['mediclaim'],$data['life_insurance'],$data['mutual_fund'],$data['vehicle_insurance']);
            
            return Datatables::of($d3)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    if(isset($row['policy_name'])){
                        return $row['policy_name'];
                    }elseif(isset($row['fund_name'])){
                        return $row['fund_name'];
                    }elseif(isset($row['plan_name'])){
                        return $row['plan_name'];
                    }elseif(isset($row['insurance_company_name'])){
                        return $row['insurance_company_name'];
                    }
                }) 
                ->addColumn('jan', function($row){
                    return $row['jan'];
                }) 
                ->addColumn('feb', function($row){
                    return $row['feb'];
                }) 
                ->addColumn('mar', function($row){
                    return $row['mar'];
                }) 
                ->addColumn('apr', function($row){
                    return $row['apr'];
                }) 
                ->addColumn('may', function($row){
                    return $row['may'];
                }) 
                ->addColumn('jun', function($row){
                    return $row['jun'];
                }) 
                ->addColumn('jul', function($row){
                    return $row['jul'];
                }) 
                ->addColumn('aug', function($row){
                    return $row['aug'];
                }) 
                ->addColumn('sep', function($row){
                    return $row['sep'];
                }) 
                ->addColumn('oct', function($row){
                    return $row['oct'];
                }) 
                ->addColumn('nov', function($row){
                    return $row['nov'];
                }) 
                ->addColumn('dec', function($row){
                    return $row['dec'];
                })
                ->addColumn('single', function($row){
                    return $row['single'];
                }) 
                ->addColumn('total', function($row){
                    return $row['jan']+$row['feb']+$row['mar']+$row['apr']+$row['may']+$row['jun']+$row['jul']+$row['aug']+$row['sep']+$row['oct']+$row['nov']+$row['dec']+$row['single'];
                }) 
                ->make(true);
        }
        
        return view('members.reports', [
            // 'users' => $data,
            'title'=>'Member',
            'content'=>'Manage Report'
        ]);
    }
    public function member_export(Request $request,User $user) 
    {
        return Excel::download(new MembersExport($user->id), 'report.xlsx');
    }
    public function generate_pdf(Request $request,User $user)
    {
        $users = User::get();
        $data = [
            'title' => 'Welcome to Funda of Web IT - fundaofwebit.com',
            'date' => date('m/d/Y'),
            'users' => $users
        ];
        $pdf = PDF::loadView('members.member_reports', $data);
        return $pdf->download('users-lists.pdf');
    }
    public function all_mediclaim(Request $request)
    {
        
        if ($request->ajax()) {
            $data =Mediclaim::with('company_name','policy_type','policy_mode')->get();
            // $data = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles')->whereHas('roles', function($query) {
            //     $query->where('name','member');
            // })->get();
          
            // $data = User::find(auth()->user()->id)->descendants()->depthFirst()->get();
            return Datatables::of($data)
            ->addIndexColumn()
                    ->addColumn('sr_no', function($row){
                        return $row->sr_no;
                    }) 
                    ->addColumn('policy_holder_name', function($row){
                        return $row->policy_holder_name;
                    }) 
                    ->addColumn('birth_date', function($row){
                        return $row->birth_date;
                    }) 
                    ->addColumn('policy_start_date', function($row){
                        return $row->policy_start_date;
                    }) 
                    ->addColumn('company_name', function($row){
                        return $row->company_name->name;
                    }) 
                    ->addColumn('policy_number', function($row){
                        return $row->policy_number;
                    }) 
                    ->addColumn('policy_type', function($row){
                        return $row->policy_type->name;
                    }) 
                    ->addColumn('sum_assured', function($row){
                        return $row->sum_assured;
                    }) 
                    ->addColumn('policy_name', function($row){
                        return $row->policy_name;
                    }) 
                    ->addColumn('policy_mode', function($row){
                        return $row->policy_mode->name;
                    })
                    ->addColumn('premium_amount', function($row){
                        return $row->premium_amount;
                    }) 
                    ->addColumn('yearly_premium_amount', function($row){
                        return $row->yearly_premium_amount;
                    }) 
                    ->addColumn('agent_name', function($row){
                        return $row->agent_name;
                    }) 
                    ->addColumn('agent_mobile_number', function($row){
                        return $row->agent_mobile_number;
                    }) 
                    ->addColumn('branch_name', function($row){
                        return $row->branch_name;
                    }) 
                    ->addColumn('branch_address', function($row){
                        return $row->branch_address;
                    }) 
                    ->addColumn('branch_contact_no', function($row){
                        return $row->branch_contact_no;
                    }) 
                    ->addColumn('other_details', function($row){
                        return $row->other_details;
                    }) 
                    
                    ->make(true);
        }
        
        return view('members.all_mediclaims', [
            // 'users' => $data,
            'title'=>'Member',
            'content'=>'Manage Mediclaim'
        ]);
    } 
    public function all_vehicle_insurance(Request $request)
    {
        $data =VehicleInsurance::with('user','vehicle_category','insurance_policy_type')->where('parent_id',auth()->user()->id)->get();
        if ($request->ajax()) {
            // $data = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles')->whereHas('roles', function($query) {
            //     $query->where('name','member');
            // })->get();
            

            // $data = User::find(auth()->user()->id)->descendants()->depthFirst()->get();
            return Datatables::of($data)
            ->addIndexColumn()
                    ->addColumn('sr_no', function($row){
                        return $row->sr_no;
                    }) 
                    ->addColumn('vehicle_category_id', function($row){
                        return $row->vehicle_category->name;
                    }) 
                    ->addColumn('vehicle_number', function($row){
                        return $row->vehicle_number;
                    }) 
                    ->addColumn('vehicle_name', function($row){
                        return $row->vehicle_name;
                    }) 
                    ->addColumn('chasis_number', function($row){
                        return $row->chasis_number;
                    }) 
                    ->addColumn('insurance_company_name', function($row){
                        return $row->insurance_company_name;
                    }) 
                    ->addColumn('policy_number', function($row){
                        return $row->policy_number;
                    }) 
                    ->addColumn('insurance_policy_type_id', function($row){
                        return $row->insurance_policy_type->name;
                    }) 
                    ->addColumn('policy_premium', function($row){
                        return $row->policy_premium;
                    }) 
                    ->addColumn('vehicle_owner_name', function($row){
                        return $row->vehicle_owner_name;
                    })
                    ->addColumn('policy_start_date', function($row){
                        return $row->policy_start_date;
                    }) 
                    ->addColumn('policy_end_date', function($row){
                        return $row->policy_end_date;
                    }) 
                    ->addColumn('agent_name', function($row){
                        return $row->agent_name;
                    }) 
                    ->addColumn('agent_mobile_number', function($row){
                        return $row->agent_mobile_number;
                    }) 
                    ->addColumn('other_details', function($row){
                        return $row->other_details;
                    }) 
                    
                    ->make(true);
        }
        
        return view('members.all_vehicle_insurance', [
            // 'users' => $data,
            'title'=>'Member',
            'content'=>'Manage Vehicle Insurance'
        ]);
    } 
    public function all_life_insurance(Request $request)
    {
            if ($request->ajax()) {
            $data =Lifeinsurance::with('company_name','ppt','policy_mode')->get();
            // $data = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles')->whereHas('roles', function($query) {
            //     $query->where('name','member');
            // })->get();
            
            // $data = User::find(auth()->user()->id)->descendants()->depthFirst()->get();
            return Datatables::of($data)
            ->addIndexColumn()
                    ->addColumn('sr_no', function($row){
                        return $row->sr_no;
                    }) 
                    ->addColumn('policy_holder_name', function($row){
                        return $row->policy_holder_name;
                    }) 
                    ->addColumn('birth_date', function($row){
                        return $row->birth_date;
                    }) 
                    ->addColumn('policy_start_date', function($row){
                        return $row->policy_start_date;
                    }) 
                    ->addColumn('company_name_id', function($row){
                        return $row->company_name_id->name;
                    }) 
                    ->addColumn('policy_number', function($row){
                        return $row->policy_number;
                    }) 
                    ->addColumn('sum_assured', function($row){
                        return $row->sum_assured;
                    }) 
                    ->addColumn('plan_name', function($row){
                        return $row->plan_name;
                    }) 
                    ->addColumn('ppt_id', function($row){
                        return $row->ppt_id_>name;
                    }) 
                    ->addColumn('policy_term', function($row){
                        return $row->policy_term;
                    }) 
                    ->addColumn('policy_mode_id', function($row){
                        return $row->policy_mode_id->name;
                    }) 
                    ->addColumn('premium_amount', function($row){
                        return $row->premium_amount;
                    })
                    ->addColumn('yearly_premium_amount', function($row){
                        return $row->yearly_premium_amount;
                    }) 
                    ->addColumn('nominee_name', function($row){
                        return $row->nominee_name;
                    }) 
                    ->addColumn('nominee_relation', function($row){
                        return $row->nominee_relation;
                    }) 
                    ->addColumn('nominee_dob', function($row){
                        return $row->nominee_dob;
                    }) 
                    ->addColumn('agent_name', function($row){
                        return $row->agent_name;
                    }) 
                    ->addColumn('agent_mobile_number', function($row){
                        return $row->agent_mobile_number;
                    }) 
                    ->addColumn('branch_name', function($row){
                        return $row->branch_name;
                    }) 
                    ->addColumn('branch_address', function($row){
                        return $row->branch_address;
                    }) 
                    ->addColumn('branch_contact_no', function($row){
                        return $row->branch_contact_no;
                    }) 
                    ->addColumn('other_details', function($row){
                        return $row->other_details;
                    }) 
                    
                    ->make(true);
        }
        
        return view('members.all_life_insurances', [
            // 'users' => $data,
            'title'=>'Member',
            'content'=>'Manage Life Insurance'
        ]);
    } 
    public function all_mutual_fund(Request $request)
    {
        if ($request->ajax()) {
            $data =Mutualfund::with('mutual_fund_type')->get();
            // $data = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles')->whereHas('roles', function($query) {
            //     $query->where('name','member');
            // })->get();
            
            // $data = User::find(auth()->user()->id)->descendants()->depthFirst()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('sr_no', function($row){
                    return $row->sr_no;
                }) 
                ->addColumn('mutual_fund_holder_name', function($row){
                    return $row->mutual_fund_holder_name;
                }) 
                ->addColumn('mutual_fund_type_id', function($row){
                    return $row->mutual_fund_type_id;
                }) 
                ->addColumn('folio_number', function($row){
                    return $row->folio_number;
                }) 
                ->addColumn('fund_name', function($row){
                    return $row->fund_name;
                }) 
                ->addColumn('fund_type', function($row){
                    return $row->fund_type;
                }) 
                ->addColumn('purchase_date', function($row){
                    return $row->purchase_date;
                }) 
                ->addColumn('amount', function($row){
                    return $row->amount;
                }) 
                ->addColumn('yearly_amount', function($row){
                    return $row->yearly_amount;
                }) 
                ->addColumn('nominee_name', function($row){
                    return $row->nominee_name->name;
                }) 
                ->addColumn('nominee_relation', function($row){
                    return $row->nominee_relation;
                })
                ->addColumn('nominee_dob', function($row){
                    return $row->nominee_dob;
                }) 
                ->addColumn('agent_name', function($row){
                    return $row->agent_name;
                }) 
                ->addColumn('agent_mobile_number', function($row){
                    return $row->agent_mobile_number;
                }) 
                ->addColumn('other_details', function($row){
                    return $row->other_details;
                }) 
                ->make(true);
        }
        
        return view('members.all_mutual_funds', [
            'title'=>'Member',
            'content'=>'Manage Mututal Fund'
        ]);
    } 
}
