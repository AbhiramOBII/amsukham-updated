@extends('admin.layouts.app')

@section('title', 'Contact Submissions')
@section('page-title', 'Contact Submissions')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-600">
        @if($unreadCount > 0)
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 mr-2">
                {{ $unreadCount }} unread
            </span>
        @endif
        View messages from your contact form
    </p>
    @if($unreadCount > 0)
        <form action="{{ route('admin.contact-submissions.mark-all-read') }}" method="POST">
            @csrf
            <button type="submit" class="text-amber-600 hover:text-amber-800 text-sm">Mark all as read</button>
        </form>
    @endif
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($submissions as $submission)
                <tr class="{{ !$submission->is_read ? 'bg-amber-50' : '' }}">
                    <td class="px-6 py-4">
                        @if(!$submission->is_read)
                            <span class="w-2 h-2 bg-amber-500 rounded-full inline-block"></span>
                        @else
                            <span class="w-2 h-2 bg-gray-300 rounded-full inline-block"></span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900 {{ !$submission->is_read ? 'font-semibold' : '' }}">{{ $submission->name }}</div>
                        @if($submission->phone)
                            <div class="text-sm text-gray-500">{{ $submission->phone }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $submission->email }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $submission->subject ?? '-' }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $submission->created_at->format('M d, Y H:i') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.contact-submissions.show', $submission) }}" class="text-amber-600 hover:text-amber-800 mr-3">View</a>
                        <form action="{{ route('admin.contact-submissions.destroy', $submission) }}" method="POST" class="inline" onsubmit="return confirm('Delete this submission?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        No contact submissions yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $submissions->links() }}
</div>
@endsection
