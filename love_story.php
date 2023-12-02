<?php
date_default_timezone_set("Asia/JAKARTA");

$cookie = '';
$csrf_token = null;

if (preg_match('/csrftoken=([^;]+)/', $cookie, $matches)) {
    $csrf_token = $matches[1];
}

if ($csrf_token == null) {
    echo "CSRF Token not found in the cookie.";
    exit;
}

$headers = [
    'Content-Type: application/json;charset=utf-8',
    'accept-encoding: UTF-8',
    'authorization: Bearer AAAAAAAAAAAAAAAAAAAAANRILgAAAAAAnNwIzUejRCOuH5E6I8xnZz4puTs%3D1Zv7ttfk8LF81IUq16cHjhLTvJu4FA33AGWWjCpTnA',
    'Cookie: ' . $cookie,
    'x-csrf-token: ' . $csrf_token,
    'X-Ig-App-Id: 936619743392459'
];

$getStoriesIg = cURL("https://www.instagram.com/api/v1/feed/reels_tray/?is_following_feed=false", false, $cookie, $headers);
$datanya = json_decode($getStoriesIg["content"])->tray;
# print_r($datanya); //data fullnya di sini kalau mau liat

$a =('
__________                                          .__                
\______   \_______  ____   ____  ____   ______ _____|__| ____    ____  
 |     ___/\_  __ \/  _ \_/ ___\/ __ \ /  ___//  ___/  |/    \  / ___\ 
 |    |     |  | \(  <_> )  \__\  ___/ \___ \ \___ \|  |   |  \/ /_/  >
 |____|     |__|   \____/ \___  >___  >____  >____  >__|___|  /\___  / 
                              \/    \/     \/     \/        \//_____/  
');
print $a;

$logsFolder = 'folderLogs/';

if (!is_dir($logsFolder)) {
    mkdir($logsFolder, 0755, true);
}

foreach ($datanya as $item) {
    $username = $item->user->username;
    $media_ids = $item->media_ids;

    $logFileName = "$logsFolder/log_$username.txt";

    if (!file_exists($logFileName)) {
        file_put_contents($logFileName, implode("\n", $media_ids));

        foreach ($media_ids as $media_id) {
                processMediaId($media_id, $cookie, $csrf_token);
        }

        echo "Processed media_ids for @$username.
        ";
    } else {
        $existingMediaIds = explode("\n", file_get_contents($logFileName));
        $newMediaIds = array_diff($media_ids, $existingMediaIds);

        if (!empty($newMediaIds)) {
            file_put_contents($logFileName, "\n" . implode("\n", $newMediaIds), FILE_APPEND);

            foreach ($newMediaIds as $media_id) {
                processMediaId($media_id, $cookie, $csrf_token);
            }

            echo "
            Processed new media_ids for @$username.";
        } else {
            echo "
            Tidak ada Story baru dari @$username.";
        }
    }
}

function processMediaId($media_id, $cookie, $csrf_token)
{
    echo "Processing media_id: $media_id
    ";

    $headerss   = array(
        'authority: www.instagram.com',
        'method: POST',
        'path: /api/v1/story_interactions/send_story_like',
        'scheme: https',
        'Accept:  /',
        'Accept-Encoding: gzip, deflate, br',
        'Accept-Language: en-US,en;q=0.9',
        'Content-Type: application/x-www-form-urlencoded',
        'Cookie: ' . $cookie,
        'Dpr: 1',
        'Origin: https://www.instagram.com',
        'Referer: https://www.instagram.com/stories/khusaeni_al_baladi/3245879681262239508/',
        'Sec-Ch-Prefers-Color-Scheme: light',
        'Sec-Ch-Ua-Mobile: ?0',
        'Sec-Ch-Ua-Model: ""',
        'Sec-Ch-Ua-Platform: "Windows"',
        'Sec-Ch-Ua-Platform-Version: "10.0.0"',
        'Sec-Fetch-Dest: empty',
        'Sec-Fetch-Mode: cors',
        'Sec-Fetch-Site: same-origin',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36',
        'Viewport-Width: 572',
        'X-Asbd-Id: 129477',
        'X-Csrftoken: ' . $csrf_token,
        'X-Ig-App-Id: 936619743392459',
        'X-Ig-Www-Claim: hmac.AR3IVhLVec5nNs2nFWWvasnRjopisvfQICgyUrev-YBxbwKW',
        'X-Instagram-Ajax: 1010049462',
        'X-Requested-With: XMLHttpRequest'
    );

    // foreach ($headers as &$header) {
    //     if (strpos($header, 'x-csrf-token') !== false) {
    //         $header = str_replace('x-csrf-token', 'X-Csrftoken', $header);
    //         break;
    //     }
    // }

    $postLikes = cURL("https://www.instagram.com/api/v1/story_interactions/send_story_like", "media_id=$media_id", $cookie, $headerss);
    $postLikes = json_decode($postLikes["content"]);
    if ($postLikes->status == 'ok') {
        sleep(rand(3,6));
        echo "Success like media_id: $media_id
        ";
    } else {
        echo "Failed like media_id: $media_id
        ";
    }
}

function cURL($url, $fields = null, $cookie = null, $httpheader = null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.52 Safari/537.36');
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);

    if ($fields) {
        $field_string = $fields;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $field_string);
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $body = curl_exec($ch);
    $err = curl_errno($ch);
    $errmsg = curl_error($ch);
    $response = curl_getinfo($ch);
    curl_close($ch);

    $response['errno'] = $err;
    $response['errmsg'] = $errmsg;
    $response['content'] = $body;
    return $response;
}
