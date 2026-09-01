<?php
namespace App\Traits;

trait DiskonTrait {
    // Visibility: private property di dalam trait
    private float $persenDiskon = 0;

    public function setDiskon(float $persen): void {
        $this->persenDiskon = $persen;
    }

    public function hitungDiskon(float $harga): float {
        return $harga * ($this->persenDiskon / 100);
    }
}