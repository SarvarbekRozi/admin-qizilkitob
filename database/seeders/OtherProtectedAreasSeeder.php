<?php

namespace Database\Seeders;

use App\Models\NaturalResource;
use Illuminate\Database\Seeder;

/**
 * Davlat qo'riqxonalari oilasiga kirmaydigan boshqa kategoriyalar:
 *  - Majmua (landshaft) buyurtma qo'riqxonasi (Saygachiy)
 *  - Maxsus jayron pitomnigi (Buxoro)
 *  - Biosfera rezervatlari (Quyi Amudaryo)
 */
class OtherProtectedAreasSeeder extends Seeder
{
    private function paragraphs(string $text): string
    {
        $text = trim($text);
        $blocks = preg_split('/\n\s*\n/', $text);

        return implode("\n", array_map(function (string $block) {
            return '<p>' . nl2br(htmlspecialchars(trim($block), ENT_QUOTES | ENT_HTML5, 'UTF-8'), false) . '</p>';
        }, $blocks));
    }

    public function run(): void
    {
        foreach ($this->resources() as $data) {
            // Mavjud yozuvda local /uploads/... rasmi bo'lsa, uni Unsplash placeholder bilan almashtirmaymiz.
            $existing = NaturalResource::where('slug', $data['slug'])->first();
            if ($existing && $existing->image && str_starts_with($existing->image, '/uploads/')) {
                $data['image'] = $existing->image;
            }

            $payload = [
                'category'       => $data['category'],
                'title_uz'       => $data['title_uz'],
                'title_ru'       => $data['title_ru'],
                'title_en'       => $data['title_en'],
                'excerpt_uz'     => $data['excerpt_uz'],
                'excerpt_ru'     => $data['excerpt_ru'],
                'excerpt_en'     => $data['excerpt_en'],
                'content_uz'     => $this->paragraphs($data['content_uz']),
                'content_ru'     => $this->paragraphs($data['content_ru']),
                'content_en'     => $this->paragraphs($data['content_en']),
                'features_uz'    => $data['features_uz'],
                'features_ru'    => $data['features_ru'],
                'features_en'    => $data['features_en'],
                'stat_area'      => $data['stat_area'],
                'stat_species'   => $data['stat_species'],
                'stat_protected' => $data['stat_protected'],
                'latitude'       => $data['latitude'],
                'longitude'      => $data['longitude'],
                'image'          => $data['image'],
                'image_gallery'  => $data['image_gallery'] ?? [],
                'is_active'      => true,
                'featured'       => $data['featured'] ?? false,
            ];

            NaturalResource::updateOrCreate(['slug' => $data['slug']], $payload);
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function resources(): array
    {
        return [
            // 1. SAYGACHIY (Majmua landshaft buyurtma qo'riqxonasi)
            [
                'slug'     => 'saygachiy-majmua-landshaft-buyurtma-qoriqxonasi',
                'category' => 'majmua-buyurtma-qoriqxonasi',
                'title_uz' => '"Saygachiy" majmua (landshaft) buyurtma qo\'riqxonasi',
                'title_ru' => 'Комплексный ландшафтный заказник "Сайгачий"',
                'title_en' => 'The Complex Landscape Reserve "Saigachiy"',
                'excerpt_uz' => "Ustyurt platosining noyob biologik xilma-xilligini muhofaza qiluvchi qo'riqxona. Umumiy maydoni 628 300 ga, qo'riqlanma zonasi 219 800 ga. Sayg'oq, jayron, qulon va boshqa noyob turlar yashaydi.",
                'excerpt_ru' => 'Заказник, охраняющий уникальное биологическое разнообразие Устюртского плато. Общая площадь 628 300 га, охранная зона 219 800 га. Здесь обитают сайгаки, джейраны, куланы и другие редкие виды.',
                'excerpt_en' => 'Reserve protecting the unique biodiversity of the Ustyurt Plateau. Total area 628,300 ha, protected zone 219,800 ha. Home to saigas, gazelles, kulans and other rare species.',
                'content_uz' => <<<'UZ'
Ustyurt (platosining) tekisligining noyob biologik xilma-xilligini ishonchli muhofaza qilish maqsadida Saygachiy majmua (landshaft) buyurtma qo'riqxonasi tashkil qilingan bo'lib umumiy yer maydoni 628 300 ga, shundan qo'riqlanma zona hududi 219 800 ga.

Joylashgan o'rni: O'zbekiston Respublikasining Qozog'iston Respublikasi bilan chegaradosh hududlaridagi Ustyurt tekisliklarida joylashgan.

Asosiy ish faoliyati: O'z hududidagi barcha tabiiy obyektlar va majmualarni asl tabiiy holatda saqlash, tabiiy atrof muhitni ilmiy tadqiq etish va monitoring olib borish, ekologiya va atrof muhitni muhofaza qilish sohasida ilmiy kadrlar va mutaxassislar tayyorlashga ko'maklashish, biologik va landshaft xilma-xilligini ta'minlash, ekologik muvozanatni saqlab turish.

Tabiiy sharoiti: Qo'riqxonaning yer maydonlari asosan qurg'oqchil iqlimga ega bo'lgan Ustyurt tekisliklarida joylashgan bo'lib, doimiy oqar suvlar mavjud emas va yog'ingarchilik miqdori kam. Havo harorati qish mavsumida -25, -30°C ga pasayadi va yoz faslida +40, +45°C ga ko'tariladi. Qo'riqxonaning Do'ana va Jiydeli bo'limi Orol dengizi bo'yida joylashgan bo'lib, qalin saksovulzorlar bilan qoplangan.

Faunasi: Sutemizuvchilar sinfi 13 tur (sayg'oq, turkman quloni, turkman qoraqulog'i, jayron, qorsak, qora ignali tipratikan, bo'ri, qum tovushqoni, tulki, bo'rsiq, yovvoyi cho'chqa, chiyabo'ri, cho'l mushugi). Qushlar sinfi 36 tur, sudralib yuruvchilar sinfi 3 tur. Yovvoyi hayvonlarning 17 turi O'zbekiston "Qizil kitobi"ga kiritilgan.

Florasi: Qo'riqxona hududida 103 ta o'simlik turi aniqlangan. Oqtog' chalovi, Lola Borshova, Buze lolasi, Ikki gulli lola, Sogdiana lolasi, Kungir kumzum, Qanoti tukli baliqkuz, Qadoqsimon sutlama va Xiva shuragi kabi "Qizil kitob"ga kiritilgan o'simlik turlari mavjud.

Ekoturizm maskanlari: Hududda XIII-XIV asrlardagi Buyuk ipak yo'lidagi muhim manzilgohlardan biri — Beleuli karvonsaroyi yodgorligi mavjud. Hozirda yodgorlik yonidan 5 ga yer maydon ajratilib ekoturistik maskan barpo etilmoqda.

Qo'riqxona atrofiga yaqin mehmonxona mavjud emas. Eng yaqin aholi yashash manzilgohi 100 km uzoqlikda.

Yuridik manzil: Qoraqolpog'iston Respublikasi, Nukus shahri, S.Nurimbetov ko'chasi, 1-A uy.
UZ,
                'content_ru' => <<<'RU'
В целях надёжной охраны уникального биологического разнообразия Устюртской равнины создан Комплексный ландшафтный заказник «Сайгачий» общей площадью 628 300 га, из них охранная зона — 219 800 га.

Расположение: Заказник «Сайгачий» расположен на Устюртской равнине Республики Узбекистан, граничащей с Республикой Казахстан.

Основная деятельность: Сохранение всех природных объектов и комплексов в первозданном природном состоянии, проведение научных исследований и мониторинга природной среды, поддержка подготовки научных кадров и специалистов в области экологии и охраны окружающей среды, обеспечение биологического и ландшафтного разнообразия, поддержание экологического равновесия.

Природные условия: Территория заказника расположена в основном на равнине Устюрта, где климат засушливый, отсутствуют постоянные проточные воды, осадков мало. Температура воздуха зимой опускается до -25, -30°C, летом повышается до +40, +45°C. Участки Доана и Джийдели расположены на берегу Аральского моря и покрыты густыми саксаулами.

Флора: Выявлено 103 вида растений, часть которых занесена в «Красную книгу» Республики Узбекистан (ковыль актауский, тюльпан Борщова, тюльпан Бузе, двуцветковый тюльпан, согдийский тюльпан, серый кумзум, Климакоптера птилоптера, Солянка хивинская и др.).

Фауна: Класс млекопитающих насчитывает 13 видов (сайгак, туркменский кулан, туркменский каракал, джейран, корсак, длинноигольный ёж, волк, заяц-толай, лисица, барсук, кабан, шакал, барханный кот). Класс птиц 36 видов, рептилий 3 вида. В «Красную книгу» Республики Узбекистан занесены 17 видов животных.

Места экотуризма: На территории находится памятник караван-сарая Белеули, считавшийся одним из важных поселений на Великом шёлковом пути (XIII-XIV вв.). Возле памятника начато строительство экотуристического центра площадью 5 га.

В окрестностях заповедника отсутствуют отели. Расстояние до ближайшего населённого пункта составляет 100 км.

Время посещения: Будние дни с 12:00 до 20:00 в летнее время (до 17:00 в зимнее время). Выходные и праздничные дни с 09:00 до 21:00 (до 17:00 в зимнее время).

Юридический адрес: Республика Каракалпакстан, г. Нукус, улица С.Нурымбетова, дом 1-А.
RU,
                'content_en' => <<<'EN'
The Complex Landscape Reserve "Saigachiy" has been established to ensure the reliable protection of the unique biological diversity of the Ustyurt Plateau, with a total area of 628,300 hectares, of which the protected zone covers 219,800 hectares.

Location: The Saigachiy Reserve is situated on the Ustyurt Plain of the Republic of Uzbekistan, bordering the Republic of Kazakhstan.

Main Activities: Preservation of all natural objects and complexes in their pristine natural state, scientific research and environmental monitoring, training of specialists in ecology and environmental protection, ensuring biological and landscape diversity, and maintaining ecological balance.

Natural Conditions: The territory of the reserve is mainly located on the Ustyurt Plain, where the climate is arid, with no permanent flowing waters and little precipitation. Air temperatures drop to -25, -30°C in winter and rise to +40, +45°C in summer. The Doana and Dzheideli sections are located on the shores of the Aral Sea and are covered with dense saxaul vegetation.

Flora: A total of 103 plant species have been identified within the reserve, some of which are listed in the Red Book of Uzbekistan (Aktau feather grass, Borshchov's tulip, Buse's tulip, bicolour tulip, Sogdian tulip, gray kumzum, Climacoptera ptiloptera, Khiva saltwort, etc.).

Fauna: The mammal class includes 13 species (saiga antelope, Turkmenian kulan, Turkmenian caracal, goitered gazelle, corsac fox, long-eared hedgehog, wolf, tolai hare, fox, badger, wild boar, jackal, sand cat). The bird class comprises 36 species, and there are 3 species of reptiles. Seventeen species of animals are listed in the Red Book.

Ecotourism Sites: Within the reserve's territory stands the monument of the Beleuli caravanserai, considered one of the important settlements on the Great Silk Road (13th-14th centuries). A 5-hectare ecotourism centre is being built near this historical monument.

There are no hotels in the vicinity of the reserve. The nearest populated area is 100 km away.

Visit time: Weekdays from 12:00 to 20:00 in summer (until 17:00 in winter). Weekends and holidays from 09:00 to 21:00 (until 17:00 in winter).

Address: 1-A, S. Nurymbetov Street, Nukus city, Republic of Karakalpakstan.
EN,
                'features_uz' => [
                    'Umumiy maydoni 628 300 ga',
                    "Qo'riqlanma zona 219 800 ga",
                    "Sayg'oq, jayron, qulon, qorsak",
                    "17 nodir tur Qizil kitobda",
                ],
                'features_ru' => [
                    'Площадь 628 300 га',
                    'Охранная зона 219 800 га',
                    'Сайгак, джейран, кулан, корсак',
                    '17 редких видов в Красной книге',
                ],
                'features_en' => [
                    'Total area 628,300 ha',
                    'Protected zone 219,800 ha',
                    'Saiga, gazelle, kulan, corsac fox',
                    '17 rare species in Red Book',
                ],
                'stat_area'      => '628 300 ga',
                'stat_species'   => '103 tur',
                'stat_protected' => '17 nodir tur',
                'latitude'       => 43.5000,
                'longitude'      => 56.5000,
                'image'          => 'https://images.unsplash.com/photo-1486870591958-9b9d0d1dda99?w=1600&h=900&fit=crop',
                'featured'       => true,
            ],

            // 2. BUXORO JAYRON PITOMNIGI
            [
                'slug'     => 'buxoro-jayron-pitomnigi',
                'category' => 'maxsus-jayron-pitomnigi',
                'title_uz' => 'Buxoro ixtisoslashtirilgan "Jayron" pitomnigi',
                'title_ru' => 'Бухарский специализированный питомник "Джейран"',
                'title_en' => 'Bukhara Specialized Nursery "Jeyran"',
                'excerpt_uz' => "Kogon va Qorovulbozor shaharlari oralig'idagi 16 522 ga maydonga ega tabiatni muhofaza qilish va kamyob hayvon turlarini ko'paytirish ilmiy-tadqiqot muassasasi. Jayron 1086 bosh, qulon, prjeval oti ko'paytiriladi.",
                'excerpt_ru' => 'Государственный научно-исследовательский питомник по сохранению природы и разведению редких видов на 16 522 га между Каганом и Караулбазаром. Разводят джейранов (1086), куланов, лошадей Пржевальского.',
                'excerpt_en' => 'State research institution for nature conservation and rare species breeding, 16,522 ha between Kagan and Karaulbazar. Breeds gazelles (1086), kulans, Przewalski horses.',
                'content_uz' => <<<'UZ'
Buxoro ixtisoslashtirilgan "Jayron" pitomnigi davlat tabiatni muhofaza qilish, kamyob hayvon turlarini ko'paytirish ilmiy-tadqiqot muassasasi.

Hudud bo'yicha umumiy ma'lumot: Pitomnik Kogon va Qorovulbozor shaharlari orasida, A-380 avtomagistrali bo'ylab Buxoro viloyatining Buxoro tumani hududida joylashgan. Maydoni 16 522 gektar bo'lib, shundan 1-hudud 5 145 gektar (sim to'siq bilan himoyalangan), 2-hudud 11 377 gektar ochiqlik maydonidan iborat.

Tabiiy sharoiti: Pitomnik hududi Qizilqum cho'lining janubi-g'arbiy qismi, Karnabcho'l massivida joylashgan. Hudud dengiz sathidan o'rtacha 332 m balandlikda bo'lib past tepalikli qumlar, takirlar, sho'rxoklar, gipsli qatlam, toshloqlar va ko'llardan iborat.

1-hududning janubiy qismida turli xil sho'rlanish darajasiga ega 3 ta ko'ldan iborat ko'llar majmuasi mavjud. Ko'llardagi suv Amu-Buxoro kanalidan oqib o'tadigan ariq, yer osti sizot suvlari va yillik yog'in miqdori hisobidan shakllanadi.

2-hududning Kaynagach past tog'i yaqinida yer osti sizot suvlaridan shakllanadigan turli darajadagi sho'rlanishga ega 4 ta kichik tabiiy suvliklar joylashgan.

"Jayron" pitomnigi qurg'oqchil zonada joylashgan bo'lib, keskin kontinental iqlimi bilan ajralib turadi. Havo harorati yozda +43°C, +54°C ga, qishda -16°C, -28°C ga tushishi mumkin. Yillik yog'in miqdori 150-200 mm atrofida.

Florasi: Hududida saksovulzorlar, to'qaylar, tuzli botqoq va takirlar o'simliklari mavjud. Pitomnikda 46 oila, 182 turkumga mansub 267 turdagi yuksak o'simliklar o'sadi.

Faunasi: Pitomnik hududida qushlarning 257 turi, sutemizuvchilarning 36 turi, baliqlarning 8 turi, sudralib yuruvchilarning 18 turi, suvda va quruqlikda yashovchilarning 2 turi, umurtqasizlarning 700 ga yaqin turi uchraydi.

Pitomnikda quyidagi asosiy sutemizuvchi turlari maxsus sharoitlarda ko'paytiriladi: jayron (1086 bosh), turkman quloni (76 bosh), prjeval oti (22 bosh), buxoro tog' qo'yi (38 bosh), buxoro bug'usi (1 bosh).

Ekoturizm maskanlari: Ekologik turizm uchun 8 ta ekomarshrutlar ishlab chiqilgan: voler majmuasi (500 m, 30 daqiqa), voler-kichik tuzli ko'l (2 km, 2 soat), voler-ko'llar-birinchi kuzatuv minorasi (5 km, 4 soat), Amu-Buxoro kanali bo'ylab janubiy yo'l avtomobilda (7 km, 1,5-2 soat), 2-ochiqlik bo'ylab sayohat (40 km, 4-5 soat), Kainagach tog'i piyoda (14 km, 5-6 soat) va kechki/tundagi sayohatlar.

Yaqin aholi yashash punktlari: Pitomnik Qorovulbozor tumani "Cho'lquvar" MFY hududidan 10 km, Kogon shahridan 25 km, Buxoro shahridan 42 km uzoqlikda joylashgan.

Tashrif vaqti: Ish kunlari soat 12:00 dan 20:00 gacha (qishda 17:00 gacha). Dam olish va bayram kunlari soat 09:00 dan 21:00 gacha (qishda 17:00 gacha).

Manzil: 200700, Buxoro viloyati, Kogon shahri.
UZ,
                'content_ru' => <<<'RU'
Бухарский специализированный питомник «Джейран» — государственное научно-исследовательское учреждение по охране природы и разведению редких видов животных.

Общая информация: Питомник расположен между городами Каган и Караулбазар, по автодороге А-380, на территории Бухарского района Бухарской области. Площадь: 16 522 га, из них первая зона, огороженная проволочным забором — 5 145 га, вторая зона в 11 377 га открытой местности.

Природные условия: Территория питомника расположена в юго-западной части пустыни Кызылкум, на массиве Карнабчул. Площадь находится на высоте более 330 м над уровнем моря, состоящая из невысоких холмистых песков, бесплодных земель, солончаков, гипсового слоя, скал и озёр.

В южной части первого участка расположен комплекс из 3 озёр разной солёности. Вода образуется за счёт ручья по Аму-Бухарскому каналу, подземных фильтрационных вод и ежегодных осадков.

На втором участке, вблизи невысокой горы Кайнагач, имеются 4 небольших природных водоёма разной минерализации.

Питомник «Джейран» расположен в засушливой зоне с резко континентальным климатом. Температура воздуха летом достигает +54°C, зимой опускается до -28°C. Годовое количество осадков около 150-200 мм.

Флора: На территории растут саксаулы, тугаи, а также растения солончаков и бесплодных земель. Произрастает 46 семейств, 182 рода и 267 видов высокорослых растений.

Фауна: На территории обитает 257 видов птиц, 36 видов млекопитающих, 8 видов рыб, 18 видов рептилий, 2 земноводных и около 700 видов беспозвоночных.

В специальных условиях разводятся: джейран (1086 голов), туркменский кулан (76), лошадь Пржевальского (22), бухарский горный баран (38), бухарский олень (1).

Экотуризм: Разработано 8 эко-маршрутов: вольер (500 м), вольер — соленое озеро (2 км), вольер — озёра — смотровая башня (5 км), южная дорога по Аму-Бухарскому каналу на автомобиле (7 км), 40-км маршрут по второму участку, гора Кайнагач (14 км пешком). Также предусмотрены ночные поездки.

Питомник расположен в 10 км от посёлка «Чалкувар» Караулбазарского района, в 25 км от Кагана, в 42 км от Бухары.

Гостиницы: На территории питомника строится «Визит-центр», где предусмотрены условия для проживания гостей.

Время посещения: Будние дни с 12:00 до 20:00 в летнее время (до 17:00 в зимнее время). Выходные и праздничные дни с 09:00 до 21:00 (до 17:00 в зимнее время).

Адрес: 200700, Бухарская область, г. Коган.
RU,
                'content_en' => <<<'EN'
Bukhara Specialized Nursery "Jeyran" is a state research institution for nature conservation and breeding rare animal species.

General Information: The nursery is located between the cities of Kagan and Karaulbazar, along the A-380 highway, in the Bukhara district of the Bukhara region. Area: 16,522 hectares — the first zone (5,145 ha) is enclosed by a wire fence; the second zone (11,377 ha) is open space.

Natural Conditions: The nursery is in the southwest part of the Kyzylkum Desert, on the Karnabchul massif. The area is at over 330 metres above sea level, consisting of low sandy hills, barren lands, salt marshes, gypsum layers, rocks, and lakes.

In the southern part of the first section, there is a complex of 3 lakes of varying salinity. Water is fed from a stream along the Amu-Bukhara canal, underground filtration water, and annual precipitation.

In the second section, near the low Kainagach mountain, there are 4 small natural reservoirs of varying mineralization formed from groundwater.

The "Jeyran" nursery is in a drought-prone zone with a harsh continental climate. Summer temperatures reach +54°C; winters drop to -28°C. Annual precipitation is about 150-200 mm.

Flora: Saxauls, tugais, and salt-marsh plants. The nursery has 46 plant families, 182 genera, and 267 species of tall plants.

Fauna: 257 bird species, 36 mammal species, 8 fish species, 18 reptile species, 2 amphibians, and about 700 invertebrate species.

The following main mammals are bred in special conditions: gazelle (1086), Turkmenian kulan (76), Przewalski's horse (22), Bukhara mountain sheep (38), Bukhara deer (1).

Ecotourism: 8 eco-routes have been developed — Aviary (500 m), Aviary–salt lake (2 km), Aviary–lakes–observation tower (5 km), southern road along the Amu-Bukhara canal by car (7 km), a 40-km route through the second section, and Kainagach mountain (14 km on foot). Night trips are also available.

The nursery is located 10 km from Chalkuvar village in Karaulbazar district, 25 km from Kagan, and 42 km from Bukhara.

A "Visitor Centre" with guest accommodation is being constructed on the nursery premises.

Visit time: Weekdays from 12:00 to 20:00 in summer (until 17:00 in winter). Weekends and holidays from 09:00 to 21:00 (until 17:00 in winter).

Address: 200700, Bukhara region, Kogon city.
EN,
                'features_uz' => [
                    'Umumiy maydoni 16 522 ga',
                    "267 tur o'simlik (46 oila)",
                    'Jayron 1086, qulon 76, prjeval oti 22',
                    "8 ta ekomarshrut",
                ],
                'features_ru' => [
                    'Площадь 16 522 га',
                    '267 видов растений (46 семейств)',
                    'Джейран 1086, кулан 76, лошадь Пржевальского 22',
                    '8 экомаршрутов',
                ],
                'features_en' => [
                    'Total area 16,522 ha',
                    '267 plant species (46 families)',
                    'Gazelle 1086, kulan 76, Przewalski horse 22',
                    '8 eco-routes',
                ],
                'stat_area'      => '16 522 ga',
                'stat_species'   => '267 tur',
                'stat_protected' => "Jayron 1086 bosh",
                'latitude'       => 39.6500,
                'longitude'      => 64.4500,
                'image'          => 'https://images.unsplash.com/photo-1483347756197-71ef80e95f73?w=1600&h=900&fit=crop',
                'featured'       => true,
            ],

            // 3. QUYI AMUDARYO BIOSFERA REZERVATI
            [
                'slug'     => 'quyi-amudaryo-biosfera-rezervati',
                'category' => 'biosfera-rezervatlari',
                'title_uz' => '"Quyi Amudaryo" davlat biosfera rezervati',
                'title_ru' => '"Нижне-Амударьинский" государственный биосферный резерват',
                'title_en' => '"Lower Amu Darya" State Biosphere Reserve',
                'excerpt_uz' => "Amudaryoning quyi oqimida joylashgan biosfera rezervati. Maydoni 68 717,8 ga (qo'riqxona 11 568,3 ga, bufer 6 731,4 ga, o'tish 50 418,1 ga). 419 o'simlik, 348 umurtqali hayvon, Buxoro bug'usini ko'paytirish.",
                'excerpt_ru' => 'Биосферный резерват в нижнем течении Амударьи. Площадь 68 717,8 га (заповедная 11 568,3, буферная 6 731,4, переходная 50 418,1). 419 видов растений, 348 позвоночных, разведение бухарского оленя.',
                'excerpt_en' => 'Biosphere reserve in the lower Amu Darya. Area 68,717.8 ha (protected 11,568.3, buffer 6,731.4, transition 50,418.1). 419 plant species, 348 vertebrates, Bukhara deer breeding.',
                'content_uz' => <<<'UZ'
Quyi Amudaryo davlat biosfera rezervati Amudaryo etaklari Tuyamo'yin va Orol dengizi o'rtasida, daryoning quyi oqimida joylashgan allyuvial tekislikning keng hududini o'z ichiga oladi. Tekislik shimolda Orol dengizigacha boradi, g'arbda Ustyurt platosi, janubda Zangiuz Qoraqumi, sharqdan Qizilqum cho'li bilan chegaralangan. Xorazm viloyatining Gurlan, Beruniy va Amudaryo tumanlari bilan chegaradosh.

Quyi Amudaryo davlat biosfera rezervati Qoraqolpog'iston Respublikasining Nukus shahridan 90 km, Beruniy tumani markazidan 44 km uzoqlikda joylashgan.

Umumiy maydoni 68 717,8 gektarni tashkil etadi. Hudud 3 zonaga bo'lingan: qo'riqxona 11 568,3 gektar, bufer 6 731,4 gektar va o'tish 50 418,1 gektardan iborat.

Tabiiy sharoiti: Hududning iqlimi keskin kontinental. Qishlari mo'tadil sovuq va qorli. Absalyut minimum -26°C ga teng bo'lganda, yanvarning o'rtacha harorati noldan 4-5°C past. Yozi issiq, harorat absalyut maksimumi +42,6°C. Markaziy Osiyodagi eng qurg'oqchil hududlardan biri bo'lib, asosan bahor va kuzda o'rtacha 80 mm yog'in yog'adi.

O'simlik turlari: Hududda o'simliklarning 419 ga yaqin turi mutaxassislar tomonidan kuzatilgan.

Yovvoyi hayvonlar: Hududda 348 turdagi umurtqali hayvonlar — 41 turdagi baliqlar, 2 ta amfibiyalar, 24 ta sudralib yuruvchilar, 243 ta qushlar (migratsiya qiluvchilar bilan) va 38 ta sutemizuvchilar ro'yxatga olingan. Shulardan baliqlarning 10 turi, sudralib yuruvchilarning 2 turi, qushlarning 14 turi va sutemizuvchilarning 4 turi O'zbekiston "Qizil kitobi"ga, 18 tur esa TMXI Qizil ro'yxatiga kiritilgan.

Ekoturizm maskanlari: Biosfera rezervatida 3 ta ekoturistik marshrut yo'nalishlari mavjud:

№1 marshrut: Sayyohlar biosfera rezervatining ma'muriy binosida joylashgan muzeyi hamda "Buxoro bug'usi" saqlanayotgan parvarishxona (vol'er) bilan tanishadi (uzunligi 1,5-2 km).

№2 marshrut: Muzey ekskursiyasi, parvarishxona (vol'er)ni tomosha qilish, sayohat davomida Amudaryo daryosi landshafti, to'qayning florasi va faunasi bilan yaqindan tanishish, "Buxoro bug'usi" populyatsiyasini bevosita kuzatish (uzunligi 10-12 km).

Tashrif vaqti: Ish kunlari soat 12:00 dan 20:00 gacha (qishda 17:00 gacha). Dam olish va bayram kunlari soat 09:00 dan 21:00 gacha (qishda 17:00 gacha).

Quyi Amudaryo davlat biosfera rezervati atrofiga yaqin Amudaryo tumanidagi "Xon saroy" mehmonxonasi faoliyat olib bormoqda.

Ma'muriy binosi: Qoraqalpog'iston Respublikasi, Beruniy tumani, "Oltinsoy".
UZ,
                'content_ru' => <<<'RU'
Нижне-Амударьинский государственный биосферный резерват включает в себя обширную территорию аллювиальной равнины, расположенной ниже по течению реки, между предгорьями Амударьи и Аральским морем. Равнина простирается до Аральского моря на севере, ограничивается плато Устюрт на западе, Зангюзскими Каракумами на юге и пустыней Кызылкум на востоке. Граничит с Гурланским, Берунийским и Амударьинским районами Хорезмской области.

Резерват расположен в 90 км от Нукуса и 44 км от центра Берунийского района Республики Каракалпакстан.

Общая площадь биосферного резервата составляет 68 717,8 га. Территория разделена на 3 зоны: заповедная 11 568,3 га, буферная 6 731,4 га и переходная 50 418,1 га.

Природные условия: Климат резко континентальный, зима умеренно холодная и снежная. При абсолютном минимуме -26°C средняя температура января составляет 4-5° ниже нуля. Максимальная летняя температура +42°C. Один из самых засушливых в Центральной Азии регионов, в среднем весной и осенью выпадает всего 80 мм осадков.

Флора: Около 419 видов растений.

Фауна: На территории зарегистрировано 348 видов позвоночных — 41 вид рыб, 2 вида амфибий, 24 вида рептилий, 243 вида птиц (включая мигрирующих) и 38 видов млекопитающих. Из них 10 видов рыб, 2 вида рептилий, 14 видов птиц, 4 вида млекопитающих занесены в Красную книгу Республики Узбекистан, а 18 видов — в Красный список МСОП.

Экотуризм: 3 экотуристических маршрута:

Маршрут №1: Музей в административном здании биосферного резервата и питомник (вольер) для бухарских оленей (1,5-2 км).

Маршрут №2: Музей, питомник, маршрут по знакомству с ландшафтом реки Амударьи, флорой и фауной тугая, наблюдение за популяцией бухарского оленя (10-12 км).

Время посещения: Будние дни с 12:00 до 20:00 в летнее время (до 17:00 в зимнее время). Выходные и праздничные дни с 09:00 до 21:00 (до 17:00 в зимнее время).

Недалеко от резервата, в Амударьинском районе, действует гостиница «Хан Сарай».

Административное здание: посёлок «Алтинсай» Берунийского района, Республика Каракалпакстан.
RU,
                'content_en' => <<<'EN'
The Lower Amu Darya State Biosphere Reserve includes a vast area of alluvial plain located downstream of the river, between the foothills of the Amu Darya and the Aral Sea. The plain extends to the Aral Sea in the north, is bounded by the Ustyurt plateau in the west, the Zangyuz Karakum in the south, and the Kyzylkum desert in the east. It also borders the Gurlan, Beruni and Amu Darya districts of the Khorezm region.

The reserve is located 90 km from the city of Nukus and 44 km from the centre of Beruni district in the Republic of Karakalpakstan.

The total area is 68,717.8 hectares, divided into 3 zones: a protected area of 11,568.3 ha, a buffer area of 6,731.4 ha, and a transition area of 50,418.1 ha.

Natural conditions: The climate is sharply continental with moderately cold, snowy winters. With an absolute minimum of -26°C, the average January temperature is 4-5°C below zero. The maximum summer temperature reaches +42°C. The region is one of the driest in Central Asia, with an average of only 80 mm of precipitation in spring and autumn.

Flora: About 419 plant species.

Fauna: 348 species of vertebrates have been registered — 41 fish, 2 amphibians, 24 reptiles, 243 birds (including migratory species), and 38 mammals. Of these, 10 fish species, 2 reptile species, 14 bird species and 4 mammal species are listed in the Red Book of Uzbekistan, and 18 species in the IUCN Red List.

Ecotourism: 3 ecotourism routes have been laid out:

Route No. 1: The museum in the administrative building and a nursery (aviary) for Bukhara deer (1.5-2 km).

Route No. 2: The museum, nursery, and a route to get acquainted with the landscape of the Amu Darya, the flora and fauna of the tugai, and observation of the Bukhara deer population (10-12 km).

Visit time: Weekdays from 12:00 to 20:00 in summer (until 17:00 in winter). Weekends and holidays from 09:00 to 21:00 (until 17:00 in winter).

Not far from the reserve, in the Amu Darya district, the Khan Saray Hotel operates.

Administrative building: village of Altinsay, Beruni district, Republic of Karakalpakstan.
EN,
                'features_uz' => [
                    'Umumiy maydoni 68 717,8 ga',
                    "419 tur o'simlik",
                    "348 umurtqali, 38 sutemizuvchi",
                    "Buxoro bug'usi pitomnigi",
                ],
                'features_ru' => [
                    'Площадь 68 717,8 га',
                    '419 видов растений',
                    '348 позвоночных, 38 млекопитающих',
                    'Питомник бухарских оленей',
                ],
                'features_en' => [
                    'Total area 68,717.8 ha',
                    '419 plant species',
                    '348 vertebrates, 38 mammals',
                    'Bukhara deer breeding facility',
                ],
                'stat_area'      => '68 717,8 ga',
                'stat_species'   => '419 tur',
                'stat_protected' => '20 nodir tur',
                'latitude'       => 42.4000,
                'longitude'      => 60.3000,
                'image'          => 'https://images.unsplash.com/photo-1454942901704-3c44c11b2ad1?w=1600&h=900&fit=crop',
                'featured'       => true,
            ],
        ];
    }
}
