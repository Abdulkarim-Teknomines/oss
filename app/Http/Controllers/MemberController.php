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
use App\Models\MediclaimCompany;
use App\Models\LifeInsuranceCompany;
use App\Models\VehicleInsuranceCompany;
use App\Models\PolicyType;
use App\Models\VehicleCategory;
use App\Models\VehicleInsurance;
use App\Models\Children;
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
                        return $row['name'].' '.$row['middle_name'].' '.$row['surname'];
                    }) 
                    ->addColumn('mediclaim', function($row){
                        return '<a href="javascript:void(0)" class="edit fa fa-plus btn-lg" id="edits" onClick="add_mediclaim('.$row->id.')"></a>
                        <a href="javascript:void(0)" class="edit fa fa-eye btn-lg" id="edits" onClick="view_mediclaim('.$row->id.')"></a>';
                        
                        return $bcc;
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
            $user_id = 'MEM'.str_pad($user->id, 5, '0', STR_PAD_LEFT);
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
            $url = route('login');
            $mailData = [
                'title' => 'Mail from www.onestopsolutiondatamanagement.com',
                'body' => 'Login With Below Credentials',
                'url'=>'<a href="{{$url}}">Click to Login</a>',
                'username'=>$user->email,
                'password'=>$password
            ];
            Mail::to($user->email)->send(new DemoMail($mailData));
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
        
        $request->validate([
            'name' => 'required',
            'middle_name' => 'required',
            'surname' => 'required',
            'mobile_number' => 'required|numeric',
            'birth_date' => 'required',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email,'.$user->id,
            'father_name' => 'required',
            'mother_name' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
        ]); 
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
        $data['company_name'] = MediclaimCompany::get(["name", "id"]);
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
            'policy_end_date' => 'required',
            'company_name' => 'required',
            'policy_number' => 'required|unique:mediclaims',
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
        $input['policy_end_date'] = $request->policy_end_date;
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
        $input['category'] = 'Mediclaim';
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
        $data['company_name'] = LifeInsuranceCompany::get(["name", "id"]);
        $data['ppt'] = Ppt::get(["name", "id"]);
        $data['policy_mode'] = PolicyMode::get(["name", "id"]);
        
        $data['title']='Members';
        $data['content']='Create Life Insurance';
        return view('life_insurance.create', $data);
    }
    public function store_life_insurance(Request $request){
        // dd($request->all());
        $request->validate([
            'sr_no' => 'required|numeric',
            'policy_holder_name' => 'required',
            'birth_date' => 'required',
            'policy_start_date' => 'required',
            'company_name' => 'required',
            'policy_number' => 'required|unique:lifeinsurances',
            'sum_assured' => 'required|numeric',
            'plan_name' => 'required',
            'plan_type_id' => 'required',
            'ppt_end_date'=>'required',
            'ppt' => 'required',
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
        $input['ppt'] = $request->ppt;
        $input['ppt_end_date']=$request->ppt_end_date;
        $input['policy_holder_name'] = $request->policy_holder_name;
        $input['birth_date'] = $request->birth_date;
        $input['policy_start_date'] = $request->policy_start_date;
        $input['company_name_id'] = $request->company_name;
        $input['policy_number'] = $request->policy_number;
        $input['sum_assured'] = $request->sum_assured;
        $input['plan_name'] = $request->plan_name;
        $input['plan_type_id'] = $request->plan_type_id;
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
        $input['category'] = 'Life Insurance';
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
        $data['company'] = VehicleInsuranceCompany::get(["name", "id"]);
        
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
            'company_name_id' => 'required',
            'policy_number' => 'required|unique:vehicle_insurances',
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
        $input['company_name_id'] = $request->company_name_id;
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
        $input['category']='Vehicle Insurance';
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
            'folio_number' => 'required',
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
        $input['category'] = 'Mutual Fund';
        $start_month = date('m',strtotime($request->purchase_date)); 
        if($request->mutual_fund_type=='1'){
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
        }elseif($request->mutual_fund_type=='2'){
            
                $input['jan'] = $request->amount;
                $input['feb'] = $request->amount;
                $input['mar'] = $request->amount;
                $input['apr'] = $request->amount; 
                $input['may'] = $request->amount;
                $input['jun'] = $request->amount;
                $input['jul'] = $request->amount;
                $input['aug'] = $request->amount;
                $input['sep'] = $request->amount;
                $input['oct'] = $request->amount;
                $input['nov'] = $request->amount;
                $input['dec'] = $request->amount;
                $input['single'] = 0;
            }else{
                $input['single'] = 0;
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
            ->addColumn('policy_end_date', function($row){
                return $row['policy_end_date'];
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
                // if(Auth::user()->can('edit-mediclaim')) {
                    if(Auth::user()->hasRole('Agent')){
                    $btn.='<a href="javascript:void(0)" class="edit_mediclaim btn btn-primary btn-sm" id="edit_mediclaim"  onClick="edit_mediclaim('.$row->id.')">Edit</a>';
                }
                // }
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
            $data =VehicleInsurance::with('company_name','insurance_policy_type','vehicle_category')->where('user_id',$user->id)->get();    
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
            ->addColumn('company_name_id', function($row){
                return $row->company_name['name'];
            }) 
            ->addColumn('policy_number', function($row){
                return $row['policy_number'];
            }) 
            ->addColumn('insurance_policy_type_id', function($row){
                return $row->insurance_policy_type['name'];
            }) 
            ->addColumn('policy_premium', function($row){
                return $row['policy_premium'];
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
        $data =Lifeinsurance::with('company_name','policy_mode')->where('user_id',$user->id)->get();    
        if ($request->ajax()) {
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
                    return $row['ppt'].' Year';
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
        $vehicle_insurances =VehicleInsurance::with('company_name','vehicle_category','insurance_policy_type','user')->where('id',$vehicle_insurance->id)->get();
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
        $data['company_name'] = MediclaimCompany::get(["name", "id"]);
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
            'policy_end_date' => 'required',
            'company_name' => 'required',
            'policy_number' => 'required|unique:mediclaims,policy_number,'.$mediclaim->id,
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
        $input['policy_end_date'] = $request->policy_end_date;
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
        $input['category']= 'Mediclaim';
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
            'folio_number' => 'required',
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
        $input['category']='Mutual Fund';
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
        $data['company_name'] = VehicleInsuranceCompany::get(["name", "id"]);
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
            'company_name_id' => 'required',
            'policy_number' => 'required|unique:vehicle_insurances,policy_number,'.$vehicle_insurance->id,
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
        $input['company_name_id'] = $request->company_name_id;
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
        $input['category']= 'Vehicle Insurance';
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
        $data['company_name'] = LifeInsuranceCompany::get(["name", "id"]);
        $data['ppt'] = Ppt::get(["name", "id"]);
        $data['policy_mode'] = PolicyMode::get(["name", "id"]);
        $data['title']='Members';
        $data['life_insurance']= $life_insurance;
        $data['content']='Edit Life Insurance';
        return view('life_insurance.edit', $data);
    }
    public function update_life_insurance(Request $request, Lifeinsurance $life_insurance)
    {
        // dd($request->all());
        $request->validate([
            'sr_no' => 'required|numeric',
            'policy_holder_name' => 'required',
            'birth_date' => 'required',
            'policy_start_date' => 'required',
            'company_name' => 'required',
            'policy_number' => 'required|unique:lifeinsurances,policy_number,'.$life_insurance->id,
            'sum_assured' => 'required|numeric',
            'plan_name' => 'required',
            'plan_type_id' => 'required',
            'ppt_end_date'=>'required',
            'ppt' => 'required',
            'premium_mode' => 'required',
            'premium_amount' => 'required|numeric',
            'yearly_premium_amount' => 'required|numeric',
            'nominee_name' => 'required',
            'nominee_relation' => 'required',
            'nominee_dob' => 'required',
        ]);
        
        $input['parent_id'] = auth()->user()->id;
        $input['sr_no'] = $request->sr_no;
        $input['ppt'] = $request->ppt;
        $input['ppt_end_date']=$request->ppt_end_date;
        $input['policy_holder_name'] = $request->policy_holder_name;
        $input['birth_date'] = $request->birth_date;
        $input['policy_start_date'] = $request->policy_start_date;
        $input['company_name_id'] = $request->company_name;
        $input['policy_number'] = $request->policy_number;
        $input['sum_assured'] = $request->sum_assured;
        $input['plan_name'] = $request->plan_name;
        $input['plan_type_id'] = $request->plan_type_id;
        // $input['policy_term'] = $request->policy_term;
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
        $input['category'] = 'Life Insurance';
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
        return redirect()->route('life_insurance.view',$life_insurance->user_id)->withSuccess('Life Insurance is updated successfully.');
    }
    public function view_insurance_report(Request $request,User $user){
        
        if ($request->ajax()) {
            if(Auth::User()->hasRole('Member')){
                $data = User::with('mediclaim','life_insurance','mutual_fund','vehicle_insurance')->where('id',Auth::User()->id)->first()->toArray();
            }else{
                $data = User::with('mediclaim','life_insurance','mutual_fund','vehicle_insurance')->where('id',$user->id)->first()->toArray();
            }
            $d3=array();
            $d3 = array_merge($data['mediclaim'],$data['life_insurance'],$data['mutual_fund'],$data['vehicle_insurance']);
            return Datatables::of($d3)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    if(isset($row['policy_holder_name'])){
                        return $row['policy_holder_name'];
                    }elseif(isset($row['mutual_fund_holder_name'])){
                        return $row['mutual_fund_holder_name'];
                    }elseif(isset($row['vehicle_owner_name'])){
                        return $row['vehicle_owner_name'];
                    }
                }) 
                ->addColumn('category', function($row){
                    return $row['category'];
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
                    return $row['jan']+$row['feb']+$row['mar']+$row['apr']+$row['may']+$row['jun']+$row['jul']+$row['aug']+$row['sep']+$row['oct']+$row['nov']+$row['dec'];
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
        $date = Date('Y-m-d h:i:s');
        return Excel::download(new MembersExport($user->id), $date.'report.xlsx');
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
            if(Auth::User()->hasRole('Member')){
                $data = Mediclaim::with('company_name','policy_type','policy_mode')->where('user_id',Auth::User()->id)->get();
            }else{
                $data = Mediclaim::with('company_name','policy_type','policy_mode')->get();
            }
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
                    ->addColumn('action', function ($row){
                        $btn='';
                        $btn .= '<a href="all_mediclaim/'.$row['id'].'/view" class="edit btn btn-info btn-sm">View</a>&nbsp;&nbsp;';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    
                    ->make(true);
        }
        
        return view('members.all_mediclaims', [
            // 'users' => $data,
            'title'=>'Member',
            'content'=>'Manage Mediclaim'
        ]);
    } 
    public function all_mediclaim_monthly(Request $request)
    {
        if ($request->ajax()) {
                $date = $request->date;
                $dt = $request->date;
                $dts = date('M', strtotime($dt));
                $dtss = strtolower($dts);

                $data =Mediclaim::with('company_name','policy_type','policy_mode')->where($dtss,'!=',0)->get();
            
                
           return Datatables::of($data)
            ->addIndexColumn()
                    ->addColumn('sr_no', function($row){
                        return $row->sr_no;
                    }) 
                    ->addColumn('policy_holder_name', function($row){
                        return $row->policy_holder_name;
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
                    ->addColumn('policy_name', function($row){
                        return $row->policy_name;
                    }) 
                    ->addColumn('preium_amount', function($row){
                        return $row->birth_date;
                    }) 
                    ->addColumn('policy_mode', function($row){
                        return $row->policy_mode->name;
                    })
                    ->addColumn('yearly_premium_amount', function($row){
                        return $row->yearly_premium_amount;
                    }) 
                    ->addColumn('action', function ($row){
                        $btn='';
                        $btn .= '<a href="javascript:void(0)" class="edit btn btn-info btn-sm" view_mediclaim_monthly('.$row->id.')">View</a>&nbsp;&nbsp;';
                        return $btn;
                    })
                    ->rawColumns(['action','yearly_premium_amount'])
                    
                    ->make(true);
        }
        
        return view('members.all_mediclaims_monthly', [
            // 'users' => $data,
            'title'=>'Member',
            'content'=>'Manage Mediclaim'
        ]);
    } 
    public function all_mediclaim_yearly(Request $request)
    {
        if ($request->ajax()) {
            
            $data =Mediclaim::with('company_name','policy_type','policy_mode')->get();
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
                    ->addColumn('policy_name', function($row){
                        return $row->policy_name;
                    }) 
                    ->addColumn('policy_mode', function($row){
                        return $row->policy_mode->name;
                    })
                    ->addColumn('yearly_premium_amount', function($row){
                        return $row->yearly_premium_amount;
                    }) 
                    ->addColumn('action', function ($row){
                        $btn='';
                        $btn .= '<a href="javascript:void(0)" class="edit btn btn-info btn-sm" view_mediclaim_yearly('.$row->id.')">View</a>&nbsp;&nbsp;';
                        return $btn;
                    })
                    ->rawColumns(['action','yearly_premium_amount'])
                    
                    ->make(true);
        }
        
        return view('members.all_mediclaims_yearly', [
            // 'users' => $data,
            'title'=>'Member',
            'content'=>'Manage Mediclaim'
        ]);
    }

    public function all_vehicle_insurance(Request $request)
    {
        if ($request->ajax()) {
            
            if(Auth::User()->hasRole('Member')){
                $data =VehicleInsurance::with('company_name','user','vehicle_category','insurance_policy_type')->where('user_id',Auth::User()->id)->get();
            }else{
                $data =VehicleInsurance::with('company_name','user','vehicle_category','insurance_policy_type')->get();
            }
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
                    ->addColumn('company_name_id', function($row){
                        return $row->company_name->name;
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
                    ->addColumn('action', function ($row){
                        $btn='';
                        $btn .= '<a href="all_vehicle_insurance/'.$row['id'].'/view" class="edit btn btn-info btn-sm">View</a>&nbsp;&nbsp;';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    
                    
                    ->make(true);
        }
        
        return view('members.all_vehicle_insurance', [
            // 'users' => $data,
            'title'=>'Member',
            'content'=>'Manage Vehicle Insurance'
        ]);
    } 
    public function all_vehicle_insurance_monthly(Request $request)
    {
        if ($request->ajax()) {
                $dt = $request->date;
                $dts = date('M', strtotime($dt));
                $dtss = strtolower($dts);
                $data = VehicleInsurance::with('company_name','user','vehicle_category','insurance_policy_type')->where($dtss,'!=',0)->get();
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
                    ->addColumn('company_name_id', function($row){
                        return $row->company_name->name;
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
                    ->addColumn('action', function ($row){
                        $btn='';
                        
                        $btn .= '<a href="javascript:void(0)" class="edit btn btn-info btn-sm" onClick="view_vehicle_insurance_monthly('.$row->id.')">View</a>&nbsp;&nbsp;';
                        return $btn;
                    })
                    ->rawColumns(['action','policy_premium'])
                    
                    
                    ->make(true);
        }
        
        return view('members.all_vehicle_insurance_monthly', [
            // 'users' => $data,
            'title'=>'Member',
            'content'=>'Manage Vehicle Insurance'
        ]);
    } 
    public function all_vehicle_insurance_yearly(Request $request)
    {
        if ($request->ajax()) {
                $data =VehicleInsurance::with('company_name','user','vehicle_category','insurance_policy_type')->get();
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
                    ->addColumn('company_name_id', function($row){
                        return $row->company_name->name;
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
                    ->addColumn('action', function ($row){
                        $btn='';
                        
                        $btn .= '<a href="javascript:void(0)" class="edit btn btn-info btn-sm" onClick="view_vehicle_insurance_yearly('.$row->id.')">View</a>&nbsp;&nbsp;';
                        return $btn;
                    })
                    ->rawColumns(['action','policy_premium'])
                    
                    
                    ->make(true);
        }
        
        return view('members.all_vehicle_insurance_yearly', [
            // 'users' => $data,
            'title'=>'Member',
            'content'=>'Manage Vehicle Insurance'
        ]);
    } 
    public function all_life_insurance(Request $request)
        { 
            if ($request->ajax()) {
                if(Auth::User()->hasRole('Member')){
                    $data =Lifeinsurance::with('company_name','ppt','policy_mode')->where('user_id',Auth::User()->id)->get();
                }else{
                    $data =Lifeinsurance::with('company_name','ppt','policy_mode')->get();
                }
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
                        return $row->company_name->name;
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
                        return $row->ppt;
                    }) 
                    ->addColumn('premium_mode', function($row){
                        return $row->policy_mode->name;
                    }) 
                    ->addColumn('action', function ($row){
                        $btn='';
                        $btn .= '<a href="all_life_insurance/'.$row['id'].'/view" class="edit btn btn-info btn-sm">View</a>&nbsp;&nbsp;';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('members.all_life_insurances', [
            // 'users' => $data,
            'title'=>'Member',
            'content'=>'Manage Life Insurance'
        ]);
    } 
    public function all_life_insurance_monthly(Request $request)
        {  
            if ($request->ajax()) {
                $dt = $request->date;
                $dts = date('M', strtotime($dt));
                $dtss = strtolower($dts);
                $datas = Lifeinsurance::with('company_name','ppt','policy_mode')->where($dtss,'!=',0)->get();
                return Datatables::of($datas)
                ->addIndexColumn()
                ->addColumn('sr_no', function($row){
                    return $row->sr_no;
                }) 
                ->addColumn('policy_holder_name', function($row){
                    return $row->policy_holder_name;
                }) 
                ->addColumn('policy_start_date', function($row){
                    return $row->policy_start_date;
                }) 
                ->addColumn('company_name_id', function($row){
                    return $row->company_name->name;
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
                ->addColumn('premium_amount', function($row){
                    return $row->premium_amount;
                }) 
                ->addColumn('premium_mode', function($row){
                    return $row->policy_mode->name;
                }) 
                ->addColumn('yearly_premium_amount', function($row){
                    return $row->yearly_premium_amount;
                }) 
                ->addColumn('action', function ($row){
                    $btn='';
                    $btn .= '<a href="javascript:void(0)" class="view btn btn-info btn-sm"  onClick="view_life_insurance_monthly('.$row->id.')">View</a>&nbsp;&nbsp;';
                    return $btn;
                })
                ->rawColumns(['action','yearly_premium_amount'])
                ->make(true);
            }
        
        return view('members.all_life_insurance_monthly', [
            // 'users' => $data,
            'title'=>'Member',
            'content'=>'Manage Life Insurance'
        ]);
    } 
    public function member_life_insurance(Request $request)
    { 
        if ($request->ajax()) {
            $new_array = [];
            // $life_insurance = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles','member','country','state','city','life_insurance')->whereHas('roles', function($query) {
            //     $query->where('name','member');
            // })->get();
            $life_insurance = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles','member','country','state','city','life_insurance')->whereHas('roles', function($query) {
                $query->where('name','member');
            })->get();
            if(!empty($life_insurance)){
                foreach($life_insurance as $li){
                    foreach($li->life_insurance as $list){
                        $company_name_id = LifeInsuranceCompany::find($list->company_name_id)->first();
                        $policy_mode = PolicyMode::find($list->policy_mode_id)->first();
                        $new_array[] =array(
                            'id'=>$list->id,
                            'sr_no'=>$list->sr_no,
                            'policy_holder_name'=>$list->policy_holder_name,
                            'birth_date'=>$list->birth_date,
                            'policy_start_date'=>$list->policy_start_date,
                            'company_name'=>$company_name_id->name,
                            'policy_number'=>$list->policy_number,
                            'sum_assured'=>$list->sum_assured,
                            'plan_name'=>$list->plan_name,
                            'policy_mode'=>$policy_mode->name,
                            'yearly_premium_amount'=>$list->yearly_premium_amount,
                        );
                    }
    
                }
            }
            
            // $data =User::find(auth()->user()->id)->descendants()->depthFirst()->with('life_insurance')->whereHas('life_insurance', function($query) {
            //     $query->where('parent_id',auth()->user()->id);
            // })->get();
            
            // $data =Auth::User()::with('company_name','ppt','policy_mode')->get();
                return Datatables::of($new_array)
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
                    return $row['company_name'];
                }) 
                ->addColumn('policy_number', function($row){
                    return $row['policy_number'];
                }) 
                ->addColumn('sum_assured', function($row){
                    return $row['sum_assured'];
                }) 
                ->addColumn('plan_name', function($row){
                    return $row['plan_name'];
                }) 
                ->addColumn('premium_mode', function($row){
                    return $row['policy_mode'];
                }) 
                ->addColumn('yearly_premium_amount', function($row){
                    return $row['yearly_premium_amount'];
                }) 
                ->addColumn('action', function ($row){
                    $btn='';
                    $btn .= '<a href="javascript:void(0)" class="edit btn btn-info btn-sm" onClick="view_life_insurance_yearly('.$row['id'].')">View</a>&nbsp;&nbsp;';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
                
                
        }
    
        return view('members.member_life_insurance', [
            // 'users' => $data,
            'title'=>'Member',
            'content'=>'Manage Life Insurance'
        ]);
    } 
    public function member_mediclaim(Request $request)
    {
        if ($request->ajax()) {
            $new_array = [];
            $mediclaim = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles','mediclaim')->whereHas('roles', function($query) {
                $query->where('name','member');
            })->get();
            
            if(!empty($mediclaim)){
                foreach($mediclaim as $li){
                    foreach($li->mediclaim as $list){
                        $company_name_id = MediclaimCompany::find($list->company_name_id)->first();
                        $policy_mode = PolicyMode::find($list->policy_mode_id)->first();
                        $policy_type = PolicyType::find($list->policy_type_id)->first();
                        $new_array[] =array(
                            'id'=>$list->id,
                            'sr_no'=>$list->sr_no,
                            'policy_holder_name'=>$list->policy_holder_name,
                            'birth_date'=>$list->birth_date,
                            'policy_start_date'=>$list->policy_start_date,
                            'company_name'=>$company_name_id->name,
                            'policy_number'=>$list->policy_number,
                            'policy_type'=>$policy_type->name,
                            'policy_name'=>$list->policy_name,
                            'policy_mode'=>$policy_mode->name,
                            'yearly_premium_amount'=>$list->yearly_premium_amount,
                        );
                    }
    
                }
            }
            
            return Datatables::of($new_array)
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
                        return $row['company_name'];
                    }) 
                    ->addColumn('policy_number', function($row){
                        return $row['policy_number'];
                    }) 
                    ->addColumn('policy_type', function($row){
                        return $row['policy_type'];
                    }) 
                    ->addColumn('policy_name', function($row){
                        return $row['policy_name'];
                    }) 
                    ->addColumn('policy_mode', function($row){
                        return $row['policy_mode'];
                    })
                    ->addColumn('yearly_premium_amount', function($row){
                        return $row['yearly_premium_amount'];
                    }) 
                    ->addColumn('action', function ($row){
                        $btn='';
                        $btn .= '<a href="javascript:void(0)" class="edit btn btn-info btn-sm" view_mediclaim_yearly('.$row['id'].')">View</a>&nbsp;&nbsp;';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    
                    ->make(true);
        }
        
        return view('members.member_mediclaim', [
            // 'users' => $data,
            'title'=>'Member',
            'content'=>'Manage Mediclaim'
        ]);
    }
    public function member_vehicle_insurance(Request $request)
    {
        if ($request->ajax()) {
            $new_array = [];
            $vehicle_insurance = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles','vehicle_insurance')->whereHas('roles', function($query) {
                $query->where('name','member');
            })->get();
            
            if(!empty($vehicle_insurance)){
                foreach($vehicle_insurance as $li){
                    foreach($li->vehicle_insurance as $list){

                        $company_name = VehicleInsuranceCompany::find($list->company_name)->first();
                        $vehicle_category = VehicleCategory::find($list->vehicle_category_id)->first();
                        $insurance_policy_type = InsurancePolicyType::find($list->insurance_policy_type_id)->first();
                        $new_array[] =array(
                            'id'=>$list->id,
                            'sr_no'=>$list->sr_no,
                            'vehicle_category'=>$vehicle_category->name,
                            'vehicle_number'=>$list->vehicle_number,
                            'vehicle_name'=>$list->vehicle_name,
                            'chasis_number'=>$list->chasis_number,
                            'company_name'=>$company_name->name,
                            'policy_number'=>$list->policy_number,
                            'insurance_policy_type'=>$insurance_policy_type->name,
                            'policy_premium'=>$list->policy_premium,
                            'vehicle_owner_name'=>$list->vehicle_owner_name,
                            
                        );
                    }
    
                }
            }
                
            return Datatables::of($new_array)
            ->addIndexColumn()
                    ->addColumn('sr_no', function($row){
                        return $row['sr_no'];
                    }) 
                    ->addColumn('vehicle_category_id', function($row){
                        return $row['vehicle_category'];
                    }) 
                    ->addColumn('vehicle_number', function($row){
                        return $row['vehicle_number'];
                    }) 
                    ->addColumn('vehicle_name', function($row){
                        return $row['vehicle_name'];
                    }) 
                    ->addColumn('chasis_number', function($row){
                        return $row['chasis_number'];
                    }) 
                    ->addColumn('company_name_id', function($row){
                        return $row['company_name'];
                    }) 
                    ->addColumn('policy_number', function($row){
                        return $row['policy_number'];
                    }) 
                    ->addColumn('insurance_policy_type_id', function($row){
                        return $row['insurance_policy_type'];
                    }) 
                    ->addColumn('policy_premium', function($row){
                        return $row['policy_premium'];
                    }) 
                    ->addColumn('vehicle_owner_name', function($row){
                        return $row['vehicle_owner_name'];
                    })
                    ->addColumn('action', function ($row){
                        $btn='';
                        $btn .= '<a href="javascript:void(0)" class="edit btn btn-info btn-sm" onClick="view_vehicle_insurance_yearly('.$row['id'].')">View</a>&nbsp;&nbsp;';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    
                    
                    ->make(true);
        }
        
        return view('members.member_vehicle_insurance', [
            // 'users' => $data,
            'title'=>'Member',
            'content'=>'Manage Vehicle Insurance'
        ]);
    } 
    public function member_mutual_fund(Request $request)
    {
        
        if ($request->ajax()) {
            $new_array = [];
            $mutual_fund = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles','mutual_fund')->whereHas('roles', function($query) {
                $query->where('name','member');
            })->get();
            
            if(!empty($mutual_fund)){
                foreach($mutual_fund as $li){
                    foreach($li->mutual_fund as $list){

                        $mutual_fund_type = MutualFundType::find($list->mutual_fund_type_id)->first();
                        
                        $new_array[] =array(
                            'id'=>$list->id,
                            'sr_no'=>$list->sr_no,
                            'mutual_fund_holder_name'=>$list->mutual_fund_holder_name,
                            'mutual_fund_type'=>$mutual_fund_type->name,
                            'folio_number'=>$list->folio_number,
                            'fund_name'=>$list->fund_name,
                            'fund_type'=>$list->fund_type,
                            'purchase_date'=>$list->purchase_date,
                            'amount'=>$list->amount,
                            'yearly_amount'=>$list->yearly_amount,
                            'nominee_name'=>$list->nominee_name,
                        );
                    }
    
                }
            }
            
            return Datatables::of($new_array)
                ->addIndexColumn()
                ->addColumn('sr_no', function($row){
                    return $row['sr_no'];
                }) 
                ->addColumn('mutual_fund_holder_name', function($row){
                    return $row['mutual_fund_holder_name'];
                }) 
                ->addColumn('mutual_fund_type_id', function($row){
                    return $row['mutual_fund_type'];
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
                 ->addColumn('yearly_amount', function($row){
                     return $row['yearly_amount'];
                 }) 
                ->addColumn('nominee_name', function($row){
                    return $row['nominee_name'];
                }) 
                ->addColumn('action', function ($row){
                    $btn='';
                    $btn .= '<a href="javascript:void(0)" class="edit btn btn-info btn-sm" onClick="view_mutual_fund_yearly('.$row['id'].')">View</a>&nbsp;&nbsp;';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('members.member_mutual_fund', [
            'title'=>'Member',
            'content'=>'Manage Mututal Fund'
        ]);
    }
    public function all_life_insurance_yearly(Request $request)
    { 
        if ($request->ajax()) {
            $data =Lifeinsurance::with('company_name','ppt','policy_mode')->get();
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
                    return $row->company_name->name;
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
                ->addColumn('premium_mode', function($row){
                    return $row->policy_mode->name;
                }) 
                ->addColumn('yearly_premium_amount', function($row){
                    return $row->yearly_premium_amount;
                }) 
                ->addColumn('action', function ($row){
                    $btn='';
                    $btn .= '<a href="javascript:void(0)" class="edit btn btn-info btn-sm" onClick="view_life_insurance_yearly('.$row->id.')">View</a>&nbsp;&nbsp;';
                    return $btn;
                })
                ->rawColumns(['action','yearly_premium_amount'])
                ->make(true);
        }
    
        return view('members.all_life_insurances_yearly', [
            // 'users' => $data,
            'title'=>'Member',
            'content'=>'Manage Life Insurance'
        ]);
    } 
    public function all_mutual_fund_monthly(Request $request)
    {
        if($request->ajax()) {
            $date = $request->date;
            $dt = $request->date;
            $dts = date('M', strtotime($dt));
            $dtss = strtolower($dts);
            $data =Mutualfund::with('mutual_fund_type')->where($dtss,'!=',0)->get();

            
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
                    return $row->mutual_fund_type->name;
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
                    return $row->nominee_name;
                }) 
                ->addColumn('action', function ($row){
                    $btn='';
                    $btn .= '<a href="javascript:void(0)" class="edit btn btn-info btn-sm" onClick="view_mutual_fund_monthly('.$row->id.')">View</a>&nbsp;&nbsp;';
                    return $btn;
                })
                ->rawColumns(['action','yearly_amount'])
                ->make(true);
        }
        
        return view('members.all_mutual_funds_monthly', [
            'title'=>'Member',
            'content'=>'Manage Mututal Fund'
        ]);
    } 
    public function all_mutual_fund_yearly(Request $request)
    {
        if ($request->ajax()) {
            $data = Mutualfund::with('mutual_fund_type')->get();
            // if(Auth::User()->hasRole('Member')){
            //     $data =Mutualfund::with('mutual_fund_type')->where('user_id',Auth::User()->id)->get();
            // }else{
                // $data =Mutualfund::with('mutual_fund_type')->get();
            // }
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
                    return $row->mutual_fund_type->name;
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
                    return $row->nominee_name;
                }) 
                ->addColumn('action', function ($row){
                    $btn='';
                    $btn .= '<a href="javascript:void(0)" class="edit btn btn-info btn-sm" onClick="view_mutual_fund_yearly('.$row->id.')">View</a>&nbsp;&nbsp;';
                    return $btn;
                })
                ->rawColumns(['action','yearly_amount'])
                ->make(true);
        }
        
        return view('members.all_mutual_funds_yearly', [
            'title'=>'Member',
            'content'=>'Manage Mututal Fund'
        ]);
    } 
    public function all_mutual_fund(Request $request)
    {
        if ($request->ajax()) {
            $data =Mutualfund::with('mutual_fund_type')->get();
            if(Auth::User()->hasRole('Member')){
                $data =Mutualfund::with('mutual_fund_type')->where('user_id',Auth::User()->id)->get();
            }else{
                $data =Mutualfund::with('mutual_fund_type')->get();
            }
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
                    return $row->mutual_fund_type->name;
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
                    return $row->nominee_name;
                }) 
                ->addColumn('action', function ($row){
                    $btn='';
                    $btn .= '<a href="all_mutual_fund/'.$row['id'].'/view" class="edit btn btn-info btn-sm">View</a>&nbsp;&nbsp;';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('members.all_mutual_funds', [
            'title'=>'Member',
            'content'=>'Manage Mututal Fund'
        ]);
    } 
    public function list_mediclaim_company(Request $request){
        if ($request->ajax()) {
            $data =MediclaimCompany::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    return $row->name;
                }) 
                ->addColumn('action', function ($row){
                    $btn='';
                    $btn .= '<a href="mediclaims/'.$row['id'].'/view" class="edit btn btn-info btn-sm">View</a>&nbsp;&nbsp;';
                    $btn.='<a href="mediclaims/'.$row['id'].'/edit" class="edit btn btn-primary btn-sm" id="edit">Edit</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('mediclaim.list_mediclaim_company', [
            'title'=>'Mediclaim',
            'content'=>'Mediclaim Company'
        ]);
    }
    public function list_life_insurance_company(Request $request){
        if ($request->ajax()) {
            $data =LifeInsuranceCompany::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    return $row->name;
                }) 
                ->addColumn('action', function ($row){
                    $btn='';
                    $btn .= '<a href="life_insurance_company/'.$row['id'].'/view" class="edit btn btn-info btn-sm">View</a>&nbsp;&nbsp;';
                    $btn.='<a href="life_insurance_company/'.$row['id'].'/edit" class="edit btn btn-primary btn-sm" id="edit">Edit</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('life_insurance.list_life_insurance_company', [
            'title'=>'Life Insurance',
            'content'=>'Life Insurance Company'
        ]);
    }
    public function list_vehicle_insurance_company(Request $request){
        
        if ($request->ajax()) {
            $data =VehicleInsuranceCompany::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    return $row->name;
                }) 
                ->addColumn('action', function ($row){
                    $btn='';
                    $btn .= '<a href="vehicle_insurance_company/'.$row['id'].'/view" class="edit btn btn-info btn-sm">View</a>&nbsp;&nbsp;';
                    $btn.='<a href="vehicle_insurance_company/'.$row['id'].'/edit" class="edit btn btn-primary btn-sm" id="edit">Edit</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('vehicle_insurance.list_vehicle_insurance_company', [
            'title'=>'Vehicle Insurance',
            'content'=>'Vehicle Insurance Company'
        ]);
    }
    public function create_mediclaim_company(){
        $data['title']='Mediclaim';
        $data['content']='Create Mediclaim Company';
        return view('mediclaim.create_mediclaim_company', $data);
    }
    public function store_mediclaim_company(Request $request){
        
        $request->validate([
            'company_name' => 'required',
        ]); 
        $input['name'] = $request->company_name;
        
        $user = MediclaimCompany::create($input);
        return redirect()->route('list_mediclaim_company')
                    ->withSuccess('Company Name is added successfully.');
    }
    public function create_life_insurance_company(){
        $data['title']='Life Insurance';
        $data['content']='Create Life Insurance Company';
        return view('life_insurance.create_life_insurance_company', $data);
    }
    public function store_life_insurance_company(Request $request){
        
        $request->validate([
            'company_name' => 'required',
        ]); 
        $input['name'] = $request->company_name;
        
        $user = LifeInsuranceCompany::create($input);
        return redirect()->route('list_life_insurance_company')
                    ->withSuccess('Company Name is added successfully.');
    }
    public function view_life_insurance_company(Request $request,LifeInsuranceCompany $company){
        $company =$company::get();
        return view('life_insurance.view_life_insurance_company', [
            'company' => $company,
            'title'=>'Life Insurance',
            'content'=>'View Company'
        ]);
    }
    public function view_vehicle_insurance_company(Request $request,VehicleInsuranceCompany $company){
        $company =$company::get();
        return view('vehicle_insurance.view_vehicle_insurance_company', [
            'company' => $company,
            'title'=>'Vehcile Insurance',
            'content'=>'View Company'
        ]);
    }
    public function view_mediclaim_company(Request $request,MediclaimCompany $company){
        $company =$company::get();
        return view('mediclaim.view_mediclaim_company', [
            'company' => $company,
            'title'=>'Mediclaim',
            'content'=>'View Company'
        ]);
    }
    public function edit_life_insurance_company(Request $request,LifeInsuranceCompany $company){
        $company =$company::get();
        
        return view('life_insurance.edit_life_insurance_company', [
            'company' => $company,
            'title'=>'Life Insurance',
            'content'=>'View Company'
        ]);
    }
    public function edit_vehicle_insurance_company(Request $request,VehicleInsuranceCompany $company){
        $company =$company::get();
        
        return view('vehicle_insurance.edit_vehicle_insurance_company', [
            'company' => $company,
            'title'=>'Vehicle Insurance',
            'content'=>'View Company'
        ]);
    }
    public function edit_mediclaim_company(Request $request,MediclaimCompany $company){
        $company =$company::get();
        
        return view('mediclaim.edit_mediclaim_company', [
            'company' => $company,
            'title'=>'Mediclaim',
            'content'=>'View Company'
        ]);
    }
    public function update_life_insurance_company(Request $request,LifeInsuranceCompany $company){
        $request->validate([
            'company_name' => 'required',
        ]); 
        $input['name'] = $request->company_name;
        $company->update($input);
        return redirect()->route('list_life_insurance_company')
                    ->withSuccess('Company Name is Updated successfully.');
    }
    public function update_vehicle_insurance_company(Request $request,VehicleInsuranceCompany $company){
        $request->validate([
            'company_name' => 'required',
        ]); 
        $input['name'] = $request->company_name;
        $company->update($input);
        return redirect()->route('list_vehicle_insurance_company')
                    ->withSuccess('Company Name is Updated successfully.');
    }
    public function update_mediclaim_company(Request $request,MediclaimCompany $company){
        $request->validate([
            'company_name' => 'required',
        ]); 
        $input['name'] = $request->company_name;
        $company->update($input);
        return redirect()->route('list_mediclaim_company')
                    ->withSuccess('Company Name is Updated successfully.');
    }

    public function view_all_mediclaim(Request $request,Mediclaim $mediclaim){
        $mediclaim =Mediclaim::with('company_name','policy_type','policy_mode')->where('id',$mediclaim->id)->get();
        return view('mediclaim.view_all_mediclaim', [
            'mediclaim' => $mediclaim,
            'title'=>'Mediclaim',
            'content'=>'View Mediclaim'
        ]);
    } 
    public function view_all_life_insurance(Request $request,LifeInsurance $life_insurance){
        $life_insurance =Lifeinsurance::with('company_name','ppt','policy_mode')->where('id',$life_insurance->id)->get();
        return view('life_insurance.view_all_life_insurance', [
            'life_insurance' => $life_insurance,
            'title'=>'Life Insurance',
            'content'=>'View Life Insurance'
        ]);
    }
    public function view_all_vehicle_insurance(Request $request,VehicleInsurance $vehicle_insurance){
        $vehicle_insurance =VehicleInsurance::with('company_name','user','vehicle_category','insurance_policy_type')->where('id',$vehicle_insurance->id)->get();
        return view('vehicle_insurance.view_all_vehicle_insurance', [
            'vehicle_insurance' => $vehicle_insurance,
            'title'=>'Vehicle Insurance',
            'content'=>'View Vehicle Insurance'
        ]);

    }
    public function view_all_mutual_fund(Request $request,Mutualfund $mutual_fund){
        $mutual_fund =Mutualfund::with('mutual_fund_type')->where('id',$mutual_fund->id)->get();
        return view('mutual_fund.view_all_mutual_fund', [
            'mutual_fund' => $mutual_fund,
            'title'=>'Mutual Fund',
            'content'=>'View Mutual Fund'
        ]);
        
    }
    public function create_vehicle_insurance_company(){
        $data['title']='Vehicle Insurance';
        $data['content']='Create Vehicle Insurance Company';
        return view('vehicle_insurance.create_vehicle_insurance_company', $data);
    }
    public function store_vehicle_insurance_company(Request $request){
        $request->validate([
            'company_name' => 'required',
        ]); 
        $input['name'] = $request->company_name;
        $user = VehicleInsuranceCompany::create($input);
        return redirect()->route('list_vehicle_insurance_company')
                    ->withSuccess('Company Name is added successfully.');
    }
}
