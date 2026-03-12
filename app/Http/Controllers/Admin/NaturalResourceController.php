<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NaturalResource;
use App\Models\ProtectedArea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NaturalResourceController extends Controller
{
    public function index(Request $request): View
    {
        $query = NaturalResource::orderByDesc('created_at');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title_uz', 'ilike', "%{$s}%")
                  ->orWhere('title_ru', 'ilike', "%{$s}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $resources = $query->paginate(15)->withQueryString();
        $protectedAreas = ProtectedArea::active()->orderBy('order')->get();
        $areasMap = $protectedAreas->pluck('name_uz', 'slug');

        return view('admin.natural-resources.index', compact('resources', 'protectedAreas', 'areasMap'));
    }

    public function create(): View
    {
        $protectedAreas = ProtectedArea::active()->orderBy('order')->get();
        return view('admin.natural-resources.create', compact('protectedAreas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title_uz' => 'required|string|max:255',
            'title_ru' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'image'    => 'nullable|image|max:5120',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude'=> 'nullable|numeric|between:-180,180',
        ]);

        $data = $request->except(['image', 'image_gallery', '_token']);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($request->title_uz);
        }

        $data['featured'] = $request->boolean('featured');
        $data['is_active'] = $request->boolean('is_active', true);

        foreach (['features_uz', 'features_ru', 'features_en'] as $field) {
            if ($request->filled($field)) {
                $lines = array_filter(array_map('trim', explode("\n", $request->input($field))));
                $data[$field] = array_values($lines);
            } else {
                $data[$field] = null;
            }
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'resource_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/resources'), $filename);
            $data['image'] = '/uploads/resources/' . $filename;
        }

        if ($request->hasFile('image_gallery')) {
            $gallery = [];
            foreach ($request->file('image_gallery') as $img) {
                $fname = 'resource_gallery_' . time() . '_' . Str::random(8) . '.' . $img->getClientOriginalExtension();
                $img->move(public_path('uploads/resources'), $fname);
                $gallery[] = '/uploads/resources/' . $fname;
            }
            $data['image_gallery'] = $gallery;
        }

        NaturalResource::create($data);

        return redirect()->route('admin.natural-resources.index')
            ->with('success', "Tabiiy boylik muvaffaqiyatli qo'shildi.");
    }

    public function show(NaturalResource $naturalResource): View
    {
        return redirect()->route('admin.natural-resources.edit', $naturalResource);
    }

    public function edit(NaturalResource $naturalResource): View
    {
        $protectedAreas = ProtectedArea::active()->orderBy('order')->get();
        return view('admin.natural-resources.edit', compact('naturalResource', 'protectedAreas'));
    }

    public function update(Request $request, NaturalResource $naturalResource): RedirectResponse
    {
        $request->validate([
            'title_uz' => 'required|string|max:255',
            'title_ru' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'image'    => 'nullable|image|max:5120',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude'=> 'nullable|numeric|between:-180,180',
        ]);

        $data = $request->except(['image', 'image_gallery', '_token', '_method', 'gallery_remove']);

        $data['featured'] = $request->boolean('featured');
        $data['is_active'] = $request->boolean('is_active', true);

        foreach (['features_uz', 'features_ru', 'features_en'] as $field) {
            if ($request->filled($field)) {
                $lines = array_filter(array_map('trim', explode("\n", $request->input($field))));
                $data[$field] = array_values($lines);
            } else {
                $data[$field] = null;
            }
        }

        if ($request->hasFile('image')) {
            if ($naturalResource->image && file_exists(public_path($naturalResource->image))) {
                @unlink(public_path($naturalResource->image));
            }
            $file = $request->file('image');
            $filename = 'resource_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/resources'), $filename);
            $data['image'] = '/uploads/resources/' . $filename;
        }

        $existingGallery = $naturalResource->image_gallery ?? [];
        $galleryRemove = $request->input('gallery_remove', []);
        $existingGallery = array_values(array_filter($existingGallery, fn($img) => !in_array($img, $galleryRemove)));

        if ($request->hasFile('image_gallery')) {
            foreach ($request->file('image_gallery') as $img) {
                $fname = 'resource_gallery_' . time() . '_' . Str::random(8) . '.' . $img->getClientOriginalExtension();
                $img->move(public_path('uploads/resources'), $fname);
                $existingGallery[] = '/uploads/resources/' . $fname;
            }
        }
        $data['image_gallery'] = $existingGallery;

        $naturalResource->update($data);

        return redirect()->route('admin.natural-resources.index')
            ->with('success', 'Tabiiy boylik muvaffaqiyatli yangilandi.');
    }

    public function destroy(NaturalResource $naturalResource): RedirectResponse
    {
        if ($naturalResource->image && file_exists(public_path($naturalResource->image))) {
            @unlink(public_path($naturalResource->image));
        }
        $naturalResource->delete();

        return redirect()->route('admin.natural-resources.index')
            ->with('success', "Tabiiy boylik muvaffaqiyatli o'chirildi.");
    }
}
