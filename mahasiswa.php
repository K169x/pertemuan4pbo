<?php
declare(strict_types=1);

class Mahasiswa {
    private array $atributTambahan = [];


    public function __construct(
        public string $nim,
        public string $nama,
        public string $prodi,
        public string $asalSekolah,
        public int $semester,
        public string $agama,
        public string $fakultas = 'Belum diisi',
        string $hobi = ''
    ) {
        if ($nim === '' || $nama === '' || $semester < 1 || $semester > 14) {
            throw new InvalidArgumentException('NIM, nama, dan semester harus valid.');
        }

        if (trim($this->fakultas) === '') {
            $this->fakultas = 'Belum diisi';
        }

        if ($hobi !== '') {
            $this->hobi = $hobi; // Akan memicu __set('hobi', $hobi)
        }
    }

    public function ringkasan(): string {
        return sprintf(
            "%s - %s | Fakultas: %s | Prodi: %s | Semester: %d",
            $this->nim,
            $this->nama,
            $this->fakultas,
            $this->prodi,
            $this->semester
        );
    }

    public function __set(string $nama, mixed $nilai): void {
        $this->atributTambahan[$nama] = $nilai;
    }

    public function __get(string $nama): mixed {
        return $this->atributTambahan[$nama] ?? null;
    }

    public function __isset(string $nama): bool {
        return isset($this->atributTambahan[$nama]);
    }

    public function __unset(string $nama): void {
        unset($this->atributTambahan[$nama]);
    }

    public function __call(string $nama, array $argumen): mixed {
        if ($nama === 'profilSingkat' && count($argumen) === 0) {
            return $this->ringkasan();
        }
        throw new BadMethodCallException('Method tidak tersedia: ' . $nama);
    }

    public function __destruct() {
        if (defined('DEMO_LIFECYCLE') && DEMO_LIFECYCLE) {
            error_log('Destructor Mahasiswa: ' . $this->nim);
            echo "[Destructor Mahasiswa] Objek Mahasiswa NIM {$this->nim} ({$this->nama}) dihapus dari memori.\n";
        }
    }
}