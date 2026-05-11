<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Illuminate\Http\JsonResponse;

class AboutPageApiController extends Controller
{
    public function show(): JsonResponse
    {
        $page = AboutPage::singleton();

        $data = [
            'hero' => [
                'title'    => $this->ml($page, 'hero_title'),
                'subtitle' => $this->ml($page, 'hero_subtitle'),
                'image'    => $page->hero_image,
            ],
            'intro' => [
                'title'       => $this->ml($page, 'intro_title'),
                'description' => $this->ml($page, 'intro_description'),
                'image'       => $page->intro_image,
            ],
            'mission' => [
                'title' => $this->ml($page, 'mission_title'),
                'text'  => $this->ml($page, 'mission_text'),
            ],
            'vision' => [
                'title' => $this->ml($page, 'vision_title'),
                'text'  => $this->ml($page, 'vision_text'),
            ],
            'goals' => [
                'title' => $this->ml($page, 'goals_title'),
                'items' => [
                    'uz' => $page->goals_uz ?? [],
                    'ru' => $page->goals_ru ?? [],
                    'en' => $page->goals_en ?? [],
                ],
            ],
            'stats' => collect($page->stats ?? [])->map(fn ($s) => [
                'value' => $s['value'] ?? '',
                'label' => [
                    'uz' => $s['label_uz'] ?? '',
                    'ru' => $s['label_ru'] ?? '',
                    'en' => $s['label_en'] ?? '',
                ],
                'icon'  => $s['icon'] ?? null,
            ])->values(),
            'show_team' => (bool) $page->show_team,
        ];

        return response()->json([
            'success' => true,
            'result'  => ['data' => $data],
        ]);
    }

    private function ml($page, string $base): array
    {
        return [
            'uz' => $page->{$base . '_uz'},
            'ru' => $page->{$base . '_ru'},
            'en' => $page->{$base . '_en'},
        ];
    }
}
