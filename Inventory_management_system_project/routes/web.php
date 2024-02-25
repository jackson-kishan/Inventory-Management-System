<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/user-registration', [UserController::class, 'UserRegistration']);
Route::post('/user-login', [UserController::class, 'UserLogin']);
Route::post('/send-otp', [UserController::class, 'SendOTPCode']);
Route::post('/verify-otp', [UserController::class, 'VerifyOTP']);
Route::post('/reset-pass', [UserController::class, 'ResetPassword']);
//Route::post('/reset-pass', [UserController::class, 'ResetPassword'])->middleware([TokenVerificationMiddleware::class]);

Route::get('/user-profile', [UserController::class, 'UserProfile']);
// Route::get('/user-profile', [UserController::class, 'UserProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/user-update', [UserController::class, 'UpdateProfile']);
// Route::post('/user-update', [UserController::class, 'UpdateProfile'])->middleware([TokenVerificationMiddleware::class]);

 //user logout
 Route::get('/logout', [UserController::class, 'UserLogout']);

// Route::get('/userLogin', [UserController::class, 'LoginPage']);
// Route::get('/userRegistration', [UserController::class, 'RegistrationPage']);
// Route::get('/sendOtp', [UserController::class, 'SendOtpPage']);
// Route::get('/verifyOtp', [UserController::class, 'VerifyOtpPage']);
// Route::get('/resetPassword', [UserController::class, 'ResetPasswordPage']);

Route::get('/categoryPage', [CategoryController::class, 'CategoryPage']);
Route::post("/create-category",[CategoryController::class,'CategoryCreate']);
Route::get("/list-category",[CategoryController::class,'CategoryList']);
Route::post("/delete-category",[CategoryController::class,'CategoryDelete']);
Route::post("/update-category",[CategoryController::class,'CategoryUpdate']);
Route::post("/category-by-id",[CategoryController::class,'CategoryByID']);


Route::post('/create-customer', [CustomerController::class,'CustomerCreate']); //add Authontication middleware
Route::get('/list-customer', [CustomerController::class,'CustomerList']);
Route::post('/delete-customer', [CustomerController::class,'CustomerDelete']);
Route::post('/update-customer', [CustomerController::class,'CustomerUpdate']);
Route::post('/customer-by-id', [CustomerController::class,'CustomerByID']);
Route::get('/CustomerPage' , [CustomerController::class,'CustomerPage']);

Route::post('/create-product', [ProductController::class,'CreateProduct']); //add Authontication middleware
Route::get('/list-product', [ProductController::class,'ProductList']);
Route::post('/delete-product', [ProductController::class,'DeleteProduct']);
Route::post('/update-product', [ProductController::class,'UpdateProduct']);
Route::post('/product-by-id', [ProductController::class,'ProductByID']);
Route::get('/ProductPage' , [ProductController::class,'ProductPage']);

Route::get('/invoicePage', [InvoiceController::class,'InvoicePage']);
Route::get('/salePage', [InvoiceController::class,'SalePage']);

Route::post('/invoice-create', [InvoiceController::class,'InvoiceCreate']);
Route::get('/invoice-select', [InvoiceController::class,'InvoiceSelect']);
Route::post('/invoice-delete', [InvoiceController::class,'InvoiceDelete']);
Route::post('/invoice-detail', [InvoiceController::class,'InvoiceDetail']);


Route::view('/userLogin', 'pages.auth.login-page'); 
Route::view('/userRegistration', 'pages.auth.registration-page');
Route::view('/sendOtp', 'pages.auth.send-otp-page');
Route::view('/verifyOtp', 'pages.auth.verify-otp-page');
Route::view('/resetPassword', 'pages.auth.reset-pass-page');
// Route::view('/resetPassword', 'pages.auth.reset-pass-page')->middleware([TokenVerificationMiddleware::class]);
Route::view('/dashboard', 'pages.dashboard.profile-page');
// Route::view('/dashboard', 'pages.dashboard.profile-page')->middleware([TokenVerificationMiddleware::class]);

Route::view('/products', 'pages.dashboard.product-page');