<x-tenant::guest-layout>
    <form method="POST" action="{{ route('tenant.password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
        <div class="mt-4">
            <x-tenant::input-label for="email" :value="__('Email')" />
            <x-tenant::text-input 
                id="email" 
                class="block mt-1 w-full" 
                type="email" 
                name="email" 
                :value="old('email', $request->email)" 
                required 
                autocomplete="username" 
            />
            <x-tenant::input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-tenant::input-label for="password" :value="__('Password')" />
            <x-tenant::text-input 
                id="password" 
                class="block mt-1 w-full" 
                type="password" 
                name="password" 
                required 
                autocomplete="new-password" 
            />
            <x-tenant::input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-tenant::input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-tenant::text-input 
                id="password_confirmation" 
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password" 
            />
            <x-tenant::input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Reset Password Button (Full Width) -->
        <div class="mt-6">
            <x-tenant::primary-button class="w-full justify-center">
                {{ __('Reset Password') }}
            </x-tenant::primary-button>
        </div>

    </form>
</x-tenant::guest-layout>
