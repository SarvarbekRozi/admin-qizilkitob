<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\SiteStat;
use Illuminate\Http\JsonResponse;

class SiteStatApiController extends Controller
{
    public function index(): JsonResponse
    {
        $stats = SiteStat::active()
            ->orderBy('order')
            ->get()
            ->map(fn($stat) => [
                'id'     => $stat->id,
                'key'    => $stat->key,
                'value'  => $stat->value,
                'suffix' => $stat->suffix,
                'label'  => [
                    'uz' => $stat->label_uz,
                    'ru' => $stat->label_ru,
                    'en' => $stat->label_en,
                ],
                'icon'   => $stat->icon,
                'order'  => $stat->order,
            ]);

        return response()->json([
            'success' => true,
            'result'  => ['data' => $stats->values()->toArray()],
        ]);
    }
}
