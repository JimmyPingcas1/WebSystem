<x-tenant::guest-layout>
    <!-- Session Status -->
    <x-tenant::auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ url('/tenant/login') }}" class="space-y-4 mx-auto max-w-md">
        @csrf

        <!-- Tenant Slug -->
        <div>
            <x-tenant::input-label for="tenant_slug" :value="__('Tenant Slug')" />
            <x-tenant::text-input 
                id="tenant_slug" 
                class="block mt-1 w-full" 
                type="text" 
                name="tenant_slug" 
                :value="old('tenant_slug')" 
                required 
                autofocus 
                placeholder="Enter your tenant slug (e.g. djs)" 
            />
            <x-tenant::input-error :messages="$errors->get('tenant_slug')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-tenant::input-label for="email" :value="__('Email')" />
            <x-tenant::text-input 
                id="email" 
                class="block mt-1 w-full" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autocomplete="username" 
            />
            <x-tenant::input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-tenant::input-label for="password" :value="__('Password')" />
            <x-tenant::text-input 
                id="password" 
                class="block mt-1 w-full" 
                type="password" 
                name="password" 
                required 
                autocomplete="current-password" 
            />
            <x-tenant::input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-2">
            <!-- Remember Me -->
            <label for="remember_me" class="inline-flex items-center">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" 
                    name="remember"
                >
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>

            <!-- Forgot Password -->
            @if (Route::has('tenant.password.request'))
                <a 
                    class="underline text-sm text-indigo-600 hover:text-indigo-800 dark:text-gray-400 dark:hover:text-gray-100"
                    href="{{ route('tenant.password.request') }}"
                >
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <!-- Login Button (Full Width) -->
        <div class="mt-4">
            <x-tenant::primary-button class="w-full py-2 flex justify-center">
                {{ __('Log in') }}
            </x-tenant::primary-button>
        </div>

        <!-- Register Link (Centered Below) -->
        <div class="mt-4 w-full flex justify-center">
            <a 
                href="{{ route('tenant.select.register') }}" 
                class="text-sm text-gray-600 dark:text-gray-400 underline hover:text-gray-900 dark:hover:text-gray-100"
            >
                {{ __("Don't have an account? Register") }}
            </a>
        </div>

    </form>
</x-tenant::guest-layout>
