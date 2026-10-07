@extends('layouts.app')

@section('title', 'Struktur Pengelola')

@section('content')
<section class="py-12 lg:py-16">
    <div class="container mx-auto px-4">

        {{-- HEADER --}}
        <div class="reveal max-w-2xl mx-auto text-center mb-12">
            <p class="text-sky2-600 font-semibold tracking-[0.25em] uppercase text-xs mb-3">Tentang Kami</p>
            <h1 class="font-display text-3xl md:text-4xl font-semibold text-navy-900 mb-4">Struktur Pengelola</h1>
            <p class="text-navy-600/70 leading-relaxed">Tim yang mengelola Savansa Library setiap hari.</p>
        </div>

        @if($pengelolas->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                @foreach($pengelolas as $pengelola)
                <div class="reveal group bg-white rounded-2xl border border-cream-200 overflow-hidden hover:border-sky2-400/60 hover:shadow-xl hover:shadow-navy-900/10 hover:-translate-y-1 transition duration-300">

                    {{-- FOTO --}}
                    <div class="bg-navy-900 py-10 flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 opacity-[0.07]" aria-hidden="true"></div>
                        @if($pengelola->photo)
                            <img src="{{ $pengelola->photo_url }}"
                                 alt="{{ $pengelola->name }}" loading="lazy"
                                 class="w-36 h-36 rounded-full object-cover ring-4 ring-sky2-400/70 shadow-2xl relative">
                        @else
                            <div class="w-36 h-36 rounded-full bg-navy-700 ring-4 ring-sky2-400/70 flex items-center justify-center relative">
                                <i class="ph ph-user text-sky2-400/70 text-5xl"></i>
                            </div>
                        @endif
                    </div>

                    {{-- INFO --}}
                    <div class="p-6 text-center">
                        <h3 class="font-display text-xl font-semibold text-navy-900 mb-1.5">{{ $pengelola->name }}</h3>
                        <p class="text-sky2-700 font-semibold text-sm mb-4">{{ $pengelola->position }}</p>

                        @if($pengelola->description)
                            <p class="text-navy-600/70 text-sm leading-relaxed">{{ $pengelola->description }}</p>
                        @endif
                    </div>

                </div>
                @endforeach
            </div>
        @else
            {{-- NO DATA --}}
            <div class="reveal max-w-md mx-auto text-center bg-white border border-cream-200 rounded-2xl p-12">
                <div class="w-16 h-16 rounded-2xl bg-sky2-50 text-sky2-600 flex items-center justify-center text-2xl mx-auto mb-5">
                    <i class="ph ph-users"></i>
                </div>
                <h3 class="font-display text-xl font-semibold text-navy-900 mb-2">Belum Ada Data</h3>
                <p class="text-navy-600/60 text-sm">Data struktur pengelola belum tersedia.</p>
            </div>
        @endif
    </div>
</section>
@endsection
