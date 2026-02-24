<x-admin::app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-4">Welcome, {{ auth('admin')->user()->name }}!</h3>
                    <p class="mb-6 text-gray-600 dark:text-gray-400">
                        Here's an overview of your admin resources and actions:
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Manage Tenants -->
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow hover:shadow-md transition">
                            <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Manage Tenants</h4>
                            <p class="text-gray-600 dark:text-gray-300 mb-2">View, add, or remove tenants in the system.</p>
                            <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Go to Tenants</a>
                        </div>

                        <!-- Manage Payments -->
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow hover:shadow-md transition">
                            <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Payments</h4>
                            <p class="text-gray-600 dark:text-gray-300 mb-2">Review and manage tenant payments.</p>
                            <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">View Payments</a>
                        </div>

                        <!-- Maintenance Requests -->
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow hover:shadow-md transition">
                            <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Maintenance Requests</h4>
                            <p class="text-gray-600 dark:text-gray-300 mb-2">Track and assign maintenance tasks.</p>
                            <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Manage Requests</a>
                        </div>

                        <!-- Community Notices -->
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow hover:shadow-md transition">
                            <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Community Notices</h4>
                            <p class="text-gray-600 dark:text-gray-300 mb-2">Post and manage community announcements.</p>
                            <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Manage Notices</a>
                        </div>

                        <!-- Reports -->
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow hover:shadow-md transition">
                            <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Reports</h4>
                            <p class="text-gray-600 dark:text-gray-300 mb-2">View reports on tenants, payments, and maintenance.</p>
                            <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">View Reports</a>
                        </div>

                        <!-- System Settings -->
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow hover:shadow-md transition">
                            <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">System Settings</h4>
                            <p class="text-gray-600 dark:text-gray-300 mb-2">Configure system-wide settings and preferences.</p>
                            <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">View Settings</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin::app-layout>
