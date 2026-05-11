<?php

namespace Database\Seeders\NationalParks;

use App\Models\NaturalResource;
use Illuminate\Database\Seeder;

abstract class AbstractParkSeeder extends Seeder
{
    abstract protected function data(): array;

    public function run(): void
    {
        $data = $this->data();

        $existing = NaturalResource::where('slug', $data['slug'])->first();
        if ($existing && $existing->image && str_starts_with($existing->image, '/uploads/')) {
            $data['image'] = $existing->image;
        }

        $payload = [
            'category'       => 'milliy-tabiat-boglari',
            'title_uz'       => $data['title_uz'],
            'title_ru'       => $data['title_ru'],
            'title_en'       => $data['title_en'],
            'excerpt_uz'     => $data['excerpt_uz'],
            'excerpt_ru'     => $data['excerpt_ru'],
            'excerpt_en'     => $data['excerpt_en'],
            'content_uz'     => $this->paragraphs($data['content_uz']),
            'content_ru'     => $this->paragraphs($data['content_ru']),
            'content_en'     => $this->paragraphs($data['content_en']),
            'features_uz'    => $data['features_uz'],
            'features_ru'    => $data['features_ru'],
            'features_en'    => $data['features_en'],
            'stat_area'      => $data['stat_area'],
            'stat_species'   => $data['stat_species'],
            'stat_protected' => $data['stat_protected'] ?? '1-toifa',
            'latitude'       => $data['latitude'],
            'longitude'      => $data['longitude'],
            'image'          => $data['image'],
            'image_gallery'  => $data['image_gallery'] ?? [],
            'is_active'      => true,
            'featured'       => $data['featured'] ?? false,
        ];

        NaturalResource::updateOrCreate(['slug' => $data['slug']], $payload);
    }

    protected function paragraphs(string $text): string
    {
        $text = trim($text);
        $blocks = preg_split('/\n\s*\n/', $text);

        return implode("\n", array_map(function (string $block) {
            return '<p>' . nl2br(htmlspecialchars(trim($block), ENT_QUOTES | ENT_HTML5, 'UTF-8'), false) . '</p>';
        }, $blocks));
    }
}
