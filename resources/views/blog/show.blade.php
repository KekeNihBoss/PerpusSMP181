@extends('layouts.app')

@section('content')
<article class="py-16 bg-white">
    <div class="container mx-auto px-4">
        
        {{-- BREADCRUMB --}}
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="{{ route('blog.index') }}" class="hover:text-blue-600">Blog</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-gray-800 font-semibold truncate">{{ $event->title }}</li>
            </ol>
        </nav>

        <div class="max-w-4xl mx-auto">
            
            {{-- HEADER --}}
            <header class="mb-8">
                {{-- KATEGORI --}}
                <div class="mb-4">
                    <span class="bg-blue-600 text-white px-4 py-1 rounded-full text-sm font-semibold">
                        {{ $event->category }}
                    </span>
                </div>

                {{-- TITLE --}}
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6 leading-tight">
                    {{ $event->title }}
                </h1>

                {{-- META INFO --}}
                <div class="flex items-center flex-wrap gap-4 text-gray-600 pb-6 border-b">
                    <div class="flex items-center">
                        <i class="far fa-calendar mr-2"></i>
                        {{ $event->event_date->format('d F Y') }}
                    </div>
                    @if($event->author)
                        <span>•</span>
                        <div class="flex items-center">
                            <i class="far fa-user mr-2"></i>
                            {{ $event->author }}
                        </div>
                    @endif
                    <span>•</span>
                    <div class="flex items-center">
                        <i class="far fa-eye mr-2"></i>
                        {{ $event->views }} views
                    </div>
                    <span>•</span>
                    <div class="flex items-center text-gray-500">
                        <i class="far fa-clock mr-2"></i>
                        {{ $event->event_date->diffForHumans() }}
                    </div>
                </div>
            </header>

            {{-- FEATURED IMAGE --}}
            @if($event->image)
                <figure class="mb-8 rounded-xl overflow-hidden shadow-xl">
                    <img src="{{ $event->image_url }}" 
                        class="w-full max-h-[400px] object-cover rounded-xl shadow-xl">
                </figure>
            @endif

{{-- CONTENT + MODAL WRAPPER --}}
<div class="prose prose-lg max-w-none mb-12 content-body">
    {!! nl2br($event->content) !!}
</div>

{{-- MODAL GAMBAR --}}
<div id="imageModal" 
     class="hidden fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4">
    <img id="modalImage" class="max-w-[90%] max-h-[90%] rounded-xl shadow-2xl">
</div>



            {{-- SHARE BUTTONS --}}
            <div class="border-t border-b py-6 mb-12">
                <p class="text-gray-600 font-semibold mb-4">Bagikan artikel ini:</p>
                <div class="flex gap-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $event->slug)) }}" 
                       target="_blank"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                        <i class="fab fa-facebook-f mr-2"></i>Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $event->slug)) }}&text={{ urlencode($event->title) }}" 
                       target="_blank"
                       class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg transition">
                        <i class="fab fa-twitter mr-2"></i>Twitter
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($event->title . ' - ' . route('blog.show', $event->slug)) }}" 
                       target="_blank"
                       class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition">
                        <i class="fab fa-whatsapp mr-2"></i>WhatsApp
                    </a>
                </div>
            </div>

            {{-- RELATED POSTS --}}
            @if($relatedEvents->count() > 0)
                <div class="mt-16">
                    <h2 class="text-3xl font-bold text-gray-800 mb-8">Baca Juga</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($relatedEvents as $related)
                            <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition group">
                                <a href="{{ route('blog.show', $related->slug) }}" class="block">
                                    <div class="relative overflow-hidden h-40">
                                        @if($related->image)
                                            <img src="{{ $related->image_url }}" 
                                                 alt="{{ $related->title }}"
                                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-r from-blue-500 to-blue-700 flex items-center justify-center">
                                                <i class="fas fa-image text-white text-3xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="p-4">
                                        <p class="text-xs text-gray-500 mb-2">
                                            {{ $related->event_date->format('d M Y') }}
                                        </p>
                                        <h3 class="font-bold text-gray-800 line-clamp-2 group-hover:text-blue-600 transition">
                                            {{ $related->title }}
                                        </h3>
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- BACK BUTTON --}}
            <div class="text-center mt-12">
                <a href="{{ route('blog.index') }}" 
                   class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-8 py-3 rounded-lg font-semibold transition">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Blog
                </a>
            </div>

        </div>
    </div>
</article>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const body = document.querySelector('.content-body');
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');

        if (!body) return;

        body.querySelectorAll('img').forEach(img => {
            
            // --- STYLE GAMBAR DALAM KONTEN ---
            img.classList.add(
                'rounded-lg',
                'shadow-md',
                'mx-auto',
                'my-6',
                'block',
                'cursor-pointer'
            );

            // kecilin gambarnya
            img.style.maxWidth = "400px";   // ❗ atur maksimal lebar
            img.style.width = "100%";       // responsif
            img.style.height = "auto";
            
            // --- KLIK UNTUK BUKA MODAL ---
            img.addEventListener('click', function (e) {
                e.preventDefault();
                modalImg.src = this.src;
                modal.classList.remove('hidden');
            });
        });

        // Tutup modal jika klik background
        modal.addEventListener('click', function () {
            modal.classList.add('hidden');
            modalImg.src = '';
        });
    });
</script>

@endsection