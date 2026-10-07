@extends('layouts.app')

@section('title', $event->title)

@section('content')
<article class="py-12 lg:py-16">
    <div class="container mx-auto px-4">

        {{-- BREADCRUMB --}}
        <nav class="reveal mb-8">
            <ol class="flex items-center space-x-2 text-sm text-navy-600/60">
                <li><a href="{{ route('home') }}" class="hover:text-sky2-600 transition">Beranda</a></li>
                <li><i class="ph ph-caret-right text-[10px]"></i></li>
                <li><a href="{{ route('blog.index') }}" class="hover:text-sky2-600 transition">Event &amp; Berita</a></li>
                <li><i class="ph ph-caret-right text-[10px]"></i></li>
                <li class="text-navy-900 font-semibold truncate max-w-[200px] md:max-w-md">{{ $event->title }}</li>
            </ol>
        </nav>

        <div class="max-w-4xl mx-auto">

            {{-- HEADER --}}
            <header class="reveal mb-10">
                <div class="mb-5">
                    <span class="bg-sky2-50 border border-sky2-100 text-sky2-700 px-4 py-1.5 rounded-full text-sm font-semibold">
                        {{ $event->category }}
                    </span>
                </div>

                <h1 class="font-display text-3xl md:text-5xl font-semibold text-navy-900 mb-6 leading-tight">
                    {{ $event->title }}
                </h1>

                <div class="flex items-center flex-wrap gap-x-5 gap-y-2 text-sm text-navy-600/60 pb-8 border-b border-cream-200">
                    <span><i class="ph ph-calendar-blank mr-2 text-sky2-600"></i>{{ $event->event_date->format('d F Y') }}</span>
                    @if($event->author)
                        <span><i class="ph ph-user mr-2 text-sky2-600"></i>{{ $event->author }}</span>
                    @endif
                    <span><i class="ph ph-eye mr-2 text-sky2-600"></i>{{ $event->views }} views</span>
                    <span><i class="ph ph-clock mr-2 text-sky2-600"></i>{{ $event->event_date->diffForHumans() }}</span>
                </div>
            </header>

            {{-- FEATURED IMAGE --}}
            @if($event->image)
                <figure class="reveal mb-10 rounded-2xl overflow-hidden shadow-xl shadow-navy-900/10">
                    <img src="{{ $event->image_url }}"
                        alt="{{ $event->title }}"
                        class="w-full max-h-[440px] object-cover">
                </figure>
            @endif

            {{-- CONTENT + MODAL WRAPPER --}}
            <div class="reveal max-w-none mb-12 content-body text-navy-900/85 leading-relaxed space-y-4">
                {!! nl2br($event->content) !!}
            </div>

            {{-- MODAL GAMBAR --}}
            <div id="imageModal"
                 class="hidden fixed inset-0 bg-navy-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                <img id="modalImage" class="max-w-[90%] max-h-[90%] rounded-xl shadow-2xl">
            </div>

            {{-- SHARE BUTTONS --}}
            <div class="reveal border-y border-cream-200 py-8 mb-14">
                <p class="text-navy-600/60 font-semibold mb-4 text-sm uppercase tracking-wider">Bagikan artikel ini</p>
                <div class="flex flex-wrap gap-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $event->slug)) }}"
                       target="_blank" rel="noopener"
                       class="bg-navy-900 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-navy-700 transition">
                        <i class="ph ph-facebook-logo mr-2 text-sky2-400"></i>Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $event->slug)) }}&text={{ urlencode($event->title) }}"
                       target="_blank" rel="noopener"
                       class="bg-navy-900 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-navy-700 transition">
                        <i class="ph ph-twitter-logo mr-2 text-sky2-400"></i>Twitter
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($event->title . ' - ' . route('blog.show', $event->slug)) }}"
                       target="_blank" rel="noopener"
                       class="bg-navy-900 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-navy-700 transition">
                        <i class="ph ph-whatsapp-logo mr-2 text-sky2-400"></i>WhatsApp
                    </a>
                </div>
            </div>

            {{-- RELATED POSTS --}}
            @if($relatedEvents->count() > 0)
                <div class="reveal mb-14">
                    <h2 class="font-display text-2xl md:text-3xl font-semibold text-navy-900 mb-8">Baca Juga</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($relatedEvents as $related)
                            <article class="group bg-white rounded-2xl overflow-hidden border border-cream-200 hover:border-sky2-400/60 hover:shadow-xl hover:shadow-navy-900/10 transition duration-300">
                                <a href="{{ route('blog.show', $related->slug) }}" class="block">
                                    <div class="relative overflow-hidden h-40">
                                        @if($related->image)
                                            <img src="{{ $related->image_url }}"
                                                 alt="{{ $related->title }}" loading="lazy"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                        @else
                                            <div class="w-full h-full bg-navy-900 flex items-center justify-center">
                                                <i class="ph ph-image text-sky2-400/50 text-3xl"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="p-5">
                                        <p class="text-xs font-semibold text-sky2-700 mb-2">
                                            {{ $related->event_date->format('d M Y') }}
                                        </p>
                                        <h3 class="font-display font-semibold text-navy-900 line-clamp-2 leading-snug group-hover:text-sky2-700 transition">
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
            <div class="text-center">
                <a href="{{ route('blog.index') }}"
                   class="inline-flex items-center gap-2 bg-white border-2 border-cream-200 hover:border-sky2-400 text-navy-900 px-8 py-3 rounded-xl font-semibold transition">
                    <i class="ph ph-arrow-left"></i>Kembali ke Event &amp; Berita
                </a>
            </div>

        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const body = document.querySelector('.content-body');
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');

        if (!body || !modal) return;

        body.querySelectorAll('img').forEach(img => {
            img.classList.add('rounded-xl', 'shadow-md', 'mx-auto', 'my-6', 'block', 'cursor-pointer');
            img.style.maxWidth = "400px";
            img.style.width = "100%";
            img.style.height = "auto";

            img.addEventListener('click', function (e) {
                e.preventDefault();
                modalImg.src = this.src;
                modal.classList.remove('hidden');
            });
        });

        modal.addEventListener('click', function () {
            modal.classList.add('hidden');
            modalImg.src = '';
        });
    });
</script>
@endpush
