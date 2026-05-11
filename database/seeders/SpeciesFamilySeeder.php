<?php

namespace Database\Seeders;

use App\Models\SpeciesFamily;
use Illuminate\Database\Seeder;

class SpeciesFamilySeeder extends Seeder
{
    public function run(): void
    {
        // Hayvonlar (5 ta sinf)
        $animals = [
            ['umurtqasizlar',     'UMURTQASIZLAR',         'БЕСПОЗВОНОЧНЫЕ',          'INVERTEBRATES', 'Invertebrata'],
            ['baliqlar',          'BALIQLAR',              'РЫБЫ',                    'FISHES',        'Pisces'],
            ['sudralib-yuruvchilar', 'SUDRALIB YURUVCHILAR', 'ПРЕСМЫКАЮЩИЕСЯ',       'REPTILES',      'Reptilia'],
            ['qushlar',           'QUSHLAR',               'ПТИЦЫ',                   'BIRDS',         'Aves'],
            ['sutemizuvchilar',   'SUTEMIZUVCHILAR',       'МЛЕКОПИТАЮЩИЕ',           'MAMMALS',       'Mammalia'],
        ];

        foreach ($animals as $i => [$slug, $uz, $ru, $en, $latin]) {
            SpeciesFamily::updateOrCreate(
                ['slug' => $slug],
                [
                    'category'   => 'animal',
                    'name_uz'    => $uz,
                    'name_ru'    => $ru,
                    'name_en'    => $en,
                    'latin_name' => $latin,
                    'sort'       => ($i + 1) * 10,
                    'is_active'  => true,
                ]
            );
        }

        // O'simliklar (47 ta oila) — alifbo tartibida
        $plants = [
            ['ranunculaceae',                "AYIQTOVONDOSHLAR OILASI",                                  "СЕМЕЙСТВО ЛЮТИКОВЫЕ",                                    'RANUNCULACEAE'],
            ['punicaceae',                   "ANORDOSHLAR OILASI",                                       "СЕМЕЙСТВО ГРАНАТОВЫЕ",                                   'PUNICACEAE'],
            ['bignoniaceae',                 "BIGNONIYADOSHLAR OILASI",                                  "СЕМЕЙСТВО БИГНОНИЕВЫЕ",                                  'BIGNONIACEAE'],
            ['fabaceae',                     "BURCHOQDOSHLAR OILASI",                                    "СЕМЕЙСТВО МОТЫЛЬКОВЫЕ (БОБОВЫЕ)",                        'FABACEAE (LEGUMINOSAE)'],
            ['poaceae',                      "BUG'DOYDOSHLAR OILASI",                                    "СЕМЕЙСТВО МЯТЛИКОВЫЕ (ЗЛАКОВЫЕ)",                        'POACEAE (GRAMINEA)'],
            ['hyacinthaceae',                "GIATSINTDOSHLAR OILASI",                                   "СЕМЕЙСТВО ГИАЦИНТОВЫЕ (ЛИЛЕЙНЫЕ)",                       'HYACINTHACEAE (LILIACEAE)'],
            ['boraginaceae',                 "G'OVZABONDOSHLAR OILASI",                                  "СЕМЕЙСТВО БУРАЧНИКОВЫЕ",                                 'BORAGINACEAE'],
            ['iridaceae',                    "GULSAFSARDOSHLAR OILASI",                                  "СЕМЕЙСТВО ИРИСОВЫЕ",                                     'IRIDACEAE'],
            ['peganaceae',                   "ISIRIQDOSHLAR OILASI",                                     "СЕМЕЙСТВО МОГИЛЬНИКОВЫЕ (ПАРНОЛИСТНИКОВЫЕ)",             'PEGANACEAE (ZYGOPHYLLACEAE)'],
            ['solanaceae',                   "ITUZUMDOSHLAR OILASI",                                     "СЕМЕЙСТВО ПАСЛЕНОВЫЕ",                                   'SOLANACEAE'],
            ['brassicaceae',                 "KARAMDOSHLAR OILASI",                                      "СЕМЕЙСТВО КАПУСТНЫЕ (КРЕСТОЦВЕТНЫЕ)",                    'BRASSICACEAE (CRUCIFERAE)'],
            ['limoniaceae',                  "KARMAKDOSHLAR OILASI",                                     "СЕМЕЙСТВО КЕРМЕКОВЫЕ",                                   'LIMONIACEAE (PLUMBAGINACEAE)'],
            ['thymelaeaceae',                "KELINSUPURGIDOSHLAR OILASI",                               "СЕМЕЙСТВО ТИМЕЛЕЕВЫЕ",                                   'THYMELAEACEAE'],
            ['capparaceae',                  "KOVULDOSHLAR OILASI",                                      "СЕМЕЙСТВО КАПЕРЦЕВЫЕ",                                   'CAPPARACEAE'],
            ['liliaceae',                    "LOLADOSHLAR OILASI",                                       "СЕМЕЙСТВО ЛИЛЕЙНЫЕ",                                     'LILIACEAE'],
            ['primulaceae',                  "NAVRO'ZGULDOSHLAR OILASI",                                 "СЕМЕЙСТВО ПЕРВОЦВЕТНЫЕ",                                 'PRIMULACEAE'],
            ['anacardiaceae',                "PISTADOSHLAR OILASI",                                      "СЕМЕЙСТВО СУМАХОВЫЕ",                                    'ANACARDIACEAE'],
            ['rosaceae',                     "RA'NOGULDOSHLAR OILASI",                                   "СЕМЕЙСТВО РОЗОЦВЕТНЫЕ",                                  'ROSACEAE'],
            ['rubiaceae',                    "RO'YANDOSHLAR OILASI",                                     "СЕМЕЙСТВО МАРЕНОВЫЕ",                                    'RUBIACEAE'],
            ['colchicaceae',                 "SAVRINJONDOSHLAR OILASI",                                  "СЕМЕЙСТВО БЕЗВРЕМЕННИКОВЫЕ (МЕЛАНТОВЫЕ)",                'COLCHICACEAE (MELANTHIACEAE)'],
            ['orchidaceae',                  "SALIBDOSHLAR OILASI",                                      "СЕМЕЙСТВО ОРХИДНЫЕ",                                     'ORCHIDACEAE'],
            ['paeonaceae',                   "SALLAGULDOSHLAR OILASI",                                   "СЕМЕЙСТВО ПИОНОВЫЕ (ЛЮТИКОВЫЕ)",                         'PAEONACEAE (RANUNCULACEAE)'],
            ['santalaceae',                  "SANTALDOSHLAR OILASI",                                     "СЕМЕЙСТВО САНТАЛОВЫЕ",                                   'SANTALACEAE'],
            ['crassulaceae',                 "SEMIZDOSHLAR OILASI",                                      "СЕМЕЙСТВО ТОЛСТЯНКОВЫЕ",                                 'CRASSULACEAE'],
            ['scrophulariaceae',             "SIGIRQUYRUQDOSHLAR OILASI",                                "СЕМЕЙСТВО НОРИЧНИКОВЫЕ",                                 'SCROPHULARIACEAE'],
            ['euphorbiaceae',                "SUTLAMADOSHLAR OILASI",                                    "СЕМЕЙСТВО МОЛОЧАЙНЫЕ",                                   'EUPHORBIACEAE'],
            ['aspleniaceae',                 "TALOQDORIDOSHLAR OILASI",                                  "СЕМЕЙСТВО НАСТОЯЩИЕ ПАПОРОТНИКИ",                        'ASPLENIACEAE'],
            ['polygonaceae',                 "TORONDOSHLAR OILASI",                                      "СЕМЕЙСТВО ГРЕЧИШНЫЕ",                                    'POLYGONACEAE'],
            ['rutaceae',                     "TOSHBAQATOLDOSHLAR OILASI",                                "СЕМЕЙСТВО РУТОВЫЕ",                                      'RUTACEAE'],
            ['saxifragaceae',                "TOSHYORARDOSHLAR OILASI",                                  "СЕМЕЙСТВО ТОЛСТЯНКОВЫЕ",                                 'SAXIFRAGACEAE'],
            ['zygophyllaceae',               "TUYATOVONDOSHLAR OILASI",                                  "СЕМЕЙСТВО ПАРНОЛИСТНИКОВЫЕ",                             'ZYGOPHYLLACEAE'],
            ['vitaceae',                     "UZUMDOSHLAR OILASI",                                       "СЕМЕЙСТВО ВИНОГРАДНЫЕ",                                  'VITACEAE'],
            ['ebenaceae',                    "XURMODOSHLAR OILASI",                                      "СЕМЕЙСТВО ЭБЕНОВЫЕ",                                     'EBENACEAE'],
            ['rhamnaceae',                   "CHILONJIYDADOSHLAR OILASI",                                "СЕМЕЙСТВО КРУШИНОВЫЕ",                                   'RHAMNACEAE'],
            ['caryophyllaceae',              "CHINNIGULDOSHLAR OILASI",                                  "СЕМЕЙСТВО ГВОЗДИЧНЫЕ",                                   'CARYOPHYLLACEAE'],
            ['platanaceae',                  "CHINORDOSHLAR OILASI",                                     "СЕМЕЙСТВО ПЛАТАНОВЫЕ",                                   'PLATANACEAE'],
            ['amaryllidaceae',               "CHUCHMOMADOSHLAR OILASI",                                  "СЕМЕЙСТВО АМАРИЛЛИСОВЫЕ",                                'AMARYLLIDACEAE'],
            ['caprifoliaceae',               "SHILVIDOSHLAR OILASI",                                     "СЕМЕЙСТВО ЖИМОЛОСТНЫЕ",                                  'CAPRIFOLIACEAE'],
            ['xanthorrhoeaceae',             "SHIRACHDOSHLAR OILASI",                                    "СЕМЕЙСТВО КСАНОТОРОЕВЫЕ",                                'XANTHORRHOEACEAE'],
            ['fumariaceae',                  "SHOTARADOSHLAR OILASI",                                    "СЕМЕЙСТВО ДЫМЯНКОВЫЕ",                                   'FUMARIACEAE'],
            ['chenopodiaceae',               "SHO'RADOSHLAR OILASI",                                     "СЕМЕЙСТВО МАРЕВЫЕ",                                      'CHENOPODIACEAE'],
            ['lamiaceae',                    "YALPIZDOSHLAR (LABGULDOSHLAR) OILASI",                     "СЕМЕЙСТВО ЯСНОТКОВЫЕ (ГУБОЦВЕТНЫЕ)",                     'LAMIACEAE (LABIATAE)'],
            ['cucurbitaceae',                "QOVOQDOSHLAR OILASI",                                      "СЕМЕЙСТВО ТЫКВЕННЫЕ",                                    'CUCURBITACEAE'],
            ['grossulariaceae',              "QORAG'ATDOSHLAR (TOSHYORDOSHLAR) OILASI",                  "СЕМЕЙСТВО СМОРОДИНОВЫЕ (КАМНЕЛОМКОВЫЕ)",                 'GROSSULARIACEAE (SAXIFRAGACEAE)'],
            ['asteraceae',                   "QOQIO'TDOSHLAR (MURAKKABGULDOSHLAR) OILASI",               "СЕМЕЙСТВО АСТРОВЫЕ (СЛОЖНОЦВЕТНЫЕ)",                     'ASTERACEAE (COMPOSITAE)'],
            ['campanulaceae',                "QO'NG'IROQGULDOSHLAR OILASI",                              "СЕМЕЙСТВО КОЛОКОЛЬЧИКОВЫЕ",                              'CAMPANULACEAE'],
            ['cynomoriaceae',                "QUMSO'TADOSHLAR OILASI",                                   "СЕМЕЙСТВО ЦИНОМОРИЕВЫЕ",                                 'CYNOMORIACEAE'],
        ];

        foreach ($plants as $i => [$slug, $uz, $ru, $latin]) {
            SpeciesFamily::updateOrCreate(
                ['slug' => $slug],
                [
                    'category'   => 'plant',
                    'name_uz'    => $uz,
                    'name_ru'    => $ru,
                    'name_en'    => $latin,
                    'latin_name' => $latin,
                    'sort'       => ($i + 1) * 10,
                    'is_active'  => true,
                ]
            );
        }
    }
}
