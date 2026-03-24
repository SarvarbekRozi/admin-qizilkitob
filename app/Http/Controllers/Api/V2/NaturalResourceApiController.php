<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\NaturalResource;
use App\Models\ProtectedArea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NaturalResourceApiController extends Controller
{
    private function formatResource(NaturalResource $r): array
    {
        $mainImg = $r->image ? [
            'url'    => $r->image,
            'thumb'  => $r->image,
            'card'   => $r->image,
            'detail' => $r->image,
            'full'   => $r->image,
        ] : null;

        $gallery = [];
        if (!empty($r->image_gallery)) {
            $gallery = array_map(fn($img) => is_string($img) ? [
                'url' => $img, 'thumb' => $img, 'card' => $img, 'full' => $img,
            ] : $img, $r->image_gallery);
        }

        return [
            'id'       => (string) $r->id,
            'slug'     => $r->slug,
            'title'    => [
                'uz' => $r->title_uz ?? '',
                'ru' => $r->title_ru ?? '',
                'en' => $r->title_en ?? '',
            ],
            'excerpt'  => [
                'uz' => $r->excerpt_uz ?? '',
                'ru' => $r->excerpt_ru ?? '',
                'en' => $r->excerpt_en ?? '',
            ],
            'content'  => [
                'uz' => $r->content_uz ?? '',
                'ru' => $r->content_ru ?? '',
                'en' => $r->content_en ?? '',
            ],
            'image'    => $r->image,
            'category' => $r->category ?? '',
            'images'   => [
                'main'    => $mainImg,
                'gallery' => $gallery,
            ],
            'features' => [
                'uz' => $r->features_uz ?? [],
                'ru' => $r->features_ru ?? [],
                'en' => $r->features_en ?? [],
            ],
            'stats'    => [
                'area'      => $r->stat_area,
                'species'   => $r->stat_species,
                'protected' => $r->stat_protected,
            ],
            'coordinates' => ($r->latitude && $r->longitude) ? [
                'lat' => (float) $r->latitude,
                'lng' => (float) $r->longitude,
            ] : null,
            'viewsCount' => $r->views_count ?? 0,
            'featured'   => (bool) $r->featured,
        ];
    }

    public function index(Request $request): JsonResponse
    {
        $query = NaturalResource::active()->orderBy('title_uz');

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title_uz', 'ilike', "%{$search}%")
                  ->orWhere('title_ru', 'ilike', "%{$search}%")
                  ->orWhere('title_en', 'ilike', "%{$search}%");
            });
        }

        $perPage = min((int) $request->get('per_page', 12), 100);
        $paginated = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'result'  => [
                'data'       => array_map(fn($r) => $this->formatResource($r), $paginated->items()),
                'pagination' => [
                    'total'        => $paginated->total(),
                    'per_page'     => $paginated->perPage(),
                    'current_page' => $paginated->currentPage(),
                    'last_page'    => $paginated->lastPage(),
                    'from'         => $paginated->firstItem(),
                    'to'           => $paginated->lastItem(),
                ],
            ],
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $resource = NaturalResource::active()->where('slug', $slug)->firstOrFail();
        $resource->increment('views_count');

        return response()->json([
            'success' => true,
            'result'  => ['data' => $this->formatResource($resource)],
        ]);
    }

    public function featured(Request $request): JsonResponse
    {
        $limit = min((int) $request->get('limit', 6), 20);
        $resources = NaturalResource::active()->featured()->limit($limit)->get();

        return response()->json([
            'success' => true,
            'result'  => ['data' => $resources->map(fn($r) => $this->formatResource($r))->values()->toArray()],
        ]);
    }

    public function latest(Request $request): JsonResponse
    {
        $limit = min((int) $request->get('limit', 6), 20);
        $resources = NaturalResource::active()
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'result'  => ['data' => $resources->map(fn($r) => $this->formatResource($r))->values()->toArray()],
        ]);
    }

    public function categories(): JsonResponse
    {
        $categories = ProtectedArea::active()
            ->orderBy('order')
            ->get()
            ->map(fn($area) => [
                'slug' => $area->slug,
                'name' => [
                    'uz' => $area->name_uz,
                    'ru' => $area->name_ru,
                    'en' => $area->name_en,
                ],
                'icon'  => $area->icon,
                'count' => $area->count_text,
            ]);

        return response()->json([
            'success' => true,
            'result'  => ['data' => $categories->values()->toArray()],
        ]);
    }
}
