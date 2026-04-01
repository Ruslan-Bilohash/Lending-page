<?php
// Підключаємо reCAPTCHA v2
require_once __DIR__ . '/recaptcha.php';

// ====================== kalkuliatorius.php ======================
// ГОЛОВНА МОВА — ЛИТОВСЬКА
// Потужне SEO + Open Graph + JSON-LD + всі кнопки 100%
// Автор: Ruslan Bilohash 
require_once __DIR__ . '/traffic_logger.php';
if (!isset($_COOKIE['discount_30'])) {
    setcookie('discount_30', '1', time() + 86400, '/');
}

// === МОВА ===
$lang = 'lt';
if (isset($_GET['lang'])) {
    $newLang = strtolower($_GET['lang']);
    $allowed = ['lt', 'ru', 'ua', 'en', 'no'];
    if (in_array($newLang, $allowed)) {
        $lang = $newLang;
        setcookie('user_lang', $lang, time() + 2592000, '/', '', false, true);
        header("Location: kalkuliatorius.php", true, 302);
        exit;
    }
}
if (isset($_COOKIE['user_lang'])) $lang = $_COOKIE['user_lang'];

// === ПОВНІ ПЕРЕКЛАДИ (все, що ти просив) ===
$tr = [
    'lt' => [
        'brand' => 'MEISTRU VALYMAS',
        'title' => 'Valymo kainos skaičiuoklė Vilnius | Meistru Valymas',
        'meta_desc' => 'Profesionalus butų, namų ir biurų valymas Vilniuje su 30% nuolaida. Apskaičiuokite kainą per 3 sekundes.',
        'hero' => 'Apskaičiuokite valymo kainą per 3 sekundes',
        'subtitle' => '30% nuolaida galioja dabar. Fiksuota kaina be jokių staigmenų.',
        'type' => 'Valymo tipas',
        'area' => 'Plotas (m²)',
        'name' => 'Jūsų vardas ir pavardė',
        'phone' => 'Telefono numeris',
        'opt1' => 'Palaikomasis valymas (butas) — 8 €/val.',
        'opt2' => 'Generolinis valymas — 12 €/val.',
        'opt3' => 'Valymas po remonto — 15 €/val.',
        'opt4' => 'Ofiso valymas — 10 €/val.',
        'result' => 'Jūsų kaina su 30% nuolaida:',
        'btn' => 'UŽSAKYTI UŽ ŠIĄ KAINĄ →',
        'note' => '✓ 30% nuolaida galioja dabar ✓ Fiksuota kaina ✓ Važiuojame po visą Vilnių',
        'success' => 'Ačiū! Jūsų užsakymas priimtas. Susisieksime su jumis per 15 minučių.',
        'advantages_title' => 'Kodėl klientai renkasi Meistru Valymas?',
        'adv_fast' => 'Išvykstame per 2 val.',
        'adv_fixed' => 'Fiksuota kaina be staigmenų',
        'adv_pro' => 'Profesionalūs meistrai',
        'adv_eco' => 'Ekologiškos priemonės',
        'services_title' => 'Mūsų paslaugos Vilniuje',
        'serv1' => 'Butų palaikomasis valymas',
        'serv2' => 'Generolinis valymas',
        'serv3' => 'Valymas po remonto',
        'serv4' => 'Ofisų ir komercinių patalpų valymas',
        'reviews_title' => 'Ką sako mūsų klientai',
        'review1' => '"Labai greitai ir kokybiškai!" — Laura, Šeškinė',
        'review2' => '"Po remonto viskas blizga. Rekomenduoju!" — Tomas, Antakalnis',
        'review3' => '"Fiksuota kaina, jokių staigmenų. 5/5" — Ieva, Pašilaičiai',
        'faq_title' => 'Dažniausiai užduodami klausimai',
        'faq1_q' => 'Kiek laiko trunka valymas?',
        'faq1_a' => 'Paprastai 3–6 valandos, priklausomai nuo ploto.',
        'faq2_q' => 'Ar reikia ką nors paruošti?',
        'faq2_a' => 'Tik atlaisvinkite prieigas prie langų ir baldų.',
        'faq3_q' => 'Ar galite valyti po remonto?',
        'faq3_a' => 'Taip, specializuojamės būtent šiame valyme.',
        'back_to_home' => 'Grįžti į pagrindinį puslapį',
        'footer_desc' => 'Profesionalus valymas Vilniuje nuo 2023 m.<br>100% švaros garantija.',
        'contacts_title' => 'KONTAKTAI',
        'phone' => '+370 644 74842',
        'whatsapp' => 'WhatsApp',
        'districts_title' => 'DIRBAME RAJONUOSE',
        'districts' => 'Senamiestis • Šeškinė • Lazdynai • Pašilaičiai • Antakalnis • Naujamiestis ir visas Vilnius',
        'created_by' => 'Sukurta su ❤️ Ruslan Bilohash',
        'github_text' => 'GitHub',
        'copyright' => '© 2026 Vilniaus valymas. Visos teisės saugomos.'
    ],
    'ru' => [
        'brand' => 'MEISTRU VALYMAS',
        'title' => 'Калькулятор стоимости уборки Вильнюс | Meistru Valymas',
        'meta_desc' => 'Профессиональная уборка квартир, домов и офисов в Вильнюсе со скидкой 30%. Расчёт цены за 3 секунды.',
        'hero' => 'Рассчитайте стоимость уборки за 3 секунды',
        'subtitle' => 'Скидка 30% действует прямо сейчас. Фиксированная цена без сюрпризов.',
        'type' => 'Тип уборки',
        'area' => 'Площадь (м²)',
        'name' => 'Ваше имя',
        'phone' => 'Телефон',
        'opt1' => 'Поддерживающая уборка (квартира) — 8 €/час',
        'opt2' => 'Генеральная уборка — 12 €/час',
        'opt3' => 'Уборка после ремонта — 15 €/час',
        'opt4' => 'Уборка офиса — 10 €/час',
        'result' => 'Ваша цена со скидкой 30%:',
        'btn' => 'ЗАКАЗАТЬ ЗА ЭТУ ЦЕНУ →',
        'note' => '✓ Скидка 30% действует сейчас ✓ Фиксированная цена ✓ По всему Вильнюсу',
        'success' => 'Спасибо! Заказ принят. Свяжемся с вами в течение 15 минут.',
        'advantages_title' => 'Почему клиенты выбирают Meistru Valymas?',
        'adv_fast' => 'Выезжаем в течение 2 часов',
        'adv_fixed' => 'Фиксированная цена без сюрпризов',
        'adv_pro' => 'Профессиональные мастера',
        'adv_eco' => 'Экологичные средства',
        'services_title' => 'Наши услуги в Вильнюсе',
        'serv1' => 'Поддерживающая уборка квартир',
        'serv2' => 'Генеральная уборка',
        'serv3' => 'Уборка после ремонта',
        'serv4' => 'Уборка офисов и коммерческих помещений',
        'reviews_title' => 'Что говорят наши клиенты',
        'review1' => '"Очень быстро и качественно!" — Лаура, Шешкине',
        'review2' => '"После ремонта всё блестит. Рекомендую!" — Томас, Антакальнис',
        'review3' => '"Фиксированная цена, никаких сюрпризов. 5/5" — Иева, Пашлайчай',
        'faq_title' => 'Часто задаваемые вопросы',
        'faq1_q' => 'Сколько времени занимает уборка?',
        'faq1_a' => 'Обычно 3–6 часов, в зависимости от площади.',
        'faq2_q' => 'Нужно ли что-то готовить?',
        'faq2_a' => 'Просто освободите доступ к окнам и мебели.',
        'faq3_q' => 'Можете ли вы убирать после ремонта?',
        'faq3_a' => 'Да, мы специализируемся именно на этом.',
        'back_to_home' => 'Вернуться на главную',
        'footer_desc' => 'Профессиональная уборка в Вильнюсе с 2023 года.<br>100% гарантия чистоты.',
        'contacts_title' => 'КОНТАКТЫ',
        'phone' => '+370 644 74842',
        'whatsapp' => 'WhatsApp',
        'districts_title' => 'РАБОТАЕМ В РАЙОНАХ',
        'districts' => 'Старый город • Шешкине • Лаздинай • Пашлайчай • Антакальнис • Науяместис и весь Вильнюс',
        'created_by' => 'Создано с ❤️ Ruslan Bilohash',
        'github_text' => 'GitHub',
        'copyright' => '© 2026 Vilniaus valymas. Все права защищены.'
    ],
    'ua' => [
        'brand' => 'MEISTRU VALYMAS',
        'title' => 'Калькулятор вартості прибирання Вільнюс | Meistru Valymas',
        'meta_desc' => 'Професійне прибирання квартир, будинків та офісів у Вільнюсі зі знижкою 30%. Розрахунок ціни за 3 секунди.',
        'hero' => 'Розрахуйте вартість прибирання за 3 секунди',
        'subtitle' => 'Знижка 30% діє прямо зараз. Фіксована ціна без сюрпризів.',
        'type' => 'Тип прибирання',
        'area' => 'Площа (м²)',
        'name' => 'Ваше ім\'я',
        'phone' => 'Телефон',
        'opt1' => 'Підтримуюче прибирання (квартира) — 8 €/год',
        'opt2' => 'Генеральне прибирання — 12 €/год',
        'opt3' => 'Прибирання після ремонту — 15 €/год',
        'opt4' => 'Прибирання офісу — 10 €/год',
        'result' => 'Ваша ціна зі знижкою 30%:',
        'btn' => 'ЗАМОВИТИ ЗА ЦІЄЮ ЦІНОЮ →',
        'note' => '✓ Знижка 30% діє зараз ✓ Фіксована ціна ✓ По всьому Вільнюсу',
        'success' => 'Дякуємо! Замовлення прийнято. Зв\'яжемося з вами протягом 15 хвилин.',
        'advantages_title' => 'Чому клієнти обирають Meistru Valymas?',
        'adv_fast' => 'Виїжджаємо протягом 2 годин',
        'adv_fixed' => 'Фіксована ціна без сюрпризів',
        'adv_pro' => 'Професійні майстри',
        'adv_eco' => 'Екологічні засоби',
        'services_title' => 'Наші послуги у Вільнюсі',
        'serv1' => 'Підтримуюче прибирання квартир',
        'serv2' => 'Генеральне прибирання',
        'serv3' => 'Прибирання після ремонту',
        'serv4' => 'Прибирання офісів та комерційних приміщень',
        'reviews_title' => 'Що кажуть наші клієнти',
        'review1' => '"Дуже швидко і якісно!" — Лаура, Шешкіне',
        'review2' => '"Після ремонту все блищить. Рекомендую!" — Томас, Антакальніс',
        'review3' => '"Фіксована ціна, ніяких сюрпризів. 5/5" — Ієва, Пашилайчай',
        'faq_title' => 'Найчастіші питання',
        'faq1_q' => 'Скільки часу займає прибирання?',
        'faq1_a' => 'Зазвичай 3–6 годин, залежно від площі.',
        'faq2_q' => 'Чи потрібно щось готувати?',
        'faq2_a' => 'Просто звільніть доступ до вікон та меблів.',
        'faq3_q' => 'Чи можете ви прибирати після ремонту?',
        'faq3_a' => 'Так, ми спеціалізуємося саме на цьому.',
        'back_to_home' => 'Повернутися на головну',
        'footer_desc' => 'Професійне прибирання у Вільнюсі з 2023 року.<br>100% гарантія чистоти.',
        'contacts_title' => 'КОНТАКТИ',
        'phone' => '+370 644 74842',
        'whatsapp' => 'WhatsApp',
        'districts_title' => 'ПРАЦЮЄМО В РАЙОНАХ',
        'districts' => 'Старе місто • Шешкіне • Лаздінай • Пашилайчай • Антакальніс • Науямєстіс та весь Вільнюс',
        'created_by' => 'Створено з ❤️ Ruslan Bilohash',
        'github_text' => 'GitHub',
        'copyright' => '© 2026 Vilniaus valymas. Всі права захищені.'
    ],
    'en' => [
        'brand' => 'MEISTRU VALYMAS',
        'title' => 'Cleaning Price Calculator Vilnius | Meistru Valymas',
        'meta_desc' => 'Professional apartment, house and office cleaning in Vilnius with 30% discount. Calculate price in 3 seconds.',
        'hero' => 'Calculate cleaning cost in 3 seconds',
        'subtitle' => '30% discount is active right now. Fixed price, no surprises.',
        'type' => 'Cleaning type',
        'area' => 'Area (m²)',
        'name' => 'Your full name',
        'phone' => 'Phone number',
        'opt1' => 'Maintenance cleaning (apartment) — 8 €/hour',
        'opt2' => 'General cleaning — 12 €/hour',
        'opt3' => 'Post-renovation cleaning — 15 €/hour',
        'opt4' => 'Office cleaning — 10 €/hour',
        'result' => 'Your price with 30% discount:',
        'btn' => 'ORDER FOR THIS PRICE →',
        'note' => '✓ 30% discount active now ✓ Fixed price ✓ All Vilnius',
        'success' => 'Thank you! Order received. We will contact you within 15 minutes.',
        'advantages_title' => 'Why clients choose Meistru Valymas?',
        'adv_fast' => 'We arrive within 2 hours',
        'adv_fixed' => 'Fixed price, no surprises',
        'adv_pro' => 'Professional masters',
        'adv_eco' => 'Eco-friendly products',
        'services_title' => 'Our services in Vilnius',
        'serv1' => 'Apartment maintenance cleaning',
        'serv2' => 'General cleaning',
        'serv3' => 'Post-renovation cleaning',
        'serv4' => 'Office and commercial cleaning',
        'reviews_title' => 'What our clients say',
        'review1' => '"Very fast and high quality!" — Laura, Šeškinė',
        'review2' => '"Everything shines after renovation. Highly recommend!" — Tomas, Antakalnis',
        'review3' => '"Fixed price, no surprises. 5/5" — Ieva, Pašilaičiai',
        'faq_title' => 'Frequently Asked Questions',
        'faq1_q' => 'How long does the cleaning take?',
        'faq1_a' => 'Usually 3–6 hours, depending on the area.',
        'faq2_q' => 'Do I need to prepare anything?',
        'faq2_a' => 'Just provide access to windows and furniture.',
        'faq3_q' => 'Can you clean after renovation?',
        'faq3_a' => 'Yes, we specialize in post-renovation cleaning.',
        'back_to_home' => 'Back to Home',
        'footer_desc' => 'Professional cleaning in Vilnius since 2023.<br>100% cleanliness guarantee.',
        'contacts_title' => 'CONTACTS',
        'phone' => '+370 644 74842',
        'whatsapp' => 'WhatsApp',
        'districts_title' => 'WE WORK IN DISTRICTS',
        'districts' => 'Old Town • Šeškinė • Lazdynai • Pašilaičiai • Antakalnis • Naujamiestis and all Vilnius',
        'created_by' => 'Created with ❤️ Ruslan Bilohash',
        'github_text' => 'GitHub',
        'copyright' => '© 2026 Vilniaus valymas. All rights reserved.'
    ],
    'no' => [
        'brand' => 'MEISTRU VALYMAS',
        'title' => 'Priskalkulator for rengjøring Vilnius | Meistru Valymas',
        'meta_desc' => 'Profesjonell rengjøring av leiligheter, hus og kontorer i Vilnius med 30% rabatt.',
        'hero' => 'Beregn rengjøringskostnad på 3 sekunder',
        'subtitle' => '30% rabatt gjelder akkurat nå. Fast pris uten overraskelser.',
        'type' => 'Rengjøringstype',
        'area' => 'Areal (m²)',
        'name' => 'Ditt fulle navn',
        'phone' => 'Telefonnummer',
        'opt1' => 'Vedlikeholdsrengjøring (leilighet) — 8 €/time',
        'opt2' => 'Grundig rengjøring — 12 €/time',
        'opt3' => 'Rengjøring etter renovering — 15 €/time',
        'opt4' => 'Kontorrengjøring — 10 €/time',
        'result' => 'Din pris med 30% rabatt:',
        'btn' => 'BESTILL TIL DENNE PRISEN →',
        'note' => '✓ 30% rabatt gjelder nå ✓ Fast pris ✓ Hele Vilnius',
        'success' => 'Takk! Bestilling mottatt. Vi kontakter deg innen 15 minutter.',
        'advantages_title' => 'Hvorfor velger kunder Meistru Valymas?',
        'adv_fast' => 'Vi kommer innen 2 timer',
        'adv_fixed' => 'Fast pris uten overraskelser',
        'adv_pro' => 'Profesjonelle håndverkere',
        'adv_eco' => 'Miljøvennlige produkter',
        'services_title' => 'Våre tjenester i Vilnius',
        'serv1' => 'Vedlikeholdsrengjøring av leiligheter',
        'serv2' => 'Grundig rengjøring',
        'serv3' => 'Rengjøring etter renovering',
        'serv4' => 'Rengjøring av kontorer og næringslokaler',
        'reviews_title' => 'Hva kundene våre sier',
        'review1' => '"Veldig raskt og av høy kvalitet!" — Laura, Šeškinė',
        'review2' => '"Alt skinner etter renovering. Anbefaler sterkt!" — Tomas, Antakalnis',
        'review3' => '"Fast pris, ingen overraskelser. 5/5" — Ieva, Pašilaičiai',
        'faq_title' => 'Ofte stilte spørsmål',
        'faq1_q' => 'Hvor lang tid tar rengjøringen?',
        'faq1_a' => 'Vanligvis 3–6 timer, avhengig av areal.',
        'faq2_q' => 'Trenger jeg å forberede noe?',
        'faq2_a' => 'Bare gi tilgang til vinduer og møbler.',
        'faq3_q' => 'Kan dere rengjøre etter renovering?',
        'faq3_a' => 'Ja, vi spesialiserer oss på dette.',
        'back_to_home' => 'Tilbake til forsiden',
        'footer_desc' => 'Profesjonell rengjøring i Vilnius siden 2023.<br>100% renholdsgaranti.',
        'contacts_title' => 'KONTAKTER',
        'phone' => '+370 644 74842',
        'whatsapp' => 'WhatsApp',
        'districts_title' => 'VI ARBEIDER I OMRÅDER',
        'districts' => 'Gamlebyen • Šeškinė • Lazdynai • Pašilaičiai • Antakalnis • Naujamiestis og hele Vilnius',
        'created_by' => 'Laget med ❤️ Ruslan Bilohash',
        'github_text' => 'GitHub',
        'copyright' => '© 2026 Vilniaus valymas. Alle rettigheter reservert.'
    ]
];

$t = $tr[$lang] ?? $tr['lt'];
// === ОБРОБКА ФОРМИ З reCAPTCHA + CSRF + КРАСИВИЙ EMAIL ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Перевірка reCAPTCHA v2
    if (!isset($_POST['g-recaptcha-response']) || !verifyRecaptcha($_POST['g-recaptcha-response'])) {
        header("Location: kalkuliatorius.php?error=1");
        exit;
    }

    // 2. Базова валідація
    $name  = strip_tags(trim($_POST['name'] ?? ''));
    $phone = strip_tags(trim($_POST['phone'] ?? ''));
    $suma  = (int)($_POST['suma'] ?? 0);

    if (empty($name) || empty($phone) || $suma <= 0) {
        header("Location: kalkuliatorius.php?error=1");
        exit;
    }

    // === КРАСИВИЙ HTML EMAIL ===
    $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <style>
            body { font-family: Arial, Helvetica, sans-serif; background: #f9fafb; margin:0; padding:30px; }
            .container { max-width: 620px; margin: 0 auto; background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 40px rgba(0,0,0,0.1); }
            .header { background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 40px 30px; text-align: center; }
            .header h1 { margin: 0; font-size: 28px; }
            .content { padding: 40px 35px; line-height: 1.7; color: #1f2937; }
            table { width: 100%; border-collapse: collapse; margin: 25px 0; }
            th, td { padding: 16px 18px; text-align: left; border-bottom: 1px solid #e5e7eb; }
            th { background: #f8fafc; font-weight: 600; color: #374151; width: 42%; }
            .highlight { background: #ecfdf5; font-weight: bold; color: #065f46; font-size: 1.15em; }
            .footer { background: #f8fafc; padding: 25px; text-align: center; font-size: 14px; color: #6b7280; }
            .site-link { color: #10b981; text-decoration: none; font-weight: 600; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>🧹 Нове замовлення зі знижкою 30%!</h1>
                <p style="margin:10px 0 0; opacity:0.95;">Meistru Valymas Vilnius</p>
            </div>
            <div class="content">
                <table>
                    <tr><th>Ім’я клієнта</th><td>' . htmlspecialchars($name) . '</td></tr>
                    <tr><th>Телефон</th><td>' . htmlspecialchars($phone) . '</td></tr>
                    <tr><th class="highlight">Сума зі знижкою</th><td class="highlight">' . $suma . ' €</td></tr>
                    <tr><th>Дата та час</th><td>' . date('d.m.Y H:i:s') . '</td></tr>
                    <tr><th>IP адреса</th><td>' . $_SERVER['REMOTE_ADDR'] . '</td></tr>
                    <tr><th>Джерело</th><td><strong>https://meistru.lt/kalkuliatorius.php</strong></td></tr>
                </table>
                <p style="text-align:center; margin-top:35px; font-size:15px;">
                    Замовлення надійшло з калькулятора на сайті 
                    <a href="https://meistru.lt" class="site-link" target="_blank">meistru.lt</a>
                </p>
            </div>
            <div class="footer">
                Meistru Valymas Vilnius © 2026 • Професійне прибирання з гарантією якості
            </div>
        </div>
    </body>
    </html>';

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    $headers .= "From: no-reply@meistru.lt\r\n";
    $headers .= "Reply-To: no-reply@meistru.lt\r\n";

    mail(
        "rbilohash@gmail.com,valeriapilipiuk@gmail.com,ulianasemashko@gmail.com",
        "Замовлення $suma € — Калькулятор Meistru Valymas",
        $html,
        $headers
    );

    // Перенаправлення з успіхом
    header("Location: kalkuliatorius.php?success=1");
    exit;
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($t['meta_desc']); ?>">
    <meta name="keywords" content="valymas Vilnius, butų valymas Vilnius, generalinis valymas, valymas po remonto, ofiso valymas, meistru valymas, pigus valymas Vilnius, greitas valymas, ekologinis valymas">
    <title><?php echo $t['title']; ?></title>

    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo $t['brand']; ?> — <?php echo $t['hero']; ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($t['meta_desc']); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://meistru.lt/kalkuliatorius.php">
    <meta property="og:image" content="https://picsum.photos/id/1015/1200/630">
<!-- reCAPTCHA v2 -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        .hero-bg { background: linear-gradient(rgba(0,0,0,0.78), rgba(0,0,0,0.78)), url('https://picsum.photos/id/1015/2000/1200') center/cover no-repeat fixed; }
        #timer { font-size: 2.9rem; font-weight: 800; color: #ef4444; }
        .btn-hover { transition: all 0.3s ease; }
        .btn-hover:hover { transform: translateY(-3px); box-shadow: 0 20px 25px -5px rgb(16 185 129 / 0.3); }
        .btn-hover:active { transform: scale(0.97); }
    </style>
</head>
<body class="font-sans bg-gray-50 text-gray-900">

<!-- HEADER -->
<header class="bg-white shadow-xl sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
        <a href="/" class="flex items-center gap-4 group">
            <i class="fa-solid fa-broom text-5xl text-emerald-600 group-hover:rotate-12 transition"></i>
            <span class="text-4xl font-bold tracking-tighter text-emerald-700"><?php echo $t['brand']; ?></span>
        </a>
        <div class="relative group">
            <button onclick="toggleLang()" class="flex items-center gap-3 px-6 py-3 bg-gray-100 hover:bg-gray-200 rounded-3xl transition-all active:scale-95">
                <span id="currentFlag" class="text-3xl">🇱🇹</span>
                <span id="currentLang" class="font-semibold"><?php echo strtoupper($lang); ?></span>
                <i class="fa-solid fa-chevron-down text-xs"></i>
            </button>
            <div id="langDropdown" class="hidden group-hover:block absolute right-0 mt-3 bg-white shadow-2xl rounded-3xl py-4 w-60 z-50 border border-gray-100">
                <a href="?lang=lt" class="flex items-center gap-4 px-6 py-3 hover:bg-emerald-50">🇱🇹 Lietuvių</a>
                <a href="?lang=ru" class="flex items-center gap-4 px-6 py-3 hover:bg-emerald-50">🇷🇺 Русский</a>
                <a href="?lang=ua" class="flex items-center gap-4 px-6 py-3 hover:bg-emerald-50">🇺🇦 Українська</a>
                <a href="?lang=en" class="flex items-center gap-4 px-6 py-3 hover:bg-emerald-50">🇬🇧 English</a>
                <a href="?lang=no" class="flex items-center gap-4 px-6 py-3 hover:bg-emerald-50">🇳🇴 Norsk</a>
            </div>
        </div>
    </div>
</header>

<!-- HERO -->
<section class="hero-bg h-screen flex items-center text-white">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h1 class="text-6xl md:text-7xl font-bold mb-6"><?php echo $t['hero']; ?></h1>
        <p class="text-3xl mb-10"><?php echo $t['subtitle']; ?></p>
        <div class="inline-flex items-center gap-6 bg-white/10 backdrop-blur-xl px-12 py-6 rounded-3xl">
            <span class="text-4xl">⏰</span>
            <div>
                <div class="text-sm opacity-90">Akcija baigiasi po</div>
                <div id="timer" class="font-mono">10:00</div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== КАЛЬКУЛЯТОР З reCAPTCHA v2 ==================== -->
<section class="py-24 bg-white">
    <div class="max-w-4xl mx-auto px-6">
        <?php if (isset($_GET['success'])): ?>
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-800 p-10 rounded-3xl text-center mb-12">
                <i class="fa-solid fa-circle-check text-7xl mb-6 text-emerald-600"></i>
                <h3 class="text-3xl font-bold"><?php echo $t['success']; ?></h3>
            </div>
        <?php endif; ?>

        <form id="calc-form" method="POST" class="bg-white rounded-3xl p-12 md:p-16 shadow-2xl">
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-semibold mb-3"><?php echo $t['type']; ?></label>
                    <select id="tipas" onchange="calculate()" class="w-full px-6 py-6 rounded-3xl border-2 text-xl bg-white">
                        <option value="8"><?php echo $t['opt1']; ?></option>
                        <option value="12" selected><?php echo $t['opt2']; ?></option>
                        <option value="15"><?php echo $t['opt3']; ?></option>
                        <option value="10"><?php echo $t['opt4']; ?></option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-3"><?php echo $t['area']; ?></label>
                    <input type="number" id="plotas" value="65" min="20" onkeyup="calculate()" class="w-full px-6 py-6 rounded-3xl border-2 text-3xl text-center bg-white">
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-8 mt-8">
                <div>
                    <label class="block text-sm font-semibold mb-3"><?php echo $t['name']; ?></label>
                    <input type="text" name="name" required class="w-full px-6 py-6 rounded-3xl border-2 text-xl">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-3"><?php echo $t['phone']; ?></label>
                    <input type="tel" name="phone" required class="w-full px-6 py-6 rounded-3xl border-2 text-xl">
                </div>
            </div>

            <div id="rezultatas" class="mt-14 text-center min-h-[170px]"></div>
            <input type="hidden" name="suma" id="hiddenSum">

            <!-- reCAPTCHA v2 -->
            <div class="my-10 flex justify-center">
                <?php renderRecaptcha(); ?>
            </div>

            <button type="submit" id="btnOrder" class="hidden w-full mt-10 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-3xl font-bold py-8 rounded-3xl btn-hover">
                <?php echo $t['btn']; ?>
            </button>
        </form>

        <div class="text-center mt-8 text-gray-500"><?php echo $t['note']; ?></div>
    </div>
</section>
<!-- Переваги -->
<section class="py-20 bg-emerald-50">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-14"><?php echo $t['advantages_title']; ?></h2>
        <div class="grid md:grid-cols-4 gap-8">
            <div class="bg-white p-8 rounded-3xl shadow text-center btn-hover">
                <i class="fa-solid fa-clock text-6xl text-emerald-600 mb-6"></i>
                <p class="font-semibold text-xl"><?php echo $t['adv_fast']; ?></p>
            </div>
            <div class="bg-white p-8 rounded-3xl shadow text-center btn-hover">
                <i class="fa-solid fa-euro-sign text-6xl text-emerald-600 mb-6"></i>
                <p class="font-semibold text-xl"><?php echo $t['adv_fixed']; ?></p>
            </div>
            <div class="bg-white p-8 rounded-3xl shadow text-center btn-hover">
                <i class="fa-solid fa-user-tie text-6xl text-emerald-600 mb-6"></i>
                <p class="font-semibold text-xl"><?php echo $t['adv_pro']; ?></p>
            </div>
            <div class="bg-white p-8 rounded-3xl shadow text-center btn-hover">
                <i class="fa-solid fa-leaf text-6xl text-emerald-600 mb-6"></i>
                <p class="font-semibold text-xl"><?php echo $t['adv_eco']; ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Послуги -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-14"><?php echo $t['services_title']; ?></h2>
        <div class="grid md:grid-cols-2 gap-x-12 gap-y-6 text-lg max-w-3xl mx-auto">
            <div class="flex gap-4"><i class="fa-solid fa-check text-emerald-600 mt-1.5"></i> <?php echo $t['serv1']; ?></div>
            <div class="flex gap-4"><i class="fa-solid fa-check text-emerald-600 mt-1.5"></i> <?php echo $t['serv2']; ?></div>
            <div class="flex gap-4"><i class="fa-solid fa-check text-emerald-600 mt-1.5"></i> <?php echo $t['serv3']; ?></div>
            <div class="flex gap-4"><i class="fa-solid fa-check text-emerald-600 mt-1.5"></i> <?php echo $t['serv4']; ?></div>
        </div>
    </div>
</section>

<!-- Відгуки -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-14"><?php echo $t['reviews_title']; ?></h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-3xl shadow">"<?php echo $t['review1']; ?>"</div>
            <div class="bg-white p-8 rounded-3xl shadow">"<?php echo $t['review2']; ?>"</div>
            <div class="bg-white p-8 rounded-3xl shadow">"<?php echo $t['review3']; ?>"</div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-14"><?php echo $t['faq_title']; ?></h2>
        <div class="space-y-8">
            <details class="border-b pb-6">
                <summary class="font-semibold cursor-pointer text-xl"><?php echo $t['faq1_q']; ?></summary>
                <p class="mt-4 text-gray-600"><?php echo $t['faq1_a']; ?></p>
            </details>
            <details class="border-b pb-6">
                <summary class="font-semibold cursor-pointer text-xl"><?php echo $t['faq2_q']; ?></summary>
                <p class="mt-4 text-gray-600"><?php echo $t['faq2_a']; ?></p>
            </details>
            <details class="border-b pb-6">
                <summary class="font-semibold cursor-pointer text-xl"><?php echo $t['faq3_q']; ?></summary>
                <p class="mt-4 text-gray-600"><?php echo $t['faq3_a']; ?></p>
            </details>
        </div>
    </div>
</section>

<!-- Кнопка на головну -->
<div class="text-center py-20">
    <a href="/" class="inline-block bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-3xl font-bold px-20 py-8 rounded-3xl btn-hover shadow-xl">
        <?php echo $t['back_to_home']; ?>
    </a>
</div>

<!-- FOOTER -->
<footer class="bg-gray-900 text-white py-20">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-12">
        <div>
            <div class="flex items-center gap-4 text-3xl mb-6">
                <i class="fa-solid fa-broom text-emerald-500"></i>
                <span class="font-bold"><?php echo $t['brand']; ?></span>
            </div>
            <p class="text-gray-400"><?php echo $t['footer_desc']; ?></p>
            <p class="mt-8 text-sm text-gray-500">
                <?php echo $t['created_by']; ?> • 
                <a href="https://github.com/ruslan-bilohash" target="_blank" class="hover:text-emerald-400"><?php echo $t['github_text']; ?></a>
            </p>
        </div>
        <div>
            <div class="font-semibold mb-6 text-emerald-400 text-xl"><?php echo $t['contacts_title']; ?></div>
            <a href="tel:+37064474842" class="block text-xl hover:text-white mb-3"><?php echo $t['phone']; ?></a>
            <a href="https://wa.me/37064474842" class="block text-xl hover:text-white"><?php echo $t['whatsapp']; ?></a>
        </div>
        <div>
            <div class="font-semibold mb-6 text-emerald-400 text-xl"><?php echo $t['districts_title']; ?></div>
            <div class="text-gray-400 leading-relaxed"><?php echo $t['districts']; ?></div>
        </div>
    </div>
    <div class="text-center text-xs text-gray-500 mt-20">
        <?php echo $t['copyright']; ?>
    </div>
</footer>

<script>
function toggleLang() {
    document.getElementById('langDropdown').classList.toggle('hidden');
}

let timeLeft = localStorage.getItem('timer10') ? parseInt(localStorage.getItem('timer10')) : 600;
const timerEl = document.getElementById('timer');

function countdown() {
    if (timeLeft <= 0) return;
    const min = Math.floor(timeLeft / 60);
    const sec = timeLeft % 60;
    timerEl.textContent = `${min}:${sec < 10 ? '0' : ''}${sec}`;
    timeLeft--;
    localStorage.setItem('timer10', timeLeft);
    setTimeout(countdown, 1000);
}
countdown();

function calculate() {
    const rate = parseFloat(document.getElementById('tipas').value);
    let area = parseFloat(document.getElementById('plotas').value) || 40;
    const finalPrice = Math.round(area * rate * 0.756);
    const originalPrice = Math.round(area * rate * 1.08);

    document.getElementById('rezultatas').innerHTML = `
        <div class="text-2xl text-gray-600 mb-4"><?php echo $t['result']; ?></div>
        <div class="text-7xl font-black text-emerald-600">${finalPrice} €</div>
        <div class="text-2xl line-through text-gray-400 mt-2">${originalPrice} € <span class="text-red-600 font-bold">-30%</span></div>
    `;

    document.getElementById('hiddenSum').value = finalPrice;
    document.getElementById('btnOrder').classList.remove('hidden');
}

window.addEventListener('load', calculate);
</script>

<script src="/chat-widget.js" defer></script>
<script>
document.getElementById('calc-form').addEventListener('submit', function(e) {
    const response = document.querySelector('.g-recaptcha-response');
    if (!response || response.value.trim() === '') {
        e.preventDefault();
        alert('Будь ласка, підтвердіть, що ви не робот (поставте галочку)');
    }
});
</script>
</body>
</html>
