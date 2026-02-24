<x-tenant::app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tenant Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">
                    Welcome, {{ auth('tenant')->user()->name }}!
                </h2>
                <p class="mb-6 text-gray-600 dark:text-gray-400">
                    Here are your available tenant resources:
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Payment Portal -->
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow hover:shadow-md transition">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Payment Portal</h4>
                        <p class="text-gray-600 dark:text-gray-300 mb-2">Pay your rent securely online.</p>
                        <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Go to Portal</a>
                    </div>

                    <!-- Maintenance Requests -->
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow hover:shadow-md transition">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Maintenance Requests</h4>
                        <p class="text-gray-600 dark:text-gray-300 mb-2">Submit and track maintenance issues.</p>
                        <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Request Maintenance</a>
                    </div>

                    <!-- Community Notices -->
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow hover:shadow-md transition">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Community Notices</h4>
                        <p class="text-gray-600 dark:text-gray-300 mb-2">View announcements and events.</p>
                        <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">View Notices</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant::app-layout>
