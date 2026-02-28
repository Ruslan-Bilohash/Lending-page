<?php
// ====================== traffic_logger.php ======================
// УДОСКОНАЛЕНИЙ ЛОГЕР ТРАФІКУ з ВИЗНАЧЕННЯМ КРАЇНИ + МІСТА
// Автор: Ruslan Bilohash (

function logVisitor() {
    $logDir = __DIR__ . '/logs';
    if (!is_dir($logDir)) mkdir($logDir, 0755, true);

    $logFile       = $logDir . '/visitors.log';
    $tiktokLogFile = $logDir . '/tiktok_visitors.log';

    $date      = date('Y-m-d H:i:s');
    $ip        = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $referer   = $_SERVER['HTTP_REFERER'] ?? '';
    $page      = $_SERVER['REQUEST_URI'] ?? '/';
    $utmSource = $_GET['utm_source'] ?? '';
    $utmMedium = $_GET['utm_medium'] ?? '';

    // Захист від ботів
    if (empty($userAgent) || stripos($userAgent, 'bot') !== false || stripos($userAgent, 'crawler') !== false) {
        return;
    }

    // Визначення країни + міста через ipapi.co (безкоштовно)
    $country = 'Unknown';
    $city    = 'Unknown';
    $cacheFile = $logDir . '/ip_cache_' . md5($ip) . '.json';

    if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < 86400)) {
        $cached = json_decode(file_get_contents($cacheFile), true);
        $country = $cached['country'] ?? 'Unknown';
        $city    = $cached['city'] ?? 'Unknown';
    } else {
        $apiUrl = "https://ipapi.co/{$ip}/json/";
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response) {
            $data = json_decode($response, true);
            if (isset($data['country_name'])) {
                $country = $data['country_name'];
                $city    = $data['city'] ?? 'Unknown';
                file_put_contents($cacheFile, json_encode(['country' => $country, 'city' => $city]));
            }
        }
    }

    // Визначення джерела
    $source = 'Direct';
    $refLower = strtolower($referer);

    if (strpos($refLower, 'tiktok.com') !== false || strpos($refLower, 'tiktokv.com') !== false || $utmSource === 'tiktok') {
        $source = 'TikTok';
    } elseif (strpos($refLower, 'google.') !== false || strpos($refLower, 'googlesyndication') !== false || $utmSource === 'google') {
        $source = 'Google';
    } elseif (strpos($refLower, 'facebook.com') !== false || strpos($refLower, 'fb.com') !== false) {
        $source = 'Facebook';
    } elseif (strpos($refLower, 'instagram.com') !== false) {
        $source = 'Instagram';
    } elseif (strpos($refLower, 'youtube.com') !== false) {
        $source = 'YouTube';
    }

    // Тип пристрою
    $device = 'Desktop';
    if (preg_match('/(iPhone|iPod|iPad|Android|BlackBerry|Windows Phone)/i', $userAgent)) {
        $device = 'Mobile';
    }
    if (preg_match('/(iPad|Tablet)/i', $userAgent)) {
        $device = 'Tablet';
    }

    // Формуємо рядок
    $logLine = "[$date] | IP: $ip | Country: $country | City: $city | Device: $device | Source: $source | Page: $page | Referer: $referer | UTM: $utmSource/$utmMedium | UA: $userAgent" . PHP_EOL;

    // Основний лог
    file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);

    // Окремий лог тільки для TikTok
    if ($source === 'TikTok' || $source === 'TikTok (UTM)') {
        file_put_contents($tiktokLogFile, $logLine, FILE_APPEND | LOCK_EX);
    }
}

// === ЗАПУСК ===
logVisitor();
?>