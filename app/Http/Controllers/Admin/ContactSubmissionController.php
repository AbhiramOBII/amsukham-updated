<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactSubmissionController extends Controller
{
    public function index()
    {
        $submissions = ContactSubmission::latest()->paginate(20);
        $unreadCount = ContactSubmission::unread()->count();
        return view('admin.contact-submissions.index', compact('submissions', 'unreadCount'));
    }

    public function show(ContactSubmission $contactSubmission)
    {
        if (!$contactSubmission->is_read) {
            $contactSubmission->update(['is_read' => true]);
        }
        return view('admin.contact-submissions.show', compact('contactSubmission'));
    }

    public function destroy(ContactSubmission $contactSubmission)
    {
        $contactSubmission->delete();
        return redirect()->route('admin.contact-submissions.index')->with('success', 'Submission deleted successfully!');
    }

    public function markAsRead(ContactSubmission $contactSubmission)
    {
        $contactSubmission->update(['is_read' => true]);
        return redirect()->back()->with('success', 'Marked as read!');
    }

    public function markAllAsRead()
    {
        ContactSubmission::unread()->update(['is_read' => true]);
        return redirect()->back()->with('success', 'All submissions marked as read!');
    }
}
