<?php
// ========================================================
// recaptcha.php — Google reCAPTCHA v2
// ========================================================

$recaptcha_site_key   = 'КЛЮЧ САЙТУ';
$recaptcha_secret_key = 'СЕКРЕТНИЙ КЛЮЧ';

function verifyRecaptcha($response) {
    global $recaptcha_secret_key;

    if (empty($response)) {
        return false;
    }

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret'   => $recaptcha_secret_key,
        'response' => $response,
        'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === false) {
        return false;
    }

    $json = json_decode($result, true);
    return isset($json['success']) && $json['success'] === true;
}

function renderRecaptcha() {
    global $recaptcha_site_key;
    echo '<div class="g-recaptcha my-6" data-sitekey="' . htmlspecialchars($recaptcha_site_key) . '" data-size="normal" data-theme="light"></div>';
}
?>
