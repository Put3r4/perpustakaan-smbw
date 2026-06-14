<?php

namespace Database\Factories;

use App\Models\Buku;
use Illuminate\Database\Eloquent\Factories\Factory;

class BukuFactory extends Factory
{
    protected $model = Buku::class;

    public function definition(): array
    {
        $qty = $this->faker->numberBetween(5, 15);
        return [
            'kode_buku' => 'BK-' . $this->faker->unique()->numberBetween(1000, 9999),
            'no_udc' => 'UDC-' . $this->faker->numberBetween(100, 999),
            'no_reg' => 'REG-' . $this->faker->numberBetween(10000, 99999),
            'judul' => $this->faker->sentence(3),
            'penerbit' => $this->faker->company(),
            'pengarang' => $this->faker->name(),
            'tahun_terbit' => $this->faker->year(),
            'kota_terbit' => $this->faker->city(),
            'bahasa' => 'Indonesia',
            'jumlah_eksemplar' => $qty,
            'stok_tersedia' => $qty,
            'status' => 'tersedia',
        ];
    }
}