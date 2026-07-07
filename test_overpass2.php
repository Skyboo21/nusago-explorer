<?php
$query = "[out:json];node(around:75000,-7.5517,111.6611)['tourism'~'attraction|museum|viewpoint|theme_park|zoo']['name'];out 10;";
$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => "User-Agent: NusagoExplorer/1.0\r\nAccept: application/json\r\n"
    ]
]);
$url = 'https://overpass-api.de/api/interpreter?data=' . urlencode($query);
$response = @file_get_contents($url, false, $context);
if ($response === false) {
    echo "Request failed!\n";
} else {
    $json = json_decode($response, true);
    echo "Elements found: " . count($json['elements']) . "\n";
    foreach ($json['elements'] as $el) {
        echo $el['tags']['name'] . "\n";
    }
}
