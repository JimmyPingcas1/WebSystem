<x-tenant-user::app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                            Welcome back, {{ auth('regular_user')->user()->name }}!
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">
                            Here are the resources available for you:
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                        <!-- Payment Portal -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 p-6 rounded-lg shadow-sm hover:shadow-md transition border border-blue-200 dark:border-blue-700">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-gray-800 dark:text-gray-200 ms-3">Payment Portal</h4>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 text-sm mb-3">Pay your monthly rent securely online.</p>
                            <a href="#" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                Go to Portal
                            </a>
                        </div>

                        <!-- Maintenance Requests -->
                        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 p-6 rounded-lg shadow-sm hover:shadow-md transition border border-green-200 dark:border-green-700">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-white">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-gray-800 dark:text-gray-200 ms-3">Maintenance</h4>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 text-sm mb-3">Submit and track your maintenance tickets.</p>
                            <a href="#" class="inline-block px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                                Request Maintenance
                            </a>
                        </div>

                        <!-- Community Notices -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 p-6 rounded-lg shadow-sm hover:shadow-md transition border border-purple-200 dark:border-purple-700">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center text-white">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-gray-800 dark:text-gray-200 ms-3">Notices</h4>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 text-sm mb-3">Stay updated with announcements and events.</p>
                            <a href="#" class="inline-block px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm font-medium">
                                View Notices
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant-user::app-layout>
