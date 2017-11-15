<?php
    $pairs = array(
        "eurusd" => "EUR/USD",
        "gbpusd" => "GBP/USD",
        "audusd" => "AUD/USD",
        "nzdusd" => "NZD/USD",
        "usdcad" => "USD/CAD",
        "xauusd" => "GOLD",
        "eurjpy" => "EUR/JPY"
    );
    define(T_STAMP, 0);
    //PAY ROBOKASSA
    define(ROBOKASSA_LOGIN, "option21");
    define(ROBOKASSA_PASSWORD, "12345678a");
    //PAY OOOPAY
    define(OOOPAY_ID, "964");
    define(OOOPAY_KEY, "west2825944");
    // PAY INTERKASSA
    define(INTERKASSA_KEY, "59c99f043d1eaf4c7c8b4575");
	// DB INFO
	define(DB_HOST, "localhost");
	define(DB_USER, "root");
	define(DB_PASSWORD, "");
	define(DB_BASE, "trust_signal");
    // BASIC INFO wer12Dwer
    define(URI, "https://trust-signals.com");
    define(OLD_URI, "http://old.trustsignals.info");
    // SMTP INFO
    define(SMTP_HOST, 'mail.ukraine.com.ua');
    define(SMTP_USERNAME, 'support@trust-signals.com');
    define(SMTP_PASSWORD, 'wer12Dwer');
    define(SMTP_SECURE, 'non-secure');
    define(SMTP_PORT, '25');
    define(SMTP_EMAIL, 'support@trust-signals.com');
    //VK API
    define(VK_CLIENT_ID, "5038287!");
    define(VK_CLIENT_SECRET, "ZB9Hi7iOf7AvhHWrRJwx");
    define(VK_REDIRECT, URI."/auth/vk/");
    $url = 'http://oauth.vk.com/authorize';
    $params = array(
        'client_id'     => VK_CLIENT_ID,
        'redirect_uri'  => VK_REDIRECT,
        'response_type' => 'code'
    );
    $url = $url .'?'. urldecode(http_build_query($params));
    define(VK_URL_AUTH, $url);
    //OK API
    define(OK_CLIENT_ID, "1150907392!");
    define(OK_CLIENT_SECRET, "A9032CD9657AAB775304F310");
    define(OK_CLIENT_PUBLIC, "CBAFHKJFEBABABABA");
    define(OK_REDIRECT, URI."/auth/ok/");
    $url = 'http://www.odnoklassniki.ru/oauth/authorize';
    $params = array(
        'client_id'     => OK_CLIENT_ID,
        'response_type' => 'code',
        'redirect_uri'  => OK_REDIRECT
    );
    $url = $url .'?'. urldecode(http_build_query($params));
    define(OK_URL_AUTH, $url);
    //Yandex API
    define(YA_CLIENT_ID, "c6a9cbb1440f4ff7b22e94a68f04efba!");
    define(YA_CLIENT_SECRET, "d787530e6e8a424e8f0a69ce24f891f9");
    define(YA_REDIRECT, URI."/auth/ya/");
    $url = 'https://oauth.yandex.ru/authorize';
    $params = array(
        'response_type' => 'code',
        'client_id'     => YA_CLIENT_ID,
        'display'       => 'popup'
    );
    $url = $url .'?'. urldecode(http_build_query($params));
    define(YA_URL_AUTH, $url);
?>