<?php

require '../vendor/autoload.php';
require './functions.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();                                                                                                                                                                                                   

// if (php_sapi_name() != 'cli') {
//   throw new Exception('This application must be run on the command line.');
// }

// 日本のタイムゾーンを設定
date_default_timezone_set('Asia/Tokyo');

// 本日の日付を取得
$today = date('Y-m-d');

// 取得データの開始日
$start = date($today.'\T00:00:00\Z');

// 取得データの終了日
$end = date($today.'\T23:59:59\Z');

// クライアント取得
$client = getClient();

// カレンダーサービスの作成
$service = new Google_Service_Calendar($client);

$option = [
  'timeMin' => $start,
  'timeMax' => $end,
  'maxResults' => 10,
  'orderBy' => 'startTime',
  'singleEvents' => 'true'
];

// カレンダーID
$calendar_id = $_ENV['CALENDAR_ID'];

// データの取得
$response = $service->events->listEvents($calendar_id, $option);
$events = $response->getItems();

// 本日の予定を格納
$results = [];

//本日の予定がある時
if(!empty($events)) {
    
    foreach ($events as $event) {
      
      //予定の開始時刻を取得
      $start = property_exists($event->start, 'dateTime')?$event->start->dateTime:$event->start->date;

      //予定の終了時刻を取得
      $end = property_exists($event->end, 'dateTime')?$event->end->dateTime:$event->end->date;

      //予定のタイトルを取得
      $summary = $event->summary;
      
      $result = [
        'startTime' => substr($start, 11, 8),
        'endTime' => substr($end, 11, 8),
        'summary' => $summary,
      ];

      array_push($results, $result);
    }

} else {
    $results['empty'] = '本日の予定は何もありません';
}



//一旦LINEは置いておく
//===========================================================

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
    'text' => '動作確認'
  ]
];

$array = getLineTemplate();
var_dump($array);

$jsonUrl = 'template.json';
$json = file_get_contents($jsonUrl);
$json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$obj = json_decode($json, true);
var_dump($obj);


// ボディを設定
$body = json_encode([
    'to'        => $LINE_USER_ID,
    'messages'  => [$array]
]);

// var_dump($body);

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
$error = curl_exec($curl);
echo ($error);
curl_close($curl);
