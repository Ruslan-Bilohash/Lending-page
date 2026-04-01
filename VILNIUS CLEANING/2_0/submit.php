<?php
// ========================================================
// submit.php — Обробник форми для Meistru Valymas / Vilnius Cleaning
// З надійною перевіркою reCAPTCHA v2
// ========================================================

session_start();

// Підключаємо reCAPTCHA
require_once __DIR__ . '/recaptcha.php';

// ========== ПЕРЕВІРКА reCAPTCHA ==========
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['g-recaptcha-response']) || !verifyRecaptcha($_POST['g-recaptcha-response'])) {
        // Якщо reCAPTCHA не пройдена — повертаємо на сторінку з помилкою
        header("Location: en.php?error=1");
        exit;
    }
} else {
    // Якщо хтось зайшов просто так — перенаправляємо
    header("Location: en.php");
    exit;
}

// ====================== ОБРОБКА ФОРМИ ======================
$to = "rbilohash@gmail.com,valeriapilipiuk@gmail.com,ulianasemashko@gmail.com,booking@balticclean.lt";

$name    = trim(strip_tags($_POST['name'] ?? ''));
$phone   = trim(strip_tags($_POST['phone'] ?? ''));
$message = trim(strip_tags($_POST['message'] ?? ''));

if (empty($name) || empty($phone)) {
    header("Location: en.php?error=1");
    exit;
}

// === КРАСИВИЙ HTML EMAIL ===
$subject = "New Cleaning Request in Vilnius — " . $name;

$body = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Cleaning Request</title>
    <style>
        body {font-family: Arial, sans-serif; background:#f4f4f4; margin:0; padding:30px;}
        .container {max-width:620px; margin:0 auto; background:#ffffff; border-radius:20px; overflow:hidden; box-shadow:0 15px 40px rgba(0,0,0,0.1);}
        .header {background:linear-gradient(135deg, #10b981, #14b8a6); color:#fff; padding:40px 30px; text-align:center;}
        .header h1 {margin:0; font-size:28px;}
        .content {padding:40px 50px; line-height:1.75; color:#1f2937;}
        .info {background:#f8fafc; padding:25px; border-radius:16px; margin:25px 0;}
        .label {font-weight:700; color:#0f766e; display:inline-block; width:140px;}
        .footer {text-align:center; padding:30px; background:#f1f5f9; color:#64748b; font-size:14px;}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🧹 New Professional Cleaning Request</h1>
            <p style="margin:10px 0 0 0; opacity:0.95;">Vilnius • Baltic Clean</p>
        </div>
        <div class="content">
            <p>Hello team,</p>
            <p>You have received a new request for professional cleaning in Vilnius.</p>
           
            <div class="info">
                <strong>👤 Client Information</strong><br><br>
                <span class="label">Name:</span> ' . htmlspecialchars($name) . '<br>
                <span class="label">Phone:</span> ' . htmlspecialchars($phone) . '<br><br>
                <span class="label">Address & Wishes:</span><br>
                ' . nl2br(htmlspecialchars($message)) . '
            </div>
            <p><strong>Request date:</strong> ' . date('d.m.Y H:i') . '</p>
            <p><strong>Website:</strong> <a href="https://meistru.lt/" style="color:#10b981;">meistru.lt</a></p>
           
            <p style="margin-top:30px; font-weight:600;">Please contact the client as soon as possible to confirm the time and details.</p>
        </div>
        <div class="footer">
            Baltic Clean Vilnius • Professional Cleaning Service<br>
            Thank you for your quick response!
        </div>
    </div>
</body>
</html>';

$headers = "From: no-reply@balticclean.lt\r\n";
$headers .= "Reply-To: " . $phone . "\r\n";
$headers .= "Content-Type: text/html; charset=utf-8\r\n";
$headers .= "MIME-Version: 1.0\r\n";

if (mail($to, $subject, $body, $headers)) {
    header("Location: en.php?success=1");
    exit;
} else {
    header("Location: en.php?error=1");
    exit;
}
?>
