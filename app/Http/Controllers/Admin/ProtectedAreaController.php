<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProtectedArea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProtectedAreaController extends Controller
{
    public function index(): View
    {
        $areas = ProtectedArea::orderBy('order')->orderBy('name_uz')->paginate(20);

        return view('admin.protected-areas.index', compact('areas'));
    }

    public function create(): View
    {
        return view('admin.protected-areas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name_uz'    => 'required|string|max:255',
            'name_ru'    => 'nullable|string|max:255',
            'name_en'    => 'nullable|string|max:255',
            'slug'       => 'nullable|string|max:255|unique:protected_areas,slug',
            'count_text' => 'nullable|string|max:50',
            'icon'       => 'nullable|string|max:100',
            'order'      => 'nullable|integer|min:0',
        ]);

        $data = $request->only([
            'name_uz', 'name_ru', 'name_en',
            'count_text', 'icon', 'order',
        ]);

        $data['slug']      = $request->filled('slug')
            ? Str::slug($request->input('slug'))
            : Str::slug($request->input('name_uz'));

        // Ensure slug is unique
        $originalSlug = $data['slug'];
        $counter = 1;
        while (ProtectedArea::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter++;
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $data['order']     = $request->input('order', 0);
        $data['icon']      = $request->input('icon', 'fas fa-mountain');

        ProtectedArea::create($data);

        return redirect()->route('admin.protected-areas.index')
            ->with('success', "Muhofaza hududi muvaffaqiyatli qo'shildi.");
    }

    public function show(ProtectedArea $protectedArea): RedirectResponse
    {
        return redirect()->route('admin.protected-areas.edit', $protectedArea);
    }

    public function edit(ProtectedArea $protectedArea): View
    {
        return view('admin.protected-areas.edit', compact('protectedArea'));
    }

    public function update(Request $request, ProtectedArea $protectedArea): RedirectResponse
    {
        $request->validate([
            'name_uz'    => 'required|string|max:255',
            'name_ru'    => 'nullable|string|max:255',
            'name_en'    => 'nullable|string|max:255',
            'slug'       => 'nullable|string|max:255|unique:protected_areas,slug,' . $protectedArea->id,
            'count_text' => 'nullable|string|max:50',
            'icon'       => 'nullable|string|max:100',
            'order'      => 'nullable|integer|min:0',
        ]);

        $data = $request->only([
            'name_uz', 'name_ru', 'name_en',
            'count_text', 'icon', 'order',
        ]);

        if ($request->filled('slug')) {
            $data['slug'] = Str::slug($request->input('slug'));
        }

        $data['is_active'] = $request->boolean('is_active');
        $data['order']     = $request->input('order', 0);
        $data['icon']      = $request->input('icon', 'fas fa-mountain');

        $protectedArea->update($data);

        return redirect()->route('admin.protected-areas.index')
            ->with('success', 'Muhofaza hududi muvaffaqiyatli yangilandi.');
    }

    public function destroy(ProtectedArea $protectedArea): RedirectResponse
    {
        $protectedArea->delete();

        return redirect()->route('admin.protected-areas.index')
            ->with('success', "Muhofaza hududi o'chirildi.");
    }
}
