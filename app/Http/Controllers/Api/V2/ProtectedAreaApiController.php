<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\ProtectedArea;
use Illuminate\Http\JsonResponse;

class ProtectedAreaApiController extends Controller
{
    public function index(): JsonResponse
    {
        $areas = ProtectedArea::active()
            ->orderBy('order')
            ->orderBy('name_uz')
            ->get()
            ->map(fn($area) => [
                'id'    => $area->id,
                'slug'  => $area->slug,
                'name'  => [
                    'uz' => $area->name_uz,
                    'ru' => $area->name_ru,
                    'en' => $area->name_en,
                ],
                'count' => $area->count_text,
                'icon'  => $area->icon,
                'order' => $area->order,
            ]);

        return response()->json([
            'success' => true,
            'result'  => ['data' => $areas->values()->toArray()],
        ]);
    }
}
