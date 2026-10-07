@extends('layouts.app')

@section('title', $buku->judul)

@section('content')
<section class="py-12 lg:py-16">
    <div class="container mx-auto px-4">

        {{-- BREADCRUMB --}}
        <nav class="reveal mb-8">
            <ol class="flex items-center space-x-2 text-sm text-navy-600/60">
                <li><a href="{{ route('home') }}" class="hover:text-sky2-600 transition">Beranda</a></li>
                <li><i class="ph ph-caret-right text-[10px]"></i></li>
                <li><a href="{{ route('buku.index') }}" class="hover:text-sky2-600 transition">Katalog Buku</a></li>
                <li><i class="ph ph-caret-right text-[10px]"></i></li>
                <li class="text-navy-900 font-semibold truncate max-w-[200px] md:max-w-md">{{ $buku->judul }}</li>
            </ol>
        </nav>

        <div class="max-w-6xl mx-auto">

            {{-- MAIN CARD --}}
            <div class="reveal bg-white rounded-2xl border border-cream-200 shadow-xl shadow-navy-900/5 overflow-hidden mb-12">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-0">

                    {{-- COVER --}}
                    <div class="md:col-span-2 bg-navy-900 p-8 lg:p-10 flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 opacity-[0.07]" aria-hidden="true"></div>
                        <div class="w-full max-w-xs relative">

                            @if($buku->cover)
                                <img src="{{ asset('storage/' . $buku->cover) }}"
                                     alt="{{ $buku->judul }}"
                                     class="w-full h-auto rounded-xl shadow-2xl ring-1 ring-white/10">
                            @else
                                <div class="bg-gradient-to-br from-navy-700 to-navy-950 rounded-xl shadow-2xl ring-1 ring-white/10 flex items-center justify-center"
                                     style="aspect-ratio: 2/3;">
                                    <i class="ph ph-book text-sky2-400/60 text-7xl"></i>
                                </div>
                            @endif

                        </div>
                    </div>

                    {{-- DETAIL BUKU --}}
                    <div class="md:col-span-3 p-8 md:p-10">

                        <div class="mb-4">
                            <span class="bg-sky2-50 border border-sky2-100 text-sky2-700 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $buku->kategori }}
                            </span>
                        </div>

                        <h1 class="font-display text-3xl md:text-4xl font-semibold text-navy-900 mb-3 leading-tight">
                            {{ $buku->judul }}
                        </h1>

                        <p class="text-lg text-navy-600/70 mb-6">
                            <i class="ph ph-pen text-sky2-600 mr-2"></i>{{ $buku->penulis }}
                        </p>

                        {{-- DETAIL INFO --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 mb-8">

                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-sky2-50 text-sky2-600 flex items-center justify-center text-sm flex-shrink-0"><i class="ph ph-tag"></i></div>
                                <div>
                                    <p class="text-[11px] uppercase tracking-wider text-navy-600/50 font-semibold">Kategori</p>
                                    <p class="text-sm font-semibold text-navy-900">{{ $buku->kategori }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-sky2-50 text-sky2-600 flex items-center justify-center text-sm flex-shrink-0"><i class="ph ph-buildings"></i></div>
                                <div>
                                    <p class="text-[11px] uppercase tracking-wider text-navy-600/50 font-semibold">Penerbit</p>
                                    <p class="text-sm font-semibold text-navy-900">{{ $buku->penerbit }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-sky2-50 text-sky2-600 flex items-center justify-center text-sm flex-shrink-0"><i class="ph ph-map-pin"></i></div>
                                <div>
                                    <p class="text-[11px] uppercase tracking-wider text-navy-600/50 font-semibold">Nomor Rak</p>
                                    <p class="text-sm font-semibold text-navy-900">{{ $buku->nomorrak }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-sky2-50 text-sky2-600 flex items-center justify-center text-sm flex-shrink-0"><i class="ph ph-calendar-blank"></i></div>
                                <div>
                                    <p class="text-[11px] uppercase tracking-wider text-navy-600/50 font-semibold">Tahun Pembelian</p>
                                    <p class="text-sm font-semibold text-navy-900">{{ $buku->tahunpembelian }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 sm:col-span-2">
                                <div class="w-9 h-9 rounded-lg bg-sky2-50 text-sky2-600 flex items-center justify-center text-sm flex-shrink-0"><i class="ph ph-stack"></i></div>
                                <div>
                                    <p class="text-[11px] uppercase tracking-wider text-navy-600/50 font-semibold">Stok Tersedia</p>
                                    <p class="text-sm font-semibold text-navy-900">{{ $buku->stokbuku }} eksemplar</p>
                                </div>
                            </div>

                        </div>

                        {{-- ACTION BUTTONS --}}
                        <div class="flex flex-wrap gap-3 pt-6 border-t border-cream-200">
                            <button class="bg-navy-900 text-white px-6 py-3 rounded-xl font-semibold hover:bg-navy-700 transition flex items-center">
                                <i class="ph ph-heart mr-2 text-sky2-400"></i>Tambah ke Favorit
                            </button>

                            <button onclick="navigator.share ? navigator.share({title: '{{ $buku->judul }}'}) : navigator.clipboard.writeText(window.location.href).then(() => alert('Link berhasil disalin!'))"
                                    class="bg-white border-2 border-cream-200 text-navy-900 hover:border-sky2-400 px-6 py-3 rounded-xl font-semibold transition flex items-center">
                                <i class="ph ph-share-network mr-2 text-sky2-600"></i>Bagikan
                            </button>
                        </div>

                    </div>

                </div>
            </div>

            {{-- DESKRIPSI --}}
            @if($buku->deskripsi)
                <div class="reveal bg-white rounded-2xl border border-cream-200 shadow-lg shadow-navy-900/5 p-8 lg:p-10 mb-12">
                    <h2 class="font-display text-2xl font-semibold text-navy-900 mb-4">
                        <i class="ph ph-book-open text-sky2-600 mr-2"></i>Deskripsi
                    </h2>
                    <div class="text-navy-900/80 leading-relaxed">
                        {!! nl2br(e($buku->deskripsi)) !!}
                    </div>
                </div>
            @endif

            {{-- BACK BUTTON --}}
            <div class="text-center">
                <a href="{{ route('buku.index') }}"
                   class="inline-flex items-center gap-2 bg-white border-2 border-cream-200 hover:border-sky2-400 text-navy-900 px-8 py-3 rounded-xl font-semibold transition">
                    <i class="ph ph-arrow-left"></i>Kembali ke Katalog
                </a>
            </div>

        </div>
    </div>
</section>
@endsection
