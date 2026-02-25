@extends('admin.layouts.app')

@section('title', 'View Submission')
@section('page-title', 'Contact Submission')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h3 class="text-xl font-semibold text-gray-900">{{ $contactSubmission->name }}</h3>
                <p class="text-gray-500">{{ $contactSubmission->created_at->format('F d, Y \a\t H:i') }}</p>
            </div>
            @if(!$contactSubmission->is_read)
                <span class="px-2 py-1 text-xs font-medium bg-amber-100 text-amber-800 rounded-full">Unread</span>
            @endif
        </div>

        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                <p class="text-gray-900">
                    <a href="mailto:{{ $contactSubmission->email }}" class="text-amber-600 hover:underline">{{ $contactSubmission->email }}</a>
                </p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Phone</label>
                <p class="text-gray-900">
                    @if($contactSubmission->phone)
                        <a href="tel:{{ $contactSubmission->phone }}" class="text-amber-600 hover:underline">{{ $contactSubmission->phone }}</a>
                    @else
                        <span class="text-gray-400">Not provided</span>
                    @endif
                </p>
            </div>
        </div>

        @if($contactSubmission->subject)
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-500 mb-1">Subject</label>
                <p class="text-gray-900">{{ $contactSubmission->subject }}</p>
            </div>
        @endif

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-500 mb-1">Message</label>
            <div class="bg-gray-50 rounded-lg p-4 text-gray-900 whitespace-pre-wrap">{{ $contactSubmission->message }}</div>
        </div>

        <div class="flex justify-between items-center pt-6 border-t">
            <a href="{{ route('admin.contact-submissions.index') }}" class="text-gray-600 hover:text-gray-800">
                ← Back to list
            </a>
            <div class="flex gap-4">
                <a href="mailto:{{ $contactSubmission->email }}" class="bg-amber-600 text-white px-4 py-2 rounded hover:bg-amber-700">
                    Reply via Email
                </a>
                <form action="{{ route('admin.contact-submissions.destroy', $contactSubmission) }}" method="POST" onsubmit="return confirm('Delete this submission?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 px-4 py-2">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
