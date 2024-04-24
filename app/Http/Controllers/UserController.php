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
use App\Models\State;
use App\Models\City;
use App\Models\Department;
use App\Models\Member;
use App\Models\Bloodgroup;
use PDF;
use Auth;
use App\Mail\DemoMail;
use App\Exports\UsersExport;
use Illuminate\Support\Str;
use App\Imports\UsersImport;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-user|edit-user|delete-user', ['only' => ['index','show']]);
        $this->middleware('permission:create-user', ['only' => ['create','store']]);
        $this->middleware('permission:edit-user', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,User $user)
    {
        
        if ($request->ajax()) {
            $data =User::where('parent_id',auth()->user()->id)->with('roles')->whereHas('roles', function($query) {
                    $query->where('name','Admin');
                    $query->orWhere('name','Manager');
                    $query->orWhere('name','Agent');
                })->get();
            // $data = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles')->whereHas('roles', function($query) {
            //     $query->where('name','Admin');
            //     $query->orWhere('name','Manager');
            //     $query->orWhere('name','Agent');
            // })->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('id', function($row){
                        foreach($row->getRoleNames() as $role){
                            if($role=='Member'){
                                return $row['user_id'];
                            }else{
                                return '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm" id="edits" onClick="view('.$row->id.')">'.$row['user_id'].'</a>';
                            }
                        }
                    }) 
                    ->addColumn('name', function($row){
                        return $row['name'].' '.$row['middle_name'].' '.$row['surname'];
                    })
                    ->addColumn('added_by', function($row){
                        return User::getUserNameByID($row->parent_id);
                    })  
                    ->addColumn('roles', function($row){
                        foreach($row->getRoleNames() as $role){
                            return $role;
                        }
                    })      
                    ->addColumn('action', function ($row){
                        $btn='';
                        $btn .= '<a href="/users/'.$row['id'].'" class="edit btn btn-info btn-sm">View</a>&nbsp;&nbsp;';
                        if(Auth::user()->can('edit-user')) {
                            $btn.='<a href="users/'.$row['id'].'/edit" class="edit btn btn-primary btn-sm" id="edit">Edit</a>';
                        }
                        // if(Auth::user()->can('delete-user')) {
                        //     $btn.='<form method="post" action="users/'.$row['id'].'">
                        //     <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm("Do you want to delete this user?");"><i class="bi bi-trash"></i> Delete</button>
                        //     </form>';
                        // }
                        return $btn;
                    })
                    ->rawColumns(['action','id'])
                    ->make(true);
        }
        
        return view('users.index', [
            // 'users' => $data,
            'title'=>'Users',
            'content'=>'Manage Users'
        ]);
    }
    public function admin_list(Request $request,User $user)
    {
        
        if ($request->ajax()) {
            // $data =User::where('parent_id',auth()->user()->id)->with('roles')->whereHas('roles', function($query) {
            //         $query->where('name','Admin');
            //         $query->orWhere('name','Manager');
            //         $query->orWhere('name','Agent');
            //     })->get();
            $data = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles')->whereHas('roles', function($query) {
                $query->where('name','Admin');
                
            })->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('id', function($row){
                        // foreach($row->getRoleNames() as $role){
                            // if($role=='Member'){
                                return $row['user_id'];
                            // }else{
                            //     return '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm" id="edits" onClick="view('.$row->id.')">'.$row['user_id'].'</a>';
                            // }
                        // }
                    }) 
                    ->addColumn('name', function($row){
                        return $row['name'].' '.$row['middle_name'].' '.$row['surname'];
                    })
                    ->addColumn('added_by', function($row){
                        return User::getUserNameByID($row->parent_id);
                    })  
                    ->addColumn('roles', function($row){
                        foreach($row->getRoleNames() as $role){
                            return $role;
                        }
                    })      
                    ->addColumn('action', function ($row){
                        $btn='';
                        $btn .= '<a href="/users/'.$row['id'].'" class="edit btn btn-info btn-sm">View</a>&nbsp;&nbsp;';
                        if(Auth::user()->can('edit-user')) {
                            $btn.='<a href="users/'.$row['id'].'/edit" class="edit btn btn-primary btn-sm" id="edit">Edit</a>';
                        }
                        // if(Auth::user()->can('delete-user')) {
                        //     $btn.='<form method="post" action="users/'.$row['id'].'">
                        //     <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm("Do you want to delete this user?");"><i class="bi bi-trash"></i> Delete</button>
                        //     </form>';
                        // }
                        return $btn;
                    })
                    ->rawColumns(['action','id'])
                    ->make(true);
        }
         
        return view('users.admin_list', [
            // 'users' => $data,
            'title'=>'Users',
            'content'=>'Manage Users'
        ]);
    }
    public function manager_list(Request $request,User $user)
    {
        
        if ($request->ajax()) {
            // $data =User::where('parent_id',auth()->user()->id)->with('roles')->whereHas('roles', function($query) {
            //         $query->where('name','Admin');
            //         $query->orWhere('name','Manager');
            //         $query->orWhere('name','Agent');
            //     })->get();
            $data = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles')->whereHas('roles', function($query) {
                $query->where('name','Manager');
                
            })->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('id', function($row){
                        // foreach($row->getRoleNames() as $role){
                            // if($role=='Member'){
                                return $row['user_id'];
                            // }else{
                            //     return '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm" id="edits" onClick="view('.$row->id.')">'.$row['user_id'].'</a>';
                            // }
                        // }
                    }) 
                    ->addColumn('name', function($row){
                        return $row['name'].' '.$row['middle_name'].' '.$row['surname'];
                    })
                    ->addColumn('added_by', function($row){
                        return User::getUserNameByID($row->parent_id);
                    })  
                    ->addColumn('roles', function($row){
                        foreach($row->getRoleNames() as $role){
                            return $role;
                        }
                    })      
                    ->addColumn('action', function ($row){
                        $btn='';
                        $btn .= '<a href="/users/'.$row['id'].'" class="edit btn btn-info btn-sm">View</a>&nbsp;&nbsp;';
                        if(Auth::user()->can('edit-user')) {
                            $btn.='<a href="users/'.$row['id'].'/edit" class="edit btn btn-primary btn-sm" id="edit">Edit</a>';
                        }
                        // if(Auth::user()->can('delete-user')) {
                        //     $btn.='<form method="post" action="users/'.$row['id'].'">
                        //     <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm("Do you want to delete this user?");"><i class="bi bi-trash"></i> Delete</button>
                        //     </form>';
                        // }
                        return $btn;
                    })
                    ->rawColumns(['action','id'])
                    ->make(true);
        }
        
        return view('users.manager_list', [
            // 'users' => $data,
            'title'=>'Users',
            'content'=>'Manage Users'
        ]);
    }
    public function agent_list(Request $request,User $user)
    {
        
        if ($request->ajax()) {
            // $data =User::where('parent_id',auth()->user()->id)->with('roles')->whereHas('roles', function($query) {
            //         $query->where('name','Admin');
            //         $query->orWhere('name','Manager');
            //         $query->orWhere('name','Agent');
            //     })->get();
            $data = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles')->whereHas('roles', function($query) {
                $query->where('name','Agent');
                
            })->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('id', function($row){
                        // foreach($row->getRoleNames() as $role){
                            // if($role=='Member'){
                                return $row['user_id'];
                            // }else{
                            //     return '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm" id="edits" onClick="view('.$row->id.')">'.$row['user_id'].'</a>';
                            // }
                        // }
                    }) 
                    ->addColumn('name', function($row){
                        return $row['name'].' '.$row['middle_name'].' '.$row['surname'];
                    })
                    ->addColumn('added_by', function($row){
                        return User::getUserNameByID($row->parent_id);
                    })  
                    ->addColumn('roles', function($row){
                        foreach($row->getRoleNames() as $role){
                            return $role;
                        }
                    })      
                    ->addColumn('action', function ($row){
                        $btn='';
                        $btn .= '<a href="/users/'.$row['id'].'" class="edit btn btn-info btn-sm">View</a>&nbsp;&nbsp;';
                        if(Auth::user()->can('edit-user')) {
                            $btn.='<a href="users/'.$row['id'].'/edit" class="edit btn btn-primary btn-sm" id="edit">Edit</a>';
                        }
                        // if(Auth::user()->can('delete-user')) {
                        //     $btn.='<form method="post" action="users/'.$row['id'].'">
                        //     <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm("Do you want to delete this user?");"><i class="bi bi-trash"></i> Delete</button>
                        //     </form>';
                        // }
                        return $btn;
                    })
                    ->rawColumns(['action','id'])
                    ->make(true);
        }
        
        return view('users.agent_list', [
            // 'users' => $data,
            'title'=>'Users',
            'content'=>'Manage Users'
        ]);
    }
    public function Member_list(Request $request,User $user)
    {
        
        if ($request->ajax()) {
            $status = $request->status;
            // $data =User::where('parent_id',auth()->user()->id)->with('roles')->whereHas('roles', function($query) {
            //         $query->where('name','Admin');
            //         $query->orWhere('name','Manager');
            //         $query->orWhere('name','Agent');
            //     })->get();
            if($status == 0){
                $data = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles')->whereHas('roles', function($query) {
                    $query->where('name','Member');
                })->where('isActive',0)->get();
            }elseif($status == 1){
                $data = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles')->whereHas('roles', function($query) {
                    $query->where('name','Member');
                })->where('isActive',1)->get();
            }else{
                $data = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles')->whereHas('roles', function($query) {
                    $query->where('name','Member');
                })->get();
            }
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('id', function($row){
                        // foreach($row->getRoleNames() as $role){
                            // if($role=='Member'){
                                return $row['user_id'];
                            // }else{
                            //     return '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm" id="edits" onClick="view('.$row->id.')">'.$row['user_id'].'</a>';
                            // }
                        // }
                    }) 
                    ->addColumn('name', function($row){
                        return $row['name'].' '.$row['middle_name'].' '.$row['surname'];
                    })
                    ->addColumn('added_by', function($row){
                        return User::getUserNameByID($row->parent_id);
                    })  
                    ->addColumn('status', function($row){
                        // foreach($row->getRoleNames() as $role){
                        //     return $role;
                        // }
                        if($row->isActive=="0"){
                            $expiry_date = date('Y-m-d', strtotime("-1 month", strtotime($row->expiry_date)));
                            $today_date = date('Y-m-d');
                            $dateDiff = $this->dateDiffInDays($expiry_date, $today_date); 
                            if($dateDiff<='30'){
                                return 'Active (Expire Soon)';
                            }else{
                                return 'Active';
                            }
                        }else{
                            return 'inActive';
                        }
                    })      
                    ->addColumn('action', function ($row){
                        $btn='';
                        $btn .= '<a href="members/'.$row['id'].'" class="edit btn btn-info btn-sm">View</a>&nbsp;&nbsp;';
                        $btn.='<a href="members/'.$row['id'].'/edit" class="edit btn btn-primary btn-sm" id="edit">Edit</a>';
                        
                        // if(Auth::user()->can('delete-user')) {
                        //     $btn.='<form method="post" action="users/'.$row['id'].'">
                        //     <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm("Do you want to delete this user?");"><i class="bi bi-trash"></i> Delete</button>
                        //     </form>';
                        // }
                        return $btn;
                    })
                    ->rawColumns(['action','id'])
                    ->make(true);
        }
        
        return view('users.member_list', [
            // 'users' => $data,
            'title'=>'Users',
            'content'=>'Manage Users'
        ]);
    }
    public function active_member(Request $request,User $user)
    {
        
        if ($request->ajax()) {
            $status = $request->status;
            // $data =User::where('parent_id',auth()->user()->id)->with('roles')->whereHas('roles', function($query) {
            //         $query->where('name','Admin');
            //         $query->orWhere('name','Manager');
            //         $query->orWhere('name','Agent');
            //     })->get();
                $data = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles')->whereHas('roles', function($query) {
                    $query->where('name','Member');
                })->where('isActive',0)->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('id', function($row){
                        // foreach($row->getRoleNames() as $role){
                            // if($role=='Member'){
                                return $row['user_id'];
                            // }else{
                            //     return '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm" id="edits" onClick="view('.$row->id.')">'.$row['user_id'].'</a>';
                            // }
                        // }
                    }) 
                    ->addColumn('name', function($row){
                        return $row['name'].' '.$row['middle_name'].' '.$row['surname'];
                    })
                    ->addColumn('added_by', function($row){
                        return User::getUserNameByID($row->parent_id);
                    })  
                    ->addColumn('status', function($row){
                        // foreach($row->getRoleNames() as $role){
                        //     return $role;
                        // }
                        if($row->isActive=="0"){
                            $expiry_date = date('Y-m-d', strtotime("-1 month", strtotime($row->expiry_date)));
                            $today_date = date('Y-m-d');
                            $dateDiff = $this->dateDiffInDays($expiry_date, $today_date); 
                            if($dateDiff<='30'){
                                return 'Active (Expire Soon)';
                            }else{
                                return 'Active';
                            }
                        }else{
                            return 'inActive';
                        }
                    })      
                    ->addColumn('action', function ($row){
                        $btn='';
                        $btn .= '<a href="members/'.$row['id'].'" class="edit btn btn-info btn-sm">View</a>&nbsp;&nbsp;';
                        $btn.='<a href="members/'.$row['id'].'/edit" class="edit btn btn-primary btn-sm" id="edit">Edit</a>';
                        
                        // if(Auth::user()->can('delete-user')) {
                        //     $btn.='<form method="post" action="users/'.$row['id'].'">
                        //     <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm("Do you want to delete this user?");"><i class="bi bi-trash"></i> Delete</button>
                        //     </form>';
                        // }
                        return $btn;
                    })
                    ->rawColumns(['action','id'])
                    ->make(true);
        }
        
        return view('users.active_member', [
            // 'users' => $data,
            'title'=>'Users',
            'content'=>'Manage Users'
        ]);
    }
    public function inactive_member(Request $request,User $user)
    {
        
        if ($request->ajax()) {
            // $data =User::where('parent_id',auth()->user()->id)->with('roles')->whereHas('roles', function($query) {
            //         $query->where('name','Admin');
            //         $query->orWhere('name','Manager');
            //         $query->orWhere('name','Agent');
            //     })->get();
                $data = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles')->whereHas('roles', function($query) {
                    $query->where('name','Member');
                })->where('isActive',1)->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('id', function($row){
                        // foreach($row->getRoleNames() as $role){
                            // if($role=='Member'){
                                return $row['user_id'];
                            // }else{
                            //     return '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm" id="edits" onClick="view('.$row->id.')">'.$row['user_id'].'</a>';
                            // }
                        // }
                    }) 
                    ->addColumn('name', function($row){
                        return $row['name'].' '.$row['middle_name'].' '.$row['surname'];
                    })
                    ->addColumn('added_by', function($row){
                        return User::getUserNameByID($row->parent_id);
                    })  
                    ->addColumn('status', function($row){
                        // foreach($row->getRoleNames() as $role){
                        //     return $role;
                        // }
                        if($row->isActive=="0"){
                            $expiry_date = date('Y-m-d', strtotime("-1 month", strtotime($row->expiry_date)));
                            $today_date = date('Y-m-d');
                            $dateDiff = $this->dateDiffInDays($expiry_date, $today_date); 
                            if($dateDiff<='30'){
                                return 'Active (Expire Soon)';
                            }else{
                                return 'Active';
                            }
                        }else{
                            return 'inActive';
                        }
                    })      
                    ->addColumn('action', function ($row){
                        $btn='';
                        $btn .= '<a href="members/'.$row['id'].'" class="edit btn btn-info btn-sm">View</a>&nbsp;&nbsp;';
                        $btn.='<a href="members/'.$row['id'].'/edit" class="edit btn btn-primary btn-sm" id="edit">Edit</a>';
                        
                        // if(Auth::user()->can('delete-user')) {
                        //     $btn.='<form method="post" action="users/'.$row['id'].'">
                        //     <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm("Do you want to delete this user?");"><i class="bi bi-trash"></i> Delete</button>
                        //     </form>';
                        // }
                        return $btn;
                    })
                    ->rawColumns(['action','id'])
                    ->make(true);
        }
        
        return view('users.inactive_member', [
            // 'users' => $data,
            'title'=>'Users',
            'content'=>'Manage Users'
        ]);
    }
    function dateDiffInDays($date1, $date2) { 
        $diff = strtotime($date2) - strtotime($date1); 
      return abs(round($diff / 86400)); 
    } 
    public function view(Request $request,User $user)
    {
        if ($request->ajax()) {
            // $data = User::find(auth()->user()->id)->descendants()->depthFirst()->get();
            $data =User::where('parent_id',$user->id)->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('id', function($row){
                        // return $row['user_id'];
                        foreach($row->getRoleNames() as $role){
                            if($role=='Member'){
                                return $row['user_id'];
                            }else{
                                return '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm" id="edits" onClick="view('.$row->id.')">'.$row['user_id'].'</a>';
                            }
                        }
                    }) 
                    ->addColumn('added_by', function($row){
                        return User::getUserNameByID($row->parent_id);
                    })  
                    ->addColumn('roles', function($row){
                        foreach($row->getRoleNames() as $role){
                            return $role;
                        }
                    })      
                    ->addColumn('action', function ($row){
                        $btn='';
                        $btn .= '<a href="/users/'.$row['id'].'" class="edit btn btn-info btn-sm">View</a>&nbsp;&nbsp;';
                        if(Auth::user()->can('edit-user')) {
                            $btn.='<a href="javascript:void(0)" class="editd btn btn-primary btn-sm" id="editd" onClick="edit_user('.$row->id.')">Edit</a>';
                        } 
                        // if(Auth::user()->can('delete-user')) {
                        //     $btn.='<form method="post" action="users/'.$row['id'].'">
                        //     <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm("Do you want to delete this user?");"><i class="bi bi-trash"></i> Delete</button>
                        //     </form>';
                        // }
                        return $btn;
                    })
                    ->rawColumns(['action','id'])
                    ->make(true);
        }
        
        return view('users.view', [
            'id'=>$user->id,
            // 'users' => $data,
            'title'=>'Users',
            'content'=>'Manage Users'
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $data['roles'] =Role::pluck('name')->all();
        $data['countries'] = Country::get(["name", "id"]);
        $data['blood_group'] = Bloodgroup::get(["name", "id"]);
        // dd($data['countries']);
        $data['title']='Users';
        $data['departments'] = Department::get(['name','id']);
        $data['content']='Create User';
        return view('users.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        // echo Auth::user()->id;die;
        $input = $request->all();
        $input['parent_id'] = Auth::user()->id;
        $password = "ossdm@123";
        $input['password'] = Hash::make($password);
        // $input['password'] = Hash::make('ossdm@123');
        $input['isActive']=0;
        $user = User::create($input);
        if($user){
            $user_id = 'USR'.str_pad($user->id, 5, '0', STR_PAD_LEFT);
            User::whereId($user->id)->update([
                'user_id' => $user_id,
            ]);
            $user->assignRole($request->roles);
            $url = route('login');
            $mailData = [
                'title' => 'Mail from www.ossdm.com',
                'body' => 'OSSDM Login Credentials',
                'url'=>$url,
                'subject' => 'www.ossdm.com',
                'username'=>$request->email,
                'password'=>$password,
                
            ];
            Mail::to($request->email)->send(new DemoMail($mailData));
            return redirect()->route('users.index')
                    ->withSuccess('New user is added successfully.');

        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('users.show', [
            'user' => $user,
            'title'=>'Users',
            'content'=>'View Users'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        // Check Only Super Admin can update his own Profile
        if ($user->hasRole('Super Admin')){
            if($user->id != auth()->user()->id){
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }
        
        return view('users.edit', [
            'user' => $user,
            'roles' => Role::pluck('name')->all(),
            'userRoles' => $user->roles->pluck('name')->all(),
            'departments' => Department::get(['name','id']),
            'title'=>'Users',
            'content'=>'Edit User',
            'countries'=>Country::get(["name", "id"]),
            'blood_group'=>Bloodgroup::get(["name", "id"])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'middle_name' => 'required|string|max:250',
            'surname' => 'required|string|max:250',
            'mobile_number' => 'required|numeric|digits:10',
            'emergency_contact_number' => 'required|numeric|digits:10',
            'pancard_number' => 'required|string|max:10|min:10|unique:users,pancard_number,'.$user->id,
            'adharcard_number' => 'required|string|max:12|min:12|unique:users,adharcard_number,'.$user->id,
            'country_id'=>'required',
            'state_id'=>'required',
            'city_id'=>'required',
            'address'=>'required|string|max:250',
            'birth_date'=>'required',
            'blood_group_id'=>'required',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email,'.$user->id,
        ]); 
        $input = $request->all();
        if($request->isActive=="0"){
            $input['isActive']=0;
        }else{
            $input['isActive']=1;
        }
        $user->update($input);
        return redirect()->route('users.index')->withSuccess('User is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // About if user is Super Admin or User ID belongs to Auth User
        if ($user->hasRole('Super Admin') || $user->id == auth()->user()->id)
        {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }

        $user->syncRoles([]);
        $user->delete();
        return redirect()->route('users.index')
                ->withSuccess('User is deleted successfully.');
    }
    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
    public function generatePDF()
    {
        $users = User::get();
        $data = [
            'title' => 'List Users',
            'date' => date('m/d/Y'),
            'users' => $users
        ]; 
        $pdf = PDF::loadView('users.pdf', $data);
        return $pdf->download('listUsers.pdf');
    } 
    public function profile(){
        // $data['user'] = Auth::user('member');
        $data['user'] = User::with('member')->find(Auth::id());
        
        $data['title']='Users';
        $data['content']='Update Profile';
        return view('users.profile',$data);
    }
    public function update_profile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'middle_name' => 'required',
            'surname' => 'required',
        ]);
        $inp['name']= $request->name;
        $inp['middle_name'] = $request->middle_name;
        $inp['surname'] = $request->surname;
        $inp['pancard_number'] = $request->pancard_number;
        $inp['adharcard_number'] = $request->adharcard_number;
        $inp['mobile_number'] = $request->mobile_number;
        $inp['emergency_contact_number'] = $request->emergency_contact_number;
        $upd = User::whereId(Auth::user()->id)->update($inp);
        if(Auth::User()->hasRole('Member')){
            $input['mother_name'] = $request->mother_name;
            $input['father_name'] = $request->father_name;
            Member::whereUserId(Auth::user()->id)->update($input);
        }
        return redirect()->back()
                ->withSuccess('User is updated successfully.');
    } 
    public function change_password(){
        $data['title']='Users';
        $data['content']='Change Password';
        return view('users.change_password',$data);
    }
    public function update_password(Request $request)
    {
        $request->validate([
            'current_password' => ['required','string'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $currentPasswordStatus = Hash::check($request->current_password, auth()->user()->password);
        if($currentPasswordStatus){
            User::whereId(Auth::user()->id)->update([
                'password' => Hash::make($request->password),
            ]);
            // dd(User::findOrFail(Auth::user()->id)->update([
            //     'password' => Hash::make($request->password),
            // ]));
            return redirect()->back()->with('success','Password Updated Successfully');
            
        }else{
            return redirect()->back()->with('error','Current Password does not match with Old Password');
        }
    }
    public function user_password(Request $request,User $user)
    {
        
        if ($request->ajax()) {
            $data =User::with('roles')->whereHas('roles', function($query) {
                    $query->where('name','Admin');
                    $query->orWhere('name','Manager');
                    $query->orWhere('name','Agent');
                })->get();
            // $data = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles')->whereHas('roles', function($query) {
            //     $query->where('name','Admin');
            //     $query->orWhere('name','Manager');
            //     $query->orWhere('name','Agent');
            // })->get();
            return Datatables::of($data)
                ->addColumn('name', function($row){
                    return $row['name'].' '.$row['middle_name'].' '.$row['surname'];
                })
                ->addColumn('email', function($row){
                    return $row->email;
                })  
                ->addColumn('password', function($row){
                    
                        return $row->password;
                    
                })      
                ->make(true);
        }
        
        return view('users.user_password', [
            // 'users' => $data,
            'title'=>'Users',
            'content'=>'User Password'
        ]);
    } 
    public function member_password(Request $request,User $user)
    {
        if ($request->ajax()) {
            $data =User::with('roles')->whereHas('roles', function($query) {
                    $query->Where('name','Member');
                })->get();
                return Datatables::of($data)
                    ->addColumn('name', function($row){
                        return $row['name'].' '.$row['middle_name'].' '.$row['surname'];
                    })
                    ->addColumn('email', function($row){
                        return $row->email;
                    })  
                    ->addColumn('password', function($row){
                        
                            return $row->password;
                        
                    })      
                ->make(true);
        }
        
        return view('users.member_password', [
            // 'users' => $data,
            'title'=>'Users',
            'content'=>'Member Password'
        ]);
    } 
}