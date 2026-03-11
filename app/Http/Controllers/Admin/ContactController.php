<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(Request $request): View
    {
        $query = Contact::orderByDesc('created_at');

        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->status === 'read') {
                $query->where('is_read', true);
            }
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'ilike', "%{$s}%")
                  ->orWhere('email', 'ilike', "%{$s}%")
                  ->orWhere('subject', 'ilike', "%{$s}%");
            });
        }

        $contacts = $query->paginate(20)->withQueryString();
        $unreadCount = Contact::where('is_read', false)->count();

        return view('admin.contacts.index', compact('contacts', 'unreadCount'));
    }

    public function show(Contact $contact): View
    {
        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
        }
        return view('admin.contacts.show', compact('contact'));
    }

    public function markAsRead(Contact $contact): RedirectResponse
    {
        $contact->update(['is_read' => true]);
        return back()->with('success', "O'qildi deb belgilandi.");
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')
            ->with('success', "Xabar o'chirildi.");
    }
}
