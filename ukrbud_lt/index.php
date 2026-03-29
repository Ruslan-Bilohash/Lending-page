<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Kintamieji užsakymo formai
$success = false;
$error = '';

// ========================================================
// UŽSAKYMO FORMOS APDOROJIMAS — su gražiais laiškais
// ========================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_order'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = 'Saugumo klaida. Atnaujinkite puslapį.';
    } else {
        $name    = trim(htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES));
        $phone   = trim(htmlspecialchars($_POST['phone'] ?? '', ENT_QUOTES));
        $message = trim(htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES));

        if (empty($name) || empty($phone)) {
            $error = 'Vardas ir telefono numeris yra privalomi!';
        } elseif (!preg_match('/^[\+]?[\d\s\-\(\)]{10,18}$/', $phone)) {
            $error = 'Neteisingas telefono numerio formatas!';
        } else {
            $order_id = "UKR-" . date("YmdHis");

            // ==================== LAIŠKAS KLIENTUI (gražus HTML) ====================
            $client_subject = "✅ Užsakymas Nr. $order_id priimtas | Ukrbud.lt";

            $client_message = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Užsakymas priimtas</title>
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
                        <h1 style="margin:0; font-size:32px;">Užsakymas sėkmingai priimtas!</h1>
                        <p style="margin:15px 0 0; font-size:20px;">Užsakymo numeris: <strong>' . $order_id . '</strong></p>
                    </div>
                   
                    <div class="content">
                        <p>Sveiki, <strong>' . $name . '</strong>!</p>
                        <p>Dėkojame už pasitikėjimą <strong>Ukrbud.lt</strong> — profesionalia valymo įmone Vilniuje.</p>
                       
                        <div class="info-box">
                            <strong>Jūsų užsakymas Nr.' . $order_id . ' priimtas ir šiuo metu apdorojamas.</strong><br><br>
                            Mūsų vadybininkas susisieks su jumis per 15–60 minučių, kad patikslintų detales ir paskirtų patogų brigados atvykimo laiką.
                        </div>

                        <p><strong>Jūsų užsakymo duomenys:</strong></p>
                        <p>Vardas: ' . $name . '<br>
                           Telefonas: ' . $phone . '<br>
                           Pranešimas: ' . nl2br($message) . '</p>

                        <p style="text-align:center;">
                            <a href="tel:+37064474842" class="button">Skambinkite mums dabar →</a>
                        </p>

                        <p>Jei atsirado papildomų pageidavimų — tiesiog atsakykite į šį laišką.</p>
                    </div>
                   
                    <div class="footer">
                        Su pagarba,<br>
                        <strong>Ukrbud.lt komanda</strong><br>
                        Profesionalus valymas po remonto • Biurų valymas • Komercinių patalpų valymas<br>
                        Vilnius • +370 644 74842
                    </div>
                </div>
            </body>
            </html>';

            // ==================== LAIŠKAS ADMINISTRATORIUI (tau) ====================
            $admin_subject = "Naujas užsakymas Nr.$order_id — Ukrbud.lt";
            $admin_body = "NAUJAS VALYMO UŽSAKYMAS\n\n";
            $admin_body .= "Užsakymo numeris: $order_id\n";
            $admin_body .= "Vardas: $name\n";
            $admin_body .= "Telefonas: $phone\n";
            $admin_body .= "Pranešimas:\n$message\n\n";
            $admin_body .= "Data: " . date('d.m.Y H:i:s') . "\n";
            $admin_body .= "IP: " . $_SERVER['REMOTE_ADDR'] . "\n";

            $admin_headers = "From: no-reply@ukrbud.lt\r\nContent-Type: text/plain; charset=utf-8\r\n";

            // Siunčiame laiškus
            $headers_client = "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Ukrbud.lt <no-reply@ukrbud.lt>\r\n";

            mail("rbilohash@gmail.com,valeriapilipiuk@gmail.com,ulianasemashko@gmail.com,booking@balticclean.lt", $admin_subject, $admin_body, $admin_headers);
            mail($email ?? "rbilohash@gmail.com", $client_subject, $client_message, $headers_client);

            $success = true;
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }
}

// ========================================================
// Prenumeratos su 30% nuolaida apdorojimas
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
           
            $subject = "🎁 Jūsų 30% nuolaida valymui Vilniuje iš Ukrbud.lt";
           
            $message = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Jūsų nuolaida 30%</title>
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
                        <h1 style="margin:0; font-size:32px;">🎁 Sveikiname!</h1>
                        <p style="margin:10px 0 0; font-size:20px;">Jūs gavote 30% nuolaidą</p>
                    </div>
                   
                    <div class="content">
                        <p>Sveiki!</p>
                        <p>Dėkojame, kad prenumeravote Ukrbud.lt naujienlaiškį — profesionalią valymo įmonę Vilniuje.</p>
                        <p>Jūsų dovana — <strong>30% nuolaida pirmam valymui</strong> (po remonto, biurų ar komercinių patalpų).</p>
                       
                        <div class="discount-box">
                            <p style="margin:0 0 10px; font-size:18px; color:#64748b;">Jūsų nuolaidos kodas:</p>
                            <div class="code">' . $discount_code . '</div>
                            <p style="margin:15px 0 0; color:#64748b;">Galioja 30 dienas</p>
                        </div>
                       
                        <p style="text-align:center;">
                            <a href="https://ukrbud.lt/#contact" class="button">Užsisakyti valymą su nuolaida →</a>
                        </p>
                       
                        <p>Paprasčiausiai parodykite šį kodą mūsų vadybininkui užsakymo metu.</p>
                       
                        <p>Su pagarba,<br>
                        <strong>Ukrbud.lt komanda</strong><br>
                        Profesionalus valymas Vilniuje<br>
                        +370 644 74842</p>
                    </div>
                   
                    <div class="footer">
                        © 2026 Ukrbud.lt — Valymas po remonto, biurų ir komercinių patalpų Vilniuje<br>
                        Jei nebenorite gauti laiškų — tiesiog atsakykite į šį laišką su tekstu „Atsisakyti“.
                    </div>
                </div>
            </body>
            </html>';

            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=utf-8\r\n";
            $headers .= "From: Ukrbud.lt <no-reply@ukrbud.lt>\r\n";
            $headers .= "Reply-To: no-reply@ukrbud.lt\r\n";

            mail($email, $subject, $message, $headers);

            $notify_subject = "Nauja prenumerata su 30% nuolaida — ukrbud.lt";
            $notify_body = "Nauja prenumerata:\nEl. paštas: $email\nNuolaidos kodas: $discount_code\nData: " . date('d.m.Y H:i:s') . "\nIP: " . $_SERVER['REMOTE_ADDR'];
            $notify_headers = "From: no-reply@ukrbud.lt\r\nContent-Type: text/plain; charset=utf-8\r\n";
           
            mail("rbilohash@gmail.com,valeriapilipiuk@gmail.com,ulianasemashko@gmail.com,booking@balticclean.lt", $notify_subject, $notify_body, $notify_headers);
        }
       
        $subscribe_success = true;
    } else {
        $subscribe_error = 'Įveskite teisingą el. pašto adresą';
    }
}
?>
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Основні SEO мета-теги -->
    <meta name="description" content="Valymas po remonto Vilniuje nuo 2.8 €/m² ✓ Profesionalus biurų valymas Vilniuje ✓ Komercinių patalpų valymas ✓ Internetinis kainos kalkuliatorius ✓ Brigada atvyksta per 60 min ✓ Dirbame 24/7 ✓ Atsiskaitymas kortele ✓ Ukrbud.lt +370 644 74842">
    <meta name="keywords" content="valymas po remonto Vilniuje, biurų valymas Vilniuje, komercinių patalpų valymas Vilniuje, generalinis valymas Vilniuje, valymas po statybų Vilniuje, valymo įmonė Vilniuje, patalpų valymas Vilniuje">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Ukrbud.lt">
    <meta name="language" content="lt">
    <link rel="canonical" href="https://ukrbud.lt/index.php">

    <title>Valymas po remonto Vilniuje | Biurų valymas | Komercinių patalpų valymas | Ukrbud.lt</title>

    <!-- Open Graph / Facebook + Instagram + Telegram + LinkedIn -->
    <meta property="og:title" content="Valymas po remonto Vilniuje • Ukrbud.lt">
    <meta property="og:description" content="Profesionalus valymas po remonto, biurų ir komercinių patalpų Vilniuje. Internetinis kainos kalkuliatorius. Atvykimas per 60 minučių. +370 644 74842">
    <meta property="og:image" content="https://ukrbud.lt/og-image.jpg">
    <meta property="og:url" content="https://ukrbud.lt/index.php">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Ukrbud.lt">
    <meta property="og:locale" content="lt_LT">
    <meta property="og:locale:alternate" content="ru_RU">
    <meta property="og:locale:alternate" content="en_US">
    <meta property="og:locale:alternate" content="uk_UA">
	<!-- Hreflang для багатомовності -->
<link rel="alternate" hreflang="en" href="https://ukrbud.lt/en.php" />
<link rel="alternate" hreflang="lt" href="https://ukrbud.lt/" />
<link rel="alternate" hreflang="ru" href="https://ukrbud.lt/ru.php" />
<link rel="alternate" hreflang="uk" href="https://ukrbud.lt/ua.php" />
<link rel="alternate" hreflang="x-default" href="https://ukrbud.lt/" />

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Valymas po remonto Vilniuje • Ukrbud.lt">
    <meta name="twitter:description" content="Profesionalus valymas po remonto, biurų ir komercinių patalpų Vilniuje. Internetinis kainos kalkuliatorius. Atvykimas per 60 min.">
    <meta name="twitter:image" content="https://ukrbud.lt/og-image.jpg">

    <!-- Додаткові соціальні мета для Telegram, WhatsApp тощо -->
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Valymas po remonto Vilniuje - Ukrbud.lt">

    <!-- Schema.org - Розширена розмітка -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "Ukrbud.lt",
        "description": "Profesionalus valymas po remonto, biurų ir komercinių patalpų Vilniuje",
        "url": "https://ukrbud.lt/index.php",
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
        "areaServed": "Vilnius, Vilnius apskritis, Lietuva",
        "serviceType": "Valymo paslaugos",
        "image": "https://ukrbud.lt/og-image.jpg",
        "logo": "https://ukrbud.lt/logo.png"
    }
    </script>

    <!-- Schema для послуг -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Service",
        "name": "Valymas po remonto Vilniuje",
        "description": "Profesionalus valymas po remonto butų, namų ir biurų Vilniuje",
        "provider": {
            "@type": "LocalBusiness",
            "name": "Ukrbud.lt"
        },
        "areaServed": "Vilnius",
        "hasOfferCatalog": {
            "@type": "OfferCatalog",
            "name": "Kainos valymui",
            "itemListElement": [
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "Service",
                        "name": "Valymas po remonto"
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
                "name": "Kiek kainuoja valymas po remonto Vilniuje?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Kaina prasideda nuo 2.8 €/m², priklausomai nuo ploto ir darbų sudėtingumo."
                }
            },
            {
                "@type": "Question",
                "name": "Kaip greitai atvykstate biurų valymui Vilniuje?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Mes garantuojame brigados atvykimą per 60 minučių po užsakymo patvirtinimo."
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
            <a href="#services" class="hover:text-cyan-400">Paslaugos</a>
            <a href="#calculator" class="hover:text-cyan-400">Kalkuliatorius</a>
            <a href="#prices" class="hover:text-cyan-400">Kainos</a>
            <a href="#why" class="hover:text-cyan-400">Kodėl mes</a>
            <a href="#reviews" class="hover:text-cyan-400">Atsiliepimai</a>
            <a href="#faq" class="hover:text-cyan-400">Klausimai</a>
            <a href="#contact" class="hover:text-cyan-400">Kontaktai</a>
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

    <!-- Pilnas mobilus meniu -->
    <div id="mobile-menu" class="hidden lg:hidden bg-black border-t border-white/10 px-6 py-10">
        <div class="flex flex-col gap-y-6 text-white text-2xl font-medium">
            <a href="#services" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Paslaugos</a>
            <a href="#calculator" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Kainos kalkuliatorius</a>
            <a href="#prices" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Kainos</a>
            <a href="#why" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Kodėl mes</a>
            <a href="#reviews" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Atsiliepimai</a>
            <a href="#faq" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Dažniausiai užduodami klausimai</a>
            <a href="#contact" onclick="toggleMobileMenu()" class="py-3">Kontaktai</a>
            <div class="pt-8 flex flex-col gap-4">
                <a href="tel:+37064474842" onclick="toggleMobileMenu()" class="text-center bg-white text-black py-5 rounded-3xl font-bold">Skambinti +370 644 74842</a>
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
                    Vilnius ir apylinkės • 24/7 • Atvykimas per 60 min • Atsiskaitymas banko kortele
                </div>
                <h1 class="heading-font text-5xl md:text-6xl lg:text-7xl font-semibold leading-none tracking-[-2px]">
                    Valymas po remonto Vilniuje<br>Biurų valymas Vilniuje<br>Komercinių patalpų valymas
                </h1>
                <p class="text-2xl text-white/80">Profesionali valymo įmonė Ukrbud.lt siūlo kokybišką valymą po remonto, generalinį biurų valymą ir komercinių patalpų valymą geriausiomis kainomis Vilniuje. Naudojame modernią įrangą ir ekologiškas priemones. Internetinis kainos kalkuliatorius.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="#calculator" class="px-10 py-6 bg-cyan-400 text-black font-bold text-xl rounded-3xl hover:bg-cyan-300">Apskaičiuoti kainą internetu</a>
                    <a href="tel:+37064474842" class="px-10 py-6 border border-white/40 text-xl font-bold rounded-3xl hover:bg-white/10">Skambinti +370 644 74842</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES -->
<section id="services" class="py-24 bg-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="text-center mb-12">
            <h2 class="heading-font text-5xl font-semibold">Valymo paslaugos Vilniuje</h2>
        </div>
        <p class="max-w-4xl mx-auto text-center text-xl text-gray-600 mb-16">
            Mes specializuojamės <strong>valyme po remonto Vilniuje</strong>. Mūsų komanda greitai ir kokybiškai pašalina statybines dulkes, dažų, tinko, glaisto likučius ir kitus statybinius nešvarumus. Taip pat atliekame reguliarų <strong>biurų valymą Vilniuje</strong> ir <strong>komercinių patalpų valymą Vilniuje</strong> — parduotuvėms, grožio salonams, kavinėms, sandėliams ir medicinos centrams.
        </p>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="service-card bg-white border border-gray-100 rounded-3xl p-10 shadow-xl">
                <div class="text-6xl mb-6">🏗️</div>
                <h3 class="text-3xl font-semibold">Valymas po remonto Vilniuje</h3>
                <p class="text-gray-600 mt-4">Pilnas profesionalus valymas po remonto: statybinių dulkių pašalinimas nuo visų paviršių, langų plovimas, lubų, liustrų, grindjuosčių, radiatorių ir grindų valymas. Po mūsų brigados patalpos atrodo kaip naujos. Atvykimas per 60 minučių visame Vilniuje.</p>
                <div class="mt-8 text-cyan-400 font-semibold">nuo 2.8 €/m²</div>
            </div>
            <div class="service-card bg-white border border-gray-100 rounded-3xl p-10 shadow-xl">
                <div class="text-6xl mb-6">🏢</div>
                <h3 class="text-3xl font-semibold">Biurų valymas Vilniuje</h3>
                <p class="text-gray-600 mt-4">Kasdienis, savaitinis ir generalinis biurų valymas bet kokio dydžio patalpoms. Švarios darbo vietos, sanitariniai mazgai, virtuvės ir posėdžių kambariai. Palaikome aukštą švaros lygį jūsų verslui. Nuolatiniai klientai gauna iki 25% nuolaidą.</p>
                <div class="mt-8 text-cyan-400 font-semibold">nuo 2.5 €/m²</div>
            </div>
            <div class="service-card bg-white border border-gray-100 rounded-3xl p-10 shadow-xl">
                <div class="text-6xl mb-6">🛒</div>
                <h3 class="text-3xl font-semibold">Komercinių patalpų valymas Vilniuje</h3>
                <p class="text-gray-600 mt-4">Kokybiškas valymas parduotuvėms, grožio salonams, kavinėms, restoranams, sandėliams ir medicinos centrams. Gilus valymas, dezinfekcija, individualus požiūris į kiekvieną objektą. Dirbame be poilsio dienų 24/7.</p>
                <div class="mt-8 text-cyan-400 font-semibold">Individualiai</div>
            </div>
        </div>
    </div>
</section>

<!-- КАЛЬКУЛЯТОР (переведено) -->
<section id="calculator" class="py-24 bg-gray-50">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="text-center mb-12">
            <h2 class="heading-font text-5xl font-semibold">Valymo kainos kalkuliatorius Vilniuje</h2>
            <p class="text-xl text-gray-600 mt-4">Sužinokite preliminarią kainą per 20 sekundžių. Tikslį kainą patikslins specialistas po apžiūros.</p>
        </div>
        <div class="max-w-2xl mx-auto bg-white rounded-3xl shadow-2xl p-10">
            <div class="space-y-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Paslaugos tipas</label>
                    <select id="service-type" class="w-full border border-gray-300 rounded-3xl px-6 py-5 text-lg focus:outline-none focus:border-cyan-400">
                        <option value="post-repair">Valymas po remonto Vilniuje</option>
                        <option value="office">Biurų valymas Vilniuje</option>
                        <option value="commercial">Komercinių patalpų valymas</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Patalpos plotas (m²)</label>
                    <input type="number" id="area" value="100" min="10" class="w-full border border-gray-300 rounded-3xl px-6 py-5 text-lg focus:outline-none focus:border-cyan-400">
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <label class="flex items-center gap-3 cursor-pointer text-lg">
                        <input type="checkbox" id="windows" class="w-6 h-6 accent-cyan-400"> Langų plovimas
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer text-lg">
                        <input type="checkbox" id="furniture" class="w-6 h-6 accent-cyan-400"> Baldų cheminis valymas
                    </label>
                </div>
                <button onclick="calculatePrice()" 
                        class="w-full py-7 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold text-2xl rounded-3xl hover:brightness-110 transition">
                    Apskaičiuoti kainą
                </button>
                <div id="calc-result" class="hidden text-center mt-8 p-10 bg-gradient-to-br from-gray-50 to-white rounded-3xl">
                    <p class="text-gray-600 text-xl">Preliminari kaina:</p>
                    <div id="result-price" class="calc-result mt-4">0 €</div>
                    <p class="text-sm text-gray-500 mt-6">* Tai orientacinė kaina. Tikslų įkainį patikslins vadybininkas po objekto apžiūros.</p>
                    <a href="#contact" class="mt-8 inline-block px-12 py-5 bg-black text-white font-semibold text-xl rounded-3xl hover:bg-cyan-400 hover:text-black">Užsisakyti valymą šia kaina</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PRICES -->
<section id="prices" class="py-24 bg-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <h2 class="heading-font text-5xl text-center mb-4">Kainos valymui po remonto Vilniuje ir biurų valymui</h2>
        <div class="overflow-x-auto mt-12 rounded-3xl bg-white shadow-2xl">
            <table class="w-full min-w-[900px]">
                <thead>
                    <tr class="border-b">
                        <th class="pl-10 py-7 text-left font-medium text-gray-500">Paslauga</th>
                        <th class="pl-10 py-7 text-left font-medium text-gray-500">Plotas</th>
                        <th class="pr-10 py-7 text-right font-medium text-gray-500">Kaina nuo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="price-row border-b">
                        <td class="pl-10 py-7 font-medium">Valymas po remonto Vilniuje</td>
                        <td class="pl-10 py-7">iki 100 m²</td>
                        <td class="pr-10 py-7 text-right font-semibold text-emerald-600">2.8 €/m²</td>
                    </tr>
                    <tr class="price-row border-b">
                        <td class="pl-10 py-7 font-medium">Valymas po remonto Vilniuje</td>
                        <td class="pl-10 py-7">100–300 m²</td>
                        <td class="pr-10 py-7 text-right font-semibold text-emerald-600">2.5 €/m²</td>
                    </tr>
                    <tr class="price-row border-b">
                        <td class="pl-10 py-7 font-medium">Biurų valymas Vilniuje (kasdienis/generalinis)</td>
                        <td class="pl-10 py-7">iki 200 m²</td>
                        <td class="pr-10 py-7 text-right font-semibold text-emerald-600">2.5 €/m²</td>
                    </tr>
                    <tr class="price-row border-b">
                        <td class="pl-10 py-7 font-medium">Komercinių patalpų valymas Vilniuje</td>
                        <td class="pl-10 py-7">nuo 50 m²</td>
                        <td class="pr-10 py-7 text-right font-semibold text-emerald-600">3 €/m²</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- BIG SEO TEXT + ABOUT -->
<section id="about" class="py-24 bg-gray-50">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <h2 class="heading-font text-5xl text-center mb-12">Kodėl verta rinktis Ukrbud.lt valymui po remonto Vilniuje</h2>
        <div class="prose prose-lg max-w-4xl mx-auto text-gray-700 leading-relaxed space-y-8">
            <p>Jei jums reikia kokybiško <strong>valymo po remonto Vilniuje</strong> — kreipkitės į profesionalią valymo įmonę Ukrbud.lt. Mes greitai ir kruopščiai tvarkome butus, namus, biurus ir komercines patalpas po statybos ir remonto darbų. Mūsų brigada pašalina visas statybines dulkes, dažų, tinko, glaisto, klijų ir kitų nešvarumų likučius. Mes plauname langus, palanges, lubas, liustras, grindjuostes, radiatorius ir visus paviršius iki idealios švaros.</p>

            <p>Be <strong>valymo po remonto Vilniuje</strong> siūlome reguliarų <strong>biurų valymą Vilniuje</strong>. Švarus biuras didina darbuotojų produktyvumą ir kuria gerą įspūdį klientams. Atliekame kasdienį, savaitinį ir generalinį biurų valymą bet kokio dydžio patalpoms. Nuolatiniams klientams taikome naudingas abonemento sąlygas su iki 25% nuolaida.</p>

            <p><strong>Komercinių patalpų valymas Vilniuje</strong> — dar viena svarbi mūsų veiklos sritis. Aptarnaujame parduotuves, grožio salonus, kavines, restoranus, medicinos centrus ir sandėlius. Kiekvienam objektui sudarome individualų valymo planą, naudojame profesionalias ekologiškas priemones ir atliekame kruopščią dezinfekciją.</p>

            <p>Dirbame 24 valandas per parą 7 dienas per savaitę, priimame tik atsiskaitymą banko kortele, naudojame modernią profesionalią įrangą ir garantuojame aukštą kokybę. Daugelis klientų pastebi, kad mes gerokai pranašesni už konkurentus pagal atvykimo greitį, darbo kokybę ir skaidrias kainas.</p>

            <p>Reikia valymo po remonto Vilniuje ar reguliaraus biurų valymo? Skambinkite +370 644 74842 arba palikite užklausą svetainėje. Mes greitai su jumis susisieksime, apskaičiuosime kainą ir atvyksime jums patogiu laiku.</p>
        </div>
    </div>
</section>

<!-- WHY US -->
<section id="why" class="py-24 bg-black text-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <h2 class="heading-font text-5xl text-center mb-12">Kodėl klientai renkasi Ukrbud.lt vietoj kitų įmonių</h2>
        <div class="grid md:grid-cols-4 gap-10 text-center">
            <div>
                <div class="text-6xl mb-4">⏱️</div>
                <h4 class="text-2xl font-medium">Atvykimas per 60 minučių</h4>
                <p class="text-white/70 mt-3">Visame Vilniuje ir artimiausiose apylinkėse</p>
            </div>
            <div>
                <div class="text-6xl mb-4">🌿</div>
                <h4 class="text-2xl font-medium">Ekologiškos priemonės</h4>
                <p class="text-white/70 mt-3">Saugu vaikams, gyvūnams ir alergiškiems žmonėms</p>
            </div>
            <div>
                <div class="text-6xl mb-4">💳</div>
                <h4 class="text-2xl font-medium">Atsiskaitymas banko kortele</h4>
                <p class="text-white/70 mt-3">Banko kortelės, pavedimai, Revolut</p>
            </div>
            <div>
                <div class="text-6xl mb-4">⭐</div>
                <h4 class="text-2xl font-medium">Kokybės garantija</h4>
                <p class="text-white/70 mt-3">Jei kažkas nepatiks — atvyksime nemokamai</p>
            </div>
        </div>
    </div>
</section>
<!-- Mūsų partneriai -->
<section class="py-20 bg-white border-t border-gray-100">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="text-center mb-12">
            <h2 class="heading-font text-4xl font-semibold text-gray-900">Mūsų partneriai</h2>
            <p class="text-gray-600 mt-3 text-lg">Mes bendradarbiaujame su patikimomis įmonėmis, kad užtikrintume aukščiausią paslaugų kokybę</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center justify-items-center">
            
            <a href="https://balticclean.lt" target="_blank" class="group flex flex-col items-center justify-center p-8 bg-gray-50 hover:bg-white border border-gray-100 hover:border-cyan-200 rounded-3xl transition-all duration-300 hover:shadow-xl">
                <div class="w-28 h-28 flex items-center justify-center text-6xl mb-6 group-hover:scale-110 transition-transform">🧼</div>
                <span class="font-semibold text-xl text-gray-800 group-hover:text-cyan-600 transition-colors">Baltic Clean</span>
                <span class="text-sm text-gray-500 mt-1">Profesionalus valymas</span>
            </a>

            <a href="https://meistru.lt" target="_blank" class="group flex flex-col items-center justify-center p-8 bg-gray-50 hover:bg-white border border-gray-100 hover:border-cyan-200 rounded-3xl transition-all duration-300 hover:shadow-xl">
                <div class="w-28 h-28 flex items-center justify-center text-6xl mb-6 group-hover:scale-110 transition-transform">🔧</div>
                <span class="font-semibold text-xl text-gray-800 group-hover:text-cyan-600 transition-colors">Meistru.lt</span>
                <span class="text-sm text-gray-500 mt-1">Remonto paslaugos</span>
            </a>

            <a href="https://bilohash.com" target="_blank" class="group flex flex-col items-center justify-center p-8 bg-gray-50 hover:bg-white border border-gray-100 hover:border-cyan-200 rounded-3xl transition-all duration-300 hover:shadow-xl">
                <div class="w-28 h-28 flex items-center justify-center text-5xl mb-6 group-hover:scale-110 transition-transform">💻</div>
                <span class="font-semibold text-xl text-gray-800 group-hover:text-cyan-600 transition-colors">Bilohash.com</span>
                <span class="text-sm text-gray-500 mt-1">Svetainių kūrimas ir skaitmeniniai sprendimai</span>
            </a>

            <div class="flex flex-col items-center justify-center p-8 bg-gray-50 border border-dashed border-gray-200 rounded-3xl opacity-60">
                <div class="w-28 h-28 flex items-center justify-center text-6xl mb-6">🤝</div>
                <span class="font-semibold text-xl text-gray-400">Tapkite mūsų partneriu</span>
            </div>
        </div>
    </div>
</section>
<!-- REVIEWS -->
<section id="reviews" class="py-24 bg-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <h2 class="heading-font text-5xl text-center mb-12">Atsiliepimai apie mūsų valymą po remonto ir biurų</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-gray-50 p-8 rounded-3xl">
                <p class="italic">"Puikus valymas po remonto Vilniuje! 95 m² butas po statybų spindėjo švara jau po 5 valandų. Labai rekomenduoju Ukrbud.lt!"</p>
                <div class="mt-6 text-sm font-medium">— Anna, Pašilaičių rajonas</div>
            </div>
            <div class="bg-gray-50 p-8 rounded-3xl">
                <p class="italic">"Reguliarus biurų valymas Vilniuje 220 m² patalpoms. Viskas visada laiku, kokybiškai ir už gerą kainą. Atsiskaitymas banko kortele — labai patogu įmonei."</p>
                <div class="mt-6 text-sm font-medium">— Dmitrijus, IT įmonės vadovas</div>
            </div>
            <div class="bg-gray-50 p-8 rounded-3xl">
                <p class="italic">"Komercinės patalpos valymas po remonto. Viską padarė idealiai švariai. Dabar užsakome valymą kiekvieną mėnesį. Ačiū už profesionalumą!"</p>
                <div class="mt-6 text-sm font-medium">— Marija, grožio salono savininkė</div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section id="faq" class="py-24 bg-gray-50">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <h2 class="heading-font text-5xl text-center mb-12">Dažniausiai užduodami klausimai apie valymą Vilniuje</h2>
        <div class="max-w-4xl mx-auto space-y-6">
            <details class="bg-white p-8 rounded-3xl shadow-sm">
                <summary class="text-xl font-semibold cursor-pointer">Kiek kainuoja valymas po remonto Vilniuje?</summary>
                <p class="mt-6 text-gray-600">Kaina prasideda nuo 2.8 €/m², priklausomai nuo ploto ir darbų sudėtingumo. Naudokite mūsų internetinį kalkuliatorių preliminariam apskaičiavimui.</p>
            </details>
            <details class="bg-white p-8 rounded-3xl shadow-sm">
                <summary class="text-xl font-semibold cursor-pointer">Kaip greitai atvykstate biurų valymui Vilniuje?</summary>
                <p class="mt-6 text-gray-600">Mes garantuojame brigados atvykimą per 60 minučių po užsakymo patvirtinimo visame Vilniuje.</p>
            </details>
            <details class="bg-white p-8 rounded-3xl shadow-sm">
                <summary class="text-xl font-semibold cursor-pointer">Ar dirbate su komercinėmis patalpomis?</summary>
                <p class="mt-6 text-gray-600">Taip, atliekame komercinių patalpų valymą Vilniuje: parduotuvėms, kavinėms, salonams, sandėliams ir medicinos centrams.</p>
            </details>
            <details class="bg-white p-8 rounded-3xl shadow-sm">
                <summary class="text-xl font-semibold cursor-pointer">Ar naudojate ekologiškas valymo priemones?</summary>
                <p class="mt-6 text-gray-600">Taip, visos priemonės yra saugios vaikams, gyvūnams ir alergiškiems žmonėms.</p>
            </details>
        </div>
    </div>
</section>

<!-- CONTACT FORM -->
<section id="contact" class="py-24 bg-gradient-to-br from-cyan-600 to-blue-700 text-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="grid lg:grid-cols-2 gap-16">
            <div>
                <h2 class="heading-font text-5xl font-semibold">Palikti užsakymą valymui</h2>
                <p class="mt-6 text-xl">Užpildykite formą, ir mūsų vadybininkas susisieks su jumis per kelias minutes detalių patikslinimui.</p>
                <?php if ($success): ?>
                    <div class="mt-10 bg-emerald-400 text-black p-8 rounded-3xl text-center text-2xl font-medium">✅ Užsakymas sėkmingai išsiųstas! Ačiū, netrukus su jumis susisieksime.</div>
                <?php elseif ($error): ?>
                    <div class="mt-10 bg-red-500 p-8 rounded-3xl text-center"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form method="POST" class="mt-10 space-y-8">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <input type="text" name="name" required placeholder="Jūsų vardas" class="w-full bg-white/10 border border-white/30 rounded-3xl px-8 py-6 text-white placeholder-white/60 focus:outline-none">
                    <input type="tel" name="phone" required placeholder="+370 644 74842" class="w-full bg-white/10 border border-white/30 rounded-3xl px-8 py-6 text-white placeholder-white/60 focus:outline-none">
                    <textarea name="message" rows="5" placeholder="Aprašykite užduotį (valymas po remonto buto, biuras 150 m² ir t.t.)" class="w-full bg-white/10 border border-white/30 rounded-3xl px-8 py-6 text-white placeholder-white/60 focus:outline-none"></textarea>
                    <button type="submit" name="submit_order" class="w-full py-7 bg-white text-black font-bold text-2xl rounded-3xl hover:bg-cyan-300">Siųsti užsakymą</button>
                </form>
            </div>
            <div class="flex flex-col justify-center items-center lg:items-start text-center lg:text-left">
                <div class="text-7xl flex gap-12 mb-12">
                    <a href="https://wa.me/37064474842" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="https://t.me/+37064474842" target="_blank"><i class="fa-brands fa-telegram"></i></a>
                    <a href="viber://chat?number=%2B37064474842" target="_blank"><i class="fa-brands fa-viber"></i></a>
                </div>
                <a href="tel:+37064474842" class="text-5xl font-bold hover:text-cyan-200">+370 644 74842</a>
                <p class="mt-4 text-xl">Skambinkite arba rašykite į messengerius bet kuriuo metu</p>
            </div>
        </div>
    </div>
</section>

<!-- Блок подписки на скидку 30% (переведено) -->
<section class="py-24 bg-gradient-to-br from-black via-zinc-900 to-black text-white relative overflow-hidden">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="max-w-2xl mx-auto text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-cyan-500/10 rounded-3xl mb-8">
                <span class="text-5xl">🎁</span>
            </div>
            <h2 class="heading-font text-5xl lg:text-6xl font-semibold leading-none tracking-[-1px] mb-6">
                Prenumeruokite ir gaukite <span class="text-cyan-400">30% nuolaidą</span>
            </h2>
           
            <p class="text-xl text-white/80 mb-10 max-w-md mx-auto">
                Pirmam valymui po remonto, biurų ar komercinių patalpų.<br>
                Nuolaida galioja 30 dienas po prenumeratos.
            </p>
            <form id="subscribe-form" class="max-w-md mx-auto">
                <div class="flex flex-col sm:flex-row gap-3">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        required
                        placeholder="Jūsų el. pašto adresas"
                        class="flex-1 bg-white/10 border border-white/30 rounded-3xl px-8 py-6 text-white placeholder-white/60 focus:outline-none focus:border-cyan-400 transition-all text-lg">
                   
                    <button
                        type="submit"
                        class="bg-cyan-400 hover:bg-cyan-300 transition-all text-black font-bold text-lg px-10 py-6 rounded-3xl whitespace-nowrap">
                        Gauti nuolaidą
                    </button>
                </div>
               
                <p class="text-xs text-white/50 mt-4">
                    Mes gerbiame jūsų privatumą. Atsisakyti galite bet kada.
                </p>
            </form>
            <div id="subscribe-success" class="hidden mt-8 bg-emerald-500/20 border border-emerald-400 text-emerald-300 p-6 rounded-3xl">
                ✅ Ačiū! 30% nuolaida išsiųsta į jūsų el. paštą. Patikrinkite pašto dėžutę.
            </div>
            <div id="subscribe-error" class="hidden mt-8 bg-red-500/20 border border-red-400 text-red-300 p-6 rounded-3xl">
                ❌ Klaida. Bandykite vėliau arba rašykite mums tiesiogiai.
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
                <p class="text-sm max-w-xs mx-auto md:mx-0">Profesionalus valymas po remonto, biurų ir komercinių patalpų Vilniuje nuo 2018 metų.</p>
            </div>

            <div class="text-center">
                <h4 class="text-white text-lg font-semibold mb-6">Greitos nuorodos</h4>
                <div class="flex flex-col gap-y-3 text-sm">
                    <a href="#services" class="hover:text-cyan-400">Paslaugos</a>
                    <a href="#calculator" class="hover:text-cyan-400">Kalkuliatorius</a>
                    <a href="#prices" class="hover:text-cyan-400">Kainos</a>
                    <a href="#faq" class="hover:text-cyan-400">Klausimai</a>
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
            <p class="text-center md:text-left">© 2025–2026 Ukrbud.lt — Valymas po remonto Vilniuje, biurų valymas Vilniuje, komercinių patalpų valymas Vilniuje</p>

            <a href="https://bilohash.com" target="_blank" class="want-site-btn group inline-flex items-center gap-4 bg-gradient-to-r from-cyan-500 via-blue-500 to-cyan-500 text-white font-semibold text-xl px-12 py-6 rounded-3xl glow-animation">
                <span class="relative z-10 flex items-center gap-3">
                    NORIU TOKIOS SVETAINĖS!
                    <i class="fa-solid fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                </span>
            </a>

            <?php include 'counter.php'; ?>
        </div>
    </div>
</footer>

<!-- Языковой виджет (оставлен как был, т.к. это функционал) -->
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

<!-- Скрипты (AJAX подписки, языковой виджет, мобильное меню, калькулятор) — оставлены без изменений, кроме мелких правок для литовского -->
<script>
// Обработка подписки через AJAX
document.getElementById('subscribe-form').addEventListener('submit', function(e) {
    e.preventDefault();
   
    const emailInput = document.getElementById('email');
    const email = emailInput.value.trim();
    const successDiv = document.getElementById('subscribe-success');
    const errorDiv = document.getElementById('subscribe-error');
   
    if (!email) return;

    const button = this.querySelector('button');
    const originalText = button.textContent;
    button.textContent = 'Siunčiame...';
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

    window.addEventListener('load', () => {
        startFlagRotation();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape") {
            document.getElementById('language-menu').classList.add('hidden');
            startFlagRotation();
        }
    });
</script>

<style>
    #lang-button {
        box-shadow: 0 15px 25px -5px rgb(0 0 0 / 0.15), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    }
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

    console.log('%c✅ Pilnas index.php paruoštas! Ukrbud.lt dabar stipresnis už pelenes.lt pagal SEO ir funkcionalumą', 'color:#22d3ee; font-size:15px; font-weight:700');
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
