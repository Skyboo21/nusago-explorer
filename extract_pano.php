<?php
$html = file_get_contents('https://maps.google.com/maps?q=Street+View+Nusa+Penida&layer=c&output=svembed');
preg_match('/initEmbed\(\[(.*?)\]\);/', $html, $m);
$json = '[' . $m[1] . ']';
$data = json_decode($json, true);
print_r($data[5][0][3][0]); // usually where pano data is
