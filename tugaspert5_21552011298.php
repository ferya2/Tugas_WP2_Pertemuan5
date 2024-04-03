<?php

// Kelas Buku merepresentasikan objek buku
class Buku {
    private $judul;
    private $penulis;
    private $tahunTerbit;
    protected $sedangDipinjam; // Mengubah menjadi protected agar dapat diakses oleh kelas turunannya

    // Constructor untuk inisialisasi atribut-atribut buku
    public function __construct($judul, $penulis, $tahunTerbit) {
        $this->judul = $judul;
        $this->penulis = $penulis;
        $this->tahunTerbit = $tahunTerbit;
        $this->sedangDipinjam = false; // Awalnya buku belum dipinjam
    }

    // Getter untuk mendapatkan judul buku
    public function getJudul() {
        return $this->judul;
    }

    // Getter untuk mendapatkan penulis buku
    public function getPenulis() {
        return $this->penulis;
    }

    // Getter untuk mendapatkan tahun terbit buku
    public function getTahunTerbit() {
        return $this->tahunTerbit;
    }

    // Getter untuk mendapatkan status pinjam buku
    public function sedangDipinjam() {
        return $this->sedangDipinjam;
    }

    // Method untuk meminjam buku
    public function pinjamBuku() {
        $this->sedangDipinjam = true;
        echo "Buku '{$this->judul}' berhasil dipinjam.\n";
    }

    // Method untuk mengembalikan buku
    public function kembalikanBuku() {
        $this->sedangDipinjam = false;
        echo "Buku '{$this->judul}' berhasil dikembalikan.\n";
    }

    // Method untuk menampilkan informasi buku
    public function informasiBuku() {
        return "Judul: {$this->judul}, Penulis: {$this->penulis}, Tahun Terbit: {$this->tahunTerbit}";
    }
}

// Kelas ReferensiBuku adalah kelas turunan dari Buku
class ReferensiBuku extends Buku {
    private $halaman;

    // Constructor untuk inisialisasi atribut-atribut buku referensi
    public function __construct($judul, $penulis, $tahunTerbit, $halaman) {
        parent::__construct($judul, $penulis, $tahunTerbit);
        $this->halaman = $halaman;
    }

    // Override method untuk menampilkan informasi buku
    public function informasiBuku() {
        return parent::informasiBuku() . ", Halaman: {$this->halaman}";
    }
}

// Kelas Perpustakaan merepresentasikan objek perpustakaan
class Perpustakaan {
    private static $totalBuku = 0; // Menggunakan static untuk menghitung total buku

    private $buku = [];

    // Method untuk menambahkan buku baru ke dalam perpustakaan
    public function tambahBuku(Buku $buku) {
        $this->buku[] = $buku;
        self::$totalBuku++; // Menambahkan jumlah total buku
        echo "Buku '{$buku->getJudul()}' berhasil ditambahkan ke perpustakaan.\n";
    }

    // Method untuk meminjam buku dari perpustakaan
    public function pinjamBuku($judul) {
        foreach ($this->buku as $buku) {
            if ($buku->getJudul() === $judul && !$buku->sedangDipinjam()) {
                $buku->pinjamBuku();
                return;
            }
        }
        echo "Buku '{$judul}' tidak tersedia atau sudah dipinjam.\n";
    }

    // Method untuk mengembalikan buku ke perpustakaan
    public function kembalikanBuku($judul) {
        foreach ($this->buku as $buku) {
            if ($buku->getJudul() === $judul && $buku->sedangDipinjam()) {
                $buku->kembalikanBuku();
                return;
            }
        }
        echo "Buku '{$judul}' tidak dapat dikembalikan.\n";
    }

    // Method untuk mencetak daftar buku yang tersedia di perpustakaan
    public function cetakBukuTersedia() {
        echo "Daftar Buku Tersedia:\n";
        foreach ($this->buku as $buku) {
            if (!$buku->sedangDipinjam()) {
                echo "- {$buku->informasiBuku()}\n";
            }
        }
    }

    // Method untuk mengambil total buku dalam perpustakaan
    public static function getTotalBuku() {
        return self::$totalBuku;
    }
}

echo "\n-----------------------------------------------------------------------------";
echo "\n--------------------------------TAMBAH BUKU----------------------------------\n\n";
// Membuat objek-objek buku
$buku1 = new Buku("Kamus lengkap 3 Bahasa", "Ade", 2003);
$buku2 = new ReferensiBuku("Kamus Bahasa Indonesia", "Fery", 2000, 500);
$buku3 = new Buku("bagaimana mencari kesempatan dalam tech winter 2024", "Angriawan", 2024);

// Membuat objek perpustakaan
$perpustakaan = new Perpustakaan();

// Menambahkan buku-buku ke perpustakaan
$perpustakaan->tambahBuku($buku1);
$perpustakaan->tambahBuku($buku2);
$perpustakaan->tambahBuku($buku3);


echo "\n------------------------------------------------------------------------------\n";
echo "----------------------------- PEMINJAMAN BUKU ---------------------------------\n\n";
// Meminjam buku
$perpustakaan->pinjamBuku("Kamus lengkap 3 Bahasa");
$perpustakaan->pinjamBuku("bagaimana mencari kesempatan dalam tech winter 2024");
echo "\n------------------------------------------------------------------------------\n";
echo "---------------------------- PERPUSTAKAAN UTB --------------------------------\n";
// Mencetak daftar buku yang tersedia
$perpustakaan->cetakBukuTersedia();
echo "\n------------------------------------------------------------------------------\n";
echo "---------------------------- PENGEMBALIAN BUKU -------------------------------\n";
// Mengembalikan buku
$perpustakaan->kembalikanBuku("Kamus lengkap 3 Bahasa");
$perpustakaan->kembalikanBuku("bagaimana mencari kesempatan dalam tech winter 2024");
echo "\n\n\n------------------------------------------------------------------------------\n";
echo "---------------------------- PERPUSTAKAAN UTB --------------------------------\n";
// Mencetak daftar buku yang tersedia setelah pengembalian
$perpustakaan->cetakBukuTersedia();

// Mencetak total buku dalam perpustakaan
echo "Total buku dalam perpustakaan: " . Perpustakaan::getTotalBuku() . "\n";

echo "------------------------------------------------------------------------------\n";
echo "------------------------------------------------------------------------------\n";

?>
