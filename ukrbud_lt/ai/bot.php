<?php
// bot.php — AI Consultant Grok xAI для Ukrbud.lt (оновлено 2026)
// Авто-привітання + активна пропозиція бронювання прибирання

require_once 'config.php';
require_once 'settings.php';

header('Content-Type: application/json; charset=utf-8');

$log_file = LOG_DIR . '/chat-' . date('Y-m-d') . '.log';

function log_chat($text) {
    global $log_file;
    $time = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    file_put_contents($log_file, "[$time] [$ip] $text\n", FILE_APPEND | LOCK_EX);
}

function rate_limit_check($session) {
    $rate_file = CONVERSATIONS_DIR . '/' . $session . '.rate';
    $now = time();
    $requests = file_exists($rate_file) ? json_decode(file_get_contents($rate_file), true) : [];
    $requests = array_filter($requests, fn($t) => $t > $now - 300);
    $requests[] = $now;
    file_put_contents($rate_file, json_encode($requests), LOCK_EX);
    return count($requests) <= 25; // трохи підвищив ліміт
}

// Отримання даних
$raw = file_get_contents('php://input');
$input = json_decode($raw, true) ?? [];

$session = $input['session'] ?? 's_' . time() . '_' . substr(md5(uniqid()), 0, 12);
$message = trim($input['message'] ?? '');

if (strlen($message) < 1 && $message !== '__AUTO_WELCOME__') {
    echo json_encode(['error' => 'Порожнє повідомлення']);
    exit;
}

if (!rate_limit_check($session)) {
    echo json_encode(['error' => 'Занадто багато запитів. Зачекайте 5 хвилин.']);
    exit;
}

$file = CONVERSATIONS_DIR . '/' . $session . '.json';
$data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

// Додаємо системний промпт тільки при першому повідомленні
if (empty($data)) {
    $data[] = ['role' => 'system', 'content' => $SYSTEM_PROMPT];
}

// Обробка авто-привітання
$isAutoWelcome = ($message === '__AUTO_WELCOME__');
if ($isAutoWelcome) {
    $message = "Почни розмову першим.";
}

// Додаємо повідомлення користувача
$data[] = ['role' => 'user', 'content' => $message, 'sender' => 'client'];

log_chat("→ Клієнт: " . substr($message, 0, 400));

// === Відправка повідомлення КЛІЄНТА в Telegram ===
$tg_client = "🟢 <b>Клієнт" . ($isAutoWelcome ? " (авто)" : "") . " написав:</b>\n" . 
             htmlspecialchars($message) . "\n\nSession: <code>$session</code>";

@file_get_contents("https://api.telegram.org/bot" . TELEGRAM_TOKEN . "/sendMessage?" . http_build_query([
    'chat_id'    => YOUR_TELEGRAM_CHAT_ID,
    'text'       => $tg_client,
    'parse_mode' => 'HTML'
]));

// Підготовка повідомлень для Grok API
$messages = [];
foreach ($data as $m) {
    if (!empty($m['content'])) {
        $messages[] = ['role' => $m['role'], 'content' => $m['content']];
    }
}

// Запит до Grok xAI
$ch = curl_init('https://api.x.ai/v1/chat/completions');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode([
        'model'       => GROK_MODEL,
        'messages'    => $messages,
        'temperature' => 0.85,     // трохи підвищив для більш живої мови
        'max_tokens'  => 650,      // збільшив, щоб відповіді були повнішими
    ]),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Authorization: Bearer ' . XAI_API_KEY
    ],
    CURLOPT_TIMEOUT => 55,
]);

$resp = curl_exec($ch);
$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http === 200) {
    $json = json_decode($resp, true);
    $reply = $json['choices'][0]['message']['content'] ?? 
             'Вибачте, зараз невелика технічна затримка. Зателефонуйте нам: ' . PHONE;
} else {
    $reply = 'На жаль, зараз технічна проблема. Будь ласка, зателефонуйте +370 644 74842 або напишіть на booking@balticclean.lt';
}

// Додаємо відповідь Grok у історію
$data[] = ['role' => 'assistant', 'content' => $reply, 'sender' => 'bot'];

// === Відправка відповіді GROK в Telegram ===
$tg_grok = "🧠 <b>Grok AI відповів клієнту:</b>\n" . htmlspecialchars($reply) . "\n\n" .
           "Session: <code>$session</code>";

@file_get_contents("https://api.telegram.org/bot" . TELEGRAM_TOKEN . "/sendMessage?" . http_build_query([
    'chat_id'    => YOUR_TELEGRAM_CHAT_ID,
    'text'       => $tg_grok,
    'parse_mode' => 'HTML'
]));

log_chat("→ Grok AI: " . substr($reply, 0, 350));

// Зберігаємо історію розмови
file_put_contents($file, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

echo json_encode([
    'reply'   => $reply,
    'session' => $session
]);