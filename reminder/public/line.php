<?php

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();         

// LINE Messaging API プッシュメッセージを送る
$LINE_PUSH_URL = "https://api.line.me/v2/bot/message/push";

$LINE_ACCESS_TOKEN = $_ENV['LINE_ACCESS_TOKEN'];

$LINE_USER_ID = $_ENV['LINE_USER_ID'];

// ヘッダーを設定
$header = [
  'Content-Type: application/json',
  'Authorization: Bearer '.$LINE_ACCESS_TOKEN
];

// 送信メッセージを設定
$text = [
  [
    'type' => 'text',
    'text' => 'ボディ'
  ]
];

// ボディを設定
$body = json_encode([
    'to'        => $LINE_USER_ID,
    'messages'  => $text
]);

// CURLオプションを設定
$options = [
    CURLOPT_URL             => $LINE_PUSH_URL,
    CURLOPT_CUSTOMREQUEST   => 'POST',
    CURLOPT_RETURNTRANSFER  => true,
    CURLOPT_HTTPHEADER      => $header,
    CURLOPT_POSTFIELDS      => $body
];

$curl = curl_init();
curl_setopt_array($curl, $options);
curl_exec($curl);
curl_close($curl);
