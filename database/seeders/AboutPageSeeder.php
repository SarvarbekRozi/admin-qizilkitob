<?php

namespace Database\Seeders;

use App\Models\AboutPage;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = AboutPage::firstOrNew(['id' => 1]);

        $existingHero  = $page->hero_image;
        $existingIntro = $page->intro_image;

        $payload = [
            'hero_title_uz' => 'Biz haqimizda',
            'hero_title_ru' => 'О нас',
            'hero_title_en' => 'About us',

            'hero_subtitle_uz' => 'O\'zbekiston Qizil kitobi — mamlakatimizning noyob va yo\'qolib borayotgan o\'simlik va hayvon turlarini muhofaza qilish bo\'yicha rasmiy hujjat.',
            'hero_subtitle_ru' => 'Красная книга Узбекистана — официальный документ по охране редких и исчезающих видов растений и животных нашей страны.',
            'hero_subtitle_en' => 'The Red Book of Uzbekistan is the official document for the protection of rare and endangered plant and animal species of our country.',

            'hero_image' => $existingHero ?: 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=1920&h=900&fit=crop',

            'intro_title_uz' => 'Tabiatni asrash — kelajak avlodlar uchun mas\'uliyat',
            'intro_title_ru' => 'Сохранение природы — ответственность перед будущими поколениями',
            'intro_title_en' => 'Nature conservation — a responsibility to future generations',

            'intro_description_uz' => <<<'HTML'
<p>O‘zbekiston Respublikasi Qizil kitobi 1983-yilda birinchi marta nashr etilgan bo‘lib, hozirgi kunda 5-nashri amal qiladi. Unga noyob va yo‘qolib ketish xavfi ostida turgan o‘simlik va hayvon turlari kiritilgan.</p>
<p>Qizil kitob — tabiiy boyliklarimizni asrash, ekologik muvozanatni saqlash va kelajak avlodlarga toza tabiatni yetkazib berish yo‘lidagi muhim qadamdir. Bizning vazifamiz — har bir noyob turning hayotini saqlab qolish va ularning yashash muhitini muhofaza qilish.</p>
HTML,
            'intro_description_ru' => <<<'HTML'
<p>Красная книга Республики Узбекистан впервые была издана в 1983 году, в настоящее время действует её 5-е издание. В неё включены редкие и находящиеся под угрозой исчезновения виды растений и животных.</p>
<p>Красная книга — это важный шаг к сохранению наших природных богатств, поддержанию экологического баланса и передаче чистой природы будущим поколениям. Наша задача — сохранить жизнь каждого редкого вида и защитить его среду обитания.</p>
HTML,
            'intro_description_en' => <<<'HTML'
<p>The Red Book of the Republic of Uzbekistan was first published in 1983, and the current 5th edition is in force. It includes rare and endangered species of plants and animals.</p>
<p>The Red Book is an important step toward preserving our natural wealth, maintaining ecological balance, and delivering a pristine nature to future generations. Our mission is to safeguard the life of every rare species and protect its habitat.</p>
HTML,
            'intro_image' => $existingIntro ?: '/images/species/gallery-1.jpg',

            'mission_title_uz' => 'Bizning missiyamiz',
            'mission_title_ru' => 'Наша миссия',
            'mission_title_en' => 'Our mission',
            'mission_text_uz' => 'O\'zbekistonning noyob biologik xilma-xilligini ilmiy asoslangan tarzda hujjatlashtirish, jamoatchilik ongini oshirish va yo\'qolib borayotgan turlarning hayotini saqlab qolish.',
            'mission_text_ru' => 'Научно обоснованное документирование уникального биологического разнообразия Узбекистана, повышение осведомлённости общества и сохранение жизни исчезающих видов.',
            'mission_text_en' => 'To scientifically document Uzbekistan\'s unique biodiversity, raise public awareness, and preserve the lives of endangered species.',

            'vision_title_uz' => 'Bizning maqsadimiz',
            'vision_title_ru' => 'Наше видение',
            'vision_title_en' => 'Our vision',
            'vision_text_uz' => 'O\'zbekistonda hech bir noyob tur yo\'qolib ketmaydigan, har bir fuqaro tabiat himoyasiga hissa qo\'shadigan barqaror ekologik kelajak.',
            'vision_text_ru' => 'Устойчивое экологическое будущее Узбекистана, где ни один редкий вид не исчезает, и каждый гражданин вносит вклад в защиту природы.',
            'vision_text_en' => 'A sustainable ecological future for Uzbekistan where no rare species goes extinct and every citizen contributes to nature protection.',

            'goals_title_uz' => 'Asosiy maqsadlarimiz',
            'goals_title_ru' => 'Наши основные цели',
            'goals_title_en' => 'Our key goals',

            'goals_uz' => [
                'Noyob va yo\'qolib borayotgan o\'simlik va hayvon turlarini hujjatlashtirish',
                'Muhofaza tadbirlarini ishlab chiqish va amalga oshirish',
                'Jamoatchilik orasida ekologik bilim va madaniyatni oshirish',
                'Tabiatni muhofaza qilish bo\'yicha ilmiy tadqiqotlarni qo\'llab-quvvatlash',
                'Xalqaro hamkorlikni kengaytirish va tajriba almashish',
                'Yosh avlodda tabiatga mehr-muhabbat tuyg\'usini tarbiyalash',
            ],
            'goals_ru' => [
                'Документирование редких и исчезающих видов растений и животных',
                'Разработка и реализация природоохранных мероприятий',
                'Повышение экологической грамотности и культуры в обществе',
                'Поддержка научных исследований по охране природы',
                'Расширение международного сотрудничества и обмен опытом',
                'Воспитание у молодого поколения любви к природе',
            ],
            'goals_en' => [
                'Documenting rare and endangered species of plants and animals',
                'Developing and implementing conservation measures',
                'Raising ecological literacy and culture in society',
                'Supporting scientific research on nature conservation',
                'Expanding international cooperation and experience exchange',
                'Cultivating love and care for nature in the younger generation',
            ],

            'stats' => [
                [
                    'value'    => '700+',
                    'label_uz' => 'Noyob turlar',
                    'label_ru' => 'Редких видов',
                    'label_en' => 'Rare species',
                    'icon'     => 'bi-flower3',
                ],
                [
                    'value'    => '40+',
                    'label_uz' => 'Yillik tadqiqot',
                    'label_ru' => 'Лет исследований',
                    'label_en' => 'Years of research',
                    'icon'     => 'bi-journal-bookmark',
                ],
                [
                    'value'    => '14',
                    'label_uz' => 'Davlat qo\'riqxonalari',
                    'label_ru' => 'Гос. заповедников',
                    'label_en' => 'State reserves',
                    'icon'     => 'bi-shield-check',
                ],
                [
                    'value'    => '12',
                    'label_uz' => 'Milliy tabiat bog\'lari',
                    'label_ru' => 'Национальных парков',
                    'label_en' => 'National parks',
                    'icon'     => 'bi-tree',
                ],
            ],

            'show_team' => true,
        ];

        $page->fill($payload)->save();
    }
}
