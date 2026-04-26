@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900">System Settings</h1>
        <p class="text-gray-600 mt-1">Configure system-wide settings and preferences</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Settings Form -->
    <div class="bg-white rounded-xl shadow hover:shadow-lg transition">
        <div class="bg-gradient-to-r from-gray-500 to-gray-600 px-6 py-4 rounded-t-xl">
            <h2 class="text-lg font-bold text-white flex items-center">
                <i class="fas fa-cog mr-2"></i>
                Application Settings
            </h2>
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Setting 1 -->
                <div>
                    <label for="setting1" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-cogs mr-1"></i> Setting 1
                    </label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" id="setting1" name="setting1" placeholder="Enter setting value">
                </div>

                <!-- Setting 2 -->
                <div>
                    <label for="setting2" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-sliders-h mr-1"></i> Setting 2
                    </label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" id="setting2" name="setting2" placeholder="Enter setting value">
                </div>

                <!-- Max Upload Size -->
                <div>
                    <label for="max_upload" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-file-upload mr-1"></i> Max Upload Size (MB)
                    </label>
                    <input type="number" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" id="max_upload" name="max_upload" placeholder="100" min="1">
                </div>

                <!-- Maintenance Mode -->
                <div>
                    <label for="maintenance" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tools mr-1"></i> Maintenance Mode
                    </label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" id="maintenance" name="maintenance">
                        <option value="0">Off</option>
                        <option value="1">On</option>
                    </select>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-align-left mr-1"></i> Site Description
                </label>
                <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" id="description" name="description" rows="4" placeholder="Enter site description"></textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-2 pt-4">
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-8 py-2 rounded-lg font-medium transition flex items-center gap-2">
                    <i class="fas fa-save mr-1"></i> Save Settings
                </button>
                <a href="{{ route('admin.dashboard') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-8 py-2 rounded-lg font-medium transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Settings Info Card -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
        <h3 class="font-bold text-blue-900 flex items-center mb-2">
            <i class="fas fa-info-circle mr-2"></i> Information
        </h3>
        <ul class="text-sm text-blue-800 space-y-1">
            <li>• All changes will be applied system-wide</li>
            <li>• Some settings may require cache clearing</li>
            <li>• Critical settings are backed up automatically</li>
        </ul>
    </div>
</div>
@endsection
