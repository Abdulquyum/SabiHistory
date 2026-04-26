@extends('layouts.app')

@section('title', 'About')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-3xl font-bold mb-4">About SabiHistory</h1>
    <p class="text-gray-700 mb-4">SabiHistory is a student-built platform for the Department of History & Strategic Studies, University of Lagos. Our mission is to provide free, accessible, and high-quality academic resources to help students excel.</p>
    <h2 class="text-xl font-semibold mt-6 mb-2">What We Offer</h2>
    <ul class="list-disc pl-6 space-y-1">
        <li>Unlimited study materials (PDFs, notes, links)</li>
        <li>Past questions with model solutions</li>
        <li>AI-powered research assistant</li>
        <li>Lecturer ratings and reviews</li>
        <li>Daily history facts on X (Twitter)</li>
        <li>Read-only final year projects archive</li>
    </ul>
    <h2 class="text-xl font-semibold mt-6 mb-2">Built With</h2>
    <p>Laravel, MySQL, Tailwind CSS, Gemini AI, Twitter API, and a lot of late nights.</p>
    <div class="mt-8 p-4 bg-gray-100 rounded-lg">
        <p class="text-center">📧 Contact: <a href="mailto:sabihistory@unilag.edu.ng" class="text-blue-600">sabihistory@unilag.edu.ng</a></p>
    </div>
</div>
@endsection