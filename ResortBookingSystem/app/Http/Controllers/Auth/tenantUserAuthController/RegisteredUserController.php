<?php

namespace App\Http\Controllers\Auth\tenantUserAuthController;

use App\Http\Controllers\Controller;
use App\Models\TenantUserModel\RegularUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.tenantUserAuth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Get tenant slug from route
        $slug = $request->route('tenant_slug');
        if (!$slug) {
            return back()->withErrors(['error' => 'Invalid tenant']);
        }
        
        // Validate email uniqueness against tenant database
        $existingUser = DB::connection('tenant')
            ->table('regular_users')
            ->where('email', $request->email)
            ->first();
        
        if ($existingUser) {
            return back()->withErrors(['email' => 'The email has already been taken.'])->onlyInput('email');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create user in tenant database
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::connection('tenant')->table('regular_users')->insert($userData);

        // Fetch the created user
        $user = DB::connection('tenant')
            ->table('regular_users')
            ->where('email', $request->email)
            ->first();

        // Create model instance
        $userModel = new RegularUser();
        $userModel->setConnection('tenant');
        $userModel->forceFill((array) $user);

        event(new Registered($userModel));

        // Login the user
        Auth::guard('regular_user')->login($userModel);
        
        // Store tenant info in session
        $request->session()->put('tenant_slug', $slug);
        $request->session()->regenerate();
        
        return redirect('/' . $slug . '/user/dashboard');
    }
}

