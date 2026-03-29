<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_order'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = 'Ошибка безопасности. Обновите страницу.';
    } else {
        $name    = trim(htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES));
        $phone   = trim(htmlspecialchars($_POST['phone'] ?? '', ENT_QUOTES));
        $message = trim(htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES));

        if (empty($name) || empty($phone)) {
            $error = 'Имя и телефон обязательны!';
        } elseif (!preg_match('/^[\+]?[\d\s\-\(\)]{10,18}$/', $phone)) {
            $error = 'Неверный формат телефона!';
        } else {
            $to      = 'rbilohash@gmail.com';
            $subject = 'Новая заявка с ukrbud.lt — Уборка Вильнюс';
            $body    = "Имя: $name\nТелефон: $phone\nСообщение:\n$message\n\nДата: " . date('d.m.Y H:i:s') . "\nIP: " . $_SERVER['REMOTE_ADDR'];
            $headers = "From: no-reply@ukrbud.lt\r\nContent-Type: text/plain; charset=utf-8\r\n";

            if (mail($to, $subject, $body, $headers)) {
                $success = true;
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            } else {
                $error = 'Не удалось отправить заявку. Позвоните: +370 644 74842';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Уборка после ремонта Вильнюс ✓ Уборка офисов Вильнюс ✓ Клининг коммерческих помещений ✓ Цены от 3 €/м² ✓ Безналичный расчёт ✓ Выезд 60 минут. Профессиональная клининговая компания Ukrbud.lt +370 644 74842">
    <meta name="keywords" content="уборка после ремонта Вильнюс, уборка офисов Вильнюс, клининг Вильнюс, уборка коммерческих помещений Вильнюс, уборка после стройки Вильнюс, генеральная уборка Вильнюс, клининговая компания Вильнюс, уборка помещений Вильнюс">
    <title>Уборка после ремонта Вильнюс | Уборка офисов и коммерческих помещений | Ukrbud.lt</title>

    <!-- Open Graph -->
    <meta property="og:title" content="Уборка после ремонта Вильнюс • Ukrbud.lt">
    <meta property="og:description" content="Профессиональная уборка после ремонта, офисов и коммерческих помещений в Вильнюсе. Лучшие цены и качество. +370 644 74842">
    <meta property="og:image" content="https://ukrbud.lt/og-image.jpg">
    <meta property="og:url" content="https://ukrbud.lt">
    <meta property="og:type" content="website">

    <!-- Schema -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "Ukrbud.lt",
        "telephone": "+37064474842",
        "description": "Уборка после ремонта Вильнюс, уборка офисов Вильнюс, клининг коммерческих помещений",
        "address": { "@type": "PostalAddress", "addressLocality": "Vilnius", "addressCountry": "LT" }
    }
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600&display=swap');
        .heading-font { font-family: 'Space Grotesk', sans-serif; }
        .hero-bg { background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 100%); }
        .service-card:hover { transform: translateY(-12px) scale(1.04); box-shadow: 0 30px 60px -15px rgb(0 212 255 / 0.35); }
        .price-row:hover { background-color: rgba(0, 212, 255, 0.1); }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
        .mobile-menu { animation: slideDown 0.3s ease forwards; }
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
            <a href="#prices" class="hover:text-cyan-400">Цены</a>
            <a href="#why" class="hover:text-cyan-400">Почему мы</a>
            <a href="#about" class="hover:text-cyan-400">О нас</a>
            <a href="#reviews" class="hover:text-cyan-400">Отзывы</a>
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

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden lg:hidden bg-black border-t border-white/10 px-6 py-10 mobile-menu">
        <div class="flex flex-col gap-y-6 text-white text-2xl font-medium">
            <a href="#services" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Услуги</a>
            <a href="#prices" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Цены</a>
            <a href="#why" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Почему мы</a>
            <a href="#about" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">О нас</a>
            <a href="#reviews" onclick="toggleMobileMenu()" class="py-3 border-b border-white/10">Отзывы</a>
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
                    Вильнюс • 24/7 • Безналичный расчёт
                </div>
                <h1 class="heading-font text-5xl md:text-6xl lg:text-7xl font-semibold leading-none tracking-[-2px]">
                    Уборка после ремонта Вильнюс<br>и уборка офисов Вильнюс
                </h1>
                <p class="text-2xl text-white/80">Профессиональная клининговая компания Ukrbud.lt предлагает качественную уборку после ремонта, уборку офисов и коммерческих помещений по лучшим ценам в Вильнюсе. Выезд бригады в течение 60 минут.</p>
                
                <div class="flex flex-wrap gap-4">
                    <a href="#prices" class="px-10 py-6 bg-cyan-400 text-black font-bold text-xl rounded-3xl">Смотреть цены</a>
                    <a href="tel:+37064474842" class="px-10 py-6 border border-white/40 text-xl font-bold rounded-3xl hover:bg-white/10">Позвонить сейчас</a>
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
        <p class="max-w-3xl mx-auto text-center text-lg text-gray-600 mb-12">
            Мы специализируемся на <strong>уборке после ремонта Вильнюс</strong>. Наша команда профессионально убирает строительную пыль, остатки краски, штукатурки и мусор. Также выполняем регулярную <strong>уборку офисов Вильнюс</strong> и <strong>уборку коммерческих помещений Вильнюс</strong> — магазины, салоны красоты, кафе, склады и медицинские центры.
        </p>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="service-card bg-white border border-gray-100 rounded-3xl p-10 shadow-xl">
                <div class="text-6xl mb-6">🏗️</div>
                <h3 class="text-3xl font-semibold">Уборка после ремонта Вильнюс</h3>
                <p class="text-gray-600 mt-4">Полный цикл уборки после ремонта: удаление строительной пыли, мойка окон, чистка всех поверхностей, плинтусов, потолков и люстр. После нас помещение выглядит идеально чистым.</p>
                <div class="mt-8 text-cyan-400 font-semibold">от 3 €/м²</div>
            </div>
            <div class="service-card bg-white border border-gray-100 rounded-3xl p-10 shadow-xl">
                <div class="text-6xl mb-6">🏢</div>
                <h3 class="text-3xl font-semibold">Уборка офисов Вильнюс</h3>
                <p class="text-gray-600 mt-4">Ежедневная, еженедельная и генеральная уборка офисов. Чистые рабочие места, санузлы, кухни и переговорные комнаты. Поддерживаем высокий уровень чистоты для вашего бизнеса.</p>
                <div class="mt-8 text-cyan-400 font-semibold">от 2.5 €/м²</div>
            </div>
            <div class="service-card bg-white border border-gray-100 rounded-3xl p-10 shadow-xl">
                <div class="text-6xl mb-6">🛒</div>
                <h3 class="text-3xl font-semibold">Уборка коммерческих помещений Вильнюс</h3>
                <p class="text-gray-600 mt-4">Качественный клининг для магазинов, салонов красоты, кафе, складов и других коммерческих объектов. Индивидуальный подход, дезинфекция и глубокая чистка.</p>
                <div class="mt-8 text-cyan-400 font-semibold">Индивидуально</div>
            </div>
        </div>
    </div>
</section>

<!-- PRICES -->
<section id="prices" class="py-24 bg-gray-50">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <h2 class="heading-font text-5xl text-center mb-4">Цены на уборку после ремонта Вильнюс</h2>
        <div class="overflow-x-auto mt-12 rounded-3xl bg-white shadow-2xl">
            <table class="w-full min-w-[900px]">
                <thead>
                    <tr class="border-b">
                        <th class="pl-10 py-7 text-left font-medium text-gray-500">Услуга</th>
                        <th class="pl-10 py-7 text-left font-medium text-gray-500">Площадь</th>
                        <th class="pr-10 py-7 text-right font-medium text-gray-500">Цена от</th>
                        <th class="pr-10 py-7 text-right font-medium text-gray-500">Цена до</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="price-row border-b">
                        <td class="pl-10 py-7 font-medium">Уборка после ремонта Вильнюс</td>
                        <td class="pl-10 py-7">до 100 м²</td>
                        <td class="pr-10 py-7 text-right font-semibold text-emerald-600">3 €/м²</td>
                        <td class="pr-10 py-7 text-right font-semibold text-emerald-600">7 €/м²</td>
                    </tr>
                    <tr class="price-row border-b">
                        <td class="pl-10 py-7 font-medium">Уборка после ремонта Вильнюс</td>
                        <td class="pl-10 py-7">100–300 м²</td>
                        <td class="pr-10 py-7 text-right font-semibold text-emerald-600">2.8 €/м²</td>
                        <td class="pr-10 py-7 text-right font-semibold text-emerald-600">5.5 €/м²</td>
                    </tr>
                    <tr class="price-row border-b">
                        <td class="pl-10 py-7 font-medium">Уборка офисов Вильнюс (ежедневная)</td>
                        <td class="pl-10 py-7">до 200 м²</td>
                        <td class="pr-10 py-7 text-right font-semibold text-emerald-600">2.5 €/м²</td>
                        <td class="pr-10 py-7 text-right font-semibold text-emerald-600">4 €/м²</td>
                    </tr>
                    <tr class="price-row border-b">
                        <td class="pl-10 py-7 font-medium">Уборка коммерческих помещений Вильнюс</td>
                        <td class="pl-10 py-7">Индивидуально</td>
                        <td class="pr-10 py-7 text-right font-semibold text-emerald-600">3 €/м²</td>
                        <td class="pr-10 py-7 text-right font-semibold text-emerald-600">12 €/м²</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- BIG SEO TEXT -->
<section id="about" class="py-24 bg-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <h2 class="heading-font text-5xl text-center mb-12">Почему стоит выбрать нас для уборки после ремонта Вильнюс</h2>
        <div class="prose prose-lg max-w-4xl mx-auto text-gray-700 leading-relaxed space-y-6">
            <p>Если вам нужна качественная <strong>уборка после ремонта Вильнюс</strong> — обращайтесь в Ukrbud.lt. Мы профессионально убираем квартиры, дома и офисы после строительных и ремонтных работ. Наша команда быстро и тщательно удаляет строительную пыль, остатки краски, штукатурки, шпаклёвки и другой мусор. Мы моем окна, подоконники, потолки, плинтуса, люстры и все поверхности до идеального блеска.</p>
            
            <p>Кроме того, мы предлагаем регулярную <strong>уборку офисов Вильнюс</strong>. Чистый офис — это комфорт для сотрудников и положительное впечатление для клиентов. Мы выполняем ежедневную, еженедельную и генеральную уборку офисных помещений любого размера.</p>
            
            <p><strong>Клининг коммерческих помещений Вильнюс</strong> — ещё одно направление нашей работы. Мы обслуживаем магазины, салоны красоты, кафе, рестораны, медицинские центры и склады. Каждый объект получает индивидуальный подход и использование профессиональных эко-средств.</p>
            
            <p>Мы работаем 24/7 без выходных, принимаем только безналичный расчёт, используем современное оборудование и гарантируем высокое качество. Многие клиенты отмечают, что мы значительно лучше конкурентов по скорости, качеству и цене.</p>
            
            <p>Нужна уборка после ремонта в Вильнюсе? Звоните +370 644 74842 или оставляйте заявку на сайте. Мы оперативно свяжемся с вами и предложим лучшее решение.</p>
        </div>
    </div>
</section>

<!-- WHY US -->
<section id="why" class="py-24 bg-black text-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <h2 class="heading-font text-5xl text-center mb-12">Почему клиенты выбирают Ukrbud.lt</h2>
        <div class="grid md:grid-cols-4 gap-10 text-center">
            <div>
                <div class="text-6xl mb-4">⏱️</div>
                <h4 class="text-2xl font-medium">Выезд за 60 минут</h4>
                <p class="text-white/70 mt-3">По всему Вильнюсу и окрестностям</p>
            </div>
            <div>
                <div class="text-6xl mb-4">🌿</div>
                <h4 class="text-2xl font-medium">Экологичные средства</h4>
                <p class="text-white/70 mt-3">Безопасно для детей и животных</p>
            </div>
            <div>
                <div class="text-6xl mb-4">💳</div>
                <h4 class="text-2xl font-medium">Безналичный расчёт</h4>
                <p class="text-white/70 mt-3">Карты, перевод, Revolut</p>
            </div>
            <div>
                <div class="text-6xl mb-4">⭐</div>
                <h4 class="text-2xl font-medium">Гарантия качества</h4>
                <p class="text-white/70 mt-3">Приедем бесплатно при необходимости</p>
            </div>
        </div>
    </div>
</section>

<!-- REVIEWS -->
<section id="reviews" class="py-24 bg-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <h2 class="heading-font text-5xl text-center mb-12">Отзывы о нашей уборке</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-gray-50 p-8 rounded-3xl">
                <p class="italic">"Отличная уборка после ремонта Вильнюс! Квартира 92 м² сияла чистотой уже через 4 часа. Очень рекомендую!"</p>
                <div class="mt-6 text-sm font-medium">— Анна, Пашилайчяй</div>
            </div>
            <div class="bg-gray-50 p-8 rounded-3xl">
                <p class="italic">"Регулярная уборка офисов Вильнюс на 180 м². Всё всегда вовремя и на высшем уровне. Безналичный расчёт — очень удобно."</p>
                <div class="mt-6 text-sm font-medium">— Дмитрий, руководитель IT-компании</div>
            </div>
            <div class="bg-gray-50 p-8 rounded-3xl">
                <p class="italic">"Клининг коммерческого помещения после ремонта. Всё сделали идеально. Теперь заказываем уборку каждый месяц."</p>
                <div class="mt-6 text-sm font-medium">— Мария, владелец салона красоты</div>
            </div>
        </div>
    </div>
</section>

<!-- CONTACT FORM -->
<section id="contact" class="py-24 bg-gradient-to-br from-cyan-600 to-blue-700 text-white">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12">
        <div class="grid lg:grid-cols-2 gap-16">
            <div>
                <h2 class="heading-font text-5xl font-semibold">Оставить заявку на уборку</h2>
                <p class="mt-6 text-xl">Заполните форму ниже, и мы свяжемся с вами в течение нескольких минут</p>

                <?php if ($success): ?>
                    <div class="mt-10 bg-emerald-400 text-black p-8 rounded-3xl text-center text-2xl font-medium">✅ Заявка успешно отправлена! Спасибо, мы скоро свяжемся с вами.</div>
                <?php elseif ($error): ?>
                    <div class="mt-10 bg-red-500 p-8 rounded-3xl text-center"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST" class="mt-10 space-y-8">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <input type="text" name="name" required placeholder="Ваше имя" 
                           class="w-full bg-white/10 border border-white/30 rounded-3xl px-8 py-6 text-white placeholder-white/60 focus:outline-none">
                    <input type="tel" name="phone" required placeholder="+370 644 74842" 
                           class="w-full bg-white/10 border border-white/30 rounded-3xl px-8 py-6 text-white placeholder-white/60 focus:outline-none">
                    <textarea name="message" rows="5" placeholder="Опишите, что нужно убрать (например: уборка после ремонта квартиры...)" 
                              class="w-full bg-white/10 border border-white/30 rounded-3xl px-8 py-6 text-white placeholder-white/60 focus:outline-none"></textarea>
                    
                    <button type="submit" name="submit_order" 
                            class="w-full py-7 bg-white text-black font-bold text-2xl rounded-3xl hover:bg-cyan-300">Отправить заявку</button>
                </form>
            </div>

            <div class="flex flex-col justify-center items-center lg:items-start text-center lg:text-left">
                <div class="text-7xl flex gap-12 mb-12">
                    <a href="https://wa.me/37064474842" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="https://t.me/+37064474842" target="_blank"><i class="fa-brands fa-telegram"></i></a>
                    <a href="viber://chat?number=%2B37064474842" target="_blank"><i class="fa-brands fa-viber"></i></a>
                </div>
                <a href="tel:+37064474842" class="text-5xl font-bold hover:text-cyan-200">+370 644 74842</a>
                <p class="mt-4 text-xl">Звоните или пишите в мессенджеры</p>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-black py-16 text-white/70">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12 text-center">
        <div class="flex justify-center items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-cyan-400 rounded-3xl flex items-center justify-center text-3xl">🇺🇦</div>
            <span class="heading-font text-4xl font-semibold">ukrbud.lt</span>
        </div>
        <p>© 2025 Ukrbud.lt — Уборка после ремонта Вильнюс, уборка офисов Вильнюс, клининг коммерческих помещений</p><!-- Простой счётчик посещений (всего + уникальных) -->
<?php include 'counter.php'; ?>

    </div>
</footer>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const icon = document.getElementById('burger-icon');
        menu.classList.toggle('hidden');
        icon.classList.toggle('fa-bars');
        icon.classList.toggle('fa-xmark');
    }
    
    console.log('%c✅ Полный index.php с большим SEO-текстом готов для ukrbud.lt', 'color:#00d4ff; font-size:14px');</script>

<!-- AI Consultant Chat Widget -->
<!-- AI Consultant Chat Widget - Ukrbud.lt -->
<script src="/ai/chat.js?v=<?= time() ?>"></script>

<style>
    /* Додатковий стиль для адаптивності */
    @media (max-width: 480px) {
        #grok-chat {
            width: 100% !important;
            height: 100% !important;
            bottom: 0 !important;
            right: 0 !important;
            border-radius: 0 !important;
            max-width: 100vw !important;
        }
        #grok-chat header {
            padding: 16px 18px !important;
        }
    }
</style>

</body>
</html>
