<?php
$destinasi = [
    'Taman Nasional Komodo' => 'Komodo 4k',
    'Raja Ampat' => 'Raja Ampat 4k',
    'Wae Rebo' => 'Wae Rebo 4k',
    'Candi Borobudur' => 'Candi Borobudur 4k',
    'Nusa Penida' => 'Nusa Penida 4k',
    'Gunung Bromo' => 'Gunung Bromo 4k',
    'Danau Toba' => 'Danau Toba 4k',
    'Tana Toraja' => 'Tana Toraja 4k',
    'Kepulauan Derawan' => 'Derawan 4k',
    'Kawah Ijen' => 'Kawah Ijen 4k'
];

foreach ($destinasi as $nama => $query) {
    $html = file_get_contents('https://www.youtube.com/results?search_query=' . urlencode($query));
    preg_match('/"videoId":"([^"]+)"/', $html, $matches);
    if (!empty($matches[1])) {
        echo "['nama' => '{$nama}', 'id' => '{$matches[1]}'],\n";
    }
}
