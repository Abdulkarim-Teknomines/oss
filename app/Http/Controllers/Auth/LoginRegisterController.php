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
    public function dashboard()
    {
        // echo str_pad(1, 7, '0', STR_PAD_LEFT);die;
        $data['users'] = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles','member','country','state','city')->whereHas('roles', function($query) {
            $query->where('name','admin');
            $query->orWhere('name','agent');
            $query->orWhere('name','manager');
        })->count();
        $data['admin'] = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles','member','country','state','city')->whereHas('roles', function($query) {
            $query->where('name','admin');
        })->count();
        $data['member_count'] = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles','member','country','state','city')->whereHas('roles', function($query) {
            $query->where('name','member');
        })->count();
        $data['manager'] = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles','member','country','state','city')->whereHas('roles', function($query) {
            $query->where('name','manager');
        })->count();
        $data['agent'] = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles','member','country','state','city')->whereHas('roles', function($query) {
            $query->where('name','agent');
        })->count();
        $data['mediclaim_count'] = Mediclaim::count();
        $data['life_insurance_count'] = Lifeinsurance::count();
        $data['vehicle_insurance_count'] = VehicleInsurance::count();

        $data['members'] = User::find(auth()->user()->id)->descendants()->depthFirst()->with('roles','member','country','state','city')->whereHas('roles', function($query) {
            $query->where('name','member');
        })->latest()->take(10)->get();
        $data['mutual_fund_count'] = Mutualfund::count();

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
        
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
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
        return redirect()->route('login')
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
        // echo $token;die;
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
