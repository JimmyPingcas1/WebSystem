<x-tenant-user::guest-layout>
    <form method="POST" action="{{ route('user.password.store', ['tenant_slug' => request()->route('tenant_slug')]) }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-tenant-user::input-label for="email" :value="__('Email')" />
            <x-tenant-user::text-input 
                id="email" 
                class="block mt-1 w-full" 
                type="email" 
                name="email" 
                :value="old('email', $request->email)" 
                required 
                autofocus 
                autocomplete="username" 
            />
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
                autocomplete="new-password" 
            />
            <x-tenant-user::input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-tenant-user::input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-tenant-user::text-input 
                id="password_confirmation" 
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password" 
            />
            <x-tenant-user::input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Reset Password Button (Full Width) -->
        <div class="mt-6">
            <x-tenant-user::primary-button class="w-full justify-center">
                {{ __('Reset Password') }}
            </x-tenant-user::primary-button>
        </div>

    </form>
</x-tenant-user::guest-layout>
