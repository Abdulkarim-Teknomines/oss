<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\MemberController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/', [LoginRegisterController::class, 'login'])->name('login');
//     Route::get('/register', [LoginRegisterController::class, 'register'])->name('register');
//     Route::post('/store',  [LoginRegisterController::class, 'store'])->name('store');
//     Route::get('/login',  [LoginRegisterController::class, 'login'])->name('login');
//     Route::post('/authenticate',  [LoginRegisterController::class, 'authenticate'])->name('authenticate');
//     Route::get('/dashboard',  [LoginRegisterController::class, 'dashboard'])->name('dashboard');
//     Route::post('/logout',  [LoginRegisterController::class, 'logout'])->name('logout');
    

//     // Add the following route to the existing routes because we want the posts route accessible to authenticated users only.
//     // We'll use a resource route because it contains all the exact routes we need for a typical CRUD application.
//     Route::resource('posts', PostController::class);
// });

Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/', 'login')->name('login');
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/update_password', 'update_password')->name('update_password');
    Route::post('/logout', 'logout')->name('logout');
    Route::get('forget-password', 'showForgetPasswordForm')->name('forget.password.get');
    Route::post('forget-password', 'submitForgetPasswordForm')->name('forget.password.post'); 
    Route::get('reset-password/{token}', 'showResetPasswordForm')->name('reset.password.get');
    Route::post('reset-password', 'submitResetPasswordForm')->name('reset.password.post');
});
// Route::resources([
//     'roles' => RoleController::class,
//     'users' => UserController::class,
//     'products' => ProductController::class,
// ]);
Route::controller(ProductController::class)->group(function(){
    Route::get('products', 'index')->name('products.index');
    Route::post('products', 'store')->name('products.store');
    Route::get('products/create', 'create')->name('products.create');
    Route::get('products/{product}', 'show')->name('products.show');
    Route::put('products/{product}', 'update')->name('products.update');
    Route::delete('products/{product}', 'destroy')->name('products.destroy');
    Route::get('products/{product}/edit', 'edit')->name('products.edit');
    
});
Route::controller(UserController::class)->group(function(){
    Route::get('users', 'index')->name('users.index');
    Route::get('users/{user}/view', 'view')->name('users.view');
    Route::post('users', 'store')->name('users.store');
    Route::get('users/create', 'create')->name('users.create');
    Route::get('users/{user}', 'show')->name('users.show');
    Route::put('users/{user}', 'update')->name('users.update');
    Route::delete('users/{user}', 'destroy')->name('users.destroy');
    Route::get('users/{user}/edit', 'edit')->name('users.edit');
    Route::get('users-export', 'export')->name('users.export');
    Route::get('generate-pdf','generatePDF')->name('users.pdf');
    Route::get('/profile', 'profile')->name('profile');
    Route::get('/change_password', 'change_password')->name('change_password');
    Route::post('/update_profile', 'update_profile')->name('update_profile');
    Route::post('/update_password', 'update_password')->name('update_password');
    // Route::get('change_profile','changeProfile')->name('users.change_profile');
});
Route::controller(RoleController::class)->group(function(){
    Route::get('roles', 'index')->name('roles.index');
    Route::post('roles', 'store')->name('roles.store');
    Route::get('roles/create', 'create')->name('roles.create');
    Route::get('roles/{role}', 'show')->name('roles.show');
    Route::put('roles/{role}', 'update')->name('roles.update');
    Route::delete('roles/{role}', 'destroy')->name('roles.destroy');
    Route::get('roles/{role}/edit', 'edit')->name('roles.edit');
});
Route::controller(MemberController::class)->group(function(){
    Route::get('members', 'index')->name('members.index');
    Route::get('members/create', 'create')->name('members.create');
    Route::post('members', 'store')->name('members.store');
    Route::get('members/{user}/edit', 'edit')->name('members.edit');
    Route::get('members/{user}/reports', 'view_insurance_report')->name('members.reports');
    Route::put('members/{user}', 'update')->name('members.update');
    Route::get('members/{user}', 'show')->name('members.show');
    Route::get('/members/{user}/member_export','member_export')->name('members.member_export');
    Route::get('/members/{user}/generate_pdf','generate_pdf')->name('members.generate_pdf');
    
    
    Route::get('mediclaim/{user}/add', 'add_mediclaim')->name('mediclaim.add');
    Route::post('mediclaim', 'store_mediclaim')->name('mediclaim.store_mediclaim');
    Route::get('mediclaim/{user}/view', 'list_mediclaim')->name('mediclaim.view');
    Route::get('mediclaims/{mediclaim}', 'show_mediclaim')->name('mediclaim.show');
    Route::get('mediclaims/{mediclaim}/edit_mediclaim', 'edit_mediclaim')->name('mediclaim.edit');
    Route::put('mediclaims/{mediclaim}', 'update_mediclaim')->name('mediclaim.update_mediclaim');

    Route::get('life_insurance/{user}/add', 'add_life_insurance')->name('life_insurance.add');
    Route::post('life_insurance', 'store_life_insurance')->name('life_insurance.store_life_insurance');
    Route::get('life_insurance/{user}/view', 'list_life_insurance')->name('life_insurance.view');
    Route::get('life_insurances/{life_insurance}', 'show_life_insurance')->name('life_insurance.show');
    Route::get('life_insurances/{life_insurance}/edit_life_insurance', 'edit_life_insurance')->name('life_insurance.edit');
    Route::put('life_insurances/{life_insurance}', 'update_life_insurance')->name('life_insurance.update_life_insurance');

    Route::get('vehicle_insurance/{user}/add', 'add_vehicle_insurance')->name('vehicle_insurance.add');
    Route::post('vehicle_insurance', 'store_vehicle_insurance')->name('vehicle_insurance.store_vehicle_insurance');
    Route::get('vehicle_insurance/{user}/view', 'list_vehicle_insurance')->name('vehicle_insurance.view');
    Route::get('vehicle_insurances/{vehicle_insurance}', 'show_vehicle_insurance')->name('vehicle_insurance.show');
    Route::get('vehicle_insurances/{vehicle_insurance}/edit_vehicle_insurance', 'edit_vehicle_insurance')->name('vehicle_insurance.edit');
    Route::put('vehicle_insurances/{vehicle_insurance}', 'update_vehicle_insurance')->name('vehicle_insurance.update_vehicle_insurance');

    Route::get('mutual_fund/{user}/add', 'add_mutual_fund')->name('mutual_fund.add');
    Route::post('mutual_fund', 'store_mutual_fund')->name('mutual_fund.store_mutual_fund');
    Route::get('mutual_fund/{user}/view', 'list_mutual_fund')->name('mutual_fund.view');
    Route::get('mutual_funds/{mutual_fund}', 'show_mutual_fund')->name('mutual_fund.show');
    Route::get('mutual_funds/{mutual_fund}/edit_mutual_fund', 'edit_mutual_fund')->name('mutual_fund.edit');
    Route::put('mutual_funds/{mutual_fund}', 'update_mutual_fund')->name('mutual_fund.update_mutual_fund');
     
    Route::get('mediclaim', 'all_mediclaim')->name('mediclaim.all_mediclaim');
    Route::get('vehicle_insurance', 'all_vehicle_insurance')->name('vehicle_insurance.all_vehicle_insurance');
    Route::get('life_insurance', 'all_life_insurance')->name('life_insurance.all_life_insurance');
    Route::get('mutual_fund', 'all_mutual_fund')->name('mutual_fund.all_mutual_fund');
    Route::get('all_mediclaim/{mediclaim}/view', 'view_all_mediclaim')->name('view_all_mediclaim');
    Route::get('all_life_insurance/{life_insurance}/view', 'view_all_life_insurance')->name('view_all_life_insurance');
    Route::get('all_vehicle_insurance/{vehicle_insurance}/view', 'view_all_vehicle_insurance')->name('view_all_vehicle_insurance');
    Route::get('all_mutual_fund/{mutual_fund}/view', 'view_all_mutual_fund')->name('view_all_mutual_fund');

    Route::get('create_mediclaim_company', 'create_mediclaim_company')->name('create_mediclaim_company');
    Route::post('store_mediclaim_company', 'store_mediclaim_company')->name('store_mediclaim_company');
    Route::get('list_mediclaim_company', 'list_mediclaim_company')->name('list_mediclaim_company');
    Route::get('mediclaims/{company}/view', 'view_mediclaim_company')->name('view_mediclaim_company');
    Route::get('mediclaims/{company}/edit', 'edit_mediclaim_company')->name('edit_mediclaim_company');
    Route::put('update_mediclaim_company/{company}', 'update_mediclaim_company')->name('update_mediclaim_company');

    Route::get('create_life_insurance_company', 'create_life_insurance_company')->name('create_life_insurance_company');
    Route::get('list_life_insurance_company', 'list_life_insurance_company')->name('list_life_insurance_company');
    Route::post('store_life_insurance_company', 'store_life_insurance_company')->name('store_life_insurance_company');
    Route::get('life_insurance_company/{company}/view', 'view_life_insurance_company')->name('view_life_insurance_company');
    Route::get('life_insurance_company/{company}/edit', 'edit_life_insurance_company')->name('edit_life_insurance_company');
    Route::put('update_life_insurance_company/{company}', 'update_life_insurance_company')->name('update_life_insurance_company');
    
    Route::get('create_vehicle_insurance_company', 'create_vehicle_insurance_company')->name('create_vehicle_insurance_company');
    Route::get('list_vehicle_insurance_company', 'list_vehicle_insurance_company')->name('list_vehicle_insurance_company');
    Route::post('store_vehicle_insurance_company', 'store_vehicle_insurance_company')->name('store_vehicle_insurance_company');
    Route::get('vehicle_insurance_company/{company}/view', 'view_vehicle_insurance_company')->name('view_vehicle_insurance_company');
    Route::get('vehicle_insurance_company/{company}/edit', 'edit_vehicle_insurance_company')->name('edit_vehicle_insurance_company');
    Route::put('update_vehicle_insurance_company/{company}', 'update_vehicle_insurance_company')->name('update_vehicle_insurance_company');
});


Route::controller(CommonController::class)->group(function(){
    Route::post('fetchState', 'fetchState')->name('fetchState');
    Route::post('fetchCity', 'fetchCity')->name('fetchCity');
});