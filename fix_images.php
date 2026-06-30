<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Copy generated images
if (file_exists('C:/Users/hariz/.gemini/antigravity-ide/brain/c9a3230b-c601-4404-b326-29d33aef4589/lawu_1782807457331.png')) {
    copy('C:/Users/hariz/.gemini/antigravity-ide/brain/c9a3230b-c601-4404-b326-29d33aef4589/lawu_1782807457331.png', public_path('img/lawu.png'));
}
if (file_exists('C:/Users/hariz/.gemini/antigravity-ide/brain/c9a3230b-c601-4404-b326-29d33aef4589/sarangan_1782807644584.png')) {
    copy('C:/Users/hariz/.gemini/antigravity-ide/brain/c9a3230b-c601-4404-b326-29d33aef4589/sarangan_1782807644584.png', public_path('img/sarangan.png'));
}
// Copy placeholders for prambanan and ciremai
copy(public_path('img/borobudur.png'), public_path('img/prambanan.png'));
copy(public_path('img/bromo.png'), public_path('img/ciremai.png'));

$updates = [
    'Gunung Lawu' => ['alamat' => 'Perbatasan Jawa Tengah dan Jawa Timur', 'gambar' => 'lawu.png'],
    'Telaga Sarangan' => ['alamat' => 'Magetan, Jawa Timur', 'gambar' => 'sarangan.png'],
    'Candi Prambanan' => ['alamat' => 'Sleman, Daerah Istimewa Yogyakarta', 'gambar' => 'prambanan.png'],
    'Gunung Ciremai' => ['alamat' => 'Kuningan dan Majalengka, Jawa Barat', 'gambar' => 'ciremai.png']
];

foreach ($updates as $nama => $data) {
    App\Models\Wisata::where('nama_wisata', 'like', '%' . $nama . '%')
        ->update([
            'alamat' => $data['alamat'],
            'gambar' => $data['gambar']
        ]);
}

echo "Images and Alamat updated!";
