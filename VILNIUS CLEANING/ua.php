<?php
// ====================== ua.php ======================
// ПОВНІСТЬЮ ГОТОВИЙ сайт Клінінг Вільнюс (українською)
// професійне прибирання квартир, офісів, після ремонту, чисті кухні, вітальні, ванни, пилососи, ганчірки, мочалки, швабри, еко-засоби, процес уборки, прибиральниці в роботі
// Максимальний SEO 2026: розширені meta, Open Graph, Twitter Cards, Schema.org, LSI-ключі, довгі тексти 400+ слів, нові SEO-блоки
// Автор: Ruslan Bilohash | bilohash.com | github.com/Ruslan-Bilohash

$success = isset($_GET['success']) && $_GET['success'] == 1;
$error = isset($_GET['error']) && $_GET['error'] == 1 ? "Помилка відправки. Спробуйте пізніше або напишіть нам у месенджер." : "";
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <!-- БАЗОВІ SEO МЕТА -->
    <title>Прибирання у Вільнюсі | Клінінг Вільнюс | Професійна уборка квартир, офісів і після ремонту 2026</title>
    <meta name="description" content="Професійне прибирання у Вільнюсі ✓ Клінінг Вільнюс квартир, офісів, післяремонтне прибирання, генеральне прибирання ✓ Еко-засоби, пилососи, ганчірки, швабри ✓ Швидкий виїзд по всьому Вільнюсу (Старе місто, Шешкіне, Лаздінай, Пілайте) ✓ Гарантія чистоти 100% ✓ Фіксована ціна ✓ Тел: +370 644 74842">
    <meta name="keywords" content="прибирання Вільнюс, клінінг Вільнюс, уборка Вільнюс, професійне прибирання Вільнюс, прибирання квартир Вільнюс, уборка офісів Вільнюс, післяремонтне прибирання Вільнюс, генеральне прибирання Вільнюс, cleaning Vilnius, клінінг квартир Вільнюс, прибирання після ремонту Вільнюс, еко прибирання Вільнюс, пилосос Вільнюс, ганчірки мочалки Вільнюс, швабра Вільнюс, регулярне прибирання Вільнюс">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="author" content="Ruslan Bilohash">
    <meta name="theme-color" content="#10b981">
    <link rel="canonical" href="https://bilohash.com/ua.php">
    <!-- OPEN GRAPH -->
    <meta property="og:title" content="Прибирання у Вільнюсі | Клінінг Вільнюс | Професійна уборка квартир, офісів і після ремонту">
    <meta property="og:description" content="Клінінг Вільнюс — професійне прибирання квартир, офісів, після ремонту у Вільнюсі. Еко-засоби, швидкий виїзд, гарантія якості, пилососи та професійні ганчірки. +370 644 74842">
    <meta property="og:image" content="https://picsum.photos/seed/professional-cleaning-vilnius-hero/1200/630">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:url" content="https://bilohash.com/ua.php">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="uk_UA">
    <meta property="og:site_name" content="Клінінг Вільнюс">
    <!-- TWITTER CARDS -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Прибирання у Вільнюсі | Клінінг Вільнюс — квартири, офіси, після ремонту">
    <meta name="twitter:description" content="Професійне прибирання у Вільнюсі ✓ Квартири • Офіси • Після ремонту • Еко-засоби • +370 644 74842">
    <meta name="twitter:image" content="https://picsum.photos/seed/professional-cleaning-vilnius-hero/1200/630">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Playfair+Display:wght@700&amp;display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Playfair+Display:wght@700&amp;display=swap');
        .hero-bg { background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('https://picsum.photos/seed/professional-cleaning-vilnius-hero/2000/1200') center/cover no-repeat; }
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
                    <span class="text-3xl font-bold tracking-tight">КЛІНІНГ ВІЛЬНЮС</span>
                </div>
            </div>
            <nav class="hidden md:flex items-center gap-8 text-lg font-medium">
                <a href="#services" class="hover:text-emerald-600 transition">Послуги</a>
                <a href="#advantages" class="hover:text-emerald-600 transition">Переваги</a>
                <a href="#how" class="hover:text-emerald-600 transition">Як ми працюємо</a>
                <a href="#gallery" class="hover:text-emerald-600 transition">Галерея</a>
                <a href="#reviews" class="hover:text-emerald-600 transition">Відгуки</a>
                <a href="#faq" class="hover:text-emerald-600 transition">FAQ</a>
                <a href="#order" class="hover:text-emerald-600 transition">Замовити</a>
            </nav>
            <div class="relative group">
                <button onclick="toggleLang()" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-2xl transition">
                    <span class="flag">🇺🇦</span>
                    <span class="font-semibold">UA</span>
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </button>
                <div id="langDropdown" class="hidden group-hover:block absolute right-0 mt-3 bg-white shadow-2xl rounded-3xl py-4 w-52 z-50 border border-gray-100">
                    <a href="index.php" class="flex items-center gap-4 px-6 py-3 hover:bg-emerald-50 transition"><span class="flag">🇱🇹</span><span>Lietuvių</span></a>
                    <a href="no.php" class="flex items-center gap-4 px-6 py-3 hover:bg-emerald-50 transition"><span class="flag">🇳🇴</span><span>Norsk</span></a>
                    <a href="en.php" class="flex items-center gap-4 px-6 py-3 hover:bg-emerald-50 transition"><span class="flag">🇬🇧</span><span>English</span></a>
                    <a href="ru.php" class="flex items-center gap-4 px-6 py-3 hover:bg-emerald-50 transition"><span class="flag">🇷🇺</span><span>Русский</span></a>
                    <a href="ua.php" class="flex items-center gap-4 px-6 py-3 bg-emerald-50 text-emerald-700"><span class="flag">🇺🇦</span><span>Українська</span></a>
                </div>
            </div>
            <button onclick="toggleMobileMenu()" class="md:hidden text-3xl"><i class="fa-solid fa-bars"></i></button>
        </div>
    </header>
    <!-- MOBILE MENU -->
    <div id="mobileMenu" class="hidden md:hidden fixed inset-0 bg-white z-50 pt-20 px-6">
        <div class="flex flex-col gap-6 text-2xl font-medium">
            <a href="#services" onclick="toggleMobileMenu()" class="py-3 border-b">Послуги</a>
            <a href="#advantages" onclick="toggleMobileMenu()" class="py-3 border-b">Переваги</a>
            <a href="#how" onclick="toggleMobileMenu()" class="py-3 border-b">Як ми працюємо</a>
            <a href="#gallery" onclick="toggleMobileMenu()" class="py-3 border-b">Галерея</a>
            <a href="#reviews" onclick="toggleMobileMenu()" class="py-3 border-b">Відгуки</a>
            <a href="#faq" onclick="toggleMobileMenu()" class="py-3 border-b">FAQ</a>
            <a href="#order" onclick="toggleMobileMenu()" class="py-3 border-b">Замовити</a>
        </div>
    </div>
    <!-- HERO -->
    <section class="hero-bg h-screen flex items-center text-white">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-5xl md:text-7xl font-bold leading-none mb-6 tracking-tighter">
                ПРОФЕСІЙНЕ ПРИБИРАННЯ<br>У ВІЛЬНЮСІ 2026
            </h1>
            <p class="text-2xl md:text-3xl mb-10 max-w-3xl mx-auto">Клінінг Вільнюс — це швидке, якісне та екологічне прибирання квартир, офісів і після ремонту у Вільнюсі. Ми використовуємо професійні пилососи, ганчірки, мочалки, швабри та еко-засоби. Гарантуємо ідеальну чистоту в кожному куточку вашого дому чи бізнесу. Швидкий виїзд по всіх районах Вільнюса.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#order" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xl font-semibold px-10 py-6 rounded-3xl inline-flex items-center gap-3 transition shadow-xl">
                    <i class="fa-solid fa-broom"></i> Замовити прибирання у Вільнюсі
                </a>
                <a href="tel:+37064474842" class="border-2 border-white hover:bg-white hover:text-gray-900 text-white text-xl font-semibold px-10 py-6 rounded-3xl inline-flex items-center gap-3 transition">
                    <i class="fa-solid fa-phone"></i> +370 644 74842
                </a>
            </div>
            <div class="mt-16 text-sm uppercase tracking-widest">Вільнюс • Щодня 08:00-22:00 • Гарантія чистоти 100%</div>
        </div>
    </section>
    <!-- SERVICES -->
    <section id="services" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-emerald-100 text-emerald-700 px-5 py-2 rounded-full text-sm font-semibold">ПОСЛУГИ КЛІНІНГ ВІЛЬНЮС</span>
                <h2 class="text-5xl font-bold mt-4">Професійне прибирання у Вільнюсі — всі види уборки</h2>
                <p class="mt-6 max-w-3xl mx-auto text-xl text-gray-600">Клінінг Вільнюс пропонує повний спектр послуг з прибирання у Вільнюсі: підтримуюче прибирання квартир, генеральне прибирання, післяремонтне прибирання, щоденне прибирання офісів. Ми працюємо тільки професійним обладнанням — пилососи, ганчірки, мочалки, швабри, еко-засоби. Кожна уборка — це ідеальна чистота і свіжий запах у вашому приміщенні.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
                    <div class="h-56 bg-[url('https://picsum.photos/seed/apartment-deep-clean-vilnius/600/400')] bg-cover service-img"></div>
                    <div class="p-8">
                        <h3 class="text-2xl font-semibold mb-3">Прибирання квартир у Вільнюсі</h3>
                        <p class="text-gray-600">Професійне прибирання квартир у Вільнюсі: підтримуюче, генеральне, комплексне. Ми ретельно чистимо кухні, санвузли, вітальні, спальні, вікна. Використовуємо еко-засоби, пилососи та ганчірки преміум-класу. Клінінг Вільнюс для вашого дому — чистота, якої ви заслуговуєте. Прибираємо в усіх районах: Старе місто, Шешкіне, Лаздінай, Пілайте та інших.</p>
                        <div class="mt-6 text-emerald-600 font-medium">Клінінг Вільнюс для вашого комфорту</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
                    <div class="h-56 bg-[url('https://picsum.photos/seed/professional-office-cleaning/600/400')] bg-cover service-img"></div>
                    <div class="p-8">
                        <h3 class="text-2xl font-semibold mb-3">Прибирання офісів у Вільнюсі</h3>
                        <p class="text-gray-600">Щоденне, генеральне та післяремонтне прибирання офісів у Вільнюсі. Підтримуємо чистоту в бізнес-центрах, коворкінгах, адміністративних приміщеннях. Професійні прибиральниці з пилососами, швабрами та еко-засобами. Клінінг Вільнюс для бізнесу — ідеальна чистота щодня, щоб ваші співробітники працювали продуктивно.</p>
                        <div class="mt-6 text-emerald-600 font-medium">Професійний клінінг Вільнюс для бізнесу</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
                    <div class="h-56 bg-[url('https://picsum.photos/seed/post-renovation-cleaning-team/600/400')] bg-cover service-img"></div>
                    <div class="p-8">
                        <h3 class="text-2xl font-semibold mb-3">Післяремонтне прибирання Вільнюс</h3>
                        <p class="text-gray-600">Повне видалення будівельного пилу, фарби, шпаклівки, цементу після ремонту у Вільнюсі. Ми прибираємо квартири, будинки, нові об’єкти. Використовуємо потужні пилососи та спеціальні ганчірки. Після нас — стерильна чистота без жодної пилинки. Клінінг Вільнюс після ремонту — швидко і якісно.</p>
                        <div class="mt-6 text-emerald-600 font-medium">Уборка Вільнюс після ремонту</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
                    <div class="h-56 bg-[url('https://picsum.photos/seed/general-house-cleaning-supplies/600/400')] bg-cover service-img"></div>
                    <div class="p-8">
                        <h3 class="text-2xl font-semibold mb-3">Генеральне прибирання у Вільнюсі</h3>
                        <p class="text-gray-600">Глибоке генеральне прибирання квартир, будинків, котеджів у Вільнюсі. Прибираємо важкодоступні місця, миємо вікна, шафи, техніку. Професійні швабри, мочалки, еко-засоби. Клінінг Вільнюс — генеральне прибирання, яке перетворює ваш простір на ідеально чистий.</p>
                        <div class="mt-6 text-emerald-600 font-medium">Генеральне прибирання Вільнюс</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- NEW SEO ADVANTAGES SECTION -->
    <section id="advantages" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-emerald-100 text-emerald-700 px-5 py-2 rounded-full text-sm font-semibold">ЧОМУ ОБИРАЮТЬ КЛІНІНГ ВІЛЬНЮС</span>
                <h2 class="text-5xl font-bold mt-4">Переваги професійного прибирання у Вільнюсі</h2>
                <p class="mt-6 max-w-2xl mx-auto text-xl text-gray-600">Ми не просто прибираємо — ми створюємо ідеальну чистоту з використанням еко-засобів, професійних пилососів, ганчірок і швабр. Ось чому клієнти у Вільнюсі обирають саме нас для регулярного клінінгу.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">♻️</div>
                    <h3 class="text-2xl font-semibold mb-3">100% еко-засоби</h3>
                    <p class="text-gray-600">Тільки безпечні для дітей, тварин і довкілля засоби. Ніякої хімії — тільки натуральні формули для прибирання квартир та офісів у Вільнюсі.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">⭐</div>
                    <h3 class="text-2xl font-semibold mb-3">Досвідчені фахівці</h3>
                    <p class="text-gray-600">Кожна прибиральниця має досвід від 3 років. Регулярне навчання, перевірка якості після кожного прибирання у Вільнюсі.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">⏱️</div>
                    <h3 class="text-2xl font-semibold mb-3">Швидкий виїзд</h3>
                    <p class="text-gray-600">Приїжджаємо по всьому Вільнюсу протягом 2-4 годин. Можливе прибирання у день звернення — квартири, офіси, після ремонту.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">🔒</div>
                    <h3 class="text-2xl font-semibold mb-3">Фіксована ціна</h3>
                    <p class="text-gray-600">Ніяких прихованих платежів. Після дзвінка — точна вартість прибирання у Вільнюсі. Прозоро і чесно.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">🛡️</div>
                    <h3 class="text-2xl font-semibold mb-3">Гарантія якості</h3>
                    <p class="text-gray-600">Якщо після прибирання щось не влаштує — приїдемо повторно безкоштовно. 100% задоволення від клінінгу Вільнюс.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl card-hover">
                    <div class="text-5xl mb-6">📍</div>
                    <h3 class="text-2xl font-semibold mb-3">Всі райони Вільнюса</h3>
                    <p class="text-gray-600">Працюємо по всьому місту: Старе місто, Шешкіне, Фабрикас, Лаздінай, Пілайте, Жирмунай, Антакальніс, Пашилайчай та інші.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW WE WORK -->
    <section id="how" class="py-24 bg-emerald-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-white px-6 py-2 rounded-full text-emerald-700 font-semibold">ПРОЦЕС ПРИБИРАННЯ</span>
                <h2 class="text-5xl font-bold mt-4">Як ми робимо професійне прибирання у Вільнюсі</h2>
                <p class="mt-6 max-w-xl mx-auto text-gray-600">Проста та прозора схема: від заявки до ідеальної чистоти. Ми використовуємо тільки професійне обладнання — пилососи, ганчірки, мочалки, швабри та еко-засоби.</p>
            </div>
            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-4xl mb-6">1</div>
                    <h3 class="font-semibold text-xl">Заявка</h3>
                    <p class="mt-3 text-gray-600">Телефонуєте або заповнюєте форму — ми швидко підтверджуємо час прибирання у Вільнюсі.</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-4xl mb-6">2</div>
                    <h3 class="font-semibold text-xl">Приїзд</h3>
                    <p class="mt-3 text-gray-600">Наші фахівці приїжджають у зручний для вас час з професійним обладнанням та еко-засобами.</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-4xl mb-6">3</div>
                    <h3 class="font-semibold text-xl">Прибирання</h3>
                    <p class="mt-3 text-gray-600">Виконуємо повне прибирання квартир чи офісів у Вільнюсі за вашими побажаннями — від пилососіння до миття вікон.</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-4xl mb-6">4</div>
                    <h3 class="font-semibold text-xl">Контроль</h3>
                    <p class="mt-3 text-gray-600">Перевіряємо якість і передаємо вам ідеально чистий об’єкт у Вільнюсі.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- GALLERY -->
    <section id="gallery" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-emerald-100 text-emerald-700 px-5 py-2 rounded-full text-sm font-semibold">ГАЛЕРЕЯ РОБІТ КЛІНІНГУ</span>
                <h2 class="text-5xl font-bold mt-4">Прибирання у Вільнюсі — до і після (фото реальних об’єктів)</h2>
                <p class="mt-6 max-w-xl mx-auto text-gray-600">Дивіться, як ми перетворюємо звичайні квартири та офіси на ідеально чисті простори за допомогою професійних пилососів, ганчірок та еко-засобів.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <img src="https://picsum.photos/seed/sparkling-clean-kitchen/600/400" alt="Прибирання кухні Вільнюс — професійні ганчірки, мочалки, блискуча чистота" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/office-mopping-cleaning/600/400" alt="Клінінг офісу Вільнюс — швабра, пилосос, ідеальна чистота підлоги" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/cleaning-rags-sponges/600/400" alt="Мочалки та ганчірки в роботі — професійне прибирання Вільнюс" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/vacuuming-modern-apartment/600/400" alt="Пилосос у вітальні — генеральне прибирання квартир Вільнюс" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/luxury-bathroom-cleaning/600/400" alt="Післяремонтне прибирання ванни Вільнюс — блискуча чистота" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
                <img src="https://picsum.photos/seed/professional-window-cleaning/600/400" alt="Уборка вікон ганчірками — клінінг Вільнюс без розводів" class="gallery-img rounded-3xl shadow-lg w-full h-full object-cover">
            </div>
        </div>
    </section>

    <!-- REVIEWS -->
    <section id="reviews" class="py-24 bg-emerald-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <span class="text-emerald-600 font-semibold">ВІДГУКИ З GOOGLE ТА FACEBOOK</span>
                    <h2 class="text-5xl font-bold">Що кажуть клієнти про клінінг Вільнюс</h2>
                </div>
                <a href="https://www.google.com/search?hl=uk&q=Baltic%20clean%20Vilnius%20%D0%92%D1%96%D0%B4%D0%B3%D1%83%D0%BA%D0%B8&rflfq=1&num=20&stick=H4sIAAAAAAAAAONgkxKyMLY0NDO2MDQwtDAwMDOxMDDcwMj4ilHZKTGnJDNZITknNTFPISwzJy-ztFjhwqSL0y5subD5YvOFXRd2LGIlRhUA0Va-9GUAAAA&rldimm=839163810180064801&tbm=lcl&cs=1&sa=X&ved=0CCcQ9fQKKABqFwoTCPiz5dHD-pIDFQAAAAAdAAAAABAG&biw=1920&bih=919&dpr=1#lkt=LocalPoiReviews"
                   target="_blank" class="hidden md:flex items-center gap-3 text-emerald-600 hover:text-emerald-700 font-medium">
                    Читати всі відгуки на Google <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white border border-gray-100 p-8 rounded-3xl">
                    <div class="flex text-yellow-400 mb-4">★★★★★</div>
                    <p class="italic">"Найкраще прибирання квартир у Вільнюсі! Все блищить, запах приємний, еко-засоби — супер. Дякую команді!"</p>
                    <div class="mt-8 flex items-center gap-4"><div class="w-12 h-12 bg-gray-200 rounded-full"></div><div><div class="font-semibold">Олена Коваленко</div><div class="text-sm text-gray-500">Вільнюс • 2 тижні тому</div></div></div>
                </div>
                <div class="bg-white border border-gray-100 p-8 rounded-3xl">
                    <div class="flex text-yellow-400 mb-4">★★★★★</div>
                    <p class="italic">"Після ремонту — ідеальна чистота. Видалили весь пил, квартира сяє! Рекомендую всім у Вільнюсі."</p>
                    <div class="mt-8 flex items-center gap-4"><div class="w-12 h-12 bg-gray-200 rounded-full"></div><div><div class="font-semibold">Андрій Шевченко</div><div class="text-sm text-gray-500">Вільнюс • 1 місяць тому</div></div></div>
                </div>
                <div class="bg-white border border-gray-100 p-8 rounded-3xl">
                    <div class="flex text-yellow-400 mb-4">★★★★★</div>
                    <p class="italic">"Регулярне прибирання офісу. Все завжди на найвищому рівні, пилосос, швабри — професіонали!"</p>
                    <div class="mt-8 flex items-center gap-4"><div class="w-12 h-12 bg-gray-200 rounded-full"></div><div><div class="font-semibold">Компанія „Litva Tech“</div><div class="text-sm text-gray-500">Вільнюс • 3 тижні тому</div></div></div>
                </div>
            </div>
            <div class="text-center mt-12">
                <a href="https://www.google.com/search?hl=uk&q=Baltic%20clean%20Vilnius%20%D0%92%D1%96%D0%B4%D0%B3%D1%83%D0%BA%D0%B8&rflfq=1&num=20&stick=H4sIAAAAAAAAAONgkxKyMLY0NDO2MDQwtDAwMDOxMDDcwMj4ilHZKTGnJDNZITknNTFPISwzJy-ztFjhwqSL0y5subD5YvOFXRd2LGIlRhUA0Va-9GUAAAA&rldimm=839163810180064801&tbm=lcl&cs=1&sa=X&ved=0CCcQ9fQKKABqFwoTCPiz5dHD-pIDFQAAAAAdAAAAABAG&biw=1920&bih=919&dpr=1#lkt=LocalPoiReviews"
                   target="_blank" class="inline-flex items-center gap-3 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 px-8 py-4 rounded-3xl font-medium">
                    Всі відгуки на Google <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- LONG SEO TEXT SECTION -->
    <section class="py-20 bg-white border-t border-b">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-8">Професійне прибирання у Вільнюсі — ваш надійний партнер з чистоти</h2>
            <p class="text-lg text-gray-600 leading-relaxed mb-6">Клінінг Вільнюс працює з 2023 року і вже встиг стати улюбленим сервісом для сотень сімей та компаній. Ми спеціалізуємося на прибиранні квартир, офісів, післяремонтній уборці. Кожне прибирання — це комплексний підхід: пилососіння, миття підлог швабрами, чищення санвузлів мочалками, видалення пилу ганчірками, використання тільки еко-засобів. Ми прибираємо в усіх районах Вільнюса — від історичного Старого міста до сучасних новобудов Шешкіне та Лаздінай. Наші клієнти отримують не просто чистоту, а відчуття свіжості та комфорту. Замовляйте прибирання у Вільнюсі прямо зараз — і переконайтеся в нашій професійності!</p>
            <p class="text-lg text-gray-600 leading-relaxed">Ми розуміємо, як важливо жити та працювати в чистому приміщенні. Тому пропонуємо гнучкий графік, фіксовані ціни та повну гарантію. Прибирання Вільнюс від нашої команди — це інвестиція у ваше здоров’я та настрій.</p>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold">Часті питання про прибирання у Вільнюсі</h2>
            </div>
            <div class="space-y-6">
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Скільки коштує прибирання квартири у Вільнюсі?</summary>
                    <p class="mt-6 text-gray-600">Ціна залежить від площі, типу прибирання та стану приміщення. Підтримуюче прибирання від 8 €/год, генеральне — від 12 €/год, післяремонтне — від 15 €/год. Ми завжди даємо точну фіксовану ціну після уточнення деталей. Зателефонуйте — розрахуємо за 2 хвилини.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Чи використовуєте ви екологічні засоби для прибирання?</summary>
                    <p class="mt-6 text-gray-600">Так! Всі засоби — 100% еко, безпечні для дітей, тварин та довкілля. Ми дбаємо про здоров’я клієнтів і чистоту Вільнюса.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">В яких районах Вільнюса ви працюєте?</summary>
                    <p class="mt-6 text-gray-600">Прибираємо в усіх районах Вільнюса: Старе місто, Шешкіне, Фабрикас, Лаздінай, Пілайте, Жирмунай, Антакальніс, Пашилайчай, Науямєстіс та інші. Швидкий виїзд по всьому місту.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Скільки часу займає прибирання квартири чи офісу?</summary>
                    <p class="mt-6 text-gray-600">Підтримуюче прибирання квартири 50-70 м² — від 2-3 годин. Генеральне — від 4-6 годин. Післяремонтне — від 5-8 годин. Точний час залежить від стану приміщення.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Чи можна замовити прибирання на сьогодні?</summary>
                    <p class="mt-6 text-gray-600">Так! Якщо є вільні фахівці — виїжджаємо у той же день по Вільнюсу. Зателефонуйте +370 644 74842.</p>
                </details>
                <details class="bg-gray-50 border border-gray-200 rounded-3xl p-8 group">
                    <summary class="font-semibold text-xl cursor-pointer flex justify-between items-center">Чи прибираєте ви після ремонту?</summary>
                    <p class="mt-6 text-gray-600">Так, це один з наших головних напрямків. Повне видалення будівельного пилу, фарби, клею — після нас квартира блищить як нова.</p>
                </details>
            </div>
        </div>
    </section>

    <!-- ORDER FORM -->
    <section id="order" class="py-24 bg-gradient-to-br from-emerald-700 to-teal-800 text-white">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-5xl font-bold">Замовити прибирання у Вільнюсі прямо зараз</h2>
                <p class="mt-4 text-xl opacity-90">Відповідаємо протягом 15 хвилин • Виїзд по всьому Вільнюсу • Фіксована ціна</p>
            </div>
            <?php if ($success): ?>
                <div class="bg-emerald-500 text-white p-8 rounded-3xl text-center mb-8">
                    <i class="fa-solid fa-circle-check text-6xl mb-4"></i>
                    <h3 class="text-3xl font-bold">Дякуємо! Запит на прибирання у Вільнюсі отримано.</h3>
                    <p class="mt-3">Ми зв'яжемося з вами найближчим часом для уточнення деталей.</p>
                </div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="bg-red-600 text-white p-6 rounded-3xl text-center mb-8"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST" action="submit.php" class="grid md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm mb-2">Ім'я</label>
                    <input type="text" name="name" required class="w-full px-6 py-5 rounded-3xl bg-white/10 border border-white/30 focus:border-white outline-none text-white placeholder-white/60">
                </div>
                <div>
                    <label class="block text-sm mb-2">Телефон</label>
                    <input type="tel" name="phone" required class="w-full px-6 py-5 rounded-3xl bg-white/10 border border-white/30 focus:border-white outline-none text-white placeholder-white/60">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm mb-2">Адреса у Вільнюсі та додаткові побажання (кількість кімнат, тип прибирання)</label>
                    <textarea name="message" rows="5" class="w-full px-6 py-5 rounded-3xl bg-white/10 border border-white/30 focus:border-white outline-none text-white placeholder-white/60"></textarea>
                </div>
                <div class="md:col-span-2 text-center">
                    <button type="submit" class="bg-white text-emerald-700 hover:bg-emerald-100 font-bold text-xl px-16 py-7 rounded-3xl inline-flex items-center gap-4 transition shadow-2xl">
                        <i class="fa-solid fa-paper-plane"></i> НАДІСЛАТИ ЗАПИТ НА ПРИБИРАННЯ
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
                    <span class="font-bold">Клінінг Вільнюс</span>
                </div>
                <p class="text-gray-400">Професійне прибирання у Вільнюсі з 2023 року. Клінінг Вільнюс найвищої якості з еко-засобами та професійним обладнанням.</p>
            </div>
            <div>
                <div class="font-semibold mb-4 text-emerald-400">КОНТАКТИ</div>
                <div class="space-y-3 text-gray-300">
                    <div><i class="fa-solid fa-location-dot"></i> Kalvarijų g. 100, Вільнюс</div>
                    <a href="tel:+37064474842" class="block hover:text-white">+370 644 74842</a>
                    <a href="mailto:rbilohash@gmail.com" class="block hover:text-white">Rbilohash@gmail.com</a>
                </div>
            </div>
            <div>
                <div class="font-semibold mb-4 text-emerald-400">ПРИБИРАЄМО В РАЙОНАХ</div>
                <div class="text-gray-400 leading-relaxed">
                    Старе місто • Шешкіне • Фабрикас • Лаздінай • Пілайте • Жирмунай • Антакальніс • Пашилайчай • Науямєстіс та всі інші райони Вільнюса
                </div>
            </div>
        </div>
        <div class="mt-16 pt-8 border-t border-gray-800 text-center text-sm text-gray-500">
            <p>Зроблено з ❤️ <a href="https://bilohash.com" target="_blank" class="hover:text-white">Ruslan Bilohash</a></p>
            <p class="mt-2">
                <a href="https://github.com/Ruslan-Bilohash" target="_blank" class="hover:text-white flex items-center justify-center gap-2">
                    <i class="fa-brands fa-github"></i> GitHub
                </a>
            </p>
            <p class="mt-6">© 2026 Клінінг Вільнюс. Усі права захищено.</p>
        </div>
    </footer>

    <!-- SCHEMA.ORG -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "Клінінг Вільнюс",
      "description": "Професійне прибирання у Вільнюсі – клінінг квартир, офісів, післяремонтне прибирання, генеральне прибирання з еко-засобами та професійним обладнанням",
      "url": "https://bilohash.com/ua.php",
      "telephone": "+37064474842",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Kalvarijų g. 100",
        "addressLocality": "Вільнюс",
        "addressCountry": "LT"
      },
      "openingHours": "Mo-Su 08:00-22:00",
      "priceRange": "$$",
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.98",
        "reviewCount": "142"
      },
      "image": "https://picsum.photos/seed/professional-cleaning-vilnius-hero/1200/630"
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