<?php
require_once __DIR__ . '/traffic_logger.php';
// Підключаємо reCAPTCHA v2
require_once __DIR__ . '/recaptcha.php';
// ====================== no.php ======================
// ПОВНІСТЬЮ ГОТОВИЙ сайт Rengjøring Vilnius (норвезькою)
// Максимальний SEO 2026 + дуже гарне повідомлення після замовлення
// Автор: Ruslan Bilohash | bilohash.com | github.com/Ruslan-Bilohash

$success = isset($_GET['success']) && $_GET['success'] == 1;
$error = isset($_GET['error']) && $_GET['error'] == 1 ? "Feil ved sending av forespørsel. Prøv igjen eller skriv til oss i messenger." : "";
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO META -->
    <title>Profesjonell rengjøring i Vilnius | Rengjøring Vilnius | Leiligheter, kontorer og etter renovering</title>
    <meta name="description" content="Profesjonell rengjøring i Vilnius ✓ Leiligheter, kontorer, etter renovering og grundig rengjøring ✓ Miljøvennlige midler, profesjonelle støvsugere, kluter og mopper ✓ Rask utrykning til alle bydeler i Vilnius ✓ 100% renhetsgaranti ✓ Fast pris ✓ Tlf: +370 644 74842">
    <meta name="keywords" content="rengjøring Vilnius, Vilnius rengjøring, leilighetsrengjøring Vilnius, kontorrengjøring Vilnius, rengjøring etter renovering Vilnius, grundig rengjøring Vilnius, eco cleaning Vilnius">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="author" content="Ruslan Bilohash">
    <meta name="theme-color" content="#10b981">
    <link rel="canonical" href="https://bilohash.com/no.php">

    <!-- OPEN GRAPH -->
    <meta property="og:title" content="Profesjonell rengjøring i Vilnius | Leiligheter, kontorer og etter renovering">
    <meta property="og:description" content="Rask og profesjonell rengjøring i Vilnius. Miljøvennlige midler, kvalitetsgaranti, rask respons. +370 644 74842">
    <meta property="og:image" content="https://picsum.photos/seed/professional-cleaning-vilnius-hero-2026/1200/630">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:url" content="https://bilohash.com/no.php">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="nb_NO">
    <meta property="og:site_name" content="Rengjøring Vilnius">

    <!-- TWITTER CARDS -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Profesjonell rengjøring i Vilnius | Leiligheter, kontorer og etter renovering">
    <meta name="twitter:description" content="Profesjonell rengjøring i Vilnius ✓ Leiligheter • Kontorer • Etter renovering • Miljøvennlige midler • +370 644 74842">
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
                    <span class="text-3xl font-bold tracking-tight">RENGJØRING VILNIUS</span>
                </div>
            </div>
            <nav class="hidden md:flex items-center gap-8 text-lg font-medium">
                <a href="#services" class="hover:text-emerald-600 transition">Tjenester</a>
                <a href="#advantages" class="hover:text-emerald-600 transition">Hvorfor oss</a>
                <a href="#how" class="hover:text-emerald-600 transition">Slik jobber vi</a>
                <a href="#gallery" class="hover:text-emerald-600 transition">Galleri</a>
                <a href="#reviews" class="hover:text-emerald-600 transition">Anmeldelser</a>
                <a href="#faq" class="hover:text-emerald-600 transition">FAQ</a>
                <a href="#order" class="hover:text-emerald-600 transition">Bestill</a>
            </nav>
            <div class="relative group">
                <button onclick="toggleLang()" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-2xl transition">
                    <span class="flag">🇳🇴</span>
                    <span class="font-semibold">NO</span>
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </button>
                <div id="langDropdown" class="hidden group-hover:block absolute right-0 mt-3 bg-white shadow-2xl rounded-3xl py-4 w-52 z-50 border border-gray-100">
                    <a href="index.php" class="flex items-center gap-4 px-6 py-3 hover:bg-emerald-50 transition"><span class="flag">🇱🇹</span><span>Lietuvių</span></a>
                    <a href="no.php" class="flex items-center gap-4 px-6 py-3 bg-emerald-50 text-emerald-700"><span class="flag">🇳🇴</span><span>Norsk</span></a>
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
            <a href="#services" onclick="toggleMobileMenu()" class="py-3 border-b">Tjenester</a>
            <a href="#advantages" onclick="toggleMobileMenu()" class="py-3 border-b">Hvorfor oss</a>
            <a href="#how" onclick="toggleMobileMenu()" class="py-3 border-b">Slik jobber vi</a>
            <a href="#gallery" onclick="toggleMobileMenu()" class="py-3 border-b">Galleri</a>
            <a href="#reviews" onclick="toggleMobileMenu()" class="py-3 border-b">Anmeldelser</a>
            <a href="#faq" onclick="toggleMobileMenu()" class="py-3 border-b">FAQ</a>
            <a href="#order" onclick="toggleMobileMenu()" class="py-3 border-b">Bestill</a>
        </div>
    </div>

    <!-- HERO -->
    <section class="hero-bg h-screen flex items-center text-white">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-5xl md:text-7xl font-bold leading-none mb-6 tracking-tighter">
                PROFESJONELL RENGJØRING<br>I VILNIUS
            </h1>
            <p class="text-2xl md:text-3xl mb-10 max-w-3xl mx-auto">Rengjøring Vilnius er rask, høy kvalitet og miljøvennlig rengjøring av leiligheter, kontorer og etter renovering i Vilnius. Vi bruker profesjonelle støvsugere, kluter, svamper, mopper og miljøvennlige midler. 100% renhetsgaranti. Rask utrykning til alle bydeler i Vilnius.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#order" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xl font-semibold px-10 py-6 rounded-3xl inline-flex items-center gap-3 transition shadow-xl">
                    <i class="fa-solid fa-broom"></i> Bestill rengjøring i Vilnius
                </a>
                <a href="tel:+37064474842" class="border-2 border-white hover:bg-white hover:text-gray-900 text-white text-xl font-semibold px-10 py-6 rounded-3xl inline-flex items-center gap-3 transition">
                    <i class="fa-solid fa-phone"></i> +370 644 74842
                </a>
				<a href="/kalkuliatorius.php" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xl font-semibold px-10 py-6 rounded-3xl inline-flex items-center gap-3 transition-all shadow-xl hover:shadow-2xl active:scale-95">
    <i class="fa-solid fa-broom"></i>Kalkulator
</a>
            </div>
            <div class="mt-16 text-sm uppercase tracking-widest">Vilnius • Hver dag 08:00-22:00 • 100% renhetsgaranti</div>
        </div>
    </section>

    <!-- SERVICES -->
    <section id="services" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-emerald-100 text-emerald-700 px-5 py-2 rounded-full text-sm font-semibold">TJENESTER RENGJØRING VILNIUS</span>
                <h2 class="text-5xl font-bold mt-4">Profesjonell rengjøring i Vilnius — alle typer</h2>
                <p class="mt-6 max-w-3xl mx-auto text-xl text-gray-600">Rengjøring Vilnius tilbyr full pakke med rengjøringstjenester i Vilnius: vanlig leilighetsrengjøring, grundig rengjøring, rengjøring etter renovering, daglig kontorrengjøring. Vi bruker kun profesjonelt utstyr.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
                    <div class="h-56 bg-[url('https://picsum.photos/seed/deep-clean-apartment-vilnius-2026/600/400')] bg-cover service-img"></div>
                    <div class="p-8">
                        <h3 class="text-2xl font-semibold mb-3">Leilighetsrengjøring i Vilnius</h3>
                        <p class="text-gray-600">Vanlig, grundig og kompleks leilighetsrengjøring i Vilnius. Vi vasker kjøkken, bad, stuer, soverom og vinduer med miljøvennlige midler.</p>
                        <div class="mt-6 text-emerald-600 font-medium">Rengjøring Vilnius for din komfort</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
                    <div class="h-56 bg-[url('https://picsum.photos/seed/professional-office-cleaning-team-vilnius/600/400')] bg-cover service-img"></div>
                    <div class="p-8">
                        <h3 class="text-2xl font-semibold mb-3">Kontorrengjøring i Vilnius</h3>
                        <p class="text-gray-600">Daglig, grundig og etter-renovering rengjøring av kontorer i Vilnius. Vi holder business-sentre og coworking-plasser rene.</p>
                        <div class="mt-6 text-emerald-600 font-medium">Profesjonell rengjøring for din bedrift</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
                    <div class="h-56 bg-[url('https://picsum.photos/seed/post-renovation-cleaning-vilnius-2026/600/400')] bg-cover service-img"></div>
                    <div class="p-8">
                        <h3 class="text-2xl font-semibold mb-3">Rengjøring etter renovering Vilnius</h3>
                        <p class="text-gray-600">Fullstendig fjerning av byggestøv, maling og sparkel etter renovering i Vilnius. Etter oss — steril renhet uten en eneste støvpartikkel.</p>
                        <div class="mt-6 text-emerald-600 font-medium">Rengjøring etter renovering Vilnius</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
                    <div class="h-56 bg-[url('https://picsum.photos/seed/general-house-cleaning-supplies-professional/600/400')] bg-cover service-img"></div>
                    <div class="p-8">
                        <h3 class="text-2xl font-semibold mb-3">Grundig rengjøring i Vilnius</h3>
                        <p class="text-gray-600">Dyp grundig rengjøring av leiligheter, hus og hytter i Vilnius. Vi vasker vanskelig tilgjengelige steder, vinduer, skap og apparater.</p>
                        <div class="mt-6 text-emerald-600 font-medium">Grundig rengjøring Vilnius</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ADVANTAGES -->
    <section id="advantages" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-emerald-100 text-emerald-700 px-5 py-2 rounded-full text-sm font-semibold">HVORFOR VELGER KUNDER OSS</span>
                <h2 class="text-5xl font-bold mt-4">Fordeler med profesjonell rengjøring i Vilnius</h2>
                <p class="mt-6 max-w-2xl mx-auto text-xl text-gray-600">Vi gjør ikke bare rent — vi skaper perfekt renhet med miljøvennlige midler, profesjonelle støvsugere, kluter og mopper.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">♻️</div>
                    <h3 class="text-2xl font-semibold mb-3">100% miljøvennlige midler</h3>
                    <p class="text-gray-600">Sikre for barn, dyr og miljø. Ingen sterk kjemi — bare naturlige formler.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">⭐</div>
                    <h3 class="text-2xl font-semibold mb-3">Erfarne fagfolk</h3>
                    <p class="text-gray-600">Hver renholder har minst 3 års erfaring. Regelmessig opplæring og kvalitetskontroll.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">⏱️</div>
                    <h3 class="text-2xl font-semibold mb-3">Rask utrykning</h3>
                    <p class="text-gray-600">Vi kommer til alle bydeler i Vilnius innen 2-4 timer. Samme-dag rengjøring mulig.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">🔒</div>
                    <h3 class="text-2xl font-semibold mb-3">Fast pris</h3>
                    <p class="text-gray-600">Ingen skjulte avgifter. Etter samtalen — eksakt pris.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">🛡️</div>
                    <h3 class="text-2xl font-semibold mb-3">Kvalitetsgaranti</h3>
                    <p class="text-gray-600">Hvis noe ikke er perfekt — kommer vi gratis igjen. 100% fornøyde kunder.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">📍</div>
                    <h3 class="text-2xl font-semibold mb-3">Alle bydeler i Vilnius</h3>
                    <p class="text-gray-600">Vi jobber overalt: Gamlebyen, Šeškinė, Lazdynai, Pašilaičiai, Žirmūnai, Antakalnis og alle andre områder.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW WE WORK -->
    <section id="how" class="py-24 bg-emerald-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-white px-6 py-2 rounded-full text-emerald-700 font-semibold">RENGJØRINGSPROSESSEN</span>
                <h2 class="text-5xl font-bold mt-4">Slik utfører vi profesjonell rengjøring i Vilnius</h2>
                <p class="mt-6 max-w-xl mx-auto text-gray-600">Enkel og transparent prosess: fra forespørsel til perfekt renhet.</p>
            </div>
            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-4xl mb-6">1</div>
                    <h3 class="font-semibold text-xl">Forespørsel</h3>
                    <p class="mt-3 text-gray-600">Ring eller fyll ut skjemaet — vi bekrefter tid raskt.</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-4xl mb-6">2</div>
                    <h3 class="font-semibold text-xl">Ankomst</h3>
                    <p class="mt-3 text-gray-600">Våre spesialister kommer til passende tid med alt utstyr.</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-4xl mb-6">3</div>
                    <h3 class="font-semibold text-xl">Rengjøring</h3>
                    <p class="mt-3 text-gray-600">Vi utfører full rengjøring etter dine ønsker — fra støvsuging til vindusvask.</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-4xl mb-6">4</div>
                    <h3 class="font-semibold text-xl">Kvalitetskontroll</h3>
                    <p class="mt-3 text-gray-600">Vi sjekker alt og overleverer et perfekt rent objekt.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- GALLERY -->
    <section id="gallery" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-emerald-100 text-emerald-700 px-5 py-2 rounded-full text-sm font-semibold">VÅRT ARBEIDSGALLERI</span>
                <h2 class="text-5xl font-bold mt-4">Rengjøring i Vilnius — før og etter (ekte bilder)</h2>
                <p class="mt-6 max-w-xl mx-auto text-gray-600">Se hvordan vi forvandler vanlige leiligheter og kontorer til perfekt rene rom.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <img src="https://picsum.photos/seed/sparkling-clean-kitchen-vilnius/600/400" alt="Gnistrende ren kjøkken Vilnius" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/office-mopping-cleaning-vilnius/600/400" alt="Gulvvask på kontor Vilnius" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/cleaning-rags-sponges-professional/600/400" alt="Profesjonelle kluter og svamper" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/vacuuming-modern-apartment-vilnius/600/400" alt="Støvsuging i moderne leilighet Vilnius" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/luxury-bathroom-cleaning-vilnius/600/400" alt="Luksusbad etter rengjøring Vilnius" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/professional-window-cleaning-vilnius/600/400" alt="Vindusvask uten striper Vilnius" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
            </div>
        </div>
    </section>

    <!-- REVIEWS -->
    <section id="reviews" class="py-24 bg-emerald-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <span class="text-emerald-600 font-semibold">ANMELDELSER FRA GOOGLE OG FACEBOOK</span>
                    <h2 class="text-5xl font-bold">Hva kundene sier om Rengjøring Vilnius</h2>
                </div>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white border border-gray-100 p-8 rounded-3xl">
                    <div class="flex text-yellow-400 mb-4">★★★★★</div>
                    <p class="italic">"Beste leilighetsrengjøring i Vilnius! Alt skinner, behagelig lukt, miljøvennlige midler — perfekt. Takk til teamet!"</p>
                    <div class="mt-8 flex items-center gap-4"><div class="w-12 h-12 bg-gray-200 rounded-full"></div><div><div class="font-semibold">Olena Kovalenko</div><div class="text-sm text-gray-500">Vilnius • 2 uker siden</div></div></div>
                </div>
                <div class="bg-white border border-gray-100 p-8 rounded-3xl">
                    <div class="flex text-yellow-400 mb-4">★★★★★</div>
                    <p class="italic">"Etter renovering — perfekt renhet. Fjernet all støv, leiligheten skinner! Anbefaler alle i Vilnius."</p>
                    <div class="mt-8 flex items-center gap-4"><div class="w-12 h-12 bg-gray-200 rounded-full"></div><div><div class="font-semibold">Andriy Shevchenko</div><div class="text-sm text-gray-500">Vilnius • 1 måned siden</div></div></div>
                </div>
                <div class="bg-white border border-gray-100 p-8 rounded-3xl">
                    <div class="flex text-yellow-400 mb-4">★★★★★</div>
                    <p class="italic">"Regelmessig kontorrengjøring. Alltid på høyeste nivå, støvsugere, mopper — ekte profesjonelle!"</p>
                    <div class="mt-8 flex items-center gap-4"><div class="w-12 h-12 bg-gray-200 rounded-full"></div><div><div class="font-semibold">Selskap „Litva Tech“</div><div class="text-sm text-gray-500">Vilnius • 3 uker siden</div></div></div>
                </div>
            </div>
        </div>
    </section>

    <!-- LONG SEO TEXT -->
    <section class="py-20 bg-white border-t border-b">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-8">Profesjonell rengjøring i Vilnius — din pålitelige renhetspartner</h2>
            <p class="text-lg text-gray-600 leading-relaxed mb-6">Rengjøring Vilnius har operert siden 2023 og har blitt den foretrukne tjenesten for hundrevis av familier og bedrifter. Vi spesialiserer oss på leilighetsrengjøring, kontorrengjøring og rengjøring etter renovering. Hver jobb er en helhetlig tilnærming med miljøvennlige midler. Vi renser i alle bydeler i Vilnius.</p>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold">Ofte stilte spørsmål om rengjøring i Vilnius</h2>
            </div>
            <div class="space-y-6">
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Hvor mye koster leilighetsrengjøring i Vilnius?</summary>
                    <p class="mt-6 text-gray-600">Prisen avhenger av areal, type rengjøring og tilstand. Vanlig fra 8 €/time, grundig fra 12 €/time, etter renovering fra 15 €/time. Vi gir alltid eksakt fast pris etter detaljer.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Bruker dere miljøvennlige midler?</summary>
                    <p class="mt-6 text-gray-600">Ja! Alle midler er 100% miljøvennlige, trygge for barn, dyr og miljøet.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Hvilke bydeler i Vilnius dekker dere?</summary>
                    <p class="mt-6 text-gray-600">Vi renser i alle bydeler: Gamlebyen, Šeškinė, Fabrikas, Lazdynai, Pašilaičiai, Žirmūnai, Antakalnis, Naujamiestis og andre. Rask utrykning over hele byen.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Hvor lang tid tar rengjøringen?</summary>
                    <p class="mt-6 text-gray-600">Vanlig leilighetsrengjøring 50-70 m² — 2-3 timer. Grundig — 4-6 timer. Etter renovering — 5-8 timer.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Kan jeg bestille rengjøring i dag?</summary>
                    <p class="mt-6 text-gray-600">Ja! Hvis vi har ledige renholdere — kjører vi samme dag. Ring +370 644 74842.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Gjør dere rengjøring etter renovering?</summary>
                    <p class="mt-6 text-gray-600">Ja, det er en av våre hovedtjenester. Fullstendig fjerning av byggestøv — etter oss skinner leiligheten som ny.</p>
                </details>
            </div>
        </div>
    </section>

    <!-- ==================== ORDER FORM WITH reCAPTCHA v2 ==================== -->
    <section id="order" class="py-24 bg-gradient-to-br from-emerald-700 to-teal-800 text-white">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-5xl font-bold">Bestill rengjøring i Vilnius nå</h2>
                <p class="mt-4 text-xl opacity-90">Vi svarer innen 15 minutter • Fast pris • Alle bydeler i Vilnius</p>
            </div>

            <?php if ($success): ?>
                <div class="bg-emerald-500 text-white p-10 rounded-3xl text-center mb-8 shadow-2xl">
                    <i class="fa-solid fa-circle-check text-7xl mb-6"></i>
                    <h3 class="text-4xl font-bold">Takk!</h3>
                    <p class="text-2xl mt-4">Din forespørsel om profesjonell rengjøring i Vilnius er mottatt.<br>Vi kontakter deg svært snart for å bekrefte alle detaljer og avtale tidspunkt.</p>
                    <div class="mt-8 text-xl opacity-90">Vårt team forbereder allerede din perfekte renhet ✨</div>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="bg-red-600 text-white p-6 rounded-3xl text-center mb-8"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form id="order-form" method="POST" action="submit.php" class="grid md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm mb-2">Ditt navn</label>
                    <input type="text" name="name" required class="w-full px-6 py-5 rounded-3xl bg-white/10 border border-white/30 focus:border-white outline-none text-white placeholder-white/60">
                </div>
                <div>
                    <label class="block text-sm mb-2">Telefonnummer</label>
                    <input type="tel" name="phone" required class="w-full px-6 py-5 rounded-3xl bg-white/10 border border-white/30 focus:border-white outline-none text-white placeholder-white/60">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm mb-2">Adresse i Vilnius og ekstra ønsker (antall rom, type rengjøring)</label>
                    <textarea name="message" rows="5" class="w-full px-6 py-5 rounded-3xl bg-white/10 border border-white/30 focus:border-white outline-none text-white placeholder-white/60"></textarea>
                </div>

                <!-- reCAPTCHA v2 -->
                <?php renderRecaptcha(); ?>

                <div class="md:col-span-2 text-center">
                    <button type="submit" 
                            class="bg-white text-emerald-700 hover:bg-emerald-100 font-bold text-xl px-16 py-7 rounded-3xl inline-flex items-center gap-4 transition shadow-2xl">
                        <i class="fa-solid fa-paper-plane"></i> SEND FORESPOERSEL
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
                    <span class="font-bold">Rengjøring Vilnius</span>
                </div>
                <p class="text-gray-400">Profesjonell rengjøring i Vilnius siden 2023. Høyeste kvalitet med miljøvennlige midler og profesjonelt utstyr.</p>
            </div>
            <div>
                <div class="font-semibold mb-4 text-emerald-400">KONTAKT</div>
                <div class="space-y-3 text-gray-300">
                    <div><i class="fa-solid fa-location-dot"></i> Kalvarijų g. 100, Vilnius</div>
                    <a href="tel:+37064474842" class="block hover:text-white">+370 644 74842</a>
                    <a href="mailto:rbilohash@gmail.com" class="block hover:text-white">Rbilohash@gmail.com</a>
                </div>
            </div>
            <div>
                <div class="font-semibold mb-4 text-emerald-400">VI RENGJØR I BYDELENE</div>
                <div class="text-gray-400 leading-relaxed">
                    Gamlebyen • Šeškinė • Fabrikas • Lazdynai • Pašilaičiai • Žirmūnai • Antakalnis • Naujamiestis og alle andre bydeler i Vilnius
                </div>
            </div>
        </div>
        <div class="mt-16 pt-8 border-t border-gray-800 text-center text-sm text-gray-500">
            <p>Laget med ❤️ <a href="https://bilohash.com" target="_blank" class="hover:text-white">Ruslan Bilohash</a></p>
            <p class="mt-2">
                <a href="https://github.com/Ruslan-Bilohash" target="_blank" class="hover:text-white flex items-center justify-center gap-2">
                    <i class="fa-brands fa-github"></i> GitHub
                </a>
            </p>
            <p class="mt-6">© 2026 Rengjøring Vilnius. Alle rettigheter reservert.</p>
        </div>
    </footer>

    <!-- SCHEMA.ORG -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "Rengjøring Vilnius",
      "description": "Profesjonell rengjøring i Vilnius – leiligheter, kontorer, etter renovering med miljøvennlige midler",
      "url": "https://bilohash.com/no.php",
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
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- JavaScript захист (не дозволяє відправити без галочки) -->
    <script>
    document.getElementById('order-form').addEventListener('submit', function(e) {
        const response = document.querySelector('.g-recaptcha-response');
        if (!response || response.value.trim() === '') {
            e.preventDefault();
            alert('Vennligst bekreft at du ikke er en robot (merk av "Jeg er ikke en robot").');
        }
    });
    </script>
</body>
</html>
