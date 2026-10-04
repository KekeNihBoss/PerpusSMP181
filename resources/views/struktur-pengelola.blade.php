@extends('layouts.app')
@section('content')
    {{-- HERO SECTION --}}
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20 pt-24">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Struktur Pengelola</h1>
            <p class="text-xl text-green-100">Perpustakaan SMP Negeri 181 Jakarta</p>
        </div>
    </section>

    {{-- CONTENT --}}
    <section class="py-16">
        <div class="container mx-auto px-4">
            @if($pengelolas->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($pengelolas as $pengelola)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition transform hover:-translate-y-2">
                        
                        {{-- FOTO --}}
                        <div class="bg-gradient-to-br from-blue-500 to-blue-700 p-8 flex items-center justify-center">
                            @if($pengelola->photo)
                                <img src="{{ $pengelola->photo_url }}" 
                                     alt="{{ $pengelola->name }}" 
                                     class="w-40 h-40 rounded-full object-cover border-4 border-white shadow-lg">
                            @else
                                <div class="w-40 h-40 rounded-full bg-white flex items-center justify-center">
                                    <i class="fas fa-user text-blue-700 text-6xl"></i>
                                </div>
                            @endif
                        </div>

                        {{-- INFO --}}
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $pengelola->name }}</h3>
                            <p class="text-blue-600 font-semibold mb-4">{{ $pengelola->position }}</p>
                            
                            @if($pengelola->description)
                                <p class="text-gray-600 text-sm leading-relaxed">{{ $pengelola->description }}</p>
                            @endif
                        </div>

                    </div>
                    @endforeach
                </div>
            @else
                {{-- NO DATA --}}
                <div class="max-w-2xl mx-auto text-center">
                    <div class="bg-white rounded-xl shadow-lg p-12">
                        <i class="fas fa-users text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Data</h3>
                        <p class="text-gray-600">Data struktur pengelola belum tersedia.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection