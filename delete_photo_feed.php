<?php
date_default_timezone_set("Asia/JAKARTA");
error_reporting(0);



$cookie = file_get_contents('cookie1.txt');
$delete = 'true';
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

$getStoriesIg = cURL("https://www.instagram.com/api/v1/feed/user/8143927324/?count=20", false, $cookie, $headers);
$datanya = json_decode($getStoriesIg["content"])->items;
//print_r($datanya); //data fullnya di sini kalau mau liat

$logsFolder = 'Logs/';


if (file_exists('id_media.txt')) {
    $log = json_encode(file('id_media.txt'));
} else {
    $log = '';
}

$delay = '';

foreach ($datanya as $item) {
    $username = $item->user->username;
    $media_ids = $item->pk;
	$logFileName = "logs.txt";

    if (!preg_match("/" .$media_ids. "/", $log)) {
		echo "";
		$x = $media_ids. "\n";
        $y = fopen('id_media.txt', 'a');
        fwrite($y, $x);
        fclose($y);


echo "
id => ".$media_ids."";//Username=> ".$username."
}
}

if ($delete == 'true') 
 {
    for ($i= 1; $i <= 20; $i++)
    {

        sleep(rand(5,10));
	//sleep(rand(8,15));
    error_reporting(0);
    $cookie = file_get_contents('cookie.txt');
    
    $lines = file('id_media.txt');
    foreach($lines as $line){
        $data [] = trim($line);   
    }
    $filecounter = ("daftar.txt");
    $kunjungan=file($filecounter);
    $kunjungan[0]++;
    $file=fopen($filecounter,"w");
    fputs($file,"$kunjungan[0]");
    fclose($file);
    
    $cel = file_get_contents('daftar.txt');
    $csrf_token = preg_match_all('/csrf_token=(.*?);/', $cookie, $csrf_token) ? $csrf_token[1][0] : null;
    
        
        $headers = [
        'authority: www.instagram.com',
        'method: POST',
        'path: /api/v1/web/likes/3245142975007647439/like/',
        'scheme: https',
        "Accept: */*",
        'Accept-Encoding: gzip, deflate, br',
        'Accept-Language: en-US,en;q=0.9',
        'Content-Type: application/x-www-form-urlencoded',
        'cookie: '.$cookie,
        'Origin: https://www.instagram.com',
        'Referer: https://www.instagram.com/',
        'Sec-Ch-Prefers-Color-Scheme: light',
        'Sec-Ch-Ua: "Google Chrome";v="119", "Chromium";v="119", "Not?A_Brand";v="24"',
        'Sec-Ch-Ua-Full-Version-List: "Google Chrome";v="119.0.6045.160", "Chromium";v="119.0.6045.160", "Not?A_Brand";v="24.0.0.0"',
        'Sec-Ch-Ua-Mobile: ?1',
        'Sec-Ch-Ua-Model: "Nexus 5"',
        'Sec-Ch-Ua-Platform: "Android"',
        'Sec-Ch-Ua-Platform-Version: "6.0"',
        'Sec-Fetch-Dest: empty',
        'Sec-Fetch-Mode: cors',
        'Sec-Fetch-Site: same-origin',
        'User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Mobile Safari/537.36',
        'Viewport-Width: 784',
        'X-Asbd-Id: 129477',
        'X-Csrftoken: Pqk5kLhH0eTRHkahWsvFsgKeMuxO4ntk',
        'X-Ig-App-Id: 1217981644879628',
        'X-Ig-Www-Claim: hmac.AR3af4oKd_IMx4QzOIFQtNqCXBDhh5GAkDIjQxUHQzbjSQ5s',
        'X-Instagram-Ajax: 1010070360',
        'X-Requested-With: XMLHttpRequest'];
    
        $curlHandle = curl_init('https://www.instagram.com/api/v1/web/create/'.$data[$cel].'/delete/');
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $postParameter);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        $curlResponse = curl_exec($curlHandle);
        curl_close($curlHandle);
        print_r("
Status Delete =>".$curlResponse);
}
$files    = glob('daftar.txt');
foreach ($files as $file) {
    if (is_file($file))
    unlink($file); // hapus file
}
$files1    = glob('id_media.txt');
foreach ($files1 as $file2) {
    if (is_file($file2))
    unlink($file2); // hapus file
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

