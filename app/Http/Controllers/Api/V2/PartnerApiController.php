<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PartnerApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Partner::active()->orderBy('order')->orderBy('name_uz');

        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        $partners = $query->get()->map(fn($p) => [
            'id'          => $p->id,
            'name'        => ['uz' => $p->name_uz, 'ru' => $p->name_ru, 'en' => $p->name_en],
            'description' => ['uz' => $p->description_uz, 'ru' => $p->description_ru, 'en' => $p->description_en],
            'logo'        => $p->logo,
            'website'     => $p->website,
            'type'        => $p->type,
            'order'       => $p->order,
        ]);

        return response()->json([
            'success' => true,
            'result'  => ['data' => $partners->values()->toArray()],
        ]);
    }
}
