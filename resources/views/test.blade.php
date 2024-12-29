<x-app-layout>


<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">My Teams</h1>
        <a href="/teams/create" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            + Add Team
        </a>
    </div>

    <!-- Grid Layout -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Single Team Card -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <div class="flex items-center mb-4">
                <!-- Team Logo -->
                <img src="/path-to-logo.png" alt="Team Logo" class="w-12 h-12 rounded-full mr-4">
                <!-- Team Info -->
                <div>
                    <h2 class="text-lg font-bold">Team Name</h2>
                    <p class="text-sm text-gray-500">Created on: 2024-12-01</p>
                </div>
            </div>
            <!-- Actions -->
            <div class="flex justify-between mt-4">
                <a href="/teams/1" class="text-blue-500 hover:underline">View</a>
                <div>
                    <a href="/teams/1/edit" class="text-yellow-500 hover:underline mr-4">Edit</a>
                    <button class="text-red-500 hover:underline">Delete</button>
                </div>
            </div>
        </div>
        <!-- Repeat for other teams -->
    </div>
</div>
</x-app-layout>