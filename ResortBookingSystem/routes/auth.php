<?php

use Illuminate\Support\Facades\Route;

// Role selector and global logout
Route::middleware('guest')->group(function () {
    Route::get('login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
});

// Redirect plain /admin to the admin login page
Route::get('/admin', function () {
    return redirect()->route('admin.login');
});
Route::post('logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Admin auth routes (URL: /admin/... , route names prefixed with admin.)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [\App\Http\Controllers\Auth\AdminLoginController::class, 'create'])->name('login');
        Route::post('login', [\App\Http\Controllers\Auth\AdminLoginController::class, 'store']);
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [\App\Http\Controllers\Auth\LogoutController::class, 'admin'])->name('logout');
    });

    Route::middleware(['auth:admin', 'verified'])->group(function () {
        Route::get('dashboard', [\App\Http\Controllers\Auth\DashboardController::class, 'adminIndex'])->name('dashboard');
        
        // Admin profile routes
        Route::get('profile', [\App\Http\Controllers\adminControlller\ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [\App\Http\Controllers\adminControlller\ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [\App\Http\Controllers\adminControlller\ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

// Tenant auth routes are now in web.php with slug prefix
// Example: /tenant_1/login, /tenant_1/dashboard, etc.
// See routes/web.php for slug-based tenant routing

// TenantUser auth routes are also in web.php with slug prefix
// Example: /tenant_1/user/login, /tenant_1/user/register, etc.
// See routes/web.php for slug-based tenant user routing

