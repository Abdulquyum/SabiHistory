@extends('layouts.app')

@section('title', 'Quick Links')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-4xl font-bold text-gray-900">Quick Links</h1>
        <p class="text-gray-600 mt-2">Important resources for UNILAG & Faculty of Arts students</p>
    </div>

    <!-- Links Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- University of Lagos -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <h2 class="font-bold text-lg text-white flex items-center">
                    <i class="fas fa-university mr-2"></i> University of Lagos
                </h2>
            </div>
            <ul class="space-y-0 divide-y divide-gray-200">
                <li>
                    <a href="https://unilag.edu.ng" target="_blank" class="block px-6 py-3 text-blue-600 hover:bg-blue-50 transition flex items-center justify-between">
                        <span><i class="fas fa-link mr-2"></i> Official Website</span>
                        <i class="fas fa-external-link-alt text-sm"></i>
                    </a>
                </li>
                <li>
                    <a href="https://unilag.edu.ng/?page_id=2632" target="_blank" class="block px-6 py-3 text-blue-600 hover:bg-blue-50 transition flex items-center justify-between">
                        <span><i class="fas fa-calendar mr-2"></i> Academic Calendar</span>
                        <i class="fas fa-external-link-alt text-sm"></i>
                    </a>
                </li>
                <li>
                    <a href="https://studentportal.unilag.edu.ng" target="_blank" class="block px-6 py-3 text-blue-600 hover:bg-blue-50 transition flex items-center justify-between">
                        <span><i class="fas fa-sign-in-alt mr-2"></i> Student Portal</span>
                        <i class="fas fa-external-link-alt text-sm"></i>
                    </a>
                </li>
                <li>
                    <a href="https://library.unilag.edu.ng" target="_blank" class="block px-6 py-3 text-blue-600 hover:bg-blue-50 transition flex items-center justify-between">
                        <span><i class="fas fa-book mr-2"></i> University Library</span>
                        <i class="fas fa-external-link-alt text-sm"></i>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Faculty of Arts -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                <h2 class="font-bold text-lg text-white flex items-center">
                    <i class="fas fa-landmark mr-2"></i> Faculty of Arts
                </h2>
            </div>
            <ul class="space-y-0 divide-y divide-gray-200">
                <li>
                    <a href="https://arts.unilag.edu.ng" target="_blank" class="block px-6 py-3 text-purple-600 hover:bg-purple-50 transition flex items-center justify-between">
                        <span><i class="fas fa-link mr-2"></i> Faculty Website</span>
                        <i class="fas fa-external-link-alt text-sm"></i>
                    </a>
                </li>
                <li>
                    <a href="https://arts.unilag.edu.ng/departments/history-strategic-studies" target="_blank" class="block px-6 py-3 text-purple-600 hover:bg-purple-50 transition flex items-center justify-between">
                        <span><i class="fas fa-graduation-cap mr-2"></i> History & Strategic Studies</span>
                        <i class="fas fa-external-link-alt text-sm"></i>
                    </a>
                </li>
                <li>
                    <a href="https://arts.unilag.edu.ng/staff" target="_blank" class="block px-6 py-3 text-purple-600 hover:bg-purple-50 transition flex items-center justify-between">
                        <span><i class="fas fa-users mr-2"></i> Faculty Staff Directory</span>
                        <i class="fas fa-external-link-alt text-sm"></i>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Research & Repository -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
            <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                <h2 class="font-bold text-lg text-white flex items-center">
                    <i class="fas fa-database mr-2"></i> Research & Repository
                </h2>
            </div>
            <ul class="space-y-0 divide-y divide-gray-200">
                <li>
                    <a href="https://ir.unilag.edu.ng" target="_blank" class="block px-6 py-3 text-green-600 hover:bg-green-50 transition flex items-center justify-between">
                        <span><i class="fas fa-archive mr-2"></i> UNILAG Repository</span>
                        <i class="fas fa-external-link-alt text-sm"></i>
                    </a>
                </li>
                <li>
                    <a href="https://scholar.google.com" target="_blank" class="block px-6 py-3 text-green-600 hover:bg-green-50 transition flex items-center justify-between">
                        <span><i class="fas fa-search mr-2"></i> Google Scholar</span>
                        <i class="fas fa-external-link-alt text-sm"></i>
                    </a>
                </li>
                <li>
                    <a href="https://www.jstor.org" target="_blank" class="block px-6 py-3 text-green-600 hover:bg-green-50 transition flex items-center justify-between">
                        <span><i class="fas fa-journal-whills mr-2"></i> JSTOR (via Library)</span>
                        <i class="fas fa-external-link-alt text-sm"></i>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Student Tools -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                <h2 class="font-bold text-lg text-white flex items-center">
                    <i class="fas fa-tools mr-2"></i> Student Tools
                </h2>
            </div>
            <ul class="space-y-0 divide-y divide-gray-200">
                <li>
                    <a href="https://forms.gle/yourform" target="_blank" class="block px-6 py-3 text-orange-600 hover:bg-orange-50 transition flex items-center justify-between">
                        <span><i class="fas fa-clipboard-check mr-2"></i> Course Registration Help</span>
                        <i class="fas fa-external-link-alt text-sm"></i>
                    </a>
                </li>
                <li>
                    <a href="https://wa.me/234xxxxxxxxx" target="_blank" class="block px-6 py-3 text-orange-600 hover:bg-orange-50 transition flex items-center justify-between">
                        <span><i class="fab fa-whatsapp mr-2"></i> Department WhatsApp</span>
                        <i class="fas fa-external-link-alt text-sm"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ route('materials.index') }}" class="block px-6 py-3 text-orange-600 hover:bg-orange-50 transition flex items-center justify-between">
                        <span><i class="fas fa-file-download mr-2"></i> SabiHistory Materials</span>
                        <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Additional Resources Info -->
    <div class="bg-green-50 border border-green-200 rounded-xl p-6">
        <div class="flex items-start gap-3">
            <i class="fas fa-lightbulb text-green-600 text-xl mt-0.5"></i>
            <div>
                <p class="font-bold text-green-900">Pro Tip</p>
                <p class="text-green-800 text-sm mt-1">
                    Use the UNILAG student portal to access course materials, check grades, and register for courses. 
                    Don't forget to check the academic calendar for important deadlines!
                </p>
            </div>
        </div>
    </div>
</div>
@endsection