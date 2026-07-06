<?php
$lat = -7.5517;
$lng = 111.6611;
$radius = 50000;
$query = "[out:json];node(around:{$radius},{$lat},{$lng})['tourism'~'attraction|museum|viewpoint|theme_park|zoo'];out 15;";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://overpass-api.de/api/interpreter?data=" . urlencode($query));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, 'NusagoExplorer/1.0');
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
$output = curl_exec($ch);
curl_close($ch);

echo strlen($output) . " bytes\n";
echo substr($output, 0, 500);
