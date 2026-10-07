@extends('layouts.app')

@section('title', 'Tata Tertib')

@section('content')
<section class="py-12 lg:py-16">
    <div class="container mx-auto px-4">

        {{-- HEADER --}}
        <div class="reveal max-w-2xl mx-auto text-center mb-12">
            <p class="text-sky2-600 font-semibold tracking-[0.25em] uppercase text-xs mb-3">Tentang Kami</p>
            <h1 class="font-display text-3xl md:text-4xl font-semibold text-navy-900 mb-4">Tata Tertib Perpustakaan</h1>
            <p class="text-navy-600/70 leading-relaxed">Aturan yang menjaga kenyamanan bersama di Savansa Library.</p>
        </div>

        <div class="max-w-4xl mx-auto">
            @if($tataTertib)
                {{-- TITLE & DESCRIPTION --}}
                <div class="reveal bg-white rounded-2xl border border-cream-200 shadow-lg shadow-navy-900/5 p-8 lg:p-10 mb-8">
                    <h2 class="font-display text-2xl md:text-3xl font-semibold text-navy-900 mb-4">{{ $tataTertib->title }}</h2>
                    @if($tataTertib->description)
                        <p class="text-navy-900/75 leading-relaxed">{{ $tataTertib->description }}</p>
                    @endif
                </div>

                {{-- PDF VIEWER --}}
                <div class="reveal bg-white rounded-2xl border border-cream-200 shadow-lg shadow-navy-900/5 p-8 lg:p-10">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                        <h3 class="font-display text-xl font-semibold text-navy-900">
                            <i class="ph ph-file-pdf text-sky2-600 mr-2"></i>Dokumen Tata Tertib
                        </h3>
                        <a href="{{ $tataTertib->pdf_url }}" target="_blank" rel="noopener"
                           class="inline-flex items-center justify-center bg-navy-900 text-white px-6 py-2.5 rounded-xl font-semibold hover:bg-navy-700 transition">
                            <i class="ph ph-download-simple mr-2 text-sky2-400"></i>Download PDF
                        </a>
                    </div>

                    {{-- EMBED PDF --}}
                    <div class="border border-cream-200 rounded-xl overflow-hidden" style="height: 800px;">
                        <iframe src="{{ $tataTertib->pdf_url }}"
                                width="100%"
                                height="100%"
                                style="border: none;" title="Dokumen Tata Tertib">
                            <p>Browser Anda tidak mendukung PDF viewer.
                               <a href="{{ $tataTertib->pdf_url }}" class="text-sky2-600 underline">Download PDF</a>
                            </p>
                        </iframe>
                    </div>
                </div>
            @else
                {{-- NO DATA --}}
                <div class="reveal max-w-md mx-auto text-center bg-white border border-cream-200 rounded-2xl p-12">
                    <div class="w-16 h-16 rounded-2xl bg-sky2-50 text-sky2-600 flex items-center justify-center text-2xl mx-auto mb-5">
                        <i class="ph ph-clipboard-text"></i>
                    </div>
                    <h3 class="font-display text-xl font-semibold text-navy-900 mb-2">Belum Ada Data</h3>
                    <p class="text-navy-600/60 text-sm">Dokumen Tata Tertib belum tersedia.</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
