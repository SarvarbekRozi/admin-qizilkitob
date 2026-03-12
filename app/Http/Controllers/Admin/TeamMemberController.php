<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    public function index(): View
    {
        $members = TeamMember::orderBy('order')->orderBy('name_uz')->paginate(20);
        return view('admin.team.index', compact('members'));
    }

    public function create(): View
    {
        return view('admin.team.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name_uz' => 'required|string|max:255',
            'image'   => 'nullable|image|max:3072',
        ]);

        $data = $request->except(['image', '_token']);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['order']     = (int) $request->input('order', 0);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'team_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/team'), $filename);
            $data['image'] = '/uploads/team/' . $filename;
        }

        TeamMember::create($data);

        return redirect()->route('admin.team.index')
            ->with('success', "A'zo muvaffaqiyatli qo'shildi.");
    }

    public function show(TeamMember $team): RedirectResponse
    {
        return redirect()->route('admin.team.edit', $team);
    }

    public function edit(TeamMember $team): View
    {
        return view('admin.team.edit', compact('team'));
    }

    public function update(Request $request, TeamMember $team): RedirectResponse
    {
        $request->validate([
            'name_uz' => 'required|string|max:255',
            'image'   => 'nullable|image|max:3072',
        ]);

        $data = $request->except(['image', '_token', '_method']);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['order']     = (int) $request->input('order', 0);

        if ($request->hasFile('image')) {
            if ($team->image && file_exists(public_path($team->image))) {
                @unlink(public_path($team->image));
            }
            $file = $request->file('image');
            $filename = 'team_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/team'), $filename);
            $data['image'] = '/uploads/team/' . $filename;
        }

        $team->update($data);

        return redirect()->route('admin.team.index')
            ->with('success', "A'zo muvaffaqiyatli yangilandi.");
    }

    public function destroy(TeamMember $team): RedirectResponse
    {
        if ($team->image && file_exists(public_path($team->image))) {
            @unlink(public_path($team->image));
        }
        $team->delete();

        return redirect()->route('admin.team.index')
            ->with('success', "A'zo muvaffaqiyatli o'chirildi.");
    }
}
