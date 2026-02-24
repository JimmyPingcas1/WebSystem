<x-tenant::guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Forgot your password? No problem. Just let us know your tenant slug and email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-tenant::auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('tenant.password.email') }}">
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

        <!-- Submit Button (Full Width) -->
        <div class="mt-6">
            <x-tenant::primary-button class="w-full justify-center">
                {{ __('Email Password Reset Link') }}
            </x-tenant::primary-button>
        </div>
    </form>
</x-tenant::guest-layout>
