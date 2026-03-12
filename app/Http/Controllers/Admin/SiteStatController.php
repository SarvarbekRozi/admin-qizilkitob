<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteStat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteStatController extends Controller
{
    public function index(): View
    {
        $stats = SiteStat::orderBy('order')->paginate(20);

        return view('admin.site-stats.index', compact('stats'));
    }

    public function create(): View
    {
        return view('admin.site-stats.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'key'      => 'required|string|max:100|unique:site_stats,key',
            'value'    => 'required|string|max:50',
            'suffix'   => 'nullable|string|max:20',
            'label_uz' => 'required|string|max:255',
            'label_ru' => 'nullable|string|max:255',
            'label_en' => 'nullable|string|max:255',
            'icon'     => 'nullable|string|max:100',
            'order'    => 'nullable|integer|min:0',
        ]);

        $data = $request->only([
            'key', 'value', 'suffix',
            'label_uz', 'label_ru', 'label_en',
            'icon', 'order',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        $data['order']     = $request->input('order', 0);
        $data['suffix']    = $request->input('suffix', '+');
        $data['icon']      = $request->input('icon', 'fas fa-chart-bar');

        SiteStat::create($data);

        return redirect()->route('admin.site-stats.index')
            ->with('success', "Statistika muvaffaqiyatli qo'shildi.");
    }

    public function show(SiteStat $siteStat): RedirectResponse
    {
        return redirect()->route('admin.site-stats.edit', $siteStat);
    }

    public function edit(SiteStat $siteStat): View
    {
        return view('admin.site-stats.edit', compact('siteStat'));
    }

    public function update(Request $request, SiteStat $siteStat): RedirectResponse
    {
        $request->validate([
            'key'      => 'required|string|max:100|unique:site_stats,key,' . $siteStat->id,
            'value'    => 'required|string|max:50',
            'suffix'   => 'nullable|string|max:20',
            'label_uz' => 'required|string|max:255',
            'label_ru' => 'nullable|string|max:255',
            'label_en' => 'nullable|string|max:255',
            'icon'     => 'nullable|string|max:100',
            'order'    => 'nullable|integer|min:0',
        ]);

        $data = $request->only([
            'key', 'value', 'suffix',
            'label_uz', 'label_ru', 'label_en',
            'icon', 'order',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['order']     = $request->input('order', 0);
        $data['icon']      = $request->input('icon', 'fas fa-chart-bar');

        $siteStat->update($data);

        return redirect()->route('admin.site-stats.index')
            ->with('success', 'Statistika muvaffaqiyatli yangilandi.');
    }

    public function destroy(SiteStat $siteStat): RedirectResponse
    {
        $siteStat->delete();

        return redirect()->route('admin.site-stats.index')
            ->with('success', "Statistika o'chirildi.");
    }
}
