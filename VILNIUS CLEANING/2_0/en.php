<?php
require_once __DIR__ . '/traffic_logger.php';

// Підключаємо reCAPTCHA v2 з новими ключами
require_once __DIR__ . '/recaptcha.php';

// ====================== en.php ======================
// ПОВНІСТЬЮ ГОТОВИЙ сайт Vilnius Cleaning (англійською)
// професійне прибирання квартир, офісів, після ремонту, чисті кухні, вітальні, ванни, пилососи, ганчірки, мочалки, швабри, еко-засоби, процес уборки, прибиральниці в роботі
// Максимальний SEO 2026 + дуже гарне повідомлення після замовлення
// Автор: Ruslan Bilohash | bilohash.com | github.com/Ruslan-Bilohash

$success = isset($_GET['success']) && $_GET['success'] == 1;
$error = isset($_GET['error']) && $_GET['error'] == 1 ? "Error sending the request. Please try again or write to us in messenger." : "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO META -->
    <title>Professional Cleaning in Vilnius | Vilnius Cleaning Service | Apartments, Offices & Post-Renovation</title>
    <meta name="description" content="Professional cleaning in Vilnius ✓ Apartments, offices, post-renovation & deep cleaning ✓ Eco-friendly products, professional vacuums, cloths & mops ✓ Fast service across all Vilnius districts ✓ 100% Cleanliness Guarantee ✓ Fixed price ✓ Tel: +370 644 74842">
    <meta name="keywords" content="cleaning Vilnius, Vilnius cleaning service, apartment cleaning Vilnius, office cleaning Vilnius, post-renovation cleaning Vilnius, deep cleaning Vilnius, eco cleaning Vilnius, professional cleaning Vilnius">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="author" content="Ruslan Bilohash">
    <meta name="theme-color" content="#10b981">
    <link rel="canonical" href="https://meistru.lt/en.php">

<!-- hreflang -->
<link rel="alternate" hreflang="lt" href="https://meistru.lt/" />
<link rel="alternate" hreflang="lt" href="https://meistru.lt/index.php" />
<link rel="alternate" hreflang="ru" href="https://meistru.lt/ru.php" />
<link rel="alternate" hreflang="uk" href="https://meistru.lt/ua.php" />
<link rel="alternate" hreflang="en" href="https://meistru.lt/en.php" />
<link rel="alternate" hreflang="no" href="https://meistru.lt/no.php" />
<link rel="alternate" hreflang="x-default" href="https://meistru.lt/" />

    <!-- OPEN GRAPH -->
    <meta property="og:title" content="Professional Cleaning in Vilnius | Apartments, Offices & Post-Renovation">
    <meta property="og:description" content="Fast & professional cleaning service in Vilnius. Eco products, guaranteed quality, quick response. +370 644 74842">
    <meta property="og:image" content="https://picsum.photos/seed/professional-cleaning-vilnius-hero-2026/1200/630">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:url" content="https://bilohash.com/en.php">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_US">
    <meta property="og:site_name" content="Vilnius Cleaning">

    <!-- TWITTER CARDS -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Professional Cleaning in Vilnius | Apartments, Offices & Post-Renovation">
    <meta name="twitter:description" content="Professional cleaning service in Vilnius ✓ Apartments • Offices • Post-renovation • Eco products • +370 644 74842">
    <meta name="twitter:image" content="https://picsum.photos/seed/professional-cleaning-vilnius-hero-2026/1200/630">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Playfair+Display:wght@700&amp;display=swap" rel="stylesheet">
    <!-- reCAPTCHA v2 -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Playfair+Display:wght@700&amp;display=swap');
        .hero-bg { background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('https://picsum.photos/seed/professional-cleaning-vilnius-hero-2026/2000/1200') center/cover no-repeat; }
        .card-hover { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-15px) scale(1.03); box-shadow: 0 25px 50px -12px rgb(16 185 129 / 0.4); }
        .flag { font-size: 1.5rem; transition: transform 0.3s; }
        .flag:hover { transform: scale(1.3); }
        .gallery-img { transition: transform 0.4s; }
        .gallery-img:hover { transform: scale(1.08); }
        .service-img { transition: all 0.4s ease; }
        .service-img:hover { filter: brightness(1.1); }
    </style>
</head>
<body class="font-sans bg-gray-50 text-gray-900">

    <!-- HEADER -->
    <header class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-broom text-4xl text-emerald-600"></i>
                <div>
                    <span class="text-3xl font-bold tracking-tight">VILNIUS CLEANING</span>
                </div>
            </div>
            <nav class="hidden md:flex items-center gap-8 text-lg font-medium">
                <a href="#services" class="hover:text-emerald-600 transition">Services</a>
                <a href="#advantages" class="hover:text-emerald-600 transition">Why Us</a>
                <a href="#how" class="hover:text-emerald-600 transition">How We Work</a>
                <a href="#gallery" class="hover:text-emerald-600 transition">Gallery</a>
                <a href="#reviews" class="hover:text-emerald-600 transition">Reviews</a>
                <a href="#faq" class="hover:text-emerald-600 transition">FAQ</a>
                <a href="#order" class="hover:text-emerald-600 transition">Order Now</a>
            </nav>
            <div class="relative group">
                <button onclick="toggleLang()" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-2xl transition">
                    <span class="flag">🇬🇧</span>
                    <span class="font-semibold">EN</span>
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </button>
                <div id="langDropdown" class="hidden group-hover:block absolute right-0 mt-3 bg-white shadow-2xl rounded-3xl py-4 w-52 z-50 border border-gray-100">
                    <a href="index.php" class="flex items-center gap-4 px-6 py-3 hover:bg-emerald-50 transition"><span class="flag">🇱🇹</span><span>Lietuvių</span></a>
                    <a href="no.php" class="flex items-center gap-4 px-6 py-3 hover:bg-emerald-50 transition"><span class="flag">🇳🇴</span><span>Norsk</span></a>
                    <a href="en.php" class="flex items-center gap-4 px-6 py-3 bg-emerald-50 text-emerald-700"><span class="flag">🇬🇧</span><span>English</span></a>
                    <a href="ru.php" class="flex items-center gap-4 px-6 py-3 hover:bg-emerald-50 transition"><span class="flag">🇷🇺</span><span>Русский</span></a>
                    <a href="ua.php" class="flex items-center gap-4 px-6 py-3 hover:bg-emerald-50 transition"><span class="flag">🇺🇦</span><span>Українська</span></a>
                </div>
            </div>
            <button onclick="toggleMobileMenu()" class="md:hidden text-3xl"><i class="fa-solid fa-bars"></i></button>
        </div>
    </header>

    <!-- MOBILE MENU -->
    <div id="mobileMenu" class="hidden md:hidden fixed inset-0 bg-white z-50 pt-20 px-6">
        <div class="flex flex-col gap-6 text-2xl font-medium">
            <a href="#services" onclick="toggleMobileMenu()" class="py-3 border-b">Services</a>
            <a href="#advantages" onclick="toggleMobileMenu()" class="py-3 border-b">Why Us</a>
            <a href="#how" onclick="toggleMobileMenu()" class="py-3 border-b">How We Work</a>
            <a href="#gallery" onclick="toggleMobileMenu()" class="py-3 border-b">Gallery</a>
            <a href="#reviews" onclick="toggleMobileMenu()" class="py-3 border-b">Reviews</a>
            <a href="#faq" onclick="toggleMobileMenu()" class="py-3 border-b">FAQ</a>
            <a href="#order" onclick="toggleMobileMenu()" class="py-3 border-b">Order Now</a>
        </div>
    </div>

    <!-- HERO -->
    <section class="hero-bg h-screen flex items-center text-white">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-5xl md:text-7xl font-bold leading-none mb-6 tracking-tighter">
                PROFESSIONAL CLEANING<br>IN VILNIUS
            </h1>
            <p class="text-2xl md:text-3xl mb-10 max-w-3xl mx-auto">Vilnius Cleaning is fast, high-quality and eco-friendly cleaning of apartments, offices and after renovation. We use professional vacuums, cloths, sponges, mops and eco products. 100% cleanliness guarantee. Fast service to all districts of Vilnius.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#order" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xl font-semibold px-10 py-6 rounded-3xl inline-flex items-center gap-3 transition shadow-xl">
                    <i class="fa-solid fa-broom"></i> Order Cleaning in Vilnius
                </a>
                <a href="tel:+37064474842" class="border-2 border-white hover:bg-white hover:text-gray-900 text-white text-xl font-semibold px-10 py-6 rounded-3xl inline-flex items-center gap-3 transition">
                    <i class="fa-solid fa-phone"></i> +370 644 74842
                </a>
				<a href="/kalkuliatorius.php" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xl font-semibold px-10 py-6 rounded-3xl inline-flex items-center gap-3 transition-all shadow-xl hover:shadow-2xl active:scale-95">
    <i class="fa-solid fa-broom"></i>Calculator
</a>
            </div>
            <div class="mt-16 text-sm uppercase tracking-widest">Vilnius • Every day 08:00-22:00 • 100% Cleanliness Guarantee</div>
        </div>
    </section>

    <!-- SERVICES -->
    <section id="services" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-emerald-100 text-emerald-700 px-5 py-2 rounded-full text-sm font-semibold">VILNIUS CLEANING SERVICES</span>
                <h2 class="text-5xl font-bold mt-4">Professional cleaning in Vilnius — all types of cleaning</h2>
                <p class="mt-6 max-w-3xl mx-auto text-xl text-gray-600">Vilnius Cleaning offers a full range of cleaning services in Vilnius: regular apartment cleaning, deep cleaning, post-renovation cleaning, daily office cleaning. We work only with professional equipment — vacuums, cloths, sponges, mops, eco products.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
                    <div class="h-56 bg-[url('https://picsum.photos/seed/deep-clean-apartment-vilnius-2026/600/400')] bg-cover service-img"></div>
                    <div class="p-8">
                        <h3 class="text-2xl font-semibold mb-3">Apartment Cleaning in Vilnius</h3>
                        <p class="text-gray-600">Regular, deep and comprehensive apartment cleaning in Vilnius. We thoroughly clean kitchens, bathrooms, living rooms, bedrooms, windows. Eco products and premium equipment. Perfect cleanliness you deserve.</p>
                        <div class="mt-6 text-emerald-600 font-medium">Vilnius Cleaning for your comfort</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
                    <div class="h-56 bg-[url('https://picsum.photos/seed/professional-office-cleaning-team-vilnius/600/400')] bg-cover service-img"></div>
                    <div class="p-8">
                        <h3 class="text-2xl font-semibold mb-3">Office Cleaning in Vilnius</h3>
                        <p class="text-gray-600">Daily, deep and post-renovation office cleaning in Vilnius. We keep business centers, coworking spaces and administrative premises clean. Professional cleaners with vacuums, mops and eco products.</p>
                        <div class="mt-6 text-emerald-600 font-medium">Professional cleaning for your business</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
                    <div class="h-56 bg-[url('https://picsum.photos/seed/post-renovation-cleaning-vilnius-2026/600/400')] bg-cover service-img"></div>
                    <div class="p-8">
                        <h3 class="text-2xl font-semibold mb-3">Post-Renovation Cleaning Vilnius</h3>
                        <p class="text-gray-600">Complete removal of construction dust, paint, putty and cement after renovation in Vilnius. We clean apartments, houses and new objects. After us — sterile cleanliness without a single speck of dust.</p>
                        <div class="mt-6 text-emerald-600 font-medium">Post-renovation cleaning Vilnius</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
                    <div class="h-56 bg-[url('https://picsum.photos/seed/general-house-cleaning-supplies-professional/600/400')] bg-cover service-img"></div>
                    <div class="p-8">
                        <h3 class="text-2xl font-semibold mb-3">Deep General Cleaning in Vilnius</h3>
                        <p class="text-gray-600">Thorough general cleaning of apartments, houses and cottages in Vilnius. We clean hard-to-reach places, wash windows, cabinets and appliances. Professional mops, sponges and eco products.</p>
                        <div class="mt-6 text-emerald-600 font-medium">General cleaning Vilnius</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ADVANTAGES -->
    <section id="advantages" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-emerald-100 text-emerald-700 px-5 py-2 rounded-full text-sm font-semibold">WHY CLIENTS CHOOSE US</span>
                <h2 class="text-5xl font-bold mt-4">Advantages of professional cleaning in Vilnius</h2>
                <p class="mt-6 max-w-2xl mx-auto text-xl text-gray-600">We don’t just clean — we create perfect cleanliness using eco products, professional vacuums, cloths and mops. Here’s why clients in Vilnius choose us.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">♻️</div>
                    <h3 class="text-2xl font-semibold mb-3">100% Eco Products</h3>
                    <p class="text-gray-600">Only safe for children, pets and the environment. No harsh chemicals — only natural formulas.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">⭐</div>
                    <h3 class="text-2xl font-semibold mb-3">Experienced Professionals</h3>
                    <p class="text-gray-600">Every cleaner has at least 3 years of experience. Regular training and quality control after every job.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">⏱️</div>
                    <h3 class="text-2xl font-semibold mb-3">Fast Arrival</h3>
                    <p class="text-gray-600">We arrive anywhere in Vilnius within 2-4 hours. Same-day cleaning possible.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">🔒</div>
                    <h3 class="text-2xl font-semibold mb-3">Fixed Price</h3>
                    <p class="text-gray-600">No hidden fees. After your call — exact price. Transparent and honest.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">🛡️</div>
                    <h3 class="text-2xl font-semibold mb-3">Quality Guarantee</h3>
                    <p class="text-gray-600">If anything is not perfect — we come back free of charge. 100% satisfaction.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">📍</div>
                    <h3 class="text-2xl font-semibold mb-3">All Districts of Vilnius</h3>
                    <p class="text-gray-600">We work everywhere: Old Town, Šeškinė, Lazdynai, Pašilaičiai, Žirmūnai, Antakalnis and all other districts.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW WE WORK -->
    <section id="how" class="py-24 bg-emerald-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-white px-6 py-2 rounded-full text-emerald-700 font-semibold">OUR CLEANING PROCESS</span>
                <h2 class="text-5xl font-bold mt-4">How we do professional cleaning in Vilnius</h2>
                <p class="mt-6 max-w-xl mx-auto text-gray-600">Simple and transparent: from request to perfect cleanliness. We use only professional equipment.</p>
            </div>
            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-4xl mb-6">1</div>
                    <h3 class="font-semibold text-xl">Request</h3>
                    <p class="mt-3 text-gray-600">Call or fill the form — we quickly confirm the time.</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-4xl mb-6">2</div>
                    <h3 class="font-semibold text-xl">Arrival</h3>
                    <p class="mt-3 text-gray-600">Our specialists arrive at a convenient time with all equipment and eco products.</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-4xl mb-6">3</div>
                    <h3 class="font-semibold text-xl">Cleaning</h3>
                    <p class="mt-3 text-gray-600">We perform full cleaning according to your wishes — from vacuuming to window washing.</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-4xl mb-6">4</div>
                    <h3 class="font-semibold text-xl">Quality Control</h3>
                    <p class="mt-3 text-gray-600">We check everything and hand over a perfectly clean space.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- GALLERY -->
    <section id="gallery" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-emerald-100 text-emerald-700 px-5 py-2 rounded-full text-sm font-semibold">OUR WORK GALLERY</span>
                <h2 class="text-5xl font-bold mt-4">Cleaning in Vilnius — before and after (real photos)</h2>
                <p class="mt-6 max-w-xl mx-auto text-gray-600">See how we turn ordinary apartments and offices into perfectly clean spaces.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <img src="https://picsum.photos/seed/sparkling-clean-kitchen-vilnius/600/400" alt="Sparkling clean kitchen Vilnius" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/office-mopping-cleaning-vilnius/600/400" alt="Office floor mopping Vilnius" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/cleaning-rags-sponges-professional/600/400" alt="Professional cleaning cloths and sponges" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/vacuuming-modern-apartment-vilnius/600/400" alt="Vacuuming modern apartment Vilnius" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/luxury-bathroom-cleaning-vilnius/600/400" alt="Luxury bathroom after cleaning Vilnius" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/professional-window-cleaning-vilnius/600/400" alt="Streak-free window cleaning Vilnius" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
            </div>
        </div>
    </section>

    <!-- REVIEWS -->
    <section id="reviews" class="py-24 bg-emerald-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <span class="text-emerald-600 font-semibold">REVIEWS FROM GOOGLE & FACEBOOK</span>
                    <h2 class="text-5xl font-bold">What clients say about Vilnius Cleaning</h2>
                </div>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white border border-gray-100 p-8 rounded-3xl">
                    <div class="flex text-yellow-400 mb-4">★★★★★</div>
                    <p class="italic">"Best apartment cleaning in Vilnius! Everything shines, pleasant smell, eco products — perfect. Thank you!"</p>
                    <div class="mt-8 flex items-center gap-4"><div class="w-12 h-12 bg-gray-200 rounded-full"></div><div><div class="font-semibold">Olena Kovalenko</div><div class="text-sm text-gray-500">Vilnius • 2 weeks ago</div></div></div>
                </div>
                <div class="bg-white border border-gray-100 p-8 rounded-3xl">
                    <div class="flex text-yellow-400 mb-4">★★★★★</div>
                    <p class="italic">"After renovation — ideal cleanliness. Removed all dust, the apartment sparkles! Highly recommend to everyone in Vilnius."</p>
                    <div class="mt-8 flex items-center gap-4"><div class="w-12 h-12 bg-gray-200 rounded-full"></div><div><div class="font-semibold">Andriy Shevchenko</div><div class="text-sm text-gray-500">Vilnius • 1 month ago</div></div></div>
                </div>
                <div class="bg-white border border-gray-100 p-8 rounded-3xl">
                    <div class="flex text-yellow-400 mb-4">★★★★★</div>
                    <p class="italic">"Regular office cleaning. Always highest level, vacuums, mops — real professionals!"</p>
                    <div class="mt-8 flex items-center gap-4"><div class="w-12 h-12 bg-gray-200 rounded-full"></div><div><div class="font-semibold">Company „Litva Tech“</div><div class="text-sm text-gray-500">Vilnius • 3 weeks ago</div></div></div>
                </div>
            </div>
        </div>
    </section>

    <!-- LONG SEO TEXT -->
    <section class="py-20 bg-white border-t border-b">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-8">Professional Cleaning in Vilnius — your reliable cleanliness partner</h2>
            <p class="text-lg text-gray-600 leading-relaxed mb-6">Vilnius Cleaning has been operating since 2023 and has become the favourite service for hundreds of families and companies. We specialise in apartment cleaning, office cleaning and post-renovation cleaning. Every job is a comprehensive approach: vacuuming, mopping floors, cleaning bathrooms with sponges, dusting with cloths, using only eco products. We clean in all districts of Vilnius. Our clients receive not just cleanliness, but a feeling of freshness and comfort.</p>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold">Frequently Asked Questions about cleaning in Vilnius</h2>
            </div>
            <div class="space-y-6">
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">How much does apartment cleaning in Vilnius cost?</summary>
                    <p class="mt-6 text-gray-600">Price depends on area, type of cleaning and condition. Regular cleaning from 8 €/hour, deep cleaning from 12 €/hour, post-renovation from 15 €/hour. We always give exact fixed price after details.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Do you use ecological cleaning products?</summary>
                    <p class="mt-6 text-gray-600">Yes! All products are 100% eco, safe for children, pets and the environment.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Which districts of Vilnius do you serve?</summary>
                    <p class="mt-6 text-gray-600">We work in all districts: Old Town, Šeškinė, Fabrikas, Lazdynai, Pašilaičiai, Žirmūnai, Antakalnis, Naujamiestis and others. Fast arrival everywhere.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">How long does cleaning take?</summary>
                    <p class="mt-6 text-gray-600">Regular apartment cleaning 50-70 m² — 2-3 hours. Deep cleaning — 4-6 hours. Post-renovation — 5-8 hours.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Can I order cleaning for today?</summary>
                    <p class="mt-6 text-gray-600">Yes! If we have free cleaners — we come the same day. Call +370 644 74842.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Do you do post-renovation cleaning?</summary>
                    <p class="mt-6 text-gray-600">Yes, this is one of our main services. Complete removal of construction dust and debris — your apartment will shine like new.</p>
                </details>
            </div>
        </div>
    </section>
<!-- ==================== ORDER FORM WITH reCAPTCHA v2 ==================== -->
<section id="order" class="py-24 bg-gradient-to-br from-emerald-700 to-teal-800 text-white">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-5xl font-bold">Order Cleaning in Vilnius Right Now</h2>
            <p class="mt-4 text-xl opacity-90">We reply within 15 minutes • Fixed price • All districts of Vilnius</p>
        </div>

        <?php if ($success): ?>
            <div class="bg-emerald-500 text-white p-10 rounded-3xl text-center mb-8 shadow-2xl">
                <i class="fa-solid fa-circle-check text-7xl mb-6"></i>
                <h3 class="text-4xl font-bold">Thank you!</h3>
                <p class="text-2xl mt-4">Your request for professional cleaning in Vilnius has been received.<br>We will contact you very soon.</p>
                <div class="mt-8 text-xl opacity-90">Our team is already preparing for your perfect cleanliness ✨</div>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="bg-red-600 text-white p-6 rounded-3xl text-center mb-8"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form id="order-form" method="POST" action="submit.php" class="grid md:grid-cols-2 gap-8">
            <div>
                <label class="block text-sm mb-2">Your Name</label>
                <input type="text" name="name" required class="w-full px-6 py-5 rounded-3xl bg-white/10 border border-white/30 focus:border-white outline-none text-white placeholder-white/60">
            </div>
            <div>
                <label class="block text-sm mb-2">Phone Number</label>
                <input type="tel" name="phone" required class="w-full px-6 py-5 rounded-3xl bg-white/10 border border-white/30 focus:border-white outline-none text-white placeholder-white/60">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-2">Address in Vilnius and additional wishes</label>
                <textarea name="message" rows="5" class="w-full px-6 py-5 rounded-3xl bg-white/10 border border-white/30 focus:border-white outline-none text-white placeholder-white/60"></textarea>
            </div>

            <!-- reCAPTCHA v2 -->
            <?php renderRecaptcha(); ?>

            <div class="md:col-span-2 text-center">
                <button type="submit" 
                        class="bg-white text-emerald-700 hover:bg-emerald-100 font-bold text-xl px-16 py-7 rounded-3xl inline-flex items-center gap-4 transition shadow-2xl">
                    <i class="fa-solid fa-paper-plane"></i> SEND CLEANING REQUEST
                </button>
            </div>
        </form>
    </div>
</section>

    <!-- CONTACTS BAR -->
    <div class="bg-white py-8 border-t border-b">
        <div class="max-w-7xl mx-auto px-6 flex flex-wrap justify-center gap-x-12 gap-y-6 text-lg">
            <a href="tel:+37064474842" class="flex items-center gap-3 hover:text-emerald-600 transition"><i class="fa-solid fa-phone text-2xl"></i><span>+370 644 74842</span></a>
            <a href="https://wa.me/37064474842" target="_blank" class="flex items-center gap-3 hover:text-emerald-600 transition"><i class="fa-brands fa-whatsapp text-3xl"></i><span>WhatsApp</span></a>
            <a href="viber://chat?number=%2B37064474842" class="flex items-center gap-3 hover:text-emerald-600 transition"><i class="fa-brands fa-viber text-3xl"></i><span>Viber</span></a>
            <a href="https://t.me/+37064474842" target="_blank" class="flex items-center gap-3 hover:text-emerald-600 transition"><i class="fa-brands fa-telegram text-3xl"></i><span>Telegram</span></a>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-12">
            <div>
                <div class="flex items-center gap-3 text-3xl mb-6">
                    <i class="fa-solid fa-broom text-emerald-500"></i>
                    <span class="font-bold">Vilnius Cleaning</span>
                </div>
                <p class="text-gray-400">Professional cleaning in Vilnius since 2023. Highest quality with eco products and professional equipment.</p>
            </div>
            <div>
                <div class="font-semibold mb-4 text-emerald-400">CONTACTS</div>
                <div class="space-y-3 text-gray-300">
                    <div><i class="fa-solid fa-location-dot"></i> Kalvarijų g. 100, Vilnius</div>
                    <a href="tel:+37064474842" class="block hover:text-white">+370 644 74842</a>
                    <a href="mailto:rbilohash@gmail.com" class="block hover:text-white">Rbilohash@gmail.com</a>
                </div>
            </div>
            <div>
                <div class="font-semibold mb-4 text-emerald-400">WE CLEAN IN DISTRICTS</div>
                <div class="text-gray-400 leading-relaxed">
                    Old Town • Šeškinė • Fabrikas • Lazdynai • Pašilaičiai • Žirmūnai • Antakalnis • Naujamiestis and all other districts of Vilnius
                </div>
            </div>
        </div>
        <div class="mt-16 pt-8 border-t border-gray-800 text-center text-sm text-gray-500">
            <p>Made with ❤️ <a href="https://bilohash.com" target="_blank" class="hover:text-white">Ruslan Bilohash</a></p>
            <p class="mt-2">
                <a href="https://github.com/Ruslan-Bilohash" target="_blank" class="hover:text-white flex items-center justify-center gap-2">
                    <i class="fa-brands fa-github"></i> GitHub
                </a>
            </p>
            <p class="mt-6">© 2026 Vilnius Cleaning. All rights reserved.</p>
        </div>
    </footer>

    <!-- SCHEMA.ORG -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "Vilnius Cleaning",
      "description": "Professional cleaning in Vilnius – apartments, offices, post-renovation and deep cleaning with eco products and professional equipment",
      "url": "https://bilohash.com/en.php",
      "telephone": "+37064474842",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Kalvarijų g. 100",
        "addressLocality": "Vilnius",
        "addressCountry": "LT"
      },
      "openingHours": "Mo-Su 08:00-22:00",
      "priceRange": "$$",
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.98",
        "reviewCount": "142"
      },
      "image": "https://picsum.photos/seed/professional-cleaning-vilnius-hero-2026/1200/630"
    }
    </script>

    <script>
        function toggleLang() { document.getElementById('langDropdown').classList.toggle('hidden'); }
        function toggleMobileMenu() { document.getElementById('mobileMenu').classList.toggle('hidden'); }
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.relative')) document.getElementById('langDropdown').classList.add('hidden');
        });
    </script>
<script src="/chat-widget.js" defer></script>
<script>
// Захист форми від відправки без reCAPTCHA
document.getElementById('order-form').addEventListener('submit', function(e) {
    const recaptchaResponse = document.querySelector('.g-recaptcha-response');
    
    if (!recaptchaResponse || recaptchaResponse.value.trim() === '') {
        e.preventDefault();
        alert('Будь ласка, підтвердіть, що ви не робот (поставте галочку "I\'m not a robot").');
    }
});
</script>
</body>
</html>
