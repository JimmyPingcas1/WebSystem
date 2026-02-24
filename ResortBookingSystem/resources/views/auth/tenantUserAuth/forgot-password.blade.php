<x-tenant-user::guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-tenant-user::auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('user.password.email', ['tenant_slug' => request()->route('tenant_slug')]) }}">
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
            />
            <x-tenant-user::input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Submit Button (Full Width) -->
        <div class="mt-6">
            <x-tenant-user::primary-button class="w-full justify-center">
                {{ __('Email Password Reset Link') }}
            </x-tenant-user::primary-button>
        </div>

    </form>
</x-tenant-user::guest-layout>
