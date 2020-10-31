<?php

$jsonUrl = "template.json";
if(file_exists($jsonUrl)) {
  $json = file_get_contents($jsonUrl);
  $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
  $obj = json_decode($json, true);
  var_dump($obj);
}