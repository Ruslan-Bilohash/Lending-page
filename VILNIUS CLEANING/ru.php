<?php
// Підключаємо reCAPTCHA v2
require_once __DIR__ . '/recaptcha.php';
require_once __DIR__ . '/traffic_logger.php';
// ====================== ru.php ======================
// ПОВНИЙ РОСІЙСЬКИЙ ВАРІАНТ — Meistru Valymas
// Максимальний SEO 2026 + калькулятор + 30% знижка + таблиця цін
// Автор: Ruslan Bilohash

$success = isset($_GET['success']) && $_GET['success'] == 1;
$error = isset($_GET['error']) && $_GET['error'] == 1 ? "Ошибка отправки запроса. Попробуйте ещё раз или напишите нам в мессенджер." : "";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO 2026 -->
    <title>Meistru Valymas Vilnius | Профессиональная уборка со скидкой 30%</title>
    <meta name="description" content="Профессиональная уборка в Вильнюсе ✓ Квартир, офисов, после ремонта ✓ Скидка 30% + фиксированная цена ✓ Выезд за 2 часа ✓ Эко-средства ✓ +370 644 74842">
    <meta name="keywords" content="уборка Вильнюс, профессиональная уборка Вильнюс, уборка квартир Вильнюс, уборка после ремонта, генеральная уборка Вильнюс, meistru valymas">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <link rel="canonical" href="https://meistru.lt/ru.php">

    <!-- Open Graph -->
    <meta property="og:title" content="Meistru Valymas Vilnius — Профессиональная уборка со скидкой 30%">
    <meta property="og:description" content="Скидка 30% прямо сейчас! Уборка квартир, офисов, после ремонта в Вильнюсе. Фиксированная цена, выезд по всему городу.">
    <meta property="og:image" content="https://picsum.photos/seed/professional-cleaning-vilnius-hero-2026/1200/630">
    <meta property="og:url" content="https://meistru.lt/ru.php">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ru_RU">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Meistru Valymas Vilnius">
    <meta name="twitter:description" content="Профессиональная уборка в Вильнюсе со скидкой 30%">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Playfair+Display:wght@700&amp;display=swap" rel="stylesheet">
    <!-- reCAPTCHA v2 -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<style>
        .hero-bg { background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('https://picsum.photos/seed/professional-cleaning-vilnius-hero-2026/2000/1200') center/cover no-repeat; }
        .card-hover { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-15px) scale(1.03); box-shadow: 0 25px 50px -12px rgb(16 185 129 / 0.4); }
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
                <a href="#services" class="hover:text-emerald-600 transition">Услуги</a>
                <a href="#advantages" class="hover:text-emerald-600 transition">Почему мы</a>
                <a href="#how" class="hover:text-emerald-600 transition">Как работаем</a>
                <a href="#gallery" class="hover:text-emerald-600 transition">Галерея</a>
                <a href="#reviews" class="hover:text-emerald-600 transition">Отзывы</a>
                <a href="#faq" class="hover:text-emerald-600 transition">FAQ</a>
                <a href="#order" class="hover:text-emerald-600 transition">Заказать</a>
            </nav>
            <div class="relative group">
                <button onclick="toggleLang()" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-2xl transition">
                    <span class="flag">🇷🇺</span>
                    <span class="font-semibold">RU</span>
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </button>
                <div id="langDropdown" class="hidden group-hover:block absolute right-0 mt-3 bg-white shadow-2xl rounded-3xl py-4 w-52 z-50 border border-gray-100">
                    <a href="index.php" class="flex items-center gap-4 px-6 py-3 hover:bg-emerald-50"><span class="flag">🇱🇹</span><span>Lietuvių</span></a>
                    <a href="ru.php" class="flex items-center gap-4 px-6 py-3 bg-emerald-50 text-emerald-700"><span class="flag">🇷🇺</span><span>Русский</span></a>
                    <a href="ua.php" class="flex items-center gap-4 px-6 py-3 hover:bg-emerald-50"><span class="flag">🇺🇦</span><span>Українська</span></a>
                    <a href="en.php" class="flex items-center gap-4 px-6 py-3 hover:bg-emerald-50"><span class="flag">🇬🇧</span><span>English</span></a>
                    <a href="no.php" class="flex items-center gap-4 px-6 py-3 hover:bg-emerald-50"><span class="flag">🇳🇴</span><span>Norsk</span></a>
                </div>
            </div>
            <button onclick="toggleMobileMenu()" class="md:hidden text-3xl"><i class="fa-solid fa-bars"></i></button>
        </div>
    </header>

    <!-- MOBILE MENU -->
    <div id="mobileMenu" class="hidden md:hidden fixed inset-0 bg-white z-50 pt-20 px-6">
        <div class="flex flex-col gap-6 text-2xl font-medium">
            <a href="#services" onclick="toggleMobileMenu()" class="py-3 border-b">Услуги</a>
            <a href="#advantages" onclick="toggleMobileMenu()" class="py-3 border-b">Почему мы</a>
            <a href="#how" onclick="toggleMobileMenu()" class="py-3 border-b">Как работаем</a>
            <a href="#gallery" onclick="toggleMobileMenu()" class="py-3 border-b">Галерея</a>
            <a href="#reviews" onclick="toggleMobileMenu()" class="py-3 border-b">Отзывы</a>
            <a href="#faq" onclick="toggleMobileMenu()" class="py-3 border-b">FAQ</a>
            <a href="#order" onclick="toggleMobileMenu()" class="py-3 border-b">Заказать</a>
        </div>
    </div>

    <!-- HERO -->
    <section class="hero-bg h-screen flex items-center text-white">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-5xl md:text-7xl font-bold leading-none mb-6 tracking-tighter">
                ПРОФЕССИОНАЛЬНАЯ УБОРКА<br>В ВИЛЬНЮСЕ
            </h1>
            <p class="text-2xl md:text-3xl mb-10 max-w-3xl mx-auto">Быстрая, качественная и экологичная уборка квартир, офисов и после ремонта в Вильнюсе. Используем профессиональные пылесосы, тряпки, губки, швабры и эко-средства. 100% гарантия чистоты. Выезд по всему Вильнюсу.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#order" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xl font-semibold px-10 py-6 rounded-3xl inline-flex items-center gap-3 transition shadow-xl">
                    <i class="fa-solid fa-broom"></i> Заказать уборку в Вильнюсе
                </a>
                <a href="tel:+37064474842" class="border-2 border-white hover:bg-white hover:text-gray-900 text-white text-xl font-semibold px-10 py-6 rounded-3xl inline-flex items-center gap-3 transition">
                    <i class="fa-solid fa-phone"></i> +370 644 74842
                </a>
                <a href="kalkuliatorius.php?lang=ru" class="bg-white text-emerald-700 hover:bg-emerald-100 text-xl font-semibold px-10 py-6 rounded-3xl inline-flex items-center gap-3 transition shadow-xl">
                    <i class="fa-solid fa-calculator"></i> Рассчитать стоимость
                </a>
            </div>
            <div class="mt-16 text-sm uppercase tracking-widest">Вильнюс • Ежедневно 08:00-22:00 • 100% гарантия чистоты</div>
        </div>
    </section>

    <!-- SERVICES -->
    <section id="services" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-emerald-100 text-emerald-700 px-5 py-2 rounded-full text-sm font-semibold">УСЛУГИ КЛИНИНГА ВИЛЬНЮС</span>
                <h2 class="text-5xl font-bold mt-4">Профессиональная уборка в Вильнюсе — все виды уборки</h2>
                <p class="mt-6 max-w-3xl mx-auto text-xl text-gray-600">Клининг Вильнюс предлагает полный спектр услуг по уборке в Вильнюсе: поддерживающая уборка квартир, генеральная уборка, уборка после ремонта, ежедневная уборка офисов. Мы работаем только профессиональным оборудованием.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
                    <div class="h-56 bg-[url('https://picsum.photos/seed/deep-clean-apartment-vilnius-2026/600/400')] bg-cover service-img"></div>
                    <div class="p-8">
                        <h3 class="text-2xl font-semibold mb-3">Уборка квартир в Вильнюсе</h3>
                        <p class="text-gray-600">Поддерживающая, генеральная и комплексная уборка квартир в Вильнюсе. Тщательно чистим кухни, санузлы, гостиные, спальни, окна. Эко-средства и премиум-оборудование.</p>
                        <div class="mt-6 text-emerald-600 font-medium">Клининг Вильнюс для вашего комфорта</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
                    <div class="h-56 bg-[url('https://picsum.photos/seed/professional-office-cleaning-team-vilnius/600/400')] bg-cover service-img"></div>
                    <div class="p-8">
                        <h3 class="text-2xl font-semibold mb-3">Уборка офисов в Вильнюсе</h3>
                        <p class="text-gray-600">Ежедневная, генеральная и послеремонтная уборка офисов в Вильнюсе. Поддерживаем чистоту в бизнес-центрах и коворкингах.</p>
                        <div class="mt-6 text-emerald-600 font-medium">Профессиональный клининг для вашего бизнеса</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
                    <div class="h-56 bg-[url('https://picsum.photos/seed/post-renovation-cleaning-vilnius-2026/600/400')] bg-cover service-img"></div>
                    <div class="p-8">
                        <h3 class="text-2xl font-semibold mb-3">Уборка после ремонта Вильнюс</h3>
                        <p class="text-gray-600">Полное удаление строительной пыли, краски, шпаклёвки после ремонта в Вильнюсе. После нас — стерильная чистота без единой пылинки.</p>
                        <div class="mt-6 text-emerald-600 font-medium">Уборка после ремонта Вильнюс</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
                    <div class="h-56 bg-[url('https://picsum.photos/seed/general-house-cleaning-supplies-professional/600/400')] bg-cover service-img"></div>
                    <div class="p-8">
                        <h3 class="text-2xl font-semibold mb-3">Генеральная уборка в Вильнюсе</h3>
                        <p class="text-gray-600">Глубокая генеральная уборка квартир, домов и коттеджей в Вильнюсе. Чистим труднодоступные места, моем окна, шкафы и технику.</p>
                        <div class="mt-6 text-emerald-600 font-medium">Генеральная уборка Вильнюс</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ADVANTAGES -->
    <section id="advantages" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-emerald-100 text-emerald-700 px-5 py-2 rounded-full text-sm font-semibold">ПОЧЕМУ ВЫБИРАЮТ НАС</span>
                <h2 class="text-5xl font-bold mt-4">Преимущества профессиональной уборки в Вильнюсе</h2>
                <p class="mt-6 max-w-2xl mx-auto text-xl text-gray-600">Мы не просто убираем — мы создаём идеальную чистоту с помощью эко-средств, профессиональных пылесосов, тряпок и швабр.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">♻️</div>
                    <h3 class="text-2xl font-semibold mb-3">100% эко-средства</h3>
                    <p class="text-gray-600">Только безопасные для детей, животных и окружающей среды. Никакой химии.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">⭐</div>
                    <h3 class="text-2xl font-semibold mb-3">Опытные специалисты</h3>
                    <p class="text-gray-600">Каждая уборщица имеет опыт от 3 лет. Регулярное обучение и контроль качества.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">⏱️</div>
                    <h3 class="text-2xl font-semibold mb-3">Быстрый выезд</h3>
                    <p class="text-gray-600">Приезжаем по всему Вильнюсу в течение 2-4 часов. Возможна уборка в день обращения.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">🔒</div>
                    <h3 class="text-2xl font-semibold mb-3">Фиксированная цена</h3>
                    <p class="text-gray-600">Без скрытых платежей. После звонка — точная стоимость.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">🛡️</div>
                    <h3 class="text-2xl font-semibold mb-3">Гарантия качества</h3>
                    <p class="text-gray-600">Если что-то не устроит — приедем повторно бесплатно. 100% удовлетворение.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">📍</div>
                    <h3 class="text-2xl font-semibold mb-3">Все районы Вильнюса</h3>
                    <p class="text-gray-600">Работаем по всему городу: Старый город, Шешкине, Лаздинай, Пилайте, Жирмунай, Антакальнис и другие.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW WE WORK -->
    <section id="how" class="py-24 bg-emerald-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-white px-6 py-2 rounded-full text-emerald-700 font-semibold">ПРОЦЕСС УБОРКИ</span>
                <h2 class="text-5xl font-bold mt-4">Как мы делаем профессиональную уборку в Вильнюсе</h2>
                <p class="mt-6 max-w-xl mx-auto text-gray-600">Простая и прозрачная схема: от заявки до идеальной чистоты.</p>
            </div>
            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-4xl mb-6">1</div>
                    <h3 class="font-semibold text-xl">Заявка</h3>
                    <p class="mt-3 text-gray-600">Звоните или заполняете форму — мы быстро подтверждаем время.</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-4xl mb-6">2</div>
                    <h3 class="font-semibold text-xl">Приезд</h3>
                    <p class="mt-3 text-gray-600">Наши специалисты приезжают в удобное для вас время со всем оборудованием.</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-4xl mb-6">3</div>
                    <h3 class="font-semibold text-xl">Уборка</h3>
                    <p class="mt-3 text-gray-600">Выполняем полную уборку по вашим пожеланиям — от пылесоса до мытья окон.</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-4xl mb-6">4</div>
                    <h3 class="font-semibold text-xl">Контроль качества</h3>
                    <p class="mt-3 text-gray-600">Проверяем и передаём вам идеально чистый объект.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- GALLERY -->
    <section id="gallery" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-emerald-100 text-emerald-700 px-5 py-2 rounded-full text-sm font-semibold">ГАЛЕРЕЯ НАШИХ РАБОТ</span>
                <h2 class="text-5xl font-bold mt-4">Уборка в Вильнюсе — до и после (реальные фото)</h2>
                <p class="mt-6 max-w-xl mx-auto text-gray-600">Смотрите, как мы превращаем обычные квартиры и офисы в идеально чистые пространства.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <img src="https://picsum.photos/seed/sparkling-clean-kitchen-vilnius/600/400" alt="Идеально чистая кухня Вильнюс" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/office-mopping-cleaning-vilnius/600/400" alt="Мытьё полов в офисе Вильнюс" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/cleaning-rags-sponges-professional/600/400" alt="Профессиональные тряпки и губки" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/vacuuming-modern-apartment-vilnius/600/400" alt="Пылесос в современной квартире Вильнюс" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/luxury-bathroom-cleaning-vilnius/600/400" alt="Роскошная ванная после уборки Вильнюс" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/professional-window-cleaning-vilnius/600/400" alt="Мытьё окон без разводов Вильнюс" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
            </div>
        </div>
    </section>

    <!-- REVIEWS -->
    <section id="reviews" class="py-24 bg-emerald-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <span class="text-emerald-600 font-semibold">ОТЗЫВЫ С GOOGLE И FACEBOOK</span>
                    <h2 class="text-5xl font-bold">Что говорят клиенты о клиниге Вильнюс</h2>
                </div>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white border border-gray-100 p-8 rounded-3xl">
                    <div class="flex text-yellow-400 mb-4">★★★★★</div>
                    <p class="italic">"Лучшая уборка квартир в Вильнюсе! Всё блестит, приятный запах, эко-средства — супер. Спасибо команде!"</p>
                    <div class="mt-8 flex items-center gap-4"><div class="w-12 h-12 bg-gray-200 rounded-full"></div><div><div class="font-semibold">Олена Коваленко</div><div class="text-sm text-gray-500">Вильнюс • 2 недели назад</div></div></div>
                </div>
                <div class="bg-white border border-gray-100 p-8 rounded-3xl">
                    <div class="flex text-yellow-400 mb-4">★★★★★</div>
                    <p class="italic">"После ремонта — идеальная чистота. Убрали всю пыль, квартира сияет! Рекомендую всем в Вильнюсе."</p>
                    <div class="mt-8 flex items-center gap-4"><div class="w-12 h-12 bg-gray-200 rounded-full"></div><div><div class="font-semibold">Андрей Шевченко</div><div class="text-sm text-gray-500">Вильнюс • 1 месяц назад</div></div></div>
                </div>
                <div class="bg-white border border-gray-100 p-8 rounded-3xl">
                    <div class="flex text-yellow-400 mb-4">★★★★★</div>
                    <p class="italic">"Регулярная уборка офиса. Всегда на высшем уровне, пылесосы, швабры — настоящие профессионалы!"</p>
                    <div class="mt-8 flex items-center gap-4"><div class="w-12 h-12 bg-gray-200 rounded-full"></div><div><div class="font-semibold">Компания „Litva Tech“</div><div class="text-sm text-gray-500">Вильнюс • 3 недели назад</div></div></div>
                </div>
            </div>
        </div>
    </section>

    <!-- LONG SEO TEXT -->
    <section class="py-20 bg-white border-t border-b">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-8">Профессиональная уборка в Вильнюсе — ваш надёжный партнёр по чистоте</h2>
            <p class="text-lg text-gray-600 leading-relaxed mb-6">Клининг Вильнюс работает с 2023 года и уже стал любимым сервисом для сотен семей и компаний. Мы специализируемся на уборке квартир, офисов и послеремонтной уборке. Каждый выезд — комплексный подход: пылесос, мытьё полов швабрами, чистка санузлов губками, удаление пыли тряпками, только эко-средства. Мы убираем во всех районах Вильнюса. Наши клиенты получают не просто чистоту, а ощущение свежести и комфорта.</p>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold">Часто задаваемые вопросы об уборке в Вильнюсе</h2>
            </div>
            <div class="space-y-6">
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Сколько стоит уборка квартиры в Вильнюсе?</summary>
                    <p class="mt-6 text-gray-600">Цена зависит от площади, типа уборки и состояния. Поддерживающая от 8 €/час, генеральная — от 12 €/час, после ремонта — от 15 €/час. Мы всегда даём точную фиксированную цену после уточнения деталей.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Используете ли вы экологичные средства?</summary>
                    <p class="mt-6 text-gray-600">Да! Все средства — 100% эко, безопасны для детей, животных и окружающей среды.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">В каких районах Вильнюса вы работаете?</summary>
                    <p class="mt-6 text-gray-600">Убираем во всех районах: Старый город, Шешкине, Фабрикас, Лаздинай, Пилайте, Жирмунай, Антакальнис, Науйамиестис и другие. Быстрый выезд по всему городу.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Сколько времени занимает уборка?</summary>
                    <p class="mt-6 text-gray-600">Поддерживающая уборка квартиры 50-70 м² — 2-3 часа. Генеральная — 4-6 часов. После ремонта — 5-8 часов.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Можно ли заказать уборку на сегодня?</summary>
                    <p class="mt-6 text-gray-600">Да! Если есть свободные специалисты — выезжаем в тот же день. Звоните +370 644 74842.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Делаете ли вы уборку после ремонта?</summary>
                    <p class="mt-6 text-gray-600">Да, это одно из наших главных направлений. Полное удаление строительной пыли и мусора — после нас квартира блестит как новая.</p>
                </details>
            </div>
        </div>
    </section>

    <!-- ORDER FORM + КРАСИВОЕ СООБЩЕНИЕ -->
   <!-- ==================== ФОРМА ЗАКАЗА З reCAPTCHA v2 ==================== -->
    <section id="order" class="py-24 bg-gradient-to-br from-emerald-700 to-teal-800 text-white">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-5xl font-bold">Заказать уборку в Вильнюсе прямо сейчас</h2>
                <p class="mt-4 text-xl opacity-90">Отвечаем в течение 15 минут • Фиксированная цена • По всему Вильнюсу</p>
            </div>

            <?php if ($success): ?>
                <div class="bg-emerald-500 text-white p-10 rounded-3xl text-center mb-8 shadow-2xl">
                    <i class="fa-solid fa-circle-check text-7xl mb-6"></i>
                    <h3 class="text-4xl font-bold">Спасибо!</h3>
                    <p class="text-2xl mt-4">Ваш запрос на профессиональную уборку в Вильнюсе получен.<br>Мы скоро свяжемся с вами для уточнения всех деталей.</p>
                    <div class="mt-8 text-xl opacity-90">Наша команда уже готовится к вашей идеальной чистоте ✨</div>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="bg-red-600 text-white p-6 rounded-3xl text-center mb-8"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form id="order-form" method="POST" action="submit.php" class="grid md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm mb-2">Ваше имя</label>
                    <input type="text" name="name" required class="w-full px-6 py-5 rounded-3xl bg-white/10 border border-white/30 focus:border-white outline-none text-white placeholder-white/60">
                </div>
                <div>
                    <label class="block text-sm mb-2">Телефон</label>
                    <input type="tel" name="phone" required class="w-full px-6 py-5 rounded-3xl bg-white/10 border border-white/30 focus:border-white outline-none text-white placeholder-white/60">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm mb-2">Адрес в Вильнюсе и дополнительные пожелания (количество комнат, тип уборки)</label>
                    <textarea name="message" rows="5" class="w-full px-6 py-5 rounded-3xl bg-white/10 border border-white/30 focus:border-white outline-none text-white placeholder-white/60"></textarea>
                </div>

                <!-- reCAPTCHA v2 -->
                <?php renderRecaptcha(); ?>

                <div class="md:col-span-2 text-center">
                    <button type="submit" 
                            class="bg-white text-emerald-700 hover:bg-emerald-100 font-bold text-xl px-16 py-7 rounded-3xl inline-flex items-center gap-4 transition shadow-2xl">
                        <i class="fa-solid fa-paper-plane"></i> ОТПРАВИТЬ ЗАЯВКУ НА УБОРКУ
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
                    <span class="font-bold">Клининг Вильнюс</span>
                </div>
                <p class="text-gray-400">Профессиональная уборка в Вильнюсе с 2023 года. Высочайшее качество с эко-средствами и профессиональным оборудованием.</p>
            </div>
            <div>
                <div class="font-semibold mb-4 text-emerald-400">КОНТАКТЫ</div>
                <div class="space-y-3 text-gray-300">
                    <div><i class="fa-solid fa-location-dot"></i> Kalvarijų g. 100, Вильнюс</div>
                    <a href="tel:+37064474842" class="block hover:text-white">+370 644 74842</a>
                    <a href="mailto:rbilohash@gmail.com" class="block hover:text-white">Rbilohash@gmail.com</a>
                </div>
            </div>
            <div>
                <div class="font-semibold mb-4 text-emerald-400">УБИРАЕМ В РАЙОНАХ</div>
                <div class="text-gray-400 leading-relaxed">
                    Старый город • Шешкине • Фабрикас • Лаздинай • Пилайте • Жирмунай • Антакальнис • Науйамиестис и все остальные районы Вильнюса
                </div>
            </div>
        </div>
        <div class="mt-16 pt-8 border-t border-gray-800 text-center text-sm text-gray-500">
            <p>Сделано с ❤️ <a href="https://bilohash.com" target="_blank" class="hover:text-white">Ruslan Bilohash</a></p>
            <p class="mt-2">
                <a href="https://github.com/Ruslan-Bilohash" target="_blank" class="hover:text-white flex items-center justify-center gap-2">
                    <i class="fa-brands fa-github"></i> GitHub
                </a>
            </p>
            <p class="mt-6">© 2026 Клининг Вильнюс. Все права защищены.</p>
        </div>
    </footer>

    <<!-- SCHEMA.ORG -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "Meistru Valymas",
      "description": "Профессиональная уборка в Вильнюсе со скидкой 30%",
      "url": "https://meistru.lt/ru.php",
      "telephone": "+37064474842",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Vilnius",
        "addressCountry": "LT"
      },
      "openingHours": "Mo-Su 08:00-22:00",
      "priceRange": "$$",
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.98",
        "reviewCount": "142"
      }
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

    <!-- JavaScript захист форми (обов'язково!) -->
    <script>
    document.getElementById('order-form').addEventListener('submit', function(e) {
        const response = document.querySelector('.g-recaptcha-response');
        if (!response || response.value.trim() === '') {
            e.preventDefault();
            alert('Пожалуйста, подтвердите, что вы не робот (поставьте галочку "Я не робот").');
        }
    });
    </script>
</body>
</html>
