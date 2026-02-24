<x-admin::app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-4">Welcome, {{ Auth::guard('admin')->user()->name }}!</h3>
                    <p class="text-lg mb-4">You are logged in as an Administrator.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-blue-50 dark:bg-gray-700 p-6 rounded-lg">
                            <h4 class="font-semibold text-lg mb-2">Admin Panel</h4>
                            <p class="text-gray-600 dark:text-gray-300">Manage system settings and users</p>
                        </div>
                        <div class="bg-green-50 dark:bg-gray-700 p-6 rounded-lg">
                            <h4 class="font-semibold text-lg mb-2">Reports</h4>
                            <p class="text-gray-600 dark:text-gray-300">View system reports and analytics</p>
                        </div>
                        <div class="bg-purple-50 dark:bg-gray-700 p-6 rounded-lg">
                            <h4 class="font-semibold text-lg mb-2">Configuration</h4>
                            <p class="text-gray-600 dark:text-gray-300">Configure system settings</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin::app-layout>
