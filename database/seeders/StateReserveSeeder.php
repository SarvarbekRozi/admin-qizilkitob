<?php

namespace Database\Seeders;

use App\Models\NaturalResource;
use Illuminate\Database\Seeder;

class StateReserveSeeder extends Seeder
{
    /**
     * Plain matnni HTML <p> bloklariga aylantiradi.
     * Bo'sh qator bilan ajratilgan paragraflar — alohida <p>.
     */
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
        foreach ($this->reserves() as $data) {
            $payload = [
                'category'       => 'davlat-qoriqxonalari',
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
    private function reserves(): array
    {
        return [
            // 1. ZOMIN
            [
                'slug'     => 'zomin-davlat-qoriqxonasi',
                'title_uz' => '"Zomin" davlat qo\'riqxonasi',
                'title_ru' => 'Государственный заповедник "Заамин"',
                'title_en' => 'State Nature Reserve "Zaamin"',
                'excerpt_uz' => 'Turkiston tog\' tizmasining shimoli-g\'arbiy yonbag\'rida joylashgan, dengiz sathidan 1700-4029 m balandlikdagi tog\'lar va archazorlar qo\'riqxonasi. Umumiy maydoni 26 921 ga.',
                'excerpt_ru' => 'Заповедник на северо-западном склоне Туркестанского хребта на высоте 1700-4029 метров с уникальными арчовыми лесами. Общая площадь 26 921 га.',
                'excerpt_en' => 'Reserve on the northwestern slope of the Turkestan range at 1700-4029 m elevation, with unique juniper forests. Total area 26,921 ha.',
                'content_uz' => <<<'UZ'
"Zomin" davlat qo'riqxonasi Turkiston tog' tizmasining shimoli-g'arbiy yonbag'rida joylashgan bo'lib, janubda Tojikiston Respublikasi, sharqda Zomin tumani hududida joylashgan Zomin tabiat milliy bog'i, Zomin o'rmon xo'jaligi g'arbda Baxmal tumani Baxmal o'rmon xo'jaligi va shimolda Molguzar tog'i bilan chegaradosh.

Umumiy maydoni 26 921 gektar bo'lib, qo'riqlanma (bufer) hududi 3 516 gektarni tashkil etadi.

Qo'riqxonada xorijiy va mahalliy sayyohlarni o'ziga rom etadigan ekoturizm maskanlari va bir qancha madaniy meros ob'ektlari mavjud.

Tabiiy sharoiti: Qo'riqxona yerlari tarkibiga asosan tog' tizimlari kiradi. Qo'riqxona asosan Zomin va Baxmal tumanlarida joylashgan bo'lib, dengiz sathidan 1700 metrdan 4029 metrgacha balandlikka ega uch zonani — tog'larning pastki, o'rta va yuqori qismlarini o'z ichiga oladi. Hududning janubiy qismi Turkiston tog' tizmasining tik jarliklaridan iborat. Shimoliy qismi biroz tekisroq rel'efli supalardan iborat bo'lib, mergel va lyossuglinkasimon tuproq qatlamlari bilan qoplangan.

Florasi: Zomin davlat qo'riqxonasi o'simliklar dunyosida 105 oila, 530 turkumga mansub 1216 tur uchraydi.

Faunasi: Zomin davlat qo'riqxonasi hududida qushlarning 102 turi, sutemizuvchilarning 30 turi, sudralib yuruvchilarning 14 turi, baliqlarning 1 turi, suvda va quruqlikda yashovchilarning 2 turi uchraydi.

Ekoturizm maskanlari: Zomin va Baxmal bo'limlaridagi "Boyqo'ng'ir tabiati", "Qirq kiz I", "Chortangi darasi", "Ko'lsoy tabiati" va "Qoshqa suv ko'zatuv markazi" ekoturistik marshrutlari mavjud. Sayyohlar o'simliklar va hayvonlar hayotini, qo'riqxonaning tik jarliklarini, qorli tog' cho'qqilari va quyuq archazorlarni ko'rishlari mumkin.

Qo'riqxona atrofiga yaqin mehmonxona: "Wyndham Garden Hotel Zaamin" mehmonxonasi hududdan 5 km masofada Zomin tumanida joylashgan.

Tashrif vaqti: Ish kunlari soat 12:00 dan 20:00 gacha (qishda 17:00 gacha). Dam olish va bayram kunlari soat 09:00 dan 21:00 gacha (qishda 17:00 gacha).

Manzil: Jizzax viloyati, Zomin tumani, "Bog'ishamol" MFY.
UZ,
                'content_ru' => <<<'RU'
Государственный заповедник «Заамин» расположен на северо-западном склоне Туркестанского горного хребта, граничит с Республикой Таджикистан на юге, Зоминским национальным парком и Зоминским лесным хозяйством на востоке, Бахмальским лесным хозяйством Бахмальского района на западе, и горой Молгузар с севера.

Общая площадь составляет 26 921 га, а буферная зона 3 516 га. Заповедник располагает объектами экотуризма, а также объектами культурного наследия, привлекающими иностранных и отечественных туристов.

Природные условия: Территория в основном состоит из горных систем и включает в себя три зоны — нижнюю, среднюю и верхнюю части гор (1700-4029 метров над уровнем моря). Южная часть территории — крутые скалы Туркестанского хребта. Северная часть состоит из террас, со сравнительно ровным рельефом, покрыта слоями мергеля и лёссовидных суглинков.

Флора: В заповеднике встречаются 105 семейств, 1216 видов растений, относящихся к 530 родам.

Фауна: В Зоминском государственном заповеднике обитают 102 вида птиц, 30 видов млекопитающих, 14 видов рептилий, 1 вид рыб, 2 вида земноводных животных.

Экотуризм: Экотуристические маршруты «Природа Байкунгира», «Кырк кыз I», «Ущелье Чортанги», «Кульсайская природа» и «Кашка-водный наблюдательный пункт» очень привлекательны для туристов. Можно понаблюдать за флорой и фауной заповедника, увидеть крутые скалы, нижние, средние и высокие части гор, заснеженные горные вершины и густые еловые леса. Отель «Wyndham Garden Hotel Zaamin» расположен в 5 км от заповедника в Заминском районе.

Расстояние: 110 км от города Джизак через Зоминский национальный природный парк до Суфийского горного хребта; 100 км от города Джизак через село Музбулак Бахмальского района.

Время посещения: Будние дни с 12:00 до 20:00 в летнее время (до 17:00 в зимнее время). Выходные и праздничные дни с 09:00 до 21:00 (до 17:00 в зимнее время).

Адрес: Джизакская область, Зоминский район, посёлок «Богишамол».
RU,
                'content_en' => <<<'EN'
State Nature Reserve "Zaamin" is located on the northwestern slope of the Turkestan mountain range, bordering the Republic of Tajikistan to the south, Zomin National Park and Zomin Forestry to the east, Bakmal Forestry of Bakmal district to the west, and Mount Molguzar to the north.

The total area is 26,921 hectares, with a buffer zone of 3,516 hectares. The reserve offers ecotourism attractions and cultural heritage sites that attract both foreign and domestic tourists.

Natural conditions: The territory consists mainly of mountain systems and includes three zones — lower, middle, and upper parts of the mountains (1700-4029 meters above sea level). The southern part features steep cliffs of the Turkestan ridge. The northern part consists of terraces with relatively flat relief, covered with layers of marl and loess-like clay soils.

Flora: The reserve is home to 105 families, 1,216 plant species belonging to 530 genera.

Fauna: Zaamin State Reserve hosts 102 bird species, 30 mammal species, 14 reptile species, 1 fish species, and 2 amphibian species.

Ecotourism: Routes "Nature of Baykungir", "Kyrk Kyz I", "Chortangi Gorge", "Kulsai Nature" and "Kashka-Water Observation Point" attract many visitors. Tourists can observe wildlife, see steep cliffs, snow-capped peaks and dense juniper forests. The "Wyndham Garden Hotel Zaamin" is located 5 km from the reserve.

Distance: 110 km from Jizzakh via Zomin National Park to the Sufi mountain ridge; 100 km from Jizzakh via Muzbulak village of Bakmal district.

Visit time: Weekdays from 12:00 to 20:00 in summer (until 17:00 in winter). Weekends and holidays from 09:00 to 21:00 (until 17:00 in winter).

Address: Bogishamol village, Zomin district, Jizzakh region.
EN,
                'features_uz' => [
                    'Umumiy maydoni 26 921 gektar',
                    "1216 tur o'simlik (105 oila)",
                    '102 tur qush, 30 tur sutemizuvchi',
                    "5 ta ekoturistik marshrut",
                ],
                'features_ru' => [
                    'Площадь 26 921 га',
                    '1216 видов растений (105 семейств)',
                    '102 вида птиц, 30 млекопитающих',
                    '5 экотуристических маршрутов',
                ],
                'features_en' => [
                    'Total area 26,921 ha',
                    '1,216 plant species (105 families)',
                    '102 bird species, 30 mammals',
                    '5 ecotourism routes',
                ],
                'stat_area'      => '26 921 ga',
                'stat_species'   => '1216 tur',
                'stat_protected' => '1-toifa',
                'latitude'       => 39.6788,
                'longitude'      => 68.4022,
                'image'          => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=1600&h=900&fit=crop',
                'featured'       => true,
            ],

            // 2. NUROTA
            [
                'slug'     => 'nurota-davlat-qoriqxonasi',
                'title_uz' => '"Nurota" davlat qo\'riqxonasi',
                'title_ru' => 'Государственный заповедник "Нурата"',
                'title_en' => 'State Reserve "Nurata"',
                'excerpt_uz' => 'Pomir-Oloy va Tyan-Shan tog\' majmualari orasidagi Nurota tog\' tizmasi markazida, Forish tumanida joylashgan. 17 752 ga, 847 tur o\'simlik, Seversov qo\'ylari pitomnigi.',
                'excerpt_ru' => 'Расположен в центре Нуратинского хребта, в переходной зоне между Памиро-Алаем и Тянь-Шанем. Площадь 17 752 га, 847 видов растений, питомник архаров Северцова.',
                'excerpt_en' => 'Located in the central Nurata mountain range, in the transitional zone between Pamir-Alai and Tian-Shan. Area 17,752 ha, 847 plant species, Severtsov\'s sheep breeding centre.',
                'content_uz' => <<<'UZ'
"Nurota" davlat qo'riqxonasi Pomir-Oloy bilan Tyan-Shan tog' majmualari va Turon pasttekisligining orasidagi o'tish hududida joylashgan Nurota tog' tizmasining markaziy qismida joylashgan. Nurota tog' tizmasi Turkiston tizmasi hududidan shimoliy-g'arbga qarab 200 km gacha cho'zilgan bo'lib, Qizilqum sahrosi ichkarisiga chuqur kirib boradi.

Qo'riqxona Jizzax viloyati Forish tumani hududida dengiz sathidan 500 m dan 2169 m balandlikda joylashgan bo'lib, janubdan Samarqand viloyatining Payariq, Qo'shrabot, g'arbdan Navoiy viloyatining Nurota tumanlari bilan chegaradosh.

Qo'riqxona umumiy maydoni 17 752,0 ga, shu bilan birga 20 312,87 ga qo'riqlanma zonasi belgilangan. "Nurota" davlat qo'riqxonasi Jizzax viloyati markazidan 100 km, Forish tumani markazidan 40 km uzoqlikda joylashgan.

Tabiiy sharoiti: Qo'riqxona iqlim sharoiti quruq va issiq, geologik tuzilmasida proterozoy uglerodli, karbonli-grafitli va ohak-kremniyli slaneslar asosiy rol o'ynaydi.

Florasi: "Nurota" davlat qo'riqxonasida 847 tur o'simliklar aniqlangan bo'lib, shundan 32 turi yo'qolib ketish arafasidagi yoki "Qizil kitob"ga kiritilgan turlardir.

Faunasi: Qo'riqxona hududida umurtqali hayvonlarning 260 turi uchrashi kuzatilgan. Shu jumladan, sutemizuvchilarning 35 turi (Kichik taqaburun, Qorsak, Olaqo'zan, Qizilqum yovvoyi qo'yi (Arxar), Oq qorinli o'qquloq, Jayra, Bo'ri va Yovvoyi cho'chqa), qushlarning 200 turi, sudralib yuruvchilarning 21 turi, amfibiyalarning 3 turi va baliqlarning 1 turi hamda jami umurtqasiz hayvonlarning 864 turi aniqlangan. TMXI "Qizil ro'yxati" va O'zbekiston "Qizil kitobi"ga kiritilgan noyob hayvon va qushlar 32 turni tashkil etadi.

Ekoturizm maskanlari: Qo'riqxona himoya maydonida joylashgan 2000 yillik Savr (Archa) daraxti yoki Sharq Biotasi alohida ahamiyatga ega bo'lib, obyekt Forish tuman markazidan 55 km uzoqlikda "Do'stlik" MFY, Mojrum qishlog'ining yuqori qismida joylashgan.

Bundan tashqari Seversov qo'ylarini (Ovis severtzovi) tutqunlikda saqlash, ko'paytirish usullari va biologiyasini o'rganish maqsadida tashkil etilgan 16 ga yer maydoniga ega pitomnigi (volyer) Forish tumani markazidan 45 km uzoqlikda "Uxum" MFY yuqori Hayot qishlog'ida joylashgan.

Qo'riqxona atrofiga yaqin mehmon uylari yuqori Hayot qishlog'ida 4 ta, yuqori Uxum qishlog'ida 3 ta, Asrof qishlog'ida 3 ta va Porasht qishlog'ida 2 ta — 20-30 kishilik sig'imda faoliyat olib bormoqda.

Manzil: Forish tumani markazi Bog'don shaharchasi, Qo'riqxona ko'chasi, 5-uy.
UZ,
                'content_ru' => <<<'RU'
Государственный заповедник «Нурата» находится в центральной части Нуратинского горного хребта, расположенного в переходной части между Памиро-Алайскими и Тянь-Шаньскими горами и Туранской низменностью. Горные хребты Нурата простираются на 200 км от Туркестанского хребта на северо-запад и глубоко проникают в пустыню Кызылкум.

Заповедник находится на высоте от 500 до 2169 метров над уровнем моря, на территории Фаришского района Джизакской области. Заповедник граничит с Паярыкским и Кошработским районами Самаркандской области с юга и Нуратинским районом Навоийской области с запада.

Общая площадь заповедника составляет 17 752,0 га, а охранная зона — 20 312,87 га. Расположен в 100 км от центра Джизакской области и в 40 км от центра Фаришского района.

Природные условия: Климат заповедника сухой и жаркий, в геологическом составе почвы основу составляют протерозойские углеродистые, углеграфитовые и известково-кремнистые сланцы.

Флора: В заповеднике «Нурата» выявлено 847 видов растений, из них 32 вида находятся на грани исчезновения или занесены в «Красную книгу».

Фауна: На территории заповедника отмечено 260 видов позвоночных животных, в том числе 35 видов млекопитающих (Малый подковонос, Корсак, Перевязка, Кызылкумский горный баран, Белобрюхий стрелоух, Дикобраз, Дикий кабан, Волк и др.), более 200 видов птиц, 21 вид рептилий, 3 вида амфибий, всего 864 вида беспозвоночных. 32 вида редких животных и птиц занесены в «Красную книгу» Республики Узбекистан и «Красный список» МСОП.

Объекты экотуризма: Особое значение имеет 2000-летнее дерево Савур (Арча) или Биота Восточная — находится в 55 км от центра Фаришского района, в верхней части села Можрум.

Особый интерес проявляется к Северцовским овцам (Ovis severtzovi), которые содержатся в питомнике (вольере) площадью 16 га, созданном для сохранения, размножения и научного изучения. Питомник находится в 45 км от центра Фаришского района, в верхнем селе Хаёт.

Также имеются гостевые дома на 20-30 человек в сёлах Верхний Хаёт, Верхний Ухум, Асроф и Порашт.

Адрес: ул. Корикхона, д. 5, посёлок Богдон, центр Фаришского района.
RU,
                'content_en' => <<<'EN'
The "Nurata" State Reserve is located in the central part of the Nurata mountain range, in the transitional zone between the Pamir-Alai and Tian-Shan mountain ranges and the Turan lowland. The Nurata mountains stretch for 200 km from the Turkestan range to the northwest, deeply penetrating the Kyzylkum desert.

The reserve sits at an altitude of 500 to 2,169 meters above sea level, in the Farish district of Jizzakh region. It borders the Payarik and Koshrobata districts of Samarkand region to the south and the Nurata district of Navoi region to the west.

The total area of the reserve is 17,752.0 hectares, with a protective zone of 20,312.87 hectares. It is located 100 km from the centre of Jizzakh region and 40 km from the centre of Farish district.

Natural conditions: The climate is dry and hot. The geological composition primarily consists of Precambrian carbonaceous, graphite, and calcareous-siliceous shales.

Flora: 847 plant species have been identified, including 32 species on the brink of extinction or listed in the Red Book.

Fauna: 260 species of vertebrate animals are recorded, including 35 mammal species (Lesser Horseshoe Bat, Corsac Fox, Marbled Polecat, Kyzylkum Mountain Sheep, Egyptian Fruit Bat, Crested Porcupine, Wild Boar, Wolf, etc.), over 200 bird species, 21 reptile species, 3 amphibian species, and 864 invertebrate species. 32 rare animal and bird species are listed in the Red Book of the Republic of Uzbekistan and the IUCN Red List.

Ecotourism sites: The 2,000-year-old Savur (Archa) tree or Eastern Biota holds particular importance — located 55 km from Farish district centre, in the upper part of Mozhrum village.

Also of special interest is the Severtsov's Sheep (Ovis severtzovi) breeding facility — a 16-hectare nursery established for conservation, breeding, and scientific study, located 45 km from Farish district centre in the upper village of Khayot.

Guest houses for 20-30 people are available in the villages of Upper Khayot, Upper Ukhum, Asrof, and Porasht.

Address: 5 Korikkhona Street, Bogdon city, Farish district centre.
EN,
                'features_uz' => [
                    'Umumiy maydoni 17 752 ga',
                    "847 tur o'simlik (32 tasi Qizil kitobda)",
                    '260 umurtqali hayvon, 35 sutemizuvchi',
                    '2000 yillik Savr daraxti',
                ],
                'features_ru' => [
                    'Площадь 17 752 га',
                    '847 видов растений (32 в Красной книге)',
                    '260 позвоночных, 35 млекопитающих',
                    '2000-летнее дерево Савур',
                ],
                'features_en' => [
                    'Total area 17,752 ha',
                    '847 plant species (32 in Red Book)',
                    '260 vertebrates, 35 mammals',
                    '2,000-year-old Savur tree',
                ],
                'stat_area'      => '17 752 ga',
                'stat_species'   => '847 tur',
                'stat_protected' => '32 nodir tur',
                'latitude'       => 40.5500,
                'longitude'      => 66.6000,
                'image'          => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=1600&h=900&fit=crop',
                'featured'       => true,
            ],

            // 3. HISOR
            [
                'slug'     => 'hisor-davlat-qoriqxonasi',
                'title_uz' => '"Hisor" davlat qo\'riqxonasi',
                'title_ru' => 'Государственный заповедник "Гиссар"',
                'title_en' => 'State Reserve "Gissar"',
                'excerpt_uz' => "Pomir-Hisor tog' tizmasining janubiy-g'arbiy qismida, 1800-4421 m balandlikda joylashgan eng yirik qo'riqxona. Maydoni 80 986 ga, 1298 tur o'simlik, qor qoploni va Suvtushar sharsharasi.",
                'excerpt_ru' => 'Крупнейший заповедник на юго-западе Памиро-Гиссарского хребта на высоте 1800-4421 м. Площадь 80 986 га, 1298 видов растений, снежный барс и водопад Сувтушар (84 м).',
                'excerpt_en' => 'Largest reserve on the southwestern Pamir-Gissar range at 1800-4421 m elevation. Area 80,986 ha, 1,298 plant species, snow leopard, and the 84-m Suvdushar waterfall.',
                'content_uz' => <<<'UZ'
Qo'riqxona Pomir-Hisor tog' tizmasining janubiy-g'arbiy tizmalari — Oloy tog' tizmasining o'rta va baland tog' zonasida joylashgan. Dengiz sathidan 1800-4421 metr balandlikdagi Oqsuv, Tanxozdaryo va Qizilsuv daryolarining havzalarida, Qashqadaryo viloyatining Shahrisabz, Yakkabog' va Qamashi tumanlari hududida joylashgan bo'lib, sharqdan Tojikiston va janubi-sharqdan Surxondaryo viloyati bilan chegaradosh.

Umumiy maydoni 80 986,1 gektar bo'lib, qo'riqlanma (bufer) hududi 13 231,1 gektarni tashkil etadi.

Qo'riqxonada xorijiy va mahalliy sayyohlarni o'ziga rom etadigan ekoturizm maskanlari va bir qancha madaniy meros obyektlari mavjud.

Tabiiy sharoiti: Tog' yotqiziqlari ichida paleozoy jinslari ko'p uchraydi. Cho'qqilarining balandligi 2500 m dan 4421 m gacha. Jumladan, Xo'ja-Kirshavor — 4303 m, To'rtqo'ylik — 4366 m, Hazrati Sulton tog'i — 4367 m, Bibi-O'lmas tog'i — 4487 m. Abadiy muzliklardan To'palangdaryo va Oqsuvdaryolari boshlanadi. Botirboy muzligi maydoni 1600 ga.

Qo'riqxona hududidagi aksariyat daryolar Seversov hamda Botirboy muzliklaridan boshlanadi (jami 3155 ga). Eng yirik daryolar — Oqsuv, Tanxoz va Qizildaryo. Hududdagi eng baland sharshara "Suvtushar" bo'lib, balandligi 84 m — respublikamizdagi eng baland sharsharalardan biri. Qo'riqxonada katta-kichik 10 ga yaqin ko'llar mavjud.

Florasi: 71 oila, 457 turkumga mansub 1298 tur o'simlik aniqlangan.

Faunasi: 276 tur umurtqali hayvon uchraydi. Sutemizuvchilarning 32 turi (Qor qoploni, Qo'ng'ir ayiq, Turkiston silovsini, O'rta Osiyo qunduzi, Qizil sug'ur, Yovvoyi cho'chqa, Sibir tog' echkisi, Jayra, Tog' suvsari, Latcha, Bo'rsiq), qushlarning 225 turi, sudralib yuruvchilarning 17 turi, suvda va quruqlikda yashovchilarning 2 turi. TMXI "Qizil ro'yxati" va O'zbekiston "Qizil kitobi"ga kiritilgan noyob hayvon va qushlar 17 turni tashkil etadi.

Ekoturizm maskanlari: Hazrati Sulton platosi, Suvtushar sharsharasi, Dinozavr izlari va Amir Temur g'ori obyektlari qo'riqlanma zonalaridir. G'yelon bo'limida ziyorat turizmi (kempinglar, o'tovlar, dam olish, ovqatlanish, selfi olish nuqtalari) qurilmoqda. Miraki bo'limida Suvtushar sharsharasi atrofida ekoturizm maskani barpo etildi.

Qo'riqxona viloyat markazi Qarshidan 170-200 km masofada joylashgan. Shahrisabz tumani G'yelon qishlog'ida zamonaviy mehmon uylari mavjud.

Tashrif vaqti: Ish kunlari soat 12:00 dan 20:00 gacha (qishda 17:00 gacha). Dam olish va bayram kunlari soat 09:00 dan 21:00 gacha (qishda 17:00 gacha).

Manzil: Qashqadaryo viloyati, Shahrisabz shahri, Ipak yo'li ko'chasi, 140-uy. Veb-sayt: www.natureareas.uz
UZ,
                'content_ru' => <<<'RU'
Заповедник расположен в юго-западных частях Памиро-Гиссарского хребта — в среднегорном и высокогорном поясе Алайского хребта. Расположен в бассейнах рек Оксув, Танхоздарья и Кызылсув на высоте 1800-4421 метров над уровнем моря, на территории Шахрисабзского, Яккабогского и Камашинского районов Кашкадарьинской области, граничит с Таджикистаном на востоке и Сурхандарьинской областью на юго-востоке.

Общая площадь заповедника 80 986,1 га, из них буферная зона 13 231,1 га. В заповеднике имеются объекты экотуризма и культурного наследия, привлекающие иностранных и отечественных туристов.

Природные условия: В горных отложениях часто встречаются палеозойские породы. Высота горных вершин достигает 4421 м: Ходжа Киршавор — 4303 м, Торткуйлюк — 4366 м, гора Хазрат Султан — 4367 м, Биби Улмас — 4487 м. С вечных ледников этих гор начинаются Топалангдарья и Аксударья. Ледник Батирбай имеет площадь в 1600 га.

Большинство рек начинаются от ледников Северцева и Ботирбоя (3155 га). Крупнейшие реки — Оксув, Танхоз и Кызылдарья. Самый высокий водопад — «Сувтушар» высотой 84 м. На территории заповедника расположено около 10 больших и малых озёр.

Флора: Выявлено 71 семейство растений, 1298 видов.

Фауна: 276 видов позвоночных. 32 вида млекопитающих (снежный барс, бурый медведь, туркестанский рысь, среднеазиатский бобр, красный сурок, кабан, сибирский горный козёл, дикобраз, ласка, барсук и др.), 225 видов птиц, 17 видов пресмыкающихся, 2 вида земноводных. 17 видов редких животных и птиц занесены в «Красную книгу» Республики Узбекистан и «Красный список» МСОП.

Объекты экотуризма: Плато Хазрати Султан, водопад Сувтушар, тропы динозавров и пещера Амира Темура — охраняемые зоны. На Геланском участке буферной зоны строятся объекты паломнического туризма (кемпинги, юрты, объекты питания, места для селфи). Вокруг водопада «Сувтушар» (буферный участок «Мираки») построен экотуристический центр.

Среди крупных населённых пунктов вблизи заповедника — Пенджикентский район Республики Таджикистан, Узунский, Сариосийский районы Сурхандарьинской области, а также сёла Коль, Гелон, Сарчашма, Хисорак, Тамшуш, Сувтушар, Сайод, Башкаб, Оммоган, Китай, Алматы и др.

Заповедник расположен в 170-200 км от райцентра Карши.

Время посещения: Будние дни с 12:00 до 20:00 (до 17:00 в зимнее время). Выходные и праздничные дни с 09:00 до 21:00 (до 17:00 в зимнее время).

Адрес: Кашкадарьинская область, г. Шахрисабз, ул. Ипак ёли, 140. Веб-сайт: www.natureareas.uz
RU,
                'content_en' => <<<'EN'
The reserve is located in the southwest of the Pamir-Alai mountain range, in the middle and high mountain belts of the Alai range. It is situated in the basins of the Oxus, Tankhozdarya, and Kyzylsuv rivers, at 1800-4421 meters above sea level, within the Shakhrisabz, Yakkabog, and Kamashin districts of Kashkadarya region. It borders Tajikistan to the east and Surkhandarya region to the southeast.

The total area is 80,986.1 hectares, including a buffer zone of 13,231.1 hectares. The reserve features ecotourism and cultural heritage sites that attract both foreign and domestic tourists.

Natural conditions: Mountain formations frequently consist of Paleozoic rocks. Peaks reach up to 4,421 m, including Hodge Kirshavor (4,303 m), Tortkulyuk (4,366 m), Hazrat Sultan (4,367 m), and Bibi Ulmas (4,487 m). The eternal glaciers give rise to Topalangdarya and Aksudarya. The Batirbay glacier covers 1,600 hectares.

Most rivers originate from the Severtsev and Botirboy glaciers (3,155 ha). The largest rivers are Oxus, Tankhoz, and Kyzyl-Darya. The region's tallest waterfall, "Suvdushar", stands at 84 meters — one of the tallest in the country. About 10 large and small lakes are within the reserve.

Flora: 1,298 plant species belonging to 71 families.

Fauna: 276 species of vertebrate animals, including 32 mammal species (snow leopard, brown bear, Turkestan lynx, Central Asian beaver, red marmot, wild boar, Siberian ibex, porcupine, marten, badger, etc.), 225 bird species, 17 reptile species, 2 amphibian species. 17 rare species are listed in the Red Book of Uzbekistan and the IUCN Red List.

Ecotourism: The Hazrat Sultan plateau, Suvdushar waterfall, dinosaur trails, and Amir Temur cave are protected areas. Pilgrimage tourism facilities are being built in the Gelan buffer zone (campgrounds, yurts, dining facilities, selfie spots). An ecotourism centre has been built around the Suvdushar waterfall in the "Miraki" buffer area.

Major nearby settlements include the Pendjikent district of Tajikistan, Uzun and Sariosiy districts of Surkhandarya, and villages such as Kol, Gelon, Sarchashma, Hisorak, Tamshush, Suvdushar, Sayod, Bashkab, Ommogan, Kitay, and Almaty.

The reserve is 170-200 km from the district centre of Karshi.

Visit time: Weekdays from 12:00 to 20:00 in summer (until 17:00 in winter). Weekends and holidays from 09:00 to 21:00 (until 17:00 in winter).

Address: 140 Ipak Yoli Street, Shakhrisabz city, Kashkadarya region. Website: www.natureareas.uz
EN,
                'features_uz' => [
                    'Umumiy maydoni 80 986 ga',
                    "1298 tur o'simlik (71 oila)",
                    "Qor qoploni, qo'ng'ir ayiq, sibir tog' echkisi",
                    'Suvtushar sharsharasi — 84 m',
                ],
                'features_ru' => [
                    'Площадь 80 986 га',
                    '1298 видов растений (71 семейство)',
                    'Снежный барс, бурый медведь, сибирский козёл',
                    'Водопад Сувтушар — 84 м',
                ],
                'features_en' => [
                    'Total area 80,986 ha',
                    '1,298 plant species (71 families)',
                    'Snow leopard, brown bear, Siberian ibex',
                    'Suvdushar waterfall — 84 m',
                ],
                'stat_area'      => '80 986 ga',
                'stat_species'   => '1298 tur',
                'stat_protected' => '17 nodir tur',
                'latitude'       => 39.0500,
                'longitude'      => 67.2500,
                'image'          => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1600&h=900&fit=crop',
                'featured'       => true,
            ],

            // 4. QIZILQUM
            [
                'slug'     => 'qizilqum-davlat-qoriqxonasi',
                'title_uz' => '"Qizilqum" davlat qo\'riqxonasi',
                'title_ru' => 'Государственный заповедник "Кызылкум"',
                'title_en' => 'State Reserve "Kyzylkum"',
                'excerpt_uz' => 'Amudaryo o\'rta oqimi va Janubi-G\'arbiy Qizilqum cho\'lining bir qismini o\'z ichiga oluvchi cho\'l-to\'qay qo\'riqxonasi. 10 311 ga maydon, 266 tur qush, 47 tur Qizil kitobda.',
                'excerpt_ru' => 'Пустынно-тугайный заповедник на среднем течении Амударьи и в Юго-Западном Кызылкуме. Площадь 10 311 га, 266 видов птиц, 47 видов в Красной книге.',
                'excerpt_en' => 'Desert-tugai reserve in the middle reaches of the Amu Darya and Southwest Kyzylkum desert. Area 10,311 ha, 266 bird species, 47 species in the Red Book.',
                'content_uz' => <<<'UZ'
"Qizilqum" davlat qo'riqxonasi dengiz sathidan 150 metrdan 180 metrgacha balandlikdagi hududni o'z ichiga oladi. Amudaryoning o'rta oqimida daryo o'zaning chetida hamda Janubi-G'arbiy Qizilqum cho'lining kichik bir qismida joylashgan.

Qo'riqxonaning umumiy yer maydoni 10 311 gektardan iborat bo'lib, ikki viloyat hududida joylashgan: 8 844 ga Xorazm viloyatining Tuproqqala tumanida, 1 467 ga Buxoro viloyatining Romitan tumanida. Umumiy yer maydonining 7 134 gektari Qizilqum cho'l zonasi va 3 177 gektari Amudaryo o'zani qirg'og'idagi to'qay zonasidan iborat.

Tabiiy sharoiti: Iqlimi cho'l iqlimi bo'lib, juda quruq havo hukm suradi. Yoz faslida harorat +40°C, +47°C gacha ko'tariladi, qish faslida -20°C, -25°C gacha pasayadi. Yog'ingarchilik asosan bahor faslida kuzatiladi. Hudud keskin kontinental, issiqlik va yorug'likning ko'p tushishi, qurg'oqchil xarakterdaligi bilan ajralib turadi. Tuproq qatlamining asosiy qismi jigarrang-karbonatli xususiyatga egadir.

Florasi: 275 turdan ortiq o'simliklar aniqlangan bo'lib, shundan 4 turi O'zbekiston "Qizil kitobi"ga kiritilgan.

Faunasi: Umurtqali hayvonlardan 37 tur sutemizuvchilar, 266 tur qushlar, 29 tur sudralib yuruvchilar, 2 tur suvda va quruqlikda yashovchilar, 25 tur baliqlar uchraydi. O'zbekiston "Qizil kitobi"ga sutemizuvchilarning 8 turi, qushlarning 32 turi, sudralib yuruvchilarning 3 turi, baliqlarning 8 turi kiritilgan.

Hudud qo'shni Turkmaniston Respublikasi bilan to'liqligicha davlat chegarasi zonasida joylashgan. Xorazm viloyati markazi Urganch shahridan 220 km, Buxoro viloyati markazi Buxoro shahridan 250 km uzoqlikda joylashgan. Eng yaqin aholi punktlari — sharqda 5 km uzoqlikda Qizil Ravot qishlog'i, g'arbiy-shimolda 15 km uzoqlikda Tuproqqala qishlog'i.

Tashrif vaqti: Ish kunlari soat 12:00 dan 20:00 gacha (qishda 17:00 gacha). Dam olish va bayram kunlari soat 09:00 dan 21:00 gacha (qishda 17:00 gacha).

Manzil: Buxoro viloyati, Romitan tumani, Qizil Ravot qishlog'i.
UZ,
                'content_ru' => <<<'RU'
Территория Государственного заповедника «Кызылкум» находится на высоте от 150 до 180 метров над уровнем моря. В среднем течении Амударьи находится небольшая часть речной поймы и пустыни Юго-Западный Кызылкум.

Общая площадь заповедника составляет 10 311 га, из них 8 844 га — в Тупроккалинском районе Хорезмской области, 1 467 га — в Ромитанском районе Бухарской области. На Кызылкумскую пустынную зону приходится 7 134 га, и 3 177 га — тугайная зона на берегу Амударьинской долины.

Природные условия: Климат заповедника резко континентальный, летом достигает +47°C, зимой снижается до -25°C. Осадки наблюдаются преимущественно весной. За пределами территории заповедника распространены преимущественно типичные серозёмы.

Флора: Выявлено 275 видов растений, из них 4 вида включены в Красную книгу Республики Узбекистан.

Фауна: К настоящему времени обнаружено 37 видов млекопитающих, 266 видов птиц, 29 видов рептилий, 2 вида земноводных, 25 видов рыб. В «Красную книгу» Республики Узбекистан занесены 8 видов млекопитающих, 32 вида птиц, 3 вида рептилий и 8 видов рыб.

Заповедник граничит с Республикой Туркменистан и находится на расстоянии 220 км от Ургенча и 250 км от Бухары. Ближайшие населённые пункты — село Кызыл Равот в 5 км на восток и село Тупроккала Хорезмской области в 15 км на северо-запад.

Время посещения: Будние дни с 12:00 до 20:00 (до 17:00 в зимнее время). Выходные и праздничные дни с 09:00 до 21:00 (до 17:00 в зимнее время).

Административное здание заповедника расположено в селе Кызыл Равот Ромитанского района Бухарской области.
RU,
                'content_en' => <<<'EN'
The territory of the State Reserve "Kyzylkum" is situated at an elevation of 150 to 180 meters above sea level. It encompasses a small portion of the river floodplain and the Southwest Kyzylkum Desert in the middle reaches of the Amu Darya.

The total area is 10,311 hectares, with 8,844 ha in Tuprokkala district of Khorezm region and 1,467 ha in Romitan district of Bukhara region. The Kyzylkum desert zone covers 7,134 hectares, while 3,177 hectares form the riparian (tugai) zone along the Amu Darya valley.

Natural conditions: The climate is sharply continental, with summer temperatures reaching +47°C and winter lows of -25°C. Precipitation occurs mainly in spring. Outside the reserve, typical grey-brown soils prevail.

Flora: 275 plant species have been identified, including 4 species listed in the Red Book of the Republic of Uzbekistan.

Fauna: To date, 37 mammal species, 266 bird species, 29 reptile species, 2 amphibian species, and 25 fish species have been recorded. The Red Book includes 8 mammal species, 32 bird species, 3 reptile species, and 8 fish species.

The reserve borders Turkmenistan and is located 220 km from Urgench and 250 km from Bukhara. The nearest settlements are Kyzyl Ravot village (5 km east) and Tuprokkala village in Khorezm region (15 km northwest).

Visit time: Weekdays from 12:00 to 20:00 in summer (until 17:00 in winter). Weekends and holidays from 09:00 to 21:00 (until 17:00 in winter).

Address: The administrative building is located in Kyzyl Ravot village, Romitan district, Bukhara region.
EN,
                'features_uz' => [
                    'Umumiy maydoni 10 311 ga',
                    "275 tur o'simlik, 47 ta Qizil kitobda",
                    '266 tur qush, 37 sutemizuvchi',
                    "Cho'l + to'qay zonalari",
                ],
                'features_ru' => [
                    'Площадь 10 311 га',
                    '275 видов растений, 47 в Красной книге',
                    '266 видов птиц, 37 млекопитающих',
                    'Пустыня + тугайные леса',
                ],
                'features_en' => [
                    'Total area 10,311 ha',
                    '275 plant species, 47 in Red Book',
                    '266 bird species, 37 mammals',
                    'Desert + tugai (riparian) zones',
                ],
                'stat_area'      => '10 311 ga',
                'stat_species'   => '275 tur',
                'stat_protected' => '47 nodir tur',
                'latitude'       => 41.7900,
                'longitude'      => 60.7600,
                'image'          => 'https://images.unsplash.com/photo-1527824404775-dce343118ebc?w=1600&h=900&fit=crop',
                'featured'       => false,
            ],

            // 5. SURXON
            [
                'slug'     => 'surxon-davlat-qoriqxonasi',
                'title_uz' => '"Surxon" davlat qo\'riqxonasi',
                'title_ru' => 'Государственный заповедник "Сурхан"',
                'title_en' => 'State Reserve "Surkhan"',
                'excerpt_uz' => "Ko'hitang tog' tizmasining sharqiy yonbag'irlarida (850-3137 m), Sherobod tumanida joylashgan. 23 406 ga, Morxo'r va Buxoro tog' qo'yi, Zaravutsoy ekoturizm maskani.",
                'excerpt_ru' => 'Заповедник на восточных склонах хребта Кохитанг (850-3137 м), в Шерабадском районе. Площадь 23 406 га, винторогий козёл и бухарский баран, экотуризм Заравутсай.',
                'excerpt_en' => 'Reserve on the eastern slopes of the Kohitang range (850-3137 m), in Sherabad district. 23,406 ha, markhor and Bukhara urial, Zaravutsay ecotourism site.',
                'content_uz' => <<<'UZ'
"Surxon" davlat qo'riqxonasi Ko'hitang tog' tizmasining sharqiy yonbag'irlarida joylashgan. Dengiz sathidan 850-3137 metr balandlikdagi hududni o'z ichiga oladi. Surxondaryo viloyatining Sherobod tumani hududida joylashgan bo'lib, g'arbdan Turkmaniston Respublikasi bilan chegaradosh.

Umumiy maydoni 23 406,4 gektar bo'lib, qo'riqlanma (bufer) hududi 17 090,6 gektarni tashkil etadi. Qo'riqxonada xorijiy va mahalliy sayyohlarni o'ziga rom etadigan Zaravutsoy ekoturizm maskani mavjud.

Tabiiy sharoiti: Tog' yotqiziqlari ichida paleozoy jinslari ko'p uchraydi. Cho'qqilarning balandligi 1700 m dan 3137 m gacha — Ayribobo cho'qqisi 3137 m. Aksariyat daryolar va soylar tog' tepasidagi qor va buloqlardan boshlanadi. Eng yirik soylar — Kampirtepa, Sherjon va Tangidarasoy. Ularning o'zanlarida sharsharalar mavjud, eng baland sharshara "Machillisoy" 12-13 m.

Florasi: 80 oila, 378 turkumga mansub 807 tur o'simlik aniqlangan.

Faunasi: 194 tur umurtqali hayvon. Sutemizuvchilarning 26 turi (Morxo'r, Buxoro tog' qo'yi, Turkiston silovsini, Yovvoyi cho'chqa, Olaqo'zan, Jayra, Tog' suvsari, Bo'rsiq), qushlarning 137 turi, sudralib yuruvchilarning 24 turi, suvda va quruqlikda yashovchilarning 2 turi. 25 tur hayvon O'zbekiston "Qizil kitobi"ga, 18 turi TMXI "Qizil ro'yxati"ga kiritilgan.

Ekoturizm maskanlari: Buffer hududda 395,6 ga maydonida Zaravutsoy ekoturizm maskani tashkil qilingan. Qizilolma bo'limidagi "Zaravutsoy" hududida turizm uchun xizmatlar va obyektlar (kempinglar, o'tovlar, dam olish va ovqatlanish joylari, selfi nuqtalari, ekomarshrutlar, anshlaglar, panagohlar) qurilmoqda.

Yirik aholi punktlari — Sherobod tumanining Xomkon, Tangi, Xatak, Xo'janqo, Qizilolma, Shalqon, Kampirtepa, Sherjon, Vandob, Tuzkon qishloqlari. Sherobod tumani markazida mehmonxonalar mavjud (qo'riqxonadan 50-60 km). Qo'riqxona Termizdan 120-130 km, tuman markazidan 50-70 km masofada joylashgan.

Tashrif vaqti: Ish kunlari soat 12:00 dan 20:00 gacha (qishda 17:00 gacha). Dam olish va bayram kunlari soat 09:00 dan 21:00 gacha (qishda 17:00 gacha).

Manzil: Surxondaryo viloyati, Sherobod shahri, Ogahiy ko'chasi, 1-uy. Veb-sayt: www.natureareas.uz
UZ,
                'content_ru' => <<<'RU'
Государственный заповедник «Сурхан» площадью 23 406,4 га расположен на восточных склонах горного хребта Кохитанг, на высоте 850-3137 метров над уровнем моря. Расположен в Шерабадском районе Сурхандарьинской области, граничит с Туркменистаном на западе. Заповедная (буферная) территория составляет 17 090,6 га.

В заповеднике расположена экотуристическая зона Заравутсай, привлекающая иностранных и отечественных туристов.

Природные условия: В горных ущельях встречаются палеозойские породы. Высота горных вершин достигает 3137 м (пик Айрибобо). Большинство рек и ручьёв заповедника берут начало с снежных вершин и источников. Крупнейшие ручьи — Кампиртепа, Шерджан и Тангидарасай. Самый высокий водопад — «Мачиллисай» (13 м).

Флора: Растительный мир состоит из 80 семейств, включающих 807 видов.

Фауна: 194 вида позвоночных животных. 26 видов млекопитающих (Винторогий козёл, Бухарский горный баран, Туркестанская рысь, Дикий кабан, Перевязка, Дикобраз, Горная выдра, Барсук и др.), 137 видов птиц, 24 вида рептилий, 2 вида водно-наземных обитателей, 25 видов краснокнижных животных.

Экотуристические места: На участке Кизилолма создана экотуристическая зона Заравутсай площадью 395,6 га. Здесь ведутся работы по строительству объектов сервиса и туризма (кемпинги, юрты, зоны отдыха, общественного питания, площадки для селфи, экомаршруты, стоянки).

К заповеднику примыкают сёла Хомкон, Танги, Хатак, Ходжанго, Кызылолма, Шалкан, Кампиртепа, Шерджан, Вандоб, Тузкон Шерабадского района. Гостиницы расположены в центре Шерабадского района (50-60 км от заповедника). Заповедник в 120-130 км от Термеза и 50-70 км от райцентра.

Время посещения: Будние дни с 12:00 до 20:00 (до 17:00 в зимнее время). Выходные и праздничные дни с 09:00 до 21:00 (до 17:00 в зимнее время).

Адрес: Сурхандарьинская область, г. Шерабад, ул. Огахи, 1. Веб-сайт: www.natureareas.uz
RU,
                'content_en' => <<<'EN'
The Surkhan State Reserve, covering 23,406.4 hectares, is located on the eastern slopes of the Kohitang mountain range at 850-3,137 meters above sea level. Situated in the Sherabad district of Surkhandarya region, it borders Turkmenistan to the west. The protected (buffer) zone covers 17,090.6 hectares.

The reserve features the Zaravutsay ecotourism hub, attracting both international and domestic visitors.

Natural conditions: Paleozoic rock formations are common. Peaks reach up to 3,137 meters (Ayribobo summit). Most rivers and streams originate from snowmelt and high-altitude springs. Major streams include Kampirtepa, Sherjan, and Tangidarasay. The tallest waterfall is "Machillisoy" at 13 meters.

Flora: 807 plant species across 80 families.

Fauna: 194 vertebrate species, including 26 mammal species (Markhor, Bukhara urial, Turkestan lynx, wild boar, Marbled polecat, porcupine, mountain otter, badger, etc.), 137 bird species, 24 reptile species, 2 amphibian species, and 25 species classified as endangered.

Ecotourism sites: A 395.6-hectare Zaravutsay ecotourism area has been developed in the buffer zone. Facilities under construction include campgrounds, yurts, dining areas, selfie spots, eco-trails, parking areas, and shelters.

Adjacent settlements include Khomkon, Tangi, Khatak, Khojanqo, Kyzilolma, Shalqon, Kampirtepa, Sherjan, Vandob, and Tuzkon villages of Sherabad district. Hotels are available in Sherabad district centre (50-60 km from the reserve). The reserve is 120-130 km from Termez and 50-70 km from the district centre.

Visit time: Weekdays from 12:00 to 20:00 in summer (until 17:00 in winter). Weekends and holidays from 09:00 to 21:00 (until 17:00 in winter).

Address: 1 Ogahi Street, Sherabad city, Surkhandarya region. Website: www.natureareas.uz
EN,
                'features_uz' => [
                    'Umumiy maydoni 23 406 ga',
                    "807 tur o'simlik (80 oila)",
                    "Morxo'r, Buxoro tog' qo'yi",
                    "Zaravutsoy ekoturizm maskani",
                ],
                'features_ru' => [
                    'Площадь 23 406 га',
                    '807 видов растений (80 семейств)',
                    'Винторогий козёл, бухарский баран',
                    'Экотуристическая зона Заравутсай',
                ],
                'features_en' => [
                    'Total area 23,406 ha',
                    '807 plant species (80 families)',
                    'Markhor, Bukhara urial',
                    'Zaravutsay ecotourism site',
                ],
                'stat_area'      => '23 406 ga',
                'stat_species'   => '807 tur',
                'stat_protected' => '25 nodir tur',
                'latitude'       => 37.9000,
                'longitude'      => 67.0500,
                'image'          => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1600&h=900&fit=crop',
                'featured'       => false,
            ],

            // 6. CHOTQOL (biosfera)
            [
                'slug'     => 'chotqol-davlat-biosfera-qoriqxonasi',
                'title_uz' => '"Chotqol" davlat biosfera qo\'riqxonasi',
                'title_ru' => 'Чаткальский государственный биосферный заповедник',
                'title_en' => 'Chatkal State Biosphere Reserve',
                'excerpt_uz' => "G'arbiy Tyan-Shanning Chotqol tog' tizmasida (1500-3900 m), Bo'stonliq tumanida joylashgan biosfera qo'riqxonasi. 24 706 ga, qor qoploni va Menzbir sug'uri.",
                'excerpt_ru' => 'Биосферный заповедник на Чоткальском хребте Западного Тянь-Шаня (1500-3900 м), Бостанлыкский район. 24 706 га, снежный барс и сурок Мензбира.',
                'excerpt_en' => 'Biosphere reserve on the Chatkal range of Western Tian-Shan (1500-3900 m), Bostanlyk district. 24,706 ha, snow leopard and Menzbier\'s marmot.',
                'content_uz' => <<<'UZ'
Chotqol davlat biosfera qo'riqxonasi G'arbiy Tyan-Shanning g'arbiy va shimoliy yonbag'irlarida — Chotqol tog' tizmasida joylashgan. Toshkent viloyati, Bo'stonliq tumani hududida dengiz sathidan 1500 m dan 3900 m gacha balandlikda joylashgan bo'lib, shimol va shimoliy g'arbdan Buruchmullo o'rmon xo'jaligi, janubiy sharqdan Oxangaron tumani, sharqdan esa Namangan viloyatining Chortoq tumani bilan chegaradosh.

Qo'riqxona umumiy maydoni 24 706 gektarni tashkil etadi. Ma'muriy binosi Toshkent shahridan 35 km uzoqlikda, qo'riqxona hududi esa Parkent tumanidan 70 km uzoqlikda joylashgan.

Tabiiy sharoiti: Qo'riqxonaning Turon iqlimiy rayoniga mansub bo'lgan, subtropik mintaqadan mo'tadil mintaqaga o'tish zonasida joylashishi — qo'riqxona iqlimini belgilovchi asosiy omildir. Qo'riqxona hududi kenglikda joylashganligi sababli ko'p miqdorda quyosh radiatsiyasini oladi (yiliga 135 kkal/sm² ga yaqin).

Florasi: Yuksak o'simliklarning 70 oilasiga mansub 770 tur va kenja tur aniqlangan, shundan 25 turi O'zbekiston "Qizil kitobi"ga kiritilgan.

Faunasi: 166 tur umurtqali hayvon uchraydi. Sutemizuvchilarning 29 turi, qushlarning 124 turi, sudralib yuruvchilarning 6 turi, amfibiyalarning 1 turi va baliqlarning 6 turi, jami umurtqasizlarning 1000 dan ortiq turi aniqlangan.

O'zbekiston "Qizil kitobi"ga kiritilgan noyob hayvon va qushlar 20 turni tashkil etadi. Shulardan 2 turi — Qor qoploni (Panthera uncia) va Menzbir sug'uri (Marmota menzbieri) TMXI "Qizil ro'yxati"ga kiritilgan.

Ekoturizm maskanlari: Qo'riqxonada qo'riqlanma hudud mavjud bo'lmaganligi sababli turizm bo'yicha tadbirlar "Tashrif Markazi"ga sayohat orqali tashkil etiladi.

Yaqin aholi punktlari — Parkent tumani Kumushkon qishlog'i (70 km), Oxangaron tumani Ertosh qishlog'i (35 km).

Tashrif vaqti: Ish kunlari soat 12:00 dan 20:00 gacha (qishda 17:00 gacha). Dam olish va bayram kunlari soat 09:00 dan 21:00 gacha (qishda 17:00 gacha).
UZ,
                'content_ru' => <<<'RU'
Чаткальский государственный биосферный заповедник расположен на западных и северных склонах Чоткальского хребта Западного Тянь-Шаня. Заповедник расположен в Бостанлыкском районе Ташкентской области на высоте от 1500 до 3900 метров над уровнем моря. Граничит на севере и северо-западе с Буручмуллинским лесничеством, на юго-востоке с Охангаронским районом, на востоке с Чартакским районом Наманганской области.

Общая площадь заповедника составляет 24 706 га. Административное здание расположено в 35 км от Ташкента, а территория заповедника — в 70 км от Паркентского района.

Природные условия: Расположение в переходной зоне от субтропического к умеренному региону Туранской климатической области — главный фактор климата. Благодаря широтному расположению территория получает большое количество солнечной радиации (около 135 ккал/см² в год).

Флора: Выявлено 770 видов растений, принадлежащих к 70 семействам высших растений. Из них 25 видов занесены в «Красную книгу» Республики Узбекистан.

Фауна: 166 видов позвоночных. 29 видов млекопитающих, 124 вида птиц, 6 видов рептилий, 1 вид земноводных, 6 видов рыб, более 1000 видов беспозвоночных.

В «Красную книгу» Республики Узбекистан занесено 20 видов редких животных и птиц. 2 из них — снежный барс (Panthera uncia) и сурок Мензбира (Marmota menzbieri) — занесены в «Красный список» МСОП.

Объекты экотуризма: Поскольку охраняемой территории как таковой нет, для туристической деятельности организуется поездка в «Визит-центр».

Близкие населённые пункты — село Кумушкон Паркентского района (70 км), село Эртош Охангаронского района (35 км).

Время посещения: Будние дни с 12:00 до 20:00 (до 17:00 в зимнее время). Выходные и праздничные дни с 09:00 до 21:00 (до 17:00 в зимнее время).
RU,
                'content_en' => <<<'EN'
Chatkal State Biosphere Reserve is located on the western and northern slopes of the Chatkal Range of the Western Tien Shan. The reserve is in the Bostanlyk District of Tashkent Region at 1,500-3,900 meters above sea level. It borders the Buruchmulinsky Forestry to the north and northwest, the Okhangaron District to the southeast, and the Chartak District of Namangan Region to the east.

The total area is 24,706 hectares. The administrative building is 35 km from Tashkent, and the reserve area itself is 70 km from Parkent District.

Natural conditions: Located in the transitional zone from subtropical to temperate regions of the Turanian climatic region — the main climatic factor. Due to its latitudinal position, the reserve receives high solar radiation (~135 kcal/cm²/year).

Flora: 770 plant species belonging to 70 families of higher plants. 25 species are listed in the Red Book of Uzbekistan.

Fauna: 166 vertebrate species, including 29 mammal species, 124 bird species, 6 reptile species, 1 amphibian species, 6 fish species, and over 1,000 invertebrate species.

20 rare animal and bird species are listed in the Red Book of Uzbekistan. Two of them — the snow leopard (Panthera uncia) and Menzbier's marmot (Marmota menzbieri) — are also listed in the IUCN Red List.

Ecotourism: Since there is no separate protected area, tourist activities are organised through visits to the "Visitor Centre".

Nearby settlements: Kumushkon village in Parkent District (70 km) and Ertosh village in Okhangaron District (35 km).

Visit time: Weekdays from 12:00 to 20:00 in summer (until 17:00 in winter). Weekends and holidays from 09:00 to 21:00 (until 17:00 in winter).
EN,
                'features_uz' => [
                    'Umumiy maydoni 24 706 ga',
                    "770 tur o'simlik (70 oila)",
                    "Qor qoploni, Menzbir sug'uri",
                    "G'arbiy Tyan-Shan biosfera qo'riqxonasi",
                ],
                'features_ru' => [
                    'Площадь 24 706 га',
                    '770 видов растений (70 семейств)',
                    'Снежный барс, сурок Мензбира',
                    'Биосферный заповедник Зап. Тянь-Шаня',
                ],
                'features_en' => [
                    'Total area 24,706 ha',
                    '770 plant species (70 families)',
                    "Snow leopard, Menzbier's marmot",
                    'Western Tian-Shan Biosphere Reserve',
                ],
                'stat_area'      => '24 706 ga',
                'stat_species'   => '770 tur',
                'stat_protected' => '20 nodir tur',
                'latitude'       => 41.6500,
                'longitude'      => 70.3000,
                'image'          => 'https://images.unsplash.com/photo-1474511320723-9a56873867b5?w=1600&h=900&fit=crop',
                'featured'       => true,
            ],

            // 7. OQTOG'-TOMDI
            [
                'slug'     => 'oqtog-tomdi-davlat-qoriqxonasi',
                'title_uz' => '"Oqtog\'-Tomdi" davlat qo\'riqxonasi',
                'title_ru' => 'Государственный заповедник "Актаг-Тамди"',
                'title_en' => 'State Reserve "Aktag-Tamdi"',
                'excerpt_uz' => "2022-yilda tashkil etilgan eng yangi qo'riqxona. Navoiy viloyati Tomdi tumanida, Shimoliy-sharqiy cho'lda. 40 000 ga maydon, jayron va saksavul cho'llari.",
                'excerpt_ru' => 'Самый молодой заповедник, создан в 2022 году. Тамдинский район Навоийской области, северо-восточная пустыня. 40 000 га, джейраны и саксаульные пустыни.',
                'excerpt_en' => 'The newest reserve, established in 2022. Tamdi district, Navoi region, northeastern desert. 40,000 ha, goitered gazelles and saxaul desert ecosystems.',
                'content_uz' => <<<'UZ'
"Oqtog'-Tomdi" davlat qo'riqxonasi 2022-yilda tashkil etilgan bo'lib, qo'riqxonani tashkil qilishdan ko'zlangan maqsad — Respublikamizning Shimoliy-sharqiy cho'lining kichik bir qismida mavjud bo'lgan betakror tabiiy bioxilma-xillikni saqlab qolish.

Qo'riqxonada o'rganilayotgan tabiiy resurslarga boy va mavjud tashkil topgan to'qayzor o'rmonlar hamda qumli cho'ldagi turli bir yillik (efemer) va ko'p yillik (efemeroid) o'simliklar kiradi.

"Oqtog'-Tomdi" davlat qo'riqxonasi Navoiy viloyati Tomdi tumani markazidan 216 km uzoqlikda Respublikamizning Shimoliy-sharqida joylashgan. Umumiy maydoni 40 000 ga teng. Hududning asosiy maydoni cho'l hududida joylashgan bo'lib, Qozog'iston Respublikasi hududiga chegaradosh.

Tabiiy sharoiti: Qo'riqxona hududi butunlay Tomdi ma'muriy hududi chegarasida. Hududi Nurota tizmasining shimoliy yonbag'rida, 530-2069 m balandliklarda, janubi-sharqdan shimoli-g'arbiy tomonga cho'zilgan yagona yer uchastkasi bilan ifodalanadi. Markaziy idorasi qo'riqlanadigan hududdan 216 km uzoqlikda joylashgan.

Florasi: Cho'l muhitidan tashkil topgani bois 75 turdan ortiq o'simlik uchraydi. Eng ko'p tarqalgan turlar: Qora saksovul, oq saksovul, Cherkez, 3 tur qandimlar, qo'ng'irbosh, mayin shuvoq, qo'ziquloq, karrak, lola qizg'aldoq, andiz, shirach, yovvoyi piyoz va boshqalar. Mintaqadagi o'simliklarning ko'pchiligi efemer bo'lib, qurg'oqchil faslda qurib qoladi.

Faunasi: 11 tur sutemizuvchilar, 12 tur qushlar, 4 tur sudralib yuruvchilar uchraydi. Yovvoyi cho'chqa, jayron, tulki, qum quyon, oddiy dala sichqoni, kursichqon, sariq kalamush, chol burgut, kaklik, tasqara, kichik burgut, oq boshli qumoy, ukki, kichik boyqush, ko'k kaptar, dasht turg'ay kabi qushlar; sudralib yuruvchilardan O'rta Osiyo toshbaqasi, Turkiston gekkoni, Echkiemar, dasht agamasi, oq ilon kabi turlar mavjud. Noyob hayvonlardan 4 tur O'zbekiston Respublikasi va Markaziy Osiyo hududi uchun endemik turlar hisoblanadi.

Qo'riqxona atrofiga yaqin mehmonxona mavjud emas. Qo'riqxona Tomdi tumanidan 280 km masofada joylashgan.

Tashrif vaqti: Ish kunlari soat 12:00 dan 20:00 gacha (qishda 17:00 gacha). Dam olish va bayram kunlari soat 09:00 dan 21:00 gacha (qishda 17:00 gacha).
UZ,
                'content_ru' => <<<'RU'
Государственный заповедник «Актаг-Тамди» создан в 2022 году с целью сохранения уникального природного биоразнообразия, существующего на небольшой части северо-восточной пустыни Республики.

Биоразнообразие, изучаемое в заповеднике, включает тугайные леса, различные однолетние (эфемерные) и многолетние (эфемероидные) растения песчаной пустыни.

Заповедник расположен на северо-востоке Республики, в 216 км от центра Тамдинского района Навоийской области. Общая площадь — 40 000 га. Основная территория заповедника представляет собой пустынную среду, богатую природными ресурсами, флорой и фауной. Заповедник граничит с территорией Республики Казахстан.

Природные условия: Территория полностью находится в границах Тамдинского административного района и представлена единым участком на северном склоне хребта Нурата, на высотах 530-2069 м, простирающимся с юго-востока на северо-запад. Административное здание расположено в 216 км от заповедника.

Флора: Поскольку территория представляет собой пустынную среду, она не богата растительностью; здесь встречается более 75 видов. Наиболее распространённые виды — чёрный и белый саксаулы, черкез, 3 вида джузгуна, мятлик, полыни, зопник мрачный, кузиния, тюльпан, девясил, эремурус, дикий лук и другие. Многие растения являются однолетними и в жаркий сезон высыхают.

Фауна: 11 видов млекопитающих, 12 видов птиц, 4 вида рептилий. Фауна включает дикого кабана, джейрана, лисицу, песчаного зайца, обыкновенную полёвку, летучих мышей, жёлтую крысу; птиц — белоголового сипа, куропатку, чёрного грифа, жёлтого воробья, орла-карлика, стервятника, обыкновенную сову, сизого голубя, степную куропатку, дрофу-красотку, жаворонка обыкновенного и степного; рептилий — среднеазиатскую черепаху, туркестанского геккона, гладкого геккона, варана, степную агаму, белую змею. 4 вида редких животных эндемичны для всей территории Центральной Азии.

В окрестностях заповедника нет гостиниц. Заповедник расположен в 280 км от Тамдинского района.

Время посещения: Будние дни с 12:00 до 20:00 (до 17:00 в зимнее время). Выходные и праздничные дни с 09:00 до 21:00 (до 17:00 в зимнее время).

Адрес: Навоийская область, Тамдинский район, посёлок «Тамдыбулак», ул. Базар Джираи, 10.
RU,
                'content_en' => <<<'EN'
The Aktag-Tamdi State Reserve was established in 2022 to preserve the unique natural biodiversity in a small part of the northeastern desert of the Republic.

The biodiversity studied includes tugai forests and various annual (ephemeral) and perennial (ephemeroid) plants of the sandy desert.

The reserve is located in the northeast of the Republic, 216 km from the centre of Tamdi district, Navoi region, with a total area of 40,000 hectares. Most of the reserve is desert environment rich in natural resources, flora, and fauna. It borders the Republic of Kazakhstan.

Natural conditions: The reserve lies entirely within the Tamdi administrative district, represented by a single plot on the northern slope of the Nurata Range, at altitudes of 530-2,069 meters, stretching from southeast to northwest. The administrative building is 216 km from the reserve.

Flora: Being a desert environment, it has limited vegetation — over 75 species. The most common species include black and white saxauls, tamarisk, three species of Calligonum, meadow grass, sage, sour-grass, kuzinia, tulip, devyasil, eremurus, wild onion, and others. Many plants are annual and dry up during the hot season.

Fauna: 11 mammal species, 12 bird species, and 4 reptile species. The fauna includes wild boar, goitered gazelle, fox, sand hare, common vole, bats, yellow rat; birds: griffon vulture, partridge, black vulture, yellow sparrow, booted eagle, Egyptian vulture, common owl, blue pigeon, steppe partridge, houbara bustard, common and steppe larks; reptiles: Central Asian tortoise, Turkestan gecko, smooth gecko, monitor lizard, steppe agama, white snake. 4 rare species are endemic to Central Asia.

There are no hotels near the reserve. The reserve is 280 km from Tamdi district.

Visit time: Weekdays from 12:00 to 20:00 in summer (until 17:00 in winter). Weekends and holidays from 09:00 to 21:00 (until 17:00 in winter).

Address: 10 Bazar Djirai Street, Tamdybulak village, Tamdi district, Navoi region.
EN,
                'features_uz' => [
                    'Umumiy maydoni 40 000 ga',
                    "75+ tur o'simlik (saksavul cho'llari)",
                    'Jayron, kichik burgut, dasht agamasi',
                    '2022-yilda tashkil etilgan',
                ],
                'features_ru' => [
                    'Площадь 40 000 га',
                    '75+ видов растений (саксауловые пустыни)',
                    'Джейран, орёл-карлик, степная агама',
                    'Создан в 2022 году',
                ],
                'features_en' => [
                    'Total area 40,000 ha',
                    '75+ plant species (saxaul desert)',
                    'Goitered gazelle, booted eagle, steppe agama',
                    'Established in 2022',
                ],
                'stat_area'      => '40 000 ga',
                'stat_species'   => '75 tur',
                'stat_protected' => '4 endemik tur',
                'latitude'       => 41.7800,
                'longitude'      => 64.6000,
                'image'          => 'https://images.unsplash.com/photo-1473773508845-188df298d2d1?w=1600&h=900&fit=crop',
                'featured'       => false,
            ],
        ];
    }
}
