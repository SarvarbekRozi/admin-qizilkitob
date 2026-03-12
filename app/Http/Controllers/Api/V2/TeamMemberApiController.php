<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\JsonResponse;

class TeamMemberApiController extends Controller
{
    public function index(): JsonResponse
    {
        $members = TeamMember::active()
            ->orderBy('order')
            ->orderBy('name_uz')
            ->get()
            ->map(fn($m) => [
                'id'       => $m->id,
                'name'     => ['uz' => $m->name_uz,     'ru' => $m->name_ru,     'en' => $m->name_en],
                'position' => ['uz' => $m->position_uz, 'ru' => $m->position_ru, 'en' => $m->position_en],
                'bio'      => ['uz' => $m->bio_uz,      'ru' => $m->bio_ru,      'en' => $m->bio_en],
                'image'    => $m->image,
                'social'   => [
                    'facebook' => $m->facebook,
                    'twitter'  => $m->twitter,
                    'linkedin' => $m->linkedin,
                ],
                'order' => $m->order,
            ]);

        return response()->json([
            'success' => true,
            'result'  => ['data' => $members->values()->toArray()],
        ]);
    }
}
