<?php
error_reporting(0);

date_default_timezone_set("Asia/JAKARTA");
$cookie = file_get_contents('cookie.txt');

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
$datanya = json_decode($getStoriesIg["content"])->broadcasts;
//print_r($datanya); //data fullnya di sini kalau mau liat
$logsFolder = 'Logs/';

if (file_exists('id_media.txt')) {
    $log = json_encode(file('id_media.txt'));
} else {
    $log = '';
}
$delay = '';


foreach ($datanya as $item) {
    
    $nama = $item->broadcast_owner->username;

    $media_ids = $item->id;
	$logFileName = "id_media.txt";

    if (!preg_match("/" .$media_ids. "/", $log)) {
		echo "";
		$x = $media_ids. "\n";
        $y = fopen('id_media.txt', 'a');
        fwrite($y, $x);
        fclose($y);


echo "Terdapat Live Dengan ID => $media_ids $nama
";//Username=> ".$username."
echo "Proses Komen Dengan Media_id => $media_ids
";


    $url       = "https://www.instagram.com/api/v1/live/$media_ids/comment/";
    $headerss   = array(
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
		'X-Csrftoken: '.$csrf_token,
		'X-Ig-App-Id: 936619743392459',
		'X-Ig-Www-Claim: hmac.AR3IVhLVec5nNs2nFWWvasnRjopisvfQICgyUrev-YBxb74t',
		'X-Instagram-Ajax: 1010319897',
		'X-Requested-With: XMLHttpRequest');

        $post      = "comment_text=Hadir Kak, ❤"; //&place_id='.$lokasi.'
        $post      = json_decode(yarzCurl($url, $post, false, $headerss, true));

        if(isset($post->status))
        {
            echo "status : ".$post->status."
                  ID     : ".$post->comment->pk."
                  Komennya: ".$post->comment->text."";
            
            $dataString = $post->id."\n";
                $fWrite = fopen("logs.txt", "a");
                $wrote  = fwrite($fWrite, $dataString);
                fclose($fWrite);
            
        } 
        
        else {
			echo "
            [Retweet Gagal]";
        }

	} else {
		echo "ID => $media_ids [Sudah pernah di komen..]
        ";
	}
    
}

    function yarzCurl($url, $fields = false, $cookie = false, $httpheaders = false, $encoding = false)

    {
       
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        if ($fields !== false) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        }
        if ($encoding !== false) {
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        }
        if ($cookie !== false) {
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
        }
        if ($httpheaders !== false) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheaders);
        }
        
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
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

if ($media_ids == null) {
    echo "Tidak ada yang lagi Live.";
    exit;
}
