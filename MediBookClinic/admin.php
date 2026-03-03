<?php
// ====================== admin.php ======================
// Admin Panel — Your Site PRO v1.0 (FULL VERSION)
// Author: Ruslan Bilohash | bilohash.com | 2026
// Повністю цілий файл без скорочень — всі функції JavaScript написані повністю

session_start();

// Зміни пароль тут перед запуском!
$password = 'admin123';

if (!isset($_SESSION['admin_logged'])) {
    if (isset($_POST['password']) && $_POST['password'] === $password) {
        $_SESSION['admin_logged'] = true;
    } else {
        echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Admin Login</title><script src="https://cdn.tailwindcss.com"></script></head><body class="bg-gray-900 text-white flex items-center justify-center min-h-screen"><form method="post" class="bg-gray-800 p-12 rounded-3xl w-96"><h1 class="text-3xl font-bold mb-8 text-center">Admin Panel Login</h1><input type="password" name="password" placeholder="Password" class="w-full bg-gray-700 px-6 py-4 rounded-2xl mb-6"><button type="submit" class="w-full bg-emerald-600 py-4 rounded-2xl font-bold">LOGIN</button></form></body></html>';
        exit;
    }
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

$file = 'content.json';
$data = json_decode(file_get_contents($file), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $newData = json_decode($_POST['json_data'], true);
    if ($newData) {
        file_put_contents($file, json_encode($newData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        $success = "✅ ALL CHANGES SAVED!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel — Your Site PRO v1.0</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .tab-link.active { background-color: rgb(16 185 129); color: white; }
        .sidebar { transition: transform 0.3s ease-in-out; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
        }
    </style>
</head>
<body class="bg-gray-950 text-white">
<div class="flex h-screen overflow-hidden">
    <!-- MOBILE TOP BAR -->
    <div class="md:hidden fixed top-0 left-0 right-0 bg-gray-900 border-b border-gray-800 z-50 px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-broom text-3xl text-emerald-500"></i>
            <span class="text-2xl font-bold">Your Site PRO</span>
        </div>
        <button onclick="toggleSidebar()" class="text-3xl p-2"><i class="fa-solid fa-bars"></i></button>
    </div>

    <!-- SIDEBAR -->
    <div id="sidebar" class="sidebar w-72 bg-gray-900 p-6 overflow-y-auto border-r border-gray-800 md:relative fixed inset-y-0 left-0 z-50">
        <div class="flex items-center gap-3 mb-10">
            <i class="fa-solid fa-broom text-4xl text-emerald-500"></i>
            <span class="text-3xl font-bold">Your Site PRO</span>
        </div>
        <nav class="space-y-1">
            <a href="#" onclick="switchTab('general')" class="tab-link flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-emerald-600 active"><i class="fa-solid fa-cog"></i> General</a>
            <a href="#" onclick="switchTab('header')" class="tab-link flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-emerald-600"><i class="fa-solid fa-heading"></i> Header</a>
            <a href="#" onclick="switchTab('meta')" class="tab-link flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-emerald-600"><i class="fa-solid fa-tag"></i> Meta Tags</a>
            <a href="#" onclick="switchTab('og')" class="tab-link flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-emerald-600"><i class="fa-solid fa-share-alt"></i> OG + Twitter</a>
            <a href="#" onclick="switchTab('hero')" class="tab-link flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-emerald-600"><i class="fa-solid fa-home"></i> Hero</a>
            <a href="#" onclick="switchTab('services')" class="tab-link flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-emerald-600"><i class="fa-solid fa-list"></i> Services</a>
            <a href="#" onclick="switchTab('advantages')" class="tab-link flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-emerald-600"><i class="fa-solid fa-star"></i> Advantages</a>
            <a href="#" onclick="switchTab('how')" class="tab-link flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-emerald-600"><i class="fa-solid fa-clock"></i> How We Work</a>
            <a href="#" onclick="switchTab('gallery')" class="tab-link flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-emerald-600"><i class="fa-solid fa-images"></i> Gallery</a>
            <a href="#" onclick="switchTab('reviews')" class="tab-link flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-emerald-600"><i class="fa-solid fa-comment-dots"></i> Reviews</a>
            <a href="#" onclick="switchTab('seo_text')" class="tab-link flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-emerald-600"><i class="fa-solid fa-text-height"></i> SEO Text</a>
            <a href="#" onclick="switchTab('faq')" class="tab-link flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-emerald-600"><i class="fa-solid fa-question-circle"></i> FAQ</a>
            <a href="#" onclick="switchTab('order_form')" class="tab-link flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-emerald-600"><i class="fa-solid fa-envelope"></i> Order Form</a>
            <a href="#" onclick="switchTab('footer')" class="tab-link flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-emerald-600"><i class="fa-solid fa-footer"></i> Footer + Schema</a>
            <a href="#" onclick="switchTab('custom')" class="tab-link flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-emerald-600 text-emerald-400 font-bold"><i class="fa-solid fa-code"></i> Custom Code</a>
            <a href="#" onclick="switchTab('email')" class="tab-link flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-emerald-600"><i class="fa-solid fa-envelope"></i> Email Settings</a>

            <center><a href="?logout=1" onclick="return confirm('Logout from admin panel?')" class="mt-8 md:flex items-center gap-2 bg-red-600 hover:bg-red-700 px-5 py-2.5 rounded-2xl text-sm font-medium">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a></center>
        </nav>
    </div>

    <!-- MAIN CONTENT -->
    <div class="flex-1 overflow-y-auto pt-16 md:pt-0 p-6 md:p-10">
        <?php if(isset($success)): ?><div class="bg-emerald-600 p-4 rounded-2xl mb-8"><?= $success ?></div><?php endif; ?>
        <form method="POST" id="adminForm">
            <input type="hidden" name="json_data" id="jsonData">
            <button type="submit" name="save" onclick="prepareJSON()" class="fixed bottom-6 right-6 md:bottom-8 md:right-8 bg-emerald-600 hover:bg-emerald-700 px-10 py-5 rounded-3xl text-lg font-bold shadow-2xl flex items-center gap-3 z-50">
                <i class="fa-solid fa-save"></i> SAVE ALL CHANGES
            </button>

            <!-- TAB GENERAL -->
            <div id="tab-general" class="tab-content active">
                <h2 class="text-4xl font-bold mb-8">General Settings</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div><label class="block text-sm mb-2">Phone</label><input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl" value="<?= htmlspecialchars($data['general']['phone'] ?? '') ?>" onchange="updateData('general.phone', this.value)"></div>
                    <div><label class="block text-sm mb-2">Email</label><input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl" value="<?= htmlspecialchars($data['general']['email'] ?? '') ?>" onchange="updateData('general.email', this.value)"></div>
                    <div><label class="block text-sm mb-2">Address</label><input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl" value="<?= htmlspecialchars($data['general']['address'] ?? '') ?>" onchange="updateData('general.address', this.value)"></div>
                    <div><label class="block text-sm mb-2">Site Name (footer)</label><input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl" value="<?= htmlspecialchars($data['general']['site_name'] ?? '') ?>" onchange="updateData('general.site_name', this.value)"></div>
                    <div><label class="block text-sm mb-2">Year</label><input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl" value="<?= htmlspecialchars($data['general']['year'] ?? '') ?>" onchange="updateData('general.year', this.value)"></div>
                </div>
            </div>

            <!-- TAB HEADER -->
            <div id="tab-header" class="tab-content">
                <h2 class="text-4xl font-bold mb-8">Site Header</h2>
                <div class="space-y-8">
                    <div>
                        <label class="block text-sm mb-2">Logo Text</label>
                        <input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl text-2xl font-bold"
                               value="<?= htmlspecialchars($data['header']['logo_text'] ?? '') ?>"
                               onchange="updateData('header.logo_text', this.value)">
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-4 flex items-center gap-2"><i class="fa-solid fa-list"></i> Navigation Items</h3>
                        <div id="nav-container" class="space-y-6"></div>
                        <button type="button" onclick="addNavItem()" class="mt-6 bg-emerald-600 hover:bg-emerald-700 px-8 py-4 rounded-3xl flex items-center gap-2">
                            <i class="fa-solid fa-plus"></i> Add Menu Item
                        </button>
                    </div>
                </div>
            </div>

            <!-- TAB META -->
            <div id="tab-meta" class="tab-content">
                <h2 class="text-4xl font-bold mb-8">Meta Tags</h2>
                <div class="space-y-6">
                    <div><label class="block text-sm mb-2">Title</label><input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl" value="<?= htmlspecialchars($data['meta']['title'] ?? '') ?>" onchange="updateData('meta.title', this.value)"></div>
                    <div><label class="block text-sm mb-2">Description</label><textarea class="w-full bg-gray-800 px-6 py-4 rounded-2xl h-32" onchange="updateData('meta.description', this.value)"><?= htmlspecialchars($data['meta']['description'] ?? '') ?></textarea></div>
                    <div><label class="block text-sm mb-2">Keywords</label><textarea class="w-full bg-gray-800 px-6 py-4 rounded-2xl h-32" onchange="updateData('meta.keywords', this.value)"><?= htmlspecialchars($data['meta']['keywords'] ?? '') ?></textarea></div>
                    <div class="grid grid-cols-2 gap-6">
                        <div><label class="block text-sm mb-2">Robots</label><input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl" value="<?= htmlspecialchars($data['meta']['robots'] ?? '') ?>" onchange="updateData('meta.robots', this.value)"></div>
                        <div><label class="block text-sm mb-2">Author</label><input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl" value="<?= htmlspecialchars($data['meta']['author'] ?? '') ?>" onchange="updateData('meta.author', this.value)"></div>
                    </div>
                </div>
            </div>

            <!-- TAB OG -->
            <div id="tab-og" class="tab-content">
                <h2 class="text-4xl font-bold mb-8">Open Graph + Twitter</h2>
                <div class="space-y-6">
                    <div><label class="block text-sm mb-2">og:title</label><input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl" value="<?= htmlspecialchars($data['og']['title'] ?? '') ?>" onchange="updateData('og.title', this.value)"></div>
                    <div><label class="block text-sm mb-2">og:description</label><textarea class="w-full bg-gray-800 px-6 py-4 rounded-2xl h-24" onchange="updateData('og.description', this.value)"><?= htmlspecialchars($data['og']['description'] ?? '') ?></textarea></div>
                    <div><label class="block text-sm mb-2">og:image</label><input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl" value="<?= htmlspecialchars($data['og']['image'] ?? '') ?>" onchange="updateData('og.image', this.value)"></div>
                    <div><label class="block text-sm mb-2">twitter:title</label><input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl" value="<?= htmlspecialchars($data['twitter']['title'] ?? '') ?>" onchange="updateData('twitter.title', this.value)"></div>
                    <div><label class="block text-sm mb-2">twitter:description</label><textarea class="w-full bg-gray-800 px-6 py-4 rounded-2xl h-24" onchange="updateData('twitter.description', this.value)"><?= htmlspecialchars($data['twitter']['description'] ?? '') ?></textarea></div>
                    <div><label class="block text-sm mb-2">twitter:image</label><input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl" value="<?= htmlspecialchars($data['twitter']['image'] ?? '') ?>" onchange="updateData('twitter.image', this.value)"></div>
                </div>
            </div>

            <!-- TAB HERO -->
            <div id="tab-hero" class="tab-content">
                <h2 class="text-4xl font-bold mb-8">Hero Section</h2>
                <div class="space-y-6">
                    <div><label class="block text-sm mb-2">H1</label><input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl" value="<?= htmlspecialchars($data['hero']['h1'] ?? '') ?>" onchange="updateData('hero.h1', this.value)"></div>
                    <div><label class="block text-sm mb-2">Text</label><textarea class="w-full bg-gray-800 px-6 py-4 rounded-2xl h-32" onchange="updateData('hero.p', this.value)"><?= htmlspecialchars($data['hero']['p'] ?? '') ?></textarea></div>
                    <div class="grid grid-cols-2 gap-6">
                        <div><label class="block text-sm mb-2">Order Button</label><input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl" value="<?= htmlspecialchars($data['hero']['button_order'] ?? '') ?>" onchange="updateData('hero.button_order', this.value)"></div>
                        <div><label class="block text-sm mb-2">Phone Button</label><input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl" value="<?= htmlspecialchars($data['hero']['button_phone'] ?? '') ?>" onchange="updateData('hero.button_phone', this.value)"></div>
                    </div>
                </div>
            </div>

            <!-- TAB SERVICES -->
            <div id="tab-services" class="tab-content">
                <h2 class="text-4xl font-bold mb-8">Services</h2>
                <div id="services-container" class="space-y-8"></div>
                <button type="button" onclick="addService()" class="mt-6 bg-emerald-600 px-8 py-4 rounded-3xl flex items-center gap-2"><i class="fa-solid fa-plus"></i> Add Service</button>
            </div>

            <!-- TAB ADVANTAGES -->
            <div id="tab-advantages" class="tab-content">
                <h2 class="text-4xl font-bold mb-8">Advantages</h2>
                <div id="advantages-container" class="space-y-8"></div>
                <button type="button" onclick="addAdvantage()" class="mt-6 bg-emerald-600 px-8 py-4 rounded-3xl flex items-center gap-2"><i class="fa-solid fa-plus"></i> Add Advantage</button>
            </div>

            <!-- TAB HOW -->
            <div id="tab-how" class="tab-content">
                <h2 class="text-4xl font-bold mb-8">How We Work</h2>
                <div id="how-container" class="space-y-8"></div>
                <button type="button" onclick="addHowStep()" class="mt-6 bg-emerald-600 px-8 py-4 rounded-3xl flex items-center gap-2"><i class="fa-solid fa-plus"></i> Add Step</button>
            </div>

            <!-- TAB GALLERY -->
            <div id="tab-gallery" class="tab-content">
                <h2 class="text-4xl font-bold mb-8">Gallery</h2>
                <div id="gallery-container" class="space-y-8"></div>
                <button type="button" onclick="addGalleryImage()" class="mt-6 bg-emerald-600 px-8 py-4 rounded-3xl flex items-center gap-2"><i class="fa-solid fa-plus"></i> Add Photo</button>
            </div>

            <!-- TAB REVIEWS -->
            <div id="tab-reviews" class="tab-content">
                <h2 class="text-4xl font-bold mb-8">Reviews</h2>
                <div id="reviews-container" class="space-y-8"></div>
                <button type="button" onclick="addReview()" class="mt-6 bg-emerald-600 px-8 py-4 rounded-3xl flex items-center gap-2"><i class="fa-solid fa-plus"></i> Add Review</button>
            </div>

            <!-- TAB SEO TEXT -->
            <div id="tab-seo_text" class="tab-content">
                <h2 class="text-4xl font-bold mb-8">SEO Text</h2>
                <div class="space-y-6">
                    <div><label class="block text-sm mb-2">H2</label><input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl" value="<?= htmlspecialchars($data['seo_text']['h2'] ?? '') ?>" onchange="updateData('seo_text.h2', this.value)"></div>
                    <div><label class="block text-sm mb-2">Paragraph 1</label><textarea class="w-full bg-gray-800 px-6 py-4 rounded-2xl h-32" onchange="updateData('seo_text.p1', this.value)"><?= htmlspecialchars($data['seo_text']['p1'] ?? '') ?></textarea></div>
                    <div><label class="block text-sm mb-2">Paragraph 2</label><textarea class="w-full bg-gray-800 px-6 py-4 rounded-2xl h-32" onchange="updateData('seo_text.p2', this.value)"><?= htmlspecialchars($data['seo_text']['p2'] ?? '') ?></textarea></div>
                </div>
            </div>

            <!-- TAB FAQ -->
            <div id="tab-faq" class="tab-content">
                <h2 class="text-4xl font-bold mb-8">FAQ</h2>
                <div id="faq-container" class="space-y-8"></div>
                <button type="button" onclick="addFaq()" class="mt-6 bg-emerald-600 px-8 py-4 rounded-3xl flex items-center gap-2"><i class="fa-solid fa-plus"></i> Add Question</button>
            </div>

            <!-- TAB ORDER FORM -->
            <div id="tab-order_form" class="tab-content">
                <h2 class="text-4xl font-bold mb-8">Order Form</h2>
                <div class="space-y-6">
                    <div><label class="block text-sm mb-2">H2</label><input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl" value="<?= htmlspecialchars($data['order_form']['h2'] ?? '') ?>" onchange="updateData('order_form.h2', this.value)"></div>
                    <div><label class="block text-sm mb-2">Subtitle</label><input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl" value="<?= htmlspecialchars($data['order_form']['p'] ?? '') ?>" onchange="updateData('order_form.p', this.value)"></div>
                    <div><label class="block text-sm mb-2">Success Title</label><input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl" value="<?= htmlspecialchars($data['order_form']['success_title'] ?? '') ?>" onchange="updateData('order_form.success_title', this.value)"></div>
                    <div><label class="block text-sm mb-2">Success Text</label><input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl" value="<?= htmlspecialchars($data['order_form']['success_text'] ?? '') ?>" onchange="updateData('order_form.success_text', this.value)"></div>
                    <div><label class="block text-sm mb-2">Error Text</label><input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl" value="<?= htmlspecialchars($data['order_form']['error_text'] ?? '') ?>" onchange="updateData('order_form.error_text', this.value)"></div>
                </div>
            </div>

            <!-- TAB FOOTER -->
            <div id="tab-footer" class="tab-content">
                <h2 class="text-4xl font-bold mb-8">Footer + Schema</h2>
                <div class="space-y-6">
                    <div><label class="block text-sm mb-2">About</label><textarea class="w-full bg-gray-800 px-6 py-4 rounded-2xl h-32" onchange="updateData('footer.about', this.value)"><?= htmlspecialchars($data['footer']['about'] ?? '') ?></textarea></div>
                    <div><label class="block text-sm mb-2">Districts</label><textarea class="w-full bg-gray-800 px-6 py-4 rounded-2xl h-32" onchange="updateData('footer.districts', this.value)"><?= htmlspecialchars($data['footer']['districts'] ?? '') ?></textarea></div>
                    <div><label class="block text-sm mb-2">Copyright</label><input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl" value="<?= htmlspecialchars($data['footer']['copyright'] ?? '') ?>" onchange="updateData('footer.copyright', this.value)"></div>
                </div>
            </div>

            <!-- TAB CUSTOM CODE -->
            <div id="tab-custom" class="tab-content">
                <h2 class="text-4xl font-bold mb-8">Custom Code</h2>
                <div class="space-y-8">
                    <div>
                        <label class="block text-sm mb-2">Code in &lt;head&gt;</label>
                        <textarea class="w-full bg-gray-800 px-6 py-4 rounded-2xl h-48 font-mono" onchange="updateData('custom_code.head', this.value)"><?= htmlspecialchars($data['custom_code']['head'] ?? '') ?></textarea>
                    </div>
                    <div>
                        <label class="block text-sm mb-2">Additional CSS</label>
                        <textarea class="w-full bg-gray-800 px-6 py-4 rounded-2xl h-48 font-mono" onchange="updateData('custom_code.style', this.value)"><?= htmlspecialchars($data['custom_code']['style'] ?? '') ?></textarea>
                    </div>
                    <div>
                        <label class="block text-sm mb-2">Additional JavaScript</label>
                        <textarea class="w-full bg-gray-800 px-6 py-4 rounded-2xl h-48 font-mono" onchange="updateData('custom_code.js', this.value)"><?= htmlspecialchars($data['custom_code']['js'] ?? '') ?></textarea>
                    </div>
                    <div>
                        <label class="block text-sm mb-2">HTML before &lt;/body&gt;</label>
                        <textarea class="w-full bg-gray-800 px-6 py-4 rounded-2xl h-32" onchange="updateData('custom_code.footer_html', this.value)"><?= htmlspecialchars($data['custom_code']['footer_html'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- TAB EMAIL SETTINGS -->
            <div id="tab-email" class="tab-content">
                <h2 class="text-4xl font-bold mb-8">Email Settings</h2>
                <div class="space-y-6 max-w-2xl">
                    <div>
                        <label class="block text-sm mb-2 font-medium">Recipient (to)</label>
                        <input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl"
                               value="<?= htmlspecialchars($data['email_settings']['recipient'] ?? 'info@your-site.com') ?>"
                               onchange="updateData('email_settings.recipient', this.value)">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm mb-2 font-medium">From Email</label>
                            <input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl"
                                   value="<?= htmlspecialchars($data['email_settings']['from_email'] ?? '') ?>"
                                   onchange="updateData('email_settings.from_email', this.value)">
                        </div>
                        <div>
                            <label class="block text-sm mb-2 font-medium">From Name</label>
                            <input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl"
                                   value="<?= htmlspecialchars($data['email_settings']['from_name'] ?? '') ?>"
                                   onchange="updateData('email_settings.from_name', this.value)">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm mb-2 font-medium">Subject Prefix</label>
                        <input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl"
                               value="<?= htmlspecialchars($data['email_settings']['subject_prefix'] ?? '') ?>"
                               onchange="updateData('email_settings.subject_prefix', this.value)">
                    </div>
                    <div>
                        <label class="block text-sm mb-2 font-medium">Company Name in Email</label>
                        <input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl"
                               value="<?= htmlspecialchars($data['email_settings']['company_name'] ?? '') ?>"
                               onchange="updateData('email_settings.company_name', this.value)">
                    </div>
                    <div>
                        <label class="block text-sm mb-2 font-medium">City in Email</label>
                        <input type="text" class="w-full bg-gray-800 px-6 py-4 rounded-2xl"
                               value="<?= htmlspecialchars($data['email_settings']['city'] ?? '') ?>"
                               onchange="updateData('email_settings.city', this.value)">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
let globalData = <?= json_encode($data, JSON_UNESCAPED_UNICODE) ?>;

function updateData(path, value) {
    let keys = path.split('.');
    let obj = globalData;
    for (let i = 0; i < keys.length - 1; i++) obj = obj[keys[i]];
    obj[keys[keys.length-1]] = value;
}

function prepareJSON() {
    document.getElementById('jsonData').value = JSON.stringify(globalData);
}

function switchTab(tab) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.add('active');
    document.querySelectorAll('.tab-link').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.tab-link').forEach(el => {
        if (el.getAttribute('onclick').includes("'" + tab + "'")) el.classList.add('active');
    });
}

function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
}

// NAV
function renderNav() {
    const c = document.getElementById('nav-container');
    c.innerHTML = '';
    globalData.header.nav_items.forEach((item, i) => {
        const div = document.createElement('div');
        div.className = 'bg-gray-800 p-6 rounded-3xl';
        div.innerHTML = `
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs text-gray-400 mb-1">Text</label>
                    <input type="text" value="${item.text||''}" placeholder="Services"
                           class="bg-gray-900 px-5 py-3 rounded-2xl w-full"
                           onchange="globalData.header.nav_items[${i}].text=this.value">
                </div>
                <div>
                    <label class="block text-xs text-gray-400 mb-1">Anchor (#services)</label>
                    <input type="text" value="${item.anchor||''}" placeholder="#services"
                           class="bg-gray-900 px-5 py-3 rounded-2xl w-full"
                           onchange="globalData.header.nav_items[${i}].anchor=this.value">
                </div>
            </div>
            <button onclick="removeNav(${i})" class="mt-4 text-red-500 hover:text-red-600 flex items-center gap-1">
                <i class="fa-solid fa-trash"></i> Remove Item
            </button>
        `;
        c.appendChild(div);
    });
}
function addNavItem() {
    globalData.header.nav_items.push({text: '', anchor: ''});
    renderNav();
}
function removeNav(i) {
    globalData.header.nav_items.splice(i, 1);
    renderNav();
}

// SERVICES
function renderServices() {
    const c = document.getElementById('services-container');
    c.innerHTML = '';
    globalData.services.items.forEach((item, i) => {
        const div = document.createElement('div');
        div.className = 'bg-gray-800 p-6 rounded-3xl';
        div.innerHTML = `
            <input type="text" value="${item.image||''}" placeholder="Image URL" class="bg-gray-900 px-5 py-3 rounded-2xl w-full" onchange="globalData.services.items[${i}].image=this.value">
            <input type="text" value="${item.title||''}" placeholder="Title" class="bg-gray-900 px-5 py-3 rounded-2xl w-full mt-3" onchange="globalData.services.items[${i}].title=this.value">
            <textarea class="w-full bg-gray-900 px-5 py-3 rounded-2xl h-32 mt-3" onchange="globalData.services.items[${i}].text=this.value">${item.text||''}</textarea>
            <input type="text" value="${item.footer||''}" placeholder="Footer text" class="bg-gray-900 px-5 py-3 rounded-2xl w-full mt-3" onchange="globalData.services.items[${i}].footer=this.value">
            <button onclick="removeService(${i})" class="mt-4 text-red-500">Remove</button>
        `;
        c.appendChild(div);
    });
}
function addService() { 
    globalData.services.items.push({image:'',title:'',text:'',footer:''}); 
    renderServices(); 
}
function removeService(i) { 
    globalData.services.items.splice(i,1); 
    renderServices(); 
}

// ADVANTAGES
function renderAdvantages() {
    const c = document.getElementById('advantages-container');
    c.innerHTML = '';
    globalData.advantages.items.forEach((item, i) => {
        const div = document.createElement('div');
        div.className = 'bg-gray-800 p-6 rounded-3xl';
        div.innerHTML = `
            <input type="text" value="${item.emoji||''}" placeholder="Emoji" class="bg-gray-900 px-5 py-3 rounded-2xl w-full" onchange="globalData.advantages.items[${i}].emoji=this.value">
            <input type="text" value="${item.title||''}" placeholder="Title" class="bg-gray-900 px-5 py-3 rounded-2xl w-full mt-3" onchange="globalData.advantages.items[${i}].title=this.value">
            <textarea class="w-full bg-gray-900 px-5 py-3 rounded-2xl h-24 mt-3" onchange="globalData.advantages.items[${i}].text=this.value">${item.text||''}</textarea>
            <button onclick="removeAdvantage(${i})" class="mt-4 text-red-500">Remove</button>
        `;
        c.appendChild(div);
    });
}
function addAdvantage() { 
    globalData.advantages.items.push({emoji:'',title:'',text:''}); 
    renderAdvantages(); 
}
function removeAdvantage(i) { 
    globalData.advantages.items.splice(i,1); 
    renderAdvantages(); 
}

// HOW WE WORK
function renderHow() {
    const c = document.getElementById('how-container');
    c.innerHTML = '';
    globalData.how.steps.forEach((item, i) => {
        const div = document.createElement('div');
        div.className = 'bg-gray-800 p-6 rounded-3xl';
        div.innerHTML = `
            <input type="text" value="${item.num||''}" placeholder="Number" class="bg-gray-900 px-5 py-3 rounded-2xl w-16" onchange="globalData.how.steps[${i}].num=this.value">
            <input type="text" value="${item.title||''}" placeholder="Title" class="bg-gray-900 px-5 py-3 rounded-2xl w-full mt-3" onchange="globalData.how.steps[${i}].title=this.value">
            <textarea class="w-full bg-gray-900 px-5 py-3 rounded-2xl h-24 mt-3" onchange="globalData.how.steps[${i}].text=this.value">${item.text||''}</textarea>
            <button onclick="removeHow(${i})" class="mt-4 text-red-500">Remove</button>
        `;
        c.appendChild(div);
    });
}
function addHowStep() { 
    globalData.how.steps.push({num:'',title:'',text:''}); 
    renderHow(); 
}
function removeHow(i) { 
    globalData.how.steps.splice(i,1); 
    renderHow(); 
}

// GALLERY
function renderGallery() {
    const c = document.getElementById('gallery-container');
    c.innerHTML = '';
    globalData.gallery.images.forEach((item, i) => {
        const div = document.createElement('div');
        div.className = 'bg-gray-800 p-6 rounded-3xl';
        div.innerHTML = `
            <input type="text" value="${item.url||''}" placeholder="URL" class="bg-gray-900 px-5 py-3 rounded-2xl w-full" onchange="globalData.gallery.images[${i}].url=this.value">
            <input type="text" value="${item.alt||''}" placeholder="Alt" class="bg-gray-900 px-5 py-3 rounded-2xl w-full mt-3" onchange="globalData.gallery.images[${i}].alt=this.value">
            <button onclick="removeGallery(${i})" class="mt-4 text-red-500">Remove</button>
        `;
        c.appendChild(div);
    });
}
function addGalleryImage() { 
    globalData.gallery.images.push({url:'',alt:''}); 
    renderGallery(); 
}
function removeGallery(i) { 
    globalData.gallery.images.splice(i,1); 
    renderGallery(); 
}

// REVIEWS
function renderReviews() {
    const c = document.getElementById('reviews-container');
    c.innerHTML = '';
    globalData.reviews.items.forEach((item, i) => {
        const div = document.createElement('div');
        div.className = 'bg-gray-800 p-6 rounded-3xl';
        div.innerHTML = `
            <input type="text" value="${item.stars||''}" placeholder="Stars" class="bg-gray-900 px-5 py-3 rounded-2xl w-full" onchange="globalData.reviews.items[${i}].stars=this.value">
            <textarea class="w-full bg-gray-900 px-5 py-3 rounded-2xl h-24 mt-3" onchange="globalData.reviews.items[${i}].text=this.value">${item.text||''}</textarea>
            <input type="text" value="${item.name||''}" placeholder="Name" class="bg-gray-900 px-5 py-3 rounded-2xl w-full mt-3" onchange="globalData.reviews.items[${i}].name=this.value">
            <input type="text" value="${item.info||''}" placeholder="Info" class="bg-gray-900 px-5 py-3 rounded-2xl w-full mt-3" onchange="globalData.reviews.items[${i}].info=this.value">
            <button onclick="removeReview(${i})" class="mt-4 text-red-500">Remove</button>
        `;
        c.appendChild(div);
    });
}
function addReview() { 
    globalData.reviews.items.push({stars:'★★★★★',text:'',name:'',info:''}); 
    renderReviews(); 
}
function removeReview(i) { 
    globalData.reviews.items.splice(i,1); 
    renderReviews(); 
}

// FAQ
function renderFaq() {
    const c = document.getElementById('faq-container');
    c.innerHTML = '';
    globalData.faq.items.forEach((item, i) => {
        const div = document.createElement('div');
        div.className = 'bg-gray-800 p-6 rounded-3xl';
        div.innerHTML = `
            <input type="text" value="${item.q||''}" placeholder="Question" class="bg-gray-900 px-5 py-3 rounded-2xl w-full" onchange="globalData.faq.items[${i}].q=this.value">
            <textarea class="w-full bg-gray-900 px-5 py-3 rounded-2xl h-24 mt-3" onchange="globalData.faq.items[${i}].a=this.value">${item.a||''}</textarea>
            <button onclick="removeFaq(${i})" class="mt-4 text-red-500">Remove</button>
        `;
        c.appendChild(div);
    });
}
function addFaq() { 
    globalData.faq.items.push({q:'',a:''}); 
    renderFaq(); 
}
function removeFaq(i) { 
    globalData.faq.items.splice(i,1); 
    renderFaq(); 
}

// INIT
window.onload = () => {
    renderNav();
    renderServices();
    renderAdvantages();
    renderHow();
    renderGallery();
    renderReviews();
    renderFaq();
    switchTab('general');
};
</script>
</body>
</html>
