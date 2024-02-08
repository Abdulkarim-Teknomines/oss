<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Member;
use App\Models\State;
use App\Models\City;
use App\Models\Children;
use App\Models\Bloodgroup;
use PDF;
use Auth;
use App\Mail\DemoMail;
use App\Exports\UsersExport;
use Illuminate\Support\Str;
use App\Imports\UsersImport;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;

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
                    ->addColumn('life_insurance', function($row){
                        return '<a href="javascript:void(0)" class="edit fa fa-plus btn-lg" id="edits" onClick="view('.$row->id.')"></a>
                        <a href="javascript:void(0)" class="edit fa fa-eye btn-lg" id="edits" onClick="view('.$row->id.')"></a>';
                    }) 
                    ->addColumn('mediclaim', function($row){
                        return '<a href="javascript:void(0)" class="edit fa fa-plus btn-lg" id="edits" onClick="view('.$row->id.')"></a>
                        <a href="javascript:void(0)" class="edit fa fa-eye btn-lg" id="edits" onClick="view('.$row->id.')"></a>';
                    }) 
                    ->addColumn('mutual_fund', function($row){
                        return '<a href="javascript:void(0)" class="edit fa fa-plus btn-lg" id="edits" onClick="view('.$row->id.')"></a>
                        <a href="javascript:void(0)" class="edit fa fa-eye btn-lg" id="edits" onClick="view('.$row->id.')"></a>';
                    }) 
                    ->addColumn('vehicle', function($row){
                        return '<a href="javascript:void(0)" class="edit fa fa-plus btn-lg" id="edits" onClick="view('.$row->id.')"></a>
                        <a href="javascript:void(0)" class="edit fa fa-eye btn-lg" id="edits" onClick="view('.$row->id.')"></a>';
                    }) 
                    ->addColumn('action', function ($row){
                        $btn='';
                        $btn .= '<a href="/members/'.$row['id'].'" class="edit btn btn-info btn-sm">View</a>&nbsp;&nbsp;';
                        if(Auth::user()->can('edit-member')) {
                            $btn.='<a href="members/'.$row['id'].'/edit" class="edit btn btn-primary btn-sm" id="edit">Edit</a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action','life_insurance','mediclaim','mutual_fund','vehicle'])
                    ->make(true);
        }
        
        return view('members.index', [
            // 'users' => $data,
            'title'=>'Member',
            'content'=>'Manage Member'
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
            'mobile_number' => 'required',
            
            'email' => 'required|email',
            'pancard_number' => 'required',
            'adharcard_number' => 'required',
            'emergency_contact_number' => 'required',

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
            $member['spous_name'] = $request->spous_name;
            $member['spous_dob'] = $request->spous_dob;
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
                    ->withSuccess('New Member is added successfully.');

        }
    }
    public function edit(User $user)
    {
        // $user = User::with('member')->where('id',$member->id)->get();
        $user =User::with('member','children')->where('id',$user->id)->get();
        // dd($user[0]->children);
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
        // $input = $request->all();
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
            $member['spous_name'] = $request->spous_name;
            $member['spous_dob'] = $request->spous_dob;
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
        
        return redirect()->route('members.index')->withSuccess('User is updated successfully.');
    }
}
