<?php
// ========================================================
// Ukrbud.lt - ua.php (Повна потужна версія 2026)
// Максимальний SEO + найкращий калькулятор + красиві листи
// ========================================================
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Змінні для форми замовлення
$success = false;
$error = '';

// ========================================================
// ОБРОБКА ФОРМИ ЗАМОВЛЕННЯ — з красивими листами
// ========================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_order'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = 'Помилка безпеки. Оновіть сторінку.';
    } else {
        $name    = trim(htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES));
        $phone   = trim(htmlspecialchars($_POST['phone'] ?? '', ENT_QUOTES));
        $message = trim(htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES));

        if (empty($name) || empty($phone)) {
            $error = 'Ім’я та номер телефону обов’язкові!';
        } elseif (!preg_match('/^[\+]?[\d\s\-\(\)]{10,18}$/', $phone)) {
            $error = 'Невірний формат номера телефону!';
        } else {
            $order_id = "UKR-" . date("YmdHis");

            // ==================== ЛИСТ КЛІЄНТУ (гарний HTML) ====================
            $client_subject = "✅ Замовлення №$order_id прийнято | Ukrbud.lt";

            $client_message = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Замовлення прийнято</title>
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
                        <h1 style="margin:0; font-size:32px;">Ваше замовлення успішно прийнято!</h1>
                        <p style="margin:15px 0 0; font-size:20px;">Номер замовлення: <strong>' . $order_id . '</strong></p>
                    </div>
                   
                    <div class="content">
                        <p>Вітаємо, <strong>' . $name . '</strong>!</p>
                        <p>Дякуємо за довіру до <strong>Ukrbud.lt</strong> — професійної клінінгової компанії у Вільнюсі.</p>
                       
                        <div class="info-box">
                            <strong>Ваше замовлення №' . $order_id . ' прийнято та обробляється.</strong><br><br>
                            Наш менеджер зв’яжеться з вами протягом 15–60 хвилин для уточнення деталей та призначення зручного часу приїзду бригади.
                        </div>

                        <p><strong>Дані вашого замовлення:</strong></p>
                        <p>Ім’я: ' . $name . '<br>
                           Телефон: ' . $phone . '<br>
                           Повідомлення: ' . nl2br($message) . '</p>

                        <p style="text-align:center;">
                            <a href="tel:+37064474842" class="button">Зателефонувати нам зараз →</a>
                        </p>

                        <p>Якщо з’явилися додаткові побажання — просто відповідайте на цей лист.</p>
                    </div>
                   
                    <div class="footer">
                        З повагою,<br>
                        <strong>Команда Ukrbud.lt</strong><br>
                        Професійне прибирання після ремонту • Прибирання офісів • Прибирання комерційних приміщень<br>
                        Вільнюс • +370 644 74842
                    </div>
                </div>
            </body>
            </html>';

            // ==================== ЛИСТ АДМІНУ (тобі) ====================
            $admin_subject = "Нове замовлення №$order_id — Ukrbud.lt";
            $admin_body = "НОВЕ ЗАМОВЛЕННЯ НА ПРИБИРАННЯ\n\n";
            $admin_body .= "Номер замовлення: $order_id\n";
            $admin_body .= "Ім’я: $name\n";
            $admin_body .= "Телефон: $phone\n";
            $admin_body .= "Повідомлення:\n$message\n\n";
            $admin_body .= "Дата: " . date('d.m.Y H:i:s') . "\n";
            $admin_body .= "IP: " . $_SERVER['REMOTE_ADDR'] . "\n";

            $admin_headers = "From: no-reply@ukrbud.lt\r\nContent-Type: text/plain; charset=utf-8\r\n";

            // Відправка листів
            $headers_client = "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Ukrbud.lt <no-reply@ukrbud.lt>\r\n";

            mail("rbilohash@gmail.com, valeriapilipiuk@gmail.com, ulianasemashko@gmail.com, booking@balticclean.lt", $admin_subject, $admin_body, $admin_headers);
            mail($email ?? "rbilohash@gmail.com", $client_subject, $client_message, $headers_client);

            $success = true;
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }
}

// ========================================================
// Обробка підписки на знижку 30%
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
           
            $subject = "🎁 Ваша знижка 30% на прибирання у Вільнюсі від Ukrbud.lt";
           
            $message = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Ваша знижка 30%</title>
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
                        <h1 style="margin:0; font-size:32px;">🎁 Вітаємо!</h1>
                        <p style="margin:10px 0 0; font-size:20px;">Ви отримали знижку 30%</p>
                    </div>
                   
                    <div class="content">
                        <p>Вітаємо!</p>
                        <p>Дякуємо, що підписалися на розсилку Ukrbud.lt — професійної клінінгової компанії у Вільнюсі.</p>
                        <p>Ваш подарунок — <strong>знижка 30% на перше прибирання</strong> (після ремонту, офісів або комерційних приміщень).</p>
                       
                        <div class="discount-box">
                            <p style="margin:0 0 10px; font-size:18px; color:#64748b;">Ваш промокод:</p>
                            <div class="code">' . $discount_code . '</div>
                            <p style="margin:15px 0 0; color:#64748b;">Діє 30 днів</p>
                        </div>
                       
                        <p style="text-align:center;">
                            <a href="https://ukrbud.lt/#contact" class="button">Замовити прибирання зі знижкою →</a>
                        </p>
                       
                        <p>Просто покажіть цей промокод нашому менеджеру при оформленні замовлення.</p>
                       
                        <p>З повагою,<br>
                        <strong>Команда Ukrbud.lt</strong><br>
                        Професійне прибирання у Вільнюсі<br>
                        +370 644 74842</p>
                    </div>
                   
                    <div class="footer">
                        © 2026 Ukrbud.lt — Прибирання після ремонту, офісів та комерційних приміщень у Вільнюсі<br>
                        Якщо ви більше не бажаєте отримувати листи — просто відповідайте на цей лист текстом «Відписатися».
                    </div>
                </div>
            </body>
            </html>';

            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=utf-8\r\n";
            $headers .= "From: Ukrbud.lt <no-reply@ukrbud.lt>\r\n";
            $headers .= "Reply-To: no-reply@ukrbud.lt\r\n";

            mail($email, $subject, $message, $headers);

            $notify_subject = "Нова підписка на знижку 30% — ukrbud.lt";
            $notify_body = "Нова підписка:\nEmail: $email\nПромокод: $discount_code\nДата: " . date('d.m.Y H:i:s') . "\nIP: " . $_SERVER['REMOTE_ADDR'];
            $notify_headers = "From: no-reply@ukrbud.lt\r\nContent-Type: text/plain; charset=utf-8\r\n";
           
            mail("rbilohash@gmail.com, valeriapilipiuk@gmail.com, ulianasemashko@gmail.com, booking@balticclean.lt", $notify_subject, $notify_body, $notify_headers);
        }
       
        $subscribe_success = true;
    } else {
        $subscribe_error = 'Введіть коректну email адресу';
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Основні SEO мета-теги -->
    <meta name="description" content="Прибирання після ремонту у Вільнюсі від 2.8 €/м² ✓ Професійне прибирання офісів у Вільнюсі ✓ Прибирання комерційних приміщень ✓ Онлайн-калькулятор вартості ✓ Виїзд бригади за 60 хвилин ✓ Працюємо 24/7 ✓ Безготівковий розрахунок ✓ Ukrbud.lt +370 644 74842">
    <meta name="keywords" content="прибирання після ремонту Вільнюс, прибирання офісів Вільнюс, клінінг Вільнюс, прибирання комерційних приміщень Вільнюс, генеральне прибирання Вільнюс, прибирання після будівництва Вільнюс, клінінгова компанія Вільнюс, valymas po remonto Vilnius">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Ukrbud.lt">
    <meta name="language" content="uk">
    <link rel="canonical" href="https://ukrbud.lt/ua.php">
<!-- Hreflang для багатомовності -->
<link rel="alternate" hreflang="en" href="https://ukrbud.lt/en.php" />
<link rel="alternate" hreflang="lt" href="https://ukrbud.lt/" />
<link rel="alternate" hreflang="ru" href="https://ukrbud.lt/ru.php" />
<link rel="alternate" hreflang="uk" href="https://ukrbud.lt/ua.php" />
<link rel="alternate" hreflang="x-default" href="https://ukrbud.lt/" />
    <title>Прибирання після ремонту Вільнюс | Прибирання офісів | Прибирання комерційних приміщень | Ukrbud.lt</title>

    <!-- Open Graph / Facebook + Instagram + Telegram -->
    <meta property="og:title" content="Прибирання після ремонту Вільнюс • Ukrbud.lt">
    <meta property="og:description" content="Професійне прибирання після ремонту, офісів та комерційних приміщень у Вільнюсі. Онлайн-калькулятор ціни. Виїзд за 60 хвилин. +370 644 74842">
    <meta property="og:image" content="https://ukrbud.lt/og-image.jpg">
    <meta property="og:url" content="https://ukrbud.lt/ua.php">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Ukrbud.lt">
    <meta property="og:locale" content="uk_UA">
    <meta property="og:locale:alternate" content="ru_RU">
    <meta property="og:locale:alternate" content="en_US">
    <meta property="og:locale:alternate" content="lt_LT">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Прибирання після ремонту Вільнюс • Ukrbud.lt">
    <meta name="twitter:description" content="Професійне прибирання після ремонту, офісів та комерційних приміщень у Вільнюсі. Онлайн-калькулятор. Виїзд за 60 хв.">
    <meta name="twitter:image" content="https://ukrbud.lt/og-image.jpg">

    <!-- Додаткові соціальні мета-теги для Telegram, WhatsApp, Messenger -->
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Прибирання після ремонту у Вільнюсі - Ukrbud.lt">

    <!-- Schema.org - Розширена розмітка -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "Ukrbud.lt",
        "description": "Професійне прибирання після ремонту, офісів та комерційних приміщень у Вільнюсі",
        "url": "https://ukrbud.lt/ua.php",
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

    <!-- Schema для послуг (Service) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Service",
        "name": "Прибирання після ремонту у Вільнюсі",
        "description": "Професійне прибирання після ремонту квартир, будинків та офісів у Вільнюсі",
        "provider": {
            "@type": "LocalBusiness",
            "name": "Ukrbud.lt"
        },
        "areaServed": "Vilnius",
        "hasOfferCatalog": {
            "@type": "OfferCatalog",
            "name": "Ціни на прибирання",
            "itemListElement": [
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "Service",
                        "name": "Прибирання після ремонту"
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
                "name": "Скільки коштує прибирання після ремонту у Вільнюсі?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Ціна починається від 2.8 €/м² залежно від площі та складності робіт."
                }
            },
            {
                "@type": "Question",
                "name": "Як швидко ви приїжджаєте на прибирання офісів у Вільнюсі?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Ми гарантуємо виїзд бригади протягом 60 хвилин після підтвердження замовлення."
                }
            }
        ]
    }
    </script>

    <!-- Favicon та іконки -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

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
            <a href="#services" class="hover:text-cyan-400">Послуги</a>
            <a href="#calculator" class="hover:text-cyan-400">Калькулятор</a>
            <a href="#prices" class="hover:text-cyan-400">Ціни</a>
            <a href="#why" class="hover:text-cyan-400">Чому ми</a>
            <a href="#reviews" class="hover:text-cyan-400">Відгуки</a>
            <a href="#faq" class="hover:text-cyan-400">Питання</a>
            <a href="#contact" class="hover:text-cyan-400">Контакти</a>
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

    <!-- Повне мобільне меню -->
    <div id="mobile-menu" class="hidden lg:hidden bg-black border-t border-white/10 px-6 py-10">
        <div class="flex flex-col gap-y-6 text-white text-2xl font-medium">
            <a href="#services" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Послуги</a>
            <a href="#calculator" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Калькулятор вартості</a>
            <a href="#prices" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Ціни</a>
            <a href="#why" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Чому ми</a>
            <a href="#reviews" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Відгуки</a>
            <a href="#faq" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Часті питання</a>
            <a href="#contact" onclick="toggleMobileMenu()" class="py-3">Контакти</a>
            <div class="pt-8 flex flex-col gap-4">
                <a href="tel:+37064474842" onclick="toggleMobileMenu()" class="text-center bg-white text-black py-5 rounded-3xl font-bold">Зателефонувати +370 644 74842</a>
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
                    Вільнюс та околиці • 24/7 • Виїзд за 60 хвилин • Безготівковий розрахунок
                </div>
                <h1 class="heading-font text-5xl md:text-6xl lg:text-7xl font-semibold leading-none tracking-[-2px]">
                    Прибирання після ремонту у Вільнюсі<br>Прибирання офісів у Вільнюсі<br>Прибирання комерційних приміщень
                </h1>
                <p class="text-2xl text-white/80">Професійна клінінгова компанія Ukrbud.lt пропонує якісне прибирання після ремонту, генеральне прибирання офісів та прибирання комерційних об’єктів за найкращими цінами у Вільнюсі. Використовуємо сучасне обладнання та екологічні засоби. Онлайн-калькулятор вартості.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="#calculator" class="px-10 py-6 bg-cyan-400 text-black font-bold text-xl rounded-3xl hover:bg-cyan-300">Розрахувати вартість онлайн</a>
                    <a href="tel:+37064474842" class="px-10 py-6 border border-white/40 text-xl font-bold rounded-3xl hover:bg-white/10">Зателефонувати +370 644 74842</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES -->
<section id="services" class="py-24 bg-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="text-center mb-12">
            <h2 class="heading-font text-5xl font-semibold">Послуги клінінгу у Вільнюсі</h2>
        </div>
        <p class="max-w-4xl mx-auto text-center text-xl text-gray-600 mb-16">
            Ми спеціалізуємося на <strong>прибиранні після ремонту у Вільнюсі</strong>. Наша команда швидко та якісно видаляє будівельний пил, залишки фарби, штукатурки, шпаклівки та інше будівельне сміття. Також виконуємо регулярне <strong>прибирання офісів у Вільнюсі</strong> та <strong>прибирання комерційних приміщень у Вільнюсі</strong> — магазини, салони краси, кафе, склади, медичні центри.
        </p>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="service-card bg-white border border-gray-100 rounded-3xl p-10 shadow-xl">
                <div class="text-6xl mb-6">🏗️</div>
                <h3 class="text-3xl font-semibold">Прибирання після ремонту у Вільнюсі</h3>
                <p class="text-gray-600 mt-4">Повний цикл професійного прибирання після ремонту: видалення будівельного пилу з усіх поверхонь, миття вікон, чищення стель, люстр, плінтусів, радіаторів та підлог. Після нашої бригади приміщення виглядає як нове. Виїзд протягом 60 хвилин по всьому Вільнюсу.</p>
                <div class="mt-8 text-cyan-400 font-semibold">від 2.8 €/м²</div>
            </div>
            <div class="service-card bg-white border border-gray-100 rounded-3xl p-10 shadow-xl">
                <div class="text-6xl mb-6">🏢</div>
                <h3 class="text-3xl font-semibold">Прибирання офісів у Вільнюсі</h3>
                <p class="text-gray-600 mt-4">Щоденне, щотижневе та генеральне прибирання офісів будь-якого розміру. Чисті робочі місця, санвузли, кухні та переговорні кімнати. Підтримуємо високий рівень чистоти для вашого бізнесу. Постійні клієнти отримують знижки до 25%.</p>
                <div class="mt-8 text-cyan-400 font-semibold">від 2.5 €/м²</div>
            </div>
            <div class="service-card bg-white border border-gray-100 rounded-3xl p-10 shadow-xl">
                <div class="text-6xl mb-6">🛒</div>
                <h3 class="text-3xl font-semibold">Прибирання комерційних приміщень у Вільнюсі</h3>
                <p class="text-gray-600 mt-4">Якісний клінінг для магазинів, салонів краси, кафе, ресторанів, складів та медичних центрів. Глибоке прибирання, дезінфекція, індивідуальний підхід до кожного об’єкта. Працюємо без вихідних 24/7.</p>
                <div class="mt-8 text-cyan-400 font-semibold">Індивідуально</div>
            </div>
        </div>
    </div>
</section>

<!-- КАЛЬКУЛЯТОР -->
<section id="calculator" class="py-24 bg-gray-50">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="text-center mb-12">
            <h2 class="heading-font text-5xl font-semibold">Калькулятор вартості прибирання у Вільнюсі</h2>
            <p class="text-xl text-gray-600 mt-4">Дізнайтеся попередню ціну за 20 секунд. Точну вартість уточнить спеціаліст після огляду.</p>
        </div>
        <div class="max-w-2xl mx-auto bg-white rounded-3xl shadow-2xl p-10">
            <div class="space-y-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Тип послуги</label>
                    <select id="service-type" class="w-full border border-gray-300 rounded-3xl px-6 py-5 text-lg focus:outline-none focus:border-cyan-400">
                        <option value="post-repair">Прибирання після ремонту у Вільнюсі</option>
                        <option value="office">Прибирання офісів у Вільнюсі</option>
                        <option value="commercial">Прибирання комерційних приміщень</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Площа приміщення (м²)</label>
                    <input type="number" id="area" value="100" min="10" class="w-full border border-gray-300 rounded-3xl px-6 py-5 text-lg focus:outline-none focus:border-cyan-400">
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <label class="flex items-center gap-3 cursor-pointer text-lg">
                        <input type="checkbox" id="windows" class="w-6 h-6 accent-cyan-400"> Миття вікон
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer text-lg">
                        <input type="checkbox" id="furniture" class="w-6 h-6 accent-cyan-400"> Хімчистка меблів
                    </label>
                </div>
                <button onclick="calculatePrice()" 
                        class="w-full py-7 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold text-2xl rounded-3xl hover:brightness-110 transition">
                    Розрахувати вартість
                </button>
                <div id="calc-result" class="hidden text-center mt-8 p-10 bg-gradient-to-br from-gray-50 to-white rounded-3xl">
                    <p class="text-gray-600 text-xl">Попередня вартість:</p>
                    <div id="result-price" class="calc-result mt-4">0 €</div>
                    <p class="text-sm text-gray-500 mt-6">* Це орієнтовна ціна. Точну вартість уточнить менеджер після огляду об’єкта.</p>
                    <a href="#contact" class="mt-8 inline-block px-12 py-5 bg-black text-white font-semibold text-xl rounded-3xl hover:bg-cyan-400 hover:text-black">Замовити прибирання за цією ціною</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PRICES -->
<section id="prices" class="py-24 bg-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <h2 class="heading-font text-5xl text-center mb-4">Ціни на прибирання після ремонту у Вільнюсі та прибирання офісів</h2>
        <div class="overflow-x-auto mt-12 rounded-3xl bg-white shadow-2xl">
            <table class="w-full min-w-[900px]">
                <thead>
                    <tr class="border-b">
                        <th class="pl-10 py-7 text-left font-medium text-gray-500">Послуга</th>
                        <th class="pl-10 py-7 text-left font-medium text-gray-500">Площа</th>
                        <th class="pr-10 py-7 text-right font-medium text-gray-500">Ціна від</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="price-row border-b">
                        <td class="pl-10 py-7 font-medium">Прибирання після ремонту у Вільнюсі</td>
                        <td class="pl-10 py-7">до 100 м²</td>
                        <td class="pr-10 py-7 text-right font-semibold text-emerald-600">2.8 €/м²</td>
                    </tr>
                    <tr class="price-row border-b">
                        <td class="pl-10 py-7 font-medium">Прибирання після ремонту у Вільнюсі</td>
                        <td class="pl-10 py-7">100–300 м²</td>
                        <td class="pr-10 py-7 text-right font-semibold text-emerald-600">2.5 €/м²</td>
                    </tr>
                    <tr class="price-row border-b">
                        <td class="pl-10 py-7 font-medium">Прибирання офісів у Вільнюсі (щоденне/генеральне)</td>
                        <td class="pl-10 py-7">до 200 м²</td>
                        <td class="pr-10 py-7 text-right font-semibold text-emerald-600">2.5 €/м²</td>
                    </tr>
                    <tr class="price-row border-b">
                        <td class="pl-10 py-7 font-medium">Прибирання комерційних приміщень у Вільнюсі</td>
                        <td class="pl-10 py-7">від 50 м²</td>
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
        <h2 class="heading-font text-5xl text-center mb-12">Чому варто обрати Ukrbud.lt для прибирання після ремонту у Вільнюсі</h2>
        <div class="prose prose-lg max-w-4xl mx-auto text-gray-700 leading-relaxed space-y-8">
            <p>Якщо вам потрібне якісне <strong>прибирання після ремонту у Вільнюсі</strong> — звертайтеся до професійної клінінгової компанії Ukrbud.lt. Ми швидко та ретельно прибираємо квартири, будинки, офіси та комерційні приміщення після будівельних та ремонтних робіт. Наша бригада видаляє весь будівельний пил, залишки фарби, штукатурки, шпаклівки, клею та іншого сміття. Ми миємо вікна, підвіконня, стелі, люстри, плінтуси, радіатори та всі поверхні до ідеального блиску.</p>

            <p>Окрім <strong>прибирання після ремонту у Вільнюсі</strong> ми пропонуємо регулярне <strong>прибирання офісів у Вільнюсі</strong>. Чистий офіс підвищує продуктивність співробітників та створює гарне враження у клієнтів. Ми виконуємо щоденне, щотижневе та генеральне прибирання офісних приміщень будь-якого розміру. Для постійних клієнтів діють вигідні абонементи зі знижкою до 25%.</p>

            <p><strong>Прибирання комерційних приміщень у Вільнюсі</strong> — ще один важливий напрям нашої роботи. Ми обслуговуємо магазини, салони краси, кафе, ресторани, медичні центри та склади. Кожному об’єкту складаємо індивідуальний план прибирання, використовуємо професійні екологічні засоби та проводимо ретельну дезінфекцію.</p>

            <p>Ми працюємо 24 години на добу 7 днів на тиждень, приймаємо тільки безготівковий розрахунок, використовуємо сучасне професійне обладнання та гарантуємо високу якість. Багато клієнтів відзначають, що ми значно кращі за конкурентів за швидкістю виїзду, якістю робіт та прозорими цінами.</p>

            <p>Потрібне прибирання після ремонту у Вільнюсі або регулярне прибирання офісів? Телефонуйте +370 644 74842 або залишайте заявку на сайті. Ми оперативно зв’яжемося з вами, розрахуємо вартість та приїдемо у зручний для вас час.</p>
        </div>
    </div>
</section>

<!-- WHY US -->
<section id="why" class="py-24 bg-black text-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <h2 class="heading-font text-5xl text-center mb-12">Чому клієнти обирають Ukrbud.lt замість інших компаній</h2>
        <div class="grid md:grid-cols-4 gap-10 text-center">
            <div>
                <div class="text-6xl mb-4">⏱️</div>
                <h4 class="text-2xl font-medium">Виїзд за 60 хвилин</h4>
                <p class="text-white/70 mt-3">По всьому Вільнюсу та найближчих околицях</p>
            </div>
            <div>
                <div class="text-6xl mb-4">🌿</div>
                <h4 class="text-2xl font-medium">Екологічні засоби</h4>
                <p class="text-white/70 mt-3">Безпечні для дітей, тварин та алергіків</p>
            </div>
            <div>
                <div class="text-6xl mb-4">💳</div>
                <h4 class="text-2xl font-medium">Безготівковий розрахунок</h4>
                <p class="text-white/70 mt-3">Картки, банківський переказ, Revolut</p>
            </div>
            <div>
                <div class="text-6xl mb-4">⭐</div>
                <h4 class="text-2xl font-medium">Гарантія якості</h4>
                <p class="text-white/70 mt-3">Якщо щось не сподобається — приїдемо безкоштовно</p>
            </div>
        </div>
    </div>
</section>

<!-- REVIEWS -->
<section id="reviews" class="py-24 bg-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <h2 class="heading-font text-5xl text-center mb-12">Відгуки про наше прибирання після ремонту та офісів</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-gray-50 p-8 rounded-3xl">
                <p class="italic">"Відмінне прибирання після ремонту у Вільнюсі! Квартира 95 м² після будівництва сяяла чистотою вже через 5 годин. Дуже рекомендую Ukrbud.lt!"</p>
                <div class="mt-6 text-sm font-medium">— Анна, район Пашілайчяй</div>
            </div>
            <div class="bg-gray-50 p-8 rounded-3xl">
                <p class="italic">"Регулярне прибирання офісів у Вільнюсі на 220 м². Все завжди вчасно, якісно та за приємною ціною. Безготівковий розрахунок — дуже зручно для компанії."</p>
                <div class="mt-6 text-sm font-medium">— Дмитро, керівник IT-компанії</div>
            </div>
            <div class="bg-gray-50 p-8 rounded-3xl">
                <p class="italic">"Прибирання комерційного приміщення після ремонту. Все зробили ідеально чисто. Тепер замовляємо прибирання кожен місяць. Дякуємо за професіоналізм!"</p>
                <div class="mt-6 text-sm font-medium">— Марія, власниця салону краси</div>
            </div>
        </div>
    </div>
</section>
<!-- Блок "Наші партнери" -->
<section class="py-20 bg-white border-t border-gray-100">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="text-center mb-12">
            <h2 class="heading-font text-4xl font-semibold text-gray-900">Наші партнери</h2>
            <p class="text-gray-600 mt-3 text-lg">Ми співпрацюємо з надійними компаніями для надання найкращого сервісу</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center justify-items-center">
            
            <!-- Партнер 1 -->
            <a href="https://balticclean.lt" target="_blank" 
               class="group flex flex-col items-center justify-center p-8 bg-gray-50 hover:bg-white border border-gray-100 hover:border-cyan-200 rounded-3xl transition-all duration-300 hover:shadow-xl">
                <div class="w-28 h-28 flex items-center justify-center text-6xl mb-6 group-hover:scale-110 transition-transform">
                    🧼
                </div>
                <span class="font-semibold text-xl text-gray-800 group-hover:text-cyan-600 transition-colors">Baltic Clean</span>
                <span class="text-sm text-gray-500 mt-1">Професійний клінінг</span>
            </a>

            <!-- Партнер 2 -->
            <a href="https://meistru.lt" target="_blank" 
               class="group flex flex-col items-center justify-center p-8 bg-gray-50 hover:bg-white border border-gray-100 hover:border-cyan-200 rounded-3xl transition-all duration-300 hover:shadow-xl">
                <div class="w-28 h-28 flex items-center justify-center text-6xl mb-6 group-hover:scale-110 transition-transform">
                    🔧
                </div>
                <span class="font-semibold text-xl text-gray-800 group-hover:text-cyan-600 transition-colors">Meistru.lt</span>
                <span class="text-sm text-gray-500 mt-1">Ремонтні послуги</span>
            </a>

            <!-- Партнер 3 - bilohash.com -->
            <a href="https://bilohash.com" target="_blank" 
               class="group flex flex-col items-center justify-center p-8 bg-gray-50 hover:bg-white border border-gray-100 hover:border-cyan-200 rounded-3xl transition-all duration-300 hover:shadow-xl">
                <div class="w-28 h-28 flex items-center justify-center text-5xl mb-6 group-hover:scale-110 transition-transform">
                    💻
                </div>
                <span class="font-semibold text-xl text-gray-800 group-hover:text-cyan-600 transition-colors">Bilohash.com</span>
                <span class="text-sm text-gray-500 mt-1">Веб-розробка та цифрові рішення</span>
            </a>

            <!-- Можна додати ще одного партнера пізніше -->
            <div class="flex flex-col items-center justify-center p-8 bg-gray-50 border border-dashed border-gray-200 rounded-3xl opacity-60">
                <div class="w-28 h-28 flex items-center justify-center text-6xl mb-6">
                    🤝
                </div>
                <span class="font-semibold text-xl text-gray-400">Стань нашим партнером</span>
            </div>

        </div>

        <div class="text-center mt-12 text-sm text-gray-500">
            Ми довіряємо тільки перевіреним партнерам, щоб забезпечити найвищу якість послуг для наших клієнтів
        </div>
    </div>
</section>
<!-- FAQ -->
<section id="faq" class="py-24 bg-gray-50">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <h2 class="heading-font text-5xl text-center mb-12">Часті питання про прибирання у Вільнюсі</h2>
        <div class="max-w-4xl mx-auto space-y-6">
            <details class="bg-white p-8 rounded-3xl shadow-sm">
                <summary class="text-xl font-semibold cursor-pointer">Скільки коштує прибирання після ремонту у Вільнюсі?</summary>
                <p class="mt-6 text-gray-600">Ціна починається від 2.8 €/м² залежно від площі та складності робіт. Використовуйте наш онлайн-калькулятор для попереднього розрахунку.</p>
            </details>
            <details class="bg-white p-8 rounded-3xl shadow-sm">
                <summary class="text-xl font-semibold cursor-pointer">Як швидко ви приїжджаєте на прибирання офісів у Вільнюсі?</summary>
                <p class="mt-6 text-gray-600">Ми гарантуємо виїзд бригади протягом 60 хвилин після підтвердження замовлення по всьому Вільнюсу.</p>
            </details>
            <details class="bg-white p-8 rounded-3xl shadow-sm">
                <summary class="text-xl font-semibold cursor-pointer">Чи працюєте ви з комерційними приміщеннями?</summary>
                <p class="mt-6 text-gray-600">Так, ми виконуємо прибирання комерційних приміщень у Вільнюсі: магазини, кафе, салони, склади та медичні центри.</p>
            </details>
            <details class="bg-white p-8 rounded-3xl shadow-sm">
                <summary class="text-xl font-semibold cursor-pointer">Чи використовуєте ви екологічні засоби?</summary>
                <p class="mt-6 text-gray-600">Так, всі засоби безпечні для дітей, тварин та людей з алергією.</p>
            </details>
        </div>
    </div>
</section>

<!-- CONTACT FORM -->
<section id="contact" class="py-24 bg-gradient-to-br from-cyan-600 to-blue-700 text-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="grid lg:grid-cols-2 gap-16">
            <div>
                <h2 class="heading-font text-5xl font-semibold">Залишити заявку на прибирання</h2>
                <p class="mt-6 text-xl">Заповніть форму, і наш менеджер зв’яжеться з вами протягом кількох хвилин для уточнення деталей.</p>
                <?php if ($success): ?>
                    <div class="mt-10 bg-emerald-400 text-black p-8 rounded-3xl text-center text-2xl font-medium">✅ Замовлення успішно надіслано! Дякуємо, ми скоро з вами зв’яжемося.</div>
                <?php elseif ($error): ?>
                    <div class="mt-10 bg-red-500 p-8 rounded-3xl text-center"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form method="POST" class="mt-10 space-y-8">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <input type="text" name="name" required placeholder="Ваше ім’я" class="w-full bg-white/10 border border-white/30 rounded-3xl px-8 py-6 text-white placeholder-white/60 focus:outline-none">
                    <input type="tel" name="phone" required placeholder="+370 644 74842" class="w-full bg-white/10 border border-white/30 rounded-3xl px-8 py-6 text-white placeholder-white/60 focus:outline-none">
                    <textarea name="message" rows="5" placeholder="Опишіть завдання (прибирання після ремонту квартири, офіс 150 м² тощо)" class="w-full bg-white/10 border border-white/30 rounded-3xl px-8 py-6 text-white placeholder-white/60 focus:outline-none"></textarea>
                    <button type="submit" name="submit_order" class="w-full py-7 bg-white text-black font-bold text-2xl rounded-3xl hover:bg-cyan-300">Надіслати заявку</button>
                </form>
            </div>
            <div class="flex flex-col justify-center items-center lg:items-start text-center lg:text-left">
                <div class="text-7xl flex gap-12 mb-12">
                    <a href="https://wa.me/37064474842" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="https://t.me/+37064474842" target="_blank"><i class="fa-brands fa-telegram"></i></a>
                    <a href="viber://chat?number=%2B37064474842" target="_blank"><i class="fa-brands fa-viber"></i></a>
                </div>
                <a href="tel:+37064474842" class="text-5xl font-bold hover:text-cyan-200">+370 644 74842</a>
                <p class="mt-4 text-xl">Телефонуйте або пишіть у месенджери в будь-який час</p>
            </div>
        </div>
    </div>
</section>

<!-- Блок підписки на знижку 30% -->
<section class="py-24 bg-gradient-to-br from-black via-zinc-900 to-black text-white relative overflow-hidden">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="max-w-2xl mx-auto text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-cyan-500/10 rounded-3xl mb-8">
                <span class="text-5xl">🎁</span>
            </div>
            <h2 class="heading-font text-5xl lg:text-6xl font-semibold leading-none tracking-[-1px] mb-6">
                Підпишись і отримай <span class="text-cyan-400">30% знижку</span>
            </h2>
           
            <p class="text-xl text-white/80 mb-10 max-w-md mx-auto">
                На перше прибирання після ремонту, офісів або комерційних приміщень.<br>
                Знижка діє 30 днів після підписки.
            </p>
            <form id="subscribe-form" class="max-w-md mx-auto">
                <div class="flex flex-col sm:flex-row gap-3">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        required
                        placeholder="Ваша email адреса"
                        class="flex-1 bg-white/10 border border-white/30 rounded-3xl px-8 py-6 text-white placeholder-white/60 focus:outline-none focus:border-cyan-400 transition-all text-lg">
                   
                    <button
                        type="submit"
                        class="bg-cyan-400 hover:bg-cyan-300 transition-all text-black font-bold text-lg px-10 py-6 rounded-3xl whitespace-nowrap">
                        Отримати знижку
                    </button>
                </div>
               
                <p class="text-xs text-white/50 mt-4">
                    Ми поважаємо вашу приватність. Відписатися можна в будь-який момент.
                </p>
            </form>
            <div id="subscribe-success" class="hidden mt-8 bg-emerald-500/20 border border-emerald-400 text-emerald-300 p-6 rounded-3xl">
                ✅ Дякуємо! Знижка 30% надіслана на вашу email. Перевірте пошту.
            </div>
            <div id="subscribe-error" class="hidden mt-8 bg-red-500/20 border border-red-400 text-red-300 p-6 rounded-3xl">
                ❌ Помилка. Спробуйте пізніше або напишіть нам напряму.
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
                <p class="text-sm max-w-xs mx-auto md:mx-0">Професійне прибирання після ремонту, офісів та комерційних приміщень у Вільнюсі з 2018 року.</p>
            </div>

            <div class="text-center">
                <h4 class="text-white text-lg font-semibold mb-6">Швидкі посилання</h4>
                <div class="flex flex-col gap-y-3 text-sm">
                    <a href="#services" class="hover:text-cyan-400">Послуги</a>
                    <a href="#calculator" class="hover:text-cyan-400">Калькулятор</a>
                    <a href="#prices" class="hover:text-cyan-400">Ціни</a>
                    <a href="#faq" class="hover:text-cyan-400">Питання</a>
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
            <p class="text-center md:text-left">© 2025–2026 Ukrbud.lt — Прибирання після ремонту у Вільнюсі, прибирання офісів у Вільнюсі, прибирання комерційних приміщень у Вільнюсі</p>

            <a href="https://bilohash.com" target="_blank" class="want-site-btn group inline-flex items-center gap-4 bg-gradient-to-r from-cyan-500 via-blue-500 to-cyan-500 text-white font-semibold text-xl px-12 py-6 rounded-3xl glow-animation">
                <span class="relative z-10 flex items-center gap-3">
                    ХОЧУ ТАКИЙ САЙТ!
                    <i class="fa-solid fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                </span>
            </a>

            <?php include 'counter.php'; ?>
        </div>
    </div>
</footer>

<!-- Мовний віджет з автозміною прапора -->
<div id="language-widget" class="fixed bottom-6 left-6 z-[100]">
    <button onclick="toggleLanguageMenu()" id="lang-button" class="bg-white shadow-2xl hover:shadow-2xl w-16 h-16 rounded-3xl flex items-center justify-center border border-gray-200 hover:border-cyan-400 transition-all duration-300 overflow-hidden">
        <span id="current-flag" class="text-4xl transition-all duration-700">🇷🇺</span>
    </button>
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

<!-- Скрипти -->
<script>
// Обробка підписки через AJAX
document.getElementById('subscribe-form').addEventListener('submit', function(e) {
    e.preventDefault();
   
    const emailInput = document.getElementById('email');
    const email = emailInput.value.trim();
    const successDiv = document.getElementById('subscribe-success');
    const errorDiv = document.getElementById('subscribe-error');
   
    if (!email) return;

    const button = this.querySelector('button');
    const originalText = button.textContent;
    button.textContent = 'Відправляємо...';
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
       
        setTimeout(() => successDiv.classList.add('hidden'), 7000);
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
        flagElement.style.opacity = '0';
        flagElement.style.transform = 'scale(0.7) rotate(-15deg)';
       
        setTimeout(() => {
            flagElement.textContent = flags[currentIndex];
            flagElement.style.opacity = '1';
            flagElement.style.transform = 'scale(1) rotate(0deg)';
        }, 300);
    }

    function startFlagRotation() {
        interval = setInterval(changeFlag, 2000);
    }

    function toggleLanguageMenu() {
        const menu = document.getElementById('language-menu');
        menu.classList.toggle('hidden');
       
        if (!menu.classList.contains('hidden')) {
            clearInterval(interval);
        } else {
            startFlagRotation();
        }
    }

    document.addEventListener('click', function(e) {
        const widget = document.getElementById('language-widget');
        if (!widget.contains(e.target)) {
            document.getElementById('language-menu').classList.add('hidden');
            startFlagRotation();
        }
    });

    window.addEventListener('load', () => startFlagRotation());

    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape") {
            document.getElementById('language-menu').classList.add('hidden');
            startFlagRotation();
        }
    });
</script>

<style>
    #lang-button { box-shadow: 0 15px 25px -5px rgb(0 0 0 / 0.15), 0 8px 10px -6px rgb(0 0 0 / 0.1); }
    #lang-button:hover { transform: scale(1.08); }
    #language-menu { animation: languageMenuPop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
    @keyframes languageMenuPop {
        from { opacity: 0; transform: translateY(20px) scale(0.9); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    #current-flag { display: inline-block; transition: all 0.4s ease; }
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

    console.log('%c✅ ua.php готовий! Ukrbud.lt українська версія запущена.', 'color:#22d3ee; font-size:15px; font-weight:700');
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