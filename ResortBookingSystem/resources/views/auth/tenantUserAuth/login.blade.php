<x-tenant-user::guest-layout>

    <!-- Session Status -->
    <x-tenant-user::auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('tenant.user.login', ['tenant_slug' => request()->route('tenant_slug')]) }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-tenant-user::input-label for="email" :value="__('Email')" />
            <x-tenant-user::text-input 
                id="email" 
                class="block mt-1 w-full" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username" />
            <x-tenant-user::input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-tenant-user::input-label for="password" :value="__('Password')" />
            <x-tenant-user::text-input 
                id="password" 
                class="block mt-1 w-full"
                type="password"
                name="password"
                required 
                autocomplete="current-password" />
            <x-tenant-user::input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me + Forgot Password (same line) -->
        <div class="flex items-center justify-between mt-4">
            <!-- Remember Me -->
            <label class="inline-flex items-center">
                <input id="remember_me" type="checkbox" 
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                       name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>

            <!-- Forgot Password -->
            @if (Route::has('tenant.user.password.request'))
                <a class="text-sm underline text-indigo-600 hover:text-indigo-800 dark:text-gray-400 dark:hover:text-gray-100" 
                   href="{{ route('tenant.user.password.request', ['tenant_slug' => request()->route('tenant_slug')]) }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <!-- Login Button (Full Width) -->
        <div class="mt-6">
            <x-tenant-user::primary-button class="w-full justify-center">
                {{ __('Log in') }}
            </x-tenant-user::primary-button>
        </div>

        <!-- Register (Centered below) -->
        <div class="flex justify-center mt-4">
            <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Don\'t have an account?') }}</span>
            <a class="ms-2 underline text-sm text-indigo-600 hover:text-indigo-800" 
               href="{{ route('tenant.user.register', ['tenant_slug' => request()->route('tenant_slug')]) }}">
                {{ __('Register') }}
            </a>
        </div>

    </form>

</x-tenant-user::guest-layout>
