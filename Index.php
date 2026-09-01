<?php
namespace App\Traits {
    trait DiskonTrait {
        private float $persenDiskon = 0;

        public function setDiskon(float $persen): void {
            $this->persenDiskon = $persen;
        }

        public function hitungDiskon(float $harga): float {
            return $harga * ($this->persenDiskon / 100);
        }
    }
}


namespace App\Interfaces {
    interface CetakStrukInterface {
        public function cetakInfo(): string;
    }
}


namespace App\Abstract {
    use App\Interfaces\CetakStrukInterface;

    abstract class ProdukAbstract implements CetakStrukInterface {
        // Encapsulation & Visibility (protected & private)
        protected string $nama;
        private float $harga;

        // Constructor
        public function __construct(string $nama, float $harga) {
            $this->nama = $nama;
            $this->setHarga($harga);
        }

        // Encapsulation (Getter & Setter)
        public function getHarga(): float {
            return $this->harga;
        }

        public function setHarga(float $harga): void {
            if ($harga < 0) {
                throw new \InvalidArgumentException("Harga tidak boleh negatif!");
            }
            $this->harga = $harga;
        }

        public function getNama(): string {
            return $this->nama;
        }

        // Abstract Method
        abstract public function getKategori(): string;
    }
}


namespace App\Models {
    use App\Abstract\ProdukAbstract;
    use App\Traits\DiskonTrait;

    class Makanan extends ProdukAbstract {
        use DiskonTrait; // Trait

        private bool $isSpicy;

        // Constructor Overriding
        public function __construct(string $nama, float $harga, bool $isSpicy = false) {
            parent::__construct($nama, $harga);
            $this->isSpicy = $isSpicy;
        }

        public function getKategori(): string {
            return "Makanan";
        }

        // Method Overriding
        public function cetakInfo(): string {
            $pedas = $this->isSpicy ? "(Pedas)" : "(Tidak Pedas)";
            $diskon = $this->hitungDiskon($this->getHarga());
            $hargaAkhir = $this->getHarga() - $diskon;

            return "{$this->getKategori()}: {$this->nama} {$pedas} - Rp " . number_format($hargaAkhir, 0, ',', '.');
        }
    }

    class Minuman extends ProdukAbstract {
        use DiskonTrait; // Trait

        private string $ukuran;

        public function __construct(string $nama, float $harga, string $ukuran = "M") {
            parent::__construct($nama, $harga);
            $this->ukuran = $ukuran;
        }

        public function getKategori(): string {
            return "Minuman";
        }

        // Method Overriding
        public function cetakInfo(): string {
            $diskon = $this->hitungDiskon($this->getHarga());
            $hargaAkhir = $this->getHarga() - $diskon;

            return "{$this->getKategori()}: {$this->nama} [Size {$this->ukuran}] - Rp " . number_format($hargaAkhir, 0, ',', '.');
        }
    }
}


namespace {
    use App\Models\Makanan;
    use App\Models\Minuman;

    try {
        // Instansiasi Object menggunakan Constructor
        $makanan1 = new Makanan("Nasi Goreng Spesial", 25000, true);
        $makanan1->setDiskon(10); // Menggunakan Trait

        $minuman1 = new Minuman("Es Teh Manis", 8000, "L");
        $minuman1->setDiskon(0);

        $makanan2 = new Makanan("Mie Ayam", 18000, false);

        // Menampilkan Output
        echo "<h2>=== DAFTAR MENU KAFE ===</h2>";
        echo $makanan1->cetakInfo() . "<br><br>";
        echo $minuman1->cetakInfo() . "<br><br>";
        echo $makanan2->cetakInfo() . "<br><br>";

    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}