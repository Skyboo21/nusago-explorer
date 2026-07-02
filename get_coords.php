<?php
$destinations = [
    "Candi Borobudur",
    "Taman Nasional Komodo",
    "Gunung Bromo",
    "Gunung Lawu",
    "Nusa Penida",
    "Wae Rebo",
    "Telaga Sarangan",
    "Candi Prambanan",
    "Gunung Ciremai"
];

foreach($destinations as $dest) {
    $url = "https://maps.google.com/maps?q=" . urlencode($dest) . "&layer=c&output=svembed";
    
    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"
        ]
    ];
    $context = stream_context_create($opts);
    $html = file_get_contents($url, false, $context);
    
    if (preg_match('/\[\[\[[0-9\.]+,\s*([0-9\.-]+),\s*([0-9\.-]+)\]/', $html, $matches)) {
        echo $dest . " -> Lat: " . $matches[2] . ", Lng: " . $matches[1] . "\n";
    } else {
        echo $dest . " -> Not found\n";
    }
}
