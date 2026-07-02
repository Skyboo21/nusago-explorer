<?php
$destinations = [
    "Candi Borobudur" => ["lat" => -7.6078738, "lng" => 110.2037513],
    "Taman Nasional Komodo" => ["lat" => -8.527716, "lng" => 119.4833198],
    "Gunung Bromo" => ["lat" => -7.94249345, "lng" => 112.9530122],
    "Gunung Lawu" => ["lat" => -7.62749985, "lng" => 111.1941666],
    "Nusa Penida" => ["lat" => -8.7455, "lng" => 115.5376],
    "Wae Rebo" => ["lat" => -8.7691, "lng" => 120.2841],
    "Telaga Sarangan" => ["lat" => -7.6765, "lng" => 111.2272],
    "Candi Prambanan" => ["lat" => -7.7520, "lng" => 110.4915],
    "Gunung Ciremai" => ["lat" => -6.8933, "lng" => 108.4066]
];

function testCoordinate($lat, $lng) {
    $url = "https://maps.google.com/maps?layer=c&cbll={$lat},{$lng}&cbp=11,0,0,0,0&output=svembed";
    $html = @file_get_contents($url);
    if($html && strlen($html) > 2000) {
        return true;
    }
    return false;
}

$results = [];
foreach($destinations as $name => $c) {
    $found = false;
    echo "Scanning $name...\n";
    // Check center first
    if(testCoordinate($c['lat'], $c['lng'])) {
        $results[$name] = $c;
        echo "Found center: {$c['lat']}, {$c['lng']}\n";
        continue;
    }
    // Scan spiral
    $steps = [
        [0.0001, 0], [-0.0001, 0], [0, 0.0001], [0, -0.0001],
        [0.0005, 0], [-0.0005, 0], [0, 0.0005], [0, -0.0005],
        [0.001, 0], [-0.001, 0], [0, 0.001], [0, -0.001]
    ];
    foreach($steps as $s) {
        $testLat = $c['lat'] + $s[0];
        $testLng = $c['lng'] + $s[1];
        if(testCoordinate($testLat, $testLng)) {
            $results[$name] = ['lat' => $testLat, 'lng' => $testLng];
            echo "Found near: $testLat, $testLng\n";
            $found = true;
            break;
        }
    }
    if(!$found) {
        echo "FAILED $name\n";
    }
}
file_put_contents('valid_coords.json', json_encode($results));
