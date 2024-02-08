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
    Route::put('members/{user}', 'update')->name('members.update');

});
    
Route::controller(CommonController::class)->group(function(){
    Route::post('fetchState', 'fetchState')->name('fetchState');
    Route::post('fetchCity', 'fetchCity')->name('fetchCity');
});