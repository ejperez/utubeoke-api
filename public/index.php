<?php
// Check if API key and q param are available
$apiKey = getenv('API_KEY');
$q = $_GET['q'] ?? null;

if(!$apiKey || !$q) {
	die('<h1>It works!</h1>');
}

// Allow CORS for specific hosts
$referer = $_SERVER['HTTP_REFERER'];
$parsedUrl = parse_url($referer);
$allowedHosts = getenv('ALLOWED_HOSTS');

if($allowedHosts) {
	if(in_array($parsedUrl, explode(',', $allowedHosts))) {
		header('Access-Control-Allow-Origin: ' . $referer);
	}
}

// Do request
$params = http_build_query([
	'q' => $q,
	'part' => 'snippet',
	'key' => $apiKey,
	'maxResults' => 10,
	'type' => 'video'
]);

$response = file_get_contents('https://www.googleapis.com/youtube/v3/search?' . $params);

header('Content-Type: application/json');
echo $response;