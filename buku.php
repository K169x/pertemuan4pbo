<?php
declare(strict_types=1);

class Buku {
    public function __construct(
        public string $judul,
        public string $penulis,
        public int $tahun
    ) {
        if (defined('DEMO_LIFECYCLE') && DEMO_LIFECYCLE) {
            echo "[Constructor Buku] Objek buku \"{$this->judul}\" berhasil dibuat.\n";
        }
    }

    public function tampilInfo(): string {
        return "Judul: \"{$this->judul}\" | Penulis: {$this->penulis} | Tahun: {$this->tahun}";
    }

    public function __destruct() {
        if (defined('DEMO_LIFECYCLE') && DEMO_LIFECYCLE) {
            echo "[Destructor Buku] Objek buku \"{$this->judul}\" telah dihapus dari memori.\n";
        }
    }
}