@extends('layouts.app')

@section('content')
@section('content')
<div class="home-content" style="margin-top: -4.5rem;">
{{-- ========================= --}}
{{-- HERO SLIDER FULL PAGE --}}
{{-- ========================= --}}
{{-- HERO SLIDER FULL PAGE --}}
<section class="hero-slider swiper">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <img src="https://picsum.photos/1920/1080?random=1" alt="Slide 1">
        </div>
        <div class="swiper-slide">
            <img src="https://picsum.photos/1920/1080?random=2" alt="Slide 2">
        </div>
        <div class="swiper-slide">
            <img src="https://picsum.photos/1920/1080?random=3" alt="Slide 3">
        </div>
    </div>
    
    <div class="hero-overlay">
        <div class="hero-text text-center text-white px-4">
            <h1 class="text-5xl md:text-7xl font-bold mb-4 drop-shadow-lg">
                Selamat Datang
            </h1>
            <p class="text-xl md:text-3xl mb-8 drop-shadow-md">
                di Savansa Library SMP Negeri 181 Jakarta
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#books" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition transform hover:scale-105 shadow-lg">
                    Jelajahi Buku
                </a>
                <a href="#events" class="bg-white hover:bg-gray-100 text-blue-700 px-8 py-3 rounded-lg font-semibold text-lg transition transform hover:scale-105 shadow-lg">
                    Lihat Event
                </a>
            </div>
        </div>
    </div>
    
    <div class="swiper-pagination"></div>
    
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 z-20 animate-bounce">
        <a href="#statistics" class="text-white">
            <i class="fas fa-chevron-down text-3xl"></i>
        </a>
    </div>
</section>
    
    {{-- ============================= --}}
    {{-- DASHBOARD STATISTICS --}}
    {{-- ============================= --}}
    <section id="statistics" class="py-12 bg-white">
        <div class="container mx-auto px-4">
            
            {{-- STATISTIC CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                
                {{-- Total Buku --}}
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total Buku</p>
                            <h3 class="text-3xl font-bold">{{ number_format($totalBooks ?? 0) }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4">
                            <i class="fas fa-book text-3xl"></i>
                        </div>
                    </div>
                    <p class="text-blue-100 text-xs">Koleksi perpustakaan</p>
                </div>

                {{-- Total Anggota --}}
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Total Anggota</p>
                            <h3 class="text-3xl font-bold">{{ number_format($totalMembers ?? 0) }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4">
                            <i class="fas fa-users text-3xl"></i>
                        </div>
                    </div>
                    <p class="text-green-100 text-xs">Anggota aktif</p>
                </div>

                {{-- Peminjaman Aktif --}}
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-orange-100 text-sm font-medium">Peminjaman Aktif</p>
                            <h3 class="text-3xl font-bold">{{ number_format($activeBorrowings ?? 0) }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4">
                            <i class="fas fa-book-reader text-3xl"></i>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-orange-100 text-xs">Sedang dipinjam</p>
                        @if(($lateBorrowings ?? 0) > 0)
                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-semibold">
                                {{ $lateBorrowings }} Terlambat
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Absensi Hari Ini --}}
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Absensi Hari Ini</p>
                            <h3 class="text-3xl font-bold">{{ number_format($todayAbsences ?? 0) }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4">
                            <i class="fas fa-user-check text-3xl"></i>
                        </div>
                    </div>
                    <p class="text-purple-100 text-xs">Kunjungan hari ini</p>
                </div>

            </div>

            {{-- FILTER BUTTONS --}}
            <div class="flex justify-center gap-4 mb-8">
                <a href="{{ route('home', ['chart_filter' => '7days']) }}" 
                   class="px-6 py-2 rounded-lg font-semibold transition {{ ($chartFilter ?? '7days') === '7days' ? 'bg-blue-600 text-white shadow-lg' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    <i class="fas fa-calendar-week mr-2"></i>7 Hari Terakhir
                </a>
                <a href="{{ route('home', ['chart_filter' => 'month']) }}" 
                   class="px-6 py-2 rounded-lg font-semibold transition {{ ($chartFilter ?? '7days') === 'month' ? 'bg-blue-600 text-white shadow-lg' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    <i class="fas fa-calendar-alt mr-2"></i>30 Hari Terakhir
                </a>
            </div>

            {{-- CHARTS --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                {{-- Chart Absensi --}}
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-800">Grafik Absensi</h3>
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            {{ ($chartFilter ?? '7days') === 'month' ? '30 Hari Terakhir' : '7 Hari Terakhir' }}
                        </span>
                    </div>
                    <div style="position: relative; height: 300px;">
                        <canvas id="absensiChart"></canvas>
                    </div>
                </div>

                {{-- Chart Pengembalian --}}
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-800">Grafik Pengembalian</h3>
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            {{ ($chartFilter ?? '7days') === 'month' ? '30 Hari Terakhir' : '7 Hari Terakhir' }}
                        </span>
                    </div>
                    <div style="position: relative; height: 300px;">
                        <canvas id="pengembalianChart"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </section>
    
    {{-- ============================= --}}
    {{-- SAMBUTAN KEPALA SEKOLAH --}}
    {{-- ============================= --}}
    @if(isset($principal) && $principal)
    <section id="principal" class="py-16 bg-gradient-to-br from-blue-50 to-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-2 text-gray-800">Sambutan Kepala Sekolah</h2>
            <p class="text-center text-gray-600 mb-12">Selamat datang di Savansa Library</p>
            
            <div class="bg-white rounded-xl shadow-xl overflow-hidden max-w-5xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-0">
                    
                    {{-- FOTO KEPALA SEKOLAH --}}
                    <div class="md:col-span-1 bg-gradient-to-br from-blue-500 to-blue-700 p-8 flex items-center justify-center">
                        @if($principal->photo)
                            <img src="{{ $principal->photo_url }}" alt="{{ $principal->name }}" 
                                 class="w-48 h-48 rounded-full object-cover border-4 border-white shadow-lg">
                        @else
                            <div class="w-48 h-48 rounded-full bg-white flex items-center justify-center">
                                <i class="fas fa-user text-blue-700 text-7xl"></i>
                            </div>
                        @endif
                    </div>

                    {{-- SAMBUTAN TEXT --}}
                    <div class="md:col-span-2 p-8 md:p-10">
                        <div class="mb-4">
                            <h3 class="text-2xl font-bold text-gray-800">{{ $principal->name }}</h3>
                            <p class="text-blue-600 font-semibold">Kepala Sekolah</p>
                        </div>

                        <div class="text-gray-700 leading-relaxed space-y-4">
                            <div class="text-6xl text-blue-200 leading-none">"</div>
                            <p class="text-base md:text-lg -mt-8 pl-8">
                                {!! nl2br(e($principal->message)) !!}
                            </p>
                            <div class="text-6xl text-blue-200 leading-none text-right">"</div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ============================= --}}
    {{-- EVENT & BERITA (Blog-Style) --}}
    {{-- ============================= --}}
    @if($events->count() > 0)
    <section id="events" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-2 text-gray-800">Event & Berita Terbaru</h2>
            <p class="text-center text-gray-600 mb-12">Kegiatan dan informasi terbaru dari perpustakaan</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($events as $event)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                    
                    {{-- THUMBNAIL --}}
                    <div class="relative overflow-hidden h-48">
                        @if($event->image)
                            <img src="{{ $event->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-r from-blue-500 to-blue-700 flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-white text-5xl"></i>
                            </div>
                        @endif
                        
                        {{-- BADGE KATEGORI --}}
                        <div class="absolute top-4 left-4">
                            <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
                                Event
                            </span>
                        </div>
                    </div>

                    {{-- CONTENT --}}
                    <div class="p-6">
                        {{-- DATE --}}
                        <div class="flex items-center text-gray-500 text-sm mb-3">
                            <i class="far fa-calendar mr-2"></i>
                            {{ $event->event_date->format('d F Y') }}
                            <span class="mx-2">•</span>
                            <i class="far fa-clock mr-2"></i>
                            {{ $event->event_date->diffForHumans() }}
                        </div>

                        {{-- TITLE --}}
                        <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-blue-600 transition">
                            {{ $event->title }}
                        </h3>
                        
                        {{-- EXCERPT --}}
                        <p class="text-gray-600 text-sm line-clamp-3 mb-4">{{ $event->description }}</p>
                        
                        {{-- READ MORE BUTTON --}}
                        <a href="{{ route('blog.show', $event->slug) }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold text-sm transition-all">
                            Baca Selengkapnya 
                            <i class="fas fa-arrow-right ml-2 group-hover:ml-3 transition-all"></i>
                        </a>
                    </div>

                </div>
                @endforeach
            </div>
            
            {{-- LIHAT SEMUA BUTTON --}}
            <div class="text-center mt-12">
                <a href="{{ route('blog.index') }}" class="inline-block bg-white border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white px-8 py-3 rounded-lg font-semibold transition transform hover:scale-105 shadow-lg">
                    <i class="fas fa-newspaper mr-2"></i>Lihat Semua Event & Berita
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- ============================= --}}
    {{-- REKOMENDASI BUKU (9:16 Ratio) --}}
    {{-- ============================= --}}
    @if($bookRecommendations->count() > 0)
    <section id="books" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-2 text-gray-800">Rekomendasi Bacaan</h2>
            <p class="text-center text-gray-600 mb-12">Rekomendasi buku pilihan</p>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach($bookRecommendations as $book)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1 group">

                    {{-- COVER BUKU (9:16 RATIO) --}}
                    <div class="book-cover-9-16">
                        @if($book->cover)
                            <img src="{{ asset('storage/' . $book->cover) }}" 
                                 alt="{{ $book->title }}" 
                                 class="group-hover:scale-105 transition duration-300">
                        @else
                            <div class="bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                                <i class="fas fa-book text-white text-6xl"></i>
                            </div>
                        @endif
                        
                        {{-- OVERLAY BUTTON --}}
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <a href="{{ route('book.show', $book->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold text-sm transition transform scale-90 group-hover:scale-100">
                                <i class="fas fa-eye mr-2"></i>Lihat Detail
                            </a>
                        </div>
                    </div>

                    {{-- INFO BUKU --}}
                    <div class="p-4">
                        <h3 class="text-sm font-bold text-gray-800 line-clamp-2 mb-1">{{ $book->title }}</h3>
                        <p class="text-xs text-gray-500 mb-2">{{ $book->author }}</p>
                        @if($book->category)
                            <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">
                                {{ $book->category }}
                            </span>
                        @endif
                    </div>

                </div>
                @endforeach
            </div>
            
            {{-- LIHAT SEMUA BUTTON --}}
            <div class="text-center mt-8">
                <a href="{{ route('buku.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition transform hover:scale-105 shadow-lg">
                    <i class="fas fa-book-open mr-2"></i>Lihat Semua Buku
                </a>
            </div>
        </div>
    </section>
    @endif
</div>
@endsection