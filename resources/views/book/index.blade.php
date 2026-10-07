@extends('layouts.app')

@section('title', 'Katalog Buku')

@section('content')
<section class="py-12 lg:py-16">
    <div class="container mx-auto px-4">

        {{-- HEADER --}}
        <div class="reveal flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-10">
            <div>
                <p class="text-sky2-600 font-semibold tracking-[0.25em] uppercase text-xs mb-3">Koleksi</p>
                <h1 class="font-display text-3xl md:text-4xl font-semibold text-navy-900">Katalog Buku</h1>
                <p class="text-navy-600/70 mt-2">Temukan buku dari koleksi perpustakaan kami.</p>
            </div>

            {{-- TOGGLE VIEW --}}
            <div class="flex gap-2">
                <a href="?view=grid" class="px-5 py-2 rounded-full font-semibold text-sm transition border-2 {{ $view=='grid' ? 'bg-navy-900 text-sky2-400 border-navy-900' : 'bg-transparent text-navy-600 border-cream-200 hover:border-sky2-400' }}">
                    <i class="ph ph-squares-four mr-1.5"></i>Grid
                </a>
                <a href="?view=list" class="px-5 py-2 rounded-full font-semibold text-sm transition border-2 {{ $view=='list' ? 'bg-navy-900 text-sky2-400 border-navy-900' : 'bg-transparent text-navy-600 border-cream-200 hover:border-sky2-400' }}">
                    <i class="ph ph-list-bullets mr-1.5"></i>List
                </a>
            </div>
        </div>

        {{-- FILTER + SEARCH --}}
        <form method="GET" class="reveal flex flex-col sm:flex-row gap-3 mb-10 bg-white border border-cream-200 rounded-2xl p-4 shadow-sm">
            <input type="hidden" name="view" value="{{ $view }}">
            <div class="relative flex-1">
                <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-navy-200"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari judul buku..."
                    class="w-full border border-cream-200 rounded-xl pl-11 pr-4 py-2.5 bg-cream-50/50 focus:bg-white focus:border-sky2-400 focus:ring-2 focus:ring-sky2-100 outline-none transition">
            </div>

            <select name="kategori" class="border border-cream-200 rounded-xl px-4 py-2.5 bg-cream-50/50 focus:bg-white focus:border-sky2-400 focus:ring-2 focus:ring-sky2-100 outline-none transition text-navy-900">
                <option value="">Semua Kategori</option>
                @foreach ($kategoriList as $kat)
                    <option value="{{ $kat }}"
                        {{ request('kategori') == $kat ? 'selected' : '' }}>
                        {{ $kat }}
                    </option>
                @endforeach
            </select>

            <button class="bg-navy-900 text-white px-6 py-2.5 rounded-xl font-semibold hover:bg-navy-700 transition">
                Cari
            </button>
        </form>

        {{-- GRID VIEW --}}
        @if ($view == 'grid')
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-5">
                @foreach ($buku as $item)
                    <a href="{{ route('buku.show', $item->id) }}"
                        class="group bg-white border border-cream-200 rounded-2xl overflow-hidden hover:border-sky2-400/60 hover:shadow-xl hover:shadow-navy-900/10 hover:-translate-y-1 transition duration-300">

                        <div class="book-cover-9-16 !pb-[130%] bg-cream-100">
                            @if($item->cover)
                                <img src="{{ Storage::url($item->cover) }}" alt="Cover {{ $item->judul }}" loading="lazy"
                                     class="group-hover:scale-105 transition duration-500">
                            @else
                                <div class="bg-gradient-to-br from-navy-700 to-navy-900 flex items-center justify-center">
                                    <i class="ph ph-book text-sky2-400/60 text-5xl"></i>
                                </div>
                            @endif
                        </div>

                        <div class="p-4">
                            <h3 class="text-sm font-bold text-navy-900 line-clamp-2 mb-1 leading-snug group-hover:text-sky2-700 transition">{{ $item->judul }}</h3>
                            <p class="text-xs text-navy-600/60 mb-2.5">{{ $item->kategori }}</p>
                            @if($item->nomorrak)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-sky2-50 border border-sky2-100 text-sky2-700 text-[11px] font-semibold rounded-full">
                                    <i class="ph ph-map-pin text-[9px]"></i>Rak {{ $item->nomorrak }}
                                </span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- LIST VIEW --}}
        @if ($view == 'list')
            <div class="bg-white border border-cream-200 rounded-2xl divide-y divide-cream-200 overflow-hidden shadow-sm">
                @foreach ($buku as $item)
                    <a href="{{ route('buku.show', $item->id) }}"
                       class="flex items-center gap-5 p-4 hover:bg-sky2-50/50 transition">

                        @if($item->cover)
                            <img src="{{ Storage::url($item->cover) }}" alt="Cover {{ $item->judul }}" loading="lazy"
                                class="w-14 h-20 object-cover rounded-lg shadow-md">
                        @else
                            <div class="w-14 h-20 rounded-lg bg-navy-900 flex items-center justify-center shadow-md">
                                <i class="ph ph-book text-sky2-400/60"></i>
                            </div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-navy-900 truncate">{{ $item->judul }}</h3>
                            <p class="text-sm text-navy-600/60">{{ $item->kategori }}</p>
                        </div>

                        @if($item->nomorrak)
                            <span class="hidden sm:inline-flex items-center gap-1 px-2.5 py-1 bg-sky2-50 border border-sky2-100 text-sky2-700 text-xs font-semibold rounded-full">
                                <i class="ph ph-map-pin text-[10px]"></i>Rak {{ $item->nomorrak }}
                            </span>
                        @endif
                        <i class="ph ph-caret-right text-navy-200"></i>
                    </a>
                @endforeach
            </div>
        @endif

        <div class="mt-10">
            {{ $buku->appends(request()->query())->links() }}
        </div>

    </div>
</section>
@endsection
