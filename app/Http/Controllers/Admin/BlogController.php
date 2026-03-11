<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $query = BlogPost::with(['category'])->orderByDesc('created_at');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title_uz', 'ilike', "%{$s}%")
                  ->orWhere('title_ru', 'ilike', "%{$s}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $posts = $query->paginate(15)->withQueryString();
        $categories = BlogCategory::orderBy('title_uz')->get();

        return view('admin.blog.index', compact('posts', 'categories'));
    }

    public function create(): View
    {
        $categories = BlogCategory::orderBy('title_uz')->get();
        $tags = BlogTag::orderBy('title_uz')->get();
        return view('admin.blog.create', compact('categories', 'tags'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title_uz'    => 'required|string|max:255',
            'title_ru'    => 'required|string|max:255',
            'title_en'    => 'required|string|max:255',
            'category_id' => 'nullable|exists:blog_categories,id',
            'image'       => 'nullable|image|max:5120',
        ]);

        $data = $request->except(['image', '_token', 'tags']);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($request->title_uz);
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $data['publish_date'] = $request->filled('publish_date') ? $request->publish_date : now();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'blog_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/blog'), $filename);
            $data['image'] = '/uploads/blog/' . $filename;
        }

        $post = BlogPost::create($data);

        if ($request->filled('tags')) {
            $post->tags()->sync($request->input('tags', []));
        }

        return redirect()->route('admin.blog.index')
            ->with('success', "Blog post muvaffaqiyatli qo'shildi.");
    }

    public function edit(BlogPost $blog): View
    {
        $categories = BlogCategory::orderBy('title_uz')->get();
        $tags = BlogTag::orderBy('title_uz')->get();
        $blog->load('tags');
        return view('admin.blog.edit', compact('blog', 'categories', 'tags'));
    }

    public function update(Request $request, BlogPost $blog): RedirectResponse
    {
        $request->validate([
            'title_uz'    => 'required|string|max:255',
            'title_ru'    => 'required|string|max:255',
            'title_en'    => 'required|string|max:255',
            'category_id' => 'nullable|exists:blog_categories,id',
            'image'       => 'nullable|image|max:5120',
        ]);

        $data = $request->except(['image', '_token', '_method', 'tags']);

        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            if ($blog->image && file_exists(public_path($blog->image))) {
                @unlink(public_path($blog->image));
            }
            $file = $request->file('image');
            $filename = 'blog_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/blog'), $filename);
            $data['image'] = '/uploads/blog/' . $filename;
        }

        $blog->update($data);
        $blog->tags()->sync($request->input('tags', []));

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post muvaffaqiyatli yangilandi.');
    }

    public function destroy(BlogPost $blog): RedirectResponse
    {
        if ($blog->image && file_exists(public_path($blog->image))) {
            @unlink(public_path($blog->image));
        }
        $blog->delete();

        return redirect()->route('admin.blog.index')
            ->with('success', "Blog post muvaffaqiyatli o'chirildi.");
    }

    // Category management
    public function categoriesIndex(): View
    {
        $categories = BlogCategory::withCount('posts')->orderBy('title_uz')->get();
        return view('admin.blog.categories.index', compact('categories'));
    }

    public function categoryStore(Request $request): RedirectResponse
    {
        $request->validate([
            'title_uz' => 'required|string|max:255',
            'title_ru' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
        ]);

        $data = $request->only(['title_uz', 'title_ru', 'title_en']);
        $data['slug'] = Str::slug($request->title_uz);

        BlogCategory::create($data);

        return back()->with('success', "Kategoriya qo'shildi.");
    }

    public function categoryDestroy(BlogCategory $category): RedirectResponse
    {
        $category->delete();
        return back()->with('success', "Kategoriya o'chirildi.");
    }
}
