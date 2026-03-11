<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function index(Request $request): View
    {
        $query = Partner::orderBy('order')->orderBy('name_uz');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $partners = $query->paginate(20)->withQueryString();

        return view('admin.partners.index', compact('partners'));
    }

    public function create(): View
    {
        return view('admin.partners.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name_uz' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'type'    => 'required|in:international,national,research',
            'order'   => 'nullable|integer',
            'logo'    => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['logo', '_token']);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['order'] = $request->input('order', 0);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'partner_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/partners'), $filename);
            $data['logo'] = '/uploads/partners/' . $filename;
        }

        Partner::create($data);

        return redirect()->route('admin.partners.index')
            ->with('success', "Hamkor muvaffaqiyatli qo'shildi.");
    }

    public function show(Partner $partner): RedirectResponse
    {
        return redirect()->route('admin.partners.edit', $partner);
    }

    public function edit(Partner $partner): View
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner): RedirectResponse
    {
        $request->validate([
            'name_uz' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'type'    => 'required|in:international,national,research',
            'order'   => 'nullable|integer',
            'logo'    => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['logo', '_token', '_method']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('logo')) {
            if ($partner->logo && file_exists(public_path($partner->logo))) {
                @unlink(public_path($partner->logo));
            }
            $file = $request->file('logo');
            $filename = 'partner_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/partners'), $filename);
            $data['logo'] = '/uploads/partners/' . $filename;
        }

        $partner->update($data);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Hamkor muvaffaqiyatli yangilandi.');
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        if ($partner->logo && file_exists(public_path($partner->logo))) {
            @unlink(public_path($partner->logo));
        }
        $partner->delete();

        return redirect()->route('admin.partners.index')
            ->with('success', "Hamkor o'chirildi.");
    }
}
