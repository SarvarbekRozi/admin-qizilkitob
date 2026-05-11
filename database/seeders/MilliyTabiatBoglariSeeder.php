<?php

namespace Database\Seeders;

use App\Models\NaturalResource;
use App\Models\ProtectedArea;
use Database\Seeders\NationalParks\BobotogSeeder;
use Database\Seeders\NationalParks\JanubiyUstyurtSeeder;
use Database\Seeders\NationalParks\MarkaziyQizilqumSeeder;
use Database\Seeders\NationalParks\OmonqotonSeeder;
use Database\Seeders\NationalParks\OrolbuyiSeeder;
use Database\Seeders\NationalParks\OrolqumSeeder;
use Database\Seeders\NationalParks\PopSeeder;
use Database\Seeders\NationalParks\UgomChotqolSeeder;
use Database\Seeders\NationalParks\XorazmSeeder;
use Database\Seeders\NationalParks\YuqoriTopalangSeeder;
use Database\Seeders\NationalParks\ZarafshonSeeder;
use Database\Seeders\NationalParks\ZominSeeder;
use Illuminate\Database\Seeder;

/**
 * "Milliy tabiat bog'lari" kategoriyasi uchun barcha post seederlari.
 * Har bir park alohida faylda — database/seeders/NationalParks/ kataloginda.
 */
class MilliyTabiatBoglariSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ZominSeeder::class,
            UgomChotqolSeeder::class,
            ZarafshonSeeder::class,
            XorazmSeeder::class,
            JanubiyUstyurtSeeder::class,
            MarkaziyQizilqumSeeder::class,
            OrolqumSeeder::class,
            PopSeeder::class,
            OmonqotonSeeder::class,
            YuqoriTopalangSeeder::class,
            BobotogSeeder::class,
            OrolbuyiSeeder::class,
        ]);

        // Update count_text on ProtectedArea
        $count = NaturalResource::where('category', 'milliy-tabiat-boglari')->count();
        ProtectedArea::where('slug', 'milliy-tabiat-boglari')->update([
            'count_text' => $count . ' ta',
        ]);
    }
}
