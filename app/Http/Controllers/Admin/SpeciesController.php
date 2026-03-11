<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Species;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SpeciesController extends Controller
{
    public function index(Request $request): View
    {
        $query = Species::orderByDesc('created_at');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name_uz', 'ilike', "%{$s}%")
                  ->orWhere('scientific_name', 'ilike', "%{$s}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('danger_level')) {
            $query->where('danger_level', $request->danger_level);
        }

        $species = $query->paginate(15)->withQueryString();

        return view('admin.species.index', compact('species'));
    }

    public function create(): View
    {
        $allSpecies = Species::orderBy('name_uz')->get(['id', 'name_uz', 'scientific_name']);
        return view('admin.species.create', compact('allSpecies'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name_uz'          => 'required|string|max:255',
            'name_ru'          => 'required|string|max:255',
            'name_en'          => 'required|string|max:255',
            'scientific_name'  => 'required|string|max:255',
            'category'         => 'required|in:animal,plant',
            'danger_level'     => 'required|in:critically_endangered,endangered,vulnerable,near_threatened',
            'slug'             => 'nullable|string|unique:species,slug|max:255',
            'image_main'       => 'nullable|image|max:5120',
            'featured'         => 'nullable|boolean',
            'is_active'        => 'nullable|boolean',
            'latitude'         => 'nullable|numeric|between:-90,90',
            'longitude'        => 'nullable|numeric|between:-180,180',
        ]);

        $data = $request->except(['image_main', 'image_gallery', '_token', 'gallery_remove']);

        // Slug
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($request->name_uz);
        }

        // Booleans
        $data['featured'] = $request->boolean('featured');
        $data['is_active'] = $request->boolean('is_active', true);

        // JSON fields from textarea
        foreach (['description_bullets_uz', 'description_bullets_ru', 'description_bullets_en',
                  'threats_uz', 'threats_ru', 'threats_en'] as $field) {
            if ($request->filled($field)) {
                $lines = array_filter(array_map('trim', explode("\n", $request->input($field))));
                $data[$field] = array_values($lines);
            } else {
                $data[$field] = null;
            }
        }

        // Related species
        $data['related_species'] = $request->input('related_species', []);

        // Main image upload
        if ($request->hasFile('image_main')) {
            $file = $request->file('image_main');
            $filename = 'species_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/species'), $filename);
            $data['image_main'] = '/uploads/species/' . $filename;
        }

        // Gallery images
        if ($request->hasFile('image_gallery')) {
            $gallery = [];
            foreach ($request->file('image_gallery') as $img) {
                $fname = 'gallery_' . time() . '_' . Str::random(8) . '.' . $img->getClientOriginalExtension();
                $img->move(public_path('uploads/species'), $fname);
                $gallery[] = '/uploads/species/' . $fname;
            }
            $data['image_gallery'] = $gallery;
        }

        Species::create($data);

        return redirect()->route('admin.species.index')
            ->with('success', "Tur muvaffaqiyatli qo'shildi.");
    }

    public function show(Species $species): View
    {
        return view('admin.species.show', compact('species'));
    }

    public function edit(Species $species): View
    {
        $allSpecies = Species::where('id', '!=', $species->id)
            ->orderBy('name_uz')
            ->get(['id', 'name_uz', 'scientific_name']);

        return view('admin.species.edit', compact('species', 'allSpecies'));
    }

    public function update(Request $request, Species $species): RedirectResponse
    {
        $request->validate([
            'name_uz'         => 'required|string|max:255',
            'name_ru'         => 'required|string|max:255',
            'name_en'         => 'required|string|max:255',
            'scientific_name' => 'required|string|max:255',
            'category'        => 'required|in:animal,plant',
            'danger_level'    => 'required|in:critically_endangered,endangered,vulnerable,near_threatened',
            'slug'            => 'nullable|string|max:255|unique:species,slug,' . $species->id,
            'image_main'      => 'nullable|image|max:5120',
            'latitude'        => 'nullable|numeric|between:-90,90',
            'longitude'       => 'nullable|numeric|between:-180,180',
        ]);

        $data = $request->except(['image_main', 'image_gallery', '_token', '_method', 'gallery_remove']);

        $data['featured'] = $request->boolean('featured');
        $data['is_active'] = $request->boolean('is_active', true);

        foreach (['description_bullets_uz', 'description_bullets_ru', 'description_bullets_en',
                  'threats_uz', 'threats_ru', 'threats_en'] as $field) {
            if ($request->filled($field)) {
                $lines = array_filter(array_map('trim', explode("\n", $request->input($field))));
                $data[$field] = array_values($lines);
            } else {
                $data[$field] = null;
            }
        }

        $data['related_species'] = $request->input('related_species', []);

        // Main image
        if ($request->hasFile('image_main')) {
            // Remove old
            if ($species->image_main && file_exists(public_path($species->image_main))) {
                @unlink(public_path($species->image_main));
            }
            $file = $request->file('image_main');
            $filename = 'species_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/species'), $filename);
            $data['image_main'] = '/uploads/species/' . $filename;
        }

        // Gallery
        $existingGallery = $species->image_gallery ?? [];
        $galleryRemove = $request->input('gallery_remove', []);
        $existingGallery = array_values(array_filter($existingGallery, fn($img) => !in_array($img, $galleryRemove)));

        if ($request->hasFile('image_gallery')) {
            foreach ($request->file('image_gallery') as $img) {
                $fname = 'gallery_' . time() . '_' . Str::random(8) . '.' . $img->getClientOriginalExtension();
                $img->move(public_path('uploads/species'), $fname);
                $existingGallery[] = '/uploads/species/' . $fname;
            }
        }
        $data['image_gallery'] = $existingGallery;

        $species->update($data);

        return redirect()->route('admin.species.index')
            ->with('success', 'Tur muvaffaqiyatli yangilandi.');
    }

    public function destroy(Species $species): RedirectResponse
    {
        if ($species->image_main && file_exists(public_path($species->image_main))) {
            @unlink(public_path($species->image_main));
        }

        $species->delete();

        return redirect()->route('admin.species.index')
            ->with('success', 'Tur muvaffaqiyatli o\'chirildi.');
    }
}
