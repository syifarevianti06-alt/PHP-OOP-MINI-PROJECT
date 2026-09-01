<?php
namespace App\Models;

use App\Abstract\ProdukAbstract;
use App\Traits\DiskonTrait;

class Minuman extends ProdukAbstract {
    use DiskonTrait;

    private string $ukuran; // S, M, L

    public function __construct(string $nama, float $harga, string $ukuran = "M") {
        parent::__construct($nama, $harga);
        $this->ukuran = $ukuran;
    }

    public function getKategori(): string {
        return "Minuman";
    }

    // Overriding Method
    public function cetakInfo(): string {
        $diskon = $this->hitungDiskon($this->getHarga());
        $hargaAkhir = $this->getHarga() - $diskon;

        return "{$this->getKategori()}: {$this->nama} [Size {$this->ukuran}] - Rp " . number_format($hargaAkhir, 0, ',', '.');
    }
}