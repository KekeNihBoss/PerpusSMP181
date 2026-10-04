@extends('layouts.app')

@section('content')
<section class="py-16 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        
        {{-- HEADER --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Event & Berita</h1>
            <p class="text-xl text-gray-600">Informasi terbaru dari Savansa Library</p>
        </div>

        {{-- FILTER KATEGORI --}}
        <div class="flex flex-wrap justify-center gap-3 mb-12">
            <a href="{{ route('blog.index') }}" 
               class="px-6 py-2 rounded-full font-semibold transition {{ !request('category') ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                Semua
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('blog.index', ['category' => $cat]) }}" 
                   class="px-6 py-2 rounded-full font-semibold transition {{ request('category') === $cat ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        {{-- BLOG GRID --}}
        @if($events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($events as $event)
                <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                    
                    {{-- THUMBNAIL --}}
                    <a href="{{ route('blog.show', $event->slug) }}" class="block relative overflow-hidden h-48">
                        @if($event->image)
                            <img src="{{ $event->image_url }}" 
                                 alt="{{ $event->title }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-r from-blue-500 to-blue-700 flex items-center justify-center">
                                <i class="fas fa-image text-white text-5xl"></i>
                            </div>
                        @endif
                        
                        {{-- BADGE KATEGORI --}}
                        <div class="absolute top-4 left-4">
                            <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
                                {{ $event->category }}
                            </span>
                        </div>
                    </a>

                    {{-- CONTENT --}}
                    <div class="p-6">
                        {{-- META --}}
                        <div class="flex items-center text-gray-500 text-sm mb-3 flex-wrap gap-2">
                            <div class="flex items-center">
                                <i class="far fa-calendar mr-1"></i>
                                {{ $event->event_date->format('d M Y') }}
                            </div>
                            @if($event->author)
                                <span>•</span>
                                <div class="flex items-center">
                                    <i class="far fa-user mr-1"></i>
                                    {{ $event->author }}
                                </div>
                            @endif
                            <span>•</span>
                            <div class="flex items-center">
                                <i class="far fa-eye mr-1"></i>
                                {{ $event->views }} views
                            </div>
                        </div>

                        {{-- TITLE --}}
                        <a href="{{ route('blog.show', $event->slug) }}">
                            <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-blue-600 transition">
                                {{ $event->title }}
                            </h3>
                        </a>
                        
                        {{-- EXCERPT --}}
                        <p class="text-gray-600 text-sm line-clamp-3 mb-4">{{ $event->description }}</p>
                        
                        {{-- READ MORE --}}
                        <a href="{{ route('blog.show', $event->slug) }}" 
                           class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold text-sm transition-all">
                            Baca Selengkapnya 
                            <i class="fas fa-arrow-right ml-2 group-hover:ml-3 transition-all"></i>
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
            <div class="text-center py-16">
                <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Konten</h3>
                <p class="text-gray-600">{{ request('category') ? 'Tidak ada konten di kategori ini' : 'Belum ada event atau berita' }}</p>
            </div>
        @endif

    </div>
</section>
@endsection