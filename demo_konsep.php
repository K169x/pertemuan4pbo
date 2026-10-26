<?php
declare(strict_types=1);
require_once __DIR__ . '/Mahasiswa.php';
require_once __DIR__ . '/Buku.php';

define('DEMO_LIFECYCLE', true);
header('Content-Type: text/plain; charset=utf-8');

echo "=================================================================\n";
echo "CONSTRUCTOR MAHASISWA (DEFAULT PARAMETER FAKULTAS)\n";
echo "=================================================================\n";

$m1 = new Mahasiswa('123', 'Alya', 'Informatika', 'SMA 1', 3, 'Islam');

$m2 = new Mahasiswa('124', 'Budi', 'Sistem Informasi', 'SMA 2', 5, 'Islam', 'Teknik');

echo "Output Objek 1 (Tanpa Fakultas) : " . $m1->ringkasan() . "\n";
echo "Output Objek 2 (Dengan Fakultas): " . $m2->ringkasan() . "\n\n";


echo "=================================================================\n";
echo "CLASS BUKU, TAMPILINFO(), DESTRUCTOR & ALIAS\n";
echo "=================================================================\n";

$buku1 = new Buku('Clean Code', 'Robert C. Martin', 2008);
$buku2 = new Buku('Design Patterns', 'Erich Gamma', 1994);
$buku3 = new Buku('Pemrograman Berorientasi Objek', 'Tim Dosen', 2026);

echo "\n--- Menampilkan Info 3 Objek Buku ---\n";
echo "1. " . $buku1->tampilInfo() . "\n";
echo "2. " . $buku2->tampilInfo() . "\n";
echo "3. " . $buku3->tampilInfo() . "\n\n";

echo "--- Uji Destructor & Efek unset() Ketika Masih Ada Alias Object ---\n";
$aliasBuku1 = $buku1; // Membuat alias yang menunjuk ke objek $buku1 yang sama

echo "-> Menjalankan unset(\$buku1) saat \$aliasBuku1 masih ada...\n";
unset($buku1);
echo "   (Perhatikan: Destructor 'Clean Code' BELUM dijalankan karena masih ada \$aliasBuku1)\n";
echo "   Masih bisa diakses lewat alias: " . $aliasBuku1->tampilInfo() . "\n\n";

echo "-> Menjalankan unset(\$aliasBuku1) (referensi terakhir dihapus)...\n";
unset($aliasBuku1); // Sekarang reference count = 0, destructor langsung jalan!

echo "\n-> Membandingkan dengan unset(\$buku2) yang TIDAK punya alias...\n";
unset($buku2); // Langsung menjalankan destructor saat itu juga
echo "\n";


echo "=================================================================\n";
echo "OVERLOADING ATRIBUT DINAMIS 'hobi'\n";
echo "=================================================================\n";

echo "-> Mengisi \$m1->hobi = 'Membaca' (memicu __set)\n";
$m1->hobi = 'Membaca';

echo "-> Membaca \$m1->hobi (memicu __get): " . $m1->hobi . "\n";

echo "-> Mengecek isset(\$m1->hobi) (memicu __isset): ";
echo isset($m1->hobi) ? "Ada (true)\n" : "Tidak ada (false)\n";

echo "-> Menghapus dengan unset(\$m1->hobi) (memicu __unset)\n";
unset($m1->hobi);

echo "-> Mengecek ulang isset(\$m1->hobi) setelah di-unset: ";
echo isset($m1->hobi) ? "Ada (true)\n\n" : "Tidak ada (false)\n\n";


echo "=================================================================\n";
echo "OVERLOADING METHOD __call() & UJI EXCEPTION\n";
echo "=================================================================\n";

echo "-> Memanggil method yang diizinkan (\$m1->profilSingkat()):\n";
echo "   Hasil: " . $m1->profilSingkat() . "\n\n";

echo "-> Memanggil method lain yang TIDAK diizinkan (\$m1->cetakKRS()):\n";
try {
    echo $m1->cetakKRS() . "\n";
} catch (BadMethodCallException $e) {
    echo "   [Exception Tertangkap] " . get_class($e) . ": " . $e->getMessage() . "\n\n";
}


echo "=================================================================\n";
echo "(Objek yang tersisa di memori akan di-destruct)\n";
echo "=================================================================\n";
unset($m1);