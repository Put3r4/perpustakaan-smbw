routes
│
├── web.php
├── auth.php
│
├── anggota.php
├── buku.php
├── transaksi.php
├── kunjungan.php
├── laporan.php
└── export.php

---

require __DIR__.'/auth.php';
require __DIR__.'/anggota.php';
require __DIR__.'/buku.php';
require __DIR__.'/transaksi.php';
require __DIR__.'/kunjungan.php';
require __DIR__.'/laporan.php';
require __DIR__.'/export.php';