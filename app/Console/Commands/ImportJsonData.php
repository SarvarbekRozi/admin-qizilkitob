<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use App\Models\NaturalResource;
use App\Models\Species;
use Illuminate\Console\Command;

class ImportJsonData extends Command
{
    protected $signature   = 'import:json {--path= : Path to Nuxt project data folder}';
    protected $description = 'Import data from Nuxt static JSON files into database';

    private string $dataPath;

    public function handle(): void
    {
        $this->dataPath = $this->option('path')
            ?: 'D:/loyiha/qizilkitob/data';

        $this->info("Data path: {$this->dataPath}");

        $this->importSpecies();
        $this->importBlog();
        $this->importNaturalResources();

        $this->info('✅ Import completed!');
    }

    private function importSpecies(): void
    {
        $this->info('Importing species...');
        $count = 0;

        foreach (['animals', 'plants'] as $file) {
            $path = "{$this->dataPath}/species/{$file}.json";
            if (!file_exists($path)) {
                $this->warn("File not found: {$path}");
                continue;
            }

            $json = json_decode(file_get_contents($path), true);
            $items = $json[$file] ?? [];

            foreach ($items as $item) {
                if (Species::where('slug', $item['slug'])->exists()) continue;

                Species::create([
                    'slug'                    => $item['slug'],
                    'category'                => $item['category'],
                    'danger_level'            => $item['dangerLevel'] ?? 'vulnerable',
                    'name_uz'                 => $item['name']['uz'] ?? '',
                    'name_ru'                 => $item['name']['ru'] ?? '',
                    'name_en'                 => $item['name']['en'] ?? '',
                    'scientific_name'         => $item['scientificName'] ?? '',
                    'description_short_uz'    => $item['description']['uz']['short'] ?? '',
                    'description_short_ru'    => $item['description']['ru']['short'] ?? '',
                    'description_short_en'    => $item['description']['en']['short'] ?? '',
                    'description_full_uz'     => $item['description']['uz']['full'] ?? '',
                    'description_full_ru'     => $item['description']['ru']['full'] ?? '',
                    'description_full_en'     => $item['description']['en']['full'] ?? '',
                    'description_bullets_uz'  => $item['description']['uz']['bullets'] ?? [],
                    'description_bullets_ru'  => $item['description']['ru']['bullets'] ?? [],
                    'description_bullets_en'  => $item['description']['en']['bullets'] ?? [],
                    'image_main'              => $item['images']['main'] ?? null,
                    'image_gallery'           => $item['images']['gallery'] ?? [],
                    'stat_mass'               => $item['stats']['mass'] ?? null,
                    'stat_speed'              => $item['stats']['speed'] ?? null,
                    'stat_lifespan'           => $item['stats']['lifespan'] ?? null,
                    'stat_diet'               => $item['stats']['diet'] ?? null,
                    'stat_height'             => $item['stats']['height'] ?? null,
                    'stat_bloom_period'       => $item['stats']['bloomPeriod'] ?? null,
                    'stat_habitat'            => $item['stats']['habitat'] ?? null,
                    'habitat_location_uz'     => $item['habitat']['location']['uz'] ?? '',
                    'habitat_location_ru'     => $item['habitat']['location']['ru'] ?? '',
                    'habitat_location_en'     => $item['habitat']['location']['en'] ?? '',
                    'latitude'                => $item['habitat']['coordinates']['lat'] ?? null,
                    'longitude'               => $item['habitat']['coordinates']['lng'] ?? null,
                    'conservation_level'      => $item['conservationStatus']['level'] ?? '',
                    'conservation_population' => $item['conservationStatus']['population'] ?? '',
                    'threats_uz'              => $item['conservationStatus']['threats']['uz'] ?? [],
                    'threats_ru'              => $item['conservationStatus']['threats']['ru'] ?? [],
                    'threats_en'              => $item['conservationStatus']['threats']['en'] ?? [],
                    'related_species'         => $item['relatedSpecies'] ?? [],
                    'views_count'             => $item['viewsCount'] ?? 0,
                    'featured'                => $item['featured'] ?? false,
                    'is_active'               => true,
                ]);
                $count++;
            }
        }

        $this->info("  → {$count} species imported");
    }

    private function importBlog(): void
    {
        $this->info('Importing blog posts...');

        $path = "{$this->dataPath}/blog.json";
        if (!file_exists($path)) {
            $this->warn("File not found: {$path}");
            return;
        }

        $json  = json_decode(file_get_contents($path), true);
        $posts = $json['posts'] ?? [];
        $count = 0;

        foreach ($posts as $item) {
            if (BlogPost::where('slug', $item['slug'])->exists()) continue;

            $titleUz = is_array($item['title'] ?? null) ? ($item['title']['uz'] ?? '') : ($item['title'] ?? '');
            $titleRu = is_array($item['title'] ?? null) ? ($item['title']['ru'] ?? $titleUz) : $titleUz;
            $titleEn = is_array($item['title'] ?? null) ? ($item['title']['en'] ?? $titleUz) : $titleUz;

            $excerptUz = is_array($item['excerpt'] ?? null) ? ($item['excerpt']['uz'] ?? '') : ($item['excerpt'] ?? '');
            $excerptRu = is_array($item['excerpt'] ?? null) ? ($item['excerpt']['ru'] ?? $excerptUz) : $excerptUz;
            $excerptEn = is_array($item['excerpt'] ?? null) ? ($item['excerpt']['en'] ?? $excerptUz) : $excerptUz;

            $contentUz = is_array($item['content'] ?? null) ? ($item['content']['uz'] ?? '') : ($item['content'] ?? '');
            $contentRu = is_array($item['content'] ?? null) ? ($item['content']['ru'] ?? $contentUz) : $contentUz;
            $contentEn = is_array($item['content'] ?? null) ? ($item['content']['en'] ?? $contentUz) : $contentUz;

            BlogPost::create([
                'slug'         => $item['slug'],
                'title_uz'     => $titleUz,
                'title_ru'     => $titleRu,
                'title_en'     => $titleEn,
                'excerpt_uz'   => $excerptUz,
                'excerpt_ru'   => $excerptRu,
                'excerpt_en'   => $excerptEn,
                'content_uz'   => $contentUz,
                'content_ru'   => $contentRu,
                'content_en'   => $contentEn,
                'image'        => $item['image'] ?? null,
                'author'       => $item['author'] ?? '',
                'video'        => $item['video'] ?? null,
                'audio'        => $item['audio'] ?? null,
                'views_count'  => $item['viewsCount'] ?? 0,
                'is_active'    => true,
                'publish_date' => $item['publishDate'] ?? now(),
            ]);
            $count++;
        }

        $this->info("  → {$count} blog posts imported");
    }

    private function importNaturalResources(): void
    {
        $this->info('Importing natural resources...');

        $path = "{$this->dataPath}/natural-resources.json";
        if (!file_exists($path)) {
            $this->warn("File not found: {$path}");
            return;
        }

        $json      = json_decode(file_get_contents($path), true);
        $resources = $json['resources'] ?? [];
        $count     = 0;

        foreach ($resources as $item) {
            if (NaturalResource::where('slug', $item['slug'])->exists()) continue;

            $titleUz = is_array($item['title'] ?? null) ? ($item['title']['uz'] ?? '') : ($item['title'] ?? '');
            $titleRu = is_array($item['title'] ?? null) ? ($item['title']['ru'] ?? $titleUz) : $titleUz;
            $titleEn = is_array($item['title'] ?? null) ? ($item['title']['en'] ?? $titleUz) : $titleUz;

            $excerptUz = is_array($item['excerpt'] ?? null) ? ($item['excerpt']['uz'] ?? '') : ($item['excerpt'] ?? '');
            $excerptRu = is_array($item['excerpt'] ?? null) ? ($item['excerpt']['ru'] ?? $excerptUz) : $excerptUz;
            $excerptEn = is_array($item['excerpt'] ?? null) ? ($item['excerpt']['en'] ?? $excerptUz) : $excerptUz;

            $contentUz = is_array($item['content'] ?? null) ? ($item['content']['uz'] ?? '') : ($item['content'] ?? '');
            $contentRu = is_array($item['content'] ?? null) ? ($item['content']['ru'] ?? $contentUz) : $contentUz;
            $contentEn = is_array($item['content'] ?? null) ? ($item['content']['en'] ?? $contentUz) : $contentUz;

            $features = $item['features'] ?? [];
            if (is_array($features) && !empty($features) && !isset($features['uz'])) {
                // flat array — same for all langs
                $featuresUz = $features;
                $featuresRu = $features;
                $featuresEn = $features;
            } else {
                $featuresUz = $features['uz'] ?? [];
                $featuresRu = $features['ru'] ?? [];
                $featuresEn = $features['en'] ?? [];
            }

            NaturalResource::create([
                'slug'           => $item['slug'],
                'title_uz'       => $titleUz,
                'title_ru'       => $titleRu,
                'title_en'       => $titleEn,
                'excerpt_uz'     => $excerptUz,
                'excerpt_ru'     => $excerptRu,
                'excerpt_en'     => $excerptEn,
                'content_uz'     => $contentUz,
                'content_ru'     => $contentRu,
                'content_en'     => $contentEn,
                'image'          => $item['image'] ?? null,
                'category'       => $item['category'] ?? '',
                'features_uz'    => $featuresUz,
                'features_ru'    => $featuresRu,
                'features_en'    => $featuresEn,
                'stat_area'      => $item['stats']['area'] ?? null,
                'stat_species'   => $item['stats']['species'] ?? null,
                'stat_protected' => $item['stats']['protected'] ?? null,
                'latitude'       => $item['coordinates']['lat'] ?? null,
                'longitude'      => $item['coordinates']['lng'] ?? null,
                'views_count'    => $item['viewsCount'] ?? 0,
                'featured'       => $item['featured'] ?? false,
                'is_active'      => true,
            ]);
            $count++;
        }

        $this->info("  → {$count} natural resources imported");
    }
}
