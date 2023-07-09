<?php

use App\Http\Controllers\Auth\CandidatesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Sign_upController;
use App\Http\Controllers\Auth\IndexController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\SettingsController;
use App\Http\Controllers\Auth\ElectionController;
use App\Http\Controllers\Auth\PostController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\auth\VueController;
use App\Http\Controllers\Auth\VuetifyController;
use App\Http\Controllers\Forgot_passwordController;

Route::post('register-user', [Sign_upController::class, 'sign_up'])->name('register_user');
Route::get('logout', [IndexController::class, 'logout'] )->name('logout');

//VUE-JS api ROUTES ===
Route::prefix('api')->middleware('auth')->group( function(){
    Route::get('fetch-elections', [VueController::class, 'fetch_elections'] )->name('fetch_elections');

    //=== user info ===///
    Route::get('fetch-user-info', [ProfileController::class, 'user_info'] )->name('fetch_user_info');

    //== Fetch app Data ==///
    Route::get('fetch-app-data', [VuetifyController::class, 'fetch_app_data'] )->name('fetch_app_data');
//==settings
    Route::any('store_wards', [SettingsController::class, 'store_wards'] )->name('store_wards');
    Route::any('store_app_data', [SettingsController::class, 'store'] )->name('store_app_data');
});

///=== Login/Regiser Routes ===///
Route::prefix('')->middleware('guest')->group( function(){
    Route::get('/', [LoginController::class, 'login_page'])->name('login');
    Route::post('login-user', [LoginController::class, 'login_user'])->name('login_user');
    Route::get('sign-up-u', [Sign_upController::class, 'user_registration_page'])->name('user_registration_page');
    Route::get('sign-up-o', [Sign_upController::class, 'organization_registration_page'])->name('organization_registration_page');
    
    Route::get('password-reset', [Forgot_passwordController::class, 'forgot_password_page'] )->name('forgot_password_page');
    Route::post('reset-password', [Forgot_passwordController::class, 'send_password_reset_email'] )->name('send_password_reset_email');
    Route::get('confirm-password-reset', [Forgot_passwordController::class, 'confirm_password_reset_token'])->name('confirm_password_reset_token');
});

//VUE-JS ROUTES ===
Route::prefix('auth')->middleware('auth')->group( function(){
    Route::get('{any?}', [IndexController::class, 'vue_homepage'] )
          ->where('any','.*')
          ->name('homepage');
});

