<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('subject', 'like', '%' . $request->search . '%')
                  ->orWhere('message', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'reviewed') {
                $query->whereNotNull('reviewed_at');
            } else {
                $query->whereNull('reviewed_at');
            }
        }

        $contacts = $query->latest()->paginate(10)->withQueryString();

        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    public function markAsReviewed(Contact $contact)
    {
        if (!$contact->reviewed_at) {
            $contact->update([
                'reviewed_at' => now(),
                'status' => 'reviewed'
            ]);
            
            return redirect()->back()->with('success', 'Contact message marked as reviewed!');
        } else {
            // Toggle back to unreviewed
            $contact->update([
                'reviewed_at' => null,
                'status' => 'new'
            ]);
            
            return redirect()->back()->with('success', 'Contact message marked as unreviewed!');
        }
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')
                        ->with('success', 'Contact message deleted successfully!');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'contacts' => 'required|array',
            'contacts.*' => 'exists:contacts,id',
            'action' => 'required|in:mark_reviewed,delete',
        ]);

        $contacts = Contact::whereIn('id', $request->contacts);

        switch ($request->action) {
            case 'mark_reviewed':
                $contacts->update([
                    'reviewed_at' => now(),
                    'status' => 'reviewed'
                ]);
                $message = 'Messages marked as reviewed successfully!';
                break;
            case 'delete':
                $contacts->delete();
                $message = 'Messages deleted successfully!';
                break;
        }

        return redirect()->back()->with('success', $message);
    }
}