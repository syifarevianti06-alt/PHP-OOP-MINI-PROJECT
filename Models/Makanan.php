<?php
namespace App\Models;

use App\Abstract\ProdukAbstract;
use App\Traits\DiskonTrait;

class Makanan extends ProdukAbstract {
    // Trait
    use DiskonTrait;

    private bool $isSpicy;

    // Constructor Override (Memanggil parent constructor)
    public function __construct(string $nama, float $harga, bool $isSpicy = false) {
        parent::__construct($nama, $harga);
        $this->isSpicy = $isSpicy;
    }

    // Implementasi Abstract Method
    public function getKategori(): string {
        return "Makanan";
    }

    // Overriding Method dari Interface yang diturunkan lewat Abstract Class
    public function cetakInfo(): string {
        $pedas = $this->isSpicy ? "(Pedas)" : "(Tidak Pedas)";
        $diskon = $this->hitungDiskon($this->getHarga());
        $hargaAkhir = $this->getHarga() - $diskon;

        return "{$this->getKategori()}: {$this->nama} {$pedas} - Rp " . number_format($hargaAkhir, 0, ',', '.');
    }
}