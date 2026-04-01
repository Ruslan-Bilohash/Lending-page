<?php
// ========================================================
// Ukrbud.lt - index.php (Полная мощная версия 2026)
// Максимальный SEO + лучший калькулятор + красивые письма + защита reCAPTCHA v2
// ========================================================
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Подключаем reCAPTCHA v2
require_once 'recaptcha.php';

$success = false;
$error = '';

// ========================================================
// ОБРАБОТКА ФОРМЫ ЗАКАЗА — с reCAPTCHA v2
// ========================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_order'])) {
    
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = 'Ошибка безопасности. Обновите страницу.';
    } 
    elseif (!isset($_POST['g-recaptcha-response']) || !verifyRecaptcha($_POST['g-recaptcha-response'])) {
        $error = 'Не удалось подтвердить, что вы не робот. Поставьте галочку «Я не робот».';
    } 
    else {
        $name    = trim(htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES | ENT_HTML5));
        $phone   = trim(htmlspecialchars($_POST['phone'] ?? '', ENT_QUOTES | ENT_HTML5));
        $message = trim(htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES | ENT_HTML5));

        if (empty($name) || empty($phone)) {
            $error = 'Имя и телефон обязательны!';
        } elseif (!preg_match('/^[\+]?[\d\s\-\(\)]{10,18}$/', $phone)) {
            $error = 'Неверный формат телефона!';
        } else {
            $order_id = "UKR-" . date("YmdHis");

            // ==================== ПИСЬМО КЛИЕНТУ (красивое HTML) ====================
            $client_subject = "✅ Заявка №$order_id принята | Ukrbud.lt";
            $client_message = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Заявка принята</title>
                <style>
                    body { font-family: Arial, sans-serif; background:#f8fafc; margin:0; padding:40px 0; }
                    .container { max-width: 620px; margin: 0 auto; background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.08); }
                    .header { background: linear-gradient(135deg, #22d3ee, #0ea5e9); color: white; padding: 50px 40px; text-align: center; }
                    .content { padding: 45px 40px; line-height: 1.8; color: #1e2937; }
                    .info-box { background: #f1f5f9; border-left: 5px solid #22d3ee; padding: 25px; margin: 30px 0; border-radius: 12px; }
                    .button { display: inline-block; background: #22d3ee; color: #0f172a; padding: 16px 36px; text-decoration: none; font-weight: 700; border-radius: 9999px; margin: 20px 0; }
                    .footer { background: #0f172a; color: #94a3b8; padding: 35px 40px; text-align: center; font-size: 14px; }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h1 style="margin:0; font-size:32px;">Заявка успешно принята!</h1>
                        <p style="margin:15px 0 0; font-size:20px;">Номер заявки: <strong>' . $order_id . '</strong></p>
                    </div>
                    <div class="content">
                        <p>Здравствуйте, <strong>' . $name . '</strong>!</p>
                        <p>Благодарим вас за доверие к <strong>Ukrbud.lt</strong> — профессиональной клиниговой компании в Вильнюсе.</p>
                        <div class="info-box">
                            <strong>Ваша заявка №' . $order_id . ' принята и находится в обработке.</strong><br><br>
                            Наш менеджер свяжется с вами в течение 15–60 минут для уточнения деталей.
                        </div>
                        <p><strong>Данные вашей заявки:</strong></p>
                        <p>Имя: ' . $name . '<br>
                           Телефон: ' . $phone . '<br>
                           Сообщение: ' . nl2br($message) . '</p>
                        <p style="text-align:center;">
                            <a href="tel:+37064474842" class="button">Позвонить нам прямо сейчас →</a>
                        </p>
                        <p>Если у вас появились дополнительные пожелания — просто ответьте на это письмо.</p>
                    </div>
                    <div class="footer">
                        С уважением,<br>
                        <strong>Команда Ukrbud.lt</strong><br>
                        Профессиональная уборка после ремонта • Уборка офисов • Клининг коммерческих помещений<br>
                        Вильнюс • +370 644 74842
                    </div>
                </div>
            </body>
            </html>';

            // ==================== ПИСЬМО АДМИНУ ====================
            $admin_subject = "Новая заявка №$order_id — Ukrbud.lt";
            $admin_body = "НОВАЯ ЗАЯВКА НА УБОРКУ\n\n";
            $admin_body .= "Номер заявки: $order_id\n";
            $admin_body .= "Имя: $name\n";
            $admin_body .= "Телефон: $phone\n";
            $admin_body .= "Сообщение:\n$message\n\n";
            $admin_body .= "Дата: " . date('d.m.Y H:i:s') . "\n";
            $admin_body .= "IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
            $admin_body .= "reCAPTCHA v2: Пройдена успешно\n";

            $admin_headers = "From: no-reply@ukrbud.lt\r\nContent-Type: text/plain; charset=utf-8\r\n";
            $headers_client = "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Ukrbud.lt <no-reply@ukrbud.lt>\r\n";

            mail("rbilohash@gmail.com,valeriapilipiuk@gmail.com,ulianasemashko@gmail.com,booking@balticclean.lt", $admin_subject, $admin_body, $admin_headers);
            mail($email ?? "rbilohash@gmail.com", $client_subject, $client_message, $headers_client);

            $success = true;
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }
}

// ========================================================
// Обработка подписки на скидку 30% (оставлена без изменений)
// ========================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subscribe_email'])) {
    $email = trim(htmlspecialchars($_POST['subscribe_email'] ?? '', ENT_QUOTES));
   
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
       
        if (!is_dir('subscribe')) mkdir('subscribe', 0755, true);
       
        $file = 'subscribe/emails.txt';
        $exists = false;
       
        if (file_exists($file)) {
            $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $exists = in_array($email, $lines);
        }
       
        if (!$exists) {
            file_put_contents($file, $email . PHP_EOL, FILE_APPEND | LOCK_EX);
           
            $discount_code = "UKR30-" . strtoupper(substr(md5($email . time()), 0, 6));
           
            $subject = "🎁 Ваша скидка 30% на уборку в Вильнюсе от Ukrbud.lt";
           
            $message = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Ваша скидка 30%</title>
                <style>
                    body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; padding:0; }
                    .container { max-width: 600px; margin: 30px auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
                    .header { background: linear-gradient(135deg, #22d3ee, #0ea5e9); color: white; padding: 40px 30px; text-align: center; }
                    .content { padding: 40px 30px; line-height: 1.7; color: #333; }
                    .discount-box { background: #f8fafc; border: 3px dashed #22d3ee; border-radius: 16px; padding: 25px; text-align: center; margin: 30px 0; }
                    .code { font-size: 32px; font-weight: bold; letter-spacing: 4px; color: #0e7490; background: white; padding: 15px 30px; border-radius: 12px; display: inline-block; margin: 15px 0; }
                    .button { display: inline-block; background: #22d3ee; color: #0f172a; padding: 16px 32px; text-decoration: none; font-weight: bold; border-radius: 9999px; margin-top: 20px; }
                    .footer { background:#1e2937; color:#94a3b8; padding:30px; text-align:center; font-size:14px; }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h1 style="margin:0; font-size:32px;">🎁 Поздравляем!</h1>
                        <p style="margin:10px 0 0; font-size:20px;">Вы получили скидку 30%</p>
                    </div>
                    <div class="content">
                        <p>Здравствуйте!</p>
                        <p>Спасибо, что подписались на рассылку Ukrbud.lt.</p>
                        <p>Ваш подарок — <strong>скидка 30% на первую уборку</strong>.</p>
                        <div class="discount-box">
                            <p style="margin:0 0 10px; font-size:18px; color:#64748b;">Ваш промокод:</p>
                            <div class="code">' . $discount_code . '</div>
                            <p style="margin:15px 0 0; color:#64748b;">Действует 30 дней</p>
                        </div>
                        <p style="text-align:center;">
                            <a href="https://ukrbud.lt/#contact" class="button">Заказать уборку со скидкой →</a>
                        </p>
                        <p>Просто покажите этот промокод нашему менеджеру.</p>
                        <p>С уважением,<br><strong>Команда Ukrbud.lt</strong></p>
                    </div>
                    <div class="footer">
                        © 2026 Ukrbud.lt — Уборка после ремонта, офисов и коммерческих помещений в Вильнюсе<br>
                        Если не хотите получать письма — ответьте «Отписаться».
                    </div>
                </div>
            </body>
            </html>';

            $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Ukrbud.lt <no-reply@ukrbud.lt>\r\n";
            mail($email, $subject, $message, $headers);

            $notify_subject = "Новая подписка на скидку 30% — ukrbud.lt";
            $notify_body = "Новая подписка:\nEmail: $email\nПромокод: $discount_code\nДата: " . date('d.m.Y H:i:s') . "\nIP: " . $_SERVER['REMOTE_ADDR'];
            mail("rbilohash@gmail.com,valeriapilipiuk@gmail.com,ulianasemashko@gmail.com,booking@balticclean.lt", $notify_subject, $notify_body, "From: no-reply@ukrbud.lt\r\nContent-Type: text/plain; charset=utf-8\r\n");
        }
       
        $subscribe_success = true;
    } else {
        $subscribe_error = 'Введите корректный email адрес';
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Основні SEO мета-теги -->
    <meta name="description" content="Уборка после ремонта в Вильнюсе от 2.8 €/м² ✓ Профессиональная уборка офисов в Вильнюсе ✓ Клининг коммерческих помещений ✓ Онлайн-калькулятор стоимости ✓ Выезд бригады за 60 минут ✓ Работаем 24/7 ✓ Безналичный расчёт ✓ Ukrbud.lt +370 644 74842">
    <meta name="keywords" content="уборка после ремонта Вильнюс, уборка офисов Вильнюс, клининг Вильнюс, уборка коммерческих помещений Вильнюс, генеральная уборка Вильнюс, уборка после стройки Вильнюс, клининговая компания Вильнюс">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Ukrbud.lt">
    <meta name="language" content="ru">
    <link rel="canonical" href="https://ukrbud.lt/ru.php">

    <title>Уборка после ремонта Вильнюс | Уборка офисов | Клининг коммерческих помещений | Ukrbud.lt</title>

    <!-- Open Graph / Facebook + Instagram + Telegram + LinkedIn -->
    <meta property="og:title" content="Уборка после ремонта Вильнюс • Ukrbud.lt">
    <meta property="og:description" content="Профессиональная уборка после ремонта, офисов и коммерческих помещений в Вильнюсе. Онлайн-калькулятор цены. Выезд за 60 минут. +370 644 74842">
    <meta property="og:image" content="https://ukrbud.lt/og-image.jpg">
    <meta property="og:url" content="https://ukrbud.lt/ru.php">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Ukrbud.lt">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:locale:alternate" content="lt_LT">
    <meta property="og:locale:alternate" content="en_US">
    <meta property="og:locale:alternate" content="uk_UA">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Уборка после ремонта Вильнюс • Ukrbud.lt">
    <meta name="twitter:description" content="Профессиональная уборка после ремонта, офисов и коммерческих помещений в Вильнюсе. Онлайн-калькулятор. Выезд за 60 минут.">
    <meta name="twitter:image" content="https://ukrbud.lt/og-image.jpg">

    <!-- Додаткові соціальні мета -->
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Уборка после ремонта в Вильнюсе - Ukrbud.lt">
<!-- Hreflang для багатомовності -->
<link rel="alternate" hreflang="en" href="https://ukrbud.lt/en.php" />
<link rel="alternate" hreflang="lt" href="https://ukrbud.lt/" />
<link rel="alternate" hreflang="ru" href="https://ukrbud.lt/ru.php" />
<link rel="alternate" hreflang="uk" href="https://ukrbud.lt/ua.php" />
<link rel="alternate" hreflang="x-default" href="https://ukrbud.lt/" />
    <!-- Schema.org - Розширена розмітка -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "Ukrbud.lt",
        "description": "Профессиональная уборка после ремонта, офисов и коммерческих помещений в Вильнюсе",
        "url": "https://ukrbud.lt/ru.php",
        "telephone": "+37064474842",
        "email": "booking@balticclean.lt",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Vilnius",
            "addressCountry": "LT"
        },
        "priceRange": "€€",
        "openingHours": "Mo-Su 00:00-24:00",
        "paymentAccepted": "Cash, Credit Card, Bank Transfer, Revolut",
        "areaServed": "Vilnius, Vilnius County, Lithuania",
        "serviceType": "Cleaning Services",
        "image": "https://ukrbud.lt/og-image.jpg",
        "logo": "https://ukrbud.lt/logo.png"
    }
    </script>

    <!-- Schema для послуг -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Service",
        "name": "Уборка после ремонта в Вильнюсе",
        "description": "Профессиональная уборка после ремонта квартир, домов и офисов в Вильнюсе",
        "provider": {
            "@type": "LocalBusiness",
            "name": "Ukrbud.lt"
        },
        "areaServed": "Vilnius",
        "hasOfferCatalog": {
            "@type": "OfferCatalog",
            "name": "Цены на уборку",
            "itemListElement": [
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "Service",
                        "name": "Уборка после ремонта"
                    },
                    "price": "2.8",
                    "priceCurrency": "EUR"
                }
            ]
        }
    }
    </script>

    <!-- Schema для FAQ -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
            {
                "@type": "Question",
                "name": "Сколько стоит уборка после ремонта в Вильнюсе?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Цена начинается от 2.8 €/м² в зависимости от площади и сложности работ."
                }
            },
            {
                "@type": "Question",
                "name": "Как быстро вы приезжаете на уборку офисов в Вильнюсе?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Мы гарантируем выезд бригады в течение 60 минут после подтверждения заявки."
                }
            }
        ]
    }
    </script>

    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
<!-- reCAPTCHA v2 -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap');
        .heading-font { font-family: 'Space Grotesk', sans-serif; }
        .hero-bg { background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 100%); }

        .service-card:hover { transform: translateY(-12px) scale(1.04); box-shadow: 0 30px 60px -15px rgb(0 212 255 / 0.35); }
        .price-row:hover { background-color: rgba(0, 212, 255, 0.1); }

        .calc-result { font-size: 2.8rem; font-weight: 700; color: #22d3ee; }

        .want-site-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .want-site-btn::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: 0.7s;
        }
        .want-site-btn:hover::before { left: 200%; }
        .want-site-btn:hover { transform: translateY(-6px) scale(1.07); box-shadow: 0 0 60px 10px rgb(34 211 238); }

        @keyframes glowPulse {
            0%, 100% { box-shadow: 0 0 25px -5px rgb(34 211 238); }
            50% { box-shadow: 0 0 65px 25px rgb(34 211 238); }
        }
        .glow-animation { animation: glowPulse 3.5s ease-in-out infinite; }
    </style>
</head>
<body class="font-sans">

<!-- NAVBAR -->
<nav class="bg-black/95 backdrop-blur-xl border-b border-white/10 sticky top-0 z-50">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12 py-5 flex items-center justify-between">
        <a href="/" class="flex items-center gap-3">
            <div class="w-11 h-11 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-3xl flex items-center justify-center text-3xl">🇺🇦</div>
            <span class="heading-font text-4xl font-semibold tracking-[-2px] text-white">ukrbud</span>
            <span class="text-cyan-400 text-sm font-bold -mt-1">.lt</span>
        </a>
        <div class="hidden lg:flex items-center gap-x-10 text-white font-medium text-lg">
            <a href="#services" class="hover:text-cyan-400">Услуги</a>
            <a href="#calculator" class="hover:text-cyan-400">Калькулятор</a>
            <a href="#prices" class="hover:text-cyan-400">Цены</a>
            <a href="#why" class="hover:text-cyan-400">Почему мы</a>
            <a href="#reviews" class="hover:text-cyan-400">Отзывы</a>
            <a href="#faq" class="hover:text-cyan-400">Вопросы</a>
            <a href="#contact" class="hover:text-cyan-400">Контакты</a>
        </div>
        <div class="flex items-center gap-x-5">
            <a href="tel:+37064474842" class="hidden md:flex items-center gap-2 bg-white text-black font-semibold px-7 h-12 rounded-3xl hover:bg-cyan-400 hover:text-white">
                <i class="fa-solid fa-phone"></i> +370 644 74842
            </a>
            <a href="https://wa.me/37064474842" target="_blank" class="text-3xl text-emerald-400 hover:scale-110"><i class="fa-brands fa-whatsapp"></i></a>
            <a href="https://t.me/+37064474842" target="_blank" class="text-3xl text-sky-400 hover:scale-110"><i class="fa-brands fa-telegram"></i></a>
            <a href="viber://chat?number=%2B37064474842" target="_blank" class="text-3xl text-purple-400 hover:scale-110"><i class="fa-brands fa-viber"></i></a>
            <button onclick="toggleMobileMenu()" class="lg:hidden text-4xl text-white p-2">
                <i id="burger-icon" class="fa-solid fa-bars"></i>
            </button>
        </div>
    </div>

    <!-- Полное мобильное меню -->
    <div id="mobile-menu" class="hidden lg:hidden bg-black border-t border-white/10 px-6 py-10">
        <div class="flex flex-col gap-y-6 text-white text-2xl font-medium">
            <a href="#services" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Услуги</a>
            <a href="#calculator" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Калькулятор стоимости</a>
            <a href="#prices" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Цены</a>
            <a href="#why" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Почему мы</a>
            <a href="#reviews" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Отзывы</a>
            <a href="#faq" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Часто задаваемые вопросы</a>
            <a href="#contact" onclick="toggleMobileMenu()" class="py-3">Контакты</a>
            <div class="pt-8 flex flex-col gap-4">
                <a href="tel:+37064474842" onclick="toggleMobileMenu()" class="text-center bg-white text-black py-5 rounded-3xl font-bold">Позвонить +370 644 74842</a>
                <div class="grid grid-cols-3 gap-3">
                    <a href="https://wa.me/37064474842" target="_blank" onclick="toggleMobileMenu()" class="text-center py-5 bg-emerald-500 text-white rounded-3xl">WhatsApp</a>
                    <a href="https://t.me/+37064474842" target="_blank" onclick="toggleMobileMenu()" class="text-center py-5 bg-sky-500 text-white rounded-3xl">Telegram</a>
                    <a href="viber://chat?number=%2B37064474842" target="_blank" onclick="toggleMobileMenu()" class="text-center py-5 bg-purple-500 text-white rounded-3xl">Viber</a>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero-bg text-white min-h-screen flex items-center relative">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="grid lg:grid-cols-2 gap-12 items-center pt-12 lg:pt-0">
            <div class="space-y-8">
                <div class="inline-flex bg-white/10 px-6 py-3 rounded-3xl text-sm font-medium">
                    Вильнюс и окрестности • 24/7 • Выезд за 60 минут • Безналичный расчёт
                </div>
                <h1 class="heading-font text-5xl md:text-6xl lg:text-7xl font-semibold leading-none tracking-[-2px]">
                    Уборка после ремонта Вильнюс<br>Уборка офисов Вильнюс<br>Клининг коммерческих помещений
                </h1>
                <p class="text-2xl text-white/80">Профессиональная клининговая компания Ukrbud.lt предлагает качественную уборку после ремонта, генеральную уборку офисов и клининг коммерческих объектов по лучшим ценам в Вильнюсе. Используем современное оборудование и экологичные средства. Калькулятор стоимости онлайн.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="#calculator" class="px-10 py-6 bg-cyan-400 text-black font-bold text-xl rounded-3xl hover:bg-cyan-300">Рассчитать стоимость онлайн</a>
                    <a href="tel:+37064474842" class="px-10 py-6 border border-white/40 text-xl font-bold rounded-3xl hover:bg-white/10">Позвонить +370 644 74842</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES -->
<section id="services" class="py-24 bg-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="text-center mb-12">
            <h2 class="heading-font text-5xl font-semibold">Услуги клинингa в Вильнюсе</h2>
        </div>
        <p class="max-w-4xl mx-auto text-center text-xl text-gray-600 mb-16">
            Мы специализируемся на <strong>уборке после ремонта Вильнюс</strong>. Наша команда быстро и качественно удаляет строительную пыль, остатки краски, штукатурки, шпаклёвки и другой мусор после ремонта или стройки. Также выполняем регулярную <strong>уборку офисов Вильнюс</strong> и <strong>клининг коммерческих помещений Вильнюс</strong> — магазины, салоны, кафе, склады, медицинские центры.
        </p>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="service-card bg-white border border-gray-100 rounded-3xl p-10 shadow-xl">
                <div class="text-6xl mb-6">🏗️</div>
                <h3 class="text-3xl font-semibold">Уборка после ремонта Вильнюс</h3>
                <p class="text-gray-600 mt-4">Полный цикл профессиональной уборки после ремонта: удаление строительной пыли со всех поверхностей, мойка окон, чистка потолков, люстр, плинтусов, радиаторов и полов. После нашей бригады помещение выглядит как новое. Выезд в течение 60 минут по всему Вильнюсу.</p>
                <div class="mt-8 text-cyan-400 font-semibold">от 2.8 €/м²</div>
            </div>
            <div class="service-card bg-white border border-gray-100 rounded-3xl p-10 shadow-xl">
                <div class="text-6xl mb-6">🏢</div>
                <h3 class="text-3xl font-semibold">Уборка офисов Вильнюс</h3>
                <p class="text-gray-600 mt-4">Ежедневная, еженедельная и генеральная уборка офисов любого размера. Чистые рабочие места, санузлы, кухни, переговорные комнаты. Поддерживаем высокий уровень чистоты для вашего бизнеса. Регулярные клиенты получают скидки до 25%.</p>
                <div class="mt-8 text-cyan-400 font-semibold">от 2.5 €/м²</div>
            </div>
            <div class="service-card bg-white border border-gray-100 rounded-3xl p-10 shadow-xl">
                <div class="text-6xl mb-6">🛒</div>
                <h3 class="text-3xl font-semibold">Клининг коммерческих помещений Вильнюс</h3>
                <p class="text-gray-600 mt-4">Качественный клининг для магазинов, салонов красоты, кафе, ресторанов, складов и медицинских центров. Глубокая чистка, дезинфекция, индивидуальный подход к каждому объекту. Работаем без выходных 24/7.</p>
                <div class="mt-8 text-cyan-400 font-semibold">Индивидуально</div>
            </div>
        </div>
    </div>
</section>

<!-- КАЛЬКУЛЯТОР СТОИМОСТИ (улучшенный) -->
<section id="calculator" class="py-24 bg-gray-50">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="text-center mb-12">
            <h2 class="heading-font text-5xl font-semibold">Калькулятор стоимости уборки Вильнюс</h2>
            <p class="text-xl text-gray-600 mt-4">Узнайте предварительную цену за 20 секунд. Точная стоимость после выезда специалиста.</p>
        </div>

        <div class="max-w-2xl mx-auto bg-white rounded-3xl shadow-2xl p-10">
            <div class="space-y-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Тип услуги</label>
                    <select id="service-type" class="w-full border border-gray-300 rounded-3xl px-6 py-5 text-lg focus:outline-none focus:border-cyan-400">
                        <option value="post-repair">Уборка после ремонта Вильнюс</option>
                        <option value="office">Уборка офисов Вильнюс</option>
                        <option value="commercial">Клининг коммерческих помещений</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Площадь помещения (м²)</label>
                    <input type="number" id="area" value="100" min="10" class="w-full border border-gray-300 rounded-3xl px-6 py-5 text-lg focus:outline-none focus:border-cyan-400">
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <label class="flex items-center gap-3 cursor-pointer text-lg">
                        <input type="checkbox" id="windows" class="w-6 h-6 accent-cyan-400"> Мойка окон
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer text-lg">
                        <input type="checkbox" id="furniture" class="w-6 h-6 accent-cyan-400"> Химчистка мебели
                    </label>
                </div>

                <button onclick="calculatePrice()" 
                        class="w-full py-7 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold text-2xl rounded-3xl hover:brightness-110 transition">
                    Рассчитать стоимость
                </button>

                <div id="calc-result" class="hidden text-center mt-8 p-10 bg-gradient-to-br from-gray-50 to-white rounded-3xl">
                    <p class="text-gray-600 text-xl">Предварительная стоимость:</p>
                    <div id="result-price" class="calc-result mt-4">0 €</div>
                    <p class="text-sm text-gray-500 mt-6">* Это ориентировочная цена. Финальную стоимость уточнит менеджер после осмотра.</p>
                    <a href="#contact" class="mt-8 inline-block px-12 py-5 bg-black text-white font-semibold text-xl rounded-3xl hover:bg-cyan-400 hover:text-black">Заказать уборку по этой цене</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PRICES -->
<section id="prices" class="py-24 bg-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <h2 class="heading-font text-5xl text-center mb-4">Цены на уборку после ремонта Вильнюс и уборку офисов</h2>
        <div class="overflow-x-auto mt-12 rounded-3xl bg-white shadow-2xl">
            <table class="w-full min-w-[900px]">
                <thead>
                    <tr class="border-b">
                        <th class="pl-10 py-7 text-left font-medium text-gray-500">Услуга</th>
                        <th class="pl-10 py-7 text-left font-medium text-gray-500">Площадь</th>
                        <th class="pr-10 py-7 text-right font-medium text-gray-500">Цена от</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="price-row border-b">
                        <td class="pl-10 py-7 font-medium">Уборка после ремонта Вильнюс</td>
                        <td class="pl-10 py-7">до 100 м²</td>
                        <td class="pr-10 py-7 text-right font-semibold text-emerald-600">2.8 €/м²</td>
                    </tr>
                    <tr class="price-row border-b">
                        <td class="pl-10 py-7 font-medium">Уборка после ремонта Вильнюс</td>
                        <td class="pl-10 py-7">100–300 м²</td>
                        <td class="pr-10 py-7 text-right font-semibold text-emerald-600">2.5 €/м²</td>
                    </tr>
                    <tr class="price-row border-b">
                        <td class="pl-10 py-7 font-medium">Уборка офисов Вильнюс (ежедневная/генеральная)</td>
                        <td class="pl-10 py-7">до 200 м²</td>
                        <td class="pr-10 py-7 text-right font-semibold text-emerald-600">2.5 €/м²</td>
                    </tr>
                    <tr class="price-row border-b">
                        <td class="pl-10 py-7 font-medium">Клининг коммерческих помещений Вильнюс</td>
                        <td class="pl-10 py-7">от 50 м²</td>
                        <td class="pr-10 py-7 text-right font-semibold text-emerald-600">3 €/м²</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- BIG SEO TEXT + ABOUT -->
<section id="about" class="py-24 bg-gray-50">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <h2 class="heading-font text-5xl text-center mb-12">Почему стоит выбрать Ukrbud.lt для уборки после ремонта Вильнюс</h2>
        <div class="prose prose-lg max-w-4xl mx-auto text-gray-700 leading-relaxed space-y-8">
            <p>Если вам нужна качественная <strong>уборка после ремонта Вильнюс</strong> — обращайтесь в профессиональную клининговая компанию Ukrbud.lt. Мы быстро и тщательно убираем квартиры, дома, офисы и коммерческие помещения после строительных и ремонтных работ. Наша бригада удаляет всю строительную пыль, остатки краски, штукатурки, шпаклёвки, клея и другого мусора. Мы моем окна, подоконники, потолки, люстры, плинтуса, радиаторы и все поверхности до идеального блеска.</p>

            <p>Помимо <strong>уборки после ремонта Вильнюс</strong> мы предлагаем регулярную <strong>уборку офисов Вильнюс</strong>. Чистый офис повышает продуктивность сотрудников и создаёт хорошее впечатление у клиентов. Мы выполняем ежедневную, еженедельную и генеральную уборку офисных помещений любого размера. Для постоянных клиентов действуют выгодные абонементы со скидкой до 25%.</p>

            <p><strong>Клининг коммерческих помещений Вильнюс</strong> — ещё одно важное направление нашей работы. Мы обслуживаем магазины, салоны красоты, кафе, рестораны, медицинские центры и склады. Каждый объект получает индивидуальный план уборки, использование профессиональных эко-средств и тщательную дезинфекцию.</p>

            <p>Мы работаем 24 часа в сутки 7 дней в неделю, принимаем только безналичный расчёт, используем современное профессиональное оборудование и гарантируем высокое качество. Многие клиенты отмечают, что мы значительно лучше конкурентов по скорости выезда, качеству работ и прозрачным ценам.</p>

            <p>Нужна уборка после ремонта в Вильнюсе или регулярная уборка офисов? Звоните +370 644 74842 или оставляйте заявку на сайте. Мы оперативно свяжемся с вами, рассчитаем стоимость и приедем в удобное для вас время.</p>
        </div>
    </div>
</section>

<!-- WHY US -->
<section id="why" class="py-24 bg-black text-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <h2 class="heading-font text-5xl text-center mb-12">Почему клиенты выбирают Ukrbud.lt вместо других компаний</h2>
        <div class="grid md:grid-cols-4 gap-10 text-center">
            <div>
                <div class="text-6xl mb-4">⏱️</div>
                <h4 class="text-2xl font-medium">Выезд за 60 минут</h4>
                <p class="text-white/70 mt-3">По всему Вильнюсу и ближайшим окрестностям</p>
            </div>
            <div>
                <div class="text-6xl mb-4">🌿</div>
                <h4 class="text-2xl font-medium">Экологичные средства</h4>
                <p class="text-white/70 mt-3">Безопасно для детей, животных и аллергиков</p>
            </div>
            <div>
                <div class="text-6xl mb-4">💳</div>
                <h4 class="text-2xl font-medium">Безналичный расчёт</h4>
                <p class="text-white/70 mt-3">Карты, банковский перевод, Revolut</p>
            </div>
            <div>
                <div class="text-6xl mb-4">⭐</div>
                <h4 class="text-2xl font-medium">Гарантия качества</h4>
                <p class="text-white/70 mt-3">Если что-то не понравится — приедем бесплатно</p>
            </div>
        </div>
    </div>
</section>
<!-- Блок "Наши партнёры" -->
<section class="py-20 bg-white border-t border-gray-100">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="text-center mb-12">
            <h2 class="heading-font text-4xl font-semibold text-gray-900">Наши партнёры</h2>
            <p class="text-gray-600 mt-3 text-lg">Мы сотрудничаем с надёжными компаниями для предоставления лучшего сервиса</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center justify-items-center">
            
            <a href="https://balticclean.lt" target="_blank" class="group flex flex-col items-center justify-center p-8 bg-gray-50 hover:bg-white border border-gray-100 hover:border-cyan-200 rounded-3xl transition-all duration-300 hover:shadow-xl">
                <div class="w-28 h-28 flex items-center justify-center text-6xl mb-6 group-hover:scale-110 transition-transform">🧼</div>
                <span class="font-semibold text-xl text-gray-800 group-hover:text-cyan-600 transition-colors">Baltic Clean</span>
                <span class="text-sm text-gray-500 mt-1">Профессиональный клининг</span>
            </a>

            <a href="https://meistru.lt" target="_blank" class="group flex flex-col items-center justify-center p-8 bg-gray-50 hover:bg-white border border-gray-100 hover:border-cyan-200 rounded-3xl transition-all duration-300 hover:shadow-xl">
                <div class="w-28 h-28 flex items-center justify-center text-6xl mb-6 group-hover:scale-110 transition-transform">🔧</div>
                <span class="font-semibold text-xl text-gray-800 group-hover:text-cyan-600 transition-colors">Meistru.lt</span>
                <span class="text-sm text-gray-500 mt-1">Ремонтные услуги</span>
            </a>

            <a href="https://bilohash.com" target="_blank" class="group flex flex-col items-center justify-center p-8 bg-gray-50 hover:bg-white border border-gray-100 hover:border-cyan-200 rounded-3xl transition-all duration-300 hover:shadow-xl">
                <div class="w-28 h-28 flex items-center justify-center text-5xl mb-6 group-hover:scale-110 transition-transform">💻</div>
                <span class="font-semibold text-xl text-gray-800 group-hover:text-cyan-600 transition-colors">Bilohash.com</span>
                <span class="text-sm text-gray-500 mt-1">Веб-разработка и цифровые решения</span>
            </a>

            <div class="flex flex-col items-center justify-center p-8 bg-gray-50 border border-dashed border-gray-200 rounded-3xl opacity-60">
                <div class="w-28 h-28 flex items-center justify-center text-6xl mb-6">🤝</div>
                <span class="font-semibold text-xl text-gray-400">Стань нашим партнёром</span>
            </div>
        </div>
    </div>
</section>
<!-- REVIEWS -->
<section id="reviews" class="py-24 bg-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <h2 class="heading-font text-5xl text-center mb-12">Отзывы о нашей уборке после ремонта и офисов</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-gray-50 p-8 rounded-3xl">
                <p class="italic">"Отличная уборка после ремонта Вильнюс! Квартира 95 м² после стройки сияла чистотой уже через 5 часов. Очень рекомендую Ukrbud.lt!"</p>
                <div class="mt-6 text-sm font-medium">— Анна, район Пашилайчяй</div>
            </div>
            <div class="bg-gray-50 p-8 rounded-3xl">
                <p class="italic">"Регулярная уборка офисов Вильнюс на 220 м². Всё всегда вовремя, качественно и по приятной цене. Безналичный расчёт — очень удобно для компании."</p>
                <div class="mt-6 text-sm font-medium">— Дмитрий, руководитель IT-компании</div>
            </div>
            <div class="bg-gray-50 p-8 rounded-3xl">
                <p class="italic">"Клининг коммерческого помещения после ремонта. Сделали идеально чисто. Теперь заказываем уборку каждый месяц. Спасибо за профессионализм!"</p>
                <div class="mt-6 text-sm font-medium">— Мария, владелица салона красоты</div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section id="faq" class="py-24 bg-gray-50">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <h2 class="heading-font text-5xl text-center mb-12">Часто задаваемые вопросы об уборке в Вильнюсе</h2>
        <div class="max-w-4xl mx-auto space-y-6">
            <details class="bg-white p-8 rounded-3xl shadow-sm">
                <summary class="text-xl font-semibold cursor-pointer">Сколько стоит уборка после ремонта Вильнюс?</summary>
                <p class="mt-6 text-gray-600">Цена начинается от 2.8 €/м² в зависимости от площади и сложности работ. Используйте наш онлайн-калькулятор выше для предварительного расчёта.</p>
            </details>
            <details class="bg-white p-8 rounded-3xl shadow-sm">
                <summary class="text-xl font-semibold cursor-pointer">Как быстро вы приезжаете на уборку офисов Вильнюс?</summary>
                <p class="mt-6 text-gray-600">Мы гарантируем выезд бригады в течение 60 минут после подтверждения заявки по всему Вильнюсу.</p>
            </details>
            <details class="bg-white p-8 rounded-3xl shadow-sm">
                <summary class="text-xl font-semibold cursor-pointer">Работаете ли вы с коммерческими помещениями?</summary>
                <p class="mt-6 text-gray-600">Да, мы выполняем клининг коммерческих помещений Вильнюс: магазины, кафе, салоны, склады и медицинские центры.</p>
            </details>
            <details class="bg-white p-8 rounded-3xl shadow-sm">
                <summary class="text-xl font-semibold cursor-pointer">Используете ли вы экологичные средства?</summary>
                <p class="mt-6 text-gray-600">Да, все средства безопасны для детей, животных и людей с аллергией.</p>
            </details>
            <!-- Можно добавить ещё деталей, если нужно -->
        </div>
    </div>
</section>

<!-- CONTACT FORM -->
<section id="contact" class="py-24 bg-gradient-to-br from-cyan-600 to-blue-700 text-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="grid lg:grid-cols-2 gap-16">
            <div>
                <h2 class="heading-font text-5xl font-semibold">Оставить заявку на уборку</h2>
                <p class="mt-6 text-xl">Заполните форму, и наш менеджер свяжется с вами в течение нескольких минут для уточнения деталей.</p>

                <?php if ($success): ?>
                    <div class="mt-10 bg-emerald-400 text-black p-8 rounded-3xl text-center text-2xl font-medium">✅ Заявка успешно отправлена! Спасибо, мы скоро свяжемся с вами.</div>
                <?php elseif ($error): ?>
                    <div class="mt-10 bg-red-500 p-8 rounded-3xl text-center"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST" class="mt-10 space-y-8">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <input type="text" name="name" required placeholder="Ваше имя" class="w-full bg-white/10 border border-white/30 rounded-3xl px-8 py-6 text-white placeholder-white/60 focus:outline-none">
                    <input type="tel" name="phone" required placeholder="+370 644 74842" class="w-full bg-white/10 border border-white/30 rounded-3xl px-8 py-6 text-white placeholder-white/60 focus:outline-none">
                    <textarea name="message" rows="5" placeholder="Опишите задачу (уборка после ремонта квартиры, офис 150 м² и т.д.)" class="w-full bg-white/10 border border-white/30 rounded-3xl px-8 py-6 text-white placeholder-white/60 focus:outline-none"></textarea>
                    <!-- reCAPTCHA v2 -->
                    <?php renderRecaptcha(); ?>
					<button type="submit" name="submit_order" class="w-full py-7 bg-white text-black font-bold text-2xl rounded-3xl hover:bg-cyan-300">Отправить заявку</button>
                </form>
            </div>
            <div class="flex flex-col justify-center items-center lg:items-start text-center lg:text-left">
                <div class="text-7xl flex gap-12 mb-12">
                    <a href="https://wa.me/37064474842" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="https://t.me/+37064474842" target="_blank"><i class="fa-brands fa-telegram"></i></a>
                    <a href="viber://chat?number=%2B37064474842" target="_blank"><i class="fa-brands fa-viber"></i></a>
                </div>
                <a href="tel:+37064474842" class="text-5xl font-bold hover:text-cyan-200">+370 644 74842</a>
                <p class="mt-4 text-xl">Звоните или пишите в мессенджеры в любое время</p>
            </div>
        </div>
    </div>
</section>
<!-- Блок подписки на скидку 30% -->
<section class="py-24 bg-gradient-to-br from-black via-zinc-900 to-black text-white relative overflow-hidden">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="max-w-2xl mx-auto text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-cyan-500/10 rounded-3xl mb-8">
                <span class="text-5xl">🎁</span>
            </div>

            <h2 class="heading-font text-5xl lg:text-6xl font-semibold leading-none tracking-[-1px] mb-6">
                Подпишись и получи <span class="text-cyan-400">30% скидку</span>
            </h2>
            
            <p class="text-xl text-white/80 mb-10 max-w-md mx-auto">
                На первую уборку после ремонта, офисов или коммерческого помещения.<br>
                Скидка действует 30 дней после подписки.
            </p>

            <form id="subscribe-form" class="max-w-md mx-auto">
                <div class="flex flex-col sm:flex-row gap-3">
                    <input 
                        type="email" 
                        id="email" 
                        name="email"
                        required
                        placeholder="Ваш email адрес"
                        class="flex-1 bg-white/10 border border-white/30 rounded-3xl px-8 py-6 text-white placeholder-white/60 focus:outline-none focus:border-cyan-400 transition-all text-lg">
                    
                    <button 
                        type="submit"
                        class="bg-cyan-400 hover:bg-cyan-300 transition-all text-black font-bold text-lg px-10 py-6 rounded-3xl whitespace-nowrap">
                        Получить скидку
                    </button>
                </div>
                
                <p class="text-xs text-white/50 mt-4">
                    Мы уважаем вашу приватность. Отписаться можно в любой момент.
                </p>
            </form>

            <div id="subscribe-success" class="hidden mt-8 bg-emerald-500/20 border border-emerald-400 text-emerald-300 p-6 rounded-3xl">
                ✅ Спасибо! Скидка 30% отправлена на ваш email. Проверьте почту.
            </div>

            <div id="subscribe-error" class="hidden mt-8 bg-red-500/20 border border-red-400 text-red-300 p-6 rounded-3xl">
                ❌ Ошибка. Попробуйте позже или напишите нам напрямую.
            </div>
        </div>
    </div>
</section>
<!-- FOOTER -->
<footer class="bg-black py-20 text-white/70 relative overflow-hidden">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="grid md:grid-cols-3 gap-12 items-center">
            <div class="text-center md:text-left">
                <div class="flex justify-center md:justify-start items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-3xl flex items-center justify-center text-4xl">🇺🇦</div>
                    <span class="heading-font text-5xl font-semibold tracking-[-2px]">ukrbud.lt</span>
                </div>
                <p class="text-sm max-w-xs mx-auto md:mx-0">Профессиональная уборка после ремонта, офисов и коммерческих помещений в Вильнюсе с 2018 года.</p>
            </div>

            <div class="text-center">
                <h4 class="text-white text-lg font-semibold mb-6">Быстрые ссылки</h4>
                <div class="flex flex-col gap-y-3 text-sm">
                    <a href="#services" class="hover:text-cyan-400">Услуги</a>
                    <a href="#calculator" class="hover:text-cyan-400">Калькулятор</a>
                    <a href="#prices" class="hover:text-cyan-400">Цены</a>
                    <a href="#faq" class="hover:text-cyan-400">Вопросы</a>
                </div>
            </div>

            <div class="text-center md:text-right">
                <a href="tel:+37064474842" class="block text-4xl font-bold text-white hover:text-cyan-400 mb-2">+370 644 74842</a>
                <div class="flex justify-center md:justify-end gap-6 text-3xl mt-8">
                    <a href="https://wa.me/37064474842" target="_blank" class="hover:text-emerald-400"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="https://t.me/+37064474842" target="_blank" class="hover:text-sky-400"><i class="fa-brands fa-telegram"></i></a>
                    <a href="viber://chat?number=%2B37064474842" target="_blank" class="hover:text-purple-400"><i class="fa-brands fa-viber"></i></a>
                </div>
            </div>
        </div>

        <div class="border-t border-white/10 my-12"></div>

        <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-sm">
            <p class="text-center md:text-left">© 2025–2026 Ukrbud.lt — Уборка после ремонта Вильнюс, уборка офисов Вильнюс, клининг коммерческих помещений Вильнюс</p>

            <a href="https://bilohash.com" target="_blank" class="want-site-btn group inline-flex items-center gap-4 bg-gradient-to-r from-cyan-500 via-blue-500 to-cyan-500 text-white font-semibold text-xl px-12 py-6 rounded-3xl glow-animation">
                <span class="relative z-10 flex items-center gap-3">
                    ХОЧУ ТАКОЙ САЙТ!
                    <i class="fa-solid fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                </span>
            </a>

            <?php include 'counter.php'; ?>
        </div>
    </div>
</footer>

<!-- Языковой виджет с автосменой флага (слева внизу) -->
<div id="language-widget" class="fixed bottom-6 left-6 z-[100]">
    <button onclick="toggleLanguageMenu()" 
            id="lang-button"
            class="bg-white shadow-2xl hover:shadow-2xl w-16 h-16 rounded-3xl flex items-center justify-center border border-gray-200 hover:border-cyan-400 transition-all duration-300 overflow-hidden">
        <!-- Флаг будет меняться автоматически -->
        <span id="current-flag" class="text-4xl transition-all duration-700">🇷🇺</span>
    </button>

    <!-- Меню выбора языка -->
    <div id="language-menu" class="hidden mt-4 bg-white rounded-3xl shadow-2xl py-4 px-3 border border-gray-100 w-60">
        <a href="ru.php" class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 rounded-2xl transition-all">
            <span class="text-3xl">🇷🇺</span>
            <div>
                <span class="font-semibold text-gray-900">Русский</span>
                <span class="block text-xs text-gray-500">RU</span>
            </div>
        </a>
        
        <a href="ua.php" class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 rounded-2xl transition-all">
            <span class="text-3xl">🇺🇦</span>
            <div>
                <span class="font-semibold text-gray-900">Українська</span>
                <span class="block text-xs text-gray-500">UA</span>
            </div>
        </a>
        
        <a href="en.php" class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 rounded-2xl transition-all">
            <span class="text-3xl">🇬🇧</span>
            <div>
                <span class="font-semibold text-gray-900">English</span>
                <span class="block text-xs text-gray-500">EN</span>
            </div>
        </a>
        
        <a href="index.php" class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 rounded-2xl transition-all">
            <span class="text-3xl">🇱🇹</span>
            <div>
                <span class="font-semibold text-gray-900">Lietuvių</span>
                <span class="block text-xs text-gray-500">LT</span>
            </div>
        </a>
    </div>
</div>
<script>
// Обработка подписки через AJAX
document.getElementById('subscribe-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const emailInput = document.getElementById('email');
    const email = emailInput.value.trim();
    const successDiv = document.getElementById('subscribe-success');
    const errorDiv = document.getElementById('subscribe-error');
    
    if (!email) return;

    // Отключаем кнопку на время отправки
    const button = this.querySelector('button');
    const originalText = button.textContent;
    button.textContent = 'Отправляем...';
    button.disabled = true;

    fetch(window.location.href, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'subscribe_email=' + encodeURIComponent(email)
    })
    .then(response => response.text())
    .then(() => {
        successDiv.classList.remove('hidden');
        errorDiv.classList.add('hidden');
        emailInput.value = '';
        
        setTimeout(() => {
            successDiv.classList.add('hidden');
        }, 7000);
    })
    .catch(() => {
        errorDiv.classList.remove('hidden');
        setTimeout(() => errorDiv.classList.add('hidden'), 5000);
    })
    .finally(() => {
        button.textContent = originalText;
        button.disabled = false;
    });
});
</script>
<script>
    const flags = ['🇷🇺', '🇺🇦', '🇬🇧', '🇱🇹'];
    let currentIndex = 0;
    let interval;

    function changeFlag() {
        currentIndex = (currentIndex + 1) % flags.length;
        const flagElement = document.getElementById('current-flag');
        
        // Плавная анимация смены флага
        flagElement.style.opacity = '0';
        flagElement.style.transform = 'scale(0.7) rotate(-15deg)';
        
        setTimeout(() => {
            flagElement.textContent = flags[currentIndex];
            flagElement.style.opacity = '1';
            flagElement.style.transform = 'scale(1) rotate(0deg)';
        }, 300);
    }

    // Запускаем автосмену флага каждые 2 секунды
    function startFlagRotation() {
        interval = setInterval(changeFlag, 2000);
    }

    function toggleLanguageMenu() {
        const menu = document.getElementById('language-menu');
        menu.classList.toggle('hidden');
        
        // Если меню открыто — останавливаем автосмену, чтобы не мешала
        if (!menu.classList.contains('hidden')) {
            clearInterval(interval);
        } else {
            startFlagRotation(); // Возобновляем при закрытии
        }
    }

    // Закрываем меню при клике вне виджета
    document.addEventListener('click', function(e) {
        const widget = document.getElementById('language-widget');
        if (!widget.contains(e.target)) {
            document.getElementById('language-menu').classList.add('hidden');
            startFlagRotation();
        }
    });

    // Запускаем всё при загрузке страницы
    window.addEventListener('load', () => {
        startFlagRotation();
    });

    // Закрываем меню при нажатии Esc
    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape") {
            document.getElementById('language-menu').classList.add('hidden');
            startFlagRotation();
        }
    });
</script>

<style>
    #lang-button {
        box-shadow: 0 15px 25px -5px rgb(0 0 0 / 0.15), 
                    0 8px 10px -6px rgb(0 0 0 / 0.1);
    }
    
    #lang-button:hover {
        transform: scale(1.08);
    }

    #language-menu {
        animation: languageMenuPop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }

    @keyframes languageMenuPop {
        from {
            opacity: 0;
            transform: translateY(20px) scale(0.9);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    #current-flag {
        display: inline-block;
        transition: all 0.4s ease;
    }
</style>
<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const icon = document.getElementById('burger-icon');
        menu.classList.toggle('hidden');
        icon.classList.toggle('fa-bars');
        icon.classList.toggle('fa-xmark');
    }

    function calculatePrice() {
        const area = parseFloat(document.getElementById('area').value) || 50;
        const type = document.getElementById('service-type').value;
        let basePrice = 3.2;

        if (type === 'post-repair') basePrice = 3.5;
        else if (type === 'office') basePrice = 2.7;
        else if (type === 'commercial') basePrice = 4.0;

        let total = area * basePrice;
        if (document.getElementById('windows').checked) total += area * 1.5;
        if (document.getElementById('furniture').checked) total += 120;

        document.getElementById('result-price').textContent = Math.round(total) + ' €';
        document.getElementById('calc-result').classList.remove('hidden');
    }

    console.log('%c✅ Полный index.php готов! Ukrbud.lt теперь мощнее pelenes.lt по SEO и функционалу', 'color:#22d3ee; font-size:15px; font-weight:700');
</script>

<!-- AI Consultant Chat Widget -->
<script src="/ai/chat.js?v=<?= time() ?>"></script>

<style>
    @media (max-width: 480px) {
        #grok-chat {
            width: 100% !important;
            height: 100% !important;
            bottom: 0 !important;
            right: 0 !important;
            border-radius: 0 !important;
        }
    }
</style>
<?php include 'gdpr-consent.php'; ?>
</body>
</html>
