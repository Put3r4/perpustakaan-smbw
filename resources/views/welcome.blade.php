<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan Digital Kabupaten Sumbawa</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #FFFFFF; color: #1F2937; }
        .custom-shadow { box-shadow: 0 10px 30px -10px rgba(15, 45, 82, 0.08); }
    </style>
</head>
<body class="antialiased bg-white" x-data="{ searchOpen: false, mobileMenu: false }">

    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-gradient-to-tr from-libDark to-libPrimary rounded-xl flex items-center justify-center text-white shadow-md shadow-libPrimary/20">
                        <i class="fa-solid fa-book-open text-xl"></i>
                    </div>
                    <div>
                        <span class="text-xs font-bold tracking-widest text-libPrimary block">PERPUSTAKAAN DIGITAL</span>
                        <span class="text-base font-extrabold text-libDark tracking-tight block">KABUPATEN SUMBAWA</span>
                    </div>
                </div>

                <nav class="hidden md:flex items-center gap-8 font-medium text-sm text-gray-600">
                    <a href="#" class="text-libPrimary border-b-2 border-libPrimary px-1 py-2 transition-all">Home</a>
                    <a href="#" class="hover:text-libPrimary transition-all px-1 py-2">About Us</a>
                    <a href="#" class="hover:text-libPrimary transition-all px-1 py-2">Rak Buku</a>
                    <a href="#" class="hover:text-libPrimary transition-all px-1 py-2">FAQ</a>
                    <a href="#" class="hover:text-libPrimary transition-all px-1 py-2">Contact</a>
                </nav>

                <div class="hidden md:flex items-center gap-4">
                    <button @click="searchOpen = !searchOpen" class="w-10 h-10 rounded-xl flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-all">
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </button>

                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-3 bg-gray-50 hover:bg-gray-100 p-1.5 pr-4 rounded-xl transition-all">
                                <img class="h-8 w-8 rounded-lg object-cover ring-2 ring-libPrimary/20" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80" alt="Avatar">
                                <div class="text-left">
                                    <p class="text-xs font-semibold text-libDark leading-none">{{ Auth::user()->name ?? 'Saputra Budiman' }}</p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">Anggota Aktif</p>
                                </div>
                                <i class="fa-solid fa-chevron-down text-xs text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                            </button>
                            <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-1 z-50">
                                <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50"><i class="fa-regular fa-user mr-2 text-gray-400"></i> Profil Saya</a>
                                <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50"><i class="fa-solid fa-bookmark mr-2 text-gray-400"></i> Peminjaman</a>
                                <hr class="border-gray-100 my-1">
                                <a href="#" class="block px-4 py-2.5 text-sm text-red-600 hover:bg-red-50"><i class="fa-solid fa-arrow-right-from-bracket mr-2 text-red-400"></i> Keluar</a>
                            </div>
                        </div>
                    @else
                        <a href="#" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-libDark hover:bg-gray-50 transition-all">Masuk</a>
                        <a href="#" class="px-5 py-2.5 bg-libPrimary hover:bg-blue-600 text-white rounded-xl text-sm font-semibold shadow-md shadow-libPrimary/20 transition-all">Daftar Anggota</a>
                    @endauth
                </div>

                <div class="md:hidden flex items-center gap-2">
                    <button @click="searchOpen = !searchOpen" class="w-10 h-10 rounded-xl flex items-center justify-center text-gray-500">
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </button>
                    <button @click="mobileMenu = !mobileMenu" class="w-10 h-10 rounded-xl flex items-center justify-center text-libDark">
                        <i class="fa-solid" :class="mobileMenu ? 'fa-xmark text-xl' : 'fa-bars text-xl'"></i>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="searchOpen" x-transition class="absolute top-full left-0 w-full bg-white border-b border-gray-100 p-4 shadow-md">
            <div class="max-w-3xl mx-auto">
                <div class="relative flex items-center">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 text-gray-400"></i>
                    <input type="text" placeholder="Cari judul buku, penulis, atau keyword katalog..." class="w-full pl-12 pr-4 py-3 bg-libLight rounded-xl border-none focus:ring-2 focus:ring-libPrimary/50 outline-none text-sm text-libDark">
                </div>
            </div>
        </div>
    </header>

    <section class="relative bg-gradient-to-b from-libLight/60 to-white pt-8 pb-16 overflow-hidden" x-data="{ activeSlide: 1 }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-wrap items-center justify-center gap-6 md:gap-12 mb-12 bg-white border border-gray-100 rounded-2xl p-4 max-w-3xl mx-auto custom-shadow">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-libPrimary/10 text-libPrimary rounded-lg flex items-center justify-center"><i class="fa-solid fa-book text-sm"></i></div>
                    <div><span class="block font-bold text-libDark text-sm">10.000+</span><span class="text-[11px] text-gray-400 block font-medium">Koleksi Buku</span></div>
                </div>
                <div class="h-6 w-px bg-gray-200 hidden sm:block"></div>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-libGold/10 text-libGold rounded-lg flex items-center justify-center"><i class="fa-solid fa-users text-sm"></i></div>
                    <div><span class="block font-bold text-libDark text-sm">3.000+</span><span class="text-[11px] text-gray-400 block font-medium">Anggota Aktif</span></div>
                </div>
                <div class="h-6 w-px bg-gray-200 hidden sm:block"></div>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-green-100 text-green-600 rounded-lg flex items-center justify-center"><i class="fa-solid fa-chart-line text-sm"></i></div>
                    <div><span class="block font-bold text-libDark text-sm">500+</span><span class="text-[11px] text-gray-400 block font-medium">Pengunjung Bulanan</span></div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center min-h-[460px]">
                <div class="lg:col-span-6 z-10 space-y-6 text-center lg:text-left">
                    <div x-show="activeSlide === 1" x-transition:enter="transition ease-out duration-500" class="space-y-6">
                        <span class="px-4 py-1.5 bg-libPrimary/10 text-libPrimary rounded-full font-semibold text-xs inline-block tracking-wide">Pusat Literasi Digital</span>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-libDark leading-tight">Gudang Ilmu Pengetahuan untuk <span class="text-libPrimary">Generasi Sumbawa</span></h1>
                        <p class="text-gray-500 text-sm sm:text-base max-w-xl mx-auto lg:mx-0 font-normal leading-relaxed">Akses ribuan literatur ilmiah, buku pelajaran, karya lokal, hingga jurnal internasional dengan mudah kapan saja dan di mana saja.</p>
                    </div>
                    <div x-show="activeSlide === 2" x-transition:enter="transition ease-out duration-500" class="space-y-6" style="display: none;">
                        <span class="px-4 py-1.5 bg-libGold/10 text-libGold rounded-full font-semibold text-xs inline-block tracking-wide">Akses Tanpa Batas</span>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-libDark leading-tight">Ribuan Koleksi Buku <span class="text-libGold">Digital & Fisik</span></h1>
                        <p class="text-gray-500 text-sm sm:text-base max-w-xl mx-auto lg:mx-0 font-normal leading-relaxed">Mulai dari buku fiksi kreatif hingga referensi riset akademik untuk mendukung kurikulum Merdeka Belajar di wilayah Tana Samawa.</p>
                    </div>
                    <div x-show="activeSlide === 3" x-transition:enter="transition ease-out duration-500" class="space-y-6" style="display: none;">
                        <span class="px-4 py-1.5 bg-green-100 text-green-600 rounded-full font-semibold text-xs inline-block tracking-wide">Inovasi Layanan</span>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-libDark leading-tight">Perpustakaan Modern <span class="text-green-600">Untuk Semua Usia</span></h1>
                        <p class="text-gray-500 text-sm sm:text-base max-w-xl mx-auto lg:mx-0 font-normal leading-relaxed">Sistem pendaftaran instan, manajemen peminjaman transparan, dan ruang baca digital terintegrasi untuk seluruh lapisan masyarakat Sumbawa.</p>
                    </div>

                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-2">
                        <a href="#" class="px-6 py-3.5 bg-libDark hover:bg-slate-800 text-white font-semibold text-sm rounded-xl transition-all shadow-lg shadow-libDark/10 flex items-center gap-2"><i class="fa-solid fa-magnifying-glass"></i> Jelajahi Buku</a>
                        <a href="#" class="px-6 py-3.5 bg-white border-2 border-gray-200 hover:border-libPrimary text-gray-700 hover:text-libPrimary font-semibold text-sm rounded-xl transition-all flex items-center gap-2">Daftar Anggota <i class="fa-solid fa-arrow-right"></i></a>
                    </div>

                    <div class="flex items-center justify-center lg:justify-start gap-2.5 pt-6">
                        <button @click="activeSlide = 1" class="h-2 rounded-full transition-all duration-300" :class="activeSlide === 1 ? 'w-8 bg-libPrimary' : 'w-2 bg-gray-300'"></button>
                        <button @click="activeSlide = 2" class="h-2 rounded-full transition-all duration-300" :class="activeSlide === 2 ? 'w-8 bg-libPrimary' : 'w-2 bg-gray-300'"></button>
                        <button @click="activeSlide = 3" class="h-2 rounded-full transition-all duration-300" :class="activeSlide === 3 ? 'w-8 bg-libPrimary' : 'w-2 bg-gray-300'"></button>
                    </div>
                </div>

                <div class="lg:col-span-6 relative flex justify-center items-center">
                    <div class="relative w-full max-w-[440px] aspect-square rounded-3xl bg-gradient-to-tr from-blue-500/10 to-libPrimary/5 p-6 border border-white/60">
                        <div class="w-full h-full bg-white/70 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-100 overflow-hidden relative p-4 flex flex-col justify-between">
                            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                                <div class="flex gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-red-400"></span><span class="w-2.5 h-2.5 rounded-full bg-yellow-400"></span><span class="w-2.5 h-2.5 rounded-full bg-green-400"></span></div>
                                <span class="text-[10px] text-gray-400 bg-gray-100 px-3 py-1 rounded-md">Sumbawa-Library App v2.0</span>
                            </div>
                            <div class="my-auto space-y-3 py-4">
                                <div class="w-2/3 h-4 bg-gray-200 rounded-md"></div>
                                <div class="w-full h-3 bg-gray-100 rounded-md"></div>
                                <div class="w-5/6 h-3 bg-gray-100 rounded-md"></div>
                                <div class="grid grid-cols-3 gap-3 pt-2">
                                    <div class="aspect-[3/4] bg-libDark/10 rounded-lg border border-libDark/5 flex flex-col justify-end p-2"><div class="h-2 w-full bg-libDark/30 rounded"></div></div>
                                    <div class="aspect-[3/4] bg-libPrimary/10 rounded-lg border border-libPrimary/5 flex flex-col justify-end p-2"><div class="h-2 w-full bg-libPrimary/30 rounded"></div></div>
                                    <div class="aspect-[3/4] bg-libGold/10 rounded-lg border border-libGold/5 flex flex-col justify-end p-2"><div class="h-2 w-full bg-libGold/30 rounded"></div></div>
                                </div>
                            </div>
                            <div class="bg-libDark text-white p-3 rounded-xl flex items-center justify-between text-xs shadow-md">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-graduation-cap text-libGold"></i>
                                    <span>Mahasiswa UTS Aktif Membaca</span>
                                </div>
                                <span class="font-bold text-[10px] text-libGold">LIVE</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="relative z-20 -mt-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-xl shadow-libDark/[0.03] grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            
            <a href="#" class="group p-4 bg-libLight/50 hover:bg-libPrimary rounded-xl transition-all duration-300 text-center flex flex-col items-center justify-center border border-gray-50 hover:shadow-lg hover:shadow-libPrimary/20">
                <div class="w-12 h-12 rounded-xl bg-libPrimary/10 group-hover:bg-white/20 text-libPrimary group-hover:text-white flex items-center justify-center mb-3 transition-colors">
                    <i class="fa-solid fa-magnifying-glass text-lg"></i>
                </div>
                <span class="text-xs font-bold text-libDark group-hover:text-white block transition-colors">Cari Buku</span>
            </a>

            <a href="#" class="group p-4 bg-libLight/50 hover:bg-libPrimary rounded-xl transition-all duration-300 text-center flex flex-col items-center justify-center border border-gray-50 hover:shadow-lg hover:shadow-libPrimary/20">
                <div class="w-12 h-12 rounded-xl bg-orange-100 group-hover:bg-white/20 text-orange-600 group-hover:text-white flex items-center justify-center mb-3 transition-colors">
                    <i class="fa-solid fa-book-medical text-lg"></i>
                </div>
                <span class="text-xs font-bold text-libDark group-hover:text-white block transition-colors">Buku Terbaru</span>
            </a>

            <a href="#" class="group p-4 bg-libLight/50 hover:bg-libPrimary rounded-xl transition-all duration-300 text-center flex flex-col items-center justify-center border border-gray-50 hover:shadow-lg hover:shadow-libPrimary/20">
                <div class="w-12 h-12 rounded-xl bg-libGold/10 group-hover:bg-white/20 text-libGold group-hover:text-white flex items-center justify-center mb-3 transition-colors">
                    <i class="fa-solid fa-star text-lg"></i>
                </div>
                <span class="text-xs font-bold text-libDark group-hover:text-white block transition-colors">Buku Favorit</span>
            </a>

            <a href="#" class="group p-4 bg-libLight/50 hover:bg-libPrimary rounded-xl transition-all duration-300 text-center flex flex-col items-center justify-center border border-gray-50 hover:shadow-lg hover:shadow-libPrimary/20">
                <div class="w-12 h-12 rounded-xl bg-green-100 group-hover:bg-white/20 text-green-600 group-hover:text-white flex items-center justify-center mb-3 transition-colors">
                    <i class="fa-solid fa-user-plus text-lg"></i>
                </div>
                <span class="text-xs font-bold text-libDark group-hover:text-white block transition-colors">Daftar Anggota</span>
            </a>

            <a href="#" class="group p-4 bg-libLight/50 hover:bg-libPrimary rounded-xl transition-all duration-300 text-center flex flex-col items-center justify-center border border-gray-50 hover:shadow-lg hover:shadow-libPrimary/20">
                <div class="w-12 h-12 rounded-xl bg-purple-100 group-hover:bg-white/20 text-purple-600 group-hover:text-white flex items-center justify-center mb-3 transition-colors">
                    <i class="fa-solid fa-calendar-clock text-lg"></i>
                </div>
                <span class="text-xs font-bold text-libDark group-hover:text-white block transition-colors">Jadwal Layanan</span>
            </a>

            <a href="#" class="group p-4 bg-libLight/50 hover:bg-libPrimary rounded-xl transition-all duration-300 text-center flex flex-col items-center justify-center border border-gray-50 hover:shadow-lg hover:shadow-libPrimary/20">
                <div class="w-12 h-12 rounded-xl bg-cyan-100 group-hover:bg-white/20 text-cyan-600 group-hover:text-white flex items-center justify-center mb-3 transition-colors">
                    <i class="fa-solid fa-chart-pie text-lg"></i>
                </div>
                <span class="text-xs font-bold text-libDark group-hover:text-white block transition-colors">Statistik</span>
            </a>

        </div>
    </section>

    <section class="bg-libLight py-16 mt-8" x-data="{ currentTab: 'populer' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-libDark tracking-tight">Buku Pilihan untuk Anda</h2>
                    <p class="text-sm text-gray-400 mt-1">Koleksi yang paling banyak dipinjam dan direkomendasikan oleh perpustakaan.</p>
                </div>
                <div class="flex bg-white border border-gray-200/60 p-1.5 rounded-xl gap-1 self-start md:self-auto">
                    <button @click="currentTab = 'populer'" :class="currentTab === 'populer' ? 'bg-libDark text-white shadow-sm' : 'text-gray-500 hover:text-libDark'" class="px-4 py-2 rounded-lg text-xs font-bold transition-all">Terpopuler</button>
                    <button @click="currentTab = 'terbaru'" :class="currentTab === 'terbaru' ? 'bg-libDark text-white shadow-sm' : 'text-gray-500 hover:text-libDark'" class="px-4 py-2 rounded-lg text-xs font-bold transition-all">Terbaru</button>
                    <button @click="currentTab = 'petugas'" :class="currentTab === 'petugas' ? 'bg-libDark text-white shadow-sm' : 'text-gray-500 hover:text-libDark'" class="px-4 py-2 rounded-lg text-xs font-bold transition-all">Rekomendasi Petugas</button>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                
                @for ($i = 1; $i <= 4; $i++)
                <div class="bg-white rounded-2xl border border-gray-100 p-4 transition-all duration-300 hover:shadow-xl group flex flex-col justify-between">
                    <div>
                        <div class="aspect-[3/4] rounded-xl bg-gray-100 mb-4 overflow-hidden relative shadow-sm group-hover:shadow-md transition-shadow">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent z-10"></div>
                            <div class="w-full h-full bg-gradient-to-br from-libDark to-slate-700 flex flex-col justify-between p-4 text-white">
                                <span class="text-[9px] bg-white/20 uppercase tracking-widest font-bold px-2 py-1 rounded w-fit backdrop-blur-sm">Informatika</span>
                                <div class="space-y-1">
                                    <p class="text-xs font-bold leading-tight line-clamp-2">Dasar Algoritma & Struktur Data</p>
                                    <p class="text-[9px] text-gray-300">Prof. Budianto</p>
                                </div>
                            </div>
                            <span class="absolute top-3 right-3 z-20 text-[9px] font-bold px-2.5 py-1 bg-green-500 text-white rounded-full shadow-sm">Tersedia</span>
                        </div>
                        <div class="space-y-1">
                            <span class="text-[10px] font-semibold text-libPrimary tracking-wider uppercase">Teknologi</span>
                            <h3 class="text-xs font-bold text-libDark group-hover:text-libPrimary transition-colors line-clamp-1">Dasar Algoritma & Struktur Data dengan Python</h3>
                            <p class="text-[11px] text-gray-400">Prof. Dr. Ir. Budianto, M.T.</p>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-3 border-t border-gray-50 flex items-center justify-between">
                        <div class="text-[10px] text-gray-400 font-medium">
                            <span class="block text-libDark font-bold"><i class="fa-solid fa-fire text-libGold mr-1"></i> 142x</span> Dipinjam
                        </div>
                        <a href="#" class="px-3 py-2 bg-libLight group-hover:bg-libPrimary text-libDark group-hover:text-white text-xs font-bold rounded-lg transition-colors flex items-center gap-1.5">
                            Detail <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
                @endfor

            </div>

        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-gradient-to-r from-libDark to-blue-900 text-white rounded-3xl p-8 lg:p-12 relative overflow-hidden shadow-2xl">
            <div class="absolute -right-16 -bottom-16 w-64 h-64 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-6 space-y-4">
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Jadilah Anggota Perpustakaan Digital Sumbawa</h2>
                    <p class="text-blue-100/80 text-sm max-w-lg leading-relaxed">Nikmati berbagai manfaat eksklusif dan kemudahan akses seluruh koleksi literatur fisik maupun modul digital dalam satu genggaman akun.</p>
                    <div class="pt-2">
                        <a href="#" class="px-6 py-3.5 bg-libGold hover:bg-amber-600 text-libDark font-bold text-sm rounded-xl transition-all shadow-lg inline-block">Daftar Sekarang <i class="fa-solid fa-user-plus ml-2"></i></a>
                    </div>
                </div>
                
                <div class="lg:col-span-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-libGold/20 text-libGold flex items-center justify-center shrink-0 mt-0.5"><i class="fa-solid fa-bolt-lightning text-xs"></i></div>
                        <p class="text-xs font-medium text-gray-200"><strong class="text-white block font-bold mb-0.5">Sirkulasi Kilat</strong> Meminjam buku fisik lebih cepat tanpa antrean manual.</p>
                    </div>
                    <div class="p-4 bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-libGold/20 text-libGold flex items-center justify-center shrink-0 mt-0.5"><i class="fa-solid fa-clock-rotate-left text-xs"></i></div>
                        <p class="text-xs font-medium text-gray-200"><strong class="text-white block font-bold mb-0.5">Log Personal</strong> Riwayat peminjaman rapi terpantau aman.</p>
                    </div>
                    <div class="p-4 bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-libGold/20 text-libGold flex items-center justify-center shrink-0 mt-0.5"><i class="fa-solid fa-globe text-xs"></i></div>
                        <p class="text-xs font-medium text-gray-200"><strong class="text-white block font-bold mb-0.5">Koleksi Digital</strong> Akses e-book eksklusif langsung dari smartphone.</p>
                    </div>
                    <div class="p-4 bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-libGold/20 text-libGold flex items-center justify-center shrink-0 mt-0.5"><i class="fa-solid fa-bell text-xs"></i></div>
                        <p class="text-xs font-medium text-gray-200"><strong class="text-white block font-bold mb-0.5">Notifikasi Cerdas</strong> Pengingat otomatis pengembalian buku tepat waktu.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16 border-t border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <div class="lg:col-span-7 space-y-6" x-data="{ activeFaq: null }">
                <div>
                    <h2 class="text-2xl font-bold text-libDark tracking-tight">Pertanyaan yang Sering Ditanyakan</h2>
                    <p class="text-sm text-gray-400 mt-1">Panduan praktis penggunaan ekosistem perpustakaan digital.</p>
                </div>

                <div class="space-y-3">
                    <div class="border border-gray-100 rounded-xl overflow-hidden transition-all" :class="activeFaq === 1 ? 'border-libPrimary bg-gray-50/50' : 'bg-white'">
                        <button @click="activeFaq = (activeFaq === 1 ? null : 1)" class="w-full flex items-center justify-between p-4 font-semibold text-sm text-libDark text-left">
                            <span>Bagaimana cara mendaftar menjadi anggota online?</span>
                            <i class="fa-solid" :class="activeFaq === 1 ? 'fa-minus text-libPrimary' : 'fa-plus text-gray-400'"></i>
                        </button>
                        <div x-show="activeFaq === 1" x-transition class="p-4 pt-0 text-xs text-gray-500 leading-relaxed border-t border-gray-100/50">
                            Anda cukup klik tombol "Daftar Anggota", masukkan data NIK/NIM mahasiswa aktif UTS, lampirkan kartu identitas, dan akun Anda akan diverifikasi dalam kurun waktu maksimal 1x24 jam kerja oleh admin layanan sirkulasi.
                        </div>
                    </div>
                    <div class="border border-gray-100 rounded-xl overflow-hidden transition-all" :class="activeFaq === 2 ? 'border-libPrimary bg-gray-50/50' : 'bg-white'">
                        <button @click="activeFaq = (activeFaq === 2 ? null : 2)" class="w-full flex items-center justify-between p-4 font-semibold text-sm text-libDark text-left">
                            <span>Berapa lama batas maksimal waktu peminjaman buku?</span>
                            <i class="fa-solid" :class="activeFaq === 2 ? 'fa-minus text-libPrimary' : 'fa-plus text-gray-400'"></i>
                        </button>
                        <div x-show="activeFaq === 2" x-transition class="p-4 pt-0 text-xs text-gray-500 leading-relaxed border-t border-gray-100/50">
                            Masa peminjaman standar untuk buku fisik adalah 7 hari kalender, dan dapat diperpanjang secara mandiri lewat dashboard profil anggota sebanyak 1 kali perpanjangan (total maksimal 14 hari).
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-libDark tracking-tight">Petugas Piket Hari Ini</h2>
                    <p class="text-sm text-gray-400 mt-1">Staf operasional yang siap membantu Anda hari ini.</p>
                </div>

                <div class="space-y-3.5">
                    
                    <div class="bg-white border border-gray-100 p-4 rounded-xl flex items-center justify-between custom-shadow relative overflow-hidden">
                        <div class="absolute left-0 top-0 h-full w-1 bg-green-500"></div>
                        
                        <div class="flex items-center gap-4 pl-1">
                            <div class="relative">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80" class="w-12 h-12 rounded-xl object-cover" alt="Petugas">
                                <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-libDark">Ahmad Fauzi, S.I.Pust.</h4>
                                <p class="text-[11px] text-gray-400 font-medium">Kepala Layanan Utama</p>
                                <span class="inline-block px-2 py-0.5 bg-libLight text-libDark text-[10px] font-semibold rounded mt-1">Shift Pagi (08:00 - 12:00)</span>
                            </div>
                        </div>
                        <span class="text-[10px] bg-green-50 font-bold text-green-600 px-2.5 py-1 rounded-md shrink-0">Sedang Bertugas</span>
                    </div>

                    <div class="bg-white border border-gray-100 p-4 rounded-xl flex items-center justify-between relative overflow-hidden opacity-85">
                        <div class="absolute left-0 top-0 h-full w-1 bg-libPrimary"></div>
                        <div class="flex items-center gap-4 pl-1">
                            <div class="relative">
                                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=100&q=80" class="w-12 h-12 rounded-xl object-cover" alt="Petugas">
                                <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-blue-500 border-2 border-white rounded-full"></span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-libDark">Nur Aisyah, A.Md.</h4>
                                <p class="text-[11px] text-gray-400 font-medium">Staf Administrasi Sirkulasi</p>
                                <span class="inline-block px-2 py-0.5 bg-libLight text-libDark text-[10px] font-semibold rounded mt-1">Shift Siang (12:00 - 16:00)</span>
                            </div>
                        </div>
                        <span class="text-[10px] bg-blue-50 font-bold text-libPrimary px-2.5 py-1 rounded-md shrink-0">Berikutnya</span>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <section class="bg-libLight/40 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            
            <div class="text-center max-w-xl mx-auto">
                <h2 class="text-2xl font-bold text-libDark tracking-tight">Monitoring Dashboard Perpustakaan</h2>
                <p class="text-sm text-gray-400 mt-1">Data kunjungan analitik, log transaksi sirkulasi, dan aktivitas baca publik terbarui seketika.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs text-gray-400 font-medium block">Anggota Baru (Bulan Ini)</span>
                        <span class="text-2xl font-extrabold text-libDark block mt-1">1,248</span>
                        <span class="text-[10px] text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded mt-2 inline-block"><i class="fa-solid fa-trend-up"></i> +12% vs bulan lalu</span>
                    </div>
                    <div class="w-12 h-12 bg-libPrimary/10 text-libPrimary rounded-xl flex items-center justify-center text-xl"><i class="fa-solid fa-users-line"></i></div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs text-gray-400 font-medium block">Total Buku Dipinjam</span>
                        <span class="text-2xl font-extrabold text-libDark block mt-1">4,812</span>
                        <span class="text-[10px] text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded mt-2 inline-block"><i class="fa-solid fa-trend-up"></i> +5.4%</span>
                    </div>
                    <div class="w-12 h-12 bg-libGold/10 text-libGold rounded-xl flex items-center justify-center text-xl"><i class="fa-solid fa-book-bookmark"></i></div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs text-gray-400 font-medium block">Kunjungan Mingguan</span>
                        <span class="text-2xl font-extrabold text-libDark block mt-1">840</span>
                        <span class="text-[10px] text-red-500 font-bold bg-red-50 px-2 py-0.5 rounded mt-2 inline-block"><i class="fa-solid fa-trend-down"></i> -2% Tren Libur</span>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center text-xl"><i class="fa-solid fa-street-view"></i></div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-8 bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xs font-bold text-libDark uppercase tracking-wider">Grafik Jumlah Pengunjung Harian (Minggu Ini)</h3>
                        <span class="text-[10px] bg-libLight px-3 py-1 rounded text-gray-500 font-medium">Live Server Update</span>
                    </div>
                    <div class="h-64">
                        <canvas id="visitorWeeklyChart"></canvas>
                    </div>
                </div>

                <div class="lg:col-span-4 bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-libDark uppercase tracking-wider mb-4">Metrik Kategori Terpopuler</h3>
                        <div class="h-44 relative flex items-center justify-center">
                            <canvas id="categoryPieChart"></canvas>
                        </div>
                    </div>
                    <div class="border-t border-gray-100 pt-3 mt-4 text-center">
                        <p class="text-[11px] text-gray-400">Kategori <strong class="text-libPrimary">Sains & Teknologi</strong> mendominasi minat baca 56% di Kabupaten Sumbawa.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-libDark tracking-tight">Apa Kata Pengunjung Kami?</h2>
            <p class="text-sm text-gray-400 mt-1">Ulasan tulus dari para akademisi, peneliti, dan masyarakat umum di Sumbawa.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between space-y-4">
                <p class="text-xs text-gray-500 leading-relaxed italic">"Aplikasi pencarian katalog bukunya sangat cepat dan responsif. Memudahkan saya mencari referensi jurnal untuk tugas akhir semester di kampus Informatika UTS tanpa harus membongkar rak manual."</p>
                <div class="flex items-center gap-3 pt-2 border-t border-gray-50">
                    <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=80&q=80" class="w-9 h-9 rounded-xl object-cover" alt="User">
                    <div>
                        <h4 class="text-xs font-bold text-libDark">Saputra B.</h4>
                        <p class="text-[10px] text-gray-400 font-medium">Mahasiswa UTS</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between space-y-4">
                <p class="text-xs text-gray-500 leading-relaxed italic">"Sangat ramah pengguna untuk kami yang sudah berkeluarga. Proses registrasi anak-anak menjadi anggota perpustakaan daerah kini jauh lebih singkat berkat digitalisasi sistem ini."</p>
                <div class="flex items-center gap-3 pt-2 border-t border-gray-50">
                    <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=80&q=80" class="w-9 h-9 rounded-xl object-cover" alt="User">
                    <div>
                        <h4 class="text-xs font-bold text-libDark">Lestari Handayani</h4>
                        <p class="text-[10px] text-gray-400 font-medium">Wirausaha / Ibu Rumah Tangga</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between space-y-4">
                <p class="text-xs text-gray-500 leading-relaxed italic">"Sistem monitoring grafiknya luar biasa transparan. Membantu dinas terkait melihat indeks minat baca harian masyarakat secara akurat guna menyusun laporan bulanan."</p>
                <div class="flex items-center gap-3 pt-2 border-t border-gray-50">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=80&q=80" class="w-9 h-9 rounded-xl object-cover" alt="User">
                    <div>
                        <h4 class="text-xs font-bold text-libDark">Hendra Wijaya</h4>
                        <p class="text-[10px] text-gray-400 font-medium">Peneliti Ekonomi Publik</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-libDark text-gray-300 pt-16 pb-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-10 pb-12 border-b border-slate-800">
            
            <div class="lg:col-span-4 space-y-4">
                <div class="flex items-center gap-2 text-white">
                    <div class="w-8 h-8 bg-libPrimary rounded-lg flex items-center justify-center text-white"><i class="fa-solid fa-book-open text-sm"></i></div>
                    <span class="text-sm font-bold tracking-tight">PERPUSTAKAAN DIGITAL SUMBAWA</span>
                </div>
                <p class="text-xs text-gray-400 leading-relaxed">Pusat integrasi data literasi modern Kabupaten Sumbawa guna mewujudkan kemudahan akses ilmu pengetahuan terpadu untuk semua.</p>
                <div class="flex items-center gap-3 pt-2">
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-libPrimary hover:text-white flex items-center justify-center transition-colors text-xs text-gray-400"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-libPrimary hover:text-white flex items-center justify-center transition-colors text-xs text-gray-400"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-4">
                <h4 class="text-white text-xs font-bold uppercase tracking-wider">Tautan Utama</h4>
                <ul class="space-y-2 text-xs text-gray-400">
                    <li><a href="#" class="hover:text-libPrimary transition-colors">Home</a></li>
                    <li><a href="#" class="hover:text-libPrimary transition-colors">About Us</a></li>
                    <li><a href="#" class="hover:text-libPrimary transition-colors">Rak Buku Digital</a></li>
                    <li><a href="#" class="hover:text-libPrimary transition-colors">FAQ</a></li>
                </ul>
            </div>

            <div class="lg:col-span-3 space-y-4">
                <h4 class="text-white text-xs font-bold uppercase tracking-wider">Layanan Informasi</h4>
                <ul class="space-y-2.5 text-xs text-gray-400">
                    <li class="flex items-start gap-2.5"><i class="fa-solid fa-phone text-libPrimary mt-0.5"></i> <span>+62 (371) 21234</span></li>
                    <li class="flex items-start gap-2.5"><i class="fa-solid fa-envelope text-libPrimary mt-0.5"></i> <span>disperpustakaan@sumbawakab.go.id</span></li>
                    <li class="flex items-start gap-2.5"><i class="fa-solid fa-location-dot text-libPrimary mt-0.5"></i> <span class="leading-relaxed">Jl. Lintasan Utama Samping Kantor Bupati, Seketeng, Sumbawa, NTB.</span></li>
                </ul>
            </div>

            <div class="lg:col-span-3 space-y-4">
                <h4 class="text-white text-xs font-bold uppercase tracking-wider">Kebijakan Sistem</h4>
                <ul class="space-y-2 text-xs text-gray-400">
                    <li><a href="#" class="hover:text-libPrimary transition-colors">Hubungi Kami (Helpdesk)</a></li>
                    <li><a href="#" class="hover:text-libPrimary transition-colors">Kebijakan Privasi Anggota</a></li>
                    <li><a href="#" class="hover:text-libPrimary transition-colors">Syarat & Ketentuan Penggunaan</a></li>
                </ul>
            </div>

        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500">
            <p>&copy; 2026 Perpustakaan Digital Kabupaten Sumbawa. Hak Cipta Dilindungi.</p>
            <p class="font-medium">Dikembangkan Berbasis Laravel Framework</p>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // 1. Weekly Visitor Bar Chart
            const ctxWeekly = document.getElementById('visitorWeeklyChart').getContext('2d');
            new Chart(ctxWeekly, {
                type: 'bar',
                data: {
                    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                    datasets: [{
                        label: 'Jumlah Pengunjung',
                        data: [120, 150, 180, 145, 95, 110, 40],
                        backgroundColor: '#3A7BFF',
                        borderRadius: 6,
                        borderSkipped: false,
                        hoverBackgroundColor: '#0F2D52'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { grid: { color: '#F3F4F6' }, ticks: { font: { family: 'Poppins', size: 10 } } },
                        x: { grid: { display: false }, ticks: { font: { family: 'Poppins', size: 10 } } }
                    }
                }
            });

            // 2. Metrik Kategori Pie Chart (Donut Modern)
            const ctxCategory = document.getElementById('categoryPieChart').getContext('2d');
            new Chart(ctxCategory, {
                type: 'doughnut',
                data: {
                    labels: ['Teknologi', 'Sastra', 'Ekonomi', 'Umum'],
                    datasets: [{
                        data: [56, 20, 14, 10],
                        backgroundColor: ['#3A7BFF', '#D4A017', '#0F2D52', '#E5E7EB'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right', labels: { font: { family: 'Poppins', size: 9 } } },
                    },
                    cutout: '75%'
                }
            });
        });
    </script>
</body>
</html>