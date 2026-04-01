<?php
require_once __DIR__ . '/traffic_logger.php';
// ====================== index.php ======================
// ПОВНІСТЬЮ ГОТОВИЙ сайт Meistru Valymas (литовською)
// професійне прибирання квартир, офісів, після ремонту, чисті кухні, вітальні, ванни, пилососи, ганчірки, мочалки, швабри, еко-засоби
// Максимальний SEO 2026 + дуже гарне повідомлення після замовлення
// Автор: Ruslan Bilohash | bilohash.com | github.com/Ruslan-Bilohash
// Копіюй ЦІЛКОМ і завантажуй разом із submit.php

$success = isset($_GET['success']) && $_GET['success'] == 1;
$error = isset($_GET['error']) && $_GET['error'] == 1 ? "Klaida siunčiant užklausą. Bandykite dar kartą arba parašykite mums per messenger." : "";
?>
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO 2026 (виправлено) -->
    <title>Meistru Valymas Vilnius | Profesionalus valymas su 30% nuolaida</title>
    <meta name="description" content="Profesionalus valymas Vilniuje ✓ Butų, biurų, po remonto ir generalinis valymas ✓ 30% nuolaida + fiksuota kaina ✓ Greitas išvykimas per 2 val. ✓ Ekologiškos priemonės ✓ +370 644 74842">
    <meta name="keywords" content="valymas Vilnius, meistru valymas, butų valymas Vilnius, biurų valymas, valymas po remonto Vilnius, 30% nuolaida valymas">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <link rel="canonical" href="https://meistru.lt/">

<!-- hreflang -->
<link rel="alternate" hreflang="lt" href="https://meistru.lt/" />
<link rel="alternate" hreflang="lt" href="https://meistru.lt/index.php" />
<link rel="alternate" hreflang="ru" href="https://meistru.lt/ru.php" />
<link rel="alternate" hreflang="uk" href="https://meistru.lt/ua.php" />
<link rel="alternate" hreflang="en" href="https://meistru.lt/en.php" />
<link rel="alternate" hreflang="no" href="https://meistru.lt/no.php" />
<link rel="alternate" hreflang="x-default" href="https://meistru.lt/" />
    <meta name="author" content="Meistru Valymas">
    <meta name="theme-color" content="#10b981">

    <!-- OPEN GRAPH (виправлено) -->
    <meta property="og:title" content="Meistru Valymas Vilnius | Profesionalus valymas su 30% nuolaida">
    <meta property="og:description" content="Greitas ir kokybiškas valymas Vilniuje su 30% nuolaida. Butai, biurai, po remonto. Fiksuota kaina ir 100% garantija. +370 644 74842">
    <meta property="og:image" content="https://picsum.photos/seed/professional-cleaning-vilnius-hero-2026/1200/630">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:url" content="https://meistru.lt/">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="lt_LT">
    <meta property="og:site_name" content="Meistru Valymas">

    <!-- TWITTER CARDS -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Meistru Valymas Vilnius">
    <meta name="twitter:description" content="30% nuolaida dabar! Profesionalus valymas Vilniuje. Butai • Biurai • Po remonto • +370 644 74842">
    <meta name="twitter:image" content="https://picsum.photos/seed/professional-cleaning-vilnius-hero-2026/1200/630">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Playfair+Display:wght@700&amp;display=swap" rel="stylesheet">
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
                    <span class="text-3xl font-bold tracking-tight">MEISTRU VALYMAS</span>
                </div>
            </div>
            <nav class="hidden md:flex items-center gap-8 text-lg font-medium">
                <a href="#services" class="hover:text-emerald-600 transition">Paslaugos</a>
                <a href="#advantages" class="hover:text-emerald-600 transition">Kodėl mes</a>
                <a href="#how" class="hover:text-emerald-600 transition">Kaip dirbame</a>
                <a href="#gallery" class="hover:text-emerald-600 transition">Galerija</a>
                <a href="#reviews" class="hover:text-emerald-600 transition">Atsiliepimai</a>
                <a href="#faq" class="hover:text-emerald-600 transition">DUK</a>
                <a href="#order" class="hover:text-emerald-600 transition">Užsakyti</a>
            </nav>
            <div class="relative group">
                <button onclick="toggleLang()" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-2xl transition">
                    <span class="flag">🇱🇹</span>
                    <span class="font-semibold">LT</span>
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </button>
                <div id="langDropdown" class="hidden group-hover:block absolute right-0 mt-3 bg-white shadow-2xl rounded-3xl py-4 w-52 z-50 border border-gray-100">
                    <a href="index.php" class="flex items-center gap-4 px-6 py-3 bg-emerald-50 text-emerald-700"><span class="flag">🇱🇹</span><span>Lietuvių</span></a>
                    <a href="no.php" class="flex items-center gap-4 px-6 py-3 hover:bg-emerald-50 transition"><span class="flag">🇳🇴</span><span>Norsk</span></a>
                    <a href="en.php" class="flex items-center gap-4 px-6 py-3 hover:bg-emerald-50 transition"><span class="flag">🇬🇧</span><span>English</span></a>
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
            <a href="#services" onclick="toggleMobileMenu()" class="py-3 border-b">Paslaugos</a>
            <a href="#advantages" onclick="toggleMobileMenu()" class="py-3 border-b">Kodėl mes</a>
            <a href="#how" onclick="toggleMobileMenu()" class="py-3 border-b">Kaip dirbame</a>
            <a href="#gallery" onclick="toggleMobileMenu()" class="py-3 border-b">Galerija</a>
            <a href="#reviews" onclick="toggleMobileMenu()" class="py-3 border-b">Atsiliepimai</a>
            <a href="#faq" onclick="toggleMobileMenu()" class="py-3 border-b">DUK</a>
            <a href="#order" onclick="toggleMobileMenu()" class="py-3 border-b">Užsakyti</a>
        </div>
    </div>

    <!-- HERO -->
    <section class="hero-bg h-screen flex items-center text-white">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-5xl md:text-7xl font-bold leading-none mb-6 tracking-tighter">
                PROFESIONALUS VALYMAS<br>VILNIUJE
            </h1>
            <p class="text-2xl md:text-3xl mb-10 max-w-3xl mx-auto">Vilniaus valymas – greitas, kokybiškas ir ekologiškas butų, biurų bei po remonto valymas Vilniuje. Naudojame profesionalius dulkių siurblius, šluostes, kempines, švabres ir ekologiškas priemones. 100% švaros garantija. Greitas išvykimas po visus Vilniaus rajonus.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#order" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xl font-semibold px-10 py-6 rounded-3xl inline-flex items-center gap-3 transition shadow-xl">
                    <i class="fa-solid fa-broom"></i> Užsakyti valymą Vilniuje
                </a>
                <a href="tel:+37064474842" class="border-2 border-white hover:bg-white hover:text-gray-900 text-white text-xl font-semibold px-10 py-6 rounded-3xl inline-flex items-center gap-3 transition">
                    <i class="fa-solid fa-phone"></i> +370 644 74842
                </a>
                <a href="kalkuliatorius.php" class="bg-white text-emerald-700 hover:bg-emerald-100 text-xl font-semibold px-10 py-6 rounded-3xl inline-flex items-center gap-3 transition shadow-xl">
                    <i class="fa-solid fa-calculator"></i> Apskaičiuoti kainą
                </a>
            </div>
            <div class="mt-16 text-sm uppercase tracking-widest">Vilnius • Kasdien 08:00-22:00 • 100% švaros garantija</div>
        </div>
    </section>

    <!-- SERVICES -->
    <section id="services" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-emerald-100 text-emerald-700 px-5 py-2 rounded-full text-sm font-semibold">VILNIAUS VALYMO PASLAUGOS</span>
                <h2 class="text-5xl font-bold mt-4">Profesionalus valymas Vilniuje – visos valymo rūšys</h2>
                <p class="mt-6 max-w-3xl mx-auto text-xl text-gray-600">Vilniaus valymas siūlo pilną valymo paslaugų spektrą Vilniuje: reguliarų butų valymą, giluminį valymą, valymą po remonto, kasdienį biurų valymą. Dirbame tik su profesionalia įranga – dulkių siurbliais, šluostėmis, kempinėmis, švabrėmis ir ekologiškomis priemonėmis.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
                    <div class="h-56 bg-[url('https://picsum.photos/seed/deep-clean-apartment-vilnius-2026/600/400')] bg-cover service-img"></div>
                    <div class="p-8">
                        <h3 class="text-2xl font-semibold mb-3">Butų valymas Vilniuje</h3>
                        <p class="text-gray-600">Reguliarus, gilus ir kompleksinis butų valymas Vilniuje. Kruopščiai valome virtuves, vonios kambarius, svetaines, miegamuosius, langus. Ekologiškos priemonės ir premium įranga.</p>
                        <div class="mt-6 text-emerald-600 font-medium">Vilniaus valymas jūsų komfortui</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
                    <div class="h-56 bg-[url('https://picsum.photos/seed/professional-office-cleaning-team-vilnius/600/400')] bg-cover service-img"></div>
                    <div class="p-8">
                        <h3 class="text-2xl font-semibold mb-3">Biurų valymas Vilniuje</h3>
                        <p class="text-gray-600">Kasdienis, gilus ir po remonto biurų valymas Vilniuje. Palaikome švarą verslo centruose, bendradarbystės erdvėse. Profesionalios valytojos su dulkių siurbliais і ekologiškomis priemonėmis.</p>
                        <div class="mt-6 text-emerald-600 font-medium">Profesionalus valymas jūsų verslui</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
                    <div class="h-56 bg-[url('https://picsum.photos/seed/post-renovation-cleaning-vilnius-2026/600/400')] bg-cover service-img"></div>
                    <div class="p-8">
                        <h3 class="text-2xl font-semibold mb-3">Valymas po remonto Vilniuje</h3>
                        <p class="text-gray-600">Visiškas statybinių dulkių, dažų, glaisto ir cemento pašalinimas po remonto Vilniuje. Valome butus, namus ir naujus objektus. Po mūsų – sterili švara be jokios dulkelės.</p>
                        <div class="mt-6 text-emerald-600 font-medium">Valymas po remonto Vilnius</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
                    <div class="h-56 bg-[url('https://picsum.photos/seed/general-house-cleaning-supplies-professional/600/400')] bg-cover service-img"></div>
                    <div class="p-8">
                        <h3 class="text-2xl font-semibold mb-3">Generalinis valymas Vilniuje</h3>
                        <p class="text-gray-600">Gilus generalinis butų, namų ir kotedžų valymas Vilniuje. Valome sunkiai prieinamas vietas, plauname langus, spintas, techniką. Profesionalios švabrės, kempinės ir ekologiškos priemonės.</p>
                        <div class="mt-6 text-emerald-600 font-medium">Generalinis valymas Vilnius</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ADVANTAGES -->
    <section id="advantages" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-emerald-100 text-emerald-700 px-5 py-2 rounded-full text-sm font-semibold">KODĖL KLIENTAI RENKASI MUS</span>
                <h2 class="text-5xl font-bold mt-4">Profesionalaus valymo Vilniuje privalumai</h2>
                <p class="mt-6 max-w-2xl mx-auto text-xl text-gray-600">Mes ne tik valome – mes sukuriame tobulą švarą naudodami ekologiškas priemones, profesionalius dulkių siurblius, šluostes ir švabres. Štai kodėl Vilniaus klientai renkasi mus.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">♻️</div>
                    <h3 class="text-2xl font-semibold mb-3">100% ekologiškos priemonės</h3>
                    <p class="text-gray-600">Saugios vaikams, gyvūnams ir aplinkai. Jokios chemijos – tik natūralios formulės.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">⭐</div>
                    <h3 class="text-2xl font-semibold mb-3">Patyrę specialistai</h3>
                    <p class="text-gray-600">Kiekviena valytoja turi mažiausiai 3 metų patirtį. Reguliarūs mokymai ir kokybės kontrolė po kiekvieno valymo.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">⏱️</div>
                    <h3 class="text-2xl font-semibold mb-3">Greitas išvykimas</h3>
                    <p class="text-gray-600">Atvykstame į bet kurį Vilniaus rajoną per 2-4 valandas. Galimas valymas tą pačią dieną.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">🔒</div>
                    <h3 class="text-2xl font-semibold mb-3">Fiksuota kaina</h3>
                    <p class="text-gray-600">Jokių paslėptų mokesčių. Po skambučio – tiksli kaina. Skaidru ir sąžininga.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">🛡️</div>
                    <h3 class="text-2xl font-semibold mb-3">Kokybės garantija</h3>
                    <p class="text-gray-600">Jei kažkas nepatiks – atvykstame pakartotinai nemokamai. 100% pasitenkinimas.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">📍</div>
                    <h3 class="text-2xl font-semibold mb-3">Visi Vilniaus rajonai</h3>
                    <p class="text-gray-600">Dirbame visame mieste: Senamiestis, Šeškinė, Lazdynai, Pašilaičiai, Žirmūnai, Antakalnis, Naujamiestis ir visi kiti rajonai.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW WE WORK -->
    <section id="how" class="py-24 bg-emerald-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-white px-6 py-2 rounded-full text-emerald-700 font-semibold">VALYMO PROCESAS</span>
                <h2 class="text-5xl font-bold mt-4">Kaip mes atliekame profesionalų valymą Vilniuje</h2>
                <p class="mt-6 max-w-xl mx-auto text-gray-600">Paprasta ir skaidri schema: nuo užklausos iki tobulos švaros. Naudojame tik profesionalią įrangą.</p>
            </div>
            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-4xl mb-6">1</div>
                    <h3 class="font-semibold text-xl">Užklausa</h3>
                    <p class="mt-3 text-gray-600">Paskambinkite arba užpildykite formą – greitai patvirtiname laiką.</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-4xl mb-6">2</div>
                    <h3 class="font-semibold text-xl">Atvykimas</h3>
                    <p class="mt-3 text-gray-600">Mūsų specialistai atvyksta patogiu jums laiku su visa įranga і ekologiškomis priemonėmis.</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-4xl mb-6">3</div>
                    <h3 class="font-semibold text-xl">Valymas</h3>
                    <p class="mt-3 text-gray-600">Atliekame pilną valymą pagal jūsų pageidavimus – nuo dulkių siurbimo iki langų plovimo.</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-4xl mb-6">4</div>
                    <h3 class="font-semibold text-xl">Kokybės kontrolė</h3>
                    <p class="mt-3 text-gray-600">Patikriname viską і perduodame tobulai švarų objektą.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- GALLERY -->
    <section id="gallery" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-emerald-100 text-emerald-700 px-5 py-2 rounded-full text-sm font-semibold">MŪSŲ DARBŲ GALERIJA</span>
                <h2 class="text-5xl font-bold mt-4">Valymas Vilniuje – prieš ir po (realios nuotraukos)</h2>
                <p class="mt-6 max-w-xl mx-auto text-gray-600">Žiūrėkite, kaip mes paverčiame įprastus butus ir biurus tobulai švariais.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <img src="https://picsum.photos/seed/sparkling-clean-kitchen-vilnius/600/400" alt="Žvilganti švari virtuvė Vilnius" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/office-mopping-cleaning-vilnius/600/400" alt="Biuro grindų valymas Vilnius" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/cleaning-rags-sponges-professional/600/400" alt="Profesionalios valymo šluostės і kempinės" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/vacuuming-modern-apartment-vilnius/600/400" alt="Dulkių siurbimas moderniame bute Vilnius" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/luxury-bathroom-cleaning-vilnius/600/400" alt="Praelegantiškas vonios kambario valymas Vilnius" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/professional-window-cleaning-vilnius/600/400" alt="Langų valymas be dryžių Vilnius" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
            </div>
        </div>
    </section>

    <!-- REVIEWS -->
    <section id="reviews" class="py-24 bg-emerald-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <span class="text-emerald-600 font-semibold">ATSAKYMAI IŠ GOOGLE IR FACEBOOK</span>
                    <h2 class="text-5xl font-bold">Ką sako klientai apie Meistru Valymą</h2>
                </div>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white border border-gray-100 p-8 rounded-3xl">
                    <div class="flex text-yellow-400 mb-4">★★★★★</div>
                    <p class="italic">"Geriausias butų valymas Vilniuje! Viskas blizga, malonus kvapas, ekologiškos priemonės – super. Ačiū komandai!"</p>
                    <div class="mt-8 flex items-center gap-4"><div class="w-12 h-12 bg-gray-200 rounded-full"></div><div><div class="font-semibold">Olena Kovalenko</div><div class="text-sm text-gray-500">Vilnius • prieš 2 savaites</div></div></div>
                </div>
                <div class="bg-white border border-gray-100 p-8 rounded-3xl">
                    <div class="flex text-yellow-400 mb-4">★★★★★</div>
                    <p class="italic">"Po remonto – ideali švara. Pašalino visus dulkes, butas spindi! Rekomenduoju visiems Vilniuje."</p>
                    <div class="mt-8 flex items-center gap-4"><div class="w-12 h-12 bg-gray-200 rounded-full"></div><div><div class="font-semibold">Andriy Shevchenko</div><div class="text-sm text-gray-500">Vilnius • prieš 1 mėnesį</div></div></div>
                </div>
                <div class="bg-white border border-gray-100 p-8 rounded-3xl">
                    <div class="flex text-yellow-400 mb-4">★★★★★</div>
                    <p class="italic">"Reguliarus biuro valymas. Visada aukščiausiu lygiu, dulkių siurbliai, švabrės – tikri profesionalai!"</p>
                    <div class="mt-8 flex items-center gap-4"><div class="w-12 h-12 bg-gray-200 rounded-full"></div><div><div class="font-semibold">UAB „Litva Tech“</div><div class="text-sm text-gray-500">Vilnius • prieš 3 savaites</div></div></div>
                </div>
            </div>
        </div>
    </section>

    <!-- LONG SEO TEXT -->
    <section class="py-20 bg-white border-t border-b">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-8">Profesionalus valymas Vilniuje – ваш patikimas švaros partneris</h2>
            <p class="text-lg text-gray-600 leading-relaxed mb-6">Meistru Valymas veikia nuo 2023 m. і tapo mėgstamiausia paslauga šimtams šeimų і įmonių. Specializuojamės butų, biurų ir po remonto valyme. Kiekvienas valymas – kompleksinis požiūris: dulkių siurbimas, grindų plovimas швabrėmis, vonios kambarių valymas kempinėmis, dulkių valymas šluostėmis, tik ekologiškos priemonės. Valome visuose Vilniaus rajonuose.</p>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold">Dažniausiai užduodami klausimai apie valymą Vilniuje</h2>
            </div>
            <div class="space-y-6">
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Kiek kainuoja buto valymas Vilniuje?</summary>
                    <p class="mt-6 text-gray-600">Kaina priklauso nuo ploto, valymo tipo ir būklės. Reguliarus valymas nuo 8 €/val., gilus – nuo 12 €/val., po remonto – nuo 15 €/val. Visada duodame tikslią fiksuotą kainą po detalių patikslinimo.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Ar naudojate ekologiškas valymo priemones?</summary>
                    <p class="mt-6 text-gray-600">Taip! Visos priemonės – 100% ekologiškos, saugios vaikams, gyvūnams ir aplinkai.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Kuriuose Vilniaus rajonuose dirbate?</summary>
                    <p class="mt-6 text-gray-600">Valome visuose rajonuose: Senamiestis, Šeškinė, Fabrikas, Lazdynai, Pašilaičiai, Žirmūnai, Antakalnis, Naujamiestis ir kiti. Greitas išvykimas visame mieste.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Kiek laiko užtrunka valymas?</summary>
                    <p class="mt-6 text-gray-600">Reguliarus 50-70 m² buto valymas – 2-3 val. Gilus – 4-6 val. Po remonto – 5-8 val.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Ar galima užsakyti valymą šiandien?</summary>
                    <p class="mt-6 text-gray-600">Taip! Jei turime laisvų specialistų – išvykstame tą pačią dieną. Skambinkite +370 644 74842.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Ar atliekate valymą po remonto?</summary>
                    <p class="mt-6 text-gray-600">Taip, tai vienas pagrindinių mūsų krypčių. Visiškas statybinių dulkių ir šiukšlių pašalinimas – po mūsų butas spindi kaip naujas.</p>
                </details>
            </div>
        </div>
    </section>

    <!-- ORDER FORM + BEAUTIFUL SUCCESS MESSAGE -->
    <section id="order" class="py-24 bg-gradient-to-br from-emerald-700 to-teal-800 text-white">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-5xl font-bold">Užsakyti valymą Vilniuje dabar</h2>
                <p class="mt-4 text-xl opacity-90">Atsakome per 15 minučių • Fiksuota kaina • Visas Vilniaus rajonus</p>
            </div>
            <?php if ($success): ?>
                <div class="bg-emerald-500 text-white p-10 rounded-3xl text-center mb-8 shadow-2xl">
                    <i class="fa-solid fa-circle-check text-7xl mb-6"></i>
                    <h3 class="text-4xl font-bold">Ačiū!</h3>
                    <p class="text-2xl mt-4">Jūsų užklausa dėl profesionalaus valymo Vilniuje gauta.<br>Netrukus su jumis susisieksime, patikslinsime visas detales ir suderinsime valymo laiką.</p>
                    <div class="mt-8 text-xl opacity-90">Mūsų komanda jau ruošiasi jūsų tobulai švarai ✨</div>
                </div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="bg-red-600 text-white p-6 rounded-3xl text-center mb-8"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST" action="submit.php" class="grid md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm mb-2">Jūsų vardas</label>
                    <input type="text" name="name" required class="w-full px-6 py-5 rounded-3xl bg-white/10 border border-white/30 focus:border-white outline-none text-white placeholder-white/60">
                </div>
                <div>
                    <label class="block text-sm mb-2">Telefono numeris</label>
                    <input type="tel" name="phone" required class="w-full px-6 py-5 rounded-3xl bg-white/10 border border-white/30 focus:border-white outline-none text-white placeholder-white/60">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm mb-2">Adresas Vilniuje ir papildomi pageidavimai (kambarių skaičius, valymo tipas)</label>
                    <textarea name="message" rows="5" class="w-full px-6 py-5 rounded-3xl bg-white/10 border border-white/30 focus:border-white outline-none text-white placeholder-white/60"></textarea>
                </div>
                <div class="md:col-span-2 text-center">
                    <button type="submit" class="bg-white text-emerald-700 hover:bg-emerald-100 font-bold text-xl px-16 py-7 rounded-3xl inline-flex items-center gap-4 transition shadow-2xl">
                        <i class="fa-solid fa-paper-plane"></i> SIŲSTI UŽKLAUSĄ
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
                    <span class="font-bold">MEISTRU VALYMAS</span>
                </div>
                <p class="text-gray-400">Profesionalus valymas Vilniuje nuo 2023 m. Aukščiausios kokybės paslaugos su ekologiškomis priemonėmis ir profesionalia įranga.</p>
            </div>
            <div>
                <div class="font-semibold mb-4 text-emerald-400">KONTAKTAI</div>
                <div class="space-y-3 text-gray-300">
                    <div><i class="fa-solid fa-location-dot"></i> Kalvarijų g. 100, Vilnius</div>
                    <a href="tel:+37064474842" class="block hover:text-white">+370 644 74842</a>
                    <a href="mailto:rbilohash@gmail.com" class="block hover:text-white">Rbilohash@gmail.com</a>
                </div>
            </div>
            <div>
                <div class="font-semibold mb-4 text-emerald-400">VALOME RAJONUOSE</div>
                <div class="text-gray-400 leading-relaxed">
                    Senamiestis • Šeškinė • Fabrikas • Lazdynai • Pašilaičiai • Žirmūnai • Antakalnis • Naujamiestis ir visi kiti Vilniaus rajonai
                </div>
            </div>
        </div>
        <div class="mt-16 pt-8 border-t border-gray-800 text-center text-sm text-gray-500">
            <p>Sukurta su ❤️ <a href="https://bilohash.com" target="_blank" class="hover:text-white">Ruslan Bilohash</a></p>
            <p class="mt-2">
                <a href="https://github.com/Ruslan-Bilohash" target="_blank" class="hover:text-white flex items-center justify-center gap-2">
                    <i class="fa-brands fa-github"></i> GitHub
                </a>
            </p>
            <p class="mt-6">© 2026 Meistru Valymas. Visos teisės saugomos.</p>
        </div>
    </footer>

    <!-- SCHEMA.ORG (виправлено) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "Meistru Valymas",
      "description": "Profesionalus valymas Vilniuje – butų, biurų, po remonto ir generalinis valymas su ekologiškomis priemonėmis і 30% nuolaida",
      "url": "https://meistru.lt/",
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
</body>
</html>
