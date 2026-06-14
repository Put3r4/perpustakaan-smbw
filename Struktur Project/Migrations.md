database/migrations
│
├── users
├── roles
│
├── anggota_pelajar
├── anggota_non_pelajar
│
├── kategori_buku
├── buku
│
├── transaksi_pelajar
├── transaksi_non_pelajar
│
├── visitor_logs
│
└── system_settings

---

# Database Keseluruhan Sistem
## Sistem Informasi Perpustakaan Kota Sumbawa
### Laravel 13

---

# 1. Tujuan

Dokumen ini menjadi acuan utama dalam perancangan database Sistem Informasi Perpustakaan Kota Sumbawa berbasis Laravel 13.

Database dirancang untuk mendukung:

- Sistem Keanggotaan (Pelajar dan Non Pelajar)
- Sistem Buku
- Sistem Peminjaman
- Sistem Pengembalian
- Sistem Denda
- Sistem Pelaporan (Keanggotaan, Buku, Denda)
- Sistem Monitoring Pengunjung (Untuk Statistik di Home)
- Sistem Notifikasi (Untuk memberikan promosi membaca buku atau konfirmasi akun berhasil dibuat)


---

## Petugas

Mengelola operasional perpustakaan dan memiliki hak akses penuh.

### Hak Akses

- CRUD Buku
- Peminjaman Buku
- Pengembalian Buku
- Laporan
- Check-In Pengunjung
- Kelola Buku
- Kelola Anggota
- Kelola Transaksi
- Kelola Laporan
- Kelola Jadwal Piket
- Kelola Hak Akses

---

## Pelajar

Anggota perpustakaan kategori pelajar.

### Hak Akses

- Melihat Buku
- Registrasi
- Login
- Melihat Profil

---

## Non Pelajar

Anggota perpustakaan kategori umum.

### Hak Akses

- Melihat Buku
- Registrasi
- Login
- Melihat Profil

---

# 3. Struktur Database

Jumlah tabel utama:

1. users
2. anggota_pelajar
3. anggota_non_pelajar
4. petugas
5. buku
6. transaksi_pelajar
7. transaksi_non_pelajar
8. visitor_logs
9. book_views
10. notifications
11. petugas_shifts <- untuk mengatur jadwal piket

---

# 4. Tabel Users

Digunakan Laravel Authentication.

## Fields

| Nama Field | Tipe |
|------------|------|
| id | bigint |
| name | varchar(100) |
| email | varchar(100) |
| password | varchar(255) |
| role | enum |
| email_verified_at | timestamp |
| created_at | timestamp |
| updated_at | timestamp |

## Role

- superadmin
- petugas
- pelajar
- non_pelajar

---

# 5. Tabel Anggota Pelajar

## Fields

| Nama Field | Tipe |
|------------|------|
| id | bigint |
| user_id | bigint |
| no_anggota | varchar(20) |
| nim_nis | varchar(30) |
| nama_anggota | varchar(100) |
| asal_sekolah | varchar(100) |
| ttl | varchar(100) |
| alamat | text |
| kode_pos | varchar(10) |
| no_telp1 | varchar(20) |
| no_telp2 | varchar(20) |
| tgl_daftar | date |
| nama_ortu | varchar(100) |
| alamat_ortu | text |
| no_telp_ortu | varchar(20) |
| qr_anggota | varchar(255) |
| created_at | timestamp |
| updated_at | timestamp |

---

# 6. Tabel Anggota Non Pelajar

## Fields

| Nama Field | Tipe |
|------------|------|
| id | bigint |
| user_id | bigint |
| no_anggota | varchar(20) |
| nik | varchar(30) |
| nama_anggota | varchar(100) |
| pekerjaan | varchar(100) |
| ttl | varchar(100) |
| alamat | text |
| kode_pos | varchar(10) |
| no_telp1 | varchar(20) |
| no_telp2 | varchar(20) |
| tgl_daftar | date |
| qr_anggota | varchar(255) |
| created_at | timestamp |
| updated_at | timestamp |

---

# 7. Tabel Petugas

## Fields

| Nama Field | Tipe |
|------------|------|
| id | bigint |
| user_id | bigint |
| kode_petugas | varchar(20) |
| nama_petugas | varchar(100) |
| jabatan | varchar(50) |
| foto | varchar(255) |
| no_telp | varchar(20) |
| created_at | timestamp |
| updated_at | timestamp |

---

# 8. Tabel Buku

## Fields

| Nama Field | Tipe |
|------------|------|
| id | bigint |
| kode_buku | varchar(30) |
| no_udc | varchar(30) |
| no_reg | varchar(30) |
| judul | varchar(255) |
| penerbit | varchar(100) |
| pengarang | varchar(100) |
| tahun_terbit | year |
| kota_terbit | varchar(100) |
| bahasa | varchar(50) |
| edisi | varchar(50) |
| deskripsi | text |
| isbn | varchar(30) |
| jumlah_eksemplar | integer |
| stok_tersedia | integer |
| subjek_utama | varchar(100) |
| subjek_tambahan | varchar(100) |
| cover_buku | varchar(255) |
| total_dilihat | integer |
| total_dipinjam | integer |
| status | enum |
| created_at | timestamp |
| updated_at | timestamp |

## Status Buku

- tersedia
- habis
- rusak

---

# 9. Tabel Transaksi Pelajar

## Fields

| Nama Field | Tipe |
|------------|------|
| id | bigint |
| kode_transaksi | varchar(50) |
| no_anggota_p | bigint |
| kode_buku | bigint |
| petugas_pinjam | bigint |
| petugas_kembali | bigint |
| qr_resi | varchar(255) |
| tgl_pinjam | date |
| tgl_jatuh_tempo | date |
| tgl_kembali | date |
| status | enum |
| denda | decimal |
| status_denda | enum |
| created_at | timestamp |
| updated_at | timestamp |

## Status

- dipinjam
- dikembalikan
- terlambat

## Status Denda

- belum_lunas
- lunas

---

# 10. Tabel Transaksi Non Pelajar

Struktur sama dengan transaksi_pelajar.

---

# 11. Tabel Visitor Logs

Digunakan untuk Check-In Pengunjung dengan konsep akan dimasukkan oleh petugas untuk setiap pengunjung yang ada dengan verifikasi username dan password.

## Fields

| Nama Field | Tipe |
|------------|------|
| id | bigint |
| member_type | enum |
| member_id | bigint |
| checkin_at | datetime |
| checkout_at | datetime |
| durasi_kunjungan | integer |
| created_at | timestamp |
| updated_at | timestamp |


---

# 12. Tabel Petugas Shifts

Digunakan untuk jadwal piket petugas.

## Fields

| Nama Field | Tipe |
|------------|------|
| id | bigint |
| petugas_id | bigint |
| tanggal | date |
| jam_mulai | time |
| jam_selesai | time |
| created_at | timestamp |
| updated_at | timestamp |

---

# 14. Tabel Notifications

Digunakan untuk notifikasi sistem.

## Fields

| Nama Field | Tipe |
|------------|------|
| id | bigint |
| user_id | bigint |
| title | varchar(255) |
| message | text |
| is_read | boolean |
| created_at | timestamp |
| updated_at | timestamp |

---

# 15. Aturan Bisnis

## Peminjaman

- Maksimal 2 buku aktif.
- Lama peminjaman 7 hari.

## Pengembalian

- Wajib melalui petugas.

## Denda

- Rp500 per hari keterlambatan.
- Dapat diubah melalui konfigurasi sistem.

## Tracking Buku

- Hanya dicatat jika pengunjung melihat detail buku minimal 60 detik.

---

# 16. Acceptance Criteria

Database dianggap selesai apabila:

- Seluruh tabel berhasil dimigrasikan.
- Seluruh relasi berhasil dibuat.
- Foreign Key berjalan normal.
- Seeder role berhasil dibuat.
- Data dapat digunakan seluruh sprint berikutnya.

---

# 17. Output Yang Diharapkan

- ERD Lengkap
- Migration Laravel 13
- Model Laravel 13
- Factory
- Seeder
- Foreign Key
- Indexing Database