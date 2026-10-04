@extends('layouts.app')

@section('title', 'Event & Berita')

@section('content')
<section class="py-12 lg:py-16 min-h-screen">
    <div class="container mx-auto px-4">

        {{-- HEADER --}}
        <div class="reveal max-w-2xl mx-auto text-center mb-10">
            <p class="text-sky2-600 font-semibold tracking-[0.25em] uppercase text-xs mb-3">Kegiatan</p>
            <h1 class="font-display text-3xl md:text-4xl font-semibold text-navy-900 mb-4">Event &amp; Berita</h1>
            <p class="text-navy-600/70 leading-relaxed">Informasi terbaru dari Savansa Library.</p>
        </div>

        {{-- FILTER KATEGORI --}}
        <div class="reveal flex flex-wrap justify-center gap-2.5 mb-12">
            <a href="{{ route('blog.index') }}"
               class="px-5 py-2 rounded-full font-semibold text-sm transition border-2 {{ !request('category') ? 'bg-navy-900 text-sky2-400 border-navy-900' : 'bg-white text-navy-600 border-cream-200 hover:border-sky2-400' }}">
                Semua
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('blog.index', ['category' => $cat]) }}"
                   class="px-5 py-2 rounded-full font-semibold text-sm transition border-2 {{ request('category') === $cat ? 'bg-navy-900 text-sky2-400 border-navy-900' : 'bg-white text-navy-600 border-cream-200 hover:border-sky2-400' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        {{-- BLOG GRID --}}
        @if($events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($events as $event)
                <article class="reveal group bg-white rounded-2xl overflow-hidden border border-cream-200 hover:border-sky2-400/60 hover:shadow-2xl hover:shadow-navy-900/10 transition duration-300">

                    {{-- THUMBNAIL --}}
                    <a href="{{ route('blog.show', $event->slug) }}" class="block relative overflow-hidden h-52">
                        @if($event->image)
                            <img src="{{ $event->image_url }}"
                                 alt="{{ $event->title }}" loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full bg-navy-900 flex items-center justify-center">
                                <i class="fas fa-image text-sky2-400/50 text-5xl"></i>
                            </div>
                        @endif

                        {{-- BADGE KATEGORI --}}
                        <div class="absolute top-4 left-4">
                            <span class="bg-navy-900/90 backdrop-blur text-sky2-400 px-3 py-1.5 rounded-full text-xs font-bold border border-white/10">
                                {{ $event->category }}
                            </span>
                        </div>
                    </a>

                    {{-- CONTENT --}}
                    <div class="p-6">
                        {{-- META --}}
                        <div class="flex items-center flex-wrap text-navy-600/50 text-xs font-medium mb-3 gap-x-3 gap-y-1">
                            <span><i class="far fa-calendar mr-1.5 text-sky2-600"></i>{{ $event->event_date->format('d M Y') }}</span>
                            @if($event->author)
                                <span><i class="far fa-user mr-1.5 text-sky2-600"></i>{{ $event->author }}</span>
                            @endif
                            <span><i class="far fa-eye mr-1.5 text-sky2-600"></i>{{ $event->views }} views</span>
                        </div>

                        {{-- TITLE --}}
                        <a href="{{ route('blog.show', $event->slug) }}">
                            <h3 class="font-display text-xl font-semibold text-navy-900 mb-2.5 line-clamp-2 group-hover:text-sky2-700 transition leading-snug">
                                {{ $event->title }}
                            </h3>
                        </a>

                        {{-- EXCERPT --}}
                        <p class="text-navy-600/70 text-sm line-clamp-3 mb-5 leading-relaxed">{{ $event->description }}</p>

                        {{-- READ MORE --}}
                        <a href="{{ route('blog.show', $event->slug) }}"
                           class="inline-flex items-center gap-2 text-sm font-bold text-navy-900 hover:text-sky2-600 transition">
                            Baca selengkapnya
                            <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>

                </article>
                @endforeach
            </div>

            {{-- PAGINATION --}}
            <div class="flex justify-center">
                {{ $events->links() }}
            </div>
        @else
            {{-- EMPTY STATE --}}
            <div class="reveal max-w-md mx-auto text-center bg-white border border-cream-200 rounded-2xl p-12">
                <div class="w-16 h-16 rounded-2xl bg-sky2-50 text-sky2-600 flex items-center justify-center text-2xl mx-auto mb-5">
                    <i class="fas fa-inbox"></i>
                </div>
                <h3 class="font-display text-xl font-semibold text-navy-900 mb-2">Belum Ada Konten</h3>
                <p class="text-navy-600/60 text-sm">{{ request('category') ? 'Tidak ada konten di kategori ini.' : 'Belum ada event atau berita.' }}</p>
            </div>
        @endif

    </div>
</section>
@endsection
