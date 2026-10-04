@extends('layouts.app')

@section('content')
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        
        {{-- BREADCRUMB --}}
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="#books" class="hover:text-blue-600">Buku</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-gray-800 font-semibold truncate">{{ $buku->judul }}</li>
            </ol>
        </nav>

        <div class="max-w-6xl mx-auto">
            
            {{-- MAIN CARD --}}
            <div class="bg-white rounded-xl shadow-xl overflow-hidden mb-12">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-0">
                    
                    {{-- COVER --}}
                    <div class="md:col-span-2 bg-gradient-to-br from-gray-100 to-gray-200 p-8 flex items-center justify-center">
                        <div class="w-full max-w-sm">

                            @if($buku->cover)
                                <img src="{{ asset('storage/' . $buku->cover) }}"
                                     alt="{{ $buku->judul }}"
                                     class="w-full h-auto rounded-lg shadow-2xl">
                            @else
                                <div class="bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg shadow-2xl flex items-center justify-center"
                                     style="aspect-ratio: 9/16;">
                                    <i class="fas fa-book text-white text-8xl"></i>
                                </div>
                            @endif

                        </div>
                    </div>

                    {{-- DETAIL BUKU --}}
                    <div class="md:col-span-3 p-8 md:p-10">
                        
                        {{-- BADGE KATEGORI --}}
                        <div class="mb-4">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $buku->kategori }}
                            </span>
                        </div>

                        {{-- JUDUL --}}
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">
                            {{ $buku->judul }}
                        </h1>

                        {{-- PENULIS --}}
                        <p class="text-xl text-gray-600 mb-4">
                            <i class="fas fa-user-edit mr-2"></i>{{ $buku->penulis }}
                        </p>

                        <hr class="my-6">

                        {{-- DETAIL INFO --}}
                        <div class="space-y-3 text-gray-700">

                            <div class="flex">
                                <span class="w-40 font-semibold">Kategori:</span>
                                <span>{{ $buku->kategori }}</span>
                            </div>

                            <div class="flex">
                                <span class="w-40 font-semibold">Penerbit:</span>
                                <span>{{ $buku->penerbit }}</span>
                            </div>

                            <div class="flex">
                                <span class="w-40 font-semibold">Nomor Rak:</span>
                                <span>{{ $buku->nomorrak }}</span>
                            </div>

                            <div class="flex">
                                <span class="w-40 font-semibold">Tahun Pembelian:</span>
                                <span>{{ $buku->tahunpembelian }}</span>
                            </div>

                            <div class="flex">
                                <span class="w-40 font-semibold">Stok Buku:</span>
                                <span>{{ $buku->stokbuku }}</span>
                            </div>

                        </div>

                        <hr class="my-6">

                        {{-- ACTION BUTTONS --}}
                        <div class="flex space-x-4">
                            <button class="bg-white border-2 border-blue-600 text-blue-600 hover:bg-blue-50 px-6 py-3 rounded-lg font-semibold transition flex items-center">
                                <i class="fas fa-heart mr-2"></i>Tambah ke Favorit
                            </button>
                            
                            <button class="bg-white border-2 border-gray-300 text-gray-700 hover:bg-gray-50 px-6 py-3 rounded-lg font-semibold transition flex items-center">
                                <i class="fas fa-share-alt mr-2"></i>Bagikan
                            </button>
                        </div>

                    </div>

                </div>
            </div>

            {{-- DESKRIPSI --}}
            @if($buku->deskripsi)
                <div class="bg-white rounded-xl shadow-lg p-8 mb-12">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-book-open text-blue-600 mr-2"></i>Deskripsi
                    </h2>
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                        {!! nl2br(e($buku->deskripsi)) !!}
                    </div>
                </div>
            @endif

            {{-- BACK BUTTON --}}
            <div class="text-center mt-12">
                <a href="{{ route('home') }}#books" 
                   class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-8 py-3 rounded-lg font-semibold transition">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>
</section>
@endsection
