<x-tenant-user::guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('user.password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-tenant-user::input-label for="password" :value="__('Password')" />

            <x-tenant-user::text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-tenant-user::input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-tenant-user::primary-button>
                {{ __('Confirm') }}
            </x-tenant-user::primary-button>
        </div>
    </form>
</x-tenant-user::guest-layout>
