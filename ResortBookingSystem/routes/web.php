<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Middleware\SetTenantDatabase;
use App\Http\Controllers\tenantControlllers\ProfileController;
use App\Http\Controllers\Auth\TenantRegisterController;
use App\Http\Controllers\Auth\TenantLoginController;
use App\Http\Controllers\Auth\AdminLoginController;

// routes/web.php
use App\Http\Controllers\TenantController;
use App\Http\Controllers\DebugController;

Route::get('/tenants', [TenantController::class, 'index'])->name('tenants.index');

// Debug routes
Route::get('/debug/tenants', [DebugController::class, 'checkTenants']);
Route::get('/debug/tenant/{slug}', [DebugController::class, 'checkTenant']);
Route::get('/debug/all-tenants-users', [DebugController::class, 'checkAllTenantUsers']);


// Routes for testing
Route::get('/debug/tenant-users/{slug}', function ($slug) {
    $tenant = \App\Models\Tenant::where('slug', $slug)->first();
    if (!$tenant) {
        return response()->json(['error' => 'Tenant not found'], 404);
    }
    
    config(['database.connections.tenant.database' => $tenant->database_name]);
    \Illuminate\Support\Facades\DB::purge('tenant');
    
    $users = \Illuminate\Support\Facades\DB::connection('tenant')->table('tenant_users')->get();
    return response()->json([
        'tenant' => $tenant,
        'database' => $tenant->database_name,
        'user_count' => count($users),
        'users' => $users
    ]);
});

Route::get('/debug/test-login/{slug}/{email}/{password}', function ($slug, $email, $password) {
    $tenant = \App\Models\Tenant::where('slug', $slug)->first();
    if (!$tenant) {
        return response()->json(['error' => 'Tenant not found'], 404);
    }
    
    config(['database.connections.tenant.database' => $tenant->database_name]);
    \Illuminate\Support\Facades\DB::purge('tenant');
    
    $user = \Illuminate\Support\Facades\DB::connection('tenant')->table('tenant_users')->where('email', $email)->first();
    
    if (!$user) {
        return response()->json([
            'status' => 'failed',
            'reason' => 'User not found',
            'email_searched' => $email
        ]);
    }
    
    $passwordMatch = \Illuminate\Support\Facades\Hash::check($password, $user->password);
    
    return response()->json([
        'status' => $passwordMatch ? 'success' : 'failed',
        'reason' => $passwordMatch ? 'Password matches!' : 'Password does not match',
        'user' => $user,
        'password_hash' => $user->password
    ]);
});


Route::get('/', function () {
    return view('landing');
})->name('landing');


// =======================
// ADMIN ROUTES (TOP)
// =======================
Route::prefix('admin')->name('admin.')->group(function () {

    // Guest admin routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'create'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'store']);
    });

    // Authenticated admin routes
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [\App\Http\Controllers\Auth\LogoutController::class, 'admin'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'adminIndex'])->name('dashboard');
        
        // Admin profile routes
        Route::get('/profile', [\App\Http\Controllers\adminControlller\ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [\App\Http\Controllers\adminControlller\ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [\App\Http\Controllers\adminControlller\ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('/profile/send-verification', [\App\Http\Controllers\adminControlller\ProfileController::class, 'sendVerification'])->name('verification.send');
        
        // Admin password update
        Route::put('/password', [\App\Http\Controllers\adminControlller\PasswordController::class, 'update'])->name('password.update');
    });
});


// Generic tenant selector routes (show full login/register forms)
Route::get('/tenant/login', function () {
    return view('auth.tenantAuth.login');
})->name('tenant.select.login');

Route::post('/tenant/login', [TenantLoginController::class, 'store']);

Route::get('/tenant/register', function () {
    return view('auth.tenantAuth.register');
})->name('tenant.select.register');

Route::post('/tenant/register', [TenantRegisterController::class, 'store']);

// Tenant password reset routes
Route::middleware('guest')->group(function () {
    Route::get('/tenant/forgot-password', [\App\Http\Controllers\Auth\tenantAuthController\PasswordResetLinkController::class, 'create'])->name('tenant.password.request');
    Route::post('/tenant/forgot-password', [\App\Http\Controllers\Auth\tenantAuthController\PasswordResetLinkController::class, 'store'])->name('tenant.password.email');
    Route::get('/tenant/reset-password/{token}', [\App\Http\Controllers\Auth\tenantAuthController\NewPasswordController::class, 'create'])->name('tenant.password.reset');
    Route::post('/tenant/reset-password', [\App\Http\Controllers\Auth\tenantAuthController\NewPasswordController::class, 'store'])->name('tenant.password.store');
});

Route::get('/check-tenants', function () {
    $tenants = \Illuminate\Support\Facades\DB::table('tenants')->select('slug', 'database_name')->get();
    return response()->json($tenants);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Slug-based tenant routes - UNAUTHENTICATED (landing page, login)
Route::prefix('{tenant_slug}')->middleware([SetTenantDatabase::class])->group(function () {
    // Tenant landing page
    Route::get('/', function () {
        return view('Tenant.TenantLandingPage');
    })->name('tenant.landing');
    
    // Tenant login routes (must be guest)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [\App\Http\Controllers\Auth\TenantLoginController::class, 'create'])->name('tenant.login');
        Route::post('/login', [\App\Http\Controllers\Auth\TenantLoginController::class, 'store']);
        
        Route::get('/user/login', [\App\Http\Controllers\Auth\TenantUserLoginController::class, 'create'])->name('tenant.user.login');
        Route::post('/user/login', [\App\Http\Controllers\Auth\TenantUserLoginController::class, 'store']);
        
        Route::get('/user/register', [\App\Http\Controllers\Auth\tenantUserAuthController\RegisteredUserController::class, 'create'])->name('tenant.user.register');
        Route::post('/user/register', [\App\Http\Controllers\Auth\tenantUserAuthController\RegisteredUserController::class, 'store']);
        
        // Tenant user password reset routes
        Route::get('/user/forgot-password', [\App\Http\Controllers\Auth\tenantUserAuthController\PasswordResetLinkController::class, 'create'])->name('tenant.user.password.request');
        Route::post('/user/forgot-password', [\App\Http\Controllers\Auth\tenantUserAuthController\PasswordResetLinkController::class, 'store'])->name('user.password.email');
        Route::get('/user/reset-password/{token}', [\App\Http\Controllers\Auth\tenantUserAuthController\NewPasswordController::class, 'create'])->name('tenant.user.password.reset');
        Route::post('/user/reset-password', [\App\Http\Controllers\Auth\tenantUserAuthController\NewPasswordController::class, 'store'])->name('user.password.store');
    });
});

// Slug-based tenant routes - AUTHENTICATED (dashboard, profile)
Route::prefix('{tenant_slug}')->middleware([SetTenantDatabase::class, 'auth:tenant'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'tenantIndex'])->name('tenant.dashboard');
    
    // Tenant profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('tenant.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('tenant.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('tenant.profile.destroy');
    Route::post('/profile/send-verification', [ProfileController::class, 'sendVerification'])->name('tenant.verification.send');
    
    // Tenant password update
    Route::put('/password', [\App\Http\Controllers\Auth\tenantAuthController\PasswordController::class, 'update'])->name('tenant.password.update');
    
    // Tenant logout
    Route::post('/logout', [\App\Http\Controllers\Auth\LogoutController::class, 'tenant'])->name('tenant.logout');
});

// Slug-based tenant USER routes - AUTHENTICATED (dashboard, profile)
Route::prefix('{tenant_slug}')->middleware([SetTenantDatabase::class, 'auth:regular_user'])->group(function () {
    Route::get('/user/dashboard', [DashboardController::class, 'userIndex'])->name('tenant.user.dashboard');
    
    // Tenant user profile routes
    Route::get('/user/profile', [\App\Http\Controllers\tenantUserControlllers\ProfileController::class, 'edit'])->name('tenant.user.profile.edit');
    Route::patch('/user/profile', [\App\Http\Controllers\tenantUserControlllers\ProfileController::class, 'update'])->name('tenant.user.profile.update');
    Route::delete('/user/profile', [\App\Http\Controllers\tenantUserControlllers\ProfileController::class, 'destroy'])->name('tenant.user.profile.destroy');
    Route::post('/user/profile/send-verification', [\App\Http\Controllers\tenantUserControlllers\ProfileController::class, 'sendVerification'])->name('tenant.user.verification.send');
    
    // Tenant user password update
    Route::put('/user/password', [\App\Http\Controllers\Auth\tenantUserAuthController\PasswordController::class, 'update'])->name('tenant.user.password.update');
    
    // Tenant user logout
    Route::post('/user/logout', [\App\Http\Controllers\Auth\LogoutController::class, 'user'])->name('tenant.user.logout');
});



require __DIR__.'/auth.php';


// Load domain-based tenant routing
require __DIR__.'/usingDomain.php';
