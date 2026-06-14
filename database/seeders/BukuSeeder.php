<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\RakBuku;
use App\Models\Buku;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Seed 10 Kategori
        $kategoriList = [
            ['nama_kategori' => 'Sains & Matematika', 'deskripsi' => 'Buku-buku tentang ilmu alam, fisika, kimia, biologi, dan matematika.'],
            ['nama_kategori' => 'Teknologi & Komputer', 'deskripsi' => 'Buku-buku pemograman, jaringan, AI, hardware, dan teknologi informasi.'],
            ['nama_kategori' => 'Sastra & Novel', 'deskripsi' => 'Koleksi novel, cerita pendek, puisi, dan karya sastra klasik maupun modern.'],
            ['nama_kategori' => 'Sejarah & Geografi', 'deskripsi' => 'Buku sejarah nasional, sejarah dunia, geografi, dan atlas.'],
            ['nama_kategori' => 'Agama & Filsafat', 'deskripsi' => 'Buku-buku kajian keagamaan, spiritualitas, teologi, dan filsafat barat/timur.'],
            ['nama_kategori' => 'Seni & Kebudayaan', 'deskripsi' => 'Koleksi seni musik, seni rupa, desain komunikasi visual, dan kebudayaan daerah.'],
            ['nama_kategori' => 'Sosial & Politik', 'deskripsi' => 'Buku sosiologi, ilmu politik, ekonomi, hukum, dan kebijakan publik.'],
            ['nama_kategori' => 'Kesehatan & Kedokteran', 'deskripsi' => 'Buku panduan kesehatan, kedokteran umum, keperawatan, dan nutrisi.'],
            ['nama_kategori' => 'Bahasa & Kamus', 'deskripsi' => 'Kamus bahasa asing, tata bahasa, panduan belajar bahasa, dan linguistik.'],
            ['nama_kategori' => 'Komik & Fiksi Ilmiah', 'deskripsi' => 'Komik pendidikan, novel grafis, fiksi ilmiah, dan cerita fantasi.'],
        ];

        foreach ($kategoriList as $k) {
            Kategori::create($k);
        }

        // 2. Seed 7 Rak Buku
        $rakList = [
            ['kode_rak' => 'RAK-A1', 'nama_rak' => 'Rak Sains & Matematika', 'lokasi' => 'Lantai 1 - Sayap Kanan'],
            ['kode_rak' => 'RAK-B2', 'nama_rak' => 'Rak Teknologi & Komputer', 'lokasi' => 'Lantai 1 - Sayap Kiri'],
            ['kode_rak' => 'RAK-C3', 'nama_rak' => 'Rak Sastra & Novel', 'lokasi' => 'Lantai 2 - Ruang Tengah'],
            ['kode_rak' => 'RAK-D4', 'nama_rak' => 'Rak Sejarah & Sosial', 'lokasi' => 'Lantai 2 - Sayap Kanan'],
            ['kode_rak' => 'RAK-E5', 'nama_rak' => 'Rak Agama & Filsafat', 'lokasi' => 'Lantai 1 - Depan Mushola'],
            ['kode_rak' => 'RAK-F6', 'nama_rak' => 'Rak Bahasa & Kamus', 'lokasi' => 'Lantai 2 - Sayap Kiri'],
            ['kode_rak' => 'RAK-G7', 'nama_rak' => 'Rak Komik & Umum', 'lokasi' => 'Lantai 1 - Dekat Lobby'],
        ];

        $rakIds = [];
        foreach ($rakList as $r) {
            $rak = RakBuku::create($r);
            $rakIds[] = $rak->id;
        }

        // 3. Seed 1000 Buku
        $books = [];
        $now = now();

        // Subjek list untuk data realistis
        $subjekUtama = ['Sains', 'Teknologi', 'Fiksi', 'Sejarah', 'Sosial', 'Bahasa', 'Seni', 'Agama', 'Kesehatan', 'Komik'];

        for ($i = 1; $i <= 1000; $i++) {
            $qty = $faker->numberBetween(1, 5);
            $books[] = [
                'kode_buku'        => 'BK-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'no_udc'           => 'UDC-' . $faker->numerify('###.##'),
                'no_reg'           => 'REG-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'judul'            => ucwords($faker->words($faker->numberBetween(2, 5), true)),
                'penerbit'         => $faker->company(),
                'pengarang'        => $faker->name(),
                'tahun_terbit'     => $faker->year(),
                'kota_terbit'      => $faker->city(),
                'bahasa'           => 'Indonesia',
                'edisi'            => 'Edisi Ke-' . $faker->numberBetween(1, 4),
                'deskripsi'        => $faker->sentence(12),
                'isbn'             => $faker->isbn13(),
                'jumlah_eksemplar' => $qty,
                'stok_tersedia'    => $qty,
                'subjek_utama'     => $faker->randomElement($subjekUtama),
                'subjek_tambahan'  => $faker->word(),
                'cover_buku'       => null,
                'total_dilihat'    => $faker->numberBetween(10, 500),
                'total_dipinjam'   => 0, // Akan di-update sesuai relasi peminjaman di TransaksiSeeder
                'status'           => 'tersedia',
                'rak_id'           => $faker->randomElement($rakIds),
                'created_at'       => $now,
                'updated_at'       => $now,
            ];

            // Batch insert every 200 records to save memory and avoid timeout
            if (count($books) === 200) {
                DB::table('buku')->insert($books);
                $books = [];
            }
        }

        // Insert remaining records if any
        if (count($books) > 0) {
            DB::table('buku')->insert($books);
        }
    }
}
