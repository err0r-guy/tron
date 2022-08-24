<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Route::get('/cron', [App\Http\Controllers\CronController::class, 'cron'])->name('cron');

Route::prefix('ipn')->name('ipn.')->group(function () {
    Route::post('/coinpayments', [App\Http\Controllers\coinpayments\ProcessController::class, 'ipn'])->name('coinpayments');
    Route::post('/nowpayments', [App\Http\Controllers\nowpayments\ProcessController::class, 'ipn'])->name('nowpayments');
    Route::get('/nowpayments/{payment_id}/{order_id}/confirm/{planPrice}', [App\Http\Controllers\nowpayments\ProcessController::class, 'confirmPayment'])->name('confirmPayment');
});

// Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/affiliate', [App\Http\Controllers\HomeController::class, 'affiliate'])->name('affiliate');
Route::get('/payouts', [App\Http\Controllers\HomeController::class, 'payouts'])->name('payouts');
Route::get('/faq', [App\Http\Controllers\HomeController::class, 'faq'])->name('faq');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [App\Http\Controllers\HomeController::class, 'contactInsert']);

Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::post('/password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

Route::prefix('user')->name('user.')->group(function () {
    // User Dashboard
    Route::get('/dashboard', [App\Http\Controllers\UserController::class, 'index'])->name('dashboard');
    Route::get('/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\UserController::class, 'profileUpdate']);
    // Buy plan
    Route::get('/plan/upgrade/{plan_id}', [App\Http\Controllers\UserController::class, 'upgradePlan'])->name('plan.upgrade');
    Route::get('/invoice/{hash}', [App\Http\Controllers\UserController::class, 'invoice'])->name('plan.invoice');
    // Transactions, Deposits, Withdraws, Refferals etc
    Route::get('/transactions', [App\Http\Controllers\UserController::class, 'transactions'])->name('transactions');
    // Withdrawal
    Route::get('/withdraw', [App\Http\Controllers\UserController::class, 'withdraw'])->name('withdraw');
    Route::post('/withdraw', [App\Http\Controllers\UserController::class, 'withdrawInsert']);
});

Route::prefix('admin')->name('admin.')->group(function () {
    // Admin
    Route::get('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('logout');
    // Admin Password Reset
    Route::get('/password/reset', [App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/reset', [App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('/password/verify-code', [App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'verifyCode'])->name('password.verify-code');
    Route::get('/password/reset/{token}', [App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.change-link');
    Route::post('/password/reset/change', [App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'reset'])->name('password.change');

    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');
        Route::get('/settings', [App\Http\Controllers\Admin\AdminController::class, 'settings'])->name('settings');
        Route::post('/settings/update', [App\Http\Controllers\Admin\AdminController::class, 'settingsPost'])->name('settings.update');
        Route::get('/profile', [App\Http\Controllers\Admin\AdminController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [App\Http\Controllers\Admin\AdminController::class, 'profilePost'])->name('profile.update');
        Route::post('/profile/password', [App\Http\Controllers\Admin\AdminController::class, 'profilePasswordPost'])->name('profile.password');

        Route::resource('/plans', App\Http\Controllers\Admin\PlanController::class);
        Route::get('/plans/{id}/approve', [App\Http\Controllers\Admin\PlanController::class, 'approve'])->name('plans.approve');
        Route::get('/plans/{id}/unapprove', [App\Http\Controllers\Admin\PlanController::class, 'unapprove'])->name('plans.unapprove');

        Route::resource('/users', App\Http\Controllers\Admin\UserController::class);
        Route::get('/users/{id}/approve', [App\Http\Controllers\Admin\UserController::class, 'approve'])->name('users.approve');
        Route::get('/users/{id}/unapprove', [App\Http\Controllers\Admin\UserController::class, 'unapprove'])->name('users.unapprove');

        Route::resource('/admins', App\Http\Controllers\Admin\AdminsController::class);
        Route::get('/admins/{id}/approve', [App\Http\Controllers\Admin\AdminsController::class, 'approve'])->name('admins.approve');
        Route::get('/admins/{id}/unapprove', [App\Http\Controllers\Admin\AdminsController::class, 'unapprove'])->name('admins.unapprove');

        Route::get('/frontends', [App\Http\Controllers\Admin\AdminController::class, 'frontends'])->name('frontends');
        Route::post('/frontends/{key}/update', [App\Http\Controllers\Admin\AdminController::class, 'frontendsUpdate'])->name('frontends.update');

        Route::resource('/faqs', App\Http\Controllers\Admin\FaqsController::class);

        Route::get('/deposits', [App\Http\Controllers\Admin\DepositsController::class, 'index'])->name('deposits');

        Route::get('/withdrawals', [App\Http\Controllers\Admin\WithdrawalsController::class, 'index'])->name('withdrawals');

        Route::get('/contacts', [App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contacts');
        Route::delete('/contacts/{id}', [App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contacts.destroy');

        Route::get('/admins', [App\Http\Controllers\Admin\AdminsController::class, 'index'])->name('admins');
    });
});
