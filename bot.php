<?php
require_once 'curl.php';
$TOKEN = 'YOUR_TELEGRAM TOKEN';
$URL = "https://api.telegram.org/bot$TOKEN";

// From https://atareao.es/tutorial/crea-tu-propio-bot-para-telegram/un-bot-de-telegram-con-php/
function sendMessage($chat_id, $text) {
    global $URL;
    $json = ['chat_id'       => $chat_id,
             'text'          => $text,
             'parse_mode'    => 'HTML'];
    return curl_post($URL.'/sendMessage', json_encode($json));
}

$i = 1;
$next_id = null;
while (true) {
  $params = "";
  if ($next_id != null) {
    // ask only from next_id
  	$params = http_build_query(['offset' => $next_id]);
  }
  $res = curl_get($URL.'/getUpdates', $params);
  echo "$i) ";
  if (!$res['ok']) {
    echo "Curl failed: " . $res['err'] . "\n";
    continue;
  }
  $updates = json_decode($res['res']);
  if (!$updates->ok) {
    echo "Tgram failed: " . $res['err'] . "\n";
    continue;
  }
  $updates = $updates->result;
  var_dump($updates);
  sleep(5);

  $last_update = end($updates);
  $next_id = $last_update->update_id+1;
  $i++;
}

