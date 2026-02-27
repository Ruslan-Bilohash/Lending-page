<?php
// ====================== 404.php ======================
// Красива сторінка помилки 404 з автоматичною переадресацією на головну
// Автор: Ruslan Bilohash | bilohash.com

header("HTTP/1.1 404 Not Found");
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Сторінку не знайдено | Клінінг Вільнюс</title>
    <meta name="robots" content="noindex, nofollow">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Playfair+Display:wght@700&amp;display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Playfair+Display:wght@700&amp;display=swap');
        body { font-family: 'Inter', sans-serif; }
        .hero-404 { 
            background: linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)), 
                        url('https://picsum.photos/seed/cleaning-404-vilnius/2000/1200') center/cover no-repeat; 
        }
        .countdown { font-size: 4.5rem; font-weight: 700; color: #10b981; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">

    <!-- HEADER -->
    <header class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-broom text-4xl text-emerald-600"></i>
                <span class="text-3xl font-bold tracking-tight">КЛІНІНГ ВІЛЬНЮС</span>
            </div>
            <a href="index.php" class="text-emerald-600 hover:text-emerald-700 font-medium">На головну</a>
        </div>
    </header>

    <!-- 404 HERO -->
    <section class="hero-404 h-screen flex items-center text-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <div class="inline-flex items-center gap-4 bg-white/10 backdrop-blur-md px-8 py-3 rounded-3xl mb-8">
                <i class="fa-solid fa-triangle-exclamation text-4xl"></i>
                <span class="text-2xl font-semibold tracking-widest">404 ERROR</span>
            </div>

            <h1 class="text-8xl md:text-[10rem] font-bold leading-none tracking-tighter mb-6">404</h1>
            
            <h2 class="text-5xl md:text-6xl font-bold mb-6">Сторінку не знайдено</h2>
            
            <p class="text-2xl md:text-3xl max-w-2xl mx-auto mb-12 opacity-90">
                На жаль, сторінка, яку ви шукали, не існує або була переміщена.
            </p>

            <!-- Таймер -->
            <div class="mb-12">
                <p class="text-xl mb-3">Автоматично перенаправимо вас на головну через</p>
                <div id="countdown" class="countdown">8</div>
                <p class="text-sm uppercase tracking-widest mt-2">секунд</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="index.php" 
                   class="bg-white text-emerald-700 hover:bg-emerald-100 font-bold text-xl px-12 py-6 rounded-3xl inline-flex items-center gap-3 transition shadow-2xl">
                    <i class="fa-solid fa-house"></i> Повернутися на головну
                </a>
                <a href="tel:+37064474842" 
                   class="border-2 border-white hover:bg-white hover:text-gray-900 text-white text-xl font-semibold px-12 py-6 rounded-3xl inline-flex items-center gap-3 transition">
                    <i class="fa-solid fa-phone"></i> Зателефонувати нам
                </a>
            </div>

            <div class="mt-16 text-sm opacity-75">
                © 2026 Клінінг Вільнюс — Професійна уборка у Вільнюсі
            </div>
        </div>
    </section>

    <script>
        // Автоматична переадресація через 8 секунд
        let timeLeft = 8;
        const countdownEl = document.getElementById('countdown');

        const timer = setInterval(() => {
            timeLeft--;
            countdownEl.textContent = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(timer);
                window.location.href = "index.php";
            }
        }, 1000);

        // Якщо користувач клікне на кнопку — скасовуємо таймер
        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => clearInterval(timer));
        });
    </script>
</body>
</html>