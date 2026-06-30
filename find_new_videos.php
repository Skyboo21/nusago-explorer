<?php
$destinasi = [
    'Gunung Lawu' => 'Gunung Lawu pendakian drone',
    'Telaga Sarangan' => 'Telaga Sarangan wisata',
    'Candi Prambanan' => 'Candi Prambanan 4k',
    'Gunung Ciremai' => 'Gunung Ciremai pendakian'
];

foreach ($destinasi as $nama => $query) {
    $html = file_get_contents('https://www.youtube.com/results?search_query=' . urlencode($query));
    preg_match_all('/"videoId":"([^"]+)"/', $html, $matches);
    
    // get unique ids
    $ids = array_unique($matches[1]);
    
    if (!empty($ids)) {
        // filter out playlist ids or channel ids if they match accidentally, videoId is 11 chars
        $valid_ids = array_filter($ids, function($id) { return strlen($id) === 11; });
        $id = reset($valid_ids);
        echo "['nama' => '{$nama}', 'id' => '{$id}'],\n";
    }
}
