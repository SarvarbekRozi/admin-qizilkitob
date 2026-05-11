<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\Species;
use App\Models\SpeciesFamily;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SpeciesApiController extends Controller
{
    private function formatSpecies(Species $s): array
    {
        return [
            'id'               => (string) $s->id,
            'slug'             => $s->slug,
            'category'         => $s->category,
            'dangerLevel'      => $s->danger_level,
            'name'             => [
                'uz' => $s->name_uz ?? '',
                'ru' => $s->name_ru ?? '',
                'en' => $s->name_en ?? '',
            ],
            'scientificName'   => $s->scientific_name ?? '',
            'description'      => [
                'uz' => [
                    'short'   => $s->description_short_uz ?? '',
                    'full'    => $s->description_full_uz ?? '',
                    'bullets' => $s->description_bullets_uz ?? [],
                ],
                'ru' => [
                    'short'   => $s->description_short_ru ?? '',
                    'full'    => $s->description_full_ru ?? '',
                    'bullets' => $s->description_bullets_ru ?? [],
                ],
                'en' => [
                    'short'   => $s->description_short_en ?? '',
                    'full'    => $s->description_full_en ?? '',
                    'bullets' => $s->description_bullets_en ?? [],
                ],
            ],
            'images'           => [
                'main'    => $s->image_main,
                'gallery' => $s->image_gallery ?? [],
            ],
            'stats'            => [
                'mass'        => $s->stat_mass,
                'speed'       => $s->stat_speed,
                'lifespan'    => $s->stat_lifespan,
                'diet'        => $s->stat_diet,
                'height'      => $s->stat_height,
                'bloomPeriod' => $s->stat_bloom_period,
                'habitat'     => $s->stat_habitat,
            ],
            'habitat'          => [
                'location'    => [
                    'uz' => $s->habitat_location_uz ?? '',
                    'ru' => $s->habitat_location_ru ?? '',
                    'en' => $s->habitat_location_en ?? '',
                ],
                'coordinates' => [
                    'lat' => (float) ($s->latitude ?? 0),
                    'lng' => (float) ($s->longitude ?? 0),
                ],
            ],
            'conservationStatus' => [
                'level'      => $s->conservation_level ?? '',
                'population' => $s->conservation_population ?? '',
                'threats'    => [
                    'uz' => $s->threats_uz ?? [],
                    'ru' => $s->threats_ru ?? [],
                    'en' => $s->threats_en ?? [],
                ],
            ],
            'relatedSpecies'   => $s->related_species ?? [],
            'viewsCount'       => $s->views_count ?? 0,
            'featured'         => (bool) $s->featured,
            'family'           => $s->family ? [
                'id'         => $s->family->id,
                'slug'       => $s->family->slug,
                'name'       => [
                    'uz' => $s->family->name_uz,
                    'ru' => $s->family->name_ru,
                    'en' => $s->family->name_en,
                ],
                'latinName'  => $s->family->latin_name,
            ] : null,
        ];
    }

    public function index(Request $request): JsonResponse
    {
        $query = Species::active()->with('family')->orderBy('name_uz');

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('family')) {
            $query->byFamily($request->family);
        }

        if ($request->filled('danger_level')) {
            $query->byDangerLevel($request->danger_level);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name_uz', 'ilike', "%{$search}%")
                  ->orWhere('name_ru', 'ilike', "%{$search}%")
                  ->orWhere('name_en', 'ilike', "%{$search}%")
                  ->orWhere('scientific_name', 'ilike', "%{$search}%");
            });
        }

        $perPage = min((int) $request->get('per_page', 12), 100);
        $paginated = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'result'  => [
                'data'       => array_map(fn($s) => $this->formatSpecies($s), $paginated->items()),
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
        $species = Species::active()->with('family')->where('slug', $slug)->firstOrFail();
        $species->increment('views_count');

        $related = [];
        if (!empty($species->related_species)) {
            $related = Species::active()
                ->whereIn('slug', $species->related_species)
                ->get()
                ->map(fn($s) => $this->formatSpecies($s))
                ->values()
                ->toArray();
        }

        return response()->json([
            'success' => true,
            'result'  => [
                'data'    => $this->formatSpecies($species),
                'related' => $related,
            ],
        ]);
    }

    public function featured(Request $request): JsonResponse
    {
        $limit = min((int) $request->get('limit', 6), 20);
        $species = Species::active()->featured()->limit($limit)->get();

        return response()->json([
            'success' => true,
            'result'  => ['data' => $species->map(fn($s) => $this->formatSpecies($s))->values()->toArray()],
        ]);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'result'  => ['data' => [
                'total'                 => Species::active()->count(),
                'animals'               => Species::active()->byCategory('animal')->count(),
                'plants'                => Species::active()->byCategory('plant')->count(),
                'critically_endangered' => Species::active()->byDangerLevel('critically_endangered')->count(),
                'endangered'            => Species::active()->byDangerLevel('endangered')->count(),
                'vulnerable'            => Species::active()->byDangerLevel('vulnerable')->count(),
                'near_threatened'       => Species::active()->byDangerLevel('near_threatened')->count(),
            ]],
        ]);
    }

    public function map(): JsonResponse
    {
        $species = Species::active()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return response()->json([
            'success' => true,
            'result'  => ['data' => $species->map(fn($s) => [
                'id'           => (string) $s->id,
                'slug'         => $s->slug,
                'name'         => ['uz' => $s->name_uz, 'ru' => $s->name_ru, 'en' => $s->name_en],
                'scientificName' => $s->scientific_name,
                'category'     => $s->category,
                'dangerLevel'  => $s->danger_level,
                'images'       => ['main' => $s->image_main],
                'habitat'      => [
                    'location'    => ['uz' => $s->habitat_location_uz, 'ru' => $s->habitat_location_ru, 'en' => $s->habitat_location_en],
                    'coordinates' => ['lat' => (float) $s->latitude, 'lng' => (float) $s->longitude],
                ],
            ])->values()->toArray()],
        ]);
    }

    public function families(Request $request): JsonResponse
    {
        $query = SpeciesFamily::active()
            ->withCount(['species' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('sort');

        if ($request->filled('category') && in_array($request->category, ['animal', 'plant'], true)) {
            $query->where('category', $request->category);
        }

        $families = $query->get()->map(fn ($f) => [
            'id'           => $f->id,
            'slug'         => $f->slug,
            'category'     => $f->category,
            'name'         => [
                'uz' => $f->name_uz,
                'ru' => $f->name_ru,
                'en' => $f->name_en,
            ],
            'latinName'    => $f->latin_name,
            'speciesCount' => $f->species_count,
        ])->values()->toArray();

        return response()->json([
            'success' => true,
            'result'  => ['data' => $families],
        ]);
    }

    public function gallery(Request $request): JsonResponse
    {
        $perPage = min((int) $request->get('per_page', 20), 100);

        $query = Species::active()->whereNotNull('image_main')->orderBy('name_uz');

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        $paginated = $query->paginate($perPage);

        $gallery = $paginated->getCollection()->map(function ($s) {
            $images = [$s->image_main];
            if (!empty($s->image_gallery)) {
                $images = array_merge($images, $s->image_gallery);
            }
            return [
                'id'           => (string) $s->id,
                'slug'         => $s->slug,
                'name'         => ['uz' => $s->name_uz, 'ru' => $s->name_ru, 'en' => $s->name_en],
                'category'     => $s->category,
                'dangerLevel'  => $s->danger_level,
                'images'       => $images,
            ];
        });

        return response()->json([
            'success' => true,
            'result'  => [
                'data'       => $gallery->values()->toArray(),
                'pagination' => [
                    'total'        => $paginated->total(),
                    'per_page'     => $paginated->perPage(),
                    'current_page' => $paginated->currentPage(),
                    'last_page'    => $paginated->lastPage(),
                ],
            ],
        ]);
    }
}
