@extends('layouts.app')

@section('content')
<div class="home-content">

    {{-- ========================= --}}
    {{-- HERO SLIDER FULL PAGE --}}
    {{-- ========================= --}}
    <section class="hero-slider swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="{{ asset('storage/sliders/01KAK6XWD6APSGH8W2WJ7H8864.jpg') }}" alt="Suasana Savansa Library">
            </div>
            <div class="swiper-slide">
                <img src="{{ asset('storage/events/01KCR3MV2575VA3XWB3STTSRST.jpg') }}" alt="Kegiatan perpustakaan">
            </div>
            <div class="swiper-slide">
                <img src="{{ asset('storage/events/01KCR2EGC2PYH2MABHBSD6BSKW.jpg') }}" alt="Koleksi perpustakaan">
            </div>
        </div>

        <div class="hero-overlay">
            <div class="container mx-auto px-4 w-full">
                <div class="hero-text max-w-3xl">
                    <p class="text-sky2-400 font-semibold tracking-[0.25em] uppercase text-sm mb-5">
                        SMP Negeri 181 Jakarta
                    </p>
                    <h1 class="font-display text-5xl md:text-7xl font-semibold text-white mb-6 leading-tight">
                        Savansa <span class="italic text-sky2-400">Library</span>
                    </h1>
                    <p class="text-lg md:text-2xl text-cream-100/90 mb-10 leading-relaxed max-w-xl">
                        Jendela ilmu dan ruang baca bagi generasi muda — jelajahi koleksi, ikuti kegiatan, dan tumbuhkan budaya literasi bersama.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#books" class="inline-flex items-center justify-center gap-2 bg-sky2-500 hover:bg-sky2-400 text-navy-900 px-8 py-3.5 rounded-xl font-bold text-base transition transform hover:scale-105 shadow-xl shadow-sky2-500/25">
                            <i class="fas fa-book-open"></i> Jelajahi Koleksi
                        </a>
                        <a href="#events" class="inline-flex items-center justify-center gap-2 border-2 border-white/60 hover:border-sky2-400 hover:text-sky2-400 text-white px-8 py-3.5 rounded-xl font-bold text-base transition transform hover:scale-105">
                            <i class="fas fa-calendar"></i> Event &amp; Berita
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="swiper-pagination !bottom-8"></div>

        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20 animate-bounce lg:hidden">
            <a href="#statistics" class="text-white/80 hover:text-sky2-400">
                <i class="fas fa-chevron-down text-2xl"></i>
            </a>
        </div>
    </section>

    {{-- ========================= --}}
    {{-- STATISTIK STRIP --}}
    {{-- ========================= --}}
    <section id="statistics" class="relative z-20 -mt-16 pb-4">
        <div class="container mx-auto px-4">
            <div class="reveal bg-white rounded-2xl shadow-2xl shadow-navy-900/10 border border-cream-200 grid grid-cols-2 lg:grid-cols-4 divide-x divide-y lg:divide-y-0 divide-cream-200 overflow-hidden">

                <div class="p-6 lg:p-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-sky2-50 text-sky2-600 flex items-center justify-center text-xl flex-shrink-0">
                            <i class="fas fa-book"></i>
                        </div>
                        <div>
                            <p class="text-3xl lg:text-4xl font-display font-semibold text-navy-900">{{ number_format($totalBooks ?? 0) }}</p>
                            <p class="text-xs lg:text-sm text-navy-600/60 font-medium">Koleksi Buku</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 lg:p-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-sky2-50 text-sky2-600 flex items-center justify-center text-xl flex-shrink-0">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <p class="text-3xl lg:text-4xl font-display font-semibold text-navy-900">{{ number_format($totalMembers ?? 0) }}</p>
                            <p class="text-xs lg:text-sm text-navy-600/60 font-medium">Anggota Aktif</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 lg:p-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-sky2-50 text-sky2-600 flex items-center justify-center text-xl flex-shrink-0">
                            <i class="fas fa-book-reader"></i>
                        </div>
                        <div>
                            <p class="text-3xl lg:text-4xl font-display font-semibold text-navy-900">{{ number_format($activeBorrowings ?? 0) }}</p>
                            <p class="text-xs lg:text-sm text-navy-600/60 font-medium">Sedang Dipinjam</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 lg:p-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-sky2-50 text-sky2-600 flex items-center justify-center text-xl flex-shrink-0">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div>
                            <p class="text-3xl lg:text-4xl font-display font-semibold text-navy-900">{{ number_format($todayAbsences ?? 0) }}</p>
                            <p class="text-xs lg:text-sm text-navy-600/60 font-medium">Kunjungan Hari Ini</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ============================= --}}
    {{-- MENGAPA SAVANSA LIBRARY --}}
    {{-- ============================= --}}
    <section class="py-20 lg:py-24">
        <div class="container mx-auto px-4">
            <div class="reveal max-w-2xl mx-auto text-center mb-14">
                <p class="text-sky2-600 font-semibold tracking-[0.25em] uppercase text-xs mb-3">Layanan Kami</p>
                <h2 class="font-display text-3xl md:text-4xl font-semibold text-navy-900 mb-4">Mengapa Savansa Library?</h2>
                <p class="text-navy-600/70 leading-relaxed">Empat alasan mengapa perpustakaan kami menjadi rumah bagi para pembaca muda.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="reveal group relative bg-white rounded-2xl border border-cream-200 p-8 hover:border-sky2-400/60 hover:shadow-xl hover:shadow-navy-900/5 transition">
                    <span class="absolute top-6 right-7 font-display text-4xl font-semibold text-cream-200 group-hover:text-sky2-100 transition-colors">01</span>
                    <div class="w-14 h-14 rounded-xl bg-navy-900 text-sky2-400 flex items-center justify-center text-2xl mb-6">
                        <i class="fas fa-book-bookmark"></i>
                    </div>
                    <h3 class="font-display text-xl font-semibold text-navy-900 mb-3">Koleksi Lengkap</h3>
                    <p class="text-sm text-navy-600/70 leading-relaxed">Ratusan judul buku pelajaran, fiksi, dan referensi yang terus bertambah setiap tahun ajaran.</p>
                </div>

                <div class="reveal group relative bg-white rounded-2xl border border-cream-200 p-8 hover:border-sky2-400/60 hover:shadow-xl hover:shadow-navy-900/5 transition">
                    <span class="absolute top-6 right-7 font-display text-4xl font-semibold text-cream-200 group-hover:text-sky2-100 transition-colors">02</span>
                    <div class="w-14 h-14 rounded-xl bg-navy-900 text-sky2-400 flex items-center justify-center text-2xl mb-6">
                        <i class="fas fa-hand-holding"></i>
                    </div>
                    <h3 class="font-display text-xl font-semibold text-navy-900 mb-3">Peminjaman Mudah</h3>
                    <p class="text-sm text-navy-600/70 leading-relaxed">Proses pinjam dan kembalikan cepat dengan pencatatan digital — tinggal bawa kartu pelajar.</p>
                </div>

                <div class="reveal group relative bg-white rounded-2xl border border-cream-200 p-8 hover:border-sky2-400/60 hover:shadow-xl hover:shadow-navy-900/5 transition">
                    <span class="absolute top-6 right-7 font-display text-4xl font-semibold text-cream-200 group-hover:text-sky2-100 transition-colors">03</span>
                    <div class="w-14 h-14 rounded-xl bg-navy-900 text-sky2-400 flex items-center justify-center text-2xl mb-6">
                        <i class="fas fa-couch"></i>
                    </div>
                    <h3 class="font-display text-xl font-semibold text-navy-900 mb-3">Ruang Baca Nyaman</h3>
                    <p class="text-sm text-navy-600/70 leading-relaxed">Area baca yang tenang dan sejuk untuk menemani belajar mandiri maupun tugas kelompok.</p>
                </div>

                <div class="reveal group relative bg-white rounded-2xl border border-cream-200 p-8 hover:border-sky2-400/60 hover:shadow-xl hover:shadow-navy-900/5 transition">
                    <span class="absolute top-6 right-7 font-display text-4xl font-semibold text-cream-200 group-hover:text-sky2-100 transition-colors">04</span>
                    <div class="w-14 h-14 rounded-xl bg-navy-900 text-sky2-400 flex items-center justify-center text-2xl mb-6">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h3 class="font-display text-xl font-semibold text-navy-900 mb-3">Digital &amp; E-Book</h3>
                    <p class="text-sm text-navy-600/70 leading-relaxed">Katalog online untuk mencari koleksi kapan saja, dengan e-book yang akan segera hadir.</p>
                </div>

            </div>
        </div>
    </section>

    {{-- ============================= --}}
    {{-- SAMBUTAN KEPALA SEKOLAH --}}
    {{-- ============================= --}}
    @if(isset($principal) && $principal)
    <section id="principal" class="py-20 lg:py-24 bg-navy-900 relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.06]" aria-hidden="true"></div>
        <div class="container mx-auto px-4 relative">
            <div class="reveal max-w-5xl mx-auto">
                <p class="text-sky2-400 font-semibold tracking-[0.25em] uppercase text-xs mb-3 text-center">Sambutan</p>
                <h2 class="font-display text-3xl md:text-4xl font-semibold text-white mb-12 text-center">Kepala Sekolah</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-10 items-center">
                    {{-- FOTO --}}
                    <div class="flex md:justify-start justify-center">
                        <div class="relative">
                            @if($principal->photo)
                                <img src="{{ $principal->photo_url }}" alt="{{ $principal->name }}"
                                     class="w-44 h-44 lg:w-52 lg:h-52 rounded-full object-cover border-4 border-sky2-500/80 shadow-2xl">
                            @else
                                <div class="w-44 h-44 lg:w-52 lg:h-52 rounded-full bg-navy-700 border-4 border-sky2-500/80 flex items-center justify-center">
                                    <i class="fas fa-user text-sky2-400 text-6xl"></i>
                                </div>
                            @endif
                            <div class="absolute -bottom-2 -right-2 w-12 h-12 rounded-full bg-sky2-500 text-navy-900 flex items-center justify-center text-lg shadow-lg">
                                <i class="fas fa-quote-right"></i>
                            </div>
                        </div>
                    </div>

                    {{-- KUTIPAN --}}
                    <div class="md:col-span-2">
                        <span class="font-display text-6xl text-sky2-500/40 leading-none select-none" aria-hidden="true">&ldquo;</span>
                        <div class="font-display text-lg lg:text-2xl text-cream-100 leading-relaxed italic -mt-4">
                            {!! nl2br(e($principal->message)) !!}
                        </div>
                        <div class="mt-8 flex items-center gap-4">
                            <div class="h-px w-12 bg-sky2-500"></div>
                            <div>
                                <p class="text-white font-bold">{{ $principal->name }}</p>
                                <p class="text-sky2-400 text-sm">Kepala SMP Negeri 181 Jakarta</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ============================= --}}
    {{-- EVENT & BERITA --}}
    {{-- ============================= --}}
    @if($events->count() > 0)
    <section id="events" class="py-20 lg:py-24">
        <div class="container mx-auto px-4">
            <div class="reveal flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-12">
                <div>
                    <p class="text-sky2-600 font-semibold tracking-[0.25em] uppercase text-xs mb-3">Kegiatan</p>
                    <h2 class="font-display text-3xl md:text-4xl font-semibold text-navy-900">Event &amp; Berita Terbaru</h2>
                </div>
                <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-navy-900 font-semibold hover:text-sky2-600 transition group">
                    Lihat semua
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($events as $event)
                <article class="reveal group bg-white rounded-2xl overflow-hidden border border-cream-200 hover:border-sky2-400/60 hover:shadow-2xl hover:shadow-navy-900/10 transition duration-300">
                    <div class="relative overflow-hidden h-52">
                        @if($event->image)
                            <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full bg-navy-900 flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-sky2-500/60 text-5xl"></i>
                            </div>
                        @endif

                        {{-- BADGE TANGGAL --}}
                        <div class="absolute top-4 left-4 bg-white rounded-xl px-3.5 py-2 text-center shadow-lg">
                            <p class="font-display text-2xl font-semibold text-navy-900 leading-none">{{ $event->event_date->format('d') }}</p>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-sky2-600">{{ $event->event_date->format('M Y') }}</p>
                        </div>
                    </div>

                    <div class="p-6">
                        <p class="text-xs font-semibold text-navy-600/50 uppercase tracking-wider mb-2.5">
                            <i class="far fa-clock mr-1.5 text-sky2-600"></i>{{ $event->event_date->diffForHumans() }}
                        </p>

                        <h3 class="font-display text-xl font-semibold text-navy-900 mb-2.5 line-clamp-2 group-hover:text-sky2-700 transition">
                            {{ $event->title }}
                        </h3>

                        <p class="text-sm text-navy-600/70 line-clamp-3 mb-5 leading-relaxed">{{ $event->description }}</p>

                        <a href="{{ route('blog.show', $event->slug) }}" class="inline-flex items-center gap-2 text-sm font-bold text-navy-900 hover:text-sky2-600 transition">
                            Baca selengkapnya
                            <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============================= --}}
    {{-- RAK REKOMENDASI BUKU --}}
    {{-- ============================= --}}
    @if($bookRecommendations->count() > 0)
    <section id="books" class="py-20 lg:py-24 bg-navy-950 relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.05]" aria-hidden="true"></div>
        <div class="container mx-auto px-4 relative">
            <div class="reveal flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-12">
                <div>
                    <p class="text-sky2-400 font-semibold tracking-[0.25em] uppercase text-xs mb-3">Rak Rekomendasi</p>
                    <h2 class="font-display text-3xl md:text-4xl font-semibold text-white">Rekomendasi Bacaan</h2>
                    <p class="text-cream-100/60 mt-3">Buku pilihan pustakawan untuk menemani hari ini.</p>
                </div>
                <div class="hidden md:flex gap-3">
                    <button class="book-prev w-11 h-11 rounded-full border border-white/20 text-white hover:bg-sky2-500 hover:text-navy-900 hover:border-sky2-500 transition" aria-label="Geser kiri">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <button class="book-next w-11 h-11 rounded-full border border-white/20 text-white hover:bg-sky2-500 hover:text-navy-900 hover:border-sky2-500 transition" aria-label="Geser kanan">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <div class="reveal swiper book-shelf overflow-visible !pb-4">
                <div class="swiper-wrapper">
                    @foreach($bookRecommendations as $book)
                    <div class="swiper-slide h-auto">
                        <div class="shelf-card group bg-navy-900/60 rounded-xl overflow-hidden border border-white/10 h-full">

                            <div class="book-cover-9-16">
                                @if($book->cover)
                                    <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover {{ $book->title }}" loading="lazy">
                                @else
                                    <div class="bg-gradient-to-br from-navy-700 to-navy-900 flex items-center justify-center">
                                        <i class="fas fa-book text-sky2-500/50 text-5xl"></i>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-navy-950/0 group-hover:bg-navy-950/60 transition duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                    <a href="{{ route('book.show', $book->id) }}" class="bg-sky2-500 text-navy-900 px-4 py-2 rounded-lg font-bold text-sm">
                                        <i class="fas fa-eye mr-2"></i>Lihat Detail
                                    </a>
                                </div>
                            </div>

                            <div class="p-4">
                                <h3 class="text-sm font-bold text-white line-clamp-2 mb-1 leading-snug">{{ $book->title }}</h3>
                                <p class="text-xs text-cream-100/50 mb-3">{{ $book->author }}</p>
                                @if($book->category)
                                    <span class="inline-block px-2.5 py-1 bg-sky2-500/10 border border-sky2-500/30 text-sky2-400 text-[11px] font-semibold rounded-full">
                                        {{ $book->category }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('buku.index') }}" class="inline-flex items-center gap-2 bg-sky2-500 hover:bg-sky2-400 text-navy-900 px-8 py-3.5 rounded-xl font-bold transition transform hover:scale-105 shadow-xl shadow-sky2-500/20">
                    <i class="fas fa-book-open"></i> Lihat Semua Buku
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- ============================= --}}
    {{-- DATA KUNJUNGAN (GRAFIK) --}}
    {{-- ============================= --}}
    <section id="data" class="py-20 lg:py-24">
        <div class="container mx-auto px-4">
            <div class="reveal max-w-2xl mx-auto text-center mb-12">
                <p class="text-sky2-600 font-semibold tracking-[0.25em] uppercase text-xs mb-3">Transparansi</p>
                <h2 class="font-display text-3xl md:text-4xl font-semibold text-navy-900 mb-4">Data Kunjungan Perpustakaan</h2>
                <p class="text-navy-600/70 leading-relaxed">Aktivitas kunjungan dan pengembalian buku yang tercatat secara digital.</p>
            </div>

            {{-- FILTER PERIODE --}}
            <div class="reveal flex justify-center gap-3 mb-10">
                <a href="{{ route('home', ['chart_filter' => '7days']) }}" data-chart-filter="7days"
                   class="px-6 py-2.5 rounded-full font-semibold text-sm transition border-2 {{ ($chartFilter ?? '7days') === '7days' ? 'bg-navy-900 text-sky2-400 border-navy-900 shadow-lg' : 'bg-transparent text-navy-600 border-cream-200 hover:border-sky2-400' }}">
                    <i class="fas fa-calendar-week mr-2"></i>7 Hari Terakhir
                </a>
                <a href="{{ route('home', ['chart_filter' => 'month']) }}" data-chart-filter="month"
                   class="px-6 py-2.5 rounded-full font-semibold text-sm transition border-2 {{ ($chartFilter ?? '7days') === 'month' ? 'bg-navy-900 text-sky2-400 border-navy-900 shadow-lg' : 'bg-transparent text-navy-600 border-cream-200 hover:border-sky2-400' }}">
                    <i class="fas fa-calendar-alt mr-2"></i>30 Hari Terakhir
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- Chart Absensi --}}
                <div class="reveal bg-white rounded-2xl border border-cream-200 shadow-lg shadow-navy-900/5 p-6 lg:p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="font-display text-xl font-semibold text-navy-900">Kunjungan Harian</h3>
                            <p class="text-xs text-navy-600/50 mt-1">Absensi pengunjung perpustakaan</p>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-sky2-50 text-sky2-600 flex items-center justify-center text-lg">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                    <div style="position: relative; height: 300px;">
                        <canvas id="absensiChart"></canvas>
                    </div>
                </div>

                {{-- Chart Pengembalian --}}
                <div class="reveal bg-white rounded-2xl border border-cream-200 shadow-lg shadow-navy-900/5 p-6 lg:p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="font-display text-xl font-semibold text-navy-900">Pengembalian Buku</h3>
                            <p class="text-xs text-navy-600/50 mt-1">Buku yang dikembalikan per hari</p>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-sky2-50 text-sky2-600 flex items-center justify-center text-lg">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                    <div style="position: relative; height: 300px;">
                        <canvas id="pengembalianChart"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection
