<?php
$destinations = [
    "Nusa Penida" => ["lat" => -8.7455, "lng" => 115.5376],
    "Telaga Sarangan" => ["lat" => -7.6765, "lng" => 111.2272],
    "Candi Prambanan" => ["lat" => -7.7520, "lng" => 110.4915]
];

function testCoordinate($lat, $lng) {
    $url = "https://maps.google.com/maps?layer=c&cbll={$lat},{$lng}&cbp=11,0,0,0,0&output=svembed";
    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0\r\n"
        ]
    ];
    $context = stream_context_create($opts);
    $html = @file_get_contents($url, false, $context);
    if($html && strlen($html) > 2000) {
        return true;
    }
    return false;
}

foreach($destinations as $name => $c) {
    $found = false;
    echo "Searching for $name...\n";
    // scan a 5x5 grid around the center, step 0.002 degrees (~200 meters)
    for($i = -2; $i <= 2; $i++) {
        for($j = -2; $j <= 2; $j++) {
            $testLat = $c['lat'] + ($i * 0.002);
            $testLng = $c['lng'] + ($j * 0.002);
            if(testCoordinate($testLat, $testLng)) {
                echo "SUCCESS $name -> Lat: $testLat, Lng: $testLng\n";
                $found = true;
                break 2;
            }
        }
    }
    if(!$found) {
        echo "FAILED $name\n";
    }
}
