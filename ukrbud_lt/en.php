<?php
// ========================================================
// Ukrbud.lt - en.php (Full powerful version 2026)
// Maximum SEO + Best calculator + Beautiful emails
// ========================================================
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Variables for order form
$success = false;
$error = '';

// ========================================================
// ORDER FORM PROCESSING — with beautiful emails
// ========================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_order'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = 'Security error. Please refresh the page.';
    } else {
        $name    = trim(htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES));
        $phone   = trim(htmlspecialchars($_POST['phone'] ?? '', ENT_QUOTES));
        $message = trim(htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES));

        if (empty($name) || empty($phone)) {
            $error = 'Name and phone number are required!';
        } elseif (!preg_match('/^[\+]?[\d\s\-\(\)]{10,18}$/', $phone)) {
            $error = 'Invalid phone number format!';
        } else {
            $order_id = "UKR-" . date("YmdHis");

            // ==================== EMAIL TO CLIENT (beautiful HTML) ====================
            $client_subject = "✅ Order #$order_id Accepted | Ukrbud.lt";

            $client_message = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Order Accepted</title>
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
                        <h1 style="margin:0; font-size:32px;">Your Order Has Been Accepted!</h1>
                        <p style="margin:15px 0 0; font-size:20px;">Order number: <strong>' . $order_id . '</strong></p>
                    </div>
                   
                    <div class="content">
                        <p>Hello, <strong>' . $name . '</strong>!</p>
                        <p>Thank you for trusting <strong>Ukrbud.lt</strong> — a professional cleaning company in Vilnius.</p>
                       
                        <div class="info-box">
                            <strong>Your order #' . $order_id . ' has been accepted and is being processed.</strong><br><br>
                            Our manager will contact you within 15–60 minutes to clarify details and schedule a convenient time for the team to arrive.
                        </div>

                        <p><strong>Your order details:</strong></p>
                        <p>Name: ' . $name . '<br>
                           Phone: ' . $phone . '<br>
                           Message: ' . nl2br($message) . '</p>

                        <p style="text-align:center;">
                            <a href="tel:+37064474842" class="button">Call us now →</a>
                        </p>

                        <p>If you have any additional requests — simply reply to this email.</p>
                    </div>
                   
                    <div class="footer">
                        Best regards,<br>
                        <strong>Ukrbud.lt Team</strong><br>
                        Professional cleaning after renovation • Office cleaning • Commercial premises cleaning<br>
                        Vilnius • +370 644 74842
                    </div>
                </div>
            </body>
            </html>';

            // ==================== EMAIL TO ADMIN (you) ====================
            $admin_subject = "New Order #$order_id — Ukrbud.lt";
            $admin_body = "NEW CLEANING ORDER\n\n";
            $admin_body .= "Order number: $order_id\n";
            $admin_body .= "Name: $name\n";
            $admin_body .= "Phone: $phone\n";
            $admin_body .= "Message:\n$message\n\n";
            $admin_body .= "Date: " . date('d.m.Y H:i:s') . "\n";
            $admin_body .= "IP: " . $_SERVER['REMOTE_ADDR'] . "\n";

            $admin_headers = "From: no-reply@ukrbud.lt\r\nContent-Type: text/plain; charset=utf-8\r\n";

            // Send emails
            $headers_client = "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Ukrbud.lt <no-reply@ukrbud.lt>\r\n";

            mail("rbilohash@gmail.com, valeriapilipiuk@gmail.com, ulianasemashko@gmail.com, booking@balticclean.lt", $admin_subject, $admin_body, $admin_headers);
            mail($email ?? "rbilohash@gmail.com", $client_subject, $client_message, $headers_client);

            $success = true;
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }
}

// ========================================================
// 30% Discount Subscription Processing
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
           
            $subject = "🎁 Your 30% Discount on Cleaning in Vilnius from Ukrbud.lt";
           
            $message = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Your 30% Discount</title>
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
                        <h1 style="margin:0; font-size:32px;">🎁 Congratulations!</h1>
                        <p style="margin:10px 0 0; font-size:20px;">You have received a 30% discount</p>
                    </div>
                   
                    <div class="content">
                        <p>Hello!</p>
                        <p>Thank you for subscribing to the Ukrbud.lt newsletter — a professional cleaning company in Vilnius.</p>
                        <p>Your gift is a <strong>30% discount on your first cleaning</strong> (after renovation, offices or commercial premises).</p>
                       
                        <div class="discount-box">
                            <p style="margin:0 0 10px; font-size:18px; color:#64748b;">Your promo code:</p>
                            <div class="code">' . $discount_code . '</div>
                            <p style="margin:15px 0 0; color:#64748b;">Valid for 30 days</p>
                        </div>
                       
                        <p style="text-align:center;">
                            <a href="https://ukrbud.lt/#contact" class="button">Order cleaning with discount →</a>
                        </p>
                       
                        <p>Simply show this code to our manager when placing an order.</p>
                       
                        <p>Best regards,<br>
                        <strong>Ukrbud.lt Team</strong><br>
                        Professional cleaning in Vilnius<br>
                        +370 644 74842</p>
                    </div>
                   
                    <div class="footer">
                        © 2026 Ukrbud.lt — Cleaning after renovation, offices and commercial premises in Vilnius<br>
                        If you no longer wish to receive emails — simply reply with the text "Unsubscribe".
                    </div>
                </div>
            </body>
            </html>';

            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=utf-8\r\n";
            $headers .= "From: Ukrbud.lt <no-reply@ukrbud.lt>\r\n";
            $headers .= "Reply-To: no-reply@ukrbud.lt\r\n";

            mail($email, $subject, $message, $headers);

            $notify_subject = "New 30% Discount Subscription — ukrbud.lt";
            $notify_body = "New subscription:\nEmail: $email\nPromo code: $discount_code\nDate: " . date('d.m.Y H:i:s') . "\nIP: " . $_SERVER['REMOTE_ADDR'];
            $notify_headers = "From: no-reply@ukrbud.lt\r\nContent-Type: text/plain; charset=utf-8\r\n";
           
            mail("rbilohash@gmail.com, valeriapilipiuk@gmail.com, ulianasemashko@gmail.com, booking@balticclean.lt", $notify_subject, $notify_body, $notify_headers);
        }
       
        $subscribe_success = true;
    } else {
        $subscribe_error = 'Please enter a valid email address';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Основні SEO мета-теги -->
    <meta name="description" content="Cleaning after renovation in Vilnius from 2.8 €/m² ✓ Professional office cleaning in Vilnius ✓ Commercial premises cleaning ✓ Online price calculator ✓ Team arrives within 60 minutes ✓ 24/7 service ✓ Card payment ✓ Ukrbud.lt +370 644 74842">
    <meta name="keywords" content="cleaning after renovation Vilnius, office cleaning Vilnius, commercial cleaning Vilnius, general cleaning Vilnius, post-construction cleaning Vilnius, cleaning company Vilnius">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Ukrbud.lt">
    <meta name="language" content="en">
    <link rel="canonical" href="https://ukrbud.lt/en.php">
<!-- Hreflang для багатомовності -->
<link rel="alternate" hreflang="en" href="https://ukrbud.lt/en.php" />
<link rel="alternate" hreflang="lt" href="https://ukrbud.lt/" />
<link rel="alternate" hreflang="ru" href="https://ukrbud.lt/ru.php" />
<link rel="alternate" hreflang="uk" href="https://ukrbud.lt/ua.php" />
<link rel="alternate" hreflang="x-default" href="https://ukrbud.lt/" />
    <title>Cleaning after Renovation Vilnius | Office Cleaning | Commercial Cleaning | Ukrbud.lt</title>

    <!-- Open Graph / Facebook + Instagram + Telegram + LinkedIn -->
    <meta property="og:title" content="Cleaning after Renovation Vilnius • Ukrbud.lt">
    <meta property="og:description" content="Professional cleaning after renovation, offices and commercial premises in Vilnius. Online price calculator. Arrival within 60 minutes. +370 644 74842">
    <meta property="og:image" content="https://ukrbud.lt/og-image.jpg">
    <meta property="og:url" content="https://ukrbud.lt/en.php">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Ukrbud.lt">
    <meta property="og:locale" content="en_US">
    <meta property="og:locale:alternate" content="lt_LT">
    <meta property="og:locale:alternate" content="ru_RU">
    <meta property="og:locale:alternate" content="uk_UA">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Cleaning after Renovation Vilnius • Ukrbud.lt">
    <meta name="twitter:description" content="Professional cleaning after renovation, offices and commercial premises in Vilnius. Online price calculator. Arrival within 60 minutes.">
    <meta name="twitter:image" content="https://ukrbud.lt/og-image.jpg">

    <!-- Додаткові соціальні мета -->
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Cleaning after renovation in Vilnius - Ukrbud.lt">

    <!-- Schema.org - Extended markup -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "Ukrbud.lt",
        "description": "Professional cleaning after renovation, offices and commercial premises in Vilnius",
        "url": "https://ukrbud.lt/en.php",
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
        "name": "Cleaning after Renovation in Vilnius",
        "description": "Professional cleaning after renovation of apartments, houses and offices in Vilnius",
        "provider": {
            "@type": "LocalBusiness",
            "name": "Ukrbud.lt"
        },
        "areaServed": "Vilnius",
        "hasOfferCatalog": {
            "@type": "OfferCatalog",
            "name": "Cleaning Prices",
            "itemListElement": [
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "Service",
                        "name": "Cleaning after Renovation"
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
                "name": "How much does cleaning after renovation in Vilnius cost?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "The price starts from 2.8 €/m² depending on the area and complexity of the work."
                }
            },
            {
                "@type": "Question",
                "name": "How quickly do you arrive for office cleaning in Vilnius?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "We guarantee team arrival within 60 minutes after order confirmation."
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
            <a href="#services" class="hover:text-cyan-400">Services</a>
            <a href="#calculator" class="hover:text-cyan-400">Calculator</a>
            <a href="#prices" class="hover:text-cyan-400">Prices</a>
            <a href="#why" class="hover:text-cyan-400">Why Us</a>
            <a href="#reviews" class="hover:text-cyan-400">Reviews</a>
            <a href="#faq" class="hover:text-cyan-400">FAQ</a>
            <a href="#contact" class="hover:text-cyan-400">Contact</a>
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

    <!-- Full mobile menu -->
    <div id="mobile-menu" class="hidden lg:hidden bg-black border-t border-white/10 px-6 py-10">
        <div class="flex flex-col gap-y-6 text-white text-2xl font-medium">
            <a href="#services" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Services</a>
            <a href="#calculator" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Price Calculator</a>
            <a href="#prices" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Prices</a>
            <a href="#why" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Why Us</a>
            <a href="#reviews" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Reviews</a>
            <a href="#faq" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Frequently Asked Questions</a>
            <a href="#contact" onclick="toggleMobileMenu()" class="py-3">Contact</a>
            <div class="pt-8 flex flex-col gap-4">
                <a href="tel:+37064474842" onclick="toggleMobileMenu()" class="text-center bg-white text-black py-5 rounded-3xl font-bold">Call +370 644 74842</a>
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
                    Vilnius and surroundings • 24/7 • Arrival within 60 minutes • Card payment
                </div>
                <h1 class="heading-font text-5xl md:text-6xl lg:text-7xl font-semibold leading-none tracking-[-2px]">
                    Cleaning after Renovation in Vilnius<br>Office Cleaning in Vilnius<br>Commercial Premises Cleaning
                </h1>
                <p class="text-2xl text-white/80">Professional cleaning company Ukrbud.lt offers high-quality cleaning after renovation, general office cleaning and commercial premises cleaning at the best prices in Vilnius. We use modern equipment and eco-friendly products. Online price calculator.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="#calculator" class="px-10 py-6 bg-cyan-400 text-black font-bold text-xl rounded-3xl hover:bg-cyan-300">Calculate price online</a>
                    <a href="tel:+37064474842" class="px-10 py-6 border border-white/40 text-xl font-bold rounded-3xl hover:bg-white/10">Call +370 644 74842</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES -->
<section id="services" class="py-24 bg-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="text-center mb-12">
            <h2 class="heading-font text-5xl font-semibold">Cleaning Services in Vilnius</h2>
        </div>
        <p class="max-w-4xl mx-auto text-center text-xl text-gray-600 mb-16">
            We specialize in <strong>cleaning after renovation in Vilnius</strong>. Our team quickly and efficiently removes construction dust, paint residues, plaster, putty and other construction debris. We also provide regular <strong>office cleaning in Vilnius</strong> and <strong>commercial premises cleaning in Vilnius</strong> — shops, beauty salons, cafes, warehouses and medical centres.
        </p>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="service-card bg-white border border-gray-100 rounded-3xl p-10 shadow-xl">
                <div class="text-6xl mb-6">🏗️</div>
                <h3 class="text-3xl font-semibold">Cleaning after Renovation in Vilnius</h3>
                <p class="text-gray-600 mt-4">Full professional cleaning cycle after renovation: removal of construction dust from all surfaces, window washing, cleaning of ceilings, chandeliers, baseboards, radiators and floors. After our team, the premises look brand new. Arrival within 60 minutes across Vilnius.</p>
                <div class="mt-8 text-cyan-400 font-semibold">from 2.8 €/m²</div>
            </div>
            <div class="service-card bg-white border border-gray-100 rounded-3xl p-10 shadow-xl">
                <div class="text-6xl mb-6">🏢</div>
                <h3 class="text-3xl font-semibold">Office Cleaning in Vilnius</h3>
                <p class="text-gray-600 mt-4">Daily, weekly and general office cleaning of any size. Clean workstations, bathrooms, kitchens and meeting rooms. We maintain a high level of cleanliness for your business. Regular clients receive up to 25% discount.</p>
                <div class="mt-8 text-cyan-400 font-semibold">from 2.5 €/m²</div>
            </div>
            <div class="service-card bg-white border border-gray-100 rounded-3xl p-10 shadow-xl">
                <div class="text-6xl mb-6">🛒</div>
                <h3 class="text-3xl font-semibold">Commercial Premises Cleaning in Vilnius</h3>
                <p class="text-gray-600 mt-4">High-quality cleaning for shops, beauty salons, cafes, restaurants, warehouses and medical centres. Deep cleaning, disinfection, individual approach to each object. We work 24/7 without days off.</p>
                <div class="mt-8 text-cyan-400 font-semibold">Individually</div>
            </div>
        </div>
    </div>
</section>

<!-- КАЛЬКУЛЯТОР -->
<section id="calculator" class="py-24 bg-gray-50">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="text-center mb-12">
            <h2 class="heading-font text-5xl font-semibold">Cleaning Price Calculator in Vilnius</h2>
            <p class="text-xl text-gray-600 mt-4">Find out the estimated price in 20 seconds. The exact cost will be confirmed by a specialist after inspection.</p>
        </div>
        <div class="max-w-2xl mx-auto bg-white rounded-3xl shadow-2xl p-10">
            <div class="space-y-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Service Type</label>
                    <select id="service-type" class="w-full border border-gray-300 rounded-3xl px-6 py-5 text-lg focus:outline-none focus:border-cyan-400">
                        <option value="post-repair">Cleaning after Renovation in Vilnius</option>
                        <option value="office">Office Cleaning in Vilnius</option>
                        <option value="commercial">Commercial Premises Cleaning</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Premises Area (m²)</label>
                    <input type="number" id="area" value="100" min="10" class="w-full border border-gray-300 rounded-3xl px-6 py-5 text-lg focus:outline-none focus:border-cyan-400">
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <label class="flex items-center gap-3 cursor-pointer text-lg">
                        <input type="checkbox" id="windows" class="w-6 h-6 accent-cyan-400"> Window Cleaning
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer text-lg">
                        <input type="checkbox" id="furniture" class="w-6 h-6 accent-cyan-400"> Furniture Dry Cleaning
                    </label>
                </div>
                <button onclick="calculatePrice()" 
                        class="w-full py-7 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold text-2xl rounded-3xl hover:brightness-110 transition">
                    Calculate Price
                </button>
                <div id="calc-result" class="hidden text-center mt-8 p-10 bg-gradient-to-br from-gray-50 to-white rounded-3xl">
                    <p class="text-gray-600 text-xl">Estimated Cost:</p>
                    <div id="result-price" class="calc-result mt-4">0 €</div>
                    <p class="text-sm text-gray-500 mt-6">* This is an approximate price. The final cost will be confirmed by the manager after inspection.</p>
                    <a href="#contact" class="mt-8 inline-block px-12 py-5 bg-black text-white font-semibold text-xl rounded-3xl hover:bg-cyan-400 hover:text-black">Order Cleaning at This Price</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PRICES -->
<section id="prices" class="py-24 bg-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <h2 class="heading-font text-5xl text-center mb-4">Prices for Cleaning after Renovation and Office Cleaning in Vilnius</h2>
        <div class="overflow-x-auto mt-12 rounded-3xl bg-white shadow-2xl">
            <table class="w-full min-w-[900px]">
                <thead>
                    <tr class="border-b">
                        <th class="pl-10 py-7 text-left font-medium text-gray-500">Service</th>
                        <th class="pl-10 py-7 text-left font-medium text-gray-500">Area</th>
                        <th class="pr-10 py-7 text-right font-medium text-gray-500">Price from</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="price-row border-b">
                        <td class="pl-10 py-7 font-medium">Cleaning after Renovation in Vilnius</td>
                        <td class="pl-10 py-7">up to 100 m²</td>
                        <td class="pr-10 py-7 text-right font-semibold text-emerald-600">2.8 €/m²</td>
                    </tr>
                    <tr class="price-row border-b">
                        <td class="pl-10 py-7 font-medium">Cleaning after Renovation in Vilnius</td>
                        <td class="pl-10 py-7">100–300 m²</td>
                        <td class="pr-10 py-7 text-right font-semibold text-emerald-600">2.5 €/m²</td>
                    </tr>
                    <tr class="price-row border-b">
                        <td class="pl-10 py-7 font-medium">Office Cleaning in Vilnius (daily/general)</td>
                        <td class="pl-10 py-7">up to 200 m²</td>
                        <td class="pr-10 py-7 text-right font-semibold text-emerald-600">2.5 €/m²</td>
                    </tr>
                    <tr class="price-row border-b">
                        <td class="pl-10 py-7 font-medium">Commercial Premises Cleaning in Vilnius</td>
                        <td class="pl-10 py-7">from 50 m²</td>
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
        <h2 class="heading-font text-5xl text-center mb-12">Why Choose Ukrbud.lt for Cleaning after Renovation in Vilnius</h2>
        <div class="prose prose-lg max-w-4xl mx-auto text-gray-700 leading-relaxed space-y-8">
            <p>If you need high-quality <strong>cleaning after renovation in Vilnius</strong> — contact the professional cleaning company Ukrbud.lt. We quickly and thoroughly clean apartments, houses, offices and commercial premises after construction and renovation works. Our team removes all construction dust, paint residues, plaster, putty, glue and other debris. We wash windows, windowsills, ceilings, chandeliers, baseboards, radiators and all surfaces to a perfect shine.</p>

            <p>In addition to <strong>cleaning after renovation in Vilnius</strong>, we offer regular <strong>office cleaning in Vilnius</strong>. A clean office increases employee productivity and creates a good impression on clients. We perform daily, weekly and general cleaning of office premises of any size. Regular clients receive advantageous subscription terms with up to 25% discount.</p>

            <p><strong>Commercial premises cleaning in Vilnius</strong> is another important area of our work. We serve shops, beauty salons, cafes, restaurants, medical centres and warehouses. Each object receives an individual cleaning plan, the use of professional eco-friendly products and thorough disinfection.</p>

            <p>We work 24 hours a day, 7 days a week, accept only card payments, use modern professional equipment and guarantee high quality. Many clients note that we are significantly better than competitors in terms of arrival speed, work quality and transparent prices.</p>

            <p>Need cleaning after renovation in Vilnius or regular office cleaning? Call +370 644 74842 or leave a request on the website. We will contact you promptly, calculate the cost and arrive at a time convenient for you.</p>
        </div>
    </div>
</section>

<!-- WHY US -->
<section id="why" class="py-24 bg-black text-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <h2 class="heading-font text-5xl text-center mb-12">Why Clients Choose Ukrbud.lt Over Other Companies</h2>
        <div class="grid md:grid-cols-4 gap-10 text-center">
            <div>
                <div class="text-6xl mb-4">⏱️</div>
                <h4 class="text-2xl font-medium">Arrival within 60 minutes</h4>
                <p class="text-white/70 mt-3">Throughout Vilnius and nearby areas</p>
            </div>
            <div>
                <div class="text-6xl mb-4">🌿</div>
                <h4 class="text-2xl font-medium">Eco-friendly products</h4>
                <p class="text-white/70 mt-3">Safe for children, pets and allergy sufferers</p>
            </div>
            <div>
                <div class="text-6xl mb-4">💳</div>
                <h4 class="text-2xl font-medium">Card payment</h4>
                <p class="text-white/70 mt-3">Bank cards, transfers, Revolut</p>
            </div>
            <div>
                <div class="text-6xl mb-4">⭐</div>
                <h4 class="text-2xl font-medium">Quality guarantee</h4>
                <p class="text-white/70 mt-3">If something is not to your liking — we will come back for free</p>
            </div>
        </div>
    </div>
</section>
<!-- Our Partners Block -->
<section class="py-20 bg-white border-t border-gray-100">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="text-center mb-12">
            <h2 class="heading-font text-4xl font-semibold text-gray-900">Our Partners</h2>
            <p class="text-gray-600 mt-3 text-lg">We collaborate with trusted companies to deliver the best service</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center justify-items-center">
            
            <a href="https://balticclean.lt" target="_blank" class="group flex flex-col items-center justify-center p-8 bg-gray-50 hover:bg-white border border-gray-100 hover:border-cyan-200 rounded-3xl transition-all duration-300 hover:shadow-xl">
                <div class="w-28 h-28 flex items-center justify-center text-6xl mb-6 group-hover:scale-110 transition-transform">🧼</div>
                <span class="font-semibold text-xl text-gray-800 group-hover:text-cyan-600 transition-colors">Baltic Clean</span>
                <span class="text-sm text-gray-500 mt-1">Professional Cleaning</span>
            </a>

            <a href="https://meistru.lt" target="_blank" class="group flex flex-col items-center justify-center p-8 bg-gray-50 hover:bg-white border border-gray-100 hover:border-cyan-200 rounded-3xl transition-all duration-300 hover:shadow-xl">
                <div class="w-28 h-28 flex items-center justify-center text-6xl mb-6 group-hover:scale-110 transition-transform">🔧</div>
                <span class="font-semibold text-xl text-gray-800 group-hover:text-cyan-600 transition-colors">Meistru.lt</span>
                <span class="text-sm text-gray-500 mt-1">Repair Services</span>
            </a>

            <a href="https://bilohash.com" target="_blank" class="group flex flex-col items-center justify-center p-8 bg-gray-50 hover:bg-white border border-gray-100 hover:border-cyan-200 rounded-3xl transition-all duration-300 hover:shadow-xl">
                <div class="w-28 h-28 flex items-center justify-center text-5xl mb-6 group-hover:scale-110 transition-transform">💻</div>
                <span class="font-semibold text-xl text-gray-800 group-hover:text-cyan-600 transition-colors">Bilohash.com</span>
                <span class="text-sm text-gray-500 mt-1">Web Development & Digital Solutions</span>
            </a>

            <div class="flex flex-col items-center justify-center p-8 bg-gray-50 border border-dashed border-gray-200 rounded-3xl opacity-60">
                <div class="w-28 h-28 flex items-center justify-center text-6xl mb-6">🤝</div>
                <span class="font-semibold text-xl text-gray-400">Become Our Partner</span>
            </div>
        </div>
    </div>
</section>
<!-- REVIEWS -->
<section id="reviews" class="py-24 bg-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <h2 class="heading-font text-5xl text-center mb-12">Reviews about Our Cleaning after Renovation and Offices</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-gray-50 p-8 rounded-3xl">
                <p class="italic">"Excellent cleaning after renovation in Vilnius! A 95 m² apartment after construction was sparkling clean after just 5 hours. Highly recommend Ukrbud.lt!"</p>
                <div class="mt-6 text-sm font-medium">— Anna, Pašilaičiai district</div>
            </div>
            <div class="bg-gray-50 p-8 rounded-3xl">
                <p class="italic">"Regular office cleaning in Vilnius for 220 m². Everything is always on time, high quality and at a good price. Card payment is very convenient for the company."</p>
                <div class="mt-6 text-sm font-medium">— Dmitry, IT company manager</div>
            </div>
            <div class="bg-gray-50 p-8 rounded-3xl">
                <p class="italic">"Commercial premises cleaning after renovation. Everything was done perfectly clean. Now we order cleaning every month. Thank you for your professionalism!"</p>
                <div class="mt-6 text-sm font-medium">— Maria, beauty salon owner</div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section id="faq" class="py-24 bg-gray-50">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <h2 class="heading-font text-5xl text-center mb-12">Frequently Asked Questions about Cleaning in Vilnius</h2>
        <div class="max-w-4xl mx-auto space-y-6">
            <details class="bg-white p-8 rounded-3xl shadow-sm">
                <summary class="text-xl font-semibold cursor-pointer">How much does cleaning after renovation in Vilnius cost?</summary>
                <p class="mt-6 text-gray-600">The price starts from 2.8 €/m² depending on the area and complexity of the work. Use our online calculator for a preliminary calculation.</p>
            </details>
            <details class="bg-white p-8 rounded-3xl shadow-sm">
                <summary class="text-xl font-semibold cursor-pointer">How quickly do you arrive for office cleaning in Vilnius?</summary>
                <p class="mt-6 text-gray-600">We guarantee team arrival within 60 minutes after order confirmation throughout Vilnius.</p>
            </details>
            <details class="bg-white p-8 rounded-3xl shadow-sm">
                <summary class="text-xl font-semibold cursor-pointer">Do you work with commercial premises?</summary>
                <p class="mt-6 text-gray-600">Yes, we perform commercial premises cleaning in Vilnius: shops, cafes, salons, warehouses and medical centres.</p>
            </details>
            <details class="bg-white p-8 rounded-3xl shadow-sm">
                <summary class="text-xl font-semibold cursor-pointer">Do you use eco-friendly cleaning products?</summary>
                <p class="mt-6 text-gray-600">Yes, all products are safe for children, pets and people with allergies.</p>
            </details>
        </div>
    </div>
</section>

<!-- CONTACT FORM -->
<section id="contact" class="py-24 bg-gradient-to-br from-cyan-600 to-blue-700 text-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="grid lg:grid-cols-2 gap-16">
            <div>
                <h2 class="heading-font text-5xl font-semibold">Leave a Request for Cleaning</h2>
                <p class="mt-6 text-xl">Fill out the form and our manager will contact you within a few minutes to clarify the details.</p>
                <?php if ($success): ?>
                    <div class="mt-10 bg-emerald-400 text-black p-8 rounded-3xl text-center text-2xl font-medium">✅ Order successfully sent! Thank you, we will contact you soon.</div>
                <?php elseif ($error): ?>
                    <div class="mt-10 bg-red-500 p-8 rounded-3xl text-center"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form method="POST" class="mt-10 space-y-8">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <input type="text" name="name" required placeholder="Your Name" class="w-full bg-white/10 border border-white/30 rounded-3xl px-8 py-6 text-white placeholder-white/60 focus:outline-none">
                    <input type="tel" name="phone" required placeholder="+370 644 74842" class="w-full bg-white/10 border border-white/30 rounded-3xl px-8 py-6 text-white placeholder-white/60 focus:outline-none">
                    <textarea name="message" rows="5" placeholder="Describe the task (cleaning after apartment renovation, office 150 m², etc.)" class="w-full bg-white/10 border border-white/30 rounded-3xl px-8 py-6 text-white placeholder-white/60 focus:outline-none"></textarea>
                    <button type="submit" name="submit_order" class="w-full py-7 bg-white text-black font-bold text-2xl rounded-3xl hover:bg-cyan-300">Send Request</button>
                </form>
            </div>
            <div class="flex flex-col justify-center items-center lg:items-start text-center lg:text-left">
                <div class="text-7xl flex gap-12 mb-12">
                    <a href="https://wa.me/37064474842" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="https://t.me/+37064474842" target="_blank"><i class="fa-brands fa-telegram"></i></a>
                    <a href="viber://chat?number=%2B37064474842" target="_blank"><i class="fa-brands fa-viber"></i></a>
                </div>
                <a href="tel:+37064474842" class="text-5xl font-bold hover:text-cyan-200">+370 644 74842</a>
                <p class="mt-4 text-xl">Call or write to messengers at any time</p>
            </div>
        </div>
    </div>
</section>

<!-- Subscription Block 30% Discount -->
<section class="py-24 bg-gradient-to-br from-black via-zinc-900 to-black text-white relative overflow-hidden">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="max-w-2xl mx-auto text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-cyan-500/10 rounded-3xl mb-8">
                <span class="text-5xl">🎁</span>
            </div>
            <h2 class="heading-font text-5xl lg:text-6xl font-semibold leading-none tracking-[-1px] mb-6">
                Subscribe and Get <span class="text-cyan-400">30% Discount</span>
            </h2>
           
            <p class="text-xl text-white/80 mb-10 max-w-md mx-auto">
                On your first cleaning after renovation, office or commercial premises.<br>
                The discount is valid for 30 days after subscription.
            </p>
            <form id="subscribe-form" class="max-w-md mx-auto">
                <div class="flex flex-col sm:flex-row gap-3">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        required
                        placeholder="Your email address"
                        class="flex-1 bg-white/10 border border-white/30 rounded-3xl px-8 py-6 text-white placeholder-white/60 focus:outline-none focus:border-cyan-400 transition-all text-lg">
                   
                    <button
                        type="submit"
                        class="bg-cyan-400 hover:bg-cyan-300 transition-all text-black font-bold text-lg px-10 py-6 rounded-3xl whitespace-nowrap">
                        Get Discount
                    </button>
                </div>
               
                <p class="text-xs text-white/50 mt-4">
                    We respect your privacy. You can unsubscribe at any time.
                </p>
            </form>
            <div id="subscribe-success" class="hidden mt-8 bg-emerald-500/20 border border-emerald-400 text-emerald-300 p-6 rounded-3xl">
                ✅ Thank you! 30% discount has been sent to your email. Check your inbox.
            </div>
            <div id="subscribe-error" class="hidden mt-8 bg-red-500/20 border border-red-400 text-red-300 p-6 rounded-3xl">
                ❌ Error. Please try again later or contact us directly.
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
                <p class="text-sm max-w-xs mx-auto md:mx-0">Professional cleaning after renovation, offices and commercial premises in Vilnius since 2018.</p>
            </div>

            <div class="text-center">
                <h4 class="text-white text-lg font-semibold mb-6">Quick Links</h4>
                <div class="flex flex-col gap-y-3 text-sm">
                    <a href="#services" class="hover:text-cyan-400">Services</a>
                    <a href="#calculator" class="hover:text-cyan-400">Calculator</a>
                    <a href="#prices" class="hover:text-cyan-400">Prices</a>
                    <a href="#faq" class="hover:text-cyan-400">FAQ</a>
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
            <p class="text-center md:text-left">© 2025–2026 Ukrbud.lt — Cleaning after renovation in Vilnius, office cleaning in Vilnius, commercial premises cleaning in Vilnius</p>

            <a href="https://bilohash.com" target="_blank" class="want-site-btn group inline-flex items-center gap-4 bg-gradient-to-r from-cyan-500 via-blue-500 to-cyan-500 text-white font-semibold text-xl px-12 py-6 rounded-3xl glow-animation">
                <span class="relative z-10 flex items-center gap-3">
                    I WANT SUCH A WEBSITE!
                    <i class="fa-solid fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                </span>
            </a>

            <?php include 'counter.php'; ?>
        </div>
    </div>
</footer>

<!-- Language Widget -->
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

<!-- Scripts -->
<script>
// Subscribe form AJAX
document.getElementById('subscribe-form').addEventListener('submit', function(e) {
    e.preventDefault();
   
    const emailInput = document.getElementById('email');
    const email = emailInput.value.trim();
    const successDiv = document.getElementById('subscribe-success');
    const errorDiv = document.getElementById('subscribe-error');
   
    if (!email) return;

    const button = this.querySelector('button');
    const originalText = button.textContent;
    button.textContent = 'Sending...';
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

    console.log('%c✅ en.php is ready! Ukrbud.lt English version is now live.', 'color:#22d3ee; font-size:15px; font-weight:700');
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