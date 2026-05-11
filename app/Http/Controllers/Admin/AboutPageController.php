<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AboutPageController extends Controller
{
    public function edit(): View
    {
        $page = AboutPage::singleton();
        return view('admin.about-page.edit', compact('page'));
    }

    public function update(Request $request): RedirectResponse
    {
        $page = AboutPage::singleton();

        $request->validate([
            'hero_image_file'  => 'nullable|image|max:5120',
            'intro_image_file' => 'nullable|image|max:5120',
        ]);

        $data = $request->only([
            'hero_title_uz', 'hero_title_ru', 'hero_title_en',
            'hero_subtitle_uz', 'hero_subtitle_ru', 'hero_subtitle_en',
            'hero_image',
            'intro_title_uz', 'intro_title_ru', 'intro_title_en',
            'intro_description_uz', 'intro_description_ru', 'intro_description_en',
            'intro_image',
            'mission_title_uz', 'mission_title_ru', 'mission_title_en',
            'mission_text_uz', 'mission_text_ru', 'mission_text_en',
            'vision_title_uz', 'vision_title_ru', 'vision_title_en',
            'vision_text_uz', 'vision_text_ru', 'vision_text_en',
            'goals_title_uz', 'goals_title_ru', 'goals_title_en',
        ]);

        // Goals (textarea lines → array)
        foreach (['goals_uz', 'goals_ru', 'goals_en'] as $field) {
            $value = $request->input($field);
            if (is_string($value)) {
                $lines = array_values(array_filter(array_map('trim', preg_split("/\r\n|\n|\r/", $value))));
                $data[$field] = $lines;
            }
        }

        // Stats — array of rows
        $stats = [];
        $statValues = (array) $request->input('stat_value', []);
        $statLabelsUz = (array) $request->input('stat_label_uz', []);
        $statLabelsRu = (array) $request->input('stat_label_ru', []);
        $statLabelsEn = (array) $request->input('stat_label_en', []);
        $statIcons    = (array) $request->input('stat_icon', []);

        foreach ($statValues as $i => $val) {
            $val = trim((string) $val);
            if ($val === '' && empty($statLabelsUz[$i]) && empty($statLabelsRu[$i]) && empty($statLabelsEn[$i])) {
                continue;
            }
            $stats[] = [
                'value'    => $val,
                'label_uz' => trim((string) ($statLabelsUz[$i] ?? '')),
                'label_ru' => trim((string) ($statLabelsRu[$i] ?? '')),
                'label_en' => trim((string) ($statLabelsEn[$i] ?? '')),
                'icon'     => trim((string) ($statIcons[$i] ?? '')) ?: null,
            ];
        }
        $data['stats'] = $stats;

        $data['show_team'] = $request->boolean('show_team');

        // Image uploads
        if ($request->hasFile('hero_image_file')) {
            $data['hero_image'] = $this->saveImage($request->file('hero_image_file'), 'hero', $page->hero_image);
        }
        if ($request->hasFile('intro_image_file')) {
            $data['intro_image'] = $this->saveImage($request->file('intro_image_file'), 'intro', $page->intro_image);
        }

        $page->fill($data)->save();

        return redirect()->route('admin.about-page.edit')
            ->with('success', 'Biz haqimizda sahifasi yangilandi.');
    }

    private function saveImage($file, string $prefix, ?string $oldPath): string
    {
        if ($oldPath && str_starts_with($oldPath, '/uploads/') && file_exists(public_path($oldPath))) {
            @unlink(public_path($oldPath));
        }
        $filename = 'about_' . $prefix . '_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/about'), $filename);
        return '/uploads/about/' . $filename;
    }
}
