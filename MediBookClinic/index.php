<?php
// ====================== index.php ======================
// MediBook Clinic v2.0 — Online Doctor Appointment Booking 2026
// Bootstrap 5.3 + Lucide Medical Icons + Glassmorphism + Modern Animations
// FULL VERSION | 100% JSON COMPATIBLE | NO CUTS | Ruslan Bilohash
// Переписано під "Запис до лікаря" — усі поля з content.json залишені без змін!
$json = json_decode(file_get_contents('content.json'), true);
$success = isset($_GET['success']) && $_GET['success'] == 1;
$error = isset($_GET['error']) && $_GET['error'] == 1
           ? ($json['order_form']['error_text'] ?? 'Something went wrong. Please try again.')
           : '';
// Clean phone for messengers
$clean_phone = preg_replace('/[^0-9]/', '', $json['general']['phone'] ?? '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $json['custom_code']['head'] ?? '' ?>
    <title><?= htmlspecialchars($json['meta']['title'] ?? 'Запис до лікаря онлайн') ?></title>
    <meta name="description" content="<?= htmlspecialchars($json['meta']['description'] ?? '') ?>">
    <meta name="keywords" content="<?= htmlspecialchars($json['meta']['keywords'] ?? '') ?>">
    <meta name="robots" content="<?= htmlspecialchars($json['meta']['robots'] ?? 'index, follow') ?>">
    <meta name="author" content="<?= htmlspecialchars($json['meta']['author'] ?? '') ?>">
    <meta name="theme-color" content="#14b8a6">
    <link rel="canonical" href="<?= htmlspecialchars($json['meta']['canonical'] ?? '') ?>">

    <!-- Open Graph + Twitter -->
    <meta property="og:title" content="<?= htmlspecialchars($json['og']['title'] ?? '') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($json['og']['description'] ?? '') ?>">
    <meta property="og:image" content="<?= htmlspecialchars($json['og']['image'] ?? '') ?>">
    <meta property="og:image:width" content="<?= htmlspecialchars($json['og']['image_width'] ?? '1200') ?>">
    <meta property="og:image:height" content="<?= htmlspecialchars($json['og']['image_height'] ?? '630') ?>">
    <meta property="og:url" content="<?= htmlspecialchars($json['og']['url'] ?? '') ?>">
    <meta property="og:type" content="<?= htmlspecialchars($json['og']['type'] ?? 'website') ?>">
    <meta property="og:locale" content="<?= htmlspecialchars($json['og']['locale'] ?? 'en_US') ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($json['og']['site_name'] ?? '') ?>">
    <meta name="twitter:card" content="<?= htmlspecialchars($json['twitter']['card'] ?? 'summary_large_image') ?>">
    <meta name="twitter:title" content="<?= htmlspecialchars($json['twitter']['title'] ?? '') ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($json['twitter']['description'] ?? '') ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($json['twitter']['image'] ?? '') ?>">

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons + Lucide (медичні іконки 2026) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <!-- AOS + Animate.css -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Playfair+Display:wght@700&amp;display=swap" rel="stylesheet">
    
    <!-- EXTERNAL STYLES -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="preload" href="assets/css/styles.css" as="style">
    <?= $json['custom_code']['style'] ?? '' ?>

    <style>
        :root {
            --primary: #14b8a6;
            --primary-hover: #0f766e;
            --accent: #67e8f9;
        }
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #f8fafc;
            overflow-x: hidden;
        }
        .hero-bg {
            background: linear-gradient(rgba(15,23,42,0.75), rgba(15,23,42,0.85)),
                        url('https://picsum.photos/seed/doctor-clinic-2026/2000/1200') center/cover no-repeat fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .glass {
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        .card-hover {
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .card-hover:hover {
            transform: translateY(-20px) scale(1.04);
            box-shadow: 0 30px 60px -15px rgb(20 184 166 / 0.4);
        }
        .nav-link {
            position: relative;
        }
        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background: var(--primary);
            transition: width 0.4s ease;
        }
        .nav-link:hover:after {
            width: 100%;
        }
        .btn-modern {
            padding: 14px 32px;
            border-radius: 9999px;
            font-weight: 700;
            letter-spacing: -0.02em;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .btn-modern:hover {
            transform: scale(1.08) translateY(-3px);
        }
        .section-badge {
            background: linear-gradient(90deg, #14b8a6, #67e8f9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 3px;
        }
        .service-img {
            transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .service-card:hover .service-img {
            transform: scale(1.12);
        }
        .floating-whatsapp {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        .lucide-icon { width: 28px; height: 28px; }
    </style>
</head>
<body>

    <!-- PRELOADER -->
    <div id="preloader" class="fixed inset-0 bg-white z-[9999] flex items-center justify-center">
        <div class="w-16 h-16 border-4 border-teal-600 border-t-transparent rounded-full animate-spin"></div>
    </div>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top z-50">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="#">
                <i data-lucide="stethoscope" class="text-teal-600 lucide-icon"></i>
                <span class="fs-3 fw-bold text-dark"><?= htmlspecialchars($json['header']['logo_text'] ?? 'MediBook Clinic') ?></span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto gap-4">
                    <?php foreach($json['header']['nav_items'] as $nav): ?>
                        <li class="nav-item">
                            <a class="nav-link fw-medium text-dark" href="<?= htmlspecialchars($nav['anchor'] ?? '#') ?>">
                                <?= htmlspecialchars($nav['text'] ?? '') ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Language + Phone -->
               
            </div>
        </div>
    </nav>

    <!-- MOBILE OFFCANVAS -->
    <div class="offcanvas offcanvas-end" id="mobileMenu">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Меню</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav flex-column gap-3">
                <?php foreach($json['header']['nav_items'] as $nav): ?>
                    <li><a href="<?= htmlspecialchars($nav['anchor'] ?? '#') ?>" class="text-dark text-decoration-none fs-4" data-bs-dismiss="offcanvas"><?= htmlspecialchars($nav['text'] ?? '') ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- HERO -->
    <section class="hero-bg text-white">
        <div class="container py-5" data-aos="fade-up">
            <div class="row justify-content-center text-center">
                <div class="col-lg-9">
                    <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInUp">
                        <?= htmlspecialchars($json['hero']['h1'] ?? 'ЗАПИС ДО ЛІКАРЯ ОНЛАЙН') ?>
                    </h1>
                    <p class="lead fs-3 mb-5 opacity-90">
                        <?= htmlspecialchars($json['hero']['p'] ?? '') ?>
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-4 justify-content-center">
                        <a href="#apply" class="btn btn-modern btn-lg bg-white text-teal-700 shadow-xl">
                            <i data-lucide="calendar-check" class="me-2 lucide-icon"></i>
                            <?= htmlspecialchars($json['hero']['button_order'] ?? 'Записатися зараз') ?>
                        </a>
                        <a href="tel:<?= htmlspecialchars($json['general']['phone'] ?? '') ?>" 
                           class="btn btn-modern btn-lg border border-2 border-white text-white hover:bg-white hover:text-teal-700">
                            <i data-lucide="phone-call" class="me-2 lucide-icon"></i>
                            <?= htmlspecialchars($json['hero']['button_phone'] ?? 'Подзвонити') ?>
                        </a>
                    </div>
                    <div class="mt-5 text-white-50 text-uppercase small tracking-widest">
                        <?= htmlspecialchars($json['hero']['bottom_text'] ?? '') ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICES / ДОКТОРИ ТА ПОСЛУГИ -->
    <section id="loans" class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="section-badge px-4 py-2 rounded-pill"><?= htmlspecialchars($json['services']['badge'] ?? 'НАШІ ПОСЛУГИ') ?></span>
                <h2 class="display-5 fw-bold mt-3"><?= htmlspecialchars($json['services']['h2'] ?? '') ?></h2>
                <p class="lead text-muted mt-3"><?= htmlspecialchars($json['services']['p'] ?? '') ?></p>
            </div>

            <div class="row g-4">
                <?php foreach($json['services']['items'] as $item): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100 service-card overflow-hidden card-hover" data-aos="fade-up">
                        <div class="position-relative">
                            <img src="<?= htmlspecialchars($item['image'] ?? '') ?>" class="service-img card-img-top w-100" style="height:240px;object-fit:cover" alt="">
                        </div>
                        <div class="card-body p-4">
                            <h3 class="card-title fs-4 fw-semibold"><?= htmlspecialchars($item['title'] ?? '') ?></h3>
                            <p class="text-muted"><?= htmlspecialchars($item['text'] ?? '') ?></p>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-4 pt-0">
                            <span class="text-teal-600 fw-medium"><?= htmlspecialchars($item['footer'] ?? '') ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- BENEFITS / ЧОМУ ОБИРАЮТЬ НАС -->
    <section id="benefits" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="section-badge px-4 py-2 rounded-pill"><?= htmlspecialchars($json['advantages']['badge'] ?? '') ?></span>
                <h2 class="display-5 fw-bold mt-3"><?= htmlspecialchars($json['advantages']['h2'] ?? '') ?></h2>
                <p class="lead text-muted"><?= htmlspecialchars($json['advantages']['p'] ?? '') ?></p>
            </div>
            <div class="row g-4">
                <?php foreach($json['advantages']['items'] as $adv): ?>
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <div class="glass p-5 rounded-4 h-100 card-hover">
                        <div class="display-4 mb-4"><?= $adv['emoji'] ?? '' ?></div>
                        <h3 class="fs-4 fw-semibold"><?= htmlspecialchars($adv['title'] ?? '') ?></h3>
                        <p class="text-muted"><?= htmlspecialchars($adv['text'] ?? '') ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS / ЯК ЗАПИСАТИСЯ -->
    <section id="process" class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="section-badge px-4 py-2 rounded-pill"><?= htmlspecialchars($json['how']['badge'] ?? '') ?></span>
                <h2 class="display-5 fw-bold mt-3"><?= htmlspecialchars($json['how']['h2'] ?? '') ?></h2>
            </div>
            <div class="row g-5">
                <?php foreach($json['how']['steps'] as $step): ?>
                <div class="col-md-4 text-center" data-aos="fade-up">
                    <div class="mx-auto mb-4 d-flex align-items-center justify-content-center bg-teal-100 text-teal-600 rounded-circle" 
                         style="width:90px;height:90px;font-size:2.5rem;font-weight:700">
                        <?= $step['num'] ?? '' ?>
                    </div>
                    <h4 class="fw-semibold"><?= htmlspecialchars($step['title'] ?? '') ?></h4>
                    <p class="text-muted"><?= htmlspecialchars($step['text'] ?? '') ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- GALLERY -->
    <section id="gallery" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="section-badge px-4 py-2 rounded-pill"><?= htmlspecialchars($json['gallery']['badge'] ?? '') ?></span>
                <h2 class="display-5 fw-bold mt-3"><?= htmlspecialchars($json['gallery']['h2'] ?? '') ?></h2>
            </div>
            <div class="row g-4">
                <?php foreach($json['gallery']['images'] as $img): ?>
                <div class="col-6 col-md-4" data-aos="zoom-in">
                    <img src="<?= htmlspecialchars($img['url'] ?? '') ?>" 
                         alt="<?= htmlspecialchars($img['alt'] ?? '') ?>" 
                         class="img-fluid rounded-4 shadow-sm w-100 h-100 object-fit-cover">
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- REVIEWS -->
    <section id="reviews" class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="text-teal-600 fw-bold"><?= htmlspecialchars($json['reviews']['badge'] ?? '') ?></span>
                <h2 class="display-5 fw-bold"><?= htmlspecialchars($json['reviews']['h2'] ?? '') ?></h2>
            </div>

            <div id="reviewCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php 
                    $first = true;
                    foreach($json['reviews']['items'] as $rev): 
                    ?>
                    <div class="carousel-item <?= $first ? 'active' : '' ?>">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="glass p-5 rounded-4 text-center">
                                    <div class="text-amber-400 fs-3 mb-4"><?= $rev['stars'] ?? '' ?></div>
                                    <p class="fst-italic fs-5">"<?= htmlspecialchars($rev['text'] ?? '') ?>"</p>
                                    <div class="d-flex align-items-center justify-content-center gap-3 mt-5">
                                        <div class="bg-secondary rounded-circle" style="width:48px;height:48px"></div>
                                        <div>
                                            <div class="fw-semibold"><?= htmlspecialchars($rev['name'] ?? '') ?></div>
                                            <small class="text-muted"><?= htmlspecialchars($rev['info'] ?? '') ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $first = false; endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#reviewCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#reviewCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </section>

    <!-- SEO TEXT -->
    <section class="py-5 bg-white border-top border-bottom">
        <div class="container" data-aos="fade-up">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="display-6 fw-bold"><?= htmlspecialchars($json['seo_text']['h2'] ?? '') ?></h2>
                <p class="lead text-muted mt-4"><?= htmlspecialchars($json['seo_text']['p1'] ?? '') ?></p>
                <p class="lead text-muted"><?= htmlspecialchars($json['seo_text']['p2'] ?? '') ?></p>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-5 fw-bold"><?= htmlspecialchars($json['faq']['h2'] ?? '') ?></h2>
            </div>
            <div class="accordion" id="faqAccordion">
                <?php foreach($json['faq']['items'] as $index => $faq): ?>
                <div class="accordion-item border-0 mb-3 rounded-4 overflow-hidden shadow-sm">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fs-5 fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>">
                            <?= htmlspecialchars($faq['q'] ?? '') ?>
                        </button>
                    </h2>
                    <div id="collapse<?= $index ?>" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            <?= htmlspecialchars($faq['a'] ?? '') ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- APPLICATION FORM / ЗАПИС НА ПРИЙОМ -->
    <section id="apply" class="py-5 text-white" style="background: linear-gradient(135deg, #0f766e, #14b8a6);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5" data-aos="fade-up">
                        <h2 class="display-5 fw-bold"><?= htmlspecialchars($json['order_form']['h2'] ?? '') ?></h2>
                        <p class="lead opacity-75"><?= htmlspecialchars($json['order_form']['p'] ?? '') ?></p>
                    </div>

                    <?php if ($success): ?>
                        <div class="alert alert-success text-center p-5 rounded-4 animate__animated animate__bounceIn" data-aos="fade-up">
                            <i data-lucide="check-circle" class="display-1 mb-3"></i>
                            <h3><?= htmlspecialchars($json['order_form']['success_title'] ?? 'Дякуємо!') ?></h3>
                            <p><?= htmlspecialchars($json['order_form']['success_text'] ?? 'Ми зв’яжемося з вами протягом 15 хвилин.') ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if ($error): ?>
                        <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form method="POST" action="submit.php" class="row g-4" data-aos="fade-up">
                        <div class="col-md-6">
                            <label class="form-label text-white"><?= htmlspecialchars($json['order_form']['labels']['name'] ?? 'ПІБ') ?></label>
                            <input type="text" name="name" required class="form-control form-control-lg bg-white/10 border-0 text-white placeholder-white">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white"><?= htmlspecialchars($json['order_form']['labels']['phone'] ?? 'Телефон') ?></label>
                            <input type="tel" name="phone" required class="form-control form-control-lg bg-white/10 border-0 text-white placeholder-white">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-white"><?= htmlspecialchars($json['order_form']['labels']['message'] ?? 'Бажана дата та спеціальність') ?></label>
                            <textarea name="message" rows="5" class="form-control form-control-lg bg-white/10 border-0 text-white placeholder-white"></textarea>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-modern btn-light text-teal-700 px-5 py-4 fs-5 shadow-2xl">
                                <i data-lucide="calendar-plus" class="me-3 lucide-icon"></i>
                                ЗАПИСАТИСЯ НА ПРИЙОМ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACTS BAR -->
    <div class="bg-white py-4 border-top">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-center gap-5 text-center">
                <a href="tel:<?= htmlspecialchars($json['general']['phone'] ?? '') ?>" class="d-flex align-items-center gap-3 text-dark text-decoration-none">
                    <i data-lucide="phone-call" class="fs-3"></i>
                    <span><?= htmlspecialchars($json['general']['phone'] ?? '') ?></span>
                </a>
                <a href="https://wa.me/<?= $clean_phone ?>" target="_blank" class="d-flex align-items-center gap-3 text-dark text-decoration-none">
                    <i data-lucide="message-circle" class="fs-3 text-success"></i>
                    <span>WhatsApp</span>
                </a>
                <a href="viber://chat?number=<?= $clean_phone ?>" target="_blank" class="d-flex align-items-center gap-3 text-dark text-decoration-none">
                    <i data-lucide="phone" class="fs-3 text-purple-500"></i>
                    <span>Viber</span>
                </a>
                <a href="https://t.me/+<?= $clean_phone ?>" target="_blank" class="d-flex align-items-center gap-3 text-dark text-decoration-none">
                    <i data-lucide="send" class="fs-3 text-info"></i>
                    <span>Telegram</span>
                </a>
                <a href="mailto:<?= htmlspecialchars($json['general']['email'] ?? '') ?>" class="d-flex align-items-center gap-3 text-dark text-decoration-none">
                    <i data-lucide="mail" class="fs-3"></i>
                    <span><?= htmlspecialchars($json['general']['email'] ?? '') ?></span>
                </a>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <i data-lucide="stethoscope" class="text-teal-400 lucide-icon"></i>
                        <span class="fs-3 fw-bold"><?= htmlspecialchars($json['general']['site_name'] ?? 'MediBook Clinic') ?></span>
                    </div>
                    <p class="text-white-50"><?= htmlspecialchars($json['footer']['about'] ?? '') ?></p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5 class="text-teal-400 mb-3">КОНТАКТИ</h5>
                    <div class="text-white-50">
                        <div><i data-lucide="map-pin" class="me-2"></i> <?= htmlspecialchars($json['general']['address'] ?? '') ?></div>
                        <a href="tel:<?= htmlspecialchars($json['general']['phone'] ?? '') ?>" class="d-block text-white-50"><?= htmlspecialchars($json['general']['phone'] ?? '') ?></a>
                        <a href="mailto:<?= htmlspecialchars($json['general']['email'] ?? '') ?>" class="d-block text-white-50"><?= htmlspecialchars($json['general']['email'] ?? '') ?></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h5 class="text-teal-400 mb-3">МИ ПРАЦЮЄМО В УСІХ РАЙОНАХ</h5>
                    <div class="text-white-50"><?= htmlspecialchars($json['footer']['districts'] ?? '') ?></div>
                </div>
            </div>
            <div class="border-top border-white-10 pt-4 mt-5 text-center text-white-50 small">
                <p>Made with ❤️ <a href="https://bilohash.com" target="_blank" class="text-white">Ruslan Bilohash</a></p>
                <p><?= htmlspecialchars($json['footer']['copyright'] ?? '') ?></p>
                <?= $json['custom_code']['footer_html'] ?? '' ?>
            </div>
        </div>
    </footer>

    <!-- FLOATING WHATSAPP -->
    <a href="https://wa.me/<?= $clean_phone ?>" target="_blank" 
       class="floating-whatsapp position-fixed bottom-0 end-0 m-4 bg-success text-white rounded-circle d-flex align-items-center justify-content-center shadow-lg"
       style="width:68px;height:68px;font-size:32px;z-index:9999">
        <i data-lucide="message-circle"></i>
    </a>

    <!-- SCHEMA.ORG (залишено без змін) -->
    <script type="application/ld+json">
    <?= json_encode([
        "@context" => "https://schema.org",
        "@type" => "FinancialService",
        "name" => $json['schema']['name'] ?? '',
        "description" => $json['schema']['description'] ?? '',
        "url" => $json['schema']['url'] ?? '',
        "telephone" => $json['schema']['telephone'] ?? '',
        "address" => [
            "@type" => "PostalAddress",
            "streetAddress" => $json['schema']['streetAddress'] ?? '',
            "addressLocality" => $json['schema']['addressLocality'] ?? '',
            "addressCountry" => $json['schema']['addressCountry'] ?? ''
        ],
        "openingHours" => $json['schema']['openingHours'] ?? '',
        "priceRange" => $json['schema']['priceRange'] ?? '',
        "aggregateRating" => [
            "@type" => "AggregateRating",
            "ratingValue" => $json['schema']['ratingValue'] ?? '5',
            "reviewCount" => $json['schema']['reviewCount'] ?? '100'
        ],
        "image" => $json['schema']['image'] ?? ''
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
    </script>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Lucide Icons (медичні)
        lucide.createIcons();

        // AOS
        AOS.init({ once: true, duration: 900 });

        // Preloader
        window.addEventListener('load', () => {
            const preloader = document.getElementById('preloader');
            preloader.style.opacity = '0';
            setTimeout(() => preloader.style.display = 'none', 700);
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                if (this.getAttribute('href') !== '#') {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
    <script src="assets/js/main.js" defer></script>
    <?= $json['custom_code']['js'] ?? '' ?>
</body>
</html>