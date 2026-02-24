<x-tenant-user::guest-layout>
    <form method="POST" action="{{ route('tenant.user.register', ['tenant_slug' => request()->route('tenant_slug')]) }}">
        @csrf

        <!-- Name -->
        <div>
            <x-tenant-user::input-label for="name" :value="__('Name')" />
            <x-tenant-user::text-input 
                id="name" 
                class="block mt-1 w-full" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required 
                autofocus 
                autocomplete="name" />
            <x-tenant-user::input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-tenant-user::input-label for="email" :value="__('Email')" />
            <x-tenant-user::text-input 
                id="email" 
                class="block mt-1 w-full" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
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
                autocomplete="new-password" />
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
                autocomplete="new-password" />
            <x-tenant-user::input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Register Button (Full Width) -->
        <div class="mt-6">
            <x-tenant-user::primary-button class="w-full justify-center">
                {{ __('Register') }}
            </x-tenant-user::primary-button>
        </div>

        <!-- Already Registered Link (Centered Below) -->
        <div class="flex justify-center mt-4">
            <a class="underline text-sm text-indigo-600 hover:text-indigo-800"
               href="{{ route('tenant.user.login', ['tenant_slug' => request()->route('tenant_slug')]) }}">
                {{ __('Already registered?') }}
            </a>
        </div>
    </form>
</x-tenant-user::guest-layout>
