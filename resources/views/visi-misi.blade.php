@extends('layouts.app')
@section('content')

    {{-- HERO SECTION --}}
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20 pt-24">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Visi & Misi</h1>
            <p class="text-xl text-blue-100">SMP Negeri 181 Jakarta</p>
        </div>
    </section>

    {{-- CONTENT --}}
    <section class="py-16">
        <div class="container mx-auto px-4">
            @if($visiMisi)
                <div class="max-w-4xl mx-auto">
                    
                    {{-- TITLE & DESCRIPTION --}}
                    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">{{ $visiMisi->title }}</h2>
                        @if($visiMisi->description)
                            <p class="text-gray-600 leading-relaxed">{{ $visiMisi->description }}</p>
                        @endif
                    </div>

                    {{-- PDF VIEWER --}}
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-800">
                                <i class="fas fa-file-pdf text-red-600 mr-2"></i>
                                Dokumen Visi Misi
                            </h3>
                            <a href="{{ $visiMisi->pdf_url }}" target="_blank" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                                <i class="fas fa-download mr-2"></i>Download PDF
                            </a>
                        </div>

                        {{-- EMBED PDF --}}
                        <div class="border-2 border-gray-200 rounded-lg overflow-hidden" style="height: 800px;">
                            <iframe src="{{ $visiMisi->pdf_url }}" 
                                    width="100%" 
                                    height="100%" 
                                    style="border: none;">
                                <p>Browser Anda tidak mendukung PDF viewer. 
                                   <a href="{{ $visiMisi->pdf_url }}" class="text-blue-600 underline">Download PDF</a>
                                </p>
                            </iframe>
                        </div>
                    </div>

                </div>
            @else
                {{-- NO DATA --}}
                <div class="max-w-2xl mx-auto text-center">
                    <div class="bg-white rounded-xl shadow-lg p-12">
                        <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Data</h3>
                        <p class="text-gray-600">Dokumen Visi Misi belum tersedia.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection