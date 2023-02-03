<?php

// https://www.php.net/manual/es/function.curl-exec.php#98628
/**
 * Send a POST requst using cURL
 * @param string $url to request
 * @param string $post params to send
 * @param array $options for cURL
 */
function curl_post($url, $post = "", array $options = array()) {


    $defaults = array(
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_URL => $url,
        CURLOPT_FRESH_CONNECT => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FORBID_REUSE => 1,
        CURLOPT_TIMEOUT => 4,
        CURLOPT_POSTFIELDS => $post,
        CURLOPT_FOLLOWLOCATION => true
    );

    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
    if( ! $result = curl_exec($ch)) {
        return ['ok' => false,
                'err' => curl_error($ch)];
    }
    curl_close($ch);
    return ['ok' => true,
            'res' => $result];
}

/**
 * Send a GET requst using cURL
 * @param string $url to request
 * @param string $get params to send
 * @param array $options for cURL
 */

function curl_get($url, $get = "", array $options = array()) {

	if ($get == NULL) {
		$get = [];
	}
    $defaults = array(
        CURLOPT_URL => $url. (strpos($url, '?') === FALSE ? '?' : ''). $get,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_TIMEOUT => 4,
        CURLOPT_FOLLOWLOCATION => true
    );
    
    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
    if( ! $result = curl_exec($ch)) {
        return ['ok' => false,
                'err' => curl_error($ch)];
    }
    curl_close($ch);
    return ['ok' => true,
            'res' => $result];
}
