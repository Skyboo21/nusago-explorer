<?php
// Copy generated images
if (file_exists('C:/Users/hariz/.gemini/antigravity-ide/brain/c9a3230b-c601-4404-b326-29d33aef4589/prambanan_1782807978109.png')) {
    copy('C:/Users/hariz/.gemini/antigravity-ide/brain/c9a3230b-c601-4404-b326-29d33aef4589/prambanan_1782807978109.png', __DIR__ . '/public/img/prambanan.png');
}
if (file_exists('C:/Users/hariz/.gemini/antigravity-ide/brain/c9a3230b-c601-4404-b326-29d33aef4589/ciremai_1782808000687.png')) {
    copy('C:/Users/hariz/.gemini/antigravity-ide/brain/c9a3230b-c601-4404-b326-29d33aef4589/ciremai_1782808000687.png', __DIR__ . '/public/img/ciremai.png');
}

echo "Images copied!";
