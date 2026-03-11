<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Contact;
use App\Models\NaturalResource;
use App\Models\Species;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'species'         => Species::count(),
            'blog_posts'      => BlogPost::count(),
            'resources'       => NaturalResource::count(),
            'unread_contacts' => Contact::where('is_read', false)->count(),
            'total_contacts'  => Contact::count(),
            'featured_species'=> Species::where('featured', true)->count(),
        ];

        $recentSpecies = Species::orderByDesc('created_at')->limit(5)->get();
        $recentPosts   = BlogPost::with('category')->orderByDesc('created_at')->limit(5)->get();
        $recentContacts = Contact::orderByDesc('created_at')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentSpecies', 'recentPosts', 'recentContacts'));
    }
}
