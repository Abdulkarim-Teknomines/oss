<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon; 
use App\Models\Mediclaim;
use App\Models\Lifeinsurance;
use App\Models\VehicleInsurance;
use App\Models\Mutualfund;
use Mail; 
use DB; 
use Illuminate\Support\Str;

class LoginRegisterController extends Controller
{
    /**
     * Instantiate a new LoginRegisterController instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard'
        ]);
    }

    /**
     * Display a registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('dashboard')
        ->withSuccess('You have successfully registered & logged in!');
    }

    /**
     * Display a login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            
        ]);
        $credentials['isActive']=0;
        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect()->route('dashboard')
                ->withSuccess('You have successfully logged in!');
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.',
        ])->onlyInput('email');

    } 
    
    /**
     * Display a dashboard to authenticated users.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(User $user)
    {
        $data['users'] =User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles','member','country','state','city')->whereHas('roles', function($query) {
            $query->where('name','admin');
            $query->orWhere('name','agent');
            $query->orWhere('name','manager');
        })->count();
        $data['admin'] = User::with('roles','member','country','state','city')->whereHas('roles', function($query) {
            $query->where('name','admin');
        })->count();
        $data['member_count'] = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles','member','country','state','city')->whereHas('roles', function($query) {
            $query->where('name','member');
        })->count();

        $data['manager'] =  User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles','member','country','state','city')->whereHas('roles', function($query) {
            $query->where('name','manager');
        })->count();
        $data['agent'] = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles','member','country','state','city')->whereHas('roles', function($query) {
            $query->where('name','agent');
        })->count();
        
        if(Auth::User()->hasRole('Member')){
            $data['mediclaim_count'] = Mediclaim::where('user_id',auth()->user()->id)->count();
            $data['life_insurance_count'] = Lifeinsurance::where('user_id',auth()->user()->id)->count();
            $data['mutual_fund_count'] = Mutualfund::where('user_id',auth()->user()->id)->count();
            $data['vehicle_insurance_count'] = VehicleInsurance::where('user_id',auth()->user()->id)->count();
            $data['mediclaim_premium'] = Mediclaim::where('user_id',auth()->user()->id)->sum('yearly_premium_amount');
            $data['lifeinsurance_premium'] = Lifeinsurance::where('user_id',auth()->user()->id)->sum('yearly_premium_amount');
            $data['vehicleinsurance_premium'] = VehicleInsurance::where('user_id',auth()->user()->id)->sum('policy_premium');
            $data['mutualfund_premium'] = Mutualfund::where('user_id',auth()->user()->id)->sum('yearly_amount');
            $member_details = User::where('id',Auth::id())->get();
            $data['agent_details'] = User::where('id',$member_details[0]->parent_id)->get();
            $data['manager_details'] = User::where('id',$data['agent_details'][0]->parent_id)->get();
        }else{
            // $data['mediclaim_count'] = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles','member','country','state','city','mediclaim')->whereHas('roles', function($query) {
            //     $query->where('name','member');
            // })->count();

            $members = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles','member','country','state','city','mediclaim','life_insurance','vehicle_insurance','mutual_fund','children')->whereHas('roles', function($query) {
                $query->where('name','member');
            })->get();

            $mediclaim_count=0;
            $life_insurance_count = 0;
            $vehicle_insurance_count = 0;
            $mutual_fund_count = 0;
            $mediclaim_premium_sum = 0;
            $lifeinsurance_premium_sum = 0;
            $vehicleinsurance_premium_sum = 0;
            $mutualfund_premium_sum = 0;
            // $mediclaims = array();
            
            foreach($members as $memb){
                if(!empty($memb->mediclaim)){
                    foreach($memb->mediclaim as $med){
                        $mediclaim_count+=1;  
                        $mediclaim_premium_sum+=$med->yearly_premium_amount;
                    }
                }
                
                if(!empty($memb->life_insurance)){
                    foreach($memb->life_insurance as $med){
                        $life_insurance_count+=1;   
                        $lifeinsurance_premium_sum+=$med->yearly_premium_amount;
                    }
                }
                if(!empty($memb->vehicle_insurance)){
                    foreach($memb->vehicle_insurance as $med){
                        $vehicle_insurance_count+=1;  
                        $vehicleinsurance_premium_sum+=$med->policy_premium;
                    }
                }
                if(!empty($memb->mutual_fund)){
                    foreach($memb->mutual_fund as $med){
                        $mutual_fund_count+=1;  
                        $mutualfund_premium_sum+= $med->yearly_amount;
                    }
                }
            }
            // $data['mediclaim']= $mediclaims;
            $data['mediclaim_premium'] = $mediclaim_premium_sum;
            $data['lifeinsurance_premium'] = $lifeinsurance_premium_sum;
            $data['vehicleinsurance_premium'] = $vehicleinsurance_premium_sum;
            $data['mutualfund_premium'] = $mutualfund_premium_sum;
            $data['mediclaim_count']=$mediclaim_count;
            $data['life_insurance_count']=$life_insurance_count;
            $data['vehicle_insurance_count']=$vehicle_insurance_count;
            $data['mutual_fund_count']=$mutual_fund_count;
            
        }
        $data['members'] = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles','member','country','state','city')->whereHas('roles', function($query) {
                $query->where('name','member');
        })->latest()->take(10)->get();
        $member_date = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles','member','country','state','city','children')->whereHas('roles', function($query) {
            $query->where('name','member');
        })->get();
        $member_birth_date = array();
        $member_anniversary_date = array();
        $member_spouse_date = array();
        $child_dobs = array();
        foreach($member_date as $member_dat){
            $bd = strtotime($member_dat->birth_date);
            $current_date =strtotime(date('Y-m-d'));
            $dst = date("m-d", $current_date);
            $plus_1month = date("Y-m-d", strtotime("+1 month", $current_date));
            $dst1 = date('m-d',strtotime($plus_1month));
            if(isset($bd) && !empty($bd)){
                if(date('m-d',$bd)>=$dst && date('m-d',$bd)<=$dst1){
                    $member_birth_date[]=array(
                        'user_id'=>$member_dat->id,
                        'name' => $member_dat->name.' '.$member_dat->middle_name.' '.$member_dat->surname,
                        'birth_date' => $member_dat->birth_date,
                        'father_name'=>  $member_dat->member->father_name,
                        'mother_name'=>$member_dat->member->mother_name,
                        'spouse_name'=>$member_dat->member->spouse_name,
                        'spouse_dob'=>$member_dat->member->spouse_dob,
                        'anniversary_date' => $member_dat->member->anniversary_date,
                        'mobile_number'=>$member_dat->mobile_number,
                        'email_id'=>$member_dat->email
                    );
                }
            }
            $anni_date = strtotime($member_dat->member->anniversary_date);
            if(isset($anni_date) && !empty($anni_date)){
                if(date('m-d',$anni_date)>=$dst && date('m-d',$anni_date)<=$dst1){
                    $member_anniversary_date[]=array(
                        'user_id'=>$member_dat->id,
                        'name' => $member_dat->name.' '.$member_dat->middle_name.' '.$member_dat->surname,
                        'birth_date' => $member_dat->birth_date,
                        'father_name'=>  $member_dat->member->father_name,
                        'mother_name'=>$member_dat->member->mother_name,
                        'spouse_name'=>$member_dat->member->spouse_name,
                        'spouse_dob'=>$member_dat->member->spouse_dob,
                        'anniversary_date' => $member_dat->member->anniversary_date,
                        'mobile_number'=>$member_dat->mobile_number,
                        'email_id'=>$member_dat->email
                        
                    );
                }
            }
            
        
            $spouse_date = strtotime($member_dat->member->spouse_dob);
            if(isset($spouse_date) && !empty($spouse_date)){
                if(date('m-d',$spouse_date)>=$dst && date('m-d',$spouse_date)<=$dst1){
                    $member_spouse_date[]=array(
                        'user_id'=>$member_dat->id,
                        'name' => $member_dat->name.' '.$member_dat->middle_name.' '.$member_dat->surname,
                        'birth_date' => $member_dat->birth_date,
                        'father_name'=>  $member_dat->member->father_name,
                        'mother_name'=>$member_dat->member->mother_name,
                        'spouse_name'=>$member_dat->member->spouse_name,
                        'spouse_dob'=>$member_dat->member->spouse_dob,
                        'anniversary_date' => $member_dat->member->anniversary_date,
                        'mobile_number'=>$member_dat->mobile_number,
                        'email_id'=>$member_dat->email
                    );
                }
            }
            if(!empty($member_dat->children)){
                foreach($member_dat->children as $child){
                    $child_dob = strtotime($child->birth_date);
                    if(isset($child_dob) && !empty($child_dob)){
                        if(date('m-d',$child_dob)>=$dst && date('m-d',$child_dob)<=$dst1){
                            $child_dobs[]=array(
                                    'user_id'=>$member_dat->id,
                                    'name' => $member_dat->name.' '.$member_dat->middle_name.' '.$member_dat->surname,
                                    'birth_date' => $member_dat->birth_date,
                                    'father_name'=>  $member_dat->member->father_name,
                                    'mother_name'=>$member_dat->member->mother_name,
                                    'spouse_name'=>$member_dat->member->spouse_name,
                                    'spouse_dob'=>$member_dat->member->spouse_dob,
                                    'anniversary_date' => $member_dat->member->anniversary_date,
                                    'child_birth_date'=>$child->birth_date,
                                    'child_name'=>$child->name,
                                    'mobile_number'=>$member_dat->mobile_number,
                        'email_id'=>$member_dat->email
                            );
                        }
                    }
                }
            }

        }
        
        $data['member_birth_date'] =$member_birth_date;
        $data['member_anniversary_date'] =$member_anniversary_date;
        $data['member_spouse_date'] =$member_spouse_date;
        $data['child_birth_date'] = $child_dobs;
        $data['mediclaim']= Mediclaim::with('company_name','policy_type','policy_mode')->latest()->take(10)->get();
        $data['life_insurance']=Lifeinsurance::with('company_name','ppt','policy_mode')->latest()->take(10)->get();
        $data['vehicle_insurance']=VehicleInsurance::with('company_name','user','vehicle_category','insurance_policy_type')->latest()->take(10)->get();
        $data['mutual_fund']=Mutualfund::with('mutual_fund_type')->latest()->take(10)->get();

        $data['title']='Dashboard';
        $data['content']='Dashboard';
        if(Auth::check())
        {
            return view('auth.dashboard',$data);
        }
        return redirect()->route('login')->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
    } 
    public function homepage(){
        return view('frontend.homepage');
    }
    protected function traverseTree($subtree, $des)
    {
        $descendants = $des;
        if ($subtree->descendants->count() > 0) {
            foreach ($subtree->descendants as $descendant) {
                $descendants->push($descendant);
                $this->traverseTree($descendant, $descendants);

            }
        }
        return $descendants;
    }
    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('homepage')
            ->withSuccess('You have logged out successfully!');;
    }    
    public function showForgetPasswordForm()
    {
        return view('auth.forgetPassword');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);
        Mail::send('emails.forgetPassword', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });
        return back()->with('message', 'We have e-mailed your password reset link!');
    }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm($token) { 
         return view('auth.forgetPasswordLink', ['token' => $token]);
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
  
          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();
  
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
  
          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);
 
          DB::table('password_resets')->where(['email'=> $request->email])->delete();
  
          return redirect('/login')->with('message', 'Your password has been changed!');
      }
}
